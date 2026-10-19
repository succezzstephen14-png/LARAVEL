@extends('layouts.admin')

@section('title', 'Booking Details - SUCCEZZ Drivers Agency')

@section('page-title', 'Booking Details')
@section('page-description', 'View complete booking information and manage approval status')

@section('styles')
<style>
    .booking-detail-wrapper {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
    }

    .booking-detail-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f1f5f9;
    }

    .booking-title {
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }

    .booking-status-badges {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-approved { background: #d1fae5; color: #065f46; }
    .status-rejected { background: #fee2e2; color: #991b1b; }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-paid { background: #d1fae5; color: #065f46; }
    .status-unpaid { background: #fee2e2; color: #991b1b; }

    .info-section {
        margin-bottom: 2rem;
    }

    .info-section-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 500;
        color: #1f2937;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 2px solid #f1f5f9;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(236, 72, 153, 0.3);
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #1f2937;
    }

    .btn-secondary:hover {
        background: #d1d5db;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .alert-info {
        background: #dbeafe;
        color: #1d4ed8;
        border: 1px solid #93c5fd;
    }

    .tracking-info {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
    }

    .tracking-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .tracking-item:last-child {
        border-bottom: none;
    }

    .tracking-label {
        font-weight: 600;
        color: #374151;
    }

    .tracking-value {
        color: #6b7280;
    }
</style>
@endsection

@section('content')
<div class="booking-detail-wrapper">
    <div class="container-max">
        <!-- Header -->
        <div class="booking-detail-card">
            <div class="booking-header">
                <div>
                    <h1 class="booking-title">
                        <i class="fas fa-receipt"></i> Booking #{{ $booking->id }}
                    </h1>
                    <p style="color: #64748b; margin: 0.5rem 0 0 0;">
                        Created {{ $booking->created_at->format('M d, Y \a\t g:i A') }}
                    </p>
                </div>
                <div class="booking-status-badges">
                    <span class="status-badge status-{{ $booking->approval_status }}">
                        <i class="fas fa-{{ $booking->approval_status === 'approved' ? 'check-circle' : ($booking->approval_status === 'rejected' ? 'times-circle' : 'clock') }}"></i>
                        {{ ucfirst($booking->approval_status) }}
                    </span>
                    <span class="status-badge status-{{ $booking->payment_status === 'paid' ? 'paid' : 'unpaid' }}">
                        <i class="fas fa-{{ $booking->payment_status === 'paid' ? 'credit-card' : 'exclamation-triangle' }}"></i>
                        {{ ucfirst($booking->payment_status) }}
                    </span>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="info-section">
                <div class="info-section-title">
                    <i class="fas fa-user"></i>
                    Customer Information
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Customer Name</div>
                        <div class="info-value">
                            @if($booking->guest_name)
                                {{ $booking->guest_name }} <em>(Guest)</em>
                            @else
                                {{ $booking->user?->name ?? 'Unknown' }}
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">
                            @if($booking->guest_email)
                                {{ $booking->guest_email }}
                            @else
                                {{ $booking->user?->email ?? 'N/A' }}
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Phone</div>
                        <div class="info-value">
                            @if($booking->guest_phone)
                                {{ $booking->guest_phone }}
                            @else
                                {{ $booking->user?->phone ?? 'N/A' }}
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Booking Type</div>
                        <div class="info-value">{{ ucfirst($booking->booking_type ?? 'N/A') }}</div>
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="info-section">
                <div class="info-section-title">
                    <i class="fas fa-calendar-alt"></i>
                    Booking Details
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Booking Date</div>
                        <div class="info-value">{{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') : 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Start Time</div>
                        <div class="info-value">{{ $booking->start_time ? \Carbon\Carbon::parse($booking->start_time)->format('g:i A') : 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">End Time</div>
                        <div class="info-value">{{ $booking->end_time ? \Carbon\Carbon::parse($booking->end_time)->format('g:i A') : 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Location</div>
                        <div class="info-value">{{ $booking->location ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Application Role</div>
                        <div class="info-value">{{ $booking->application_role ? ucfirst(str_replace('_', ' ', $booking->application_role)) : 'N/A' }}</div>
                    </div>
                    @if($booking->description)
                    <div class="info-item" style="grid-column: 1 / -1;">
                        <div class="info-label">Description</div>
                        <div class="info-value">{{ $booking->description }}</div>
                    </div>
                    @endif
                </div>
            </div>

            @if($booking->application_documents && is_array($booking->application_documents) && count($booking->application_documents))
            <div class="info-section">
                <div class="info-section-title">
                    <i class="fas fa-file-alt"></i>
                    Application Documents
                </div>
                <div class="info-grid">
                    @foreach($booking->application_documents as $index => $document)
                        <div class="info-item">
                            <div class="info-label">{{ basename($document) }}</div>
                            <div class="info-value">
                                <a href="{{ route('admin.documents.show', ['type' => 'booking', 'id' => $booking->id, 'field' => 'application_documents', 'index' => $index]) }}" target="_blank" class="text-primary">View document</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Service Information -->
            @if($booking->driver)
            <div class="info-section">
                <div class="info-section-title">
                    <i class="fas fa-user-tie"></i>
                    Driver Information
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Driver Name</div>
                        <div class="info-value">{{ $booking->driver->user?->name ?? 'Unknown' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">License Number</div>
                        <div class="info-value">{{ $booking->driver->license_number ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Experience</div>
                        <div class="info-value">{{ $booking->driver->experience_years ?? 0 }} years</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Rating</div>
                        <div class="info-value">
                            @if($booking->driver->rating)
                                <i class="fas fa-star text-warning"></i> {{ number_format($booking->driver->rating, 1) }}
                            @else
                                Not rated
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($booking->vehicle)
            <div class="info-section">
                <div class="info-section-title">
                    <i class="fas fa-car"></i>
                    Vehicle Information
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Vehicle</div>
                        <div class="info-value">{{ $booking->vehicle->year }} {{ $booking->vehicle->make }} {{ $booking->vehicle->model }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">License Plate</div>
                        <div class="info-value">{{ $booking->vehicle->license_plate }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Type</div>
                        <div class="info-value">{{ ucfirst($booking->vehicle->vehicle_type) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Capacity</div>
                        <div class="info-value">{{ $booking->vehicle->capacity }} passengers</div>
                    </div>
                </div>
            </div>
            @endif

            @if($booking->recruitment)
            <div class="info-section">
                <div class="info-section-title">
                    <i class="fas fa-briefcase"></i>
                    Recruitment Information
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Job Title</div>
                        <div class="info-value">{{ $booking->recruitment->title }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Position Type</div>
                        <div class="info-value">{{ str_replace('_', ' ', ucfirst($booking->recruitment->position_type)) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Location</div>
                        <div class="info-value">{{ $booking->recruitment->location }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Salary Range</div>
                        <div class="info-value">
                            @if($booking->recruitment->salary_range_min && $booking->recruitment->salary_range_max)
                                {{ config('app.currency_label', 'GHC') }} {{ number_format($booking->recruitment->salary_range_min, 2) }} - {{ config('app.currency_label', 'GHC') }} {{ number_format($booking->recruitment->salary_range_max, 2) }}
                            @elseif($booking->recruitment->salary_range_min)
                                {{ config('app.currency_label', 'GHC') }} {{ number_format($booking->recruitment->salary_range_min, 2) }}+
                            @elseif($booking->recruitment->salary_range_max)
                                Up to {{ config('app.currency_label', 'GHC') }} {{ number_format($booking->recruitment->salary_range_max, 2) }}
                            @else
                                Negotiable
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Payment Information -->
            @if($booking->amount > 0)
            <div class="info-section">
                <div class="info-section-title">
                    <i class="fas fa-credit-card"></i>
                    Payment Information
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Amount</div>
                        <div class="info-value"><strong>{{ config('app.currency_label', 'GHC') }} {{ number_format($booking->amount / 100, 2) }}</strong></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Payment Status</div>
                        <div class="info-value">
                            <span class="status-badge status-{{ $booking->payment_status === 'paid' ? 'paid' : 'unpaid' }}">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>
                    </div>
                    @if($booking->payment_reference)
                    <div class="info-item">
                        <div class="info-label">Payment Reference</div>
                        <div class="info-value"><code>{{ $booking->payment_reference }}</code></div>
                    </div>
                    @endif
                    @if($booking->payment_date)
                    <div class="info-item">
                        <div class="info-label">Payment Date</div>
                        <div class="info-value">{{ $booking->payment_date->format('M d, Y g:i A') }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Tracking Information -->
            @if($booking->tracking_status || $booking->tracking_location)
            <div class="info-section">
                <div class="info-section-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Tracking Information
                </div>
                <div class="tracking-info">
                    <div class="tracking-item">
                        <span class="tracking-label">Status:</span>
                        <span class="tracking-value">{{ ucfirst(str_replace('_', ' ', $booking->tracking_status ?? 'Not set')) }}</span>
                    </div>
                    @if($booking->tracking_location)
                    <div class="tracking-item">
                        <span class="tracking-label">Location:</span>
                        <span class="tracking-value">{{ $booking->tracking_location }}</span>
                    </div>
                    @endif
                    @if($booking->tracking_updated_at)
                    <div class="tracking-item">
                        <span class="tracking-label">Last Updated:</span>
                        <span class="tracking-value">{{ $booking->tracking_updated_at->diffForHumans() }}</span>
                    </div>
                    @endif
                    @if($booking->tracking_notes)
                    <div class="tracking-item" style="flex-direction: column; align-items: flex-start; gap: 0.5rem;">
                        <span class="tracking-label">Notes:</span>
                        <span class="tracking-value">{{ $booking->tracking_notes }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Alerts -->
            @if($booking->approval_status === 'rejected' && $booking->rejection_reason)
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Rejection Reason:</strong>
                    <p style="margin: 0.5rem 0 0 0;">{{ $booking->rejection_reason }}</p>
                </div>
            </div>
            @endif

            @if($booking->approved_at)
            <div class="alert alert-info">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>Approved on:</strong> {{ $booking->approved_at->format('M d, Y \a\t g:i A') }}
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('admin.bookings') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Bookings
                </a>
                <a href="{{ route('admin.bookings.edit-admin', $booking) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Booking
                </a>
                @if($booking->approval_status === 'pending')
                <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" style="display: inline;" id="approveForm{{ $booking->id }}">
                    @csrf
                    <button type="button" class="btn btn-success" onclick="showApprovalConfirmation('{{ $booking->id }}')">
                        <i class="fas fa-check"></i> Approve
                    </button>
                </form>
                <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" style="display: inline;" id="rejectForm{{ $booking->id }}">
                    @csrf
                    <button type="button" class="btn btn-danger" onclick="showRejectionConfirmation('{{ $booking->id }}')">
                        <i class="fas fa-times"></i> Reject
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

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

<script>
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
@endsection