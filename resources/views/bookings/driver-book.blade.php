@extends('layouts.app')

@section('title', 'Book Driver')

@section('content')
<div class="container-max content-section">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-calendar-plus"></i> Book Driver</h4>
                </div>
                <div class="card-body">
                    <!-- Driver Information -->
                    <div class="card mb-4 bg-light">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center">
                                    @if($driver->getProfilePictureUrl())
                                        <img src="{{ $driver->getProfilePictureUrl() }}" alt="Profile" class="img-fluid rounded-circle" style="max-width: 120px;">
                                    @else
                                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                            <i class="fas fa-user fa-3x"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <h5>{{ $driver->user->name }}</h5>
                                    <p class="text-muted mb-1">License: {{ $driver->license_number }}</p>
                                    <p class="text-muted mb-2">Experience: {{ $driver->experience_years }} years</p>
                                    <div>
                                        <span class="text-warning">
                                            @php
                                                $rating = $driver->rating ?? 0;
                                                for($i = 0; $i < 5; $i++) {
                                                    echo $i < $rating ? '★' : '☆';
                                                }
                                            @endphp
                                        </span>
                                        <span>{{ number_format($rating, 1) }}/5</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <form action="{{ route('drivers.book', $driver) }}" method="POST">
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
                                <label for="location" class="form-label">Location *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                           id="location" name="location" value="{{ old('location') }}" 
                                           placeholder="Where do you need the driver?" required>
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
                                <label for="description" class="form-label">Description / Special Instructions</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4" 
                                          placeholder="Describe what you need the driver for, any special requirements, etc.">{{ old('description') }}</textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Booking Fee:</strong> {{ config('app.currency_label', 'GHC') }} 50.00 will be charged for this booking. You'll be redirected to payment after confirming.
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('drivers.show', $driver) }}" class="btn btn-secondary">Back</a>
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
