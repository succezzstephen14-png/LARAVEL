@extends('layouts.app')

@section('title', 'Book Services')

@section('styles')
<style>
    .book-services-header h1 {
        color: white;
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .book-services-header p {
        color: #e0e7ff;
        font-size: 1.1rem;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="container-max content-section">
    <div class="text-center mb-5 book-services-header">
        <h1>Book Our Services</h1>
        <p class="lead">Find and book vehicles, or apply for recruitment opportunities.</p>
    </div>

    <!-- Vehicles Section -->
    @if($vehicles->count() > 0)
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Available Vehicles</h2>
            <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary">View All Vehicles</a>
        </div>
        <div class="row gy-4">
            @foreach($vehicles as $vehicle)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="vehicle-icon me-3">
                                    <i class="fas fa-car"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0">{{ $vehicle->make }} {{ $vehicle->model }}</h5>
                                    <small class="text-muted">{{ $vehicle->user->name }}</small>
                                </div>
                            </div>
                            <dl class="row small mb-3">
                                <dt class="col-sm-5">Type</dt>
                                <dd class="col-sm-7">{{ ucfirst($vehicle->vehicle_type) }}</dd>
                                <dt class="col-sm-5">Year</dt>
                                <dd class="col-sm-7">{{ $vehicle->year }}</dd>
                                <dt class="col-sm-5">Capacity</dt>
                                <dd class="col-sm-7">{{ $vehicle->capacity ?? 'N/A' }} passengers</dd>
                                <dt class="col-sm-5">Status</dt>
                                <dd class="col-sm-7">{{ ucfirst($vehicle->status) }}</dd>
                            </dl>
                            @if($vehicle->description)
                                <p class="card-text small text-muted">{{ Str::limit($vehicle->description, 100) }}</p>
                            @endif
                        </div>
                        <div class="card-footer bg-light">
                            <a href="{{ route('booking.page', ['type' => 'vehicle', 'id' => $vehicle->id]) }}" class="btn btn-primary w-100">
                                <i class="fas fa-calendar-plus me-2"></i>Book Vehicle
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Recruitments Section -->
    @if($recruitments->count() > 0)
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Recruitment Opportunities</h2>
            <a href="{{ route('recruitments.index') }}" class="btn btn-outline-primary">View All Opportunities</a>
        </div>
        <div class="row gy-4">
            @foreach($recruitments as $recruitment)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-circle me-3">
                                    {{ substr($recruitment->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="card-title mb-0">{{ $recruitment->title }}</h5>
                                    <small class="text-muted">{{ $recruitment->user->name }}</small>
                                </div>
                            </div>
                            <dl class="row small mb-3">
                                <dt class="col-sm-5">Type</dt>
                                <dd class="col-sm-7">{{ str_replace('_', ' ', ucfirst($recruitment->position_type)) }}</dd>
                                <dt class="col-sm-5">Location</dt>
                                <dd class="col-sm-7">{{ $recruitment->location }}</dd>
                                <dt class="col-sm-5">Salary</dt>
                                <dd class="col-sm-7">{{ $recruitment->salary ? config('app.currency_label', 'GHC') . ' ' . number_format($recruitment->salary, 2) : 'Negotiable' }}</dd>
                            </dl>
                            @if($recruitment->description)
                                <p class="card-text small text-muted">{{ Str::limit($recruitment->description, 100) }}</p>
                            @endif
                        </div>
                        @php
                            $applyRole = str_replace('_', '-', $recruitment->position_type);
                        @endphp
                        <div class="card-footer bg-light">
                            <a href="{{ route('application.page', ['role' => $applyRole, 'recruitment' => $recruitment->id]) }}" class="btn btn-primary w-100">
                                <i class="fas fa-paper-plane me-2"></i>Apply Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($vehicles->count() === 0 && $recruitments->count() === 0)
        <div class="text-center py-5">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
            <h3>No Services Available</h3>
            <p class="text-muted">There are currently no approved services available for booking. Please check back later.</p>
        </div>
    @endif
</div>
@endsection