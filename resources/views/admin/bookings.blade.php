@extends('layouts.admin')

@section('title', 'Booking Management - SUCCEZZ Drivers Agency')

@section('page-title', 'Booking Management')
@section('page-description', 'Manage all bookings, approvals, and tracking information')

@section('styles')
<style>
    .bookings-wrapper {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
    }
    
    .bookings-header {
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
    
    .bookings-header h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .bookings-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .booking-stat {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-left: 4px solid;
    }
    
    .booking-stat.total { border-left-color: #ec4899; }
    .booking-stat.approved { border-left-color: #10b981; }
    .booking-stat.pending { border-left-color: #f59e0b; }
    .booking-stat.guest { border-left-color: #3b82f6; }
    
    .booking-stat-value {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .booking-stat-label {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 600;
    }
    
    .bookings-filters {
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
    
    .bookings-filters input,
    .bookings-filters select {
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.9rem;
    }
    
    .bookings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .booking-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .booking-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }
    
    .booking-card-header {
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    
    .booking-info-section {
        flex: 1;
    }
    
    .booking-customer {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .booking-location {
        font-size: 0.85rem;
        opacity: 0.9;
    }
    
    .booking-status-badge {
        display: inline-block;
        padding: 0.35rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }
    
    .booking-card-body {
        padding: 1.5rem;
    }
    
    .booking-detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.8rem;
        font-size: 0.9rem;
    }
    
    .booking-detail-label {
        font-weight: 600;
        color: #6b7280;
    }
    
    .booking-detail-value {
        color: #1f2937;
        font-weight: 500;
        text-align: right;
    }
    
    .booking-timeline {
        background: #f9fafb;
        padding: 1rem;
        border-radius: 10px;
        margin: 1rem 0;
        font-size: 0.85rem;
        border-left: 3px solid #ec4899;
    }
    
    .booking-timeline-item {
        margin-bottom: 0.5rem;
        color: #4b5563;
    }
    
    .booking-card-footer {
        padding: 1rem;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .booking-action-btn {
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
    
    .booking-action-btn.primary {
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
        color: white;
    }
    
    .booking-action-btn.success {
        background: #d1fae5;
        color: #065f46;
    }
    
    .booking-action-btn.danger {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .booking-action-btn:hover {
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

<!-- Bookings Export Modal -->
<div class="modal fade" id="exportBookingsModal" tabindex="-1" aria-labelledby="exportBookingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportBookingsModalLabel">Export Bookings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Export is available only in PDF format. Click Export to download bookings as a PDF.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="performBookingsExport()">Export</button>
            </div>
        </div>
    </div>
</div>

@section('content')
<div class="bookings-wrapper">
    <div class="container-max">
        <!-- Header -->
        <div class="bookings-header">
            <div>
                <h2><i class="fas fa-calendar-check"></i> Booking Management</h2>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button onclick="openExportBookingsModal()" class="btn btn-outline-primary">
                    <i class="fas fa-download"></i> Export
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-soft">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="bookings-stats">
            <div class="booking-stat total">
                <div class="booking-stat-value">{{ $bookings->total() }}</div>
                <div class="booking-stat-label">Total Bookings</div>
            </div>
            <div class="booking-stat approved">
                <div class="booking-stat-value">{{ $bookings->where('approval_status', 'approved')->count() }}</div>
                <div class="booking-stat-label">Approved</div>
            </div>
            <div class="booking-stat pending">
                <div class="booking-stat-value">{{ $bookings->where('approval_status', 'pending')->count() }}</div>
                <div class="booking-stat-label">Pending Approval</div>
            </div>
            <div class="booking-stat guest">
                <div class="booking-stat-value">{{ $bookings->where(function($q) { $q->whereNotNull('guest_name')->orWhereNotNull('guest_email'); })->count() }}</div>
                <div class="booking-stat-label">Guest Bookings</div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="bookings-filters">
            <input type="text" id="bookingSearch" placeholder="Search bookings..." style="flex: 1; min-width: 200px;">
            <select id="statusFilter" style="min-width: 130px;">
                <option value="">All Status</option>
                <option value="approved">Approved</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <select id="typeFilter" style="min-width: 130px;">
                <option value="">All Types</option>
                <option value="driver">Driver</option>
                <option value="vehicle">Vehicle</option>
                <option value="guest">Guest</option>
            </select>
            <button onclick="clearFilters()" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Clear
            </button>
        </div>
        
        <!-- Bookings Grid -->
        <div class="bookings-grid">
            @forelse($bookings as $booking)
            <div class="booking-card">
                <div class="booking-card-header">
                    <div class="booking-info-section">
                        <div class="booking-customer">
                            @if($booking->guest_name)
                                {{ $booking->guest_name }}
                            @else
                                {{ $booking->user?->name ?? 'Unknown' }}
                            @endif
                        </div>
                        <div class="booking-location">
                            <i class="fas fa-map-marker-alt"></i> 
                            {{ Str::limit($booking->location ?? 'Not specified', 30) }}
                        </div>
                    </div>
                    <span class="booking-status-badge">
                        @if($booking->approval_status === 'approved')
                            <i class="fas fa-check-circle"></i> Approved
                        @elseif($booking->approval_status === 'pending')
                            <i class="fas fa-clock"></i> Pending
                        @elseif($booking->approval_status === 'cancelled')
                            <i class="fas fa-ban"></i> Cancelled
                        @else
                            <i class="fas fa-times-circle"></i> Rejected
                        @endif
                    </span>
                </div>
                
                <div class="booking-card-body">
                    <div class="booking-detail-row">
                        <span class="booking-detail-label">Booking Date:</span>
                        <span class="booking-detail-value">{{ $booking->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="booking-detail-row">
                        <span class="booking-detail-label">Start Time:</span>
                        <span class="booking-detail-value">{{ $booking->start_time ? \Carbon\Carbon::parse($booking->start_time)->format('h:i A') : 'N/A' }}</span>
                    </div>
                    <div class="booking-detail-row">
                        <span class="booking-detail-label">End Time:</span>
                        <span class="booking-detail-value">{{ $booking->end_time ? \Carbon\Carbon::parse($booking->end_time)->format('h:i A') : 'N/A' }}</span>
                    </div>
                    <div class="booking-detail-row">
                        <span class="booking-detail-label">Type:</span>
                        <span class="booking-detail-value">
                            @if($booking->guest_name)
                                <i class="fas fa-user"></i> Guest
                            @elseif($booking->driver_id)
                                <i class="fas fa-user-tie"></i> Driver
                            @else
                                <i class="fas fa-car"></i> Vehicle
                            @endif
                        </span>
                    </div>
                    <div class="booking-detail-row">
                        <span class="booking-detail-label">Tracking:</span>
                        <span class="booking-detail-value">
                            @php
                                $trackingStatus = $booking->tracking_status ?? 'pending';
                                $colors = [
                                    'pending' => 'text-warning',
                                    'assigned' => 'text-info',
                                    'in_transit' => 'text-primary',
                                    'arrived' => 'text-success',
                                    'completed' => 'text-success',
                                    'cancelled' => 'text-danger'
                                ];
                            @endphp
                            <i class="fas fa-circle {{ $colors[$trackingStatus] ?? 'text-secondary' }}"></i>
                            {{ ucfirst(str_replace('_', ' ', $trackingStatus)) }}
                        </span>
                    </div>
                    
                    @if($booking->tracking_location)
                    <div class="booking-timeline">
                        <div class="booking-timeline-item">
                            <strong>Location:</strong> {{ $booking->tracking_location }}
                        </div>
                        @if($booking->tracking_updated_at)
                        <div class="booking-timeline-item">
                            <strong>Updated:</strong> {{ $booking->tracking_updated_at->diffForHumans() }}
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                
                <div class="booking-card-footer">
                    <button onclick="viewBookingDetails('{{ $booking->id }}')" class="booking-action-btn primary">
                        <i class="fas fa-eye"></i> View
                    </button>
                    <button onclick="editBooking('{{ $booking->id }}')" class="booking-action-btn primary" style="flex: 1; min-width: 80px;">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    @if($booking->approval_status === 'pending')
                        <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" style="flex: 1; min-width: 80px;" id="approveForm{{ $booking->id }}">
                            @csrf
                            <button type="button" class="booking-action-btn success" style="width: 100%;" onclick="showApprovalConfirmation('{{ $booking->id }}')">
                                <i class="fas fa-check"></i> Approve
                            </button>
                        </form>
                        <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" style="flex: 1; min-width: 80px;" id="rejectForm{{ $booking->id }}">
                            @csrf
                            <button type="button" class="booking-action-btn danger" style="width: 100%;" onclick="showRejectionConfirmation('{{ $booking->id }}')">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3 style="color: #1f2937;">No bookings found</h3>
                <p style="color: #9ca3af;">Booking requests will appear here.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($bookings->hasPages())
        <div class="pagination-wrapper">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function viewBookingDetails(id) {
        window.location.href = '/admin/bookings/' + id;
    }
    
    function editBooking(id) {
        window.location.href = '/admin/bookings/' + id + '/edit-admin';
    }
    
    function openExportBookingsModal() {
        const modalEl = document.getElementById('exportBookingsModal');
        if (!modalEl) return;
        if (typeof bootstrap === 'undefined') {
            // Fallback: only PDF supported
            window.location.href = `{{ route('admin.bookings.export') }}?format=pdf`;
            return;
        }
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }

    function performBookingsExport() {
        // Only PDF supported for bookings export
        const modalEl = document.getElementById('exportBookingsModal');
        const modal = (typeof bootstrap !== 'undefined') ? bootstrap.Modal.getInstance(modalEl) : null;
        if (modal) modal.hide();
        window.location.href = `{{ route('admin.bookings.export') }}?format=pdf`;
    }
    
    function clearFilters() {
        document.getElementById('bookingSearch').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('typeFilter').value = '';
    }

    let currentForm = null;
    let currentAction = null;

    function showApprovalConfirmation(bookingId) {
        currentForm = document.getElementById('approveForm' + bookingId);
        currentAction = 'approve';
        document.getElementById('confirmationMessage').textContent = 'Are you sure you want to approve this booking?';
        const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        modal.show();
    }

    function showRejectionConfirmation(bookingId) {
        currentForm = document.getElementById('rejectForm' + bookingId);
        currentAction = 'reject';
        document.getElementById('confirmationMessage').textContent = 'Are you sure you want to reject this booking?';
        const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        modal.show();
    }

    function submitConfirmation() {
        if (currentForm) {
            currentForm.submit();
        }
    }
</script>

<!-- Modern Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);">
            <div class="modal-header" style="border-bottom: none; padding: 2rem 2rem 1rem 2rem;">
                <h5 class="modal-title" id="confirmationModalLabel" style="font-weight: 700; font-size: 1.3rem; color: #1f2937;">
                    <i class="fas fa-exclamation-circle" style="color: #f59e0b; margin-right: 0.75rem;"></i>
                    Confirm Action
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem 2rem; color: #4b5563; font-size: 1rem; line-height: 1.6;">
                <p id="confirmationMessage" style="margin: 0;">Are you sure you want to proceed with this action?</p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #f0f4f8; padding: 1.5rem 2rem; gap: 0.75rem;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" id="confirmationButton" onclick="submitConfirmation()" style="border-radius: 8px; font-weight: 600; background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%); border: none; padding: 0.6rem 1.5rem;">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
