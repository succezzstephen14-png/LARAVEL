@extends('layouts.app')

@section('title', 'My Recruitments')

@section('content')
<div class="container-max content-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>My Recruitment Posts</h2>
            <p class="text-muted">Manage the recruitment posts you have published.</p>
        </div>
        <a href="{{ route('recruitments.create') }}" class="btn btn-primary">Create Post</a>
    </div>

    <div class="row gy-4">
        @forelse($recruitments as $recruitment)
            <div class="col-md-6">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5>{{ $recruitment->title }}</h5>
                        <span class="badge bg-{{ $recruitment->status === 'open' ? 'success' : ($recruitment->status === 'filled' ? 'secondary' : 'warning') }}">
                            {{ ucfirst($recruitment->status) }}
                        </span>
                    </div>
                    <p class="mb-1">Type: {{ str_replace('_', ' ', ucfirst($recruitment->position_type)) }}</p>
                    <p class="mb-1">Location: {{ $recruitment->location }}</p>
                    <a href="{{ route('recruitments.show', $recruitment) }}" class="btn btn-outline-primary btn-sm mt-2">View</a>
                    <a href="{{ route('recruitments.edit', $recruitment) }}" class="btn btn-outline-secondary btn-sm mt-2">Edit</a>
                    <form action="{{ route('recruitments.destroy', $recruitment) }}" method="POST" class="d-inline-block mt-2">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">You have not published any recruitment posts yet.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $recruitments->links() }}</div>
</div>
@endsection
