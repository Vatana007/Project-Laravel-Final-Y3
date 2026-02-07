<!DOCTYPE html>
<html>

<head>
    <title>Sales Report Print</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header">
        <h2>Sales Report</h2>
        <p>From: {{ $startDate }} To: {{ $endDate }}</p>
        <p><strong>Total Revenue: ${{ number_format($totalRevenue, 2) }}</strong> | Transactions:
            {{ $totalTransactions }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Cashier</th>
                <th>Payment</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $sale->invoice_number }}</td>
                    <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                    <td>{{ $sale->user->name ?? 'System' }}</td>
                    <td>{{ ucfirst($sale->payment_method) }}</td>
                    <td style="text-align: right;">${{ number_format($sale->final_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>