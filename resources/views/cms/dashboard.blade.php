@extends('layouts.cms')

@section('title', 'CMS Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
        <div class="stats-card pages">
            <div class="stats-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stats-number">{{ $pagesCount }}</div>
            <div class="stats-label">Total Pages</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
        <div class="stats-card posts">
            <div class="stats-icon">
                <i class="fas fa-blog"></i>
            </div>
            <div class="stats-number">{{ $postsCount }}</div>
            <div class="stats-label">Blog Posts</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
        <div class="stats-card categories">
            <div class="stats-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stats-number">{{ $categoriesCount }}</div>
            <div class="stats-label">Categories</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
        <div class="stats-card media">
            <div class="stats-icon">
                <i class="fas fa-images"></i>
            </div>
            <div class="stats-number">{{ $mediaCount }}</div>
            <div class="stats-label">Media Files</div>
        </div>
    </div>
</div>

<!-- Additional Stats Row -->
<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
        <div class="stats-card pages">
            <div class="stats-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stats-number">{{ $publishedCount }}</div>
            <div class="stats-label">Published Pages</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
        <div class="stats-card posts">
            <div class="stats-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stats-number">{{ $publishedPostsCount }}</div>
            <div class="stats-label">Published Posts</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
        <div class="stats-card categories">
            <div class="stats-icon">
                <i class="fas fa-hashtag"></i>
            </div>
            <div class="stats-number">{{ $tagsCount }}</div>
            <div class="stats-label">Tags</div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
        <div class="stats-card media">
            <div class="stats-icon">
                <i class="fas fa-bars"></i>
            </div>
            <div class="stats-number">{{ $menusCount }}</div>
            <div class="stats-label">Menus</div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <a href="{{ route('cms.create-page') }}" class="action-card">
        <div class="action-icon">
            <i class="fas fa-plus"></i>
        </div>
        <div class="action-content">
            <h5>Create New Page</h5>
            <p>Add a new page to your website</p>
        </div>
    </a>

    <a href="{{ route('cms.create-post') }}" class="action-card">
        <div class="action-icon">
            <i class="fas fa-edit"></i>
        </div>
        <div class="action-content">
            <h5>Write New Post</h5>
            <p>Create a blog post or article</p>
        </div>
    </a>

    <a href="{{ route('cms.media') }}" class="action-card">
        <div class="action-icon">
            <i class="fas fa-upload"></i>
        </div>
        <div class="action-content">
            <h5>Upload Media</h5>
            <p>Manage images and files</p>
        </div>
    </a>

    <a href="{{ route('cms.menus') }}" class="action-card">
        <div class="action-icon">
            <i class="fas fa-bars"></i>
        </div>
        <div class="action-content">
            <h5>Manage Menus</h5>
            <p>Configure navigation menus</p>
        </div>
    </a>

    <a href="{{ route('cms.blocks') }}" class="action-card">
        <div class="action-icon">
            <i class="fas fa-cubes"></i>
        </div>
        <div class="action-content">
            <h5>Reusable Blocks</h5>
            <p>Create content blocks</p>
        </div>
    </a>

    <a href="{{ route('cms.categories') }}" class="action-card">
        <div class="action-icon">
            <i class="fas fa-tags"></i>
        </div>
        <div class="action-content">
            <h5>Categories</h5>
            <p>Organize your content</p>
        </div>
    </a>
</div>

<!-- Recent Activity or Quick Stats -->
<div class="row mt-4">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="text-center py-4">
                    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Activity Timeline</h6>
                    <p class="text-muted small">Recent content updates and publishing activity will appear here.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">System Status</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Database</span>
                    <span class="badge bg-success">Connected</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Storage</span>
                    <span class="badge bg-success">Available</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Cache</span>
                    <span class="badge bg-success">Active</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection