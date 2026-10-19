@extends('layouts.app')

@section('title', 'Browse Vehicles')

@section('content')
<style>
/* Enhanced Vehicles Page Styles */
.vehicles-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4rem 0;
    margin-bottom: 3rem;
}

.vehicles-hero-content {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 1.5rem;
    text-align: center;
}

.vehicles-hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    line-height: 1.1;
}

.vehicles-hero p {
    font-size: 1.1rem;
    opacity: 0.95;
    margin-bottom: 1.5rem;
}

.vehicles-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1.5rem 3rem;
}

.vehicles-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.vehicles-header-info h2 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
}

.vehicles-header-info p {
    margin: 0.5rem 0 0;
    color: #6b7280;
}

.vehicles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.vehicle-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
}

.vehicle-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.vehicle-image {
    width: 100%;
    height: 240px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    overflow: hidden;
    position: relative;
}

.vehicle-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.vehicle-card:hover .vehicle-image img {
    transform: scale(1.05);
}

.vehicle-image::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
}

.vehicle-status {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: #10b981;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    z-index: 2;
}

.vehicle-status.maintenance {
    background: #f59e0b;
}

.vehicle-status.unavailable {
    background: #ef4444;
}

.vehicle-content {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.vehicle-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.vehicle-specs {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-grow: 1;
}

.spec-item {
    background: #f9fafb;
    padding: 0.75rem;
    border-radius: 8px;
    border-left: 3px solid #667eea;
}

.spec-label {
    font-size: 0.8rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.spec-value {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1f2937;
}

.vehicle-owner {
    font-size: 0.9rem;
    color: #6b7280;
    padding: 1rem 0;
    border-top: 1px solid #e5e7eb;
    margin-bottom: 1rem;
}

.vehicle-owner-name {
    font-weight: 600;
    color: #1f2937;
}

.vehicle-actions {
    display: flex;
    gap: 1rem;
}

.btn-view {
    flex: 1;
    background: #f3f4f6;
    color: #1f2937;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
    text-align: center;
    border: 1px solid #e5e7eb;
}

.btn-view:hover {
    background: #e5e7eb;
    transform: translateY(-2px);
}

.btn-book {
    flex: 1;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
    text-align: center;
    border: none;
}

.btn-book:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.vehicles-empty {
    text-align: center;
    padding: 3rem 1.5rem;
    background: #f9fafb;
    border-radius: 12px;
    color: #6b7280;
}

.vehicles-empty-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.vehicles-pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.pagination .page-link {
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    color: #667eea;
    transition: all 0.2s ease;
}

.pagination .page-link:hover {
    background: #667eea;
    color: white;
}

.pagination .page-item.active .page-link {
    background: #667eea;
    border-color: #667eea;
}

@media (max-width: 768px) {
    .vehicles-hero h1 {
        font-size: 2rem;
    }

    .vehicles-hero p {
        font-size: 1rem;
    }

    .vehicles-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .vehicle-card {
        border-radius: 15px;
    }

    .vehicle-image {
        height: 200px;
    }

    .vehicles-header {
        flex-direction: column;
        align-items: flex-start;
    }
}

@media (max-width: 480px) {
    .vehicles-hero {
        padding: 2.5rem 0;
        margin-bottom: 2rem;
    }

    .vehicles-hero h1 {
        font-size: 1.5rem;
    }

    .vehicles-grid {
        grid-template-columns: 1fr;
    }

    .vehicle-specs {
        grid-template-columns: 1fr;
    }

    .vehicle-actions {
        flex-direction: column;
    }
}
</style>

<div class="vehicles-hero">
    <div class="vehicles-hero-content">
        <h1>Explore Our Vehicle Fleet</h1>
        <p>Browse our wide selection of well-maintained vehicles for your business and personal use</p>
    </div>
</div>

<div class="vehicles-container">
    <div class="vehicles-header">
        <div class="vehicles-header-info">
            <h2>Available Vehicles</h2>
            <p>{{ $vehicles->total() }} vehicles found</p>
        </div>
        @auth
            <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Your Vehicle
            </a>
        @endauth
    </div>

    @if($vehicles->count() > 0)
        <div class="vehicles-grid">
            @forelse($vehicles as $vehicle)
                <div class="vehicle-card">
                    <div class="vehicle-image">
                        @if($vehicle->imagePaths())
                            <img src="{{ route('vehicles.images.show', ['vehicle' => $vehicle, 'index' => 0]) }}" alt="{{ $vehicle->make }} {{ $vehicle->model }}">
                        @else
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: white; font-size: 3rem;">
                                <i class="fas fa-car"></i>
                            </div>
                        @endif
                        <span class="vehicle-status {{ $vehicle->status !== 'available' ? strtolower($vehicle->status) : '' }}">
                            {{ ucfirst($vehicle->status) }}
                        </span>
                    </div>

                    <div class="vehicle-content">
                        <h3 class="vehicle-title">{{ $vehicle->make }} {{ $vehicle->model }}</h3>

                        <div class="vehicle-specs">
                            <div class="spec-item">
                                <div class="spec-label">Year</div>
                                <div class="spec-value">{{ $vehicle->year ?? 'N/A' }}</div>
                            </div>
                            <div class="spec-item">
                                <div class="spec-label">Type</div>
                                <div class="spec-value">{{ ucfirst($vehicle->vehicle_type) }}</div>
                            </div>
                            <div class="spec-item">
                                <div class="spec-label">License Plate</div>
                                <div class="spec-value">{{ $vehicle->license_plate }}</div>
                            </div>
                            <div class="spec-item">
                                <div class="spec-label">Capacity</div>
                                <div class="spec-value">{{ $vehicle->capacity ?? 'N/A' }} seats</div>
                            </div>
                        </div>

                        <div class="vehicle-owner">
                            Owner: <span class="vehicle-owner-name">{{ $vehicle->user?->name ?? 'Unknown' }}</span>
                        </div>

                        <div class="vehicle-actions">
                            <a href="{{ route('vehicles.show', $vehicle) }}" class="btn-view">
                                <i class="fas fa-eye me-1"></i>View Details
                            </a>
                            <a href="{{ route('book.index') }}" class="btn-book">
                                <i class="fas fa-calendar-check me-1"></i>Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="vehicles-empty">
                    <div class="vehicles-empty-icon">
                        <i class="fas fa-car-side"></i>
                    </div>
                    <p>No vehicles available at the moment. Please check back later.</p>
                </div>
            @endforelse
        </div>

        @if($vehicles->hasPages())
            <div class="vehicles-pagination">
                {{ $vehicles->links() }}
            </div>
        @endif
    @else
        <div class="vehicles-empty">
            <div class="vehicles-empty-icon">
                <i class="fas fa-car-side"></i>
            </div>
            <p>No vehicles available at the moment. Please check back later.</p>
        </div>
    @endif
</div>

@endsection
