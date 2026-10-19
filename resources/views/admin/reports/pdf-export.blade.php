<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Report' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #1f2937;
            line-height: 1.6;
            background: white;
            padding: 40px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #ec4899;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #1f2937;
        }
        
        .header .period {
            font-size: 14px;
            color: #6b7280;
        }
        
        .header .generated {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 10px;
        }
        
        .summary-section {
            margin-bottom: 40px;
        }
        
        .summary-section h2 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1f2937;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 10px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .summary-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }
        
        .summary-card .value {
            font-size: 28px;
            font-weight: bold;
            color: #ec4899;
            margin-bottom: 5px;
        }
        
        .summary-card .label {
            font-size: 14px;
            color: #6b7280;
        }
        
        .transactions-section {
            margin-bottom: 40px;
        }
        
        .transactions-section h2 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1f2937;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        thead {
            background: #f3f4f6;
        }
        
        th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #1f2937;
            border-bottom: 2px solid #e5e7eb;
            font-size: 13px;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }
        
        tr:nth-child(even) {
            background: #f9fafb;
        }
        
        .amount {
            color: #059669;
            font-weight: 600;
        }
        
        .status-approved {
            display: inline-block;
            background: #d1fae5;
            color: #065f46;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .footer {
            margin-top: 60px;
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ec4899;
            margin-bottom: 20px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .summary-grid {
                page-break-inside: avoid;
            }
            
            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">📊 SUCCEZZ Analytics</div>
        <h1>{{ $title ?? 'Analytics Report' }}</h1>
        <div class="period">{{ $period ?? 'Report Period' }}</div>
        <div class="generated">Generated on {{ $generated_at ?? now()->format('M d, Y H:i:s') }}</div>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <h2>Summary</h2>
        <div class="summary-grid">
            <div class="summary-card">
                <div class="value">{{ config('app.currency_label', 'GHC') }} {{ number_format(($summary['total_revenue'] ?? 0) / 100, 2) }}</div>
                <div class="label">Total Revenue</div>
            </div>
            <div class="summary-card">
                <div class="value">{{ $summary['total_transactions'] ?? 0 }}</div>
                <div class="label">Transactions</div>
            </div>
            <div class="summary-card">
                <div class="value">{{ $summary['total_bookings'] ?? 0 }}</div>
                <div class="label">Bookings</div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    @if(isset($transactions) && $transactions->count() > 0)
    <div class="transactions-section">
        <h2>Recent Transactions (Latest 50)</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>#{{ $transaction->id }}</td>
                    <td>{{ $transaction->user?->name ?? 'N/A' }}</td>
                    <td class="amount">{{ config('app.currency_label', 'GHC') }} {{ number_format($transaction->amount / 100, 2) }}</td>
                    <td><span class="status-approved">{{ ucfirst($transaction->approval_status) }}</span></td>
                    <td>{{ $transaction->created_at?->format('M d, Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>This report was automatically generated by SUCCEZZ Drivers Agency Admin System</p>
        <p>© 2026 SUCCEZZ. All rights reserved.</p>
    </div>
</body>
</html>
