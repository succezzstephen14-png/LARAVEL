@extends('layouts.admin')

@section('title', 'Recruitment Review System')

@section('content')
<style>
    .recruitment-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
    }

    .recruitment-header {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .recruitment-header h1 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 800;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .recruitment-stats {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .stat-badge {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .applications-container {
        display: grid;
        gap: 1.5rem;
    }

    .application-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 1;
        transform: translateY(0);
    }

    .application-card.approved {
        border-color: #10b981;
        background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
    }

    .application-card.rejected {
        border-color: #ef4444;
        background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
    }

    .application-card.removing {
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s ease;
    }

    .application-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .application-header.approved {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .application-header.rejected {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .applicant-info h3 {
        margin: 0 0 0.5rem;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .applicant-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .applicant-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-badge.pending {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .status-badge.approved {
        background: #10b981;
        color: white;
    }

    .status-badge.rejected {
        background: #ef4444;
        color: white;
    }

    .application-body {
        padding: 1.5rem;
    }

    .application-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .detail-item {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }

    .detail-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .detail-value {
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
    }

    .documents-section {
        margin-bottom: 1.5rem;
    }

    .documents-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: #374151;
    }

    .documents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 0.75rem;
    }

    .document-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background: #f3f4f6;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        text-decoration: none;
        color: #374151;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s ease;
        text-align: center;
        justify-content: center;
    }

    .document-link:hover {
        background: #e5e7eb;
        border-color: #9ca3af;
        color: #1f2937;
    }

    .document-images {
        padding: 0.75rem;
        background: #f3f4f6;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        text-align: center;
    }

    .image-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .images-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: center;
    }

    .image-preview {
        display: inline-block;
        border-radius: 4px;
        overflow: hidden;
        border: 2px solid #d1d5db;
        transition: border-color 0.2s ease;
    }

    .image-preview:hover {
        border-color: #9ca3af;
    }

    .images-grid-modal {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: flex-start;
    }

    .image-preview-modal {
        display: inline-block;
        border-radius: 4px;
        overflow: hidden;
        border: 2px solid #d1d5db;
        transition: border-color 0.2s ease;
    }

    .image-preview-modal:hover {
        border-color: #9ca3af;
    }

    .application-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .btn-view {
        background: #6b7280;
        color: white;
    }

    .btn-view:hover {
        background: #4b5563;
    }

    .btn-approve {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-approve:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    }

    .btn-reject {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-reject:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        color: #6b7280;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 1rem;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f4f6;
        border-top: 4px solid #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        display: none;
        align-items: center;
        gap: 0.75rem;
        z-index: 10000;
        max-width: 400px;
    }

    .toast-notification.success {
        border-left: 4px solid #10b981;
    }

    .toast-notification.error {
        border-left: 4px solid #ef4444;
    }

    .toast-icon {
        font-size: 1.2rem;
    }

    .toast-message {
        font-size: 0.9rem;
        font-weight: 500;
        color: #374151;
    }

    @media (max-width: 768px) {
        .recruitment-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .application-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .application-details {
            grid-template-columns: 1fr;
        }

        .documents-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .application-actions {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .documents-grid {
            grid-template-columns: 1fr;
        }

        .application-actions {
            flex-direction: column;
        }

        .action-btn {
            justify-content: center;
        }
    }
</style>

<div class="recruitment-wrapper">
    <div class="container-max">
        <!-- Header -->
        <div class="recruitment-header">
            <h1>
                <i class="fas fa-clipboard-check"></i>
                Recruitment Review System
            </h1>
            <div class="recruitment-stats">
                <div class="stat-badge">
                    <i class="fas fa-list-ul"></i>
                    {{ $applications->count() }} Pending Applications
                </div>
            </div>
        </div>

        <!-- Applications Container -->
        <div class="applications-container">
            @forelse($applications as $application)
                <div class="application-card" id="application-{{ $application['type'] }}-{{ $application['id'] }}" data-application='@json($application)'>
                    <div class="application-header">
                        <div class="applicant-info">
                            <h3>{{ $application['name'] }}</h3>
                            <div class="applicant-meta">
                                <div class="applicant-meta-item">
                                    <i class="fas fa-envelope"></i>
                                    {{ $application['email'] }}
                                </div>
                                <div class="applicant-meta-item">
                                    <i class="fas fa-phone"></i>
                                    {{ $application['phone'] ?? 'N/A' }}
                                </div>
                                <div class="applicant-meta-item">
                                    <i class="fas fa-user-tag"></i>
                                    {{ $application['role'] }}
                                </div>
                                <div class="applicant-meta-item">
                                    <i class="fas fa-clock"></i>
                                    {{ $application['submitted_at']->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="status-badge pending">
                            <i class="fas fa-clock"></i>
                            Pending Review
                        </div>
                    </div>

                    <div class="application-body">
                        <!-- Application Details -->
                        <div class="application-details">
                            @if($application['type'] === 'driver')
                                <div class="detail-item">
                                    <div class="detail-label">License Number</div>
                                    <div class="detail-value">{{ $application['details']['license_number'] }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">License Class</div>
                                    <div class="detail-value">{{ $application['details']['license_class'] }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Experience</div>
                                    <div class="detail-value">{{ $application['details']['experience_years'] }} years</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Location</div>
                                    <div class="detail-value">{{ $application['details']['location'] ?? 'N/A' }}</div>
                                </div>
                            @elseif($application['type'] === 'vehicle')
                                <div class="detail-item">
                                    <div class="detail-label">Vehicle</div>
                                    <div class="detail-value">{{ $application['details']['make_model'] }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Year</div>
                                    <div class="detail-value">{{ $application['details']['year'] }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Capacity</div>
                                    <div class="detail-value">{{ $application['details']['capacity'] }} passengers</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Location</div>
                                    <div class="detail-value">{{ $application['details']['location'] ?? 'N/A' }}</div>
                                </div>
                            @elseif($application['type'] === 'recruitment')
                                <div class="detail-item">
                                    <div class="detail-label">Company</div>
                                    <div class="detail-value">{{ $application['details']['company'] }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Position</div>
                                    <div class="detail-value">{{ $application['details']['position'] }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Salary Range</div>
                                    <div class="detail-value">{{ $application['details']['salary_range'] ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Location</div>
                                    <div class="detail-value">{{ $application['details']['location'] ?? 'N/A' }}</div>
                                </div>
                            @elseif($application['type'] === 'booking')
                                <div class="detail-item">
                                    <div class="detail-label">Service</div>
                                    <div class="detail-value">{{ $application['details']['service'] }}</div>
                                </div>
                                @if(isset($application['details']['driver_name']))
                                    <div class="detail-item">
                                        <div class="detail-label">Driver</div>
                                        <div class="detail-value">{{ $application['details']['driver_name'] }}</div>
                                    </div>
                                @elseif(isset($application['details']['vehicle']))
                                    <div class="detail-item">
                                        <div class="detail-label">Vehicle</div>
                                        <div class="detail-value">{{ $application['details']['vehicle'] }}</div>
                                    </div>
                                @elseif(isset($application['details']['position']))
                                    <div class="detail-item">
                                        <div class="detail-label">Position</div>
                                        <div class="detail-value">{{ $application['details']['position'] }}</div>
                                    </div>
                                @endif
                                <div class="detail-item">
                                    <div class="detail-label">Date</div>
                                    <div class="detail-value">{{ isset($application['details']['booking_date']) ? \Carbon\Carbon::parse($application['details']['booking_date'])->format('M j, Y') : \Carbon\Carbon::parse($application['details']['application_date'])->format('M j, Y') }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Location</div>
                                    <div class="detail-value">{{ $application['details']['location'] ?? 'N/A' }}</div>
                                </div>
                            @elseif($application['type'] === 'payment')
                                <div class="detail-item">
                                    <div class="detail-label">Amount</div>
                                    <div class="detail-value">{{ $application['details']['amount'] }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Reference</div>
                                    <div class="detail-value">{{ $application['details']['reference'] }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Type</div>
                                    <div class="detail-value">{{ $application['details']['type'] }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Status</div>
                                    <div class="detail-value">{{ $application['details']['status'] }}</div>
                                </div>
                            @endif
                        </div>

                        <!-- Documents Section -->
                        @if(count($application['documents']) > 0)
                            <div class="documents-section">
                                <div class="documents-header">
                                    <i class="fas fa-file-alt"></i>
                                    Submitted Documents
                                </div>
                                <div class="documents-grid">
                                    @foreach($application['documents'] as $docType => $docPath)
                                        @if($docPath)
                                            @if(is_array($docPath))
                                                <!-- Display images for array values (vehicle images) -->
                                                <div class="document-images">
                                                    <div class="image-label">{{ ucfirst(str_replace('_', ' ', $docType)) }}</div>
                                                    <div class="images-grid">
                                                        @foreach($docPath as $imageIndex => $imagePath)
                                                            <a href="{{ route('admin.documents.show', ['type' => $application['type'], 'id' => $application['id'], 'field' => $docType, 'index' => $imageIndex]) }}" target="_blank" class="image-preview">
                                                                <img src="{{ route('admin.documents.show', ['type' => $application['type'], 'id' => $application['id'], 'field' => $docType, 'index' => $imageIndex]) }}" alt="Vehicle image" class="vehicle-thumbnail">
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Display links for single file paths -->
                                                <a href="{{ route('admin.documents.show', ['type' => $application['type'], 'id' => $application['id'], 'field' => $docType]) }}" target="_blank" class="document-link">
                                                    <i class="fas fa-external-link-alt"></i>
                                                    {{ ucfirst(str_replace('_', ' ', $docType)) }}
                                                </a>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="application-actions">
                            <button type="button" class="action-btn btn-view" onclick="viewApplicationDetails('{{ $application['type'] }}', {{ $application['id'] }})">
                                <i class="fas fa-eye"></i>
                                View Details
                            </button>
                            <button type="button" class="action-btn btn-approve" onclick="approveApplication('{{ $application['type'] }}', {{ $application['id'] }})">
                                <i class="fas fa-check"></i>
                                Approve
                            </button>
                            <button type="button" class="action-btn btn-reject" onclick="rejectApplication('{{ $application['type'] }}', {{ $application['id'] }})">
                                <i class="fas fa-times"></i>
                                Reject
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>All Caught Up!</h3>
                    <p>There are no pending applications to review at this time.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<!-- Toast Notification -->
<div class="toast-notification" id="toastNotification">
    <div class="toast-icon" id="toastIcon">✓</div>
    <div class="toast-message" id="toastMessage">Action completed successfully!</div>
</div>

<!-- Application Details Modal -->
<div class="modal fade" id="applicationDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Application Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="applicationDetailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Reject Reason Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejectionReason" class="form-label">Reason for Rejection</label>
                        <textarea class="form-control" id="rejectionReason" name="reason" rows="4" required placeholder="Please provide a reason for rejecting this application..."></textarea>
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

<!-- Approve Confirmation Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this application? This action will make the item visible or confirmed in the system.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmApproveButton">Approve Application</button>
            </div>
        </div>
    </div>
</div>

<span id="adminDocumentRouteTemplate" data-route-template="{{ route('admin.documents.show', ['type' => 'DOCUMENT_TYPE', 'id' => 'DOCUMENT_ID', 'field' => 'DOCUMENT_FIELD']) }}" hidden></span>

<script>
let currentApplicationType = '';
let currentApplicationId = '';
const adminDocumentRouteTemplate = document.getElementById('adminDocumentRouteTemplate').dataset.routeTemplate;

function adminDocumentUrl(type, id, field, index = null) {
    const url = adminDocumentRouteTemplate
        .replace('DOCUMENT_TYPE', encodeURIComponent(type))
        .replace('DOCUMENT_ID', encodeURIComponent(id))
        .replace('DOCUMENT_FIELD', encodeURIComponent(field));

    return index === null ? url : `${url}/${index}`;
}

function showLoading() {
    document.getElementById('loadingOverlay').style.display = 'flex';
}

function hideLoading() {
    document.getElementById('loadingOverlay').style.display = 'none';
}

function showToast(message, type = 'success') {
    const toast = document.getElementById('toastNotification');
    const toastIcon = document.getElementById('toastIcon');
    const toastMessage = document.getElementById('toastMessage');

    toastMessage.textContent = message;
    toast.className = `toast-notification ${type}`;

    if (type === 'success') {
        toastIcon.textContent = '✓';
    } else {
        toastIcon.textContent = '✕';
    }

    toast.style.display = 'flex';

    setTimeout(() => {
        toast.style.display = 'none';
    }, 4000);
}

function approveApplication(type, id) {
    currentApplicationType = type;
    currentApplicationId = id;
    const modal = new bootstrap.Modal(document.getElementById('approveModal'));
    modal.show();
}

function confirmApproveApplication() {
    const modalInstance = bootstrap.Modal.getInstance(document.getElementById('approveModal'));
    if (modalInstance) {
        modalInstance.hide();
    }

    showLoading();

    fetch('/admin/ajax/approve', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            type: currentApplicationType,
            id: currentApplicationId
        })
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();

        if (data.success) {
            showToast(data.message, 'success');

            const card = document.getElementById(`application-${currentApplicationType}-${currentApplicationId}`);
            const header = card.querySelector('.application-header');
            const statusBadge = card.querySelector('.status-badge');

            card.classList.add('approved');
            header.classList.add('approved');
            statusBadge.classList.remove('pending');
            statusBadge.classList.add('approved');
            statusBadge.innerHTML = '<i class="fas fa-check"></i> Approved';

            const actions = card.querySelector('.application-actions');
            actions.style.display = 'none';

            setTimeout(() => {
                card.classList.add('removing');
                setTimeout(() => {
                    card.remove();
                    checkEmptyState();
                }, 300);
            }, 2000);
        } else {
            showToast(data.message || 'An error occurred', 'error');
        }
    })
    .catch(error => {
        hideLoading();
        showToast('An error occurred while processing your request', 'error');
        console.error('Error:', error);
    });
}

function rejectApplication(type, id) {
    currentApplicationType = type;
    currentApplicationId = id;

    // Reset form
    document.getElementById('rejectionReason').value = '';

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}

function viewApplicationDetails(type, id) {
    const card = document.getElementById(`application-${type}-${id}`);
    if (!card) {
        showToast('Unable to find the selected application.', 'error');
        return;
    }

    let applicationData;
    try {
        applicationData = JSON.parse(card.dataset.application);
    } catch (error) {
        console.error('Failed to parse application data:', error);
        showToast('Application detail data is invalid.', 'error');
        return;
    }

    const content = renderApplicationDetails(applicationData);
    document.getElementById('applicationDetailsContent').innerHTML = content;

    const modal = new bootstrap.Modal(document.getElementById('applicationDetailsModal'));
    modal.show();
}

function escapeHtml(value) {
    if (value === null || value === undefined) {
        return 'N/A';
    }
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function renderApplicationDetails(application) {
    const details = application.details || {};
    const documents = application.documents || {};
    const model = application.model || null;
    const typeLabel = application.type ? application.type.charAt(0).toUpperCase() + application.type.slice(1) : 'Unknown';

    let html = `
        <div class="application-details">
            <div class="detail-item">
                <div class="detail-label">Application ID</div>
                <div class="detail-value">${escapeHtml(application.id || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Applicant</div>
                <div class="detail-value">${escapeHtml(application.name)}<br>${escapeHtml(application.email)}<br>${escapeHtml(application.phone || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Application Type</div>
                <div class="detail-value">${escapeHtml(typeLabel)}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Submitted At</div>
                <div class="detail-value">${escapeHtml(application.submitted_at ? new Date(application.submitted_at).toLocaleString() : 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Role</div>
                <div class="detail-value">${escapeHtml(application.role || 'N/A')}</div>
            </div>
    `;

    if (typeLabel === 'Driver') {
        html += `
            <div class="detail-item">
                <div class="detail-label">License Number</div>
                <div class="detail-value">${escapeHtml(details.license_number || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">License Class</div>
                <div class="detail-value">${escapeHtml(details.license_class || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Experience</div>
                <div class="detail-value">${escapeHtml(details.experience_years ? details.experience_years + ' years' : 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Location</div>
                <div class="detail-value">${escapeHtml(details.location || 'N/A')}</div>
            </div>
        `;
    }

    if (typeLabel === 'Vehicle') {
        html += `
            <div class="detail-item">
                <div class="detail-label">Vehicle</div>
                <div class="detail-value">${escapeHtml(details.make_model || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Year</div>
                <div class="detail-value">${escapeHtml(details.year || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Capacity</div>
                <div class="detail-value">${escapeHtml(details.capacity ? details.capacity + ' passengers' : 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Location</div>
                <div class="detail-value">${escapeHtml(details.location || 'N/A')}</div>
            </div>
        `;
    }

    if (typeLabel === 'Recruitment') {
        html += `
            <div class="detail-item">
                <div class="detail-label">Company</div>
                <div class="detail-value">${escapeHtml(details.company || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Position</div>
                <div class="detail-value">${escapeHtml(details.position || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Salary Range</div>
                <div class="detail-value">${escapeHtml(details.salary_range || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Location</div>
                <div class="detail-value">${escapeHtml(details.location || 'N/A')}</div>
            </div>
        `;
    }

    if (typeLabel === 'Booking') {
        html += `
            <div class="detail-item">
                <div class="detail-label">Service</div>
                <div class="detail-value">${escapeHtml(details.service || 'N/A')}</div>
            </div>
        `;

        if (details.driver_name) {
            html += `
                <div class="detail-item">
                    <div class="detail-label">Driver</div>
                    <div class="detail-value">${escapeHtml(details.driver_name)}</div>
                </div>
            `;
        } else if (details.vehicle) {
            html += `
                <div class="detail-item">
                    <div class="detail-label">Vehicle</div>
                    <div class="detail-value">${escapeHtml(details.vehicle)}</div>
                </div>
            `;
        } else if (details.position) {
            html += `
                <div class="detail-item">
                    <div class="detail-label">Position</div>
                    <div class="detail-value">${escapeHtml(details.position)}</div>
                </div>
            `;
        }

        html += `
            <div class="detail-item">
                <div class="detail-label">Date</div>
                <div class="detail-value">${escapeHtml(details.booking_date || details.application_date || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Location</div>
                <div class="detail-value">${escapeHtml(details.location || 'N/A')}</div>
            </div>
        `;
    }

    if (typeLabel === 'Payment') {
        html += `
            <div class="detail-item">
                <div class="detail-label">Amount</div>
                <div class="detail-value">${escapeHtml(details.amount || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Reference</div>
                <div class="detail-value">${escapeHtml(details.reference || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Type</div>
                <div class="detail-value">${escapeHtml(details.type || 'N/A')}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Status</div>
                <div class="detail-value">${escapeHtml(details.status || 'N/A')}</div>
            </div>
        `;
    }

    const shownDetailKeys = new Set(['license_number', 'license_class', 'experience_years', 'location', 'make_model', 'year', 'capacity', 'company', 'position', 'salary_range', 'service', 'driver_name', 'vehicle', 'booking_date', 'application_date', 'amount', 'reference', 'type', 'status']);
    const extraDetailEntries = Object.entries(details)
        .filter(([key, value]) => !shownDetailKeys.has(key) && value !== null && value !== undefined && value !== '');

    if (extraDetailEntries.length > 0) {
        html += `
            <div class="detail-item" style="grid-column: 1 / -1;">
                <div class="detail-label">Additional Submitted Details</div>
            </div>
        `;

        extraDetailEntries.forEach(([key, value]) => {
            html += `
                <div class="detail-item">
                    <div class="detail-label">${prettyLabel(key)}</div>
                    <div class="detail-value">${escapeHtml(formatDetailValue(value))}</div>
                </div>
            `;
        });
    }

    const documentEntries = Array.isArray(documents)
        ? documents.map((value, index) => [index, value])
        : Object.entries(documents);

    const visibleDocumentEntries = documentEntries.filter(([, value]) => value !== null && value !== undefined && value !== '');
    if (visibleDocumentEntries.length > 0) {
        html += `
            <div class="detail-item" style="grid-column: 1 / -1;">
                <div class="detail-label">Submitted Documents</div>
            </div>
        `;

        visibleDocumentEntries.forEach(([key, value]) => {
            if (Array.isArray(value)) {
                // Handle arrays (like vehicle images)
                html += `
                    <div class="detail-item" style="grid-column: 1 / -1;">
                        <div class="detail-label">${prettyLabel(key)}</div>
                        <div class="detail-value">
                            <div class="images-grid-modal">
                                ${value.map((path, index) => `
                                    <a href="${escapeHtml(adminDocumentUrl(application.type, application.id, key, index))}" target="_blank" class="image-preview-modal">
                                        <img src="${escapeHtml(adminDocumentUrl(application.type, application.id, key, index))}" alt="Document image" class="vehicle-thumbnail">
                                    </a>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // Handle single values
                html += `
                    <div class="detail-item">
                        <div class="detail-label">${prettyLabel(key)}</div>
                        <div class="detail-value"><a href="${escapeHtml(adminDocumentUrl(application.type, application.id, key))}" target="_blank">${prettyLabel(key)}</a></div>
                    </div>
                `;
            }
        });
    }

    if (model && typeof model === 'object') {
        // Exclude internal/structural fields and user relation
        const excludedFields = new Set(['user_id', 'user', 'data', 'password', 'remember_token', 'created_at', 'updated_at']);
        const modelEntries = Object.entries(model)
            .filter(([key, value]) => 
                !excludedFields.has(key) && 
                !key.startsWith('_') &&
                (typeof value === 'string' || typeof value === 'number' || typeof value === 'boolean' || value === null) &&
                value !== null && 
                value !== undefined && 
                String(value).trim() !== ''
            );

        if (modelEntries.length > 0) {
            html += `
                <div class="detail-item" style="grid-column: 1 / -1;">
                    <div class="detail-label">Profile Information</div>
                </div>
            `;

            modelEntries.forEach(([key, value]) => {
                html += `
                    <div class="detail-item">
                        <div class="detail-label">${prettyLabel(key)}</div>
                        <div class="detail-value">${escapeHtml(String(value))}</div>
                    </div>
                `;
            });
        }

        if (model.user && typeof model.user === 'object') {
            const userEntries = Object.entries(model.user)
                .filter(([key, value]) => 
                    !['id', 'password', 'remember_token', 'created_at', 'updated_at'].includes(key) &&
                    (typeof value === 'string' || typeof value === 'number' || typeof value === 'boolean') &&
                    value !== null && 
                    value !== undefined && 
                    String(value).trim() !== ''
                );
            if (userEntries.length > 0) {
                html += `
                    <div class="detail-item" style="grid-column: 1 / -1;">
                        <div class="detail-label">User Account Information</div>
                    </div>
                `;

                userEntries.forEach(([key, value]) => {
                    html += `
                        <div class="detail-item">
                            <div class="detail-label">${prettyLabel(key)}</div>
                            <div class="detail-value">${escapeHtml(String(value))}</div>
                        </div>
                    `;
                });
            }
        }
    }

    const rootExtraEntries = Object.entries(application)
        .filter(([key, value]) => !['id', 'name', 'email', 'phone', 'role', 'type', 'submitted_at', 'details', 'documents', 'model'].includes(key)
            && value !== null && value !== undefined && value !== '');

    if (rootExtraEntries.length > 0) {
        html += `
            <div class="detail-item" style="grid-column: 1 / -1;">
                <div class="detail-label">Additional Application Data</div>
            </div>
        `;

        rootExtraEntries.forEach(([key, value]) => {
            html += `
                <div class="detail-item">
                    <div class="detail-label">${prettyLabel(key)}</div>
                    <div class="detail-value">${escapeHtml(formatDetailValue(value))}</div>
                </div>
            `;
        });
    }

    html += `
            <div class="detail-item" style="grid-column: 1 / -1;">
                <div class="detail-label">Notes</div>
                <div class="detail-value">${escapeHtml(details.description || details.bio || 'No additional details provided.')}</div>
            </div>
        </div>
    `;

    return html;
}

function prettyLabel(key) {
    return String(key)
        .replace(/[_-]/g, ' ')
        .replace(/([a-z])([A-Z])/g, '$1 $2')
        .replace(/\b\w/g, char => char.toUpperCase());
}

function formatDetailValue(value) {
    if (Array.isArray(value)) {
        return value.map(item => formatDetailValue(item)).join(', ');
    }
    if (typeof value === 'object') {
        return JSON.stringify(value, null, 2);
    }
    return String(value);
}

function checkEmptyState() {
    const container = document.querySelector('.applications-container');
    const cards = container.querySelectorAll('.application-card:not(.removing)');

    if (cards.length === 0) {
        location.reload(); // Reload to show empty state
    }
}

// Handle reject form submission
document.getElementById('rejectForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const reason = document.getElementById('rejectionReason').value;

    if (!reason.trim()) {
        alert('Please provide a reason for rejection.');
        return;
    }

    showLoading();

    fetch('/admin/ajax/reject', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            type: currentApplicationType,
            id: currentApplicationId,
            reason: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
        modal.hide();

        if (data.success) {
            showToast(data.message, 'success');

            // Update the card appearance
            const card = document.getElementById(`application-${currentApplicationType}-${currentApplicationId}`);
            const header = card.querySelector('.application-header');
            const statusBadge = card.querySelector('.status-badge');

            card.classList.add('rejected');
            header.classList.add('rejected');
            statusBadge.classList.remove('pending');
            statusBadge.classList.add('rejected');
            statusBadge.innerHTML = '<i class="fas fa-times"></i> Rejected';

            // Hide action buttons
            const actions = card.querySelector('.application-actions');
            actions.style.display = 'none';

            // Remove card after animation
            setTimeout(() => {
                card.classList.add('removing');
                setTimeout(() => {
                    card.remove();
                    checkEmptyState();
                }, 300);
            }, 2000);
        } else {
            showToast(data.message || 'An error occurred', 'error');
        }
    })
    .catch(error => {
        hideLoading();
        showToast('An error occurred while processing your request', 'error');
        console.error('Error:', error);
    });
});

document.getElementById('confirmApproveButton').addEventListener('click', confirmApproveApplication);
</script>

@endsection
