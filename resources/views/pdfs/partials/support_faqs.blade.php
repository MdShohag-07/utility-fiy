{{-- resources/views/pdfs/partials/support_faqs.blade.php --}}
{{-- This is intended to be Page 3 (and potentially Page 4) content --}}

<div class="statement-page page-3-plus-content support-faqs-section">
    {{-- Optional: Replicating the header info block for context at the top of this page section --}}
    <table class="no-border page-section-header-info" style="margin-bottom: 10px;">
        <tr>
            <td style="width: 33%; font-size: 7pt; vertical-align:middle;">
                {{-- Display a smaller logo or just company name on subsequent pages --}}
                @if(isset($siteLogoUrl) && $siteLogoUrl)
                    <img src="{{ $siteLogoUrl }}" alt="{{ $companySettings['site_name'] ?? 'Logo' }}" style="max-width: 100px; max-height: 20px;">
                @else
                    <div style="font-size: 10pt; font-weight: bold; color: #0067b2;">{{ $companySettings['site_name'] ?? 'Spectrum' }}</div>
                @endif
            </td>
            <td style="width: 34%; text-align: center; font-size: 7pt;">
                ACCOUNT NUMBER<br><span class="bold brand-blue-text">{{ $statement->user->account_number ?? 'N/A' }}</span>
            </td>
            <td style="width: 33%; text-align: right; font-size: 7pt;">
                STATEMENT DATE<br><span class="bold">{{ $statement->formatted_statement_date }}</span>
            </td>
        </tr>
         <tr>
            <td colspan="3" style="text-align:right; font-size: 7pt; padding-top:2px;">
                SERVICE ADDRESS<br><span class="bold">{{ $statement->user->address ?? 'N/A' }}<br>{{ $statement->user->city ?? '' }}, {{ $statement->user->state ?? '' }} {{ $statement->user->zip_code ?? '' }}</span>
            </td>
        </tr>
    </table>
    <hr class="header-divider-page3">

    <h1 class="page-title">Support, Bill FAQs and Descriptions</h1>

    <table class="no-border content-columns-page3">
        <tr>
            {{-- Left Column for Support, FAQs, Descriptions --}}
            <td class="left-column-page3">
                <div class="section">
                    <h3 class="section-heading">Support</h3>
                    <p>Visit <a href="{{ $companySettings['support_url_billing_link'] ?? '#' }}">{{ $companySettings['support_url_billing_text'] ?? 'Spectrum.net/billing' }}</a><br>
                       Or, call us at <span class="bold brand-blue-text">{{ $companySettings['support_phone_main'] ?? '1-855-855-8679' }}</span></p>
                    <p><span class="bold">Moving Soon?</span><br>
                       Visit <a href="{{ $companySettings['support_url_moving_link'] ?? '#' }}">{{ $companySettings['support_url_moving_text'] ?? 'Spectrum.com/easy2move' }}</a> or call us at <span class="bold brand-blue-text">{{ $companySettings['support_phone_moving'] ?? '(877) 940-7124' }}</span> for help transferring and setting up your services in your new home.</p>
                </div>

                <div class="section">
                    <h3 class="section-heading">Bill FAQs</h3>
                    <p><span class="sub-heading">How do billing cycles work?</span><br>
                       {{ $companySettings['faq_billing_cycle'] ?? 'The service period covered by your first bill statement starts on your first day of service and ends on the 30th day of service. Future months\' bill statements cover service periods which start and end on the same days of the month as the first service period. Charges associated with Pay-Per-View or On Demand purchases will be included on the next service period\'s bill statement.' }}</p>
                    <p><span class="sub-heading">What happens if I have insufficient funds or a past due balance?</span><br>
                       {{ $companySettings['faq_insufficient_funds'] ?? 'Spectrum may charge a processing fee for any returned checks and card chargebacks. If your payment method is refused or returned for any reason, we may debit your account for the payment, plus an insufficient funds processing fee as described in your terms of service or video services rate card up to the amount allowable by law and any applicable tax. Your bank account may be debited as early as the same day your payment is refused or returned. If your bank account isn\'t debited, the return check amount (plus fee) must be paid by cash, cashier\'s check or money order.' }}</p>
                    <p><span class="sub-heading">What if I disagree with a charge?</span><br>
                       {{ $companySettings['faq_disagree_charge'] ?? 'If you want to dispute a charge, you have 60 days from the billing due date to file a complaint. While it\'s being reviewed, your service will remain active as long as you pay the undisputed part of your bill.' }}</p>
                    <p><span class="sub-heading">What if my service is interrupted?</span><br>
                       {{ $companySettings['faq_service_interruption'] ?? 'Unless prevented by situations beyond our control, services will be restored within 24 hours of you being notified.' }}</p>
                    <p>You can find all of our terms and conditions at <a href="{{ $companySettings['terms_url_link'] ?? '#' }}">{{ $companySettings['terms_url_text'] ?? 'Spectrum.com/policies' }}</a>.</p>
                </div>

                <div class="section">
                    <h3 class="section-heading">Descriptions</h3>
                    <p><span class="sub-heading">Taxes and Fees</span> - {{ $companySettings['desc_taxes_fees'] ?? 'This statement reflects the current taxes and fees for your area (including sales, excise, user taxes, etc.). These taxes and fees may change without notice. Visit Spectrum.net/taxesandfees for more information.' }}</p>
                    <p><span class="sub-heading">Terms & Conditions</span> - {{ $companySettings['desc_terms_conditions'] ?? 'Spectrum\'s detailed standard terms and conditions for service are located at Spectrum.com/policies.' }}</p>
                    <p><span class="sub-heading">Insufficient Funds Payment Policy</span> - {{ $companySettings['desc_insufficient_funds'] ?? 'Charter may charge an insufficient funds processing fee for all returned checks and bankcard charge-backs. If your check, bankcard (debit or credit) charge, or other instrument or electronic transfer transaction used to pay us is dishonored, refused or returned for any reason, we may electronically debit your account for the payment, plus an insufficient funds processing fee as set forth in your terms of service or on your Video Services rate card (up to the amount allowable by law and any applicable sales tax). Your bank account may be debited as early as the same day payment is dishonored, refused or returned. If your bank account is not debited, the returned check amount (plus fee) must be replaced by cash, cashier\'s check or money order.' }}</p>
                </div>
            </td>

            {{-- Right Column for Legal Text and Other Info --}}
            <td class="right-column-page3">
                <div class="section legal-text-block">
                    <p><span class="sub-heading">Programming Changes</span> - {{ $companySettings['legal_programming_changes'] ?? 'For information on any upcoming programming changes, please consult the Legal Notices published in your local newspaper and on Spectrum.net/programmingnotices.' }}</p>
                    <p><span class="sub-heading">Recording Video Services</span> - {{ $companySettings['legal_recording_video'] ?? 'When you pause or otherwise record any video service (using a set-top device, the Spectrum TV App, or any other means), you are making such copy exclusively for your own personal use, and you are not authorized to use, further reproduce or distribute such copy to any other person or for any other purpose. Furthermore, you are not authorized to make derivative works or public performances or public displays of such copy.' }}</p>
                    <p><span class="sub-heading">Spectrum Terms and Conditions of Service</span> - {{ $companySettings['legal_spectrum_terms'] ?? 'In accordance with the Spectrum Terms and Conditions of Service, Spectrum services are billed on a monthly basis. Spectrum does not provide credits for monthly subscription services that are cancelled prior to the end of the current billing month.' }}</p>
                    <p><span class="sub-heading">Spectrum Security Center:</span> {{ $companySettings['legal_security_center'] ?? 'Spectrum offers tools and solutions to keep you and your family safe when connected. Learn how to safeguard your information, detect scams and how to identify fraud alerts. Learn more at Spectrum.net/Security Center.' }}</p>
                    <p><span class="sub-heading">Billing Practices</span> - {{ $companySettings['legal_billing_practices'] ?? 'Spectrum mails monthly, itemized statements to customers for monthly services that are billed in advance. Customers agree to pay amounts due by the due date indicated on the statement, less any authorized credits. If your monthly statement is not paid by the due date, a late payment processing charge may be imposed. Nonpayment of any portion of any services on this statement could result in disconnection of all of your Spectrum services. Disconnection of Phone service may also result in the loss of your phone number.' }}</p>
                    <p><span class="sub-heading">Past Due Fee / Late Fee Reminder</span> - {{ $companySettings['legal_late_fee'] ?? 'A late fee will be assessed for past due charges for service.' }}</p>
                    <p><span class="sub-heading">Complaint Procedures:</span> {{ $companySettings['legal_complaint_procedures'] ?? 'If you disagree with your charges, you need to register a complaint no later than 60 days after the due date on your bill statement.' }}</p>
                    <p><span class="sub-heading">Video Closed Captioning Inquiries</span> - {{ $companySettings['legal_closed_captioning'] ?? 'Spectrum provided set-top boxes for video consumption support the ability for the user to enable or disable Closed Captions for customers with hearing impairment.' }}</p>
                    <p>For immediate closed captioning concerns, call <span class="bold">{{ $companySettings['closed_caption_phone'] ?? '855-70-SPECTRUM' }}</span> or email <a href="mailto:{{ $companySettings['closed_caption_email_addr'] ?? 'closedcaptioningsupport@charter.com' }}">{{ $companySettings['closed_caption_email_text'] ?? 'closedcaptioningsupport@charter.com' }}</a>.</p>
                    <p>{{ $companySettings['closed_caption_complaint_instructions_para1'] ?? 'To report a complaint on an ongoing closed captioning issue, please send your concerns via US Mail to W. Wesselman, Sr. Director, 2 Digital Place, Simpsonville, SC 29681, send a fax to 1-704-697-4935, call 1-877-276-7432 or email closedcaptioningissues@charter.com.' }}</p>
                </div>
            </td>
        </tr>
    </table>
</div>