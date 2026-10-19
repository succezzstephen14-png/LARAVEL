@extends('layouts.admin')

@section('title', 'Edit Booking - SUCCEZZ Drivers Agency')

@section('page-title', 'Edit Booking')
@section('page-description', 'Modify booking details and approval status')

@section('styles')
<style>
    .admin-wrapper {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
        display: flex;
    }

    .admin-sidebar {
        width: 260px;
        background: white;
        padding: 2rem 1rem;
        border-radius: 24px 0 0 24px;
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.08);
        margin-right: 1rem;
    }

    .admin-sidebar h5 {
        margin-bottom: 1.5rem;
        font-weight: 700;
        color: #1f2937;
    }

    .admin-sidebar ul {
        list-style: none;
        padding: 0;
    }

    .admin-sidebar li {
        margin-bottom: 0.5rem;
    }

    .admin-sidebar a {
        display: block;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        text-decoration: none;
        color: #4b5563;
        transition: all 0.2s ease;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .admin-sidebar a:hover, .admin-sidebar a.active {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .admin-main-content {
        flex: 1;
        background: white;
        border-radius: 24px;
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.08);
        padding: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .admin-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .booking-info-panel {
        background: #f8fafc;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .booking-info-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .booking-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .booking-info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .booking-info-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .booking-info-value {
        font-size: 1rem;
        font-weight: 500;
        color: #1f2937;
    }

    .panel {
        background: white;
        border-radius: 24px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.06);
        padding: 1.75rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #ec4899;
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        justify-content: flex-end;
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

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    @media (max-width: 1280px) {
        .admin-wrapper {
            flex-direction: column;
        }

        .admin-sidebar {
            border-radius: 24px;
            margin-right: 0;
            margin-bottom: 1rem;
        }

        .admin-main-content {
            border-radius: 24px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-wrapper">
    <section class="admin-main-content">
        <div class="admin-header">
            <div>
                <p style="color: #475569; margin: 0 0 0.5rem 0;">Booking management</p>
                <h2><i class="fas fa-edit"></i> Edit Booking</h2>
            </div>
            <a href="{{ route('admin.bookings') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Bookings
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Validation errors:</strong>
                <ul style="margin: 0.5rem 0 0 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Booking Information -->
        <div class="booking-info-panel">
            <div class="booking-info-title">
                <i class="fas fa-info-circle"></i>
                Booking Details
            </div>
            <div class="booking-info-grid">
                <div class="booking-info-item">
                    <div class="booking-info-label">Customer</div>
                    <div class="booking-info-value">
                        @if($booking->guest_name)
                            {{ $booking->guest_name }} (Guest)
                        @else
                            {{ $booking->user?->name ?? 'Unknown' }}
                        @endif
                    </div>
                </div>
                <div class="booking-info-item">
                    <div class="booking-info-label">Email</div>
                    <div class="booking-info-value">
                        @if($booking->guest_email)
                            {{ $booking->guest_email }}
                        @else
                            {{ $booking->user?->email ?? 'N/A' }}
                        @endif
                    </div>
                </div>
                <div class="booking-info-item">
                    <div class="booking-info-label">Booking Date</div>
                    <div class="booking-info-value">{{ $booking->created_at->format('M d, Y H:i') }}</div>
                </div>
                <div class="booking-info-item">
                    <div class="booking-info-label">Location</div>
                    <div class="booking-info-value">{{ $booking->location ?? 'Not specified' }}</div>
                </div>
                <div class="booking-info-item">
                    <div class="booking-info-label">Start Time</div>
                    <div class="booking-info-value">
                        {{ $booking->start_time ? \Carbon\Carbon::parse($booking->start_time)->format('M d, Y H:i') : 'N/A' }}
                    </div>
                </div>
                <div class="booking-info-item">
                    <div class="booking-info-label">End Time</div>
                    <div class="booking-info-value">
                        {{ $booking->end_time ? \Carbon\Carbon::parse($booking->end_time)->format('M d, Y H:i') : 'N/A' }}
                    </div>
                </div>
                <div class="booking-info-item">
                    <div class="booking-info-label">Amount</div>
                    <div class="booking-info-value">
                        @if($booking->amount)
                            {{ config('app.currency_label', 'GHC') }} {{ number_format($booking->amount / 100, 2) }}
                        @else
                            N/A
                        @endif
                    </div>
                </div>
                <div class="booking-info-item">
                    <div class="booking-info-label">Type</div>
                    <div class="booking-info-value">
                        @if($booking->driver_id)
                            <i class="fas fa-user-tie"></i> Driver Booking
                        @elseif($booking->vehicle_id)
                            <i class="fas fa-car"></i> Vehicle Booking
                        @elseif($booking->recruitment_id)
                            <i class="fas fa-briefcase"></i> Recruitment
                        @else
                            <i class="fas fa-question-circle"></i> Other
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="panel">
            <form action="{{ route('admin.bookings.update-admin', $booking) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="status">Booking Status</label>
                    <select id="status" name="status" required>
                        <option value="pending" {{ old('status', $booking->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status', $booking->status) === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ old('status', $booking->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $booking->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="approval_status">Approval Status</label>
                    <select id="approval_status" name="approval_status" required>
                        <option value="pending" {{ old('approval_status', $booking->approval_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('approval_status', $booking->approval_status) === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('approval_status', $booking->approval_status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tracking_status">Tracking Status</label>
                    <select id="tracking_status" name="tracking_status">
                        <option value="">Not Set</option>
                        <option value="pending" {{ old('tracking_status', $booking->tracking_status) === 'pending' ? 'selected' : '' }}>Not Started</option>
                        <option value="assigned" {{ old('tracking_status', $booking->tracking_status) === 'assigned' ? 'selected' : '' }}>Assigned</option>
                        <option value="in_transit" {{ old('tracking_status', $booking->tracking_status) === 'in_transit' ? 'selected' : '' }}>In Progress</option>
                        <option value="arrived" {{ old('tracking_status', $booking->tracking_status) === 'arrived' ? 'selected' : '' }}>Arrived</option>
                        <option value="completed" {{ old('tracking_status', $booking->tracking_status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('tracking_status', $booking->tracking_status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.bookings') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection