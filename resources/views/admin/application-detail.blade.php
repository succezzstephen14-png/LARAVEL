@extends('layouts.admin')

@section('title', 'Application Details')

@section('content')
<style>
    .application-detail-wrapper {
        max-width: 1100px;
        margin: 2rem auto;
        padding: 1rem;
    }

    .detail-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .detail-header {
        background: #1d4ed8;
        color: white;
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .detail-header h1 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 800;
    }

    .detail-meta {
        font-size: 0.95rem;
        opacity: 0.85;
    }

    .detail-body {
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
        border-radius: 16px;
        border: 1px solid #e5e7eb;
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
        font-size: 1rem;
        color: #111827;
        line-height: 1.6;
    }

    .documents-section {
        display: grid;
        gap: 1rem;
    }

    .documents-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        gap: 0.75rem;
    }

    .documents-list li {
        background: #ffffff;
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
        font-weight: 600;
    }

    .action-bar {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .btn-action {
        border: none;
        border-radius: 14px;
        padding: 0.85rem 1.4rem;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-action:hover {
        transform: translateY(-1px);
    }

    .btn-approve {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-reject {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .status-pill {
        display: inline-flex;
        padding: 0.5rem 0.85rem;
        border-radius: 999px;
        color: white;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pill.pending { background: #f59e0b; }
    .status-pill.approved { background: #10b981; }
    .status-pill.rejected { background: #ef4444; }
</style>

<div class="application-detail-wrapper">
    <a href="{{ route('admin.applications') }}" class="btn-action" style="background: #f3f4f6; color: #1f2937; margin-bottom: 1rem;">← Back to applications</a>

    <div class="detail-card">
        <div class="detail-header">
            <div>
                <h1>Application #{{ $booking->id }}</h1>
                <p class="detail-meta">Submitted by {{ $booking->user?->name ?? 'Unknown user' }} on {{ $booking->created_at->format('M d, Y') }}</p>
            </div>
            <div>
                <span class="status-pill {{ strtolower($booking->approval_status ?? 'pending') }}">{{ ucfirst($booking->approval_status ?? 'pending') }}</span>
            </div>
        </div>

        <div class="detail-body">
            <div class="detail-grid">
                <div class="detail-box">
                    <div class="detail-label">Applicant</div>
                    <div class="detail-value">
                        {{ $booking->user?->name ?? $booking->guest_name ?? '-' }}<br>
                        {{ $booking->user?->email ?? $booking->guest_email ?? '-' }}<br>
                        {{ $booking->user?->phone ?? $booking->guest_phone ?? 'No phone provided' }}
                    </div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Booking type</div>
                    <div class="detail-value">{{ ucfirst($booking->booking_type ?? 'booking') }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Reference</div>
                    <div class="detail-value">{{ $booking->payment_reference ?? 'N/A' }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Booking status</div>
                    <div class="detail-value">{{ ucfirst($booking->status ?? 'unknown') }}</div>
                </div>
            </div>

            <div class="detail-grid">
                <div class="detail-box">
                    <div class="detail-label">Trip / role</div>
                    <div class="detail-value">{{ $booking->location ?? $booking->application_role ?? 'Not specified' }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Pickup date</div>
                    <div class="detail-value">{{ optional($booking->booking_date)->format('M d, Y') ?? 'Not scheduled' }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Passengers</div>
                    <div class="detail-value">{{ $booking->description ?? 'Not provided' }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Requested vehicle</div>
                    <div class="detail-value">{{ $booking->vehicle ? $booking->vehicle->make . ' ' . $booking->vehicle->model : 'Any available' }}</div>
                </div>
            </div>

            <div class="detail-box">
                <div class="detail-label">Application notes</div>
                <div class="detail-value">{{ $booking->description ?? 'No additional information provided.' }}</div>
            </div>

            <div class="detail-grid">
                <div class="detail-box">
                    <div class="detail-label">Tracking status</div>
                    <div class="detail-value">{{ ucfirst($booking->tracking_status ?? 'pending') }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Current location</div>
                    <div class="detail-value">{{ $booking->tracking_location ?? ($booking->location ?? 'Not set') }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">Last tracking update</div>
                    <div class="detail-value">{{ $booking->tracking_updated_at ? $booking->tracking_updated_at->format('M d, Y H:i') : 'Never updated' }}</div>
                </div>
            </div>

            @if($booking->recruitment)
                <div class="detail-box">
                    <div class="detail-label">Recruitment listing</div>
                    <div class="detail-value">
                        <strong>{{ $booking->recruitment->title ?? 'Recruitment application' }}</strong><br>
                        {{ $booking->recruitment->location ?? '' }}<br>
                        {{ $booking->recruitment->description ? Str::limit($booking->recruitment->description, 220) : '' }}
                    </div>
                </div>
            @endif

            <div class="detail-box">
                <div class="detail-label">Booking tracking</div>
                <div class="detail-value">
                    <form action="{{ route('admin.bookings.tracking', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="tracking_status" class="form-label">Tracking status</label>
                            <select id="tracking_status" name="tracking_status" class="form-control">
                                @foreach(['pending' => 'Pending', 'assigned' => 'Assigned', 'in_transit' => 'In Transit', 'arrived' => 'Arrived', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                                    <option value="{{ $value }}" {{ ($booking->tracking_status ?? 'pending') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tracking_location" class="form-label">Location update</label>
                            <input id="tracking_location" name="tracking_location" type="text" class="form-control" value="{{ old('tracking_location', $booking->tracking_location) }}" placeholder="e.g. Accra Mall, Tema Motorway" />
                        </div>
                        <div class="mb-3">
                            <label for="tracking_notes" class="form-label">Tracking notes</label>
                            <textarea id="tracking_notes" name="tracking_notes" class="form-control" rows="3" placeholder="Add a note about the current booking or driver location.">{{ old('tracking_notes', $booking->tracking_notes) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update tracking</button>
                    </form>
                </div>
            </div>

            <div class="documents-section">
                <div class="detail-label">Uploaded documents</div>
                @if($booking->application_documents && is_array($booking->application_documents) && count($booking->application_documents))
                    <ul class="documents-list">
                        @foreach($booking->application_documents as $index => $document)
                            <li>
                                <span>{{ basename($document) }}</span>
                                <a href="{{ route('admin.documents.show', ['type' => 'booking', 'id' => $booking->id, 'field' => 'application_documents', 'index' => $index]) }}" target="_blank">View</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="detail-box">
                        <div class="detail-value">No documents uploaded with this application.</div>
                    </div>
                @endif
            </div>

            <div class="action-bar">
                <button type="button" class="btn-action btn-approve" onclick="showApproveModal()">Approve application</button>
                <button type="button" class="btn-action btn-reject" onclick="showRejectModal()">Reject application</button>
            </div>

            <form id="approveForm" action="{{ route('admin.bookings.approve', $booking) }}" method="POST" style="display:none;">
                @csrf
            </form>

            <div class="modal fade" id="approveModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Approve Application</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Approve this booking application and confirm it for the guest or user.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-success" onclick="document.getElementById('approveForm').submit();">Confirm Approve</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="rejectModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reject Application</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="rejectReason" class="form-label">Reason for rejection</label>
                                    <textarea id="rejectReason" name="rejection_reason" class="form-control" rows="4" required placeholder="Provide a short reason for rejecting this booking."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Reject Application</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showApproveModal() {
        const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
        approveModal.show();
    }

    function showRejectModal() {
        const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
        rejectModal.show();
    }
</script>
@endsection
