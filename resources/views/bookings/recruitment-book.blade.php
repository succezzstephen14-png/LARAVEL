@extends('layouts.app')

@section('title', 'Apply for Opportunity')

@section('content')
<div class="container-max content-section">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-file-alt"></i> Apply for Opportunity</h4>
                </div>
                <div class="card-body">
                    <!-- Opportunity Information -->
                    <div class="card mb-4 bg-light">
                        <div class="card-body">
                            <h5>{{ $recruitment->title }}</h5>
                            <p class="text-muted mb-1">Type: {{ str_replace('_', ' ', ucfirst($recruitment->position_type)) }}</p>
                            <p class="text-muted mb-1">Location: {{ $recruitment->location }}</p>
                            <p class="text-muted mb-1">Status: <span class="badge bg-{{ $recruitment->status === 'open' ? 'success' : 'secondary' }}">{{ ucfirst($recruitment->status) }}</span></p>
                            @if($recruitment->salary_range)
                                <p class="text-muted mb-2">Salary: {{ $recruitment->salary_range }}</p>
                            @endif
                            @if($recruitment->description)
                                <hr>
                                <p>{{ $recruitment->description }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Application Form -->
                    <form action="{{ route('recruitments.apply', $recruitment) }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="description" class="form-label">Cover Letter / Application Message *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="6" 
                                          placeholder="Tell us why you're interested in this position, your relevant experience, skills, and why you'd be a great fit for this role...">{{ old('description') }}</textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Application:</strong> Your application will be submitted for admin approval before being visible to the recruiter.
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('recruitments.show', $recruitment) }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
