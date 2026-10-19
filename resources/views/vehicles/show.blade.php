@extends('layouts.app')

@section('title', 'Vehicle Details')

@section('content')
<div class="container-max content-section py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="vehicle-hero p-5 rounded-4 shadow-sm mb-5 bg-vehicle-hero">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-4">
                    <div>
                        <h1 class="hero-title mb-3">{{ $vehicle->make }} {{ $vehicle->model }}</h1>
                        <p class="hero-subtitle mb-3">{{ $vehicle->year }} • {{ ucfirst($vehicle->vehicle_type ?? 'Vehicle') }}</p>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="badge badge-pill badge-primary">{{ ucfirst($vehicle->status) }}</span>
                            <span class="badge badge-pill badge-{{ $vehicle->approval_status === 'approved' ? 'success' : ($vehicle->approval_status === 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($vehicle->approval_status) }}</span>
                        </div>
                    </div>
                    <div class="text-lg-end">
                        <p class="text-secondary mb-1">Vehicle owner</p>
                        <h5 class="mb-1">{{ $vehicle->user?->name ?? 'Unknown' }}</h5>
                        <p class="text-muted mb-0">Listed on {{ $vehicle->created_at->format('M j, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card rounded-4 border-0 shadow-sm overflow-hidden mb-4">
                        @if($vehicle->imagePaths())
                            <div class="vehicle-image-carousel position-relative">
                                <img id="vehicle-main-image" src="{{ route('vehicles.images.show', ['vehicle' => $vehicle, 'index' => 0]) }}" alt="{{ $vehicle->make }} {{ $vehicle->model }}" class="img-fluid w-100 vehicle-main-image">
                                @if(count($vehicle->imagePaths()) > 1)
                                    <button type="button" class="carousel-control prev" onclick="vehicleCarouselPrev()" aria-label="Previous image">‹</button>
                                    <button type="button" class="carousel-control next" onclick="vehicleCarouselNext()" aria-label="Next image">›</button>
                                @endif
                            </div>
                            @if(count($vehicle->imagePaths()) > 1)
                                <div class="vehicle-carousel-thumbs d-flex flex-wrap gap-2 p-3 bg-white">
                                    @foreach($vehicle->imagePaths() as $index => $image)
                                        <button type="button" class="carousel-thumb{{ $index === 0 ? ' active' : '' }}" onclick="vehicleCarouselSet({{ $index }})" aria-label="View image {{ $index + 1 }}">
                                                <img src="{{ route('vehicles.images.show', ['vehicle' => $vehicle, 'index' => $index]) }}" alt="{{ $vehicle->make }} {{ $vehicle->model }} thumbnail {{ $index + 1 }}" class="vehicle-thumbnail">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="vehicle-image-carousel position-relative">
                                <div class="no-image text-center p-5 text-secondary">No vehicle images available</div>
                            </div>
                        @endif
                    </div>

                    <div class="card rounded-4 shadow-sm border-0 p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="section-heading mb-1">Vehicle Overview</h4>
                                <p class="section-text mb-0">A clearer summary of this vehicle and what makes it a great choice.</p>
                            </div>
                            <span class="badge badge-outline">{{ $vehicle->license_plate }}</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="detail-card p-3 rounded-4 border">
                                    <span class="detail-label">Capacity</span>
                                    <p class="detail-value">{{ $vehicle->capacity ?? 'N/A' }} passengers</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-card p-3 rounded-4 border">
                                    <span class="detail-label">Mileage</span>
                                    <p class="detail-value">{{ $vehicle->mileage ? $vehicle->mileage . ' km' : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-card p-3 rounded-4 border">
                                    <span class="detail-label">Fuel Type</span>
                                    <p class="detail-value">{{ ucfirst($vehicle->fuel_type ?? 'Not set') }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-card p-3 rounded-4 border">
                                    <span class="detail-label">Transmission</span>
                                    <p class="detail-value">{{ ucfirst($vehicle->transmission ?? 'Not set') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <h5 class="section-heading mb-2">Description</h5>
                            <p class="text-muted mb-0">{{ $vehicle->description ?? 'No description provided for this vehicle.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card rounded-4 shadow-sm border-0 p-4 bg-light-surface h-100">
                        <h4 class="section-heading mb-3">Book this vehicle</h4>
                        <p class="section-text text-muted mb-4">Reserve this vehicle quickly to secure your preferred ride.</p>

                        <div class="mb-4">
                            <div class="detail-card p-3 rounded-4 border mb-3">
                                <span class="detail-label">Approval Status</span>
                                <p class="detail-value mb-0">{{ ucfirst($vehicle->approval_status) }}</p>
                            </div>
                            <div class="detail-card p-3 rounded-4 border">
                                <span class="detail-label">Available Status</span>
                                <p class="detail-value mb-0">{{ ucfirst($vehicle->status) }}</p>
                            </div>
                        </div>

                        <div class="d-grid gap-3">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg">Back to list</a>
                            @auth
                                @if(auth()->id() === $vehicle->user_id || auth()->user()->isAdmin())
                                    <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-outline-primary btn-lg">Edit Vehicle</a>
                                @elseif(auth()->check())
                                    <a href="{{ route('booking.page', ['type' => 'vehicle', 'id' => $vehicle->id]) }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-calendar-check me-2"></i> Book Now
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('guest.booking.page', ['type' => 'vehicle', 'id' => $vehicle->id]) }}" class="btn btn-primary btn-lg">
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
        .vehicle-hero {
            background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
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
        .section-heading {
            color: #111827;
            font-size: 1.2rem;
            font-weight: 700;
        }
        .section-text {
            color: #6b7280;
        }
        .detail-card {
            background: #ffffff;
            border-color: rgba(148, 163, 184, 0.2);
        }
        .detail-label {
            display: block;
            color: #475569;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .detail-value {
            color: #0f172a;
            font-size: 1rem;
            line-height: 1.6;
            margin: 0;
        }
        .bg-light-surface {
            background: #f8fafc;
        }
        .badge-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.55rem 0.95rem;
            border: 1px solid rgba(59, 130, 246, 0.16);
            border-radius: 999px;
            color: #2563eb;
            font-weight: 700;
            background: rgba(59, 130, 246, 0.08);
        }
        .vehicle-image-carousel {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            background: #e2e8f0;
        }
        .vehicle-main-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            display: block;
        }
        .carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 42px;
            height: 42px;
            border: none;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.76);
            color: #fff;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 2;
            transition: background 0.2s ease;
        }
        .carousel-control:hover {
            background: rgba(15, 23, 42, 0.95);
        }
        .carousel-control.prev {
            left: 14px;
        }
        .carousel-control.next {
            right: 14px;
        }
        .vehicle-carousel-thumbs {
            background: #ffffff;
            padding: 1rem;
            justify-content: center;
            gap: 0.75rem;
        }
        .carousel-thumb {
            width: 88px;
            height: 64px;
            padding: 0;
            border-radius: 14px;
            border: 2px solid transparent;
            overflow: hidden;
            background: transparent;
            cursor: pointer;
            transition: border-color 0.2s ease, transform 0.2s ease;
            display: inline-flex;
        }
        .carousel-thumb.active,
        .carousel-thumb:hover {
            border-color: #2563eb;
            transform: translateY(-1px);
        }
        .carousel-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .no-image {
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection

@if($vehicle->imagePaths())
    @php
        $vehicleImageUrls = array_map(
            fn ($index) => route('vehicles.images.show', ['vehicle' => $vehicle, 'index' => $index]),
            array_keys($vehicle->imagePaths())
        );
    @endphp
    <script>
        const vehicleImages = @json($vehicleImageUrls);
        let currentVehicleImageIndex = 0;

        function setVehicleImage(index) {
            if (!vehicleImages.length) return;
            currentVehicleImageIndex = index;
            const mainImage = document.getElementById('vehicle-main-image');
            if (mainImage) {
                mainImage.src = vehicleImages[index];
            }
            document.querySelectorAll('.carousel-thumb').forEach((thumb, thumbIndex) => {
                thumb.classList.toggle('active', thumbIndex === index);
            });
        }

        function vehicleCarouselPrev() {
            if (!vehicleImages.length) return;
            setVehicleImage((currentVehicleImageIndex + vehicleImages.length - 1) % vehicleImages.length);
        }

        function vehicleCarouselNext() {
            if (!vehicleImages.length) return;
            setVehicleImage((currentVehicleImageIndex + 1) % vehicleImages.length);
        }

        function vehicleCarouselSet(index) {
            if (!vehicleImages.length) return;
            setVehicleImage(index);
        }

        document.addEventListener('DOMContentLoaded', () => setVehicleImage(0));
    </script>
@endif
