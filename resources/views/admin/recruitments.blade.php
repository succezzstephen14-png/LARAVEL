@extends('layouts.admin')

@section('title', 'Recruitment Management - SUCCEZZ Drivers Agency')

@section('styles')
<style>
    .recruitments-wrapper {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
    }
    
    .recruitments-header {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .recruitments-header h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .recruitments-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .recruitment-stat {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-left: 4px solid;
    }
    
    .recruitment-stat.total { border-left-color: #8b5cf6; }
    .recruitment-stat.open { border-left-color: #3b82f6; }
    .recruitment-stat.pending { border-left-color: #f59e0b; }
    .recruitment-stat.filled { border-left-color: #10b981; }
    
    .recruitment-stat-value {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .recruitment-stat-label {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 600;
    }
    
    .recruitments-filters {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .recruitments-filters input,
    .recruitments-filters select {
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.9rem;
    }
    
    .recruitments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .recruitment-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .recruitment-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }
    
    .recruitment-card-header {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    
    .recruitment-title-section {
        flex: 1;
    }
    
    .recruitment-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .recruitment-department {
        font-size: 0.85rem;
        opacity: 0.9;
    }
    
    .recruitment-status-badge {
        display: inline-block;
        padding: 0.35rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        text-transform: uppercase;
    }
    
    .recruitment-card-body {
        padding: 1.5rem;
    }
    
    .recruitment-detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.8rem;
        font-size: 0.9rem;
    }
    
    .recruitment-detail-label {
        font-weight: 600;
        color: #6b7280;
    }
    
    .recruitment-detail-value {
        color: #1f2937;
        font-weight: 500;
    }
    
    .recruitment-description {
        background: #f9fafb;
        padding: 1rem;
        border-radius: 10px;
        margin: 1rem 0;
        font-size: 0.85rem;
        border-left: 3px solid #8b5cf6;
        color: #4b5563;
        max-height: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .recruitment-specs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin: 1rem 0;
        font-size: 0.85rem;
    }
    
    .recruitment-spec-item {
        background: #f9fafb;
        padding: 0.75rem;
        border-radius: 8px;
        border-left: 2px solid #8b5cf6;
    }
    
    .recruitment-spec-label {
        color: #6b7280;
        font-weight: 600;
        font-size: 0.75rem;
    }
    
    .recruitment-spec-value {
        color: #1f2937;
        font-weight: 600;
    }
    
    .recruitment-card-footer {
        padding: 1rem;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .recruitment-action-btn {
        flex: 1;
        min-width: 80px;
        padding: 0.6rem 0.8rem;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }
    
    .recruitment-action-btn.primary {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
    }
    
    .recruitment-action-btn.success {
        background: #d1fae5;
        color: #065f46;
    }
    
    .recruitment-action-btn.warning {
        background: #fef3c7;
        color: #78350f;
    }
    
    .recruitment-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .empty-state {
        grid-column: 1 / -1;
        background: white;
        padding: 3rem;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    
    .empty-state-icon {
        font-size: 3.5rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    
    .pagination-wrapper {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
</style>
@endsection

@section('content')
<div class="recruitments-wrapper">
    <div class="container-max">
        <!-- Header -->
        <div class="recruitments-header">
            <div>
                <h2><i class="fas fa-briefcase"></i> Recruitment Management</h2>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="/admin/recruitments/create-temp" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Position
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-soft">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="recruitments-stats">
            <div class="recruitment-stat total">
                <div class="recruitment-stat-value">{{ $recruitments->count() }}</div>
                <div class="recruitment-stat-label">Total Positions</div>
            </div>
            <div class="recruitment-stat open">
                <div class="recruitment-stat-value">{{ $recruitments->where('status', 'open')->count() }}</div>
                <div class="recruitment-stat-label">Open Positions</div>
            </div>
            <div class="recruitment-stat pending">
                <div class="recruitment-stat-value">{{ $recruitments->where('status', 'reviewing')->count() }}</div>
                <div class="recruitment-stat-label">Under Review</div>
            </div>
            <div class="recruitment-stat filled">
                <div class="recruitment-stat-value">{{ $recruitments->where('status', 'filled')->count() }}</div>
                <div class="recruitment-stat-label">Filled</div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="recruitments-filters">
            <input type="text" id="recruitmentSearch" placeholder="Search positions..." style="flex: 1; min-width: 200px;">
            <select id="statusFilter" style="min-width: 130px;">
                <option value="">All Status</option>
                <option value="open">Open</option>
                <option value="reviewing">Reviewing</option>
                <option value="filled">Filled</option>
                <option value="closed">Closed</option>
            </select>
            <select id="departmentFilter" style="min-width: 130px;">
                <option value="">All Departments</option>
                <option value="drivers">Drivers</option>
                <option value="operations">Operations</option>
                <option value="support">Support</option>
            </select>
            <button onclick="clearFilters()" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Clear
            </button>
        </div>
        
        <!-- Recruitments Grid -->
        <div class="recruitments-grid">
            @forelse($recruitments as $recruitment)
            <div class="recruitment-card">
                <div class="recruitment-card-header">
                    <div class="recruitment-title-section">
                        <div class="recruitment-title">{{ $recruitment->title ?? 'Position Title' }}</div>
                        <div class="recruitment-department">
                            <i class="fas fa-sitemap"></i> {{ $recruitment->department ?? 'General' }}
                        </div>
                    </div>
                    <span class="recruitment-status-badge">
                        @if($recruitment->status === 'open')
                            <i class="fas fa-circle-check"></i> Open
                        @elseif($recruitment->status === 'reviewing')
                            <i class="fas fa-hourglass"></i> Reviewing
                        @elseif($recruitment->status === 'filled')
                            <i class="fas fa-check-double"></i> Filled
                        @else
                            <i class="fas fa-lock"></i> Closed
                        @endif
                    </span>
                </div>
                
                <div class="recruitment-card-body">
                    <div class="recruitment-detail-row">
                        <span class="recruitment-detail-label">Position ID:</span>
                        <span class="recruitment-detail-value">#{{ $recruitment->id }}</span>
                    </div>
                    <div class="recruitment-detail-row">
                        <span class="recruitment-detail-label">Posted:</span>
                        <span class="recruitment-detail-value">{{ $recruitment->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="recruitment-detail-row">
                        <span class="recruitment-detail-label">Salary Range:</span>
                        <span class="recruitment-detail-value">{{ $recruitment->salary_range ?? 'Negotiable' }}</span>
                    </div>
                    <div class="recruitment-detail-row">
                        <span class="recruitment-detail-label">Location:</span>
                        <span class="recruitment-detail-value">{{ $recruitment->location ?? 'Remote' }}</span>
                    </div>
                    
                    <div class="recruitment-specs">
                        <div class="recruitment-spec-item">
                            <div class="recruitment-spec-label">Type</div>
                            <div class="recruitment-spec-value">{{ $recruitment->employment_type ?? 'Full-time' }}</div>
                        </div>
                        <div class="recruitment-spec-item">
                            <div class="recruitment-spec-label">Experience</div>
                            <div class="recruitment-spec-value">{{ $recruitment->experience_level ?? 'Entry' }}</div>
                        </div>
                    </div>
                    
                    @if($recruitment->description)
                    <div class="recruitment-description">
                        {{ Str::limit($recruitment->description, 120) }}
                    </div>
                    @endif
                </div>
                
                <div class="recruitment-card-footer">
                    <button onclick="viewRecruitment('{{ $recruitment->id }}')" class="recruitment-action-btn primary">
                        <i class="fas fa-eye"></i> View
                    </button>
                    <button onclick="editRecruitment('{{ $recruitment->id }}')" class="recruitment-action-btn warning">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    @if($recruitment->status === 'open')
                    <button onclick="closeRecruitment('{{ $recruitment->id }}')" class="recruitment-action-btn" style="background: #f3f4f6; color: #374151;">
                        <i class="fas fa-times"></i> Close
                    </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3 style="color: #1f2937;">No recruitment positions</h3>
                <p style="color: #9ca3af;">Create a new position to get started with recruitment.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($recruitments->hasPages())
        <div class="pagination-wrapper">
            {{ $recruitments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function viewRecruitment(id) {
        window.location.href = '/admin/recruitments/' + id;
    }
    
    function editRecruitment(id) {
        window.location.href = '/admin/recruitments/' + id + '/edit-admin';
    }
    
    function newRecruit() {
        window.location.href = '{{ route("admin.recruitments.create") }}';
    }
    
    function closeRecruitment(id) {
        if (confirm('Are you sure you want to close this position?')) {
            alert('Close recruitment functionality coming soon');
            // Can be implemented later with actual API call
        }
    }
    
    function clearFilters() {
        document.getElementById('recruitmentSearch').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('departmentFilter').value = '';
    }
</script>
@endsection
