@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('title', 'Driver Profile')

@section('content')
<div class="container-max content-section py-5">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="driver-hero rounded-4 shadow-sm overflow-hidden mb-5">
                <div class="p-5">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-4">
                        <div>
                            <h1 class="hero-title mb-3">{{ $driver->user?->name ?? 'Driver' }}</h1>
                            <p class="hero-subtitle mb-3">License {{ $driver->license_number }} • Class {{ $driver->license_class }}</p>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <span class="badge badge-pill badge-primary">{{ ucfirst(str_replace('_', ' ', $driver->status)) }}</span>
                                <span class="badge badge-pill badge-{{ $driver->approval_status === 'approved' ? 'success' : ($driver->approval_status === 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($driver->approval_status) }}</span>
                            </div>
                        </div>
                        <div class="text-lg-end">
                            <p class="text-secondary mb-1">Driver rating</p>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= ($driver->rating ?? 0) ? ' text-warning' : ' text-muted' }}"></i>
                                    @endfor
                                </div>
                                <span class="fw-bold">{{ number_format($driver->rating ?? 0, 1) }}/5</span>
                            </div>
                            <p class="text-muted mb-0">Joined {{ $driver->created_at->format('M j, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row gx-4 gy-4">
                <div class="col-lg-7">
                    <div class="card rounded-4 shadow-sm border-0 p-4 h-100">
                        <div class="d-flex align-items-start justify-content-between mb-4 flex-column flex-md-row gap-3">
                            <div>
                                <h1 class="display-6 mb-2">Driver Information</h1>
                                <p class="text-muted mb-1">Professional driver with verified credentials</p>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <div class="detail-card p-3 rounded-4 border border-1 bg-white">
                                    <span class="detail-label">License Number</span>
                                    <p class="detail-value mb-0">{{ $driver->license_number }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-card p-3 rounded-4 border border-1 bg-white">
                                    <span class="detail-label">License Class</span>
                                    <p class="detail-value mb-0">{{ $driver->license_class }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-card p-3 rounded-4 border border-1 bg-white">
                                    <span class="detail-label">Experience</span>
                                    <p class="detail-value mb-0">{{ $driver->experience_years }} years</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-card p-3 rounded-4 border border-1 bg-white">
                                    <span class="detail-label">License Expiry</span>
                                    <p class="detail-value mb-0">{{ $driver->license_expiry?->format('M j, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4 class="section-heading mb-3">About this driver</h4>
                            <p class="text-muted">{{ $driver->bio ?? 'No profile bio available.' }}</p>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="info-box p-3 rounded-4 bg-gradient-light border border-1">
                                    <span class="info-label">Phone</span>
                                    <p class="mb-0 info-value">{{ $driver->phone ?? 'Not provided' }}</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="info-box p-3 rounded-4 bg-gradient-light border border-1">
                                    <span class="info-label">Emergency Contact</span>
                                    <p class="mb-0 info-value">{{ $driver->emergency_contact ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card rounded-4 shadow-sm border-0 p-4 h-100 bg-gradient-light">
                        <h4 class="section-heading mb-3">Book this driver</h4>
                        <p class="text-muted mb-4">Hire this experienced driver for your transportation needs.</p>

                        <div class="mb-4">
                            <div class="detail-card p-3 rounded-4 border mb-3">
                                <span class="detail-label">Current Status</span>
                                <p class="detail-value mb-0">{{ ucfirst(str_replace('_', ' ', $driver->status)) }}</p>
                            </div>
                            <div class="detail-card p-3 rounded-4 border">
                                <span class="detail-label">Approval Status</span>
                                <p class="detail-value mb-0">{{ ucfirst($driver->approval_status) }}</p>
                            </div>
                        </div>

                        <div class="d-grid gap-3">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg">Back to list</a>
                            @auth
                                @if(auth()->id() === $driver->user_id || auth()->user()->isAdmin())
                                    <a href="{{ route('drivers.edit') }}" class="btn btn-outline-primary btn-lg">Edit Profile</a>
                                @elseif(auth()->check())
                                    <a href="{{ route('booking.page', ['type' => 'driver', 'id' => $driver->id]) }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-calendar-check me-2"></i> Book Now
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('guest.booking.page', ['type' => 'driver', 'id' => $driver->id]) }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-calendar-check me-2"></i> Book as Guest
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <style>
        .driver-hero {
            background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);
            border: 1px solid rgba(59, 130, 246, 0.12);
        }
        .hero-title {
            font-size: clamp(2rem, 3vw, 2.6rem);
            line-height: 1.05;
            color: #0f172a;
        }
        .hero-subtitle {
            color: #475569;
            font-size: 1rem;
            margin-bottom: 0.75rem;
        }
        .badge-pill {
            padding: 0.7rem 1rem;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .badge-primary {
            background: #2563eb;
            color: #fff;
        }
        .badge-success {
            background: #16a34a;
            color: #fff;
        }
        .badge-warning {
            background: #eab308;
            color: #0f172a;
        }
        .badge-danger {
            background: #dc2626;
            color: #fff;
        }
        .rating-stars {
            font-size: 1.1rem;
        }
        .section-heading {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
        }
        .detail-card {
            background: #ffffff;
        }
        .detail-label {
            display: block;
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 0.6rem;
        }
        .detail-value {
            font-size: 1rem;
            color: #111827;
            line-height: 1.7;
        }
        .info-box {
            background: #f8fafc;
        }
        .info-label {
            display: block;
            color: #6b7280;
            font-size: 0.85rem;
            margin-bottom: 0.4rem;
            font-weight: 600;
        }
        .info-value {
            font-size: 1rem;
            color: #111827;
            margin-bottom: 0;
        }
        .bg-gradient-light {
            background: linear-gradient(180deg, rgba(249, 250, 251, 0.98) 0%, rgba(241, 245, 249, 0.98) 100%);
        }
    </style>
@endsection
