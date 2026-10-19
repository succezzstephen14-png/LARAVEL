@extends('layouts.admin')

@section('title', 'Edit Driver - SUCCEZZ Drivers Agency')

@section('page-title', 'Edit Driver')
@section('page-description', 'Modify driver information and approval status')

@section('styles')
<style>
    .admin-wrapper {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
        display: flex;
    }

    .admin-sidebar {
        width: 260px;
        background: white;
        padding: 2rem 1rem;
        border-radius: 24px 0 0 24px;
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.08);
        margin-right: 1rem;
    }

    .admin-sidebar h5 {
        margin-bottom: 1.5rem;
        font-weight: 700;
        color: #1f2937;
    }

    .admin-sidebar ul {
        list-style: none;
        padding: 0;
    }

    .admin-sidebar li {
        margin-bottom: 0.5rem;
    }

    .admin-sidebar a {
        display: block;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        text-decoration: none;
        color: #4b5563;
        transition: all 0.2s ease;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .admin-sidebar a:hover, .admin-sidebar a.active {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .admin-main-content {
        flex: 1;
        background: white;
        border-radius: 24px;
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.08);
        padding: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .admin-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .driver-info-panel {
        background: #f8fafc;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .driver-info-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .driver-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .driver-info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .driver-info-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .driver-info-value {
        font-size: 1rem;
        font-weight: 500;
        color: #1f2937;
    }

    .panel {
        background: white;
        border-radius: 24px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.06);
        padding: 1.75rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #ec4899;
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        justify-content: flex-end;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(236, 72, 153, 0.3);
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #1f2937;
    }

    .btn-secondary:hover {
        background: #d1d5db;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    @media (max-width: 1280px) {
        .admin-wrapper {
            flex-direction: column;
        }

        .admin-sidebar {
            border-radius: 24px;
            margin-right: 0;
            margin-bottom: 1rem;
        }

        .admin-main-content {
            border-radius: 24px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-wrapper">
    <section class="admin-main-content">
        <div class="admin-header">
            <div>
                <p style="color: #475569; margin: 0 0 0.5rem 0;">Driver management</p>
                <h2><i class="fas fa-edit"></i> Edit Driver</h2>
            </div>
            <a href="{{ route('admin.drivers') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Drivers
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Validation errors:</strong>
                <ul style="margin: 0.5rem 0 0 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Driver Information -->
        <div class="driver-info-panel">
            <div class="driver-info-title">
                <i class="fas fa-user-tie"></i>
                Driver Details
            </div>
            <div class="driver-info-grid">
                <div class="driver-info-item">
                    <div class="driver-info-label">Name</div>
                    <div class="driver-info-value">{{ $driver->user?->name ?? 'Unknown' }}</div>
                </div>
                <div class="driver-info-item">
                    <div class="driver-info-label">Email</div>
                    <div class="driver-info-value">{{ $driver->user?->email ?? 'N/A' }}</div>
                </div>
                <div class="driver-info-item">
                    <div class="driver-info-label">Phone</div>
                    <div class="driver-info-value">{{ $driver->user?->phone ?? 'N/A' }}</div>
                </div>
                <div class="driver-info-item">
                    <div class="driver-info-label">Date of Birth</div>
                    <div class="driver-info-value">{{ $driver->dob ? \Carbon\Carbon::parse($driver->dob)->format('M d, Y') : 'N/A' }}</div>
                </div>
                <div class="driver-info-item">
                    <div class="driver-info-label">License Class</div>
                    <div class="driver-info-value">{{ $driver->license_class ?? 'N/A' }}</div>
                </div>
                <div class="driver-info-item">
                    <div class="driver-info-label">Ghana Card</div>
                    <div class="driver-info-value">{{ $driver->ghana_card_no ?? 'N/A' }}</div>
                </div>
                <div class="driver-info-item">
                    <div class="driver-info-label">Experience</div>
                    <div class="driver-info-value">{{ $driver->experience_years ?? 0 }} years</div>
                </div>
                <div class="driver-info-item">
                    <div class="driver-info-label">Rating</div>
                    <div class="driver-info-value">
                        @if($driver->rating)
                            <i class="fas fa-star text-warning"></i> {{ number_format($driver->rating, 1) }}
                        @else
                            Not rated
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="panel">
            <form action="{{ route('admin.drivers.update-admin', $driver) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="license_number">License Number</label>
                    <input type="text" id="license_number" name="license_number" value="{{ old('license_number', $driver->license_number) }}" required>
                </div>

                <div class="form-group">
                    <label for="license_expiry">License Expiry Date</label>
                    <input type="date" id="license_expiry" name="license_expiry" value="{{ old('license_expiry', $driver->license_expiry ? \Carbon\Carbon::parse($driver->license_expiry)->format('Y-m-d') : '') }}" required>
                </div>

                <div class="form-group">
                    <label for="experience_years">Years of Experience</label>
                    <input type="number" id="experience_years" name="experience_years" value="{{ old('experience_years', $driver->experience_years) }}" min="0" max="60" required>
                </div>

                <div class="form-group">
                    <label for="status">Driver Status</label>
                    <select id="status" name="status" required>
                        <option value="available" {{ old('status', $driver->status) === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ old('status', $driver->status) === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                        <option value="on_duty" {{ old('status', $driver->status) === 'on_duty' ? 'selected' : '' }}>On Duty</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="approval_status">Approval Status</label>
                    <select id="approval_status" name="approval_status" required>
                        <option value="pending" {{ old('approval_status', $driver->approval_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('approval_status', $driver->approval_status) === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('approval_status', $driver->approval_status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.drivers') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection