<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $sale->invoice_number }}</title>
    <style>
        /* --- GLOBAL RESET --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eef2f6;
            margin: 0;
            padding: 40px;
            color: #334155;
            -webkit-print-color-adjust: exact;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-radius: 0;
            overflow: hidden;
            position: relative;
        }

        /* --- HEADER SECTION --- */
        .header {
            background: #1e293b;
            /* Dark Blue Professional Header */
            color: white;
            padding: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .invoice-badge {
            font-size: 14px;
            background: rgba(255, 255, 255, 0.1);
            padding: 5px 15px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        /* --- INFO GRID --- */
        .info-section {
            padding: 20px 40px 20px 40px;
            display: flex;
            justify-content: space-between;
        }

        .info-col h3 {
            font-size: 12px;
            text-transform: uppercase;
            color: #94a3b8;
            /* Muted Text */
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .info-col p {
            margin: 0;
            font-size: 15px;
            font-weight: 600;
            line-height: 1.5;
            color: #0f172a;
        }

        .meta-data {
            text-align: right;
        }

        /* --- TABLE --- */
        .table-container {
            padding: 20px 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            text-align: left;
            padding: 15px 10px;
            border-bottom: 2px solid #e2e8f0;
            font-size: 11px;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px 10px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #334155;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: 700;
        }

        /* --- TOTALS SECTION --- */
        .footer-section {
            display: flex;
            justify-content: space-between;
            padding: 20px 40px 40px 40px;
            align-items: flex-start;
        }

        .payment-info {
            font-size: 13px;
            color: #64748b;
            max-width: 40%;
        }

        .totals-box {
            width: 280px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }

        .grand-total {
            border-top: 2px solid #1e293b;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 20px;
            font-weight: 800;
            color: #1e293b;
            display: flex;
            justify-content: space-between;
        }

        /* --- PRINT BUTTON --- */
        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #1e293b;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .print-btn:hover {
            background: #0f172a;
            transform: translateY(-2px);
        }

        /* --- PRINT MEDIA QUERY --- */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .invoice-box {
                box-shadow: none;
                max-width: 100%;
            }

            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>

    <button onclick="window.print()" class="print-btn">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path
                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
            </path>
        </svg>
        Print Invoice
    </button>

    <div class="invoice-box">

        <div class="header">
            <div class="logo">NEXUS POS</div>
            <div class="invoice-badge">PAID</div>
        </div>

        <div class="info-section">
            <div class="info-col">
                <h3>Billed To</h3>
                @if($sale->customer)
                    <p>{{ $sale->customer->name }}</p>
                    <p style="font-weight: 400; font-size: 13px; color: #64748b;">{{ $sale->customer->phone }}</p>
                    <p style="font-weight: 400; font-size: 13px; color: #64748b;">{{ $sale->customer->address }}</p>
                @else
                    <p>Walk-in Customer</p>
                @endif
            </div>

            <div class="info-col meta-data">
                <h3>Invoice Details</h3>
                <p>#{{ $sale->invoice_number }}</p>
                <p style="font-weight: 400; font-size: 13px; color: #64748b;">Issued:
                    {{ $sale->created_at->format('M d, Y') }}</p>
                <p style="font-weight: 400; font-size: 13px; color: #64748b;">Time:
                    {{ $sale->created_at->format('h:i A') }}</p>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50%;">Description</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->details as $detail)
                        <tr>
                            <td>
                                <span
                                    style="display: block; font-weight: 600;">{{ optional($detail->product)->name ?? 'Item Removed' }}</span>
                                <span
                                    style="font-size: 12px; color: #94a3b8;">{{ optional($detail->product)->barcode ?? '-' }}</span>
                            </td>
                            <td class="text-right">${{ number_format($detail->price, 2) }}</td>
                            <td class="text-center">{{ $detail->qty }}</td>
                            <td class="text-right font-bold">${{ number_format($detail->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer-section">
            <div class="payment-info">
                <h3>Payment Info</h3>
                <p>Method: <strong
                        style="text-transform: uppercase; color: #1e293b;">{{ $sale->payment_method }}</strong></p>
                <p style="margin-top: 5px;">Cashier: {{ optional($sale->user)->name ?? 'System' }}</p>
                <p style="margin-top: 15px;">Thank you for your business.</p>
            </div>

            <div class="totals-box">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>${{ number_format($sale->total_amount, 2) }}</span>
                </div>
                @if($sale->discount > 0)
                    <div class="total-row" style="color: #ef4444;">
                        <span>Discount</span>
                        <span>-${{ number_format($sale->discount, 2) }}</span>
                    </div>
                @endif
                @if($sale->tax > 0)
                    <div class="total-row">
                        <span>Tax</span>
                        <span>${{ number_format($sale->tax, 2) }}</span>
                    </div>
                @endif

                <div class="grand-total">
                    <span>Total</span>
                    <span>${{ number_format($sale->final_total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

</body>

</html>