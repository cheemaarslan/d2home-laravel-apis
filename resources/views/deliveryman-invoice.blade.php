<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
            background-color: #f0f2f5;
            color: #333;
            font-size: 13px; /* Base font size */
        }
         .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
        }
        .invoice-card {
            max-width: 800px; /* Adjusted from 840px to fit common A4 better */
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: 1px solid #e8e8e8; /* Adding a light border for PDF */
        }
        .red-accent-bar {
            background-color: #e4002b;
            height: 8px;
            margin-bottom: 15px;
        }
        .content-padding {
            padding: 0 25px;
        }
        .invoice-header, .seller-invoice-meta-container {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping for smaller screens if ever viewed in browser */
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
        }
        .logo-area {
            flex: 1; /* Takes up available space */
            min-width: 250px; /* Minimum width */
        }
        .logo-text-main {
            font-size: 30px;
            font-weight: 700;
            color: #e4002b;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            display: inline; /* For span wrapping */
        }
        .logo-text-secondary {
            font-size: 30px;
            font-weight: 700;
            color: #262626;
            letter-spacing: 0.5px;
            margin-left: 2px;
            text-transform: uppercase;
            display: inline; /* For span wrapping */
        }
        .logo-text-secondary .light-char {
            font-weight: 400;
        }
        .company-details {
            flex: 1; /* Takes up available space */
            min-width: 250px; /* Minimum width */
            text-align: right;
        }
        .company-details .detail-line {
            display: block;
            color: #555;
            line-height: 1.6;
        }
        .company-details .company-name {
            color: #333;
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 4px;
        }
        .divider {
            border-top: 1px solid #e8e8e8;
            margin: 25px 0;
        }

        .seller-invoice-meta-column {
            width: 100%; /* Takes full width */
        }
        .seller-info {
            margin-bottom: 20px;
        }
        .seller-info .detail-line, .invoice-meta .detail-line {
            display: block;
            color: #555;
            line-height: 1.6;
        }
        .seller-info .strong, .invoice-meta .strong { /* For strong labels */
            color: #333;
            font-weight: 600;
        }
        .invoice-meta .invoice-number {
            color: #333;
            font-weight: 600;
            font-size: 18px;
            margin-top: 8px;
            display: block;
        }

        .financial-summary-section, .orders-overview-section {
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: separate; /* Use separate for border-spacing */
            border-spacing: 0;
            font-size: 13px;
        }
        th, td {
            padding: 10px 12px;
            border: 1px solid #e8e8e8;
            text-align: left;
        }
        thead tr {
            background-color: #fafafa;
        }
        th {
            color: #333;
            font-weight: 600;
        }
        td {
            color: #555;
        }
        /* Remove top border for subsequent rows for cleaner look */
        tbody tr td {
             border-top: none;
        }
        /* Ensure first row of tbody has a top border */
         tbody tr:first-child td {
            border-top: 1px solid #e8e8e8;
        }

        .text-right {
            text-align: right;
        }
        .font-bold {
            font-weight: 600;
            color: #333;
        }
        .font-final-total {
            font-size: 15px;
        }

        .notes-paragraph {
            margin-bottom: 25px;
            font-size: 12px;
            color: #777;
            line-height: 1.5;
        }
        .section-title {
            margin-bottom: 12px;
            color: #333;
            font-weight: 600;
            font-size: 16px; /* h5 equivalent */
        }
        .invoice-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            padding-bottom: 20px;
            border-top: 1px solid #e8e8e8;
            font-size: 12px;
            color: #777;
            line-height: 1.5;
        }
        /* Helper for text styles from React */
        .text-common { color: #555; line-height: 1.6; display: block; }
        .text-strong { color: #333; font-weight: 600; line-height: 1.6; display: block; }

    </style>
</head>
<body>
 @php
    // --- Static Company Details (as in React) ---
    $companyDetails = [
        'name' => 'D2Home',
        'addressLine1' => '10/12 Clarke St, Crows Nest NSW 2065, Australia',
        'addressLine2' => 'South Australia, 5047',
        'email' => 'info@d2home.com',
        'phone' => '+61 2 8103 1116',
        'abn' => '',
    ];

    // --- Dynamic Invoice Meta ---
    $invoiceMeta = [
        'invoiceNumber' => '01', // This was static; adjust if dynamic
        'dateOfInvoice' => \Illuminate\Support\Carbon::now()->translatedFormat('d F Y'),
        'billingPeriodStart' => 'N/A',
        'billingPeriodEnd' => 'N/A',
    ];

    // $orders is passed from your controller
    if ($orders && $orders instanceof \Illuminate\Support\Collection && $orders->count() > 0) {
        $orderDates = $orders->map(function ($order) {
            try {
                // Ensure there's a date to parse
                $dateToParse = $order->updated_at ?: $order->created_at;
                if ($dateToParse) {
                    return \Illuminate\Support\Carbon::parse($dateToParse);
                }
                return null; // No date available
            } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                // Log error or handle if necessary, return null for filtering
                report($e); // Optionally log the error
                return null;
            }
        })->filter() // Removes null values (from failed parsing or no date)
        ->all(); // Converts the collection to a plain array

        // Now $orderDates is an array of Carbon objects, or an empty array.
        // Check if the array is not empty before using min() and max().
        if (count($orderDates) > 0) {
            $minDate = min($orderDates);
            $maxDate = max($orderDates);
            $invoiceMeta['billingPeriodStart'] = $minDate->translatedFormat('d F Y');
            $invoiceMeta['billingPeriodEnd'] = $maxDate->translatedFormat('d F Y');
        }
        // If count($orderDates) is 0, billingPeriodStart/End remain 'N/A' as initialized.
    }

    // --- Financial Calculations (as per last React logic) ---
    $totalSales = $orders ? $orders->sum('total_price') : 0;
    // $total_commission is passed from controller (sum of order.commission_fee)
    $grossPlatformCommission = (float) ($total_commission ?? 0);

    // $sumOfOrderDiscounts is sum of order.total_discount
    $sumOfOrderDiscounts = $orders ? $orders->sum('total_discount') : 0;

    // This is the total amount (commission + discounts) considered as platform charges/deductions
    $totalChargesAndDiscountsByPlatform = $grossPlatformCommission + $sumOfOrderDiscounts;

    // This is the net amount payable to the seller
    $netAmountPayableToSeller = $totalSales - $totalChargesAndDiscountsByPlatform;

    $financialSummary = [
        'totalSales' => $totalSales,
        'grossPlatformCommission' => $grossPlatformCommission,
        'sumOfOrderDiscounts' => $sumOfOrderDiscounts,
        'totalChargesAndDiscountsByPlatform' => $totalChargesAndDiscountsByPlatform,
        'netAmountPayableToSeller' => $netAmountPayableToSeller,
    ];

    $financialTableRows = [
        ['desc' => 'Total Sale Amount', 'sub' => null, 'total' => $financialSummary['totalSales'], 'isBold' => false],
        ['desc' => 'D2Home Commission:', 'sub' => $financialSummary['grossPlatformCommission'], 'total' => null, 'isBold' => false],
        ['desc' => 'D2Home Discounts (platform promotions):', 'sub' => $financialSummary['sumOfOrderDiscounts'], 'total' => null, 'isBold' => false],
        ['desc' => 'Total D2Home Commission:', 'sub' => null, 'total' => $financialSummary['totalChargesAndDiscountsByPlatform'], 'isBold' => true],
        ['desc' => 'Sub Total:', 'sub' => null, 'total' => $financialSummary['netAmountPayableToSeller'], 'isBold' => true],
        ['desc' => 'The amount to be transferred:', 'sub' => null, 'total' => $financialSummary['netAmountPayableToSeller'], 'isBold' => true, 'isFinal' => true],
    ];
@endphp
    <div class="invoice-card">
        <div class="red-accent-bar"></div>
        
        <div class="content-padding">
            <div class="invoice-header">
                <div class="logo-area">
                            {{-- <img class="logo" src="{{$logo}}" alt="logo"/> --}}

                </div>
                <div class="company-details">
                    <span class="text-strong company-name">{{ $companyDetails['name'] }}</span>
                    <span class="text-common">{{ $companyDetails['addressLine1'] }}</span>
                    <span class="text-common">{{ $companyDetails['addressLine2'] }}</span>
                    <span class="text-common">{{ $companyDetails['email'] }}</span>
                    <span class="text-common">Tel.: {{ $companyDetails['phone'] }}</span>
                    <span class="text-common">ABN: {{ $companyDetails['abn'] }}</span>
                </div>
            </div>
        </div>

        <div class="content-padding"><div class="divider"></div></div>
       
        <div class="content-padding">
            <div class="seller-invoice-meta-container"> <div class="seller-invoice-meta-column">
                    <div class="seller-info">
                        <span class="text-strong">{{ $deliveryMan->relationLoaded('translation') && $deliveryMan->translation ? $deliveryMan->translation->title : ($deliveryMan->seller ? $deliveryMan->seller->firstname . ' ' . $deliveryMan->seller->lastname : 'N/A') }}</span>
                        <span class="text-common">Mobile: {{ $deliveryMan->phone ?: 'N/A' }}</span>
                        <span class="text-common">Email: {{ $deliveryMan->seller && $deliveryMan->seller->email ? $deliveryMan->seller->email : ($deliveryMan->email ?: 'N/A') }}</span>
                        <span class="text-common">Address: {{ $deliveryMan->relationLoaded('translation') && $deliveryMan->translation ? $deliveryMan->translation->address : 'N/A' }}</span>
                    </div>
                    <div class="invoice-meta">
                        <span class="text-common"><span class="strong">Date of invoice:</span> {{ $invoiceMeta['dateOfInvoice'] }}</span>
                        <span class="text-common"><span class="strong">Billing period:</span> [{{ $invoiceMeta['billingPeriodStart'] }}] - [{{ $invoiceMeta['billingPeriodEnd'] }}]</span>
                        <span class="invoice-number">INVOICE #{{ $invoiceMeta['invoiceNumber'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-padding financial-summary-section">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="text-right">Sub Total</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($financialTableRows as $index => $row)
                    <tr>
                        <td class="{{ $row['isBold'] ? 'font-bold' : '' }}">{{ $row['desc'] }}</td>
                        <td class="text-right">{{ $row['sub'] !== null ? '$' . number_format((float)$row['sub'], 2) : '' }}</td>
                        <td class="text-right {{ $row['isBold'] ? 'font-bold' : '' }} {{ isset($row['isFinal']) && $row['isFinal'] ? 'font-final-total' : '' }}">
                            {{ $row['total'] !== null ? '$' . number_format((float)$row['total'], 2) : '' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="content-padding">
            <p class="notes-paragraph">
                This credit will be credited to your account in the next few days BAN: Michael transferred.
                If you have any questions about your receipt, please contact our service center [{{ $companyDetails['email'] }}].
                Details of this invoice can be found on the attached page.
            </p>
        </div>

        <div class="content-padding orders-overview-section">
            <h3 class="section-title">Overview of individual orders - online payments</h3>
            <table>
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Order No.</th>
                        <th>Order Date</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $index => $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->id }}</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($order->updated_at ?: $order->created_at)->translatedFormat('d F Y') }}</td>
                        <td class="text-right font-bold">${{ number_format((float)$order->total_price, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">No orders found for this period.</td>
                    </tr>
                    @endforelse
                </tbody>
                @if ($orders->count() > 0)
                <tfoot>
                    <tr style="background-color: #fafafa;">
                        <td colspan="3" class="font-bold">Total:</td>
                        <td class="text-right font-bold">${{ number_format((float)$financialSummary['totalSales'], 2) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        <div class="content-padding">
            <div class="invoice-footer">
                Thank you for your business and your trust. It is our pleasure to work with you as a valued shop partner.
            </div>
        </div>
    </div>
</body>
</html>