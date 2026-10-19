@extends('layouts.dashboard')

@section('title', 'My Bookings')

@section('content')
<div class="container-max content-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>My Bookings</h2>
            <p class="text-muted">View all your bookings and their status.</p>
        </div>
    </div>

    <!-- Status Filter Tabs -->
    <div class="mb-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#all" data-bs-toggle="tab">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#pending" data-bs-toggle="tab">Pending Approval</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#approved" data-bs-toggle="tab">Approved</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#rejected" data-bs-toggle="tab">Rejected</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <!-- All Bookings -->
        <div class="tab-pane fade show active" id="all">
            @forelse($bookings as $booking)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-2">
                                    @if($booking->booking_type === 'driver')
                                        <i class="fas fa-user-tie"></i>
                                        @if(auth()->user()->isAdmin() && $booking->driver)
                                            Booking with {{ $booking->driver->user->name }}
                                        @else
                                            Driver booking
                                        @endif
                                    @elseif($booking->booking_type === 'vehicle')
                                        <i class="fas fa-car"></i> {{ $booking->vehicle->year }} {{ $booking->vehicle->make }} {{ $booking->vehicle->model }}
                                    @else
                                        <i class="fas fa-briefcase"></i> Application for {{ $booking->recruitment->title }}
                                    @endif
                                </h5>
                                <p class="text-muted mb-1">
                                    <strong>Booking ID:</strong> #{{ $booking->id }} 
                                    | <strong>Date:</strong> {{ $booking->booking_date?->format('M d, Y') }}
                                </p>
                                @if($booking->location)
                                    <p class="text-muted mb-1">
                                        <i class="fas fa-map-marker-alt"></i> {{ $booking->location }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="mb-2">
                                    <span class="badge bg-{{ 
                                        $booking->approval_status === 'approved' ? 'success' : 
                                        ($booking->approval_status === 'rejected' ? 'danger' : 'warning')
                                    }}">
                                        {{ ucfirst($booking->approval_status) }}
                                    </span>
                                    <span class="badge bg-info">{{ ucfirst($booking->payment_status) }}</span>
                                </div>
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> You haven't made any bookings yet.
                </div>
            @endforelse
        </div>

        <!-- Pending Approval -->
        <div class="tab-pane fade" id="pending">
            @php
                $pending = $bookings->where('approval_status', 'pending');
            @endphp
            @forelse($pending as $booking)
                <div class="card mb-3 border-warning">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-2">
                                    @if($booking->booking_type === 'driver')
                                        <i class="fas fa-user-tie"></i>
                                        @if(auth()->user()->isAdmin() && $booking->driver)
                                            Booking with {{ $booking->driver->user->name }}
                                        @else
                                            Driver booking
                                        @endif
                                    @elseif($booking->booking_type === 'vehicle')
                                        <i class="fas fa-car"></i> {{ $booking->vehicle->year }} {{ $booking->vehicle->make }}
                                    @else
                                        <i class="fas fa-briefcase"></i> {{ $booking->recruitment->title }}
                                    @endif
                                </h5>
                                <p class="text-muted">Awaiting admin approval...</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-warning">Pending Review</span>
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No pending bookings.
                </div>
            @endforelse
        </div>

        <!-- Approved -->
        <div class="tab-pane fade" id="approved">
            @php
                $approved = $bookings->where('approval_status', 'approved');
            @endphp
            @forelse($approved as $booking)
                <div class="card mb-3 border-success">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-2">
                                    @if($booking->booking_type === 'driver')
                                        <i class="fas fa-user-tie"></i>
                                        @if(auth()->user()->isAdmin() && $booking->driver)
                                            Booking with {{ $booking->driver->user->name }}
                                        @else
                                            Driver booking
                                        @endif
                                    @elseif($booking->booking_type === 'vehicle')
                                        <i class="fas fa-car"></i> {{ $booking->vehicle->year }} {{ $booking->vehicle->make }}
                                    @else
                                        <i class="fas fa-briefcase"></i> {{ $booking->recruitment->title }}
                                    @endif
                                </h5>
                                <p class="text-success mb-1">
                                    <i class="fas fa-check-circle"></i> Approved {{ $booking->approved_at?->diffForHumans() }}
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-success">Approved</span>
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No approved bookings.
                </div>
            @endforelse
        </div>

        <!-- Rejected -->
        <div class="tab-pane fade" id="rejected">
            @php
                $rejected = $bookings->where('approval_status', 'rejected');
            @endphp
            @forelse($rejected as $booking)
                <div class="card mb-3 border-danger">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-2">
                                    @if($booking->booking_type === 'driver')
                                        <i class="fas fa-user-tie"></i>
                                        @if(auth()->user()->isAdmin() && $booking->driver)
                                            Booking with {{ $booking->driver->user->name }}
                                        @else
                                            Driver booking
                                        @endif
                                    @elseif($booking->booking_type === 'vehicle')
                                        <i class="fas fa-car"></i> {{ $booking->vehicle->year }} {{ $booking->vehicle->make }}
                                    @else
                                        <i class="fas fa-briefcase"></i> {{ $booking->recruitment->title }}
                                    @endif
                                </h5>
                                @if($booking->rejection_reason)
                                    <p class="text-danger mb-1">
                                        <i class="fas fa-times-circle"></i> {{ $booking->rejection_reason }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-danger">Rejected</span>
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No rejected bookings.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
</div>

<script>
    // Show active tab from URL hash or history
    const hash = window.location.hash;
    if (hash) {
        const tab = document.querySelector('a[href="' + hash + '"]');
        if (tab) tab.click();
    }
</script>
@endsection
