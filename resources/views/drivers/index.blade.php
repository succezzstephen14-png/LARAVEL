@extends('layouts.app')

@section('title', 'Professional Drivers')

@section('content')
<style>
    .drivers-hero {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 4rem 0;
        margin-bottom: 3rem;
    }

    .drivers-hero-content {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1.5rem;
        text-align: center;
    }

    .drivers-hero h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.1;
    }

    .drivers-hero p {
        font-size: 1.1rem;
        opacity: 0.95;
        margin-bottom: 1.5rem;
    }

    .drivers-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1.5rem 3rem;
    }

    .drivers-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .drivers-header-info h2 {
        margin: 0;
        color: #1f2937;
        font-size: 2rem;
        font-weight: 700;
    }

    .drivers-header-info p {
        margin: 0.5rem 0 0;
        color: #6b7280;
        font-size: 1rem;
    }

    .drivers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .drivers-pagination {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .drivers-empty {
        text-align: center;
        padding: 4rem 2rem;
        background: #f9fafb;
        border-radius: 20px;
        border: 2px dashed #e5e7eb;
    }

    .drivers-empty-icon {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .drivers-empty h3 {
        color: #374151;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .drivers-empty p {
        color: #6b7280;
        margin-bottom: 2rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .drivers-hero {
            padding: 3rem 0;
        }

        .drivers-hero h1 {
            font-size: 2rem;
        }

        .drivers-hero p {
            font-size: 1rem;
        }

        .drivers-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .drivers-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 480px) {
        .drivers-hero {
            padding: 2rem 0;
        }

        .drivers-hero h1 {
            font-size: 1.5rem;
        }

        .drivers-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="drivers-hero">
    <div class="drivers-hero-content">
        <h1>Professional Drivers</h1>
        <p>Browse and book experienced drivers for your transportation needs</p>
    </div>
</div>

<div class="drivers-container">
    <!-- Header -->
    <div class="drivers-header">
        <div class="drivers-header-info">
            <h2>Available Drivers</h2>
            <p>Find reliable drivers with verified credentials</p>
        </div>
        @auth
            <a href="{{ route('drivers.create') }}" class="btn btn-primary" style="white-space: nowrap;">
                <i class="fas fa-plus me-2"></i>Become a Driver
            </a>
        @endauth
    </div>

    <!-- Drivers Grid -->
    @if($drivers->count() > 0)
        <div class="drivers-grid">
            @foreach($drivers as $driver)
                <x-driver-card :driver="$driver" />
            @endforeach
        </div>

        <!-- Pagination -->
        @if($drivers->hasPages())
            <div class="drivers-pagination">
                {{ $drivers->links() }}
            </div>
        @endif
    @else
        <div class="drivers-empty">
            <div class="drivers-empty-icon">
                <i class="fas fa-user-slash"></i>
            </div>
            <h3 style="margin: 1rem 0; color: #374151;">No Drivers Available</h3>
            <p>There are no approved drivers available at the moment. Please check back later.</p>
            @auth
                <a href="{{ route('drivers.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus me-2"></i>Become a Driver
                </a>
            @endauth
        </div>
    @endif
</div>
@endsection