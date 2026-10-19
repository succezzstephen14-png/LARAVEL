@extends('layouts.app')

@section('title', 'Apply for Role')

@section('content')
<div class="container-max content-section">
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-file-alt"></i> Apply for {{ $roleLabel }}</h4>
                </div>
                <div class="card-body">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">Opportunity</h5>
                            <p class="mb-1"><strong>{{ $recruitment->title }}</strong></p>
                            <p class="text-muted mb-2">{{ str_replace('_', ' ', ucfirst($recruitment->position_type)) }} • {{ ucfirst($recruitment->status) }}</p>
                            <p class="text-muted mb-2"><strong>Location:</strong> {{ $recruitment->location }}</p>
                            @if($recruitment->salary_range)
                                <p class="text-muted mb-2"><strong>Salary:</strong> {{ $recruitment->salary_range }}</p>
                            @endif
                            @if($recruitment->description)
                                <hr>
                                <p>{{ $recruitment->description }}</p>
                            @endif
                        </div>
                    </div>

                    <form action="{{ request()->is('guest/*') ? route('guest.application.store', ['role' => $routeRole, 'recruitment' => $recruitment->id]) : route('application.store', ['role' => $routeRole, 'recruitment' => $recruitment->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="application_role" value="{{ $routeRole }}">

                        @unless(Auth::check())
                            <div class="alert alert-warning">
                                <i class="fas fa-user-secret me-2"></i>
                                Apply as a guest without logging in. We only need your contact details to follow up.
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="guest_name" class="form-label">Full Name *</label>
                                    <input id="guest_name" name="guest_name" type="text" class="form-control @error('guest_name') is-invalid @enderror" value="{{ old('guest_name') }}" placeholder="Your name" required>
                                    @error('guest_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="guest_email" class="form-label">Email Address *</label>
                                    <input id="guest_email" name="guest_email" type="email" class="form-control @error('guest_email') is-invalid @enderror" value="{{ old('guest_email') }}" placeholder="you@example.com" required>
                                    @error('guest_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="guest_phone" class="form-label">Phone Number *</label>
                                    <input id="guest_phone" name="guest_phone" type="text" class="form-control @error('guest_phone') is-invalid @enderror" value="{{ old('guest_phone') }}" placeholder="Mobile or WhatsApp" required>
                                    @error('guest_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        @endunless

                        <div class="mb-3">
                            <label for="description" class="form-label">Cover Letter / Application Message *</label>
                            <textarea id="description" name="description" rows="6" class="form-control @error('description') is-invalid @enderror" placeholder="Share your experience, skills, and why you're a strong fit for this role...">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="documents" class="form-label">Upload Supporting Documents</label>
                            <input id="documents" name="documents[]" type="file" class="form-control @error('documents.*') is-invalid @enderror" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            @error('documents.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">You can upload resumes, license copies, or certificates (max 5MB each).</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Your application will be sent for review and stored with the selected role.
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('recruitments.show', $recruitment) }}" class="btn btn-outline-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i> Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
