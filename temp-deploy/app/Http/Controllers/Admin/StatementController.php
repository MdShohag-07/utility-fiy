<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statement;
use App\Models\StatementItem;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Providers\AppServiceProvider; // Only if you clear a shared key from here
use Carbon\Carbon;
use PDF; // Barryvdh\DomPDF\Facade\Pdf
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; // For logging admin user ID

class StatementController extends Controller
{
    public function index(): View
    {
        $statements = Statement::with('user')
                           ->orderBy('statement_date', 'desc')
                           ->orderBy('id', 'desc')
                           ->paginate(20);

        $totalStatementsCount = Statement::count();
        $usersWithStatementsCount = User::whereHas('statements')->count();
        $latestStatementDateObj = Statement::max('statement_date');
        $latestStatementDate = $latestStatementDateObj ? Carbon::parse($latestStatementDateObj)->format('M d, Y') : 'N/A';

        return view('admin.statements.index', compact(
            'statements',
            'totalStatementsCount',
            'usersWithStatementsCount',
            'latestStatementDate'
        ));
    }

    public function create(): View
    {
        $usersForSelect = User::orderBy('last_name')
                              ->orderBy('first_name')
                              ->get()
                              ->mapWithKeys(function ($user) {
                                  return [$user->id => $user->display_name];
                              });
        return view('admin.statements.create', compact('usersForSelect'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'required|exists:users,id',
            'statement_date' => 'required|date_format:Y-m-d',
            'due_date' => 'required|date_format:Y-m-d|after_or_equal:statement_date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'statement_number_prefix' => 'nullable|string|max:20',
            // Add validation for other statement fields if they are submitted from the form
            // 'previous_balance' => 'nullable|numeric',
            // 'payments_received' => 'nullable|numeric',
            // 'service_period_start' => 'nullable|date_format:Y-m-d',
            // 'service_period_end' => 'nullable|date_format:Y-m-d|after_or_equal:service_period_start',
        ],[
            'user_ids.*.exists' => 'An invalid user was selected.',
            'items.required' => 'At least one line item is required for the statement.'
        ]);

        DB::beginTransaction();
        try {
            $createdCount = 0;
            $prefix = $validated['statement_number_prefix'] ?? 'STMT-';

            foreach ($validated['user_ids'] as $userId) {
                $statementTotal = 0;
                $statementItemsData = [];
                foreach ($validated['items'] as $itemData) {
                    $itemQuantity = $itemData['quantity'] ?? 1;
                    $itemUnitPrice = $itemData['unit_price'] ?? 0;
                    $itemAmount = $itemQuantity * $itemUnitPrice;
                    $statementTotal += $itemAmount;
                    $statementItemsData[] = [
                        'description' => $itemData['description'],
                        'quantity' => $itemQuantity,
                        'unit_price' => $itemUnitPrice,
                        'amount' => $itemAmount,
                        // 'category' => $itemData['category'] ?? null, // If you add category to items
                        // 'notes' => $itemData['notes'] ?? null,      // If you add notes
                    ];
                }

                $datePart = Carbon::parse($validated['statement_date'])->format('Ymd');
                $baseNumberPart = $prefix . $datePart . '-';
                $statementNumber = $baseNumberPart . strtoupper(Str::random(4));
                $attempts = 0;
                while (Statement::where('statement_number', $statementNumber)->exists() && $attempts < 10) {
                    $statementNumber = $baseNumberPart . strtoupper(Str::random(5 + $attempts));
                    $attempts++;
                }
                if(Statement::where('statement_number', $statementNumber)->exists()){
                    $statementNumber = $baseNumberPart . strtoupper(Str::random(6)) . '-' . time();
                }

                $statement = Statement::create([
                    'user_id' => $userId,
                    'statement_number' => $statementNumber,
                    'statement_date' => $validated['statement_date'],
                    'due_date' => $validated['due_date'],
                    'total_amount' => $statementTotal,
                    'status' => 'issued',
                    // 'previous_balance' => $validated['previous_balance'] ?? 0.00,
                    // 'payments_received' => $validated['payments_received'] ?? 0.00,
                    // 'service_period_start' => $validated['service_period_start'] ?? $validated['statement_date'],
                    // 'service_period_end' => $validated['service_period_end'] ?? Carbon::parse($validated['statement_date'])->addMonth()->subDay()->format('Y-m-d'),
                ]);

                if (!empty($statementItemsData)) {
                    $statement->items()->createMany($statementItemsData);
                }
                $createdCount++;
            }

            DB::commit();
            return redirect()->route('admin.statements.index')->with('status', "{$createdCount} statement(s) created successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Statement Creation Error: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', 'Failed to create statements. Error: ' . $e->getMessage());
        }
    }

    public function show(Statement $statement): View
    {
        $statement->load(['user', 'items']);
        return view('admin.statements.show', compact('statement'));
    }

    public function destroy(Statement $statement): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $statement->delete();
            DB::commit();
            return redirect()->route('admin.statements.index')->with('status', 'Statement deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Statement Deletion Error: ' . $e->getMessage());
            return redirect()->route('admin.statements.index')->with('error', 'Failed to delete statement.');
        }
    }

    public function downloadPdf(Statement $statement) // Returns \Symfony\Component\HttpFoundation\Response
    {
        $statement->load(['user', 'items']);
        if (!$statement->user) {
            Log::warning("[Admin\StatementController] PDF Download: User not found for statement ID: {$statement->id}");
            return redirect()->back()->with('error', 'Cannot generate PDF: User data missing.');
        }

        $companySettingKeys = [
            'site_name', 'site_logo',
            'pdf_payment_recipient_name', 'pdf_payment_address_line1', 'pdf_payment_address_line2',
            'pdf_customer_service_phone', 'security_code_placeholder', 'autopay_url',
            'important_news_text', 'scam_warning_text', 'unlimited_calling_text',
            'voice_contact_number', 'customer_service_main_phone',
            'do_not_send_payment_address_line1', 'do_not_send_payment_address_line2',
        ];
        $companySettings = Setting::whereIn('key', $companySettingKeys)->pluck('value', 'key')->all();

        $siteLogoPath = $companySettings['site_logo'] ?? null;
        $siteLogoUrlForPdf = null;
        if ($siteLogoPath && Storage::disk('public')->exists($siteLogoPath)) {
            try {
                $imageContent = Storage::disk('public')->get($siteLogoPath);
                $imageExtension = strtolower(pathinfo(storage_path('app/public/' . $siteLogoPath), PATHINFO_EXTENSION));
                $imageType = in_array($imageExtension, ['jpeg', 'jpg', 'png', 'gif', 'svg', 'webp']) ? $imageExtension : 'png';
                if ($imageType === 'svg') $imageType = 'svg+xml';
                $siteLogoUrlForPdf = 'data:image/' . $imageType . ';base64,' . base64_encode($imageContent);
            } catch (\Exception $e) { Log::error("Failed to get/encode logo for PDF (Admin): " . $e->getMessage()); }
        } elseif($siteLogoPath) { Log::warning("[Admin\StatementController] Site logo '{$siteLogoPath}' not found."); }

        // Barcode Data (example, same as UserBillingController)
        $barcodeImageBase64 = null;
        $barcodeDataStringForDisplay = null;
        if ($statement->user->account_number) {
            $barcodeDataString = (string)($statement->user->account_number ?? '');
            $barcodeDataString .= (string)($statement->statement_number ?? $statement->id);
            $amountForBarcode = str_pad(str_replace('.', '', number_format($statement->total_amount, 2, '.', '')), 10, '0', STR_PAD_LEFT);
            $barcodeDataString .= $amountForBarcode;
            $barcodeDataStringForDisplay = $barcodeDataString; // Or a more formatted version for text display

            try {
                $generator = new \Picqer\Barcode\BarcodeGeneratorPNG(); // Explicitly use full namespace if not imported at top
                $barcodeImageBase64 = base64_encode($generator->getBarcode($barcodeDataString, $generator::TYPE_CODE_128, 2, 40));
            } catch (\Exception $e) { Log::error("[Admin\StatementController] Barcode generation failed: " . $e->getMessage()); }
        }

        $dataToPassToView = [
            'statement' => $statement,
            'companySettings' => $companySettings,
            'siteLogoUrl' => $siteLogoUrlForPdf,
            'barcodeImageBase64' => $barcodeImageBase64,
            'barcodeDataStringForDisplay' => $barcodeDataStringForDisplay,
        ];

        try {
            Log::info("[Admin\StatementController] Admin User ID: " . (Auth::id() ?? 'N/A') . " generating PDF for statement ID: {$statement->id}");
            $pdf = PDF::loadView('pdfs.statement_template', $dataToPassToView); // Corrected path
            $fileName = 'Statement-' . ($statement->statement_number ?? $statement->id) . '-' . Carbon::parse($statement->statement_date)->format('Ymd') . '.pdf';
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            Log::error("[Admin\StatementController] PDF Error for statement {$statement->id}: " . $e->getMessage() . " - Trace: " . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Could not generate PDF. Check logs.');
        }
    }
}