@extends('layouts.admin')

@section('title', 'Admin Reports & Analytics')
@section('page-title', 'Reports & Analytics')
@section('page-description', 'Track platform performance and review key insights')

@section('content')
<style>
    .filter-section {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
    }
    
    .filter-section .filter-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    
    .filter-section .form-group {
        flex: 1;
        min-width: 200px;
    }
    
    .filter-section label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #475569;
    }
    
    .filter-section input,
    .filter-section select {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #cbd5e1;
        border-radius: 0.375rem;
        font-size: 0.875rem;
    }
    
    .export-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .export-buttons .btn {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }
    
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .summary-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1.5rem;
        text-align: center;
    }
    
    .summary-card .value {
        font-size: 1.875rem;
        font-weight: 700;
        color: #0ea5e9;
        margin: 0.5rem 0;
    }
    
    .summary-card .label {
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 500;
    }
    
    /* ===== TABLE STYLES ===== */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
        font-size: 0.85rem;
    }
    
    .data-table thead tr {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        color: white;
    }
    
    .data-table th {
        padding: 1rem 0.875rem;
        text-align: left;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.75rem;
    }
    
    .data-table td {
        padding: 0.875rem;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
    }
    
    .data-table tbody tr:hover {
        background: #f0f9ff !important;
        transition: background 0.2s ease;
    }
    
    .data-table tbody tr:nth-child(odd) {
        background: #ffffff;
    }
    
    .data-table tbody tr:nth-child(even) {
        background: #f9fafb;
    }
    
    .badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.7rem;
        font-weight: 700;
        white-space: nowrap;
        text-transform: uppercase;
    }
    
    .badge-approved {
        background: #dcfce7;
        color: #166534;
    }
    
    .badge-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .badge-rejected {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .badge-driver {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .badge-vehicle {
        background: #fce7f3;
        color: #be185d;
    }
    
    .badge-available {
        background: #dcfce7;
        color: #166534;
    }
    
    .badge-unavailable {
        background: #fed7aa;
        color: #92400e;
    }
    
    .badge-on-duty {
        background: #c7d2fe;
        color: #3730a3;
    }
    
    .amount-value {
        color: #0ea5e9;
        font-weight: 700;
        text-align: right;
    }
    
    .table-container {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    
    .table-footer {
        padding: 1rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        text-align: center;
    }
    
    .view-all-btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #7dd3fc;
        border-radius: 0.375rem;
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .view-all-btn:hover {
        background: #0ea5e9;
        color: white;
        border-color: #0ea5e9;
        box-shadow: 0 4px 6px rgba(14, 165, 233, 0.2);
    }
    
    .text-truncate {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: block;
    }
    
    /* Chart Container - Prevents expansion */
    .chart-container {
        position: relative;
        height: 250px;
        width: 100%;
        margin-top: 1rem;
        overflow: hidden;
    }
    
    .chart-container canvas {
        max-height: 250px !important;
    }
</style>

<!-- Filter Section -->
<div class="admin-row">
    <div class="admin-card" style="grid-column: span 12;">
        <div class="filter-section">
            <div class="section-header" style="margin-bottom: 1rem;">
                <h3>Filters & Export</h3>
            </div>
            
            <div class="filter-group">
                <div class="form-group">
                    <label for="start-date">Start Date</label>
                    <input type="date" id="start-date" value="{{ date('Y-m-01') }}" />
                </div>
                <div class="form-group">
                    <label for="end-date">End Date</label>
                    <input type="date" id="end-date" value="{{ date('Y-m-d') }}" />
                </div>
                <div class="form-group">
                    <label for="group-by">Group By</label>
                    <select id="group-by">
                        <option value="month">Month</option>
                        <option value="week">Week</option>
                        <option value="day">Day</option>
                    </select>
                </div>
                <button class="btn btn-primary" onclick="applyFilters()" style="align-self: flex-end;">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
                <button class="btn btn-soft" onclick="resetFilters()" style="align-self: flex-end;">
                    <i class="fas fa-redo"></i> Reset
                </button>
            </div>
            
            <div class="export-buttons" style="margin-top: 1rem;">
                <button class="btn btn-info" onclick="openExportReportModal()" title="Export report as PDF">
                    <i class="fas fa-file-pdf"></i> Export (PDF)
                </button>
                <button class="btn btn-primary" onclick="printReport()" title="Print the report">
                    <i class="fas fa-print"></i> Print
                </button>
                <button type="button" class="btn btn-soft" onclick="openReportSettingsModal()" title="Report settings">
                    <i class="fas fa-cog"></i> Settings
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Report content wrapper (used for printing/export) -->
<div id="reportContent">

<!-- Summary Cards -->
<div class="admin-row">
    <div class="admin-card" style="grid-column: span 12;">
        <div class="section-header">
            <h3>Summary Statistics</h3>
            <p>Key metrics for the selected period</p>
        </div>
        
        <div class="summary-cards">
            <div class="summary-card">
                <div class="label">Total Revenue</div>
                <div class="value" id="total-revenue">{{ config('app.currency_label', 'GHC') }} 0.00</div>
            </div>
            <div class="summary-card">
                <div class="label">Total Transactions</div>
                <div class="value" id="total-transactions">0</div>
            </div>
            <div class="summary-card">
                <div class="label">Total Bookings</div>
                <div class="value" id="total-bookings">0</div>
            </div>
            <div class="summary-card">
                <div class="label">Approved Drivers</div>
                <div class="value" id="approved-drivers">0</div>
            </div>
            <div class="summary-card">
                <div class="label">Approved Vehicles</div>
                <div class="value" id="approved-vehicles">0</div>
            </div>
            <div class="summary-card">
                <div class="label">Pending Approvals</div>
                <div class="value" id="pending-approvals">0</div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards (Original) -->
<div class="admin-row">
    <div class="admin-card" style="grid-column: span 12;">
        <div class="section-header">
            <div>
                <h3>Live Analytics Dashboard</h3>
                <p>Real-time platform metrics and performance insights.</p>
            </div>
            <div class="d-flex gap-2">
                <button onclick="refreshAnalytics()" class="btn btn-primary">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-soft">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Live Stats Cards -->
        <div class="admin-grid">
            <div class="stat-card">
                <div class="stat-label">New Users Today</div>
                <div class="stat-value" id="new-users-today">{{ $stats['total_users'] }}</div>
                <div class="stat-note">Users registered today</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">New Bookings Today</div>
                <div class="stat-value" id="new-bookings-today">{{ $stats['total_bookings'] }}</div>
                <div class="stat-note">Bookings created today</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pending Approvals</div>
                <div class="stat-value" id="pending-count">{{ $stats['pending_approvals'] }}</div>
                <div class="stat-note">Awaiting admin review</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Active Drivers</div>
                <div class="stat-value" id="active-drivers">{{ $stats['total_drivers'] }}</div>
                <div class="stat-note">Available for booking</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Active Vehicles</div>
                <div class="stat-value" id="active-vehicles">{{ $stats['total_vehicles'] }}</div>
                <div class="stat-note">Ready for service</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Open Recruitments</div>
                <div class="stat-value">{{ $stats['open_recruitments'] }}</div>
                <div class="stat-note">Active job postings</div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="admin-row">
    <div class="admin-card" style="grid-column: span 6;">
        <div class="section-header">
            <h3>User Registration Trends</h3>
            <p>Monthly signup volume over the past year.</p>
        </div>
        <div class="chart-container">
            <canvas id="usersChart"></canvas>
        </div>
    </div>
    <div class="admin-card" style="grid-column: span 6;">
        <div class="section-header">
            <h3>Booking Activity</h3>
            <p>Monthly booking trends.</p>
        </div>
        <div class="chart-container">
            <canvas id="bookingsChart"></canvas>
        </div>
    </div>
</div>

<div class="admin-row">
    <div class="admin-card" style="grid-column: span 6;">
        <div class="section-header">
            <h3>Revenue Trends</h3>
            <p>Total revenue over time.</p>
        </div>
        <div class="chart-container">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
    <div class="admin-card" style="grid-column: span 6;">
        <div class="section-header">
            <h3>Revenue by Type</h3>
            <p>Distribution by payment type.</p>
        </div>
        <div class="chart-container">
            <canvas id="revenueTypeChart"></canvas>
        </div>
    </div>
</div>

<div class="admin-row">
    <div class="admin-card" style="grid-column: span 6;">
        <div class="section-header">
            <h3>Vehicle Types Distribution</h3>
            <p>Breakdown by vehicle category.</p>
        </div>
        <div class="chart-container">
            <canvas id="vehiclesChart"></canvas>
        </div>
    </div>
    <div class="admin-card" style="grid-column: span 6;">
        <div class="section-header">
            <h3>Driver Status Overview</h3>
            <p>Current driver availability status.</p>
        </div>
        <div class="chart-container">
            <canvas id="driversChart"></canvas>
        </div>
    </div>
</div>

<div class="admin-row">
    <div class="admin-card" style="grid-column: span 12;">
        <div class="section-header">
            <h3>Payment Status Distribution</h3>
            <p>Approval status of all payments in the system.</p>
        </div>
        <div class="chart-container">
            <canvas id="paymentsChart"></canvas>
        </div>
    </div>
</div>

<!-- Data Tables - LIMITED TO 3 ROWS EACH -->
<div class="admin-row">
    <div class="admin-card" style="grid-column: span 6;">
        <div class="section-header">
            <h3>Recent Transactions</h3>
            <p>Latest 3 approved payments</p>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 28%;">Date</th>
                        <th style="width: 18%;">Type</th>
                        <th style="width: 28%;">User</th>
                        <th style="width: 26%; text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody id="recent-transactions">
                    <tr><td colspan="4" style="text-align: center; padding: 2rem; color: #64748b;">Loading...</td></tr>
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <a href="{{ route('admin.pending-payments') }}" class="view-all-btn">→ View All Transactions</a>
        </div>
    </div>
    
    <div class="admin-card" style="grid-column: span 6;">
        <div class="section-header">
            <h3>Recent Drivers</h3>
            <p>Latest 3 registered drivers</p>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 35%;">Name</th>
                        <th style="width: 20%;">Status</th>
                        <th style="width: 22%;">Available</th>
                        <th style="width: 23%;">Date</th>
                    </tr>
                </thead>
                <tbody id="recent-drivers">
                    <tr><td colspan="4" style="text-align: center; padding: 2rem; color: #64748b;">Loading...</td></tr>
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <a href="{{ route('admin.drivers') }}" class="view-all-btn">→ View All Drivers</a>
        </div>
    </div>
</div>

<div class="admin-row">
    <div class="admin-card" style="grid-column: span 6;">
        <div class="section-header">
            <h3>Recent Vehicles</h3>
            <p>Latest 3 registered vehicles</p>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 35%;">Name</th>
                        <th style="width: 20%;">Status</th>
                        <th style="width: 22%;">Available</th>
                        <th style="width: 23%;">Date</th>
                    </tr>
                </thead>
                <tbody id="recent-vehicles">
                    <tr><td colspan="4" style="text-align: center; padding: 2rem; color: #64748b;">Loading...</td></tr>
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <a href="{{ route('admin.vehicles') }}" class="view-all-btn">→ View All Vehicles</a>
        </div>
    </div>
    
    <div class="admin-card" style="grid-column: span 6;">
        <div class="section-header">
            <h3>Recent Bookings</h3>
            <p>Latest 3 bookings</p>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 28%;">User</th>
                        <th style="width: 18%;">Type</th>
                        <th style="width: 27%;">Status</th>
                        <th style="width: 27%;">Date</th>
                    </tr>
                </thead>
                <tbody id="recent-bookings">
                    <tr><td colspan="4" style="text-align: center; padding: 2rem; color: #64748b;">Loading...</td></tr>
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <a href="{{ route('admin.bookings') }}" class="view-all-btn">→ View All Bookings</a>
        </div>
    </div>
</div>

        <!-- close reportContent -->
        </div>

        <!-- Export Modal -->
        <div class="modal fade" id="exportReportModal" tabindex="-1" aria-labelledby="exportReportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportReportModalLabel">Export Report (PDF)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Select an export format. The current filters will be applied.</p>
                        <div style="display:flex; gap:.5rem; margin-top:.5rem;">
                                <button class="btn btn-info" onclick="exportToPDF()"><i class="fas fa-file-pdf"></i> Export PDF</button>
                                <button class="btn btn-success" onclick="exportToExcel()"><i class="fas fa-file-excel"></i> Export Excel</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Modal (AJAX) -->
        <div class="modal fade" id="reportSettingsModal" tabindex="-1" aria-labelledby="reportSettingsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportSettingsModalLabel">Report Settings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="reportSettingsModalBody">
                        <p class="text-muted">Loading settings…</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        @endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
let usersChart, bookingsChart, vehiclesChart, driversChart, paymentsChart, revenueChart, revenueTypeChart;

document.addEventListener('DOMContentLoaded', function() {
    loadAnalyticsData();
    setInterval(loadAnalyticsData, 30000);
});

function getFilterParams() {
    return {
        start_date: document.getElementById('start-date').value,
        end_date: document.getElementById('end-date').value,
        group_by: document.getElementById('group-by').value,
    };
}

function loadAnalyticsData() {
    const params = getFilterParams();
    const queryString = new URLSearchParams(params).toString();
    
    Promise.all([
        fetch('{{ route('admin.analytics.data') }}').then(r => r.json()),
        fetch(`{{ route('admin.analytics.data-advanced') }}?${queryString}`).then(r => r.json())
    ])
    .then(([basicData, advancedData]) => {
        updateLiveStats(basicData.recent_activity);
        updateSummaryCards(advancedData.summary);
        updateCharts(basicData, advancedData);
        updateDataTables(advancedData);
    })
    .catch(error => {
        console.error('Error loading analytics data:', error);
    });
}

function updateLiveStats(activity) {
    if (activity) {
        document.getElementById('new-users-today').textContent = activity.new_users_today || 0;
        document.getElementById('new-bookings-today').textContent = activity.new_bookings_today || 0;
        document.getElementById('pending-count').textContent = activity.pending_approvals || 0;
        document.getElementById('active-drivers').textContent = activity.active_drivers || 0;
        document.getElementById('active-vehicles').textContent = activity.active_vehicles || 0;
    }
}

function updateSummaryCards(summary) {
    document.getElementById('total-revenue').textContent = @json(config('app.currency_label', 'GHC')) + ' ' + (summary.total_revenue || 0).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.getElementById('total-transactions').textContent = summary.total_transactions || 0;
    document.getElementById('total-bookings').textContent = summary.total_bookings || 0;
    document.getElementById('approved-drivers').textContent = summary.approved_drivers || 0;
    document.getElementById('approved-vehicles').textContent = summary.approved_vehicles || 0;
    document.getElementById('pending-approvals').textContent = summary.pending_approvals || 0;
}

function updateDataTables(data) {
    // Limit to 3 rows each
    const limit = 3;
    
    // Recent Transactions
    const transactionsHtml = data.recent_transactions.slice(0, limit).map(t => `
        <tr>
            <td><span style="font-size: 0.8rem; color: #64748b;">${t.date}</span></td>
            <td><span class="badge-status badge-pending">${t.type}</span></td>
            <td><span style="font-size: 0.8rem;">${t.user.substring(0, 20)}${t.user.length > 20 ? '...' : ''}</span></td>
            <td><span class="value-cell" style="text-align: right; display: block;">${t.amount}</span></td>
        </tr>
    `).join('');
    document.getElementById('recent-transactions').innerHTML = transactionsHtml || '<tr><td colspan="4" style="text-align: center; color: #64748b; padding: 1.5rem;">No data available</td></tr>';
    
    // Recent Drivers
    const driversHtml = data.recent_drivers.slice(0, limit).map(d => `
        <tr>
            <td><span style="font-size: 0.8rem; font-weight: 500;">${d.name.substring(0, 25)}${d.name.length > 25 ? '...' : ''}</span></td>
            <td><span class="badge-status badge-${d.status.toLowerCase()}">${d.status}</span></td>
            <td><span class="badge-status badge-${d.availability.toLowerCase()}">${d.availability}</span></td>
            <td><span style="font-size: 0.8rem; color: #64748b;">${d.date}</span></td>
        </tr>
    `).join('');
    document.getElementById('recent-drivers').innerHTML = driversHtml || '<tr><td colspan="4" style="text-align: center; color: #64748b; padding: 1.5rem;">No data available</td></tr>';
    
    // Recent Vehicles
    const vehiclesHtml = data.recent_vehicles.slice(0, limit).map(v => `
        <tr>
            <td><span style="font-size: 0.8rem; font-weight: 500;">${v.name.substring(0, 25)}${v.name.length > 25 ? '...' : ''}</span></td>
            <td><span class="badge-status badge-${v.status.toLowerCase()}">${v.status}</span></td>
            <td><span class="badge-status badge-${v.availability.toLowerCase()}">${v.availability}</span></td>
            <td><span style="font-size: 0.8rem; color: #64748b;">${v.date}</span></td>
        </tr>
    `).join('');
    document.getElementById('recent-vehicles').innerHTML = vehiclesHtml || '<tr><td colspan="4" style="text-align: center; color: #64748b; padding: 1.5rem;">No data available</td></tr>';
    
    // Recent Bookings
    const bookingsHtml = data.recent_bookings.slice(0, limit).map(b => `
        <tr>
            <td><span style="font-size: 0.8rem;">${b.user.substring(0, 20)}${b.user.length > 20 ? '...' : ''}</span></td>
            <td><span style="font-size: 0.8rem; font-weight: 500; text-transform: capitalize;">${b.type}</span></td>
            <td><span class="badge-status badge-${b.status.toLowerCase()}">${b.status}</span></td>
            <td><span style="font-size: 0.8rem; color: #64748b;">${b.date}</span></td>
        </tr>
    `).join('');
    document.getElementById('recent-bookings').innerHTML = bookingsHtml || '<tr><td colspan="4" style="text-align: center; color: #64748b; padding: 1.5rem;">No data available</td></tr>';
}

function updateCharts(basicData, advancedData) {
    // Users Chart
    if (usersChart) usersChart.destroy();
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    usersChart = new Chart(usersCtx, {
        type: 'line',
        data: {
            labels: basicData.users_by_month.map(item => item.month),
            datasets: [{
                label: 'New Users',
                data: basicData.users_by_month.map(item => item.count),
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14, 165, 233, 0.16)',
                tension: 0.35,
                fill: true,
                pointRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Bookings Chart
    if (bookingsChart) bookingsChart.destroy();
    const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    bookingsChart = new Chart(bookingsCtx, {
        type: 'line',
        data: {
            labels: basicData.bookings_by_month.map(item => item.month),
            datasets: [{
                label: 'Bookings',
                data: basicData.bookings_by_month.map(item => item.count),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.16)',
                tension: 0.35,
                fill: true,
                pointRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Revenue Chart
    if (revenueChart) revenueChart.destroy();
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: advancedData.revenue_by_period.map(item => item.period),
            datasets: [{
                label: 'Revenue ({{ config('app.currency_label', 'GHC') }})',
                data: advancedData.revenue_by_period.map(item => item.total_revenue),
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.16)',
                tension: 0.35,
                fill: true,
                pointRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Revenue Type Chart
    if (revenueTypeChart) revenueTypeChart.destroy();
    const revenueTypeCtx = document.getElementById('revenueTypeChart').getContext('2d');
    revenueTypeChart = new Chart(revenueTypeCtx, {
        type: 'doughnut',
        data: {
            labels: advancedData.revenue_by_type.map(item => item.type),
            datasets: [{
                data: advancedData.revenue_by_type.map(item => item.total_revenue),
                backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Vehicles Chart
    if (vehiclesChart) vehiclesChart.destroy();
    const vehiclesCtx = document.getElementById('vehiclesChart').getContext('2d');
    vehiclesChart = new Chart(vehiclesCtx, {
        type: 'doughnut',
        data: {
            labels: basicData.vehicles_by_type.map(item => item.vehicle_type || 'Unknown'),
            datasets: [{
                data: basicData.vehicles_by_type.map(item => item.count),
                backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Drivers Chart
    if (driversChart) driversChart.destroy();
    const driversCtx = document.getElementById('driversChart').getContext('2d');
    driversChart = new Chart(driversCtx, {
        type: 'bar',
        data: {
            labels: basicData.drivers_by_status.map(item => item.status),
            datasets: [{
                label: 'Drivers',
                data: basicData.drivers_by_status.map(item => item.count),
                backgroundColor: ['#0ea5e9', '#10b981', '#f59e0b', '#ef4444'],
                borderRadius: 12,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Payments Chart
    if (paymentsChart) paymentsChart.destroy();
    const paymentsCtx = document.getElementById('paymentsChart').getContext('2d');
    paymentsChart = new Chart(paymentsCtx, {
        type: 'pie',
        data: {
            labels: basicData.payments_by_status.map(item => item.approval_status),
            datasets: [{
                data: basicData.payments_by_status.map(item => item.count),
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#6b7280'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
}

function applyFilters() {
    loadAnalyticsData();
}

function resetFilters() {
    document.getElementById('start-date').value = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];
    document.getElementById('end-date').value = new Date().toISOString().split('T')[0];
    document.getElementById('group-by').value = 'month';
    loadAnalyticsData();
}

function exportToCSV() {
    // CSV export disabled — exports are PDF-only now.
    alert('CSV export is disabled. Please use the PDF Export option.');
}

function exportToPDF() {
    const params = getFilterParams();
    const queryString = new URLSearchParams(params).toString();
    window.location.href = `{{ route('admin.analytics.export-pdf') }}?${queryString}`;
}

function exportToExcel() {
    const params = getFilterParams();
    const queryString = new URLSearchParams(params).toString();
    window.location.href = `{{ route('admin.analytics.export-excel') }}?${queryString}`;
}

function openExportReportModal() {
    const modalEl = document.getElementById('exportReportModal');
    if (!modalEl) return;
    if (typeof bootstrap === 'undefined') {
        // fallback: directly export PDF
        exportToPDF();
        return;
    }
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}

function printReport() {
    const content = document.getElementById('reportContent');
    if (!content) { window.print(); return; }

    // Build a print window with stylesheets copied from the current document
    const printWindow = window.open('', '_blank', 'width=1000,height=800');
    if (!printWindow) { alert('Unable to open print window. Please allow popups.'); return; }

    const styles = Array.from(document.querySelectorAll('link[rel="stylesheet"], style')).map(el => el.outerHTML).join('');
    const title = document.title || 'Report';
    printWindow.document.write(`<!doctype html><html><head><meta charset="utf-8"><title>${title}</title>${styles}</head><body>`);
    printWindow.document.write(content.innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    // Give the new window a moment to render
    setTimeout(() => { printWindow.print(); printWindow.close(); }, 500);
}

function openReportSettingsModal() {
    const modalEl = document.getElementById('reportSettingsModal');
    const bodyEl = document.getElementById('reportSettingsModalBody');
    if (!modalEl || !bodyEl) {
        // fallback to route
        window.location.href = `{{ route('admin.report-settings') }}`;
        return;
    }

    if (typeof bootstrap === 'undefined') {
        window.location.href = `{{ route('admin.report-settings') }}`;
        return;
    }

    bodyEl.innerHTML = '<p class="text-muted">Loading settings…</p>';
    fetch(`{{ route('admin.report-settings') }}`)
        .then(r => r.text())
        .then(html => {
            bodyEl.innerHTML = html;
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        })
        .catch(err => {
            console.error('Failed to load settings:', err);
            // fallback to full page
            window.location.href = `{{ route('admin.report-settings') }}`;
        });
}

function refreshAnalytics() {
    const btn = event.target.closest('button');
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
    btn.disabled = true;

    loadAnalyticsData();
    
    setTimeout(() => {
        btn.innerHTML = originalHtml;
        btn.disabled = false;
    }, 500);
}
</script>
@endsection