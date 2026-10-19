@extends('layouts.dashboard')

@section('title', 'Post Recruitment')

@section('content')
<div class="container-max content-section">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-briefcase"></i> Post Recruitment</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('recruitments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="position_type" class="form-label">Position Type</label>
                                <select class="form-select" id="position_type" name="position_type" required>
                                    <option value="">Choose</option>
                                    <option value="driver" {{ old('position_type') === 'driver' ? 'selected' : '' }}>Driver</option>
                                    <option value="cleaner" {{ old('position_type') === 'cleaner' ? 'selected' : '' }}>Cleaner</option>
                                    <option value="gateman" {{ old('position_type') === 'gateman' ? 'selected' : '' }}>Gateman</option>
                                    <option value="vehicle_owner" {{ old('position_type') === 'vehicle_owner' ? 'selected' : '' }}>Vehicle owner</option>
                                    <option value="security_guard" {{ old('position_type') === 'security_guard' ? 'selected' : '' }}>Security guard</option>
                                    <option value="delivery_rider" {{ old('position_type') === 'delivery_rider' ? 'selected' : '' }}>Delivery rider</option>
                                    <option value="maintenance_worker" {{ old('position_type') === 'maintenance_worker' ? 'selected' : '' }}>Maintenance worker</option>
                                    <option value="office_assistant" {{ old('position_type') === 'office_assistant' ? 'selected' : '' }}>Office assistant</option>
                                    <option value="housekeeper" {{ old('position_type') === 'housekeeper' ? 'selected' : '' }}>Housekeeper</option>
                                    <option value="warehouse_loader" {{ old('position_type') === 'warehouse_loader' ? 'selected' : '' }}>Warehouse loader</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="requirements" class="form-label">Requirements</label>
                                <textarea class="form-control" id="requirements" name="requirements" rows="3">{{ old('requirements') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="job_brief" class="form-label">Job Brief</label>
                                <input type="file" class="form-control" id="job_brief" name="job_brief" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            </div>
                            <div class="col-md-6">
                                <label for="offer_document" class="form-label">Offer Document</label>
                                <input type="file" class="form-control" id="offer_document" name="offer_document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            </div>
                            <div class="col-md-6">
                                <label for="salary_range_min" class="form-label">Salary Min ({{ config('app.currency_label', 'GHC') }})</label>
                                <input type="number" class="form-control" id="salary_range_min" name="salary_range_min" value="{{ old('salary_range_min') }}" step="0.01" min="0">
                            </div>
                            <div class="col-md-6">
                                <label for="salary_range_max" class="form-label">Salary Max ({{ config('app.currency_label', 'GHC') }})</label>
                                <input type="number" class="form-control" id="salary_range_max" name="salary_range_max" value="{{ old('salary_range_max') }}" step="0.01" min="0">
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('recruitments.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Create Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
