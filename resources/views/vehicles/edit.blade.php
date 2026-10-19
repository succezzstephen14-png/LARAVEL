@extends('layouts.app')

@section('title', 'Edit Vehicle')

@section('content')
<div class="container-max content-section">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Vehicle</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('vehicles.update', $vehicle) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="make" class="form-label">Make</label>
                                <input type="text" class="form-control" id="make" name="make" value="{{ old('make', $vehicle->make) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" class="form-control" id="model" name="model" value="{{ old('model', $vehicle->model) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="year" class="form-label">Year</label>
                                <input type="number" class="form-control" id="year" name="year" value="{{ old('year', $vehicle->year) }}" min="1900" max="{{ date('Y') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="vehicle_type" class="form-label">Type</label>
                                <select class="form-select" id="vehicle_type" name="vehicle_type" required>
                                    <option value="">Choose</option>
                                    <option value="car" {{ old('vehicle_type', $vehicle->vehicle_type) === 'car' ? 'selected' : '' }}>Car</option>
                                    <option value="van" {{ old('vehicle_type', $vehicle->vehicle_type) === 'van' ? 'selected' : '' }}>Van</option>
                                    <option value="truck" {{ old('vehicle_type', $vehicle->vehicle_type) === 'truck' ? 'selected' : '' }}>Truck</option>
                                    <option value="motorcycle" {{ old('vehicle_type', $vehicle->vehicle_type) === 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Choose</option>
                                    <option value="available" {{ old('status', $vehicle->status) === 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="unavailable" {{ old('status', $vehicle->status) === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                    <option value="maintenance" {{ old('status', $vehicle->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="on_duty" {{ old('status', $vehicle->status) === 'on_duty' ? 'selected' : '' }}>On Duty</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="license_plate" class="form-label">License Plate</label>
                                <input type="text" class="form-control" id="license_plate" name="license_plate" value="{{ old('license_plate', $vehicle->license_plate) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" value="{{ old('capacity', $vehicle->capacity) }}" min="1">
                            </div>
                            <div class="col-12">
                                <label for="image_url" class="form-label">Vehicle Images</label>
                                <input type="file" class="form-control" id="image_url" name="image_url[]" accept="image/*" multiple>
                                @if($vehicle->imagePaths())
                                    <div class="mt-2">
                                        <small class="text-muted">Current images:</small>
                                            @foreach($vehicle->imagePaths() as $index => $image)
                                            <div class="d-inline-block me-2 mb-2">
                                                <img src="{{ route('vehicles.images.show', ['vehicle' => $vehicle, 'index' => $index]) }}" alt="Vehicle image" class="vehicle-thumbnail">
                                            </div>
                                            @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $vehicle->description) }}</textarea>
                            </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update Vehicle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
