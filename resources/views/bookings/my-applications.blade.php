@extends('layouts.dashboard')

@section('title', 'My Applications')

@section('content')
<div class="content-section">
    <div class="section-header">
        <div>
            <h3>My Applications</h3>
            <p>Review the status of your submitted recruitment applications.</p>
        </div>
        <a href="{{ route('recruitments.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>New Recruitment Post
        </a>
    </div>

    @forelse($applications as $application)
        <div class="recent-item">
            <div class="meta">
                <div>
                    <h5 class="mb-1">{{ $application->recruitment?->title ?? 'Recruitment Application' }}</h5>
                    <p class="text-muted mb-0">Submitted {{ $application->created_at?->diffForHumans() }}</p>
                </div>
                <span class="badge bg-{{ $application->approval_status === 'approved' ? 'success' : ($application->approval_status === 'rejected' ? 'danger' : 'warning') }}">
                    {{ ucfirst($application->approval_status) }}
                </span>
            </div>
            <p class="mb-2 text-muted">Role: <strong>{{ ucfirst(str_replace('_', ' ', $application->application_role ?? 'n/a')) }}</strong></p>
            <p class="text-muted mb-2">{{ \Illuminate\Support\Str::limit($application->description ?? 'No description provided.', 180) }}</p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('bookings.show', $application) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                @if($application->recruitment)
                    <a href="{{ route('recruitments.show', $application->recruitment) }}" class="btn btn-sm btn-soft">View Posting</a>
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> You haven't submitted any applications yet.
        </div>
    @endforelse

    <div class="mt-4">
        {{ $applications->links() }}
    </div>
</div>
@endsection
