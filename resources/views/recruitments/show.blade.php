@extends('layouts.app')

@section('title', 'Recruitment Post')

@section('content')
<div class="container-max content-section py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="recruitment-hero p-5 rounded-4 shadow-sm mb-5">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-4">
                    <div>
                        <h1 class="hero-title mb-2">{{ $recruitment->title }}</h1>
                        <p class="hero-subtitle mb-3">{{ str_replace('_', ' ', ucfirst($recruitment->position_type)) }} • <span class="badge bg-success text-uppercase">{{ ucfirst($recruitment->status) }}</span></p>
                        <p class="text-muted fs-5">{{ $recruitment->summary ?? 'A great opportunity for motivated candidates with the right skills and commitment.' }}</p>
                    </div>
                    <div class="text-md-end">
                        <p class="mb-2 text-secondary">Posted by</p>
                        <h5 class="mb-0">{{ $recruitment->user?->name ?? 'Unknown' }}</h5>
                        <p class="text-muted">{{ $recruitment->created_at->format('M j, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                        <div class="mb-4">
                            <h4 class="section-heading">Job details</h4>
                            <p class="section-text text-muted">Everything you need to know before applying for this role.</p>
                        </div>
                        <div class="row gx-4 gy-3">
                            <div class="col-12 col-sm-6">
                                <div class="detail-card p-3 rounded-3 border">
                                    <span class="detail-label">Location</span>
                                    <p class="mb-0 detail-value">{{ $recruitment->location }}</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="detail-card p-3 rounded-3 border">
                                    <span class="detail-label">Salary</span>
                                    <p class="mb-0 detail-value">{{ $recruitment->salary_range_min !== null ? config('app.currency_label', 'GHC') . ' ' . number_format($recruitment->salary_range_min, 2) . ' - ' . config('app.currency_label', 'GHC') . ' ' . number_format($recruitment->salary_range_max, 2) : 'Not specified' }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-card p-3 rounded-3 border">
                                    <span class="detail-label">Requirements</span>
                                    <p class="mb-0 detail-value">{{ $recruitment->requirements ?? 'Not specified' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-gradient-light">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h4 class="section-heading mb-1">Apply for this role</h4>
                                <p class="text-muted mb-0">Fast, secure application with just one click.</p>
                            </div>
                            <div class="badge bg-primary py-2 px-3 text-uppercase">{{ str_replace('_', ' ', ucfirst($recruitment->position_type)) }}</div>
                        </div>
                        <ul class="list-unstyled application-list mb-4">
                            <li><i class="fas fa-check-circle text-success me-2"></i> Competitive pay structure</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Flexible schedule options</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Supportive team environment</li>
                        </ul>

                        @php
                            $applyRole = str_replace('_', '-', $recruitment->position_type);
                        @endphp

                        <div class="d-grid gap-3">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg">Back to listings</a>
                            @auth
                                @if(auth()->id() === $recruitment->user_id || auth()->user()->isAdmin())
                                    <a href="{{ route('recruitments.edit', $recruitment) }}" class="btn btn-outline-primary btn-lg">Edit Post</a>
                                @elseif(auth()->check() && $recruitment->approval_status === 'approved' && $recruitment->status === 'open')
                                    <a href="{{ route('application.page', ['role' => $applyRole, 'recruitment' => $recruitment->id]) }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i> Apply Now
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-lg" disabled>
                                        <i class="fas fa-paper-plane me-2"></i> Application Not Available
                                    </button>
                                @endif
                            @else
                                @if($recruitment->approval_status === 'approved' && $recruitment->status === 'open')
                                    <a href="{{ url('/guest/apply/' . $applyRole . '/' . $recruitment->id) }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i> Apply Now
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-lg" disabled>
                                        <i class="fas fa-clock me-2"></i> Application Not Available
                                    </button>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
    <style>
        .recruitment-hero {
            background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);
            border: 1px solid rgba(99, 102, 241, 0.12);
        }
        .hero-title {
            font-size: clamp(2rem, 2.5vw, 2.8rem);
            margin-bottom: 0.5rem;
            color: #111827;
        }
        .hero-subtitle {
            color: #374151;
            font-size: 1rem;
        }
        .section-heading {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
        }
        .section-text {
            color: #6b7280;
        }
        .detail-card {
            background: #ffffff;
            border-color: rgba(148, 163, 184, 0.18);
        }
        .detail-label {
            display: block;
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .detail-value {
            font-size: 1rem;
            color: #111827;
            line-height: 1.6;
        }
        .bg-gradient-light {
            background: linear-gradient(180deg, rgba(249, 250, 251, 0.98) 0%, rgba(241, 245, 249, 0.98) 100%);
        }
        .application-list li {
            margin-bottom: 0.9rem;
            font-size: 0.97rem;
            color: #374151;
        }
        .application-list i {
            width: 22px;
            text-align: center;
        }
    </style>
@endsection
@endsection
