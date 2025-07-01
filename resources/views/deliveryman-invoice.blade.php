<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVvj6u52u30wKp6M/trliBTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
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
            color: #fff;
            padding: 20px;
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
    <div class="invoice-card">
        <div class="content-padding">

            <!-- Header Section -->
            <div style="padding: 20px 25px; background-color: #f59e0b; color: white; overflow: hidden;">
                <div style="float: left; width: 70%; min-height: 120px;">
                    <div style="font-weight: bold; font-size: 40px; margin-bottom: 10px;">D2Home</div>

                    @if (!empty($companyDetails['addressLine1']))
                        <div style="font-size: 14px; margin-bottom: 5px;">{{ $companyDetails['addressLine1'] }}</div>
                    @endif

                    @if (!empty($companyDetails['addressLine2']))
                        <div style="font-size: 14px; margin-bottom: 5px;">{{ $companyDetails['addressLine2'] }}</div>
                    @endif

                    @if (!empty($companyDetails['email']))
                        <div style="font-size: 14px; margin-bottom: 5px;">{{ $companyDetails['email'] }}</div>
                    @endif

                    @if (!empty($companyDetails['phone']))
                        <div style="font-size: 14px;">{{ $companyDetails['phone'] }}</div>
                    @endif
                </div>

                <div style="float: right;">
                    <img src="{{ public_path('images/image.png') }}" alt="D2Home Logo"
                        style="height: 100px; width: 100px; object-fit: cover; border-radius: 50%;">
                </div>
                <div style="clear: both;"></div>
            </div>

            <div class="content-padding">
                <div class="divider"></div>
            </div>

            <!-- Invoice Details Section -->
            <div style="padding: 20px 25px; overflow: hidden; border-bottom: 1px solid #eee;">
                <div style="width: 100%; overflow: hidden;">
                    <!-- Left Side -->
                    <div style="float: left; width: 48%;">
                        <div style="margin-bottom: 15px;">
                            <strong style="font-size: 14px;">Invoice No:</strong>
                            <span style="font-size: 14px; margin-left: 8px;">#100{{ $invoiceMeta['invoiceNumber'] ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <strong style="font-size: 14px;">Invoice To:</strong>
                            <div style="color: #f59e0b; font-weight: bold; font-size: 16px; margin-top: 5px;">
                                {{ $deliveryMan->translation->title ?? ($deliveryMan ? $deliveryMan->firstname . ' ' . $deliveryMan->lastname : 'N/A') }}
                            </div>

                            <div style="font-size: 14px; margin-top: 5px;">
                                Phone: {{ $deliveryMan->phone ?? 'N/A' }}
                            </div>

                            <div style="font-size: 14px; margin-top: 5px;">
                                Email: {{ $deliveryMan->seller->email ?? ($deliveryMan->email ?? 'N/A') }}
                            </div>
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div style="float: right; width: 48%; text-align: right;">
                        <div style="margin-bottom: 15px;">
                            <strong style="font-size: 14px;">Invoice Date:</strong>
                            <span
                                style="font-size: 14px; margin-left: 8px;">{{ $invoiceMeta['dateOfInvoice'] ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <strong style="font-size: 14px;">Pay To:</strong>
                            <div style="color: #f59e0b; font-weight: bold; font-size: 16px; margin-top: 5px;">
                                {{ $companyDetails['name'] ?? 'D2Home' }}
                            </div>

                            @if (!empty($companyDetails['addressLine1']))
                                <div style="font-size: 14px; margin-top: 5px;">{{ $companyDetails['addressLine1'] }}
                                </div>
                            @endif

                            @if (!empty($companyDetails['addressLine2']))
                                <div style="font-size: 14px; margin-top: 5px;">{{ $companyDetails['addressLine2'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div style="clear: both;"></div>
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
                                <td class="text-right">
                                    {{ $row['sub'] !== null ? '$' . number_format((float) $row['sub'], 2) : '' }}
                                </td>
                                <td
                                    class="text-right {{ $row['isBold'] ? 'font-bold' : '' }} {{ isset($row['isFinal']) && $row['isFinal'] ? 'font-final-total' : '' }}">
                                    {{ $row['total'] !== null ? '$' . number_format((float) $row['total'], 2) : '' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="content-padding">
                <p class="notes-paragraph">
                    This credit will be credited to your account in the next few days BAN: Michael transferred.
                    If you have any questions about your receipt, please contact our service center
                    [{{ $companyDetails['email'] }}].
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
                                <td>{{ \Illuminate\Support\Carbon::parse($order->updated_at ?: $order->created_at)->translatedFormat('d F Y') }}
                                </td>
                                <td class="text-right font-bold">${{ number_format((float) $order->total_price, 2) }}
                                </td>
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
                                <td class="text-right font-bold">
                                    ${{ number_format((float) $financialSummary['totalSales'], 2) }}</td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            <div class="content-padding">
                <div class="invoice-footer">
                    Thank you for your business and your trust. It is our pleasure to work with you as a valued
                    deliveryMan partner.
                </div>
            </div>
        </div>
    </div>
</body>

</html>
