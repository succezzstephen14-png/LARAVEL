@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-car me-2"></i>Vehicle Management Dashboard</h2>
            <p class="text-muted">Manage all registered vehicles, approvals, and availability</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-filter"></i> Filters & Search</h6>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search by name, model, plate..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="approval_status" class="form-select">
                        <option value="">All Approval Status</option>
                        @foreach($approvalStatuses as $status)
                            <option value="{{ $status }}" 
                                    {{ request('approval_status') === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="availability_status" class="form-select">
                        <option value="">All Availability</option>
                        @foreach($availabilityStatuses as $status)
                            <option value="{{ $status }}" 
                                    {{ request('availability_status') === $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="condition" class="form-select">
                        <option value="">All Conditions</option>
                        @foreach($conditions as $cond)
                            <option value="{{ $cond }}" 
                                    {{ request('condition') === $cond ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $cond)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Vehicles Table -->
    <div class="card">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-list"></i> Vehicles ({{ $vehicles->total() }} total)</h6>
            <span class="badge bg-info">
                Showing {{ $vehicles->firstItem() ?? 0 }} to {{ $vehicles->lastItem() ?? 0 }}
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Vehicle</th>
                        <th>Owner</th>
                        <th>Condition</th>
                        <th>Approval Status</th>
                        <th>Availability</th>
                        <th>Documents</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                    <tr>
                        <td>
                            <strong>{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</strong><br>
                            <small class="text-muted">{{ $vehicle->license_plate }}</small>
                        </td>
                        <td>
                            <strong>{{ $vehicle->user->name }}</strong><br>
                            <small class="text-muted">{{ $vehicle->user->email }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $vehicle->condition)) }}</span>
                        </td>
                        <td>
                            @if($vehicle->approval_status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($vehicle->approval_status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @elseif($vehicle->approval_status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($vehicle->approval_status) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($vehicle->availability_status === 'available')
                                <span class="badge bg-success">Available</span>
                            @elseif($vehicle->availability_status === 'in_use')
                                <span class="badge bg-info">In Use</span>
                            @else
                                <span class="badge bg-danger">Unavailable</span>
                            @endif
                        </td>
                        <td>
                            <div class="small">
                                @if($vehicle->registration_document)
                                    <i class="fas fa-file text-success"></i> Reg
                                @endif
                                @if($vehicle->insurance_document)
                                    <i class="fas fa-file text-success"></i> Ins
                                @endif
                                @if($vehicle->roadworthiness_certificate)
                                    <i class="fas fa-file text-success"></i> RWC
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.vehicles.show', $vehicle) }}" 
                                   class="btn btn-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($vehicle->approval_status === 'pending')
                                    <form method="POST" 
                                          action="{{ route('admin.vehicles.approve', $vehicle) }}" 
                                          style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success" 
                                                title="Approve Vehicle">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <button class="btn btn-warning" data-bs-toggle="modal" 
                                        data-bs-target="#editAvailabilityModal{{ $vehicle->id }}"
                                        title="Edit Availability">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Availability Modal -->
                    <div class="modal fade" id="editAvailabilityModal{{ $vehicle->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" 
                                      action="{{ route('admin.vehicles.update-availability', $vehicle) }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Availability</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label class="form-label">Availability Status:</label>
                                        <select name="availability_status" class="form-select" required>
                                            <option value="">Select Status</option>
                                            <option value="available" {{ $vehicle->availability_status === 'available' ? 'selected' : '' }}>
                                                Available
                                            </option>
                                            <option value="in_use" {{ $vehicle->availability_status === 'in_use' ? 'selected' : '' }}>
                                                In Use
                                            </option>
                                            <option value="unavailable" {{ $vehicle->availability_status === 'unavailable' ? 'selected' : '' }}>
                                                Unavailable
                                            </option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-car text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-3">No vehicles found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($vehicles->hasPages())
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $vehicles->firstItem() }} to {{ $vehicles->lastItem() }} 
                    of <strong>{{ $vehicles->total() }}</strong> vehicles
                </div>
                <nav>
                    <ul class="pagination mb-0">
                        @if($vehicles->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">← Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $vehicles->previousPageUrl() }}">← Previous</a>
                            </li>
                        @endif

                        @foreach($vehicles->getUrlRange(1, $vehicles->lastPage()) as $page => $url)
                            @if($page == $vehicles->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        @if($vehicles->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $vehicles->nextPageUrl() }}">Next →</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next →</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
