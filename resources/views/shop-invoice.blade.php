<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
            background-color: #f0f2f5;
            color: #333;
            font-size: 13px;
        }

        .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
        }

        .invoice-card {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e8e8e8;
        }

        .header {
            background-color: #e49000;
            color: #0000;
            padding: 20px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-padding {
            padding: 0 25px;
        }

        .invoice-details {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
        }

        .invoice-to-pay-to {
            padding: 0 25px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .company-details,
        .invoice-to,
        .pay-to {
            text-align: right;
        }

        .company-details .detail-line,
        .invoice-to .detail-line,
        .pay-to .detail-line {
            display: block;
            color: #555;
            line-height: 1.6;
        }

        .company-details .company-name,
        .invoice-to .strong,
        .pay-to .strong {
            color: #333;
            font-weight: 600;
        }

        .invoice-to .strong,
        .pay-to .strong {
            color: #e49000;
        }

        .table-section {
            padding: 0 25px;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th,
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #000000;
            text-align: left;
        }

        thead th {
            background-color: #e49000;
            border-bottom: 3px solid #000000;
            color: #000 !important;
            font-weight: 600;
        }

        tbody td {
            color: #555;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: 600;
            color: #333;
        }

        .summary-row {
            background-color: #e49000;
            color: #fff;
        }

        .invoice-footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            border-top: 1px solid #e8e8e8;
            font-size: 12px;
            color: #777;
            line-height: 1.5;
        }
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
                            <img class="logo" src="{{$logo}}" alt="logo"/>

                </div>
                <div style="background-color: #f59e0b;">
                    <div class="row align-items-center justify-content-between">

                        {{-- Left Side --}}
                        <div class="col-6" style="padding: 20px 25px;">
                            <div style="display: flex; flex-direction: column; gap: 12px;">

                                {{-- D2Home Text --}}
                                <div style="display: flex; align-items: center;">
                                    <span style="
                                        background-color: #e49000;
                                        color: white;
                                        font-weight: bold;
                                        font-size: 40px;
                                        padding: 0 8px;
                                    ">
                                        D2Home
                                    </span>
                                </div>

                                {{-- Contact Info --}}
                                <div>
                                    <span style="color: white; display: block; font-size: 14px;">
                                        <i class="fas fa-map-marker-alt"
                                            style="margin-right: 8px; font-size: 14px;"></i>
                                        <i class="bi bi-geo-alt"></i> {{ $companyDetails["addressLine1"] }}
                                    </span>
                                    @if (!empty($companyDetails["addressLine2"]))
                                        <span style="color: white; display: block; font-size: 14px;">
                                            <i class="fas fa-map-marker-alt"
                                                style="margin-right: 8px; font-size: 14px;"></i>
                                            <i class="bi bi-geo-alt"></i> {{ $companyDetails["addressLine2"] }}
                                        </span>
                                    @endif
                                    <span style="color: white; display: block; font-size: 14px;">
                                        <i class="fas fa-envelope" style="margin-right: 8px; font-size: 14px;"></i>
                                        <i class="bi bi-envelope"></i> {{ $companyDetails["email"] }}
                                    </span>
                                    <span style="color: white; display: block; font-size: 14px;">
                                        <i class="fas fa-phone" style="margin-right: 8px; font-size: 14px;"></i>
                                        <i class="bi bi-telephone"></i> {{ $companyDetails["phone"] }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Right Side (Logo) --}}
                        <div class=" col-4 d-flex justify-content-end text-end" style="height: 100%;">
                            <img src="{{ asset('images/image.png') }}" alt="D2Home Logo" style="
                                height: 150px;
                                width: 150px;
                                object-fit: cover;
                                display: block;
                            " />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-padding"><div class="divider"></div></div>

         <div class="row mb-4" style="padding: 0 25px;">

            {{-- Left Column --}}
            <div class="col-6">
                <div style="margin-bottom: 16px;">
                    <strong style="font-size: 14px;">Invoice No:</strong>
                    <span style="font-size: 14px; margin-left: 8px;">
                        {{ $invoiceMeta['invoiceNumber'] }}
                    </span>
                </div>

                <div style="margin-bottom: 8px;">
                    <strong style="font-size: 14px;">Invoice To:</strong>
                </div>

                <div style="margin-bottom: 8px;">
                    <span style="color: #f59e0b; font-weight: bold; font-size: 16px;">
                        {{  $shop->translation ? $shop->translation->title : ($shop->seller ? $shop->seller->firstname . ' ' . $shop->seller->lastname : 'N/A') }}
                    </span>
                </div>

                <div style="margin-bottom: 8px;">
                    <span style="font-size: 14px; display: block;">
                        Phone : {{ $shop->seller && $shop->phone ? $shop->phone : ($shop->phone ?: 'N/A') }}
                    </span>
                </div>

                <div>
                    <span style="font-size: 14px; display: block;">
                        Email:
                        {{ $shop->seller && $shop->seller->email ? $shop->seller->email : ($shop->email ?: 'N/A') }}
                    </span>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="col-6 text-end">
                <div style="margin-bottom: 16px;">
                    <strong style="font-size: 14px;">Invoice Date:</strong>
                    <span style="font-size: 14px; margin-left: 8px;">
                        {{ \Illuminate\Support\Carbon::createFromFormat('d/m/Y', $invoiceMeta['dateOfInvoice'])->format('d F Y') }}
                    </span>
                </div>

                <div style="margin-bottom: 8px;">
                    <strong style="font-size: 14px;">Pay To:</strong>
                </div>

                <div>
                    <span style="color: #f59e0b; font-weight: bold; font-size: 16px;">
                        {{$companyDetails['name']}}
                    </span>
                </div>

                <div>
                    <span style="font-size: 14px; display: block;">
                        {{$companyDetails['addressLine1']}}
                    </span>
                    <span style="font-size: 14px; display: block;">
                        {{$companyDetails['addressLine2']}}
                    </span>
                </div>
            </div>
        </div>

        <div class="content-padding financial-summary-section">
            <table>
                <thead style="color: #0000">
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
