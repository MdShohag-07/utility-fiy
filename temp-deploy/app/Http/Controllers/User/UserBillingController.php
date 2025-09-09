<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Statement;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Ensure Storage is imported
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use PDF;
use Carbon\Carbon;
use Picqer\Barcode\BarcodeGeneratorPNG; // Barcode generator class

class UserBillingController extends Controller
{
    public function index(): View
    {
        $user = Auth::user()->loadMissing('statements');
        $currentBalance = 0.00;
        $nextDueDate = null;
        $paymentStatusMessage = 'No upcoming payments due.';

        $upcomingStatement = $user->statements()
                                ->where('status', '!=', 'paid')
                                ->where('due_date', '>=', today())
                                ->orderBy('due_date', 'asc')
                                ->first();
        if ($upcomingStatement) {
            $currentBalance = $upcomingStatement->total_amount;
            $nextDueDate = $upcomingStatement->due_date;
            $paymentStatusMessage = 'Payment Due: ' . Carbon::parse($nextDueDate)->format('M d, Y');
        } else { /* ... (existing logic for overdue/up-to-date) ... */
            $latestOverallStatement = $user->statements()->orderBy('statement_date', 'desc')->first();
            if ($latestOverallStatement) {
                if ($latestOverallStatement->status !== 'paid') {
                    $currentBalance = $latestOverallStatement->total_amount;
                    $paymentStatusMessage = 'Payment Overdue: ' . Carbon::parse($latestOverallStatement->due_date)->format('M d, Y');
                } else {
                    $paymentStatusMessage = 'Account is up to date.';
                }
            }
        }
        $billingData = [
            'balance' => $currentBalance, 'paymentStatus' => $paymentStatusMessage,
            'accountIdentifier' => $user->service_type ?? 'N/A', 'accountNumber' => $user->account_number ?? 'N/A',
        ];
        $adData = [ /* ... ad data ... */ ];
        return view('user.billing.index', compact('billingData', 'adData'));
    }

    public function statements(): View
    {
        $user = Auth::user();
        $currentStatement = Statement::where('user_id', $user->id)
                                     ->orderBy('statement_date', 'desc')->orderBy('id', 'desc')->first();
        $pastStatementsQuery = Statement::where('user_id', $user->id)
                                        ->orderBy('statement_date', 'desc')->orderBy('id', 'desc');
        if ($currentStatement) { $pastStatementsQuery->where('id', '!=', $currentStatement->id); }
        $pastStatements = $pastStatementsQuery->paginate(10);
        return view('user.billing.statements', compact('currentStatement', 'pastStatements'));
    }

    public function showStatementDetails(Statement $statement): View
    {
        if (Auth::id() !== $statement->user_id) { abort(403); }
        $statement->load(['user', 'items']);
        return view('user.billing.statement_show_details', compact('statement'));
    }

    public function downloadStatementPdf(Statement $statement) // Returns \Symfony\Component\HttpFoundation\Response
    {
        if (Auth::id() !== $statement->user_id) {
            Log::warning("[UserBillingController] Unauthorized PDF attempt: StatementID {$statement->id}, UserID " . Auth::id());
            abort(403, 'Unauthorized access to statement.');
        }
        $statement->load(['user', 'items']);
        if (!$statement->user) {
            Log::error("[UserBillingController] User missing for statement ID: {$statement->id}");
            return redirect()->back()->with('error', 'User data missing for PDF.');
        }

        $companySettingKeys = [ /* ... same keys as admin controller ... */
            'site_name', 'site_logo',
            'pdf_payment_recipient_name', 'pdf_payment_address_line1', 'pdf_payment_address_line2',
            'pdf_customer_service_phone', 'security_code_placeholder', 'autopay_url',
            'important_news_text', 'scam_warning_text', 'unlimited_calling_text',
            'voice_contact_number', 'customer_service_main_phone',
            'do_not_send_payment_address_line1', 'do_not_send_payment_address_line2',
        ];
        $companySettings = Setting::whereIn('key', $companySettingKeys)->pluck('value', 'key')->all();

        $siteLogoPath = $companySettings['site_logo'] ?? null;
        $siteLogoUrlForPdf = null; // Changed variable name for clarity
        if ($siteLogoPath && Storage::disk('public')->exists($siteLogoPath)) {
            try {
                $imageContent = Storage::disk('public')->get($siteLogoPath);
                $imageExtension = strtolower(pathinfo(storage_path('app/public/' . $siteLogoPath), PATHINFO_EXTENSION));
                $imageType = in_array($imageExtension, ['jpeg', 'jpg', 'png', 'gif', 'svg', 'webp']) ? $imageExtension : 'png';
                if ($imageType === 'svg') $imageType = 'svg+xml';
                $siteLogoUrlForPdf = 'data:image/' . $imageType . ';base64,' . base64_encode($imageContent);
            } catch (\Exception $e) { Log::error("[UserBillingController] Logo encode error: " . $e->getMessage()); }
        } elseif($siteLogoPath) { Log::warning("[UserBillingController] Site logo '{$siteLogoPath}' not on disk."); }

        $barcodeImageBase64 = null;
        $barcodeDataStringForDisplay = null;
        if ($statement->user->account_number) {
            $barcodeDataString = (string)($statement->user->account_number);
            $barcodeDataString .= (string)($statement->statement_number ?? $statement->id);
            $amountForBarcode = str_pad(str_replace('.', '', number_format($statement->total_amount, 2, '.', '')), 10, '0', STR_PAD_LEFT);
            $barcodeDataString .= $amountForBarcode;
            $barcodeDataStringForDisplay = $barcodeDataString; // Or format as needed for text display

            try {
                $generator = new BarcodeGeneratorPNG(); // Correctly uses imported class
                $barcodeImageBase64 = base64_encode($generator->getBarcode($barcodeDataString, $generator::TYPE_CODE_128, 2, 40));
            } catch (\Exception $e) { Log::error("[UserBillingController] Barcode gen failed for statement {$statement->id}: " . $e->getMessage()); }
        } else { Log::warning("[UserBillingController] No account number for barcode. Stmt ID: {$statement->id}"); }

        $dataToPassToView = [
            'statement' => $statement,
            'companySettings' => $companySettings,
            'siteLogoUrl' => $siteLogoUrlForPdf,
            'barcodeImageBase64' => $barcodeImageBase64,
            'barcodeDataStringForDisplay' => $barcodeDataStringForDisplay,
        ];

        try {
            Log::info("[UserBillingController] User ID: " . Auth::id() . " generating PDF for statement ID: {$statement->id}");
            $pdf = PDF::loadView('pdfs.statement_template', $dataToPassToView); // Ensure path is 'pdfs.'
            $fileName = 'Statement-' . ($statement->statement_number ?? $statement->id) . '-' . Carbon::parse($statement->statement_date)->format('Y-m-d') . '.pdf';
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            Log::error("[UserBillingController] PDF Gen Exception for statement {$statement->id}: " . $e->getMessage());
            return redirect()->route('my-account.billing.statements')->with('error', 'Could not generate PDF. Please try later.');
        }
    }
}