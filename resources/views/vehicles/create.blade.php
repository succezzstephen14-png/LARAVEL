@extends('layouts.dashboard')

@section('title', 'Add Vehicle')

@section('content')
<div class="container-max content-section">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-car-side"></i> Add Vehicle</h4>
                </div>
                <div class="card-body">
                    <!-- Payment Notice -->
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Payment Required:</strong> Adding a vehicle requires a one-time payment of <strong>{{ config('app.currency_label', 'GHC') }} 30.00</strong> for verification and approval. Your vehicle will be submitted for admin approval after successful payment.
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger border border-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('vehicle.payment.initiate') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Vehicle Information -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-car"></i> Basic Vehicle Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="make" class="form-label">Make (Brand) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('make') is-invalid @enderror" 
                                               id="make" name="make" value="{{ old('make') }}" 
                                               placeholder="e.g., Toyota, Honda, Mercedes" required>
                                        @error('make') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                               id="model" name="model" value="{{ old('model') }}" 
                                               placeholder="e.g., Camry, Accord, C-Class" required>
                                        @error('model') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('year') is-invalid @enderror" 
                                               id="year" name="year" value="{{ old('year') }}" 
                                               placeholder="e.g., 2020" required min="1900" max="{{ date('Y') }}">
                                        @error('year') <small class="text-danger">{{ $message }}</small> @enderror
                                        <small class="form-text text-muted">Must be between 1900 and {{ date('Y') }}</small>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="vehicle_type" class="form-label">Vehicle Type <span class="text-danger">*</span></label>
                                        <select class="form-select @error('vehicle_type') is-invalid @enderror" 
                                                id="vehicle_type" name="vehicle_type" required>
                                            <option value="">Choose Type</option>
                                            <option value="car" {{ old('vehicle_type') === 'car' ? 'selected' : '' }}>Car</option>
                                            <option value="van" {{ old('vehicle_type') === 'van' ? 'selected' : '' }}>Van</option>
                                            <option value="truck" {{ old('vehicle_type') === 'truck' ? 'selected' : '' }}>Truck</option>
                                            <option value="motorcycle" {{ old('vehicle_type') === 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                                        </select>
                                        @error('vehicle_type') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="color" class="form-label">Color</label>
                                        <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                               id="color" name="color" value="{{ old('color') }}" 
                                               placeholder="e.g., Red, Blue, Silver">
                                        @error('color') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="license_plate" class="form-label">License Plate <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('license_plate') is-invalid @enderror" 
                                               id="license_plate" name="license_plate" value="{{ old('license_plate') }}" 
                                               placeholder="e.g., GH-2023-ABC-1234" required maxlength="20">
                                        @error('license_plate') <small class="text-danger">{{ $message }}</small> @enderror
                                        <small class="form-text text-muted">Must be unique and not exceed 20 characters</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="registration_number" class="form-label">Registration Number</label>
                                        <input type="text" class="form-control @error('registration_number') is-invalid @enderror" 
                                               id="registration_number" name="registration_number" value="{{ old('registration_number') }}" 
                                               placeholder="Vehicle registration number">
                                        @error('registration_number') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="vin" class="form-label">VIN (Vehicle Identification Number)</label>
                                        <input type="text" class="form-control @error('vin') is-invalid @enderror" 
                                               id="vin" name="vin" value="{{ old('vin') }}" 
                                               placeholder="17-character VIN">
                                        @error('vin') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Technical Specifications -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-cog"></i> Technical Specifications</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="fuel_type" class="form-label">Fuel Type</label>
                                        <select class="form-select @error('fuel_type') is-invalid @enderror" 
                                                id="fuel_type" name="fuel_type">
                                            <option value="">Select Fuel Type</option>
                                            <option value="petrol" {{ old('fuel_type') === 'petrol' ? 'selected' : '' }}>Petrol</option>
                                            <option value="diesel" {{ old('fuel_type') === 'diesel' ? 'selected' : '' }}>Diesel</option>
                                            <option value="hybrid" {{ old('fuel_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                            <option value="electric" {{ old('fuel_type') === 'electric' ? 'selected' : '' }}>Electric</option>
                                            <option value="gas" {{ old('fuel_type') === 'gas' ? 'selected' : '' }}>Gas</option>
                                        </select>
                                        @error('fuel_type') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="transmission" class="form-label">Transmission</label>
                                        <select class="form-select @error('transmission') is-invalid @enderror" 
                                                id="transmission" name="transmission">
                                            <option value="">Select Transmission</option>
                                            <option value="manual" {{ old('transmission') === 'manual' ? 'selected' : '' }}>Manual</option>
                                            <option value="automatic" {{ old('transmission') === 'automatic' ? 'selected' : '' }}>Automatic</option>
                                        </select>
                                        @error('transmission') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="engine_size" class="form-label">Engine Size (cc)</label>
                                        <input type="text" class="form-control @error('engine_size') is-invalid @enderror" 
                                               id="engine_size" name="engine_size" value="{{ old('engine_size') }}" 
                                               placeholder="e.g., 2000">
                                        @error('engine_size') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="capacity" class="form-label">Seating Capacity *</label>
                                        <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                               id="capacity" name="capacity" value="{{ old('capacity') }}" 
                                               min="1" placeholder="Number of passengers" required>
                                        @error('capacity') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="number_of_seats" class="form-label">Number of Seats</label>
                                        <input type="number" class="form-control @error('number_of_seats') is-invalid @enderror" 
                                               id="number_of_seats" name="number_of_seats" value="{{ old('number_of_seats') }}" 
                                               min="1" placeholder="Total seats">
                                        @error('number_of_seats') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mileage" class="form-label">Mileage (km)</label>
                                        <input type="number" class="form-control @error('mileage') is-invalid @enderror" 
                                               id="mileage" name="mileage" value="{{ old('mileage') }}" 
                                               min="0" placeholder="Current mileage">
                                        @error('mileage') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Condition & Documentation -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-file-contract"></i> Vehicle Condition & Required Documents</h6>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> <strong>Required Documents:</strong> You must upload Registration Certificate, Insurance Document, and Roadworthiness Certificate to proceed.
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="condition" class="form-label">Vehicle Condition * (Required)</label>
                                        <select class="form-select @error('condition') is-invalid @enderror" 
                                                id="condition" name="condition" required>
                                            <option value="">Select Vehicle Condition</option>
                                            <option value="excellent" {{ old('condition') === 'excellent' ? 'selected' : '' }}>Excellent</option>
                                            <option value="very_good" {{ old('condition') === 'very_good' ? 'selected' : '' }}>Very Good</option>
                                            <option value="good" {{ old('condition') === 'good' ? 'selected' : '' }}>Good</option>
                                            <option value="fair" {{ old('condition') === 'fair' ? 'selected' : '' }}>Fair</option>
                                            <option value="needs_maintenance" {{ old('condition') === 'needs_maintenance' ? 'selected' : '' }}>Needs Maintenance</option>
                                        </select>
                                        @error('condition') <small class="text-danger">{{ $message }}</small> @enderror
                                        <small class="form-text text-muted">Select the current overall condition of your vehicle</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="registration_expiry" class="form-label">Registration Expiry</label>
                                        <input type="date" class="form-control @error('registration_expiry') is-invalid @enderror" 
                                               id="registration_expiry" name="registration_expiry" value="{{ old('registration_expiry') }}">
                                        @error('registration_expiry') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="insurance_expiry" class="form-label">Insurance Expiry</label>
                                        <input type="date" class="form-control @error('insurance_expiry') is-invalid @enderror" 
                                               id="insurance_expiry" name="insurance_expiry" value="{{ old('insurance_expiry') }}">
                                        @error('insurance_expiry') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="inspection_expiry" class="form-label">Roadworthiness Expiry</label>
                                        <input type="date" class="form-control @error('inspection_expiry') is-invalid @enderror" 
                                               id="inspection_expiry" name="inspection_expiry" value="{{ old('inspection_expiry') }}">
                                        @error('inspection_expiry') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="registration_document" class="form-label">Registration Certificate * (Required)</label>
                                        <input type="file" class="form-control @error('registration_document') is-invalid @enderror" 
                                               id="registration_document" name="registration_document" accept="image/*" required>
                                        <small class="text-muted d-block mt-1"><i class="fas fa-info-circle"></i> Upload clear copy of vehicle registration certificate (PNG, JPG, GIF, max 2MB).</small>
                                        @error('registration_document') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="insurance_document" class="form-label">Insurance Document * (Required)</label>
                                        <input type="file" class="form-control @error('insurance_document') is-invalid @enderror" 
                                               id="insurance_document" name="insurance_document" accept="image/*" required>
                                        <small class="text-muted d-block mt-1"><i class="fas fa-info-circle"></i> Upload current insurance certificate (PNG, JPG, GIF, max 2MB).</small>
                                        @error('insurance_document') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="roadworthiness_certificate" class="form-label">Roadworthiness Certificate * (Required)</label>
                                        <input type="file" class="form-control @error('roadworthiness_certificate') is-invalid @enderror" 
                                               id="roadworthiness_certificate" name="roadworthiness_certificate" accept="image/*" required>
                                        <small class="text-muted d-block mt-1"><i class="fas fa-info-circle"></i> Upload roadworthiness/inspection certificate (PNG, JPG, GIF, max 2MB).</small>
                                        @error('roadworthiness_certificate') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="image_url" class="form-label">Vehicle Images (Optional)</label>
                                        <input type="file" class="form-control @error('image_url') is-invalid @enderror"
                                               id="image_url" name="image_url[]" accept="image/*" multiple>
                                        <small class="text-muted d-block mt-1"><i class="fas fa-info-circle"></i> Upload multiple photos of your vehicle from different angles.</small>
                                        @error('image_url') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-align-left"></i> Additional Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="description" class="form-label">Vehicle Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="4" 
                                                  placeholder="Describe your vehicle's condition, features, maintenance history, and any special notes...">{{ old('description') }}</textarea>
                                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('vehicles.my-vehicles') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-credit-card me-2"></i>Proceed to Payment ({{ config('app.currency_label', 'GHC') }} 30.00)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
