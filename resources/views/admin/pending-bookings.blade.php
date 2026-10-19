@extends('layouts.admin')

@section('title', 'Pending Bookings')

@section('content')
<style>
    .admin-wrapper {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
    }
    .admin-header {
        background: white;
        padding: 1.5rem 2rem;
        border-radius: 24px;
        margin-bottom: 2rem;
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .admin-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
    }
    .bookings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .booking-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);
        border: 1px solid rgba(15, 23, 42, 0.06);
    }
    .booking-card-header {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        padding: 1.5rem;
    }
    .booking-card-header h5 {
        margin: 0;
        font-size: 1rem;
    }
    .pending-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.25);
        color: white;
        margin-top: 0.5rem;
    }
    .booking-card-body {
        padding: 1.5rem;
    }
    .booking-info {
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
    }
    .booking-info strong {
        color: #6b7280;
        display: inline-block;
        width: 120px;
    }
    .booking-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }
    .approve-btn {
        padding: 0.75rem 1rem;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .approve-btn:hover {
        background: #059669;
    }
    .reject-btn {
        padding: 0.75rem 1rem;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .reject-btn:hover {
        background: #dc2626;
    }
</style>

<div class="admin-wrapper">
    <div class="container-max">
        <div class="admin-header">
            <h2><i class="fas fa-calendar-check"></i> Pending Bookings</h2>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>

        @if($bookings->count() === 0)
            <div style="background: white; padding: 3rem 2rem; border-radius: 18px; text-align: center; box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);">
                <i class="fas fa-check-circle" style="font-size: 3rem; color: #10b981; margin-bottom: 1rem; display: block;"></i>
                <p style="color: #10b981; font-weight: 600; margin: 0; font-size: 1.1rem;">All pending bookings have been processed</p>
            </div>
        @else
            <div class="bookings-grid">
                @foreach($bookings as $booking)
                    <div class="booking-card">
                        <div class="booking-card-header">
                            <h5>📅 Booking #{{ $booking->id }}</h5>
                            <span class="pending-badge">⏳ Pending</span>
                        </div>
                        <div class="booking-card-body">
                            <div class="booking-info">
                                <strong>Passenger:</strong> {{ $booking->user?->name ?? $booking->guest_name ?? 'Guest' }}
                            </div>
                            <div class="booking-info">
                                <strong>Contact:</strong> {{ $booking->guest_email ?? $booking->user?->email ?? 'No email' }} | {{ $booking->guest_phone ?? $booking->user?->phone ?? 'No phone' }}
                            </div>
                            <div class="booking-info">
                                <strong>Date:</strong> {{ $booking->booking_date?->format('M d, Y') }}
                            </div>
                            @if($booking->start_time && $booking->end_time)
                                <div class="booking-info">
                                    <strong>Time:</strong> {{ $booking->start_time?->format('H:i') }} - {{ $booking->end_time?->format('H:i') }}
                                </div>
                            @endif
                            @if($booking->booking_type === 'driver' && $booking->driver)
                                <div class="booking-info">
                                    <strong>Driver:</strong> {{ $booking->driver->user->name }}
                                </div>
                            @endif
                            @if($booking->booking_type === 'vehicle' && $booking->vehicle)
                                <div class="booking-info">
                                    <strong>Vehicle:</strong> {{ $booking->vehicle->year }} {{ $booking->vehicle->make }} {{ $booking->vehicle->model }}
                                </div>
                            @endif
                            @if($booking->booking_type === 'recruitment' && $booking->recruitment)
                                <div class="booking-info">
                                    <strong>Opportunity:</strong> {{ $booking->recruitment->title }}
                                </div>
                            @endif
                            <div class="booking-info">
                                <strong>Status:</strong> <span style="color: #f59e0b; font-weight: 600;">{{ ucfirst($booking->status) }}</span>
                            </div>

                            <div class="booking-info" style="margin-top: 1rem;">
                                <a href="{{ route('admin.application.detail', $booking) }}" class="btn btn-outline-primary w-100" style="text-align: left;">View full application</a>
                            </div>
                            <div class="booking-actions">
                                <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" style="width: 100%;">
                                    @csrf
                                    <button type="submit" class="approve-btn w-100">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <button type="button" class="reject-btn w-100" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $booking->id }}">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </div>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $booking->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Booking</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="reason{{ $booking->id }}">Reason for rejection</label>
                                                    <textarea id="reason{{ $booking->id }}" name="rejection_reason" class="form-control" rows="4" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

