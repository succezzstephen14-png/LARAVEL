@extends('layouts.admin')

@section('title', 'Edit Recruitment - SUCCEZZ Drivers Agency')

@section('page-title', 'Edit Recruitment')
@section('page-description', 'Modify recruitment posting and approval status')

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

    .recruitment-info-panel {
        background: #f8fafc;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .recruitment-info-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .recruitment-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .recruitment-info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .recruitment-info-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .recruitment-info-value {
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
                <p style="color: #475569; margin: 0 0 0.5rem 0;">Recruitment management</p>
                @if($recruitment && $recruitment->exists)
                    <h2><i class="fas fa-edit"></i> Edit Recruitment</h2>
                @else
                    <h2><i class="fas fa-plus"></i> Create New Recruitment</h2>
                @endif
            </div>
            <a href="{{ route('admin.recruitments') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Recruitments
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

        <!-- Recruitment Information -->
        @if($recruitment && $recruitment->exists)
        <div class="recruitment-info-panel">
            <div class="recruitment-info-title">
                <i class="fas fa-briefcase"></i>
                Recruitment Details
            </div>
            <div class="recruitment-info-grid">
                <div class="recruitment-info-item">
                    <div class="recruitment-info-label">Posted By</div>
                    <div class="recruitment-info-value">{{ $recruitment->user?->name ?? 'Unknown' }}</div>
                </div>
                <div class="recruitment-info-item">
                    <div class="recruitment-info-label">Position Type</div>
                    <div class="recruitment-info-value">
                        <i class="fas fa-briefcase"></i> {{ str_replace('_', ' ', ucfirst($recruitment->position_type)) }}
                    </div>
                </div>
                <div class="recruitment-info-item">
                    <div class="recruitment-info-label">Location</div>
                    <div class="recruitment-info-value">{{ $recruitment->location ?? 'N/A' }}</div>
                </div>
                <div class="recruitment-info-item">
                    <div class="recruitment-info-label">Posted Date</div>
                    <div class="recruitment-info-value">{{ optional($recruitment->created_at)->format('M d, Y') ?? 'N/A' }}</div>
                </div>
                <div class="recruitment-info-item">
                    <div class="recruitment-info-label">Salary Range</div>
                    <div class="recruitment-info-value">
                        @if($recruitment->salary_range_min && $recruitment->salary_range_max)
                            {{ config('app.currency_label', 'GHC') }} {{ number_format($recruitment->salary_range_min, 2) }} - {{ config('app.currency_label', 'GHC') }} {{ number_format($recruitment->salary_range_max, 2) }}
                        @elseif($recruitment->salary_range_min)
                            {{ config('app.currency_label', 'GHC') }} {{ number_format($recruitment->salary_range_min, 2) }}+
                        @elseif($recruitment->salary_range_max)
                            Up to {{ config('app.currency_label', 'GHC') }} {{ number_format($recruitment->salary_range_max, 2) }}
                        @else
                            Not specified
                        @endif
                    </div>
                </div>
                <div class="recruitment-info-item">
                    <div class="recruitment-info-label">Status</div>
                    <div class="recruitment-info-value">
                        @if($recruitment->status === 'open')
                            <span style="color: #059669;"><i class="fas fa-circle"></i> Open</span>
                        @elseif($recruitment->status === 'closed')
                            <span style="color: #dc2626;"><i class="fas fa-circle"></i> Closed</span>
                        @else
                            <span style="color: #7c3aed;"><i class="fas fa-circle"></i> Filled</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Edit/Create Form -->
        <div class="panel">
            @if($recruitment && $recruitment->exists)
            <form action="{{ route('admin.recruitments.update-admin', $recruitment) }}" method="POST">
                @csrf
                @method('PUT')
            @else
            <form action="{{ route('admin.recruitments.store') }}" method="POST">
                @csrf
            @endif

                <div class="form-group">
                    <label for="title">Job Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $recruitment?->title ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Job Description</label>
                    <textarea id="description" name="description" rows="4" required>{{ old('description', $recruitment?->description ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="position_type">Position Type</label>
                    <select id="position_type" name="position_type" required>
                        <option value="driver" {{ old('position_type', $recruitment?->position_type) === 'driver' ? 'selected' : '' }}>Driver</option>
                        <option value="cleaner" {{ old('position_type', $recruitment?->position_type) === 'cleaner' ? 'selected' : '' }}>Cleaner</option>
                        <option value="gateman" {{ old('position_type', $recruitment?->position_type) === 'gateman' ? 'selected' : '' }}>Gateman</option>
                        <option value="vehicle_owner" {{ old('position_type', $recruitment?->position_type) === 'vehicle_owner' ? 'selected' : '' }}>Vehicle owner</option>
                        <option value="security_guard" {{ old('position_type', $recruitment?->position_type) === 'security_guard' ? 'selected' : '' }}>Security guard</option>
                        <option value="delivery_rider" {{ old('position_type', $recruitment?->position_type) === 'delivery_rider' ? 'selected' : '' }}>Delivery rider</option>
                        <option value="maintenance_worker" {{ old('position_type', $recruitment?->position_type) === 'maintenance_worker' ? 'selected' : '' }}>Maintenance worker</option>
                        <option value="office_assistant" {{ old('position_type', $recruitment?->position_type) === 'office_assistant' ? 'selected' : '' }}>Office assistant</option>
                        <option value="housekeeper" {{ old('position_type', $recruitment?->position_type) === 'housekeeper' ? 'selected' : '' }}>Housekeeper</option>
                        <option value="warehouse_loader" {{ old('position_type', $recruitment?->position_type) === 'warehouse_loader' ? 'selected' : '' }}>Warehouse loader</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $recruitment?->location ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label for="status">Job Status</label>
                    <select id="status" name="status" required>
                        <option value="open" {{ old('status', $recruitment?->status) === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ old('status', $recruitment?->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="filled" {{ old('status', $recruitment?->status) === 'filled' ? 'selected' : '' }}>Filled</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="approval_status">Approval Status</label>
                    <select id="approval_status" name="approval_status" required>
                        <option value="pending" {{ old('approval_status', $recruitment?->approval_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('approval_status', $recruitment?->approval_status) === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('approval_status', $recruitment?->approval_status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="salary_range_min">Minimum Salary ({{ config('app.currency_label', 'GHC') }})</label>
                        <input type="number" id="salary_range_min" name="salary_range_min" value="{{ old('salary_range_min', $recruitment?->salary_range_min ?? '') }}" min="0" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="salary_range_max">Maximum Salary ({{ config('app.currency_label', 'GHC') }})</label>
                        <input type="number" id="salary_range_max" name="salary_range_max" value="{{ old('salary_range_max', $recruitment?->salary_range_max ?? '') }}" min="0" step="0.01">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.recruitments') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection