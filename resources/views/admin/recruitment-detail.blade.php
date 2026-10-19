@extends('layouts.admin')

@section('title', 'Recruitment Details')

@section('content')
<style>
    .review-wrapper {
        max-width: 1000px;
        margin: 2rem auto;
        padding: 1rem;
    }
    .review-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }
    .review-header {
        background: #1d4ed8;
        color: white;
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .review-header h1 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 800;
    }
    .status-pill {
        background: #f59e0b;
        color: white;
        padding: 0.65rem 1rem;
        border-radius: 999px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .review-body {
        padding: 2rem;
        display: grid;
        gap: 1.5rem;
    }
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
    }
    .detail-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 1.25rem;
    }
    .detail-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #6b7280;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .detail-value {
        color: #111827;
        font-weight: 600;
        line-height: 1.5;
    }
    .description-box {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 1.5rem;
        font-size: 0.95rem;
        color: #374151;
        line-height: 1.7;
    }
    .documents-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        gap: 0.75rem;
    }
    .documents-list li {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }
    .documents-list a {
        color: #1d4ed8;
        text-decoration: none;
        font-weight: 700;
    }
    .action-row {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    .btn-action {
        border: none;
        border-radius: 14px;
        padding: 0.9rem 1.4rem;
        font-weight: 700;
        cursor: pointer;
    }
    .btn-approve {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    .btn-reject {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
</style>

<div class="review-wrapper">
    <a href="{{ route('admin.pending-recruitments') }}" class="btn btn-outline-secondary" style="margin-bottom: 1rem;">← Back to pending recruitments</a>

    <div class="review-card">
        <div class="review-header">
            <div>
                <h1>{{ $recruitment->title }}</h1>
                <p style="opacity: .85; margin: .5rem 0 0;">Posted by {{ $recruitment->user->name }} — {{ $recruitment->user->email }}</p>
            </div>
            <div class="status-pill {{ $recruitment->approval_status }}">{{ ucfirst($recruitment->approval_status) }}</div>
        </div>

        <div class="review-body">
            <div class="detail-grid">
                <div class="detail-box">
                    <div class="detail-label">Location</div>
                    <div class="detail-value">{{ $recruitment->location ?? 'Not specified' }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Position type</div>
                    <div class="detail-value">{{ ucfirst($recruitment->position_type ?? 'N/A') }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Salary range</div>
                    <div class="detail-value">{{ $recruitment->salary_range }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Posted</div>
                    <div class="detail-value">{{ optional($recruitment->posted_at)->format('M d, Y') ?? $recruitment->created_at->format('M d, Y') }}</div>
                </div>
            </div>

            <div class="description-box">
                <strong>Description</strong>
                <p style="margin: .75rem 0 0;">{{ $recruitment->description ?? 'No description provided.' }}</p>
            </div>

            @if($recruitment->requirements)
                <div class="detail-box">
                    <div class="detail-label">Requirements</div>
                    <div class="detail-value">{{ $recruitment->requirements }}</div>
                </div>
            @endif

            <div class="detail-box">
                <div class="detail-label">Attachments</div>
                @php
                    $attachments = [
                        'Job Brief' => $recruitment->job_brief,
                        'Offer Document' => $recruitment->offer_document,
                    ];
                @endphp
                @if(count(array_filter($attachments)) > 0)
                    <ul class="documents-list">
                        @foreach($attachments as $label => $path)
                            @if($path)
                                <li>
                                    <span>{{ $label }}</span>
                                    <a href="{{ route('admin.documents.show', ['type' => 'recruitment', 'id' => $recruitment->id, 'field' => $label === 'Job Brief' ? 'job_brief' : 'offer_document']) }}" target="_blank">View</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <div class="detail-value">No file attachments are available for this recruitment.</div>
                @endif
            </div>

            <div class="action-row">
                <form action="{{ route('admin.recruitments.approve', $recruitment) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-action btn-approve">Approve Recruitment</button>
                </form>
                <button type="button" class="btn-action btn-reject" data-bs-toggle="modal" data-bs-target="#rejectRecruitmentModal">Reject Recruitment</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectRecruitmentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Recruitment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.recruitments.reject', $recruitment) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                            <textarea id="rejection_reason" name="rejection_reason" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Recruitment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
