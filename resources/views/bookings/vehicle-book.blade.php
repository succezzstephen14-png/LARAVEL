@extends('layouts.app')

@section('title', 'Book Vehicle')

@section('content')
<div class="container-max content-section">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-calendar-plus"></i> Book Vehicle</h4>
                </div>
                <div class="card-body">
                    <!-- Vehicle Information -->
                    <div class="card mb-4 bg-light">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center">
                                    @if($vehicle->imagePaths())
                                        <img src="{{ route('vehicles.images.show', ['vehicle' => $vehicle, 'index' => 0]) }}" alt="Vehicle" class="img-fluid rounded" style="max-height: 150px;">
                                    @else
                                        <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width: 100%; height: 150px;">
                                            <i class="fas fa-car fa-3x"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <h5>{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</h5>
                                    <p class="text-muted mb-1">Type: {{ ucfirst($vehicle->vehicle_type) }}</p>
                                    <p class="text-muted mb-1">License Plate: <code>{{ $vehicle->license_plate }}</code></p>
                                    <p class="text-muted mb-2">Capacity: {{ $vehicle->capacity }} passengers</p>
                                    @if($vehicle->color)
                                        <p class="text-muted">Color: {{ $vehicle->color }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <form action="{{ route('vehicles.book', $vehicle) }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="booking_date" class="form-label">Date *</label>
                                <input type="date" class="form-control @error('booking_date') is-invalid @enderror" 
                                       id="booking_date" name="booking_date" value="{{ old('booking_date') }}" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                @error('booking_date') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="location" class="form-label">Pickup Location *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                           id="location" name="location" value="{{ old('location') }}" 
                                           placeholder="Where to pick up the vehicle?" required>
                                    <button type="button" class="btn btn-outline-secondary" id="useMyLocationBtn" title="Use my current location"><i class="fas fa-location-arrow"></i></button>
                                </div>
                                @error('location') <small class="text-danger">{{ $message }}</small> @enderror
                                <small class="text-muted d-block mt-1">Tip: Click the location icon to use your current device location. You can edit it afterwards.</small>
                            </div>

                            <div class="col-md-6">
                                <label for="start_time" class="form-label">Start Time *</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                       id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                @error('start_time') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="end_time" class="form-label">End Time *</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                       id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                                @error('end_time') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Purpose / Special Instructions</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4" 
                                          placeholder="What will you use the vehicle for? Any special requirements or instructions?">{{ old('description') }}</textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Rental Fee:</strong> {{ config('app.currency_label', 'GHC') }} 100.00 will be charged for this booking. You'll be redirected to payment after confirming.
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Confirm Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('bookings.partials.location-helper')

@endsection
