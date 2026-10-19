@extends('layouts.app')

@section('title', 'Book ' . ucfirst($bookingType))

@section('content')
<div class="container-max content-section">
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-calendar-plus"></i> Book {{ ucfirst($bookingType) }}</h4>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-5">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h5 class="mb-3">Selected {{ ucfirst($bookingType) }}</h5>
                                    @if($bookingType === 'driver')
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3 text-center" style="width: 80px; height: 80px; border-radius: 50%; background: #eef2ff; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; color: #2563eb;">
                                                @if($item->getProfilePictureUrl())
                                                    <img src="{{ $item->getProfilePictureUrl() }}" alt="Driver" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                                @else
                                                    <i class="fas fa-user"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $item->user?->name ?? 'Professional Driver' }}</h6>
                                                <small class="text-muted">{{ $item->experience_years ?? 0 }} years experience</small>
                                            </div>
                                        </div>
                                        <p class="text-muted mb-2"><strong>License:</strong> {{ $item->license_number ?? 'N/A' }}</p>
                                        <p class="text-muted mb-2"><strong>Location:</strong> {{ $item->location ?? 'Available region' }}</p>
                                        <p class="text-muted mb-2"><strong>Rating:</strong> {{ number_format($item->rating ?? 0, 1) }}/5</p>
                                    @else
                                        @if($item->imagePaths())
                                            <img src="{{ route('vehicles.images.show', ['vehicle' => $item, 'index' => 0]) }}" alt="Vehicle Image" class="img-fluid rounded mb-3">
                                        @else
                                            <div class="bg-secondary rounded text-white d-flex align-items-center justify-content-center mb-3" style="height: 220px;">
                                                <i class="fas fa-car fa-3x"></i>
                                            </div>
                                        @endif
                                        <h6 class="mb-1">{{ $item->year ?? '' }} {{ $item->make ?? '' }} {{ $item->model ?? '' }}</h6>
                                        <p class="text-muted mb-2"><strong>Type:</strong> {{ ucfirst($item->vehicle_type ?? 'N/A') }}</p>
                                        <p class="text-muted mb-2"><strong>Capacity:</strong> {{ $item->capacity ?? 'N/A' }} passengers</p>
                                        <p class="text-muted mb-2"><strong>Plate:</strong> <code>{{ $item->license_plate ?? 'N/A' }}</code></p>
                                    @endif

                                    <div class="alert alert-info mt-4">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Standard booking rate is <strong>{{ config('app.currency_label', 'GHC') }} 10 per hour</strong>, with a minimum charge of <strong>{{ config('app.currency_label', 'GHC') }} 10</strong>.
                                        The final amount is calculated from the selected duration and rounded up to the next full hour.
                                    </div>
                                    <div id="bookingFeeEstimate" class="alert alert-secondary mt-3" style="display:none;">
                                        <strong>Estimated Fee:</strong> {{ config('app.currency_label', 'GHC') }} <span id="estimatedFeeAmount">10.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="mb-4">Booking Details</h5>
                                    <form action="{{ route('booking.payment.initiate') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="booking_type" value="{{ $bookingType }}">
                                        @if($bookingType === 'driver')
                                            <input type="hidden" name="driver_id" value="{{ $item->id }}">
                                        @else
                                            <input type="hidden" name="vehicle_id" value="{{ $item->id }}">
                                        @endif

                                        @unless(Auth::check())
                                            <div class="alert alert-warning">
                                                <i class="fas fa-user-secret me-2"></i>
                                                Book as a guest without signing in. We only need your contact details to confirm the booking.
                                            </div>

                                            <div class="row g-3 mb-3">
                                                <div class="col-md-4">
                                                    <label for="guest_name" class="form-label">Full Name *</label>
                                                    <input type="text" id="guest_name" name="guest_name" class="form-control @error('guest_name') is-invalid @enderror" value="{{ old('guest_name') }}" placeholder="Your name" required>
                                                    @error('guest_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="guest_email" class="form-label">Email Address *</label>
                                                    <input type="email" id="guest_email" name="guest_email" class="form-control @error('guest_email') is-invalid @enderror" value="{{ old('guest_email') }}" placeholder="you@example.com" required>
                                                    @error('guest_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="guest_phone" class="form-label">Phone Number *</label>
                                                    <input type="text" id="guest_phone" name="guest_phone" class="form-control @error('guest_phone') is-invalid @enderror" value="{{ old('guest_phone') }}" placeholder="Mobile or WhatsApp" required>
                                                    @error('guest_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        @endunless

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="booking_date" class="form-label">Booking Date *</label>
                                                <input type="date" id="booking_date" name="booking_date" class="form-control @error('booking_date') is-invalid @enderror" value="{{ old('booking_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                                @error('booking_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="location" class="form-label">Location *</label>
                                                <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" placeholder="Where do you need service?" required>
                                                @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="start_time" class="form-label">Start Time *</label>
                                                <input type="time" id="start_time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time') }}" required>
                                                @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="end_time" class="form-label">End Time *</label>
                                                <input type="time" id="end_time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time') }}" required>
                                                @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="description" class="form-label">Notes / Instructions</label>
                                                <textarea id="description" name="description" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="Any special requirements or trip details...">{{ old('description') }}</textarea>
                                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="mt-4 d-flex justify-content-between align-items-center">
                                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Back</a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-credit-card me-2"></i> Proceed to Payment
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function calculateBookingAmount(startTime, endTime) {
        if (!startTime || !endTime) {
            return null;
        }

        const start = startTime.split(':');
        const end = endTime.split(':');
        if (start.length !== 2 || end.length !== 2) {
            return null;
        }

        const startMinutes = parseInt(start[0], 10) * 60 + parseInt(start[1], 10);
        const endMinutes = parseInt(end[0], 10) * 60 + parseInt(end[1], 10);
        if (endMinutes <= startMinutes) {
            return null;
        }

        const durationMinutes = endMinutes - startMinutes;
        const hours = Math.ceil(durationMinutes / 60);
        const amount = Math.max(1, hours) * 10;
        return amount.toFixed(2);
    }

    function updateFeeEstimate() {
        const startTime = document.getElementById('start_time').value;
        const endTime = document.getElementById('end_time').value;
        const estimate = calculateBookingAmount(startTime, endTime);
        const estimateContainer = document.getElementById('bookingFeeEstimate');
        const estimateAmount = document.getElementById('estimatedFeeAmount');

        if (estimate) {
            estimateAmount.textContent = estimate;
            estimateContainer.style.display = 'block';
        } else {
            estimateContainer.style.display = 'none';
        }
    }

    document.getElementById('start_time').addEventListener('change', updateFeeEstimate);
    document.getElementById('end_time').addEventListener('change', updateFeeEstimate);

    document.addEventListener('DOMContentLoaded', updateFeeEstimate);
</script>
@endsection
