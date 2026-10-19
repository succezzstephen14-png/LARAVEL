@extends('layouts.admin')

@section('title', 'Driver Applications - SUCCEZZ Drivers Agency')

@section('styles')
<style>
    .applications-wrapper {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
    }
    
    .applications-header {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .applications-header h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .applications-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .application-stat {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-left: 4px solid;
    }
    
    .application-stat.total { border-left-color: #06b6d4; }
    .application-stat.pending { border-left-color: #f59e0b; }
    .application-stat.approved { border-left-color: #10b981; }
    .application-stat.rejected { border-left-color: #ef4444; }
    
    .application-stat-value {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .application-stat-label {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 600;
    }
    
    .applications-filters {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .applications-filters input,
    .applications-filters select {
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.9rem;
    }
    
    .applications-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .application-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .application-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }
    
    .application-card-header {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    
    .application-name-section {
        flex: 1;
    }
    
    .application-name {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .application-email {
        font-size: 0.85rem;
        opacity: 0.9;
    }
    
    .application-status-badge {
        display: inline-block;
        padding: 0.35rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        text-transform: uppercase;
    }
    
    .application-card-body {
        padding: 1.5rem;
    }
    
    .application-detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.8rem;
        font-size: 0.9rem;
    }
    
    .application-detail-label {
        font-weight: 600;
        color: #6b7280;
    }
    
    .application-detail-value {
        color: #1f2937;
        font-weight: 500;
    }
    
    .application-timeline {
        background: #f9fafb;
        padding: 1rem;
        border-radius: 10px;
        margin: 1rem 0;
        font-size: 0.85rem;
        border-left: 3px solid #06b6d4;
    }
    
    .application-timeline-item {
        margin-bottom: 0.5rem;
        color: #4b5563;
    }
    
    .application-card-footer {
        padding: 1rem;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .application-action-btn {
        flex: 1;
        min-width: 80px;
        padding: 0.6rem 0.8rem;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }
    
    .application-action-btn.primary {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
    }
    
    .application-action-btn.success {
        background: #d1fae5;
        color: #065f46;
    }
    
    .application-action-btn.danger {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .application-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .empty-state {
        grid-column: 1 / -1;
        background: white;
        padding: 3rem;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    
    .empty-state-icon {
        font-size: 3.5rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    
    .pagination-wrapper {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
</style>
@endsection

@section('content')
<div class="applications-wrapper">
    <div class="container-max">
        <!-- Header -->
        <div class="applications-header">
            <div>
                <h2><i class="fas fa-file-alt"></i> Applications</h2>
                <p class="text-muted" style="margin: 0.5rem 0 0 0;">View and review user recruitment applications here.</p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-soft">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="applications-stats">
            <div class="application-stat total">
                <div class="application-stat-value">{{ $applications->count() }}</div>
                <div class="application-stat-label">Total Applications</div>
            </div>
            <div class="application-stat pending">
                <div class="application-stat-value">{{ $applications->where('approval_status', 'pending')->count() }}</div>
                <div class="application-stat-label">Pending Review</div>
            </div>
            <div class="application-stat approved">
                <div class="application-stat-value">{{ $applications->where('approval_status', 'approved')->count() }}</div>
                <div class="application-stat-label">Approved</div>
            </div>
            <div class="application-stat rejected">
                <div class="application-stat-value">{{ $applications->where('approval_status', 'rejected')->count() }}</div>
                <div class="application-stat-label">Rejected</div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="applications-filters">
            <input type="text" id="applicationSearch" placeholder="Search applications..." style="flex: 1; min-width: 200px;">
            <select id="statusFilter" style="min-width: 130px;">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
            <button onclick="clearFilters()" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Clear
            </button>
        </div>
        
        <!-- Applications Grid -->
        <div class="applications-grid">
            @forelse($applications as $booking)
            <div class="application-card">
                <div class="application-card-header">
                    <div class="application-name-section">
                        <div class="application-name">{{ $booking->user?->name ?? 'Applicant' }}</div>
                        <div class="application-email">{{ $booking->user?->email ?? 'No email' }}</div>
                    </div>
                    <span class="application-status-badge">
                        @if($booking->approval_status === 'approved')
                            <i class="fas fa-check"></i> Approved
                        @elseif($booking->approval_status === 'pending')
                            <i class="fas fa-clock"></i> Pending
                        @else
                            <i class="fas fa-times"></i> Rejected
                        @endif
                    </span>
                </div>
                
                <div class="application-card-body">
                    <div class="application-detail-row">
                        <span class="application-detail-label">Application ID:</span>
                        <span class="application-detail-value">{{ $booking->id }}</span>
                    </div>
                    <div class="application-detail-row">
                        <span class="application-detail-label">Submitted:</span>
                        <span class="application-detail-value">{{ $booking->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="application-detail-row">
                        <span class="application-detail-label">Type:</span>
                        <span class="application-detail-value">
                            @if($booking->driver_id)
                                <i class="fas fa-user-tie"></i> Driver
                            @else
                                <i class="fas fa-car"></i> Vehicle
                            @endif
                        </span>
                    </div>
                    <div class="application-detail-row">
                        <span class="application-detail-label">Location:</span>
                        <span class="application-detail-value">{{ Str::limit($booking->location ?? 'Not specified', 20) }}</span>
                    </div>
                    <div class="application-detail-row">
                        <span class="application-detail-label">Role:</span>
                        <span class="application-detail-value">{{ $booking->application_role ? ucfirst(str_replace('_', ' ', $booking->application_role)) : 'N/A' }}</span>
                    </div>
                    <div class="application-detail-row">
                        <span class="application-detail-label">Contact:</span>
                        <span class="application-detail-value">{{ $booking->user?->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="application-detail-row">
                        <span class="application-detail-label">Documents:</span>
                        <span class="application-detail-value">{{ is_array($booking->application_documents) ? count($booking->application_documents) : 0 }}</span>
                    </div>
                    
                    @if($booking->notes)
                    <div class="application-timeline">
                        <div class="application-timeline-item">
                            <strong>Notes:</strong><br>{{ Str::limit($booking->notes, 100) }}
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="application-card-footer">
                    <button onclick="viewApplication('{{ $booking->id }}')" class="application-action-btn primary">
                        <i class="fas fa-eye"></i> View
                    </button>
                    @if($booking->approval_status === 'pending')
                        <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" style="flex: 1; min-width: 80px;" onsubmit="return confirm('Approve this application?')">
                            @csrf
                            <button type="submit" class="application-action-btn success" style="width: 100%;">
                                <i class="fas fa-check"></i> Approve
                            </button>
                        </form>
                        <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" style="flex: 1; min-width: 80px;" onsubmit="return confirm('Reject this application?')">
                            @csrf
                            <button type="submit" class="application-action-btn danger" style="width: 100%;">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3 style="color: #1f2937;">No applications found</h3>
                <p style="color: #9ca3af;">New driver applications will appear here.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($applications->hasPages())
        <div class="pagination-wrapper">
            {{ $applications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function viewApplication(id) {
        window.location.href = '/admin/bookings/' + id;
    }
    
    function clearFilters() {
        document.getElementById('applicationSearch').value = '';
        document.getElementById('statusFilter').value = '';
    }
</script>
@endsection
