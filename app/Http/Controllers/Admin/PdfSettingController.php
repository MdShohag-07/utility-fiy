<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Setting; // Your Setting model
use Illuminate\Support\Facades\Cache;
use App\Providers\AppServiceProvider; // For the shared cache key
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str; // <--- ADD THIS LINE TO IMPORT Str FACADE

class PdfSettingController extends Controller
{
    /**
     * Define all setting keys related to PDF content managed by this controller.
     */
    private array $pdfSettingKeys = [
        // Important News Section 1
        'pdf_important_news_section_title',
        'pdf_important_news_title1', 'pdf_important_news_text1', 'pdf_important_news_url1_text', 'pdf_important_news_url1',
        // Important News Section 2 (Scams)
        'pdf_important_news_title2', 'pdf_important_news_text2', 'pdf_important_news_url2_text', 'pdf_important_news_url2',
        // Unlimited Calling Section
        'pdf_unlimited_calling_title', 'pdf_unlimited_calling_text', 'pdf_unlimited_calling_phone_text',
        'pdf_unlimited_calling_phone', 'pdf_unlimited_calling_suffix',
        // Payment Stub Info
        'pdf_payment_stub_note_prefix', 'pdf_customer_service_phone', 'pdf_payment_stub_note_suffix',
        'pdf_return_address_warning_brand', 'pdf_return_address_warning_text',
        'pdf_return_address_co_name', 'pdf_return_address_line1', 'pdf_return_address_line2',
        'pdf_payment_recipient_name', 'pdf_payment_address_line1', 'pdf_payment_address_line2',
        // PDF Page 2 Keys
        'pdf_autopay_url_link', 'pdf_autopay_url_text',
        'pdf_online_billing_url_link', 'pdf_online_billing_url_text',
        'pdf_paperless_url_link', 'pdf_paperless_url_text',
        'pdf_phone_payment_number_tel', 'pdf_phone_payment_number_display',
        'pdf_store_address_line1', 'pdf_store_address_line2',
        'pdf_store_hours_display', 'pdf_store_locator_url_link', 'pdf_store_locator_url_text',
        // PDF Page 3 Keys
        'pdf_support_url_billing_link', 'pdf_support_url_billing_text', 'pdf_support_phone_main',
        'pdf_support_url_moving_link', 'pdf_support_url_moving_text', 'pdf_support_phone_moving',
        'pdf_faq_billing_cycle', 'pdf_faq_insufficient_funds', 'pdf_faq_disagree_charge', 'pdf_faq_service_interruption',
        'pdf_terms_url_link', 'pdf_terms_url_text',
        'pdf_desc_taxes_fees', 'pdf_desc_terms_conditions', 'pdf_desc_insufficient_funds',
        'pdf_legal_programming_changes', 'pdf_legal_recording_video', 'pdf_legal_spectrum_terms',
        'pdf_legal_security_center', 'pdf_legal_billing_practices', 'pdf_legal_late_fee',
        'pdf_legal_complaint_procedures', 'pdf_legal_closed_captioning',
        'pdf_closed_caption_phone', 'pdf_closed_caption_email_addr', 'pdf_closed_caption_email_text',
        'pdf_closed_caption_complaint_instructions_para1',
        'security_code_placeholder',
    ];

    /**
     * Show the form for editing PDF content settings.
     */
    public function edit(): View
    {
        $dbSettings = Setting::whereIn('key', $this->pdfSettingKeys)->pluck('value', 'key')->all();
        $settings = [];
        foreach ($this->pdfSettingKeys as $key) {
            $settings[$key] = $dbSettings[$key] ?? '';
        }
        return view('admin.settings.pdf-edit', compact('settings'));
    }

    /**
     * Update PDF content settings in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $errorBag = 'pdf_settings';
        $rules = [];
        foreach ($this->pdfSettingKeys as $key) {
            // Now Str::endsWith and Str::contains will work correctly
            if (Str::endsWith($key, '_url') || Str::endsWith($key, '_link')) { // URL fields
                $rules[$key] = 'nullable|url|max:2048';
            } elseif (Str::contains($key, '_text') || Str::contains($key, '_headline') || Str::contains($key, '_title') || Str::contains($key, '_note') || Str::contains($key, '_disclaimer') || Str::contains($key, '_suffix') || Str::contains($key, '_prefix') || Str::contains($key, '_address') || Str::contains($key, '_faq_') || Str::contains($key, '_desc_') || Str::contains($key, '_legal_') || Str::contains($key, '_instructions_')) {
                $rules[$key] = 'nullable|string|max:5000';
            } else {
                $rules[$key] = 'nullable|string|max:255';
            }
        }

        $validatedData = $request->validateWithBag($errorBag, $rules);
        Log::info("[PdfSettingController@update] Validated data:", $validatedData);

        try {
            foreach ($validatedData as $key => $value) {
                if (in_array($key, $this->pdfSettingKeys)) {
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value ?? '']
                    );
                }
            }

            Cache::forget(AppServiceProvider::SHARED_DATA_CACHE_KEY);
            Log::info('[PdfSettingController@update] Cleared cache: ' . AppServiceProvider::SHARED_DATA_CACHE_KEY);

            return redirect()->route('admin.settings.pdf.edit')
                             ->with('status_pdf_settings', 'PDF content settings updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("[PdfSettingController@update] Validation exception: ", $e->errors());
            return back()->withErrors($e->errors(), $errorBag)->withInput();
        } catch (\Exception $e) {
            Log::error("[PdfSettingController@update] Error updating PDF settings: " . $e->getMessage(), ['exception' => $e]);
            return back()->with('error_pdf_settings', 'An unexpected error occurred. Check logs.')->withInput();
        }
    }

    public function getDefaultPdfSettings(): array
    {
        $defaults = [];
        foreach ($this->pdfSettingKeys as $key) {
            $defaults[$key] = '';
        }
        $defaults['pdf_important_news_section_title'] = 'IMPORTANT NEWS';
        $defaults['pdf_unlimited_calling_title'] = 'Unlimited calling. Unlimited connections.';
        return $defaults;
    }
}