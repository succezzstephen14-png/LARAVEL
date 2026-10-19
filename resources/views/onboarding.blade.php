@extends('layouts.app')

@section('title', 'Welcome Onboard!')

@section('content')
<div class="container-max my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Onboarding Progress -->
            <div class="card mb-5">
                <div class="card-body">
                    <h3 class="mb-4">
                        <i class="fas fa-rocket text-primary me-2"></i>Welcome to VDR System, {{ $user->name }}!
                    </h3>
                    <p class="text-muted mb-4">Follow these steps to complete your onboarding and start using the platform:</p>

                    <!-- Progress Steps -->
                    <div class="progress mb-4" style="height: 25px;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{ $onboardingProgress }}%;" 
                             aria-valuenow="{{ $onboardingProgress }}" 
                             aria-valuemin="0" aria-valuemax="100">
                            {{ $onboardingProgress }}%
                        </div>
                    </div>

                    <!-- Steps List -->
                    <div class="row">
                        <!-- Step 1: Complete Profile -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 {{ $steps['profile'] ? 'border-success' : 'border-light' }}">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        @if($steps['profile'])
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                        @else
                                            <i class="fas fa-circle-notch text-muted me-2"></i>
                                        @endif
                                        Step 1: Profile
                                    </h5>
                                    <p class="card-text text-muted small mb-3">
                                        Complete your profile information
                                    </p>
                                    <a href="{{ route('profile') }}" class="btn btn-primary btn-sm w-100">
                                        {{ $steps['profile'] ? 'View Profile' : 'Complete Now' }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Create Driver Profile -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 {{ $steps['driver'] ? 'border-success' : 'border-light' }}">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        @if($steps['driver'])
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                        @else
                                            <i class="fas fa-circle-notch text-muted me-2"></i>
                                        @endif
                                        Step 2: Driver Profile
                                    </h5>
                                    <p class="card-text text-muted small mb-3">
                                        Create your driver profile & make payment
                                    </p>
                                    <a href="{{ route('drivers.create') }}" class="btn btn-primary btn-sm w-100">
                                        {{ $steps['driver'] ? 'View Profile' : 'Create Now' }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Add Vehicle -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 {{ $steps['vehicle'] ? 'border-success' : 'border-light' }}">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        @if($steps['vehicle'])
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                        @else
                                            <i class="fas fa-circle-notch text-muted me-2"></i>
                                        @endif
                                        Step 3: Add Vehicle
                                    </h5>
                                    <p class="card-text text-muted small mb-3">
                                        Register your vehicle on the platform
                                    </p>
                                    <a href="{{ route('vehicles.create') }}" class="btn btn-primary btn-sm w-100">
                                        {{ $steps['vehicle'] ? 'View Vehicle' : 'Add Now' }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Post Recruitment -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 {{ $steps['recruitment'] ? 'border-success' : 'border-light' }}">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        @if($steps['recruitment'])
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                        @else
                                            <i class="fas fa-circle-notch text-muted me-2"></i>
                                        @endif
                                        Step 4: Post Recruitment
                                    </h5>
                                    <p class="card-text text-muted small mb-3">
                                        Post a recruitment or job listing (Optional)
                                    </p>
                                    <a href="{{ route('recruitments.create') }}" class="btn btn-outline-primary btn-sm w-100">
                                        {{ $steps['recruitment'] ? 'View Posts' : 'Post Now' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center p-4 mb-4">
                        <i class="fas fa-truck text-primary mb-2" style="font-size: 2rem;"></i>
                        <h5>Vehicles</h5>
                        <p class="display-6">{{ $stats['vehicles'] ?? 0 }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-4 mb-4">
                        <i class="fas fa-user text-primary mb-2" style="font-size: 2rem;"></i>
                        <h5>Driver Profile</h5>
                        <p class="display-6">{{ $stats['drivers'] ?? 0 }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-4 mb-4">
                        <i class="fas fa-clipboard text-primary mb-2" style="font-size: 2rem;"></i>
                        <h5>Recruitments</h5>
                        <p class="display-6">{{ $stats['recruitments'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="alert alert-info">
                <i class="fas fa-lightbulb me-2"></i>
                <strong>Pro Tip:</strong> Complete at least Step 1 and Step 2 to start appearing on the platform and connect with others!
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    <i class="fas fa-home me-2"></i>Back to Home
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-right me-2"></i>Go to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
