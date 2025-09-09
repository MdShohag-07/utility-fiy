@extends('layouts.admin')

@section('title', 'PDF Statement Content Settings')

@section('content')
<section class="admin-content settings-page px-4 py-4 md:px-6 md:py-6">
    <div class="dashboard-header-v3 mb-4">
        <div class="header-greeting">
            <h1 class="text-2xl md:text-3xl font-semibold text-[var(--primary-color)]">
                <i class="fas fa-file-invoice-dollar fa-fw mr-2 text-[var(--accent-color)]"></i> PDF Statement Content Settings
            </h1>
            <p class="text-gray-600 mt-1">Manage text blocks that appear in generated PDF statements, organized by page.</p>
        </div>
    </div>
    <hr class="mb-5">

    {{-- Session Status Messages --}}
    @if(session('status_pdf_settings')) <div class="alert alert-success mb-4 p-3 rounded-md text-sm">{{ session('status_pdf_settings') }}</div> @endif
    @if(session('error_pdf_settings')) <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">{{ session('error_pdf_settings') }}</div> @endif
    @if($errors->pdf_settings->any())
       <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">
           <strong class="font-semibold">Please check the form for errors:</strong>
           <ul> @foreach($errors->pdf_settings->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
       </div>
    @endif

    <form action="{{ route('admin.settings.pdf.update') }}" method="POST">
        @csrf
        @method('PATCH')

        {{-- Tab Navigation --}}
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 " id="pdfSettingsTabs">
                <li class="mr-2">
                    <button type="button" class="pdf-tab-button inline-block p-4 border-b-2 rounded-t-lg active-tab" data-tab-target="page1Content">Page 1 Content</button>
                </li>
                <li class="mr-2">
                    <button type="button" class="pdf-tab-button inline-block p-4 border-b-2 rounded-t-lg" data-tab-target="page2Content">Page 2 Content (Bill Details)</button>
                </li>
                <li class="mr-2">
                    <button type="button" class="pdf-tab-button inline-block p-4 border-b-2 rounded-t-lg" data-tab-target="page3Content">Page 3 Content (Support/FAQs)</button>
                </li>
            </ul>
        </div>

        {{-- Tab Content --}}
        <div>
            {{-- ==================== PAGE 1 CONTENT TAB ==================== --}}
            <div id="page1Content" class="pdf-tab-content space-y-6 active-content">
                <div class="widget-card">
                    <div class="widget-header"><h3 class="widget-title">Page 1: Main Statement Information</h3></div>
                    <div class="widget-content space-y-4">
                        {{-- Important News Section 1 (e.g., AutoPay) --}}
                        <h4 class="form-section-title">Important News - Block 1 (e.g., AutoPay)</h4>
                        <div><label for="pdf_important_news_title1" class="form-label">News Title 1</label><input type="text" name="pdf_important_news_title1" id="pdf_important_news_title1" class="form-control" value="{{ old('pdf_important_news_title1', $settings['pdf_important_news_title1'] ?? '') }}">@error('pdf_important_news_title1', 'pdf_settings')<span class="error-message">{{ $message }}</span>@enderror</div>
                        <div><label for="pdf_important_news_text1" class="form-label">News Text 1 (main paragraph)</label><textarea name="pdf_important_news_text1" id="pdf_important_news_text1" class="form-control" rows="3">{{ old('pdf_important_news_text1', $settings['pdf_important_news_text1'] ?? '') }}</textarea>@error('pdf_important_news_text1', 'pdf_settings')<span class="error-message">{{ $message }}</span>@enderror</div>
                        <div><label for="pdf_autopay_url_text" class="form-label">AutoPay URL Link Text (e.g., Spectrum.net/autopay)</label><input type="text" name="pdf_autopay_url_text" id="pdf_autopay_url_text" class="form-control" value="{{ old('pdf_autopay_url_text', $settings['pdf_autopay_url_text'] ?? '') }}">@error('pdf_autopay_url_text', 'pdf_settings')<span class="error-message">{{ $message }}</span>@enderror</div>
                        <div><label for="pdf_autopay_url_link" class="form-label">AutoPay URL</label><input type="url" name="pdf_autopay_url_link" id="pdf_autopay_url_link" class="form-control" value="{{ old('pdf_autopay_url_link', $settings['pdf_autopay_url_link'] ?? '') }}" placeholder="https://...">@error('pdf_autopay_url_link', 'pdf_settings')<span class="error-message">{{ $message }}</span>@enderror</div>

                        {{-- Important News Section 2 (e.g., Scams) --}}
                        <h4 class="form-section-title">Important News - Block 2 (e.g., Payment Scams)</h4>
                        <div><label for="pdf_important_news_title2" class="form-label">News Title 2</label><input type="text" name="pdf_important_news_title2" id="pdf_important_news_title2" class="form-control" value="{{ old('pdf_important_news_title2', $settings['pdf_important_news_title2'] ?? '') }}">@error('pdf_important_news_title2', 'pdf_settings')<span class="error-message">{{ $message }}</span>@enderror</div>
                        <div><label for="pdf_important_news_text2" class="form-label">News Text 2 (main paragraph)</label><textarea name="pdf_important_news_text2" id="pdf_important_news_text2" class="form-control" rows="3">{{ old('pdf_important_news_text2', $settings['pdf_important_news_text2'] ?? '') }}</textarea>@error('pdf_important_news_text2', 'pdf_settings')<span class="error-message">{{ $message }}</span>@enderror</div>
                        <div><label for="pdf_scam_security_url_text" class="form-label">Scam/Security URL Link Text (e.g., Spectrum.net/securitycenter)</label><input type="text" name="pdf_scam_security_url_text" id="pdf_scam_security_url_text" class="form-control" value="{{ old('pdf_scam_security_url_text', $settings['pdf_scam_security_url_text'] ?? '') }}">@error('pdf_scam_security_url_text', 'pdf_settings')<span class="error-message">{{ $message }}</span>@enderror</div>
                        <div><label for="pdf_scam_security_url_link" class="form-label">Scam/Security URL</label><input type="url" name="pdf_scam_security_url_link" id="pdf_scam_security_url_link" class="form-control" value="{{ old('pdf_scam_security_url_link', $settings['pdf_scam_security_url_link'] ?? '') }}" placeholder="https://...">@error('pdf_scam_security_url_link', 'pdf_settings')<span class="error-message">{{ $message }}</span>@enderror</div>
                        <div><label for="pdf_scam_warning_suffix" class="form-label">Scam Warning Suffix (text after URL)</label><input type="text" name="pdf_scam_warning_suffix" id="pdf_scam_warning_suffix" class="form-control" value="{{ old('pdf_scam_warning_suffix', $settings['pdf_scam_warning_suffix'] ?? '') }}">@error('pdf_scam_warning_suffix', 'pdf_settings')<span class="error-message">{{ $message }}</span>@enderror</div>

                        {{-- Unlimited Calling Section --}}
                        <h4 class="form-section-title">Unlimited Calling Section</h4>
                        <div><label for="pdf_unlimited_calling_title" class="form-label">Title</label><input type="text" name="pdf_unlimited_calling_title" id="pdf_unlimited_calling_title" class="form-control" value="{{ old('pdf_unlimited_calling_title', $settings['pdf_unlimited_calling_title'] ?? '') }}"></div>
                        <div><label for="pdf_unlimited_calling_text" class="form-label">Text</label><textarea name="pdf_unlimited_calling_text" id="pdf_unlimited_calling_text" class="form-control" rows="2">{{ old('pdf_unlimited_calling_text', $settings['pdf_unlimited_calling_text'] ?? '') }}</textarea></div>
                        <div><label for="pdf_voice_contact_number" class="form-label">Contact Phone Number</label><input type="text" name="pdf_voice_contact_number" id="pdf_voice_contact_number" class="form-control" value="{{ old('pdf_voice_contact_number', $settings['pdf_voice_contact_number'] ?? '') }}"></div>

                        {{-- Payment Stub Info --}}
                        <h4 class="form-section-title">Payment Stub Information</h4>
                        <div><label for="pdf_customer_service_main_phone" class="form-label">Customer Service Phone (in stub note)</label><input type="text" name="pdf_customer_service_main_phone" id="pdf_customer_service_main_phone" class="form-control" value="{{ old('pdf_customer_service_main_phone', $settings['pdf_customer_service_main_phone'] ?? '') }}"></div>
                        <div><label for="pdf_return_address_warning_brand" class="form-label">Warning Brand Name (e.g., Spectrum)</label><input type="text" name="pdf_return_address_warning_brand" id="pdf_return_address_warning_brand" class="form-control" value="{{ old('pdf_return_address_warning_brand', $settings['pdf_return_address_warning_brand'] ?? '') }}"></div>
                        <div><label for="pdf_return_address_warning_text" class="form-label">Warning Text (e.g., DO NOT SEND...)</label><input type="text" name="pdf_return_address_warning_text" id="pdf_return_address_warning_text" class="form-control" value="{{ old('pdf_return_address_warning_text', $settings['pdf_return_address_warning_text'] ?? '') }}"></div>
                        <div><label for="pdf_do_not_send_payment_address_line1" class="form-label">"Do Not Send Payments To" Address Line 1</label><input type="text" name="pdf_do_not_send_payment_address_line1" id="pdf_do_not_send_payment_address_line1" class="form-control" value="{{ old('pdf_do_not_send_payment_address_line1', $settings['pdf_do_not_send_payment_address_line1'] ?? '') }}"></div>
                        <div><label for="pdf_do_not_send_payment_address_line2" class="form-label">"Do Not Send Payments To" Address Line 2</label><input type="text" name="pdf_do_not_send_payment_address_line2" id="pdf_do_not_send_payment_address_line2" class="form-control" value="{{ old('pdf_do_not_send_payment_address_line2', $settings['pdf_do_not_send_payment_address_line2'] ?? '') }}"></div>

                        <div><label for="pdf_payment_recipient_name" class="form-label">Payment Recipient Name</label><input type="text" name="pdf_payment_recipient_name" id="pdf_payment_recipient_name" class="form-control" value="{{ old('pdf_payment_recipient_name', $settings['pdf_payment_recipient_name'] ?? '') }}"></div>
                        <div><label for="pdf_payment_recipient_address_line1" class="form-label">Payment Recipient Address Line 1</label><input type="text" name="pdf_payment_recipient_address_line1" id="pdf_payment_recipient_address_line1" class="form-control" value="{{ old('pdf_payment_recipient_address_line1', $settings['pdf_payment_recipient_address_line1'] ?? '') }}"></div>
                        <div><label for="pdf_payment_recipient_address_line2" class="form-label">Payment Recipient Address Line 2</label><input type="text" name="pdf_payment_recipient_address_line2" id="pdf_payment_recipient_address_line2" class="form-control" value="{{ old('pdf_payment_recipient_address_line2', $settings['pdf_payment_recipient_address_line2'] ?? '') }}"></div>
                        <div><label for="security_code_placeholder" class="form-label">Security Code Placeholder (if static text)</label><input type="text" name="security_code_placeholder" id="security_code_placeholder" class="form-control" value="{{ old('security_code_placeholder', $settings['security_code_placeholder'] ?? 'XXXX') }}"></div>
                    </div>
                </div>
            </div>

            {{-- ==================== PAGE 2 CONTENT TAB (Bill Details) ==================== --}}
            <div id="page2Content" class="pdf-tab-content space-y-6 hidden">
                <div class="widget-card">
                    <div class="widget-header"><h3 class="widget-title">Page 2: Ways to Pay & Store Information</h3></div>
                    <div class="widget-content space-y-4">
                        <h4 class="form-section-title">Ways to Pay Section</h4>
                        <div><label for="pdf_autopay_url_text" class="form-label">AutoPay URL Text (e.g. Spectrum.net/AutoPay)</label><input type="text" name="pdf_autopay_url_text" id="pdf_autopay_url_text_pg2" class="form-control" value="{{ old('pdf_autopay_url_text', $settings['pdf_autopay_url_text'] ?? '') }}"></div>
                        <div><label for="pdf_autopay_url_link" class="form-label">AutoPay URL Link</label><input type="url" name="pdf_autopay_url_link" id="pdf_autopay_url_link_pg2" class="form-control" value="{{ old('pdf_autopay_url_link', $settings['pdf_autopay_url_link'] ?? '') }}" placeholder="https://..."></div>
                        <div><label for="pdf_online_billing_url_text" class="form-label">Online Billing URL Text (e.g. Spectrum.net)</label><input type="text" name="pdf_online_billing_url_text" id="pdf_online_billing_url_text" class="form-control" value="{{ old('pdf_online_billing_url_text', $settings['pdf_online_billing_url_text'] ?? '') }}"></div>
                        <div><label for="pdf_online_billing_url_link" class="form-label">Online Billing URL Link</label><input type="url" name="pdf_online_billing_url_link" id="pdf_online_billing_url_link" class="form-control" value="{{ old('pdf_online_billing_url_link', $settings['pdf_online_billing_url_link'] ?? '') }}" placeholder="https://..."></div>
                        <div><label for="pdf_paperless_url_text" class="form-label">Paperless URL Text (e.g. Spectrum.net/billing)</label><input type="text" name="pdf_paperless_url_text" id="pdf_paperless_url_text" class="form-control" value="{{ old('pdf_paperless_url_text', $settings['pdf_paperless_url_text'] ?? '') }}"></div>
                        <div><label for="pdf_paperless_url_link" class="form-label">Paperless URL Link</label><input type="url" name="pdf_paperless_url_link" id="pdf_paperless_url_link" class="form-control" value="{{ old('pdf_paperless_url_link', $settings['pdf_paperless_url_link'] ?? '') }}" placeholder="https://..."></div>
                        <div><label for="pdf_phone_payment_number_display" class="form-label">Phone Payment Number (Display Text, e.g. (833) 267-6097)</label><input type="text" name="pdf_phone_payment_number_display" id="pdf_phone_payment_number_display" class="form-control" value="{{ old('pdf_phone_payment_number_display', $settings['pdf_phone_payment_number_display'] ?? '') }}"></div>
                        <div><label for="pdf_phone_payment_number_tel" class="form-label">Phone Payment Number (tel: link, e.g. 8332676097)</label><input type="text" name="pdf_phone_payment_number_tel" id="pdf_phone_payment_number_tel" class="form-control" value="{{ old('pdf_phone_payment_number_tel', $settings['pdf_phone_payment_number_tel'] ?? '') }}"></div>

                        <h4 class="form-section-title">Store Information Section</h4>
                        <div><label for="pdf_store_address_line1" class="form-label">Store Address Line 1</label><input type="text" name="pdf_store_address_line1" id="pdf_store_address_line1" class="form-control" value="{{ old('pdf_store_address_line1', $settings['pdf_store_address_line1'] ?? '') }}"></div>
                        <div><label for="pdf_store_address_line2" class="form-label">Store Address Line 2 (City, ST ZIP)</label><input type="text" name="pdf_store_address_line2" id="pdf_store_address_line2" class="form-control" value="{{ old('pdf_store_address_line2', $settings['pdf_store_address_line2'] ?? '') }}"></div>
                        <div><label for="pdf_store_hours_display" class="form-label">Store Hours Display Text</label><input type="text" name="pdf_store_hours_display" id="pdf_store_hours_display" class="form-control" value="{{ old('pdf_store_hours_display', $settings['pdf_store_hours_display'] ?? '') }}"></div>
                        <div><label for="pdf_store_locator_url_text" class="form-label">Store Locator URL Text (e.g. Spectrum.com/stores)</label><input type="text" name="pdf_store_locator_url_text" id="pdf_store_locator_url_text" class="form-control" value="{{ old('pdf_store_locator_url_text', $settings['pdf_store_locator_url_text'] ?? '') }}"></div>
                        <div><label for="pdf_store_locator_url_link" class="form-label">Store Locator URL Link</label><input type="url" name="pdf_store_locator_url_link" id="pdf_store_locator_url_link" class="form-control" value="{{ old('pdf_store_locator_url_link', $settings['pdf_store_locator_url_link'] ?? '') }}" placeholder="https://..."></div>
                    </div>
                </div>
            </div>

            {{-- ==================== PAGE 3 CONTENT TAB (Support/FAQs/Descriptions/Legal) ==================== --}}
            <div id="page3Content" class="pdf-tab-content space-y-6 hidden">
                <div class="widget-card">
                    <div class="widget-header"><h3 class="widget-title">Page 3: Support, FAQs, Descriptions & Legal</h3></div>
                    <div class="widget-content space-y-4">
                        <h4 class="form-section-title">Support Section</h4>
                        <div><label for="pdf_support_url_billing_text" class="form-label">Billing Support URL Text</label><input type="text" name="pdf_support_url_billing_text" id="pdf_support_url_billing_text" class="form-control" value="{{ old('pdf_support_url_billing_text', $settings['pdf_support_url_billing_text'] ?? '') }}"></div>
                        <div><label for="pdf_support_url_billing_link" class="form-label">Billing Support URL Link</label><input type="url" name="pdf_support_url_billing_link" id="pdf_support_url_billing_link" class="form-control" value="{{ old('pdf_support_url_billing_link', $settings['pdf_support_url_billing_link'] ?? '') }}" placeholder="https://..."></div>
                        <div><label for="pdf_support_phone_main" class="form-label">Main Support Phone</label><input type="text" name="pdf_support_phone_main" id="pdf_support_phone_main" class="form-control" value="{{ old('pdf_support_phone_main', $settings['pdf_support_phone_main'] ?? '') }}"></div>
                        <div><label for="pdf_support_url_moving_text" class="form-label">Moving Support URL Text</label><input type="text" name="pdf_support_url_moving_text" id="pdf_support_url_moving_text" class="form-control" value="{{ old('pdf_support_url_moving_text', $settings['pdf_support_url_moving_text'] ?? '') }}"></div>
                        <div><label for="pdf_support_url_moving_link" class="form-label">Moving Support URL Link</label><input type="url" name="pdf_support_url_moving_link" id="pdf_support_url_moving_link" class="form-control" value="{{ old('pdf_support_url_moving_link', $settings['pdf_support_url_moving_link'] ?? '') }}" placeholder="https://..."></div>
                        <div><label for="pdf_support_phone_moving" class="form-label">Moving Support Phone</label><input type="text" name="pdf_support_phone_moving" id="pdf_support_phone_moving" class="form-control" value="{{ old('pdf_support_phone_moving', $settings['pdf_support_phone_moving'] ?? '') }}"></div>

                        <h4 class="form-section-title">Bill FAQs Section</h4>
                        <div><label for="pdf_faq_billing_cycle" class="form-label">FAQ: Billing Cycles</label><textarea name="pdf_faq_billing_cycle" class="form-control" rows="3">{{ old('pdf_faq_billing_cycle', $settings['pdf_faq_billing_cycle'] ?? '') }}</textarea></div>
                        <div><label for="pdf_faq_insufficient_funds" class="form-label">FAQ: Insufficient Funds</label><textarea name="pdf_faq_insufficient_funds" class="form-control" rows="4">{{ old('pdf_faq_insufficient_funds', $settings['pdf_faq_insufficient_funds'] ?? '') }}</textarea></div>
                        <div><label for="pdf_faq_disagree_charge" class="form-label">FAQ: Disagree with Charge</label><textarea name="pdf_faq_disagree_charge" class="form-control" rows="3">{{ old('pdf_faq_disagree_charge', $settings['pdf_faq_disagree_charge'] ?? '') }}</textarea></div>
                        <div><label for="pdf_faq_service_interruption" class="form-label">FAQ: Service Interruption</label><textarea name="pdf_faq_service_interruption" class="form-control" rows="2">{{ old('pdf_faq_service_interruption', $settings['pdf_faq_service_interruption'] ?? '') }}</textarea></div>
                        <div><label for="pdf_terms_url_text" class="form-label">General Terms URL Text (e.g. Spectrum.com/policies)</label><input type="text" name="pdf_terms_url_text" id="pdf_terms_url_text" class="form-control" value="{{ old('pdf_terms_url_text', $settings['pdf_terms_url_text'] ?? '') }}"></div>
                        <div><label for="pdf_terms_url_link" class="form-label">General Terms URL Link</label><input type="url" name="pdf_terms_url_link" id="pdf_terms_url_link" class="form-control" value="{{ old('pdf_terms_url_link', $settings['pdf_terms_url_link'] ?? '') }}" placeholder="https://..."></div>

                        <h4 class="form-section-title">Descriptions Section</h4>
                        <div><label for="pdf_desc_taxes_fees" class="form-label">Desc: Taxes and Fees</label><textarea name="pdf_desc_taxes_fees" class="form-control" rows="3">{{ old('pdf_desc_taxes_fees', $settings['pdf_desc_taxes_fees'] ?? '') }}</textarea></div>
                        <div><label for="pdf_desc_terms_conditions" class="form-label">Desc: Terms & Conditions</label><textarea name="pdf_desc_terms_conditions" class="form-control" rows="2">{{ old('pdf_desc_terms_conditions', $settings['pdf_desc_terms_conditions'] ?? '') }}</textarea></div>
                        <div><label for="pdf_desc_insufficient_funds" class="form-label">Desc: Insufficient Funds Policy</label><textarea name="pdf_desc_insufficient_funds" class="form-control" rows="4">{{ old('pdf_desc_insufficient_funds', $settings['pdf_desc_insufficient_funds'] ?? '') }}</textarea></div>

                        <h4 class="form-section-title">Legal Text Section (Right Column on PDF Page 3)</h4>
                        <div><label for="pdf_legal_programming_changes" class="form-label">Legal: Programming Changes</label><textarea name="pdf_legal_programming_changes" class="form-control" rows="3">{{ old('pdf_legal_programming_changes', $settings['pdf_legal_programming_changes'] ?? '') }}</textarea></div>
                        <div><label for="pdf_legal_recording_video" class="form-label">Legal: Recording Video Services</label><textarea name="pdf_legal_recording_video" class="form-control" rows="3">{{ old('pdf_legal_recording_video', $settings['pdf_legal_recording_video'] ?? '') }}</textarea></div>
                        <div><label for="pdf_legal_spectrum_terms" class="form-label">Legal: Spectrum Terms of Service</label><textarea name="pdf_legal_spectrum_terms" class="form-control" rows="3">{{ old('pdf_legal_spectrum_terms', $settings['pdf_legal_spectrum_terms'] ?? '') }}</textarea></div>
                        <div><label for="pdf_legal_security_center" class="form-label">Legal: Security Center</label><textarea name="pdf_legal_security_center" class="form-control" rows="3">{{ old('pdf_legal_security_center', $settings['pdf_legal_security_center'] ?? '') }}</textarea></div>
                        <div><label for="pdf_legal_billing_practices" class="form-label">Legal: Billing Practices</label><textarea name="pdf_legal_billing_practices" class="form-control" rows="4">{{ old('pdf_legal_billing_practices', $settings['pdf_legal_billing_practices'] ?? '') }}</textarea></div>
                        <div><label for="pdf_legal_late_fee" class="form-label">Legal: Past Due Fee / Late Fee</label><textarea name="pdf_legal_late_fee" class="form-control" rows="1">{{ old('pdf_legal_late_fee', $settings['pdf_legal_late_fee'] ?? '') }}</textarea></div>
                        <div><label for="pdf_legal_complaint_procedures" class="form-label">Legal: Complaint Procedures</label><textarea name="pdf_legal_complaint_procedures" class="form-control" rows="2">{{ old('pdf_legal_complaint_procedures', $settings['pdf_legal_complaint_procedures'] ?? '') }}</textarea></div>
                        <div><label for="pdf_legal_closed_captioning" class="form-label">Legal: Closed Captioning Inquiries</label><textarea name="pdf_legal_closed_captioning" class="form-control" rows="2">{{ old('pdf_legal_closed_captioning', $settings['pdf_legal_closed_captioning'] ?? '') }}</textarea></div>
                        <div><label for="pdf_closed_caption_phone" class="form-label">Closed Captioning Phone</label><input type="text" name="pdf_closed_caption_phone" id="pdf_closed_caption_phone" class="form-control" value="{{ old('pdf_closed_caption_phone', $settings['pdf_closed_caption_phone'] ?? '') }}"></div>
                        <div><label for="pdf_closed_caption_email_text" class="form-label">Closed Captioning Email Text</label><input type="text" name="pdf_closed_caption_email_text" id="pdf_closed_caption_email_text" class="form-control" value="{{ old('pdf_closed_caption_email_text', $settings['pdf_closed_caption_email_text'] ?? '') }}"></div>
                        <div><label for="pdf_closed_caption_email_addr" class="form-label">Closed Captioning Email Address</label><input type="email" name="pdf_closed_caption_email_addr" id="pdf_closed_caption_email_addr" class="form-control" value="{{ old('pdf_closed_caption_email_addr', $settings['pdf_closed_caption_email_addr'] ?? '') }}"></div>
                        <div><label for="pdf_closed_caption_complaint_instructions_para1" class="form-label">Closed Captioning Complaint Instructions</label><textarea name="pdf_closed_caption_complaint_instructions_para1" class="form-control" rows="4">{{ old('pdf_closed_caption_complaint_instructions_para1', $settings['pdf_closed_caption_complaint_instructions_para1'] ?? '') }}</textarea></div>
                    </div>
                </div>
            </div>
        </div> {{-- End Tab Content Wrapper --}}


        <div class="widget-footer bg-gray-50 p-3 border-t flex justify-end mt-6">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save All PDF Settings</button>
        </div>
    </form>
</section>
@endsection

@push('styles')
<style>
    /* Basic Tab Styles */
    .pdf-tab-button {
        border-color: transparent;
        color: #6b7280; /* Gray-500 */
    }
    .pdf-tab-button:hover {
        border-color: #d1d5db; /* Gray-300 */
        color: #374151; /* Gray-700 */
    }
    .pdf-tab-button.active-tab {
        color: var(--primary-color, #4f46e5); /* Indigo-600 */
        border-color: var(--primary-color, #4f46e5);
        font-weight: 600;
    }
    .pdf-tab-content {
        /* display: none; -- handled by JS */
    }
    .pdf-tab-content.active-content {
        display: block;
    }
    .form-section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #374151; /* Gray-700 */
        margin-top: 1.5rem;
        margin-bottom: 0.5rem;
        padding-bottom: 0.25rem;
        border-bottom: 1px solid #e5e7eb; /* Gray-200 */
    }
    .form-section-title:first-of-type {
        margin-top: 0.5rem; /* Less margin for the very first title in a tab */
    }

    /* Re-add general form styles if not globally available from layouts.admin */
    .widget-card { background-color: #fff; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px -1px rgba(0,0,0,.06); border: 1px solid #e5e7eb; }
    .widget-header { padding: 0.75rem 1.25rem; border-bottom: 1px solid #e5e7eb; background-color: #f9fafb; }
    .widget-title { font-size: 1.125rem; font-weight: 600; color: #374151; }
    .widget-content { padding: 1.25rem; }
    .widget-footer { padding: 0.75rem 1.25rem; background-color: #f9fafb; border-top: 1px solid #e5e7eb; text-align: right; }
    .form-group { margin-bottom: 1rem; }
    .form-label { display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500; color: #374151; }
    .form-control { display: block; width: 100%; padding: 0.5rem 0.75rem; font-size: 0.875rem; line-height: 1.5; color: #374151; background-color: #fff; background-clip: padding-box; border: 1px solid #d1d5db; border-radius: 0.375rem; }
    .form-control:focus { border-color: #6366f1; outline: 0; box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25); }
    .input-error { border-color: #ef4444; }
    .error-message { color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; }
    .alert { padding: 0.75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.375rem; }
    .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
    .alert-danger { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.pdf-tab-button');
    const tabContents = document.querySelectorAll('.pdf-tab-content');

    // Function to activate a tab
    function activateTab(targetTabId) {
        tabContents.forEach(content => {
            content.classList.add('hidden');
            content.classList.remove('active-content');
        });
        tabs.forEach(tab => {
            tab.classList.remove('active-tab');
            // Optional: reset other styles like border or background
            tab.style.borderColor = 'transparent';
        });

        const activeContent = document.getElementById(targetTabId);
        if (activeContent) {
            activeContent.classList.remove('hidden');
            activeContent.classList.add('active-content');
        }

        const activeButton = document.querySelector(`.pdf-tab-button[data-tab-target="${targetTabId}"]`);
        if (activeButton) {
            activeButton.classList.add('active-tab');
            // Optional: style active tab button border if not handled by active-tab class alone
            // activeButton.style.borderColor = 'var(--primary-color, #4f46e5)';
        }
        // Store active tab in localStorage
        localStorage.setItem('activePdfSettingsTab', targetTabId);
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const targetTabId = this.dataset.tabTarget;
            activateTab(targetTabId);
        });
    });

    // Restore active tab from localStorage on page load
    const savedTab = localStorage.getItem('activePdfSettingsTab');
    if (savedTab && document.getElementById(savedTab)) {
        activateTab(savedTab);
    } else {
        // Activate the first tab by default if no saved tab or saved tab is invalid
        if(tabs.length > 0 && tabContents.length > 0) {
           activateTab(tabs[0].dataset.tabTarget);
        }
    }
});
</script>
@endpush