@extends('layouts.admin')

@section('title', 'Pending Recruitment Approvals')

@section('content')
<style>
    .admin-wrapper {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
    }
    .admin-header {
        background: white;
        padding: 1.5rem 2rem;
        border-radius: 24px;
        margin-bottom: 2rem;
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .admin-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
    }
    .recruitments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .recruitment-approval-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);
        border: 1px solid rgba(15, 23, 42, 0.06);
    }
    .recruitment-card-header {
        background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
        color: white;
        padding: 1.5rem;
    }
    .recruitment-card-header h5 {
        margin: 0 0 0.5rem;
        font-size: 1.1rem;
    }
    .pending-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.25);
        color: white;
    }
    .recruitment-card-body {
        padding: 1.5rem;
    }
    .recruitment-info-row {
        display: grid;
        grid-template-columns: 140px 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }
    .recruitment-info-row strong {
        color: #6b7280;
        font-weight: 600;
    }
    .recruitment-info-row .value {
        color: #111827;
        font-weight: 500;
    }
    .description-box {
        margin: 1rem 0;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 12px;
        border-left: 3px solid #0284c7;
        font-size: 0.9rem;
        color: #374151;
    }
    .recruitment-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }
    .approve-btn {
        padding: 0.75rem 1rem;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .approve-btn:hover {
        background: #059669;
    }
    .reject-btn {
        padding: 0.75rem 1rem;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .reject-btn:hover {
        background: #dc2626;
    }
</style>

<div class="admin-wrapper">
    <div class="container-max">
        <div class="admin-header">
            <h2><i class="fas fa-briefcase"></i> Pending Recruitment Approvals</h2>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>

        @if($recruitments->count() === 0 && (!isset($requests) || $requests->count() === 0))
            <div style="background: white; padding: 3rem 2rem; border-radius: 18px; text-align: center; box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);">
                <i class="fas fa-check-circle" style="font-size: 3rem; color: #10b981; margin-bottom: 1rem; display: block;"></i>
                <p style="color: #10b981; font-weight: 600; margin: 0; font-size: 1.1rem;">All pending recruitments and requests have been processed</p>
            </div>
        @endif

        @if($recruitments->count() > 0)
            <h3 style="margin-bottom: 1rem;">Pending Recruitment Posts</h3>
            <div class="recruitments-grid">
                @foreach($recruitments as $recruitment)
                    <div class="recruitment-approval-card">
                        <div class="recruitment-card-header">
                            <h5><i class="fas fa-scroll"></i> {{ $recruitment->title }}</h5>
                            <span class="pending-badge">Pending Review</span>
                        </div>
                        <div class="recruitment-card-body">
                            <div class="recruitment-info-row">
                                <strong>Company:</strong>
                                <span class="value">{{ $recruitment->company_name ?? 'N/A' }}</span>
                            </div>
                            <div class="recruitment-info-row">
                                <strong>Posted By:</strong>
                                <span class="value">{{ $recruitment->user->name }}</span>
                            </div>
                            <div class="recruitment-info-row">
                                <strong>Position:</strong>
                                <span class="value">{{ $recruitment->position_type ?? 'N/A' }}</span>
                            </div>
                            <div class="recruitment-info-row">
                                <strong>Salary:</strong>
                                <span class="value">{{ $recruitment->salary_range ?? 'Negotiable' }}</span>
                            </div>
                            <div class="description-box">
                                <strong style="display: block; margin-bottom: 0.5rem;">Description</strong>
                                {{ Str::limit($recruitment->description, 150) }}
                            </div>

                            <div style="margin: 1rem 0;">
                                <a href="{{ route('admin.recruitments.detail', $recruitment) }}" class="btn btn-outline-primary w-100">View full recruitment details</a>
                            </div>

                            <div class="recruitment-actions">
                                <form action="{{ route('admin.recruitments.approve', $recruitment) }}" method="POST" style="width: 100%;">
                                    @csrf
                                    <button type="submit" class="approve-btn w-100">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <button type="button" class="reject-btn" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $recruitment->id }}">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Reject Modal -->
                    <div class="modal fade" id="rejectModal{{ $recruitment->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Reject Recruitment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.recruitments.reject', $recruitment) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <label for="rejection_reason_{{ $recruitment->id }}" class="form-label">Reason for Rejection</label>
                                        <textarea class="form-control" id="rejection_reason_{{ $recruitment->id }}" name="rejection_reason" rows="4" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Reject Recruitment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $recruitments->links() }}
            </div>
        @endif

        @if(isset($requests) && $requests->count() > 0)
            <h3 style="margin: 2rem 0 1rem;">Guest Recruitment Requests</h3>
            <div class="recruitments-grid">
                @foreach($requests as $requestItem)
                    <div class="recruitment-approval-card">
                        <div class="recruitment-card-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                            <h5><i class="fas fa-envelope-open-text"></i> {{ $requestItem->title }}</h5>
                            <span class="pending-badge">Guest Request</span>
                        </div>
                        <div class="recruitment-card-body">
                            <div class="recruitment-info-row">
                                <strong>Requested By:</strong>
                                <span class="value">{{ $requestItem->guest_name }}</span>
                            </div>
                            <div class="recruitment-info-row">
                                <strong>Email:</strong>
                                <span class="value">{{ $requestItem->guest_email }}</span>
                            </div>
                            <div class="recruitment-info-row">
                                <strong>Phone:</strong>
                                <span class="value">{{ $requestItem->guest_phone ?? 'N/A' }}</span>
                            </div>
                            <div class="recruitment-info-row">
                                <strong>Position:</strong>
                                <span class="value">{{ $requestItem->position_type }}</span>
                            </div>
                            <div class="recruitment-info-row">
                                <strong>Location:</strong>
                                <span class="value">{{ $requestItem->location }}</span>
                            </div>
                            <div class="description-box">
                                <strong style="display: block; margin-bottom: 0.5rem;">Request Details</strong>
                                {{ Str::limit($requestItem->description, 150) }}
                            </div>

                            <div class="recruitment-actions">
                                <form action="{{ route('admin.recruitment-requests.approve', $requestItem) }}" method="POST" style="width: 100%;">
                                    @csrf
                                    <button type="submit" class="approve-btn w-100">
                                        <i class="fas fa-check"></i> Approve Request
                                    </button>
                                </form>
                                <button type="button" class="reject-btn" data-bs-toggle="modal" data-bs-target="#rejectRequestModal{{ $requestItem->id }}">
                                    <i class="fas fa-times"></i> Reject Request
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="rejectRequestModal{{ $requestItem->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Reject Recruitment Request</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.recruitment-requests.reject', $requestItem) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <label for="rejection_reason_request_{{ $requestItem->id }}" class="form-label">Reason for Rejection</label>
                                        <textarea class="form-control" id="rejection_reason_request_{{ $requestItem->id }}" name="rejection_reason" rows="4" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Reject Request</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

