@extends('layouts.app')

@section('title', 'Request Recruitment Posting')

@section('content')
<div class="container-max section-inner">
    <div class="section-card">
        <h2>Request a Recruitment Posting</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('recruitments.request.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Your name</label>
                <input type="text" name="guest_name" class="form-control" required value="{{ old('guest_name') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="guest_email" class="form-control" required value="{{ old('guest_email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="guest_phone" class="form-control" value="{{ old('guest_phone') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Job Title</label>
                <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="6" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Position Type</label>
                <select name="position_type" class="form-control" required>
                    <option value="driver">Driver</option>
                    <option value="cleaner">Cleaner</option>
                    <option value="gateman">Gateman</option>
                    <option value="vehicle_owner">Vehicle owner</option>
                    <option value="security_guard">Security guard</option>
                    <option value="delivery_rider">Delivery rider</option>
                    <option value="maintenance_worker">Maintenance worker</option>
                    <option value="office_assistant">Office assistant</option>
                    <option value="housekeeper">Housekeeper</option>
                    <option value="warehouse_loader">Warehouse loader</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Requirements (optional)</label>
                <textarea name="requirements" class="form-control" rows="3">{{ old('requirements') }}</textarea>
            </div>

            <button class="btn btn-primary">Submit request</button>
        </form>
    </div>
</div>
@endsection
