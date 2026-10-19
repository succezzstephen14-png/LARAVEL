@extends('layouts.app')

@section('title', 'Pending Vehicles')

@section('content')
<div class="container-max content-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Pending Vehicles</h2>
            <p class="text-muted">Review the vehicles you have submitted that are awaiting admin approval.</p>
        </div>
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Add New Vehicle</a>
    </div>

    <div class="row gy-4">
        @forelse($vehicles as $vehicle)
            <div class="col-md-6">
                <div class="card p-3">
                    @if($vehicle->imagePaths())
                        <div class="vehicle-image mb-3">
                            <img src="{{ route('vehicles.images.show', ['vehicle' => $vehicle, 'index' => 0]) }}" alt="{{ $vehicle->make }} {{ $vehicle->model }}">
                        </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5>{{ $vehicle->make }} {{ $vehicle->model }}</h5>
                        <div class="d-flex gap-2">
                            <span class="badge bg-{{ $vehicle->status === 'available' ? 'success' : ($vehicle->status === 'maintenance' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($vehicle->status) }}
                            </span>
                            <span class="badge bg-{{ $vehicle->approval_status === 'approved' ? 'success' : ($vehicle->approval_status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($vehicle->approval_status) }}
                            </span>
                        </div>
                    </div>
                    <p class="mb-1">{{ $vehicle->year }} • {{ ucfirst($vehicle->vehicle_type) }}</p>
                    <p class="mb-1">License: {{ $vehicle->license_plate }}</p>
                    @if($vehicle->approval_status === 'pending')
                        <div class="alert alert-info alert-sm mt-2 mb-2">
                            <i class="fas fa-info-circle"></i> Pending admin approval
                        </div>
                    @elseif($vehicle->approval_status === 'rejected')
                        <div class="alert alert-danger alert-sm mt-2 mb-2">
                            <i class="fas fa-times-circle"></i>
                            <strong>Rejected:</strong> {{ $vehicle->rejection_reason ?? 'No reason provided' }}
                        </div>
                    @endif
                    <div class="mt-2">
                        <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-outline-primary btn-sm">View</a>
                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                        <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">You do not have any pending or rejected vehicles at the moment.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $vehicles->links() }}
    </div>
</div>
@endsection
