{{-- resources/views/pdfs/partials/bill_details.blade.php --}}
{{-- This is intended to be Page 2 content --}}

<div class="bill-details-page-content">
    {{-- Page Header (Static text, different from fixed repeating header) --}}
    <table class="no-border" style="margin-bottom: 15px;">
        <tr>
            <td style="width: 70%; vertical-align: bottom;">
                <h1 class="bill-details-title">Your Bill Details</h1>
            </td>
            <td style="width: 30%; text-align: right; font-size: 7pt; vertical-align: bottom;">
                Service from {{ $statement->service_period_start ? \Carbon\Carbon::parse($statement->service_period_start)->format('M j') : 'N/A' }} - {{ $statement->service_period_end ? \Carbon\Carbon::parse($statement->service_period_end)->format('M j, Y') : 'N/A' }}
            </td>
        </tr>
    </table>

    {{-- Main Bill Details Box --}}
    <div class="bill-details-box">
        <table class="activity-table">
            <thead>
                {{-- Previous Balance & Remaining Balance Header Row (Dark Blue) --}}
                <tr class="balance-header-row">
                    <th style="width: 80%; text-align: left; padding: 6px 8px;">Previous Balance</th>
                    <th style="width: 20%; text-align: right; padding: 6px 8px;">${{ number_format($statement->previous_balance ?? 0.00, 2) }}</th>
                </tr>
                <tr class="balance-header-row">
                    <th style="padding: 6px 8px;">Remaining Balance</th>
                    <th style="text-align: right; padding: 6px 8px;">${{ number_format(($statement->previous_balance ?? 0.00) - ($statement->payments_received ?? 0.00), 2) }}</th>
                </tr>
                {{-- Current Activity Header Row (Light Gray) --}}
                <tr class="activity-main-header-row">
                    <th colspan="2" style="padding: 8px; text-align:left; font-size:10pt;">Current Activity</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Conceptual grouping of items.
                    // For a real-world scenario, your StatementItem model should have a 'category'
                    // or you should pass pre-grouped items from the controller.
                    $groupedItems = $statement->items->groupBy(function($item) {
                        if (stripos($item->description, 'Community Solutions') !== false || stripos($item->description, 'TV Select') !== false || stripos($item->description, 'Disney+') !== false || stripos($item->description, 'ViX Premium') !== false || stripos($item->description, 'Paramount+') !== false || stripos($item->description, 'Max with Ads') !== false) return 'Community Solutions Services';
                        if (stripos($item->description, 'TV') !== false || stripos($item->description, 'Entertainment View') !== false || stripos($item->description, 'Sports View') !== false || stripos($item->description, 'Multi-dvr') !== false ) return 'Spectrum TV®';
                        if (stripos($item->description, 'Internet') !== false || stripos($item->description, 'WiFi') !== false || stripos($item->description, 'Gig') !== false) return 'Spectrum Internet®';
                        return 'Other Services'; // Default category
                    });

                    $categoryOrder = ['Community Solutions Services', 'Spectrum TV®', 'Spectrum Internet®', 'Other Services'];
                    $categoryTotals = [];
                @endphp

                @foreach ($categoryOrder as $categoryName)
                    @if(isset($groupedItems[$categoryName]) && $groupedItems[$categoryName]->isNotEmpty())
                        @php
                            $itemsInCategory = $groupedItems[$categoryName];
                            $categoryTotals[$categoryName] = $itemsInCategory->sum(function($item) {
                                // Only sum if not 'Included' (assuming 'notes' field or similar)
                                return (isset($item->notes) && strtolower(trim($item->notes)) === 'included') ? 0 : $item->amount;
                            });
                        @endphp
                        {{-- Category Header (e.g., Community Solutions Services) --}}
                        <tr class="category-title-row">
                            <td colspan="2" class="bold">{{ $categoryName }}</td>
                        </tr>
                        {{-- Items within the category --}}
                        @foreach ($itemsInCategory as $item)
                        <tr>
                            <td class="item-description">
                                {{ $item->description }}
                                {{-- Small note for "Included" items --}}
                                @if(isset($item->notes) && strtolower(trim($item->notes)) === 'included')
                                    <span class="included-note">Included</span>
                                @endif
                            </td>
                            <td class="item-amount text-right">
                                @if(isset($item->notes) && strtolower(trim($item->notes)) === 'included')
                                    {{-- Leave blank or explicitly state 'Included' if needed --}}
                                @else
                                    ${{ number_format($item->amount, 2) }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        {{-- Category Total --}}
                        <tr class="category-total-row">
                            <td class="bold text-right">{{ $categoryName }} Total</td>
                            <td class="bold text-right">${{ number_format($categoryTotals[$categoryName], 2) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                {{-- Amount Due Footer Row (Dark Blue) --}}
                <tr class="amount-due-footer-row">
                    <td class="bold" style="padding: 8px;">Amount Due</td>
                    <td class="bold text-right" style="padding: 8px;">${{ number_format($statement->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Ways to Pay & Store Info Section --}}
    <div class="ways-to-pay-section">
        <table class="no-border">
            <tr>
                <td style="width: 60%; vertical-align: top; padding-right: 15px;">
                    <h3 class="section-heading">Ways to Pay</h3>
                    <div class="payment-option">
                        <span class="payment-icon">💲</span> {{-- Replace with actual icon if possible or FontAwesome --}}
                        <span class="bold">Auto Pay:</span> Visit <a href="{{ $companySettings['autopay_url_link'] ?? '#' }}" class="brand-blue-text">{{ $companySettings['autopay_url_text'] ?? 'Spectrum.net/AutoPay' }}</a>. Auto Pay is the easiest way to pay your bill on time every month.
                    </div>
                    <div class="payment-option">
                        <span class="payment-icon">📱</span>
                        <span class="bold">App:</span> Pay your bill through the My Spectrum App.
                    </div>
                    <div class="payment-option">
                        <span class="payment-icon">💻</span>
                        <span class="bold">Online:</span> Pay your bill online at <a href="{{ $companySettings['online_billing_url_link'] ?? '#' }}" class="brand-blue-text">{{ $companySettings['online_billing_url_text'] ?? 'Spectrum.net' }}</a>.
                        Want to go paperless? Visit <a href="{{ $companySettings['paperless_url_link'] ?? '#' }}" class="brand-blue-text">{{ $companySettings['paperless_url_text'] ?? 'Spectrum.net/billing' }}</a>.
                    </div>
                    <div class="payment-option">
                        <span class="payment-icon">📞</span>
                        <span class="bold">Phone:</span> Call the automated payment service at <a href="tel:{{ $companySettings['phone_payment_number_tel'] ?? '8332676097' }}" class="brand-blue-text">{{ $companySettings['phone_payment_number_display'] ?? '(833) 267-6097' }}</a>.
                    </div>
                </td>
                <td style="width: 40%; vertical-align: top; background-color: #f8f9fa; padding: 12px; border-radius: 4px;">
                    <h3 class="section-heading"><span class="payment-icon">📍</span> Store</h3>
                    <p class="store-address">
                        {{ $companySettings['store_address_line1'] ?? '557 N Afalaya Tr, Ste J03B' }}<br>
                        {{ $companySettings['store_address_line2'] ?? 'Orlando, FL 32828' }}
                    </p>
                    <p class="store-hours">{{ $companySettings['store_hours_display'] ?? 'Store Hours: Mon thru Sat - 10:00am to 8:00pm; Sun - 12:00pm to 5:00pm' }}</p>
                    <p><a href="{{ $companySettings['store_locator_url_link'] ?? '#' }}" class="brand-blue-text">Visit {{ $companySettings['store_locator_url_text'] ?? 'Spectrum.com/stores' }} for additional locations and hours.</a></p>
                </td>
            </tr>
        </table>
    </div>
</div>