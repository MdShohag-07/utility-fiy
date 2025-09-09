<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Statement;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use PDF; // Assuming using barryvdh/laravel-dompdf facade alias
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse; // For type hinting download response

class UserDashboardController extends Controller
{
    /**
     * Display the regular user's account dashboard content page.
     */
    public function index(): View
    {
        $user = Auth::user();
        if (!$user) {
             // This should ideally be caught by 'auth' middleware
             return redirect()->route('login');
        }

        // Fetch the latest statement. This can be used by the view
        // to construct a link to 'my-account.billing.statement.downloadPdf' for the modal.
        $latestStatementForModal = $user->statements() // Using relationship
                                    ->orderBy('statement_date', 'desc')
                                    ->orderBy('id', 'desc')
                                    ->first();

        // Billing summary data for the dashboard quick view
        $billingSummary = [
            'balance' => 0.00,
            'next_due_text' => 'Your account is up to date.',
        ];

        $nextUnpaidStatement = $user->statements()
                                   ->where('status', '!=', 'paid') // Consider more specific payable statuses if needed
                                   ->orderBy('due_date', 'asc')
                                   ->where('due_date', '>=', today()->toDateString())
                                   ->first();

        if ($nextUnpaidStatement) {
            $billingSummary['balance'] = $user->statements()
                                              ->where('status', '!=', 'paid')
                                              ->sum('total_amount'); // Sum of all non-paid statement totals

            $billingSummary['next_due_text'] = 'Next payment of $' . number_format($nextUnpaidStatement->total_amount, 2) .
                                               ' due by ' . Carbon::parse($nextUnpaidStatement->due_date)->format('M d, Y') . '.';
        } else {
            $anyOverdue = $user->statements()
                                ->where('status', '!=', 'paid')
                                ->where('due_date', '<', today()->toDateString())
                                ->exists();

            if ($anyOverdue) {
                $billingSummary['balance'] = $user->statements()
                                                  ->where('status', '!=', 'paid')
                                                  ->sum('total_amount');
                $billingSummary['next_due_text'] = 'You have overdue payments.';
            } else {
                $totalUnpaidBalance = $user->statements()
                                           ->where('status', '!=', 'paid')
                                           ->sum('total_amount');
                if ($totalUnpaidBalance > 0) {
                    $billingSummary['balance'] = $totalUnpaidBalance;
                    $billingSummary['next_due_text'] = 'Please review your account balance.';
                }
            }
        }

        return view('user.dashboard', [ // This should be resources/views/user/dashboard.blade.php
            'user' => $user, // Good to pass the user object
            'latestStatement' => $latestStatementForModal, // For the modal link construction
            'billingSummary' => $billingSummary,
            'active_sidebar_item' => 'dashboard', // Or 'home' if your sidebar partial expects 'home'
            'active_mobile_nav_item' => 'dashboard', // Or 'home'
            'pageTitle' => 'My Account Dashboard'
        ]);
    }

    /**
     * Generate and stream/download the user's LATEST billing statement PDF.
     * Corresponds to the '/my-account/statement' route.
     */
    public function showStatement(Request $request): SymfonyResponse // Type hint for Response
    {
        $user = Auth::user();
        if (!$user) {
            // Should be caught by middleware, but good as a safeguard
            return redirect()->route('login')->with('error', 'Please log in to view statements.');
        }

        $latestStatement = $user->statements() // Using relationship
                            ->orderBy('statement_date', 'desc')
                            ->orderBy('id', 'desc')
                            ->with(['user', 'items']) // Eager load for PDF
                            ->first();

        if (!$latestStatement) {
            return redirect()->route('my-account.billing.statements') // Redirect to list if no latest
                             ->with('error', 'No statement is currently available to download.');
        }

        try {
            // Load company settings with proper keys
            $companySettingKeys = [
                'site_name', 'site_logo',
                'pdf_payment_recipient_name', 'pdf_payment_address_line1', 'pdf_payment_address_line2',
                'pdf_customer_service_phone', 'security_code_placeholder', 'autopay_url',
                'important_news_text', 'scam_warning_text', 'unlimited_calling_text',
                'voice_contact_number', 'customer_service_main_phone',
                'do_not_send_payment_address_line1', 'do_not_send_payment_address_line2',
            ];
            $companySettings = Setting::whereIn('key', $companySettingKeys)->pluck('value', 'key')->all();

            // CORRECTED VIEW PATH
            $pdf = PDF::loadView('pdfs.statement_template', [
                'statement' => $latestStatement,
                'companySettings' => $companySettings
            ]);

            return $pdf->download('statement-latest-' . ($user->account_number ?? $user->id) . '-' . Carbon::parse($latestStatement->statement_date)->format('Ymd') . '.pdf');
        } catch (\Exception $e) {
            Log::error("UserDashboardController::showStatement - PDF Generation Failed for user ID {$user->id}: " . $e->getMessage(), ['exception' => $e]);
            // Redirect back with an error, or show a generic error page
            return redirect()->route('my-account.index')->with('error', 'Could not generate your statement PDF at this time. Please try again later.');
        }
    }

    /**
     * View the user's LATEST billing statement PDF in browser (not download).
     * Corresponds to the '/my-account/statement/view' route.
     */
    public function viewStatement(Request $request): SymfonyResponse
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view statements.');
        }

        $latestStatement = $user->statements()
                            ->orderBy('statement_date', 'desc')
                            ->orderBy('id', 'desc')
                            ->with(['user', 'items'])
                            ->first();

        if (!$latestStatement) {
            return redirect()->route('my-account.billing.statements')
                             ->with('error', 'No statement is currently available to view.');
        }

        try {
            // Load company settings with proper keys
            $companySettingKeys = [
                'site_name', 'site_logo',
                'pdf_payment_recipient_name', 'pdf_payment_address_line1', 'pdf_payment_address_line2',
                'pdf_customer_service_phone', 'security_code_placeholder', 'autopay_url',
                'important_news_text', 'scam_warning_text', 'unlimited_calling_text',
                'voice_contact_number', 'customer_service_main_phone',
                'do_not_send_payment_address_line1', 'do_not_send_payment_address_line2',
            ];
            $companySettings = Setting::whereIn('key', $companySettingKeys)->pluck('value', 'key')->all();

            $pdf = PDF::loadView('pdfs.statement_template', [
                'statement' => $latestStatement,
                'companySettings' => $companySettings
            ]);

            return $pdf->stream('statement-latest-' . ($user->account_number ?? $user->id) . '-' . Carbon::parse($latestStatement->statement_date)->format('Ymd') . '.pdf');
        } catch (\Exception $e) {
            Log::error("UserDashboardController::viewStatement - PDF Generation Failed for user ID {$user->id}: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('my-account.index')->with('error', 'Could not generate your statement PDF at this time. Please try again later.');
        }
    }
}