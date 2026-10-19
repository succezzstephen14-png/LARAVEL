@extends('layouts.dashboard')

@section('title', 'Profile')

@section('content')
<div class="container-max content-section">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-user"></i> Profile</h4>
                        @if(!empty($user->phone) && !empty($user->address))
                            <span class="badge bg-success">Complete</span>
                        @else
                            <span class="badge bg-warning">Incomplete</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $user->name }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $user->email }}</dd>

                        <dt class="col-sm-4">Role</dt>
                        <dd class="col-sm-8">{{ ucfirst($user->role) }}</dd>

                        <dt class="col-sm-4">Phone</dt>
                        <dd class="col-sm-8">
                            {{ $user->phone ?? '-' }}
                            @if(!$user->phone)
                                <small class="text-danger d-block">Missing</small>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Address</dt>
                        <dd class="col-sm-8">
                            {{ $user->address ?? '-' }}
                            @if(!$user->address)
                                <small class="text-danger d-block">Missing</small>
                            @endif
                        </dd>
                    </dl>

                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
