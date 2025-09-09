<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Statement #{{ $statement->statement_number ?? $statement->id }}</title>
    <style>
        @page {
            margin: 0.5in 0.6in 0.5in 0.6in; /* Top, Right, Bottom, Left */
        }
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 8pt; /* Base font size for better readability */
            color: #000000; /* Pure black for main text */
            line-height: 1.2;
            margin: 0;
            font-weight: normal;
        }

        /* --- Fixed Header & Footer --- */
        .page-header-placeholder { height: 0.8in; } /* Space for fixed header + separator */
        .page-footer-placeholder { height: 0.35in; }

        .header-content {
            position: fixed;
            top: 0.15in; /* Adjust if needed */
            left: 0.6in;
            right: 0.6in;
            height: 0.6in; /* Adjust if header content + separator need more/less space */
            font-size: 8pt;
        }
        .header-content table.header-table-main { /* Target the main table inside header-content */
            width: 100%;
            border-bottom: 1px solid #cccccc; /* Separator Line - Light Gray */
            padding-bottom: 5pt; /* Space between content and line */
        }

        .page-footer {
            position: fixed;
            bottom: 0.15in;
            left: 0.6in;
            right: 0.6in;
            height: 0.2in;
            text-align: right;
            font-size: 7pt;
            color: #777777;
        }
        .footer-content { position: fixed; bottom: 0.15in; left: 0.6in; right: 0.6in; height: 0.2in; text-align: right; }
        .footer-content .page-number:after { content: "PAGE " counter(page) " OF " counter(pages); font-size: 7pt; font-weight: bold; color: #4A5568;}

        /* --- General & Table Styles --- */
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 0; vertical-align: top; text-align: left; }
        .no-border td, .no-border th { border: none; }
        .bold { font-weight: bold; }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .uppercase { text-transform: uppercase; }
        .brand-blue { color: #0067b2; } /* Primary blue */
        .brand-blue-darker { color: #004a80; }
        .accent-red { color: #d9534f; } /* For "Do Not Pay" or urgent items */
        .accent-orange { color: #f0ad4e; } /* For due by date if positive balance */
        .subtle-text { color: #555555; }
        .light-gray-bg { background-color: #f0f4f7; }
        hr.section-divider { border: 0; border-top: 1px solid #cccccc; margin: 8pt 0; }

        /* --- Header Section --- */
        .header-logo-cell { width: 25%; vertical-align: middle; }
        .header-logo { max-width: 120px; max-height: 25px; display:block; }
        .header-details-cell { width: 75%; vertical-align: top; }
        .header-details-table { font-size: 7pt; }
        .header-details-table td { line-height: 1.1; padding: 0 0 1pt 0; }
        .header-details-table td.label { color: #000000; text-align: right; width: 40%; font-weight: bold; } /* Labels right-aligned */
        .header-details-table td.value { font-weight: bold; text-align: right; color: #0066cc; } /* Values right-aligned */

        /* --- Main Content (Page 1) --- */
        .greeting { font-size: 16pt; margin: 15pt 0 10pt 0; font-weight: normal; color: #000000; }
        .main-columns-table td { padding: 0; }
        .summary-box-column { width: 45%; padding-right: 15pt; } /* Adjusted width */
        .info-column { width: 55%; padding-left: 15pt; }

        /* Blue Summary Box */
        .summary-box {
            background-color: #0066cc; /* Spectrum Bill Blue */
            color: white;
            padding: 12pt 12pt 10pt 12pt;
            border-radius: 0px; /* No rounded corners for exact match */
            border: 1px solid #0066cc;
        }
        .summary-box-header { overflow: auto; margin-bottom: 8pt; }
        .summary-box-header .amount-due-block { float: left; }
        .summary-box-header .amount-due-block .label { font-size: 9pt; display: block; line-height: 1.1; font-weight: normal; }
        .summary-box-header .amount-due-block .value { font-size: 24pt; font-weight: bold; line-height: 1; }
        .summary-box-header .due-by-block { float: right; text-align: right; }
        .summary-box-header .due-by-block .label { font-size: 8pt; display: block; font-weight: normal; }
        .summary-box-header .due-by-block .value { font-size: 10pt; font-weight: bold; display: block; color: white; }
        .summary-box-header .due-by-block .value.alert { color: #ffff00; } /* Bright yellow for due date if > 0 */
        .summary-box-header .due-by-block .value.do-not-pay { color: #cccccc; }

        .summary-details { background-color: #ffffff; color: #000000; padding: 8pt; margin-top: 8pt; border: 1px solid #cccccc; }
        .summary-details .title-bar { overflow: auto; margin-bottom: 4pt; }
        .summary-details .title { font-size: 8pt; color: #0066cc; font-weight: bold; float: left; }
        .summary-details .service-period { font-size: 7pt; color: #0066cc; float: right; font-weight: bold;}
        .summary-details table { font-size: 8pt; margin-bottom: 5pt; }
        .summary-details table td { padding: 2pt 0; border-bottom: 1px solid #dddddd; }
        .summary-details table tr:last-child td { border-bottom: none; }
        .summary-details .current-activity-title { font-weight: bold; margin-top: 8pt; margin-bottom: 3pt; font-size: 8pt; color: #000000; }
        .summary-details .total-due-row td { font-weight: bold; background-color: #e6f2ff; color: #0066cc; padding: 5pt 0 !important; font-size: 9pt; border-top: 1px solid #0066cc; }

        /* Right Panel Info */
        .info-column .section { margin-bottom: 12pt; }
        .info-column .section h4 { color: #0066cc; font-size: 9pt; margin-bottom: 2pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-column .section p { margin-top: 0; margin-bottom: 5pt; font-size: 8pt; line-height: 1.3; }
        .info-column .section a { color: #0066cc; text-decoration: none; font-weight: bold;}

        /* Promo Section */
        .promo-section { text-align: center; margin: 18pt 0; padding: 10pt 0; border-top: 1px solid #cccccc; border-bottom: 1px solid #cccccc;}
        .promo-section h3 { color: #0066cc; font-size: 11pt; margin-bottom: 3pt; font-weight: normal; }
        .promo-section p { font-size: 8pt; margin-bottom: 3pt; color: #000000; line-height: 1.3; }

        /* Payment Stub */
        .payment-stub-wrapper { margin-top: 18pt; padding-top: 10pt; border-top: 2px dashed #666666; font-size: 8pt; }
        .payment-stub-detach-text { text-align: center; font-size: 7pt; margin-bottom: 8pt; color: #000000; }
        .payment-stub-logo-container { width: 40%; }
        .payment-stub-logo { max-width: 110px; margin-bottom: 4pt; }
        .payment-stub-warning { font-size: 7pt; color: #cc0000; font-weight: bold; margin-bottom: 2pt; text-transform: uppercase; letter-spacing: 0.5px; }
        .payment-stub-return-address p { margin: 0; font-size: 7pt; line-height: 1.2; }
        .payment-stub-user-address { margin-top: 6pt; }
        .payment-stub-user-address p { margin: 0; font-size: 8pt; line-height: 1.2; }
        .payment-stub-details-container { width: 60%; padding-left: 18pt; }
        .payment-stub-details-table td { font-size: 8pt; padding: 2pt 0; line-height: 1.3;}
        .payment-stub-details-table .due-by-value { background-color: #f0f0f0; padding: 3pt 6pt !important; text-align: center !important; }
        .payment-stub-payto-address { margin-top: 8pt; text-align: left; font-size: 8pt; }
        .payment-stub-payto-address p { margin: 0; line-height: 1.2; }
        .payment-stub-barcode-text { text-align: center; font-family: 'Courier New', Courier, monospace; font-size: 9pt; margin-top: 6pt; letter-spacing: 0.5px; word-wrap: break-word; }
        .payment-stub-barcode-image { display: block; margin: 4pt auto 0 auto; max-height: 30px; }

        .page-break { page-break-after: always; }
        .clearfix::after { content: ""; clear: both; display: table; }

        .bill-details-page-content {
    /* Styles specific to page 2 if needed, or rely on general styles */
}

.bill-details-title {
    font-size: 18pt; /* Larger size for main title */
    color: #0066cc; /* Spectrum blue */
    font-weight: normal; /* Not bold */
    margin: 0;
    padding: 0;
    line-height: 1;
}

.bill-details-box {
    border: 1px solid #0066cc; /* Spectrum blue border */
    border-radius: 0px; /* No rounded corners for exact match */
    overflow: hidden; /* To make border-radius clip content */
    margin-bottom: 25px;
}

.activity-table {
    width: 100%;
    font-size: 9pt;
    border-collapse: collapse; /* Important */
}
.activity-table th, .activity-table td {
    padding: 6px 10px; /* Uniform padding */
    text-align: left;
    border: none; /* Remove individual cell borders for this style */
}
.activity-table thead tr th {
    font-weight: bold;
}

.balance-header-row {
    background-color: #0066cc; /* Spectrum blue */
    color: white;
}
.balance-header-row th {
    font-size: 10pt; /* Slightly larger */
    border-bottom: 1px solid white; /* Separator */
}
.balance-header-row:last-of-type th { /* Remove bottom border from last header row */
    border-bottom: none;
}


.activity-main-header-row {
    background-color: #f5f5f5; /* Light gray */
    color: #000000;
}
.activity-main-header-row th {
    font-weight: bold;
    border-bottom: 1px solid #0066cc; /* Spectrum blue line under "Current Activity" */
}

.category-title-row td {
    background-color: transparent; /* No background for category title */
    color: #0066cc; /* Spectrum blue text */
    font-weight: bold;
    font-size: 10pt;
    padding-top: 10px !important; /* More space above category */
    padding-bottom: 4px !important;
    border-bottom: 1px solid #0066cc; /* Blue line under category title */
}

.item-description {
    padding-left: 10px; /* Indent item description */
    color: #000000;
}
.item-description .included-note {
    font-size: 8pt;
    color: #666666;
    margin-left: 6px;
}
.item-amount {
    color: #000000;
}

.category-total-row td {
    font-weight: bold;
    color: #0066cc; /* Spectrum blue */
    border-top: 1px solid #0066cc; /* Blue line above category total */
    padding-top: 5px !important;
    padding-bottom: 8px !important;
}

.amount-due-footer-row {
    background-color: #0066cc; /* Spectrum blue */
    color: white;
}
.amount-due-footer-row td {
    font-size: 11pt;
    font-weight: bold;
}

/* Ways to Pay Section */
.ways-to-pay-section {
    margin-top: 30px;
    font-size: 9pt;
    border-top: 1px solid #cccccc; /* Light separator line */
    padding-top: 18px;
}
.ways-to-pay-section .section-heading {
    font-size: 12pt;
    color: #000000;
    font-weight: bold;
    margin-bottom: 10px;
    display: flex; /* For icon alignment */
    align-items: center;
}
.ways-to-pay-section .payment-option {
    margin-bottom: 8px;
    display: flex; /* For icon alignment */
    align-items: flex-start;
}
.ways-to-pay-section .payment-icon {
    margin-right: 10px;
    font-size: 14pt; /* Adjust icon size */
    color: #0066cc; /* Spectrum blue icons */
    width: 22px; /* Fixed width for alignment */
    text-align: center;
}
.ways-to-pay-section .store-address {
    margin-bottom: 5px;
}
.ways-to-pay-section .store-hours {
    font-size: 8pt;
    color: #000000;
    margin-bottom: 8px;
}
.page3-header-info { /* Specific styling for the repeated header on page 3 if needed */
    margin-bottom: 5px; /* Less margin than full page header */
}
.header-divider-page3 {
    border: 0;
    border-top: 1px solid #cccccc;
    margin-bottom: 15px;
}

.support-faqs-section .page-title {
    font-size: 16pt; /* Matching Spectrum bill's "Support, Bill FAQs and Descriptions" title */
    color: #0066cc;
    font-weight: normal; /* Not bold */
    border-bottom: 2px solid #0066cc;
    padding-bottom: 6px;
    margin-bottom: 15px;
}

.support-faqs-section .content-columns-page3 > tbody > tr > td {
    vertical-align: top;
    padding: 0;
}
.support-faqs-section .left-column-page3 {
    width: 49%; /* Adjust for balance */
    padding-right: 10px; /* Space between columns */
}
.support-faqs-section .right-column-page3 {
    width: 49%;
    padding-left: 10px; /* Space between columns */
}

.support-faqs-section .section {
    margin-bottom: 10px; /* Space between major sections like Support, Bill FAQs, Descriptions */
}
.support-faqs-section .section-heading { /* For "Support", "Bill FAQs", "Descriptions" */
    font-size: 12pt;
    color: #0066cc;
    margin-bottom: 6px;
    font-weight: bold; /* Bold for main headings */
}
.support-faqs-section p {
    margin-top: 0;
    margin-bottom: 8px; /* Space between paragraphs */
    font-size: 8pt;
    line-height: 1.4;
    color: #000000; /* Black text for readability */
}
.support-faqs-section p .sub-heading, .support-faqs-section .sub-heading { /* For "How do billing cycles work?", "Taxes and Fees" etc. */
    font-weight: bold;
    color: #000000; /* Black for these sub-headings */
    display: block; /* Make it take its own line if needed, or inline if preferred */
    margin-bottom: 2px; /* Little space before the paragraph */
}
.support-faqs-section .left-column-page3 p .sub-heading { /* Make FAQ questions slightly more prominent */
    font-size: 9pt;
}

.support-faqs-section a {
    color: #0066cc;
    text-decoration: none; /* Often better for PDFs */
}
.support-faqs-section .bold { /* Generic bold for phone numbers etc. */
    font-weight: bold;
}
.support-faqs-section .brand-blue-text { /* For specific blue text like phone numbers if desired */
    color: #0066cc;
}

/* Styles for the denser legal text on the right */
.support-faqs-section .right-column-page3 .section.legal-text-block p {
    font-size: 8pt; /* Slightly larger for better readability */
    line-height: 1.3;
    margin-bottom: 6px;
}
.support-faqs-section .right-column-page3 .section.legal-text-block p .sub-heading {
    font-size: 8pt; /* Sub-headings in legal text same size as paragraph */
    color: #000000;
    display: inline; /* Keep them inline with the start of the paragraph */
    margin-bottom: 0;
}

.support-faqs-section {
    margin-top: 15px;
    font-size: 8pt; /* Base font for this page */
    line-height: 1.4; /* Adjust line height for readability */
}

.support-faqs-section .page-title { /* For "Support, Bill FAQs and Descriptions" */
    font-size: 16pt;
    color: #0066cc; /* Spectrum blue */
    font-weight: normal;
    border-bottom: 2px solid #0066cc;
    padding-bottom: 6px;
    margin-bottom: 18px;
}

.support-faqs-section .content-columns-page3 > tbody > tr > td {
    vertical-align: top;
    padding: 0; /* Remove default padding if any */
}
.support-faqs-section .left-column-page3 {
    width: 48%; /* Adjust as needed */
    padding-right: 2%; /* Create a gutter */
}
.support-faqs-section .right-column-page3 {
    width: 48%;
    padding-left: 2%; /* Create a gutter */
}

.support-faqs-section .section {
    margin-bottom: 15px; /* Space between major sections */
}

.support-faqs-section .section-heading { /* For "Support", "Bill FAQs", "Descriptions" */
    font-size: 12pt; /* Main section headings */
    color: #0066cc; /* Spectrum blue */
    margin-bottom: 8px;
    font-weight: bold; /* Make these main headings bold */
    padding-top: 6px; /* Add a bit of space above if it's not the first section */
}
.support-faqs-section .section:first-child .section-heading {
    padding-top: 0; /* No extra top padding for the very first section heading */
}


.support-faqs-section p {
    margin-top: 0;
    margin-bottom: 8px; /* Consistent paragraph spacing */
    color: #000000; /* Pure black for text */
}

.support-faqs-section p .sub-heading,
.support-faqs-section .sub-heading { /* For "How do billing cycles work?", "Taxes and Fees" etc. */
    font-weight: bold;
    color: #000000; /* Black and bold for these sub-titles */
    display: block; /* Ensures it's on its own line before the paragraph */
    margin-bottom: 3px; /* Small space after the sub-heading */
    font-size: 9pt; /* Slightly larger than paragraph text */
}

/* Specifically for the right column (legal text) to make it denser if needed */
.support-faqs-section .right-column-page3 .section p {
    font-size: 8pt; /* Consistent with main text */
    line-height: 1.3;
    margin-bottom: 6px;
}
.support-faqs-section .right-column-page3 .section p .sub-heading {
    font-size: 8pt; /* Sub-headings in legal text */
    display: inline; /* Keep these inline with the paragraph start */
    margin-right: 4px;
}


.support-faqs-section a {
    color: #0066cc;
    text-decoration: none;
}
.support-faqs-section a:hover { /* Hover won't show in PDF, but good for HTML preview */
    text-decoration: underline;
}

.support-faqs-section .bold {
    font-weight: bold;
}
.support-faqs-section .brand-blue-text {
    color: #0066cc;
}
    </style>
</head>
<body>
    {{-- Fixed Header Content (repeats on each page) --}}
    <div class="header-fixed">
        <table class="no-border header-table-main">
            <tr>
                <td class="header-logo-cell">
                    @if(isset($siteLogoUrl) && $siteLogoUrl)
                        <img src="{{ $siteLogoUrl }}" alt="{{ $companySettings['site_name'] ?? 'Logo' }}" class="header-logo">
                    @else
                        <div style="font-size: 14pt; font-weight: bold; color: #0067b2;">{{ $companySettings['site_name'] ?? 'Spectrum' }}</div>
                    @endif
                </td>
                <td class="header-details-cell">
                    <table class="no-border header-details-table">
                        <tr><td class="label">ACCOUNT NUMBER</td><td class="value">{{ $statement->user->account_number ?? 'N/A' }}</td></tr>
                        <tr><td class="label">STATEMENT DATE</td><td class="value">{{ $statement->formatted_statement_date }}</td></tr>
                        <tr><td class="label">SERVICE ADDRESS</td><td class="value">{{ $statement->user->address }}</td></tr>
                        <tr><td></td><td class="value">{{ $statement->user->city }}, {{ $statement->user->state }} {{ $statement->user->zip_code }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr style="border:0; border-top: 1px solid #ddd; margin-top: 5pt; margin-bottom: 0;"> {{-- Separator line --}}
    </div>

    {{-- Fixed Footer Content (repeats on each page) --}}
    <div class="footer-fixed"><div class="page-number"></div></div>

    {{-- Main Content Wrapper Table (DomPDF trick for header/footer spacing) --}}
    <table style="width:100%;">
        <thead>
            <tr><td><div class="page-header-placeholder"></div></td></tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{-- === PAGE 1 CONTENT === --}}
                    <div class="statement-page page-1-content">
                        <div class="greeting">Hi, {{ $statement->user->first_name ?? 'Valued Customer' }}!</div>

                        <table class="main-columns-table no-border">
                            <tr>
                                <td class="summary-box-column">
                                    <div class="summary-box">
                                        <div class="summary-box-header">
                                            <div class="amount-due-block">
                                                <span class="label">Amount Due</span>
                                                <span class="value">${{ number_format($statement->total_amount, 2) }}</span>
                                            </div>
                                            <div class="due-by-block">
                                                <span class="label">Due by</span>
                                                <span class="value {{ !($statement->due_date && $statement->total_amount > 0) ? 'do-not-pay' : (($statement->due_date < now()->subDay() && $statement->total_amount > 0 && ($statement->status ?? 'issued') !== 'paid') ? 'alert' : '') }}">
                                                    {{ ($statement->due_date && $statement->total_amount > 0) ? $statement->formatted_due_date : 'Do Not Pay' }}
                                                </span>
                                            </div>
                                            <div style="clear:both;"></div>
                                        </div>
                                        <div class="summary-details">
                                            <div class="title-bar">
                                                <span class="title">How It Adds Up</span>
                                                <span class="service-period">Service from {{ $statement->service_period_start ? \Carbon\Carbon::parse($statement->service_period_start)->format('M j') : 'N/A' }} - {{ $statement->service_period_end ? \Carbon\Carbon::parse($statement->service_period_end)->format('M j, Y') : 'N/A' }}</span>
                                            </div>
                                            <table>
                                                <tr><td>Previous Balance</td><td class="text-right">${{ number_format($statement->previous_balance ?? 0.00, 2) }}</td></tr>
                                                <tr><td>Payments Received</td><td class="text-right">-${{ number_format($statement->payments_received ?? 0.00, 2) }}</td></tr>
                                                <tr class="bold"><td>Remaining Balance</td><td class="text-right">${{ number_format(($statement->previous_balance ?? 0.00) - ($statement->payments_received ?? 0.00), 2) }}</td></tr>
                                            </table>
                                            <div class="current-activity-title">Current Activity</div>
                                            <table>
                                                @forelse($statement->items as $item)
                                                    <tr>
                                                        <td>{{ Str::limit($item->description, 35) }}</td>
                                                        <td class="text-right">${{ number_format($item->amount, 2) }}</td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="2" class="text-center" style="padding:8pt 0;">No current activity items.</td></tr>
                                                @endforelse
                                                <tr class="total-due-row">
                                                    <td>Amount Due</td>
                                                    <td class="text-right">${{ number_format($statement->total_amount, 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                                <td class="info-column">
                                    <div class="section">
                                        <h4>IMPORTANT NEWS</h4>
                                        <p class="bold brand-blue-text">Enroll in Auto Pay today!</p>
                                        <p>{{ $companySettings['important_news_autopay_text'] ?? 'Spectrum Auto Pay is a convenient way to pay your bill on time every month without the hassle of buying stamps or writing checks. Visit' }} <a href="{{ $companySettings['autopay_url_link'] ?? '#' }}">{{ $companySettings['autopay_url_text'] ?? 'Spectrum.net/autopay' }}</a>.</p>
                                    </div>
                                    <hr class="section-divider">
                                    <div class="section">
                                        <h4>BEWARE OF PAYMENT SCAMS!</h4>
                                        <p>{{ $companySettings['scam_warning_text'] ?? 'Spectrum is dedicated to keeping you and your family safe online. Visit' }} <a href="{{ $companySettings['scam_security_url_link'] ?? '#' }}">{{ $companySettings['scam_security_url_text'] ?? 'Spectrum.net/securitycenter' }}</a> {{ $companySettings['scam_warning_suffix'] ?? 'for tools and solutions to keep your personal information secure.' }}</p>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <div class="promo-section">
                             <h3>Unlimited calling. Unlimited connections.</h3>
                             <p>Stay in touch with friends and family with unlimited<br>nationwide calling and 28 popular features.</p>
                             <p>Call <span class="bold brand-blue-text">{{ $companySettings['voice_contact_number'] ?? '1-877-470-6728' }}</span> to add Spectrum Voice®.</p>
                        </div>

                        <div class="payment-stub-wrapper">
                            <p class="payment-stub-detach-text">Detach the included payment stub and enclose it with a check made payable to Spectrum. If you have questions about your account, call us at {{ $companySettings['customer_service_main_phone'] ?? '(855) 757-7328' }}.</p>
                            <table class="no-border">
                                <tr>
                                    <td class="payment-stub-logo-container">
                                        @if(isset($siteLogoUrl) && $siteLogoUrl)
                                            <img src="{{ $siteLogoUrl }}" alt="{{ $companySettings['site_name'] ?? 'Logo' }}" class="payment-stub-logo">
                                        @else
                                            <h3 style="margin:0 0 8pt 0; font-size: 14pt; color: #0067b2; font-weight:bold;">{{ $companySettings['site_name'] ?? 'Spectrum' }}</h3>
                                        @endif
                                        <div class="payment-stub-return-address">
                                            <p class="payment-stub-warning">DO NOT SEND PAYMENTS TO THIS ADDRESS</p>
                                            <p>{{ $companySettings['do_not_send_payment_address_line1'] ?? '4145 S. FALKENBURG RD' }}</p>
                                            <p>{{ $companySettings['do_not_send_payment_address_line2'] ?? 'RIVERVIEW FL 33578-8652' }}</p>
                                        </div>
                                        <div class="payment-stub-barcode-text"> {{-- Text above user address on stub --}}
                                            {{ $barcodeDataStringForDisplay ?? ($statement->user->account_number ?? '').' NO RP 10 03112025 NNNNNNNN 01 992965' }}
                                        </div>
                                        <div class="payment-stub-user-address">
                                            <p class="bold">{{ $statement->user->account_holder_names ?? $statement->user->full_name }}</p>
                                            @if($statement->user->getSecondaryFullNameAttribute())
                                                <p class="bold">{{ $statement->user->getSecondaryFullNameAttribute() }}</p>
                                            @endif
                                            <p>{{ $statement->user->address }}</p>
                                            <p>{{ $statement->user->city }}, {{ $statement->user->state }} {{ $statement->user->zip_code }}</p>
                                        </div>
                                    </td>
                                    <td class="payment-stub-details-container">
                                        <table class="no-border payment-stub-details-table">
                                            <tr><td>Amount Due</td><td class="text-right bold">${{ number_format($statement->total_amount, 2) }}</td></tr>
                                            <tr class="due-by-value {{ ($statement->due_date && $statement->total_amount > 0) ? '' : 'do-not-pay' }}"><td>Due by</td><td class="text-right bold">{{ ($statement->due_date && $statement->total_amount > 0) ? $statement->formatted_due_date : 'Do Not Pay' }}</td></tr>
                                            <tr><td>Account Number</td><td class="text-right bold brand-blue-text">{{ $statement->user->account_number }}</td></tr>
                                        </table>
                                        <div class="payment-stub-payto-address">
                                            <p class="bold">Please send payment to:</p>
                                            <p>
                                                {{ $companySettings['pdf_payment_recipient_name'] ?? 'SPECTRUM' }}<br>
                                                {{ $companySettings['pdf_payment_address_line1'] ?? 'PO BOX 7186' }}<br>
                                                {{ $companySettings['pdf_payment_address_line2'] ?? 'PASADENA CA 91109-7186' }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            @if(isset($barcodeImageBase64) && $barcodeImageBase64)
                                <img src="data:image/png;base64,{{ $barcodeImageBase64 }}" alt="Payment Barcode" class="payment-stub-barcode-image">
                            @endif
                            <div class="payment-stub-barcode-text">
                                {{ $barcodeDataStringForDisplay ?? ($statement->user->account_number ?? '').'0026208385100000000' }}
                            </div>
                        </div>
                    </div>
                    {{-- END OF PAGE 1 CONTENT --}}

                    {{-- Conditional include for subsequent pages --}}
                    @if(true) {{-- Replace 'true' with actual condition if page 2+ are optional --}}
                        <div class="page-break"></div>
                        {{-- Page 2: Bill Details --}}
                        <div class="bill-details-page-content">
                             @include('pdfs.partials.bill_details', ['statement' => $statement, 'companySettings' => $companySettings])
                        </div>

                        <div class="page-break"></div>
                        {{-- Page 3: Support & FAQs --}}
                        <div class="support-faqs-page-content">
                             @include('pdfs.partials.support_faqs', ['statement' => $statement, 'companySettings' => $companySettings])
                        </div>
                    @endif

                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr><td><div class="page-footer-placeholder"></div></td></tr>
        </tfoot>
    </table>
</body>
</html>
