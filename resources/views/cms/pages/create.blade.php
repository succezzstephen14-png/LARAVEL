@extends('layouts.cms')

@section('title', 'Create New Page')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Create New Page</h5>
                <a href="{{ route('cms.pages') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('cms.store-page') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Page Title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" required placeholder="Enter page title">
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Page Slug <span class="text-danger">*</span></label>
                        <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" 
                               value="{{ old('slug') }}" required placeholder="page-url-slug">
                        <small class="form-text text-muted">URL-friendly version. Only lowercase letters, numbers, and hyphens. This will be the page URL.</small>
                        @error('slug')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3" placeholder="Brief description of the page">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="template" class="form-label">Template</label>
                                <select id="template" name="template" class="form-select @error('template') is-invalid @enderror">
                                    <option value="default" {{ old('template') === 'default' ? 'selected' : '' }}>Default Layout</option>
                                    <option value="full-width" {{ old('template') === 'full-width' ? 'selected' : '' }}>Full Width</option>
                                    <option value="sidebar" {{ old('template') === 'sidebar' ? 'selected' : '' }}>Sidebar Layout</option>
                                </select>
                                @error('template')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h6 class="card-title">SEO Information</h6>
                            <div class="mb-3">
                                <label for="seo_title" class="form-label">SEO Title</label>
                                <input type="text" id="seo_title" name="seo_title" class="form-control" 
                                       value="{{ old('seo_title') }}" maxlength="60" placeholder="Page SEO title (recommended 30-60 characters)">
                                <small class="form-text text-muted">Leave empty to use page title</small>
                            </div>
                            <div class="mb-3">
                                <label for="seo_description" class="form-label">Meta Description</label>
                                <textarea id="seo_description" name="seo_description" class="form-control" 
                                          rows="2" maxlength="160" placeholder="Page meta description (recommended 120-160 characters)">{{ old('seo_description') }}</textarea>
                                <small class="form-text text-muted">This appears in search engine results</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Page
                        </button>
                        <a href="{{ route('cms.pages') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3 bg-info-light">
            <div class="card-body">
                <h6 class="card-title text-info">
                    <i class="fas fa-lightbulb"></i> Tips
                </h6>
                <ul class="small mb-0">
                    <li>Use descriptive titles and slugs for better organization</li>
                    <li>Add SEO information to improve search engine visibility</li>
                    <li>You can add sections (text, images, videos) to your page after creation</li>
                    <li>Pages must be published to appear on the website</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
});
</script>
@endsection
