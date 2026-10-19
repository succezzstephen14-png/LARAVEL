@extends('layouts.cms')

@section('title', 'Edit Page - ' . $page->title)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Edit Page: {{ $page->title }}</h5>
                <div>
                    <a href="{{ route('cms.pages') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Tabs for different sections -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#page-details" role="tab">
                            <i class="fas fa-file"></i> Page Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#page-sections" role="tab">
                            <i class="fas fa-layer-group"></i> Sections ({{ count($sections) }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#page-seo" role="tab">
                            <i class="fas fa-search"></i> SEO
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Tab 1: Page Details -->
                    <div class="tab-pane fade show active" id="page-details" role="tabpanel">
                        <form action="{{ route('cms.update-page', $page) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Page Title</label>
                                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                                               value="{{ old('title', $page->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Page Slug</label>
                                        <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" 
                                               value="{{ old('slug', $page->slug) }}" required>
                                        <small class="form-text text-muted">URL-friendly version of the page title</small>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                                                  rows="3">{{ old('description', $page->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="template" class="form-label">Template</label>
                                        <select id="template" name="template" class="form-select @error('template') is-invalid @enderror">
                                            <option value="default" {{ old('template', $page->template) === 'default' ? 'selected' : '' }}>Default</option>
                                            <option value="full-width" {{ old('template', $page->template) === 'full-width' ? 'selected' : '' }}>Full Width</option>
                                            <option value="sidebar" {{ old('template', $page->template) === 'sidebar' ? 'selected' : '' }}>Sidebar Layout</option>
                                        </select>
                                        @error('template')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Page Status</h6>
                                            
                                            <div class="form-check mb-2">
                                                <input type="checkbox" id="is_published" name="is_published" class="form-check-input" 
                                                       value="1" {{ old('is_published', $page->is_published) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_published">
                                                    Published
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input type="checkbox" id="is_home" name="is_home" class="form-check-input" 
                                                       value="1" {{ old('is_home', $page->is_home) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_home">
                                                    Set as Home Page
                                                </label>
                                            </div>

                                            <hr>
                                            <small class="text-muted">
                                                Created: {{ $page->created_at->format('M d, Y H:i') }}<br>
                                                Updated: {{ $page->updated_at->format('M d, Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab 2: Sections -->
                    <div class="tab-pane fade" id="page-sections" role="tabpanel">
                        <div class="row mb-3">
                            <div class="col-12">
                                <button class="btn btn-success" data-bs-toggle="collapse" data-bs-target="#add-section-form">
                                    <i class="fas fa-plus"></i> Add New Section
                                </button>
                            </div>
                        </div>

                        <!-- Add Section Form -->
                        <div class="collapse mb-4" id="add-section-form">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('cms.add-section', $page) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="section-title" class="form-label">Section Title</label>
                                                    <input type="text" id="section-title" name="title" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="section-type" class="form-label">Section Type</label>
                                                    <select id="section-type" name="type" class="form-select" required>
                                                        <option value="">Select Type</option>
                                                        <option value="text">Text</option>
                                                        <option value="image">Image</option>
                                                        <option value="video">Video</option>
                                                        <option value="slider">Slider</option>
                                                        <option value="hero">Hero Banner</option>
                                                        <option value="features">Features</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Content Section -->
                                        <h6 class="mt-4 mb-3">Content</h6>
                                        <div class="mb-3">
                                            <label for="section-content" class="form-label">Main Content</label>
                                            <textarea id="section-content" name="content" class="form-control" rows="4" placeholder="HTML content is supported"></textarea>
                                        </div>

                                        <!-- Image Section -->
                                        <h6 class="mt-4 mb-3">Image Settings</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="section-image" class="form-label">Image URL</label>
                                                    <input type="text" id="section-image" name="image_url" class="form-control" placeholder="https://example.com/image.jpg">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="section-image-alt" class="form-label">Image Alt Text</label>
                                                    <input type="text" id="section-image-alt" name="image_alt" class="form-control" placeholder="Description for accessibility">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Color & Styling Section -->
                                        <h6 class="mt-4 mb-3">Styling & Colors</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="section-bg-color" class="form-label">Background Color</label>
                                                    <input type="color" id="section-bg-color" name="background_color" class="form-control form-control-color">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="section-text-color" class="form-label">Text Color</label>
                                                    <input type="color" id="section-text-color" name="text_color" class="form-control form-control-color">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="section-heading-size" class="form-label">Heading Size</label>
                                                    <select id="section-heading-size" name="heading_size" class="form-select">
                                                        <option value="small">Small</option>
                                                        <option value="normal" selected>Normal</option>
                                                        <option value="large">Large</option>
                                                        <option value="xlarge">Extra Large</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Layout Section -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="section-text-align" class="form-label">Text Alignment</label>
                                                    <select id="section-text-align" name="text_alignment" class="form-select">
                                                        <option value="left">Left</option>
                                                        <option value="center">Center</option>
                                                        <option value="right">Right</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="section-padding" class="form-label">Padding</label>
                                                    <select id="section-padding" name="padding" class="form-select">
                                                        <option value="none">None</option>
                                                        <option value="small">Small</option>
                                                        <option value="standard" selected>Standard</option>
                                                        <option value="large">Large</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="section-layout" class="form-label">Layout Style</label>
                                                    <select id="section-layout" name="layout_style" class="form-select">
                                                        <option value="default" selected>Default</option>
                                                        <option value="grid">Grid</option>
                                                        <option value="masonry">Masonry</option>
                                                        <option value="carousel">Carousel</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Button Section -->
                                        <h6 class="mt-4 mb-3">Button Settings</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="section-button-text" class="form-label">Button Text</label>
                                                    <input type="text" id="section-button-text" name="button_text" class="form-control" placeholder="e.g., Learn More">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="section-button-link" class="form-label">Button Link</label>
                                                    <input type="url" id="section-button-link" name="button_link" class="form-control" placeholder="https://example.com">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="section-button-color" class="form-label">Button Background</label>
                                                    <input type="color" id="section-button-color" name="button_color" class="form-control form-control-color" value="#007bff">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="section-button-text-color" class="form-label">Button Text Color</label>
                                                    <input type="color" id="section-button-text-color" name="button_text_color" class="form-control form-control-color" value="#ffffff">
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-3">Add Section</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Existing Sections -->
                        @if(count($sections) > 0)
                            <div class="sections-list">
                                @foreach($sections as $section)
                                <div class="card mb-3 section-item">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                <i class="fas fa-{{ $section->type === 'text' ? 'paragraph' : 'image' }}"></i>
                                                {{ $section->title }}
                                                <span class="badge bg-secondary">{{ ucfirst($section->type) }}</span>
                                            </h6>
                                            <div>
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#edit-section-{{ $section->id }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <form action="{{ route('cms.delete-section', $section) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this section?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted">{{ Str::limit(strip_tags($section->content), 150) }}</p>
                                        
                                        <div class="mt-3 row">
                                            @if($section->background_color)
                                                <div class="col-auto">
                                                    <small class="text-muted">Background:</small>
                                                    <div class="p-2 rounded border" style="background-color: {{ $section->background_color }}; width: 40px; height: 40px;"></div>
                                                </div>
                                            @endif
                                            @if($section->text_color)
                                                <div class="col-auto">
                                                    <small class="text-muted">Text:</small>
                                                    <div class="p-2 rounded border" style="background-color: {{ $section->text_color }}; width: 40px; height: 40px;"></div>
                                                </div>
                                            @endif
                                            @if($section->button_color)
                                                <div class="col-auto">
                                                    <small class="text-muted">Button:</small>
                                                    <button class="btn btn-sm" style="background-color: {{ $section->button_color }}; color: {{ $section->button_text_color ?? '#fff' }}; border: none;">
                                                        {{ $section->button_text ?? 'Button' }}
                                                    </button>
                                                </div>
                                            @endif
                                            @if($section->image_url)
                                                <div class="col-auto">
                                                    <small class="text-muted">Image:</small><br>
                                                    <img src="{{ $section->image_url }}" alt="{{ $section->image_alt }}" style="max-width: 60px; max-height: 40px; object-fit: cover; border-radius: 4px;">
                                                </div>
                                            @endif
                                        </div>

                                        @if($section->heading_size || $section->padding || $section->layout_style)
                                            <div class="mt-2 pt-2 border-top">
                                                <small class="text-muted d-block">
                                                    @if($section->heading_size) Size: <span class="badge bg-info">{{ ucfirst($section->heading_size) }}</span> @endif
                                                    @if($section->padding) Padding: <span class="badge bg-info">{{ ucfirst($section->padding) }}</span> @endif
                                                    @if($section->text_alignment) Align: <span class="badge bg-info">{{ ucfirst($section->text_alignment) }}</span> @endif
                                                    @if($section->layout_style) Layout: <span class="badge bg-info">{{ ucfirst($section->layout_style) }}</span> @endif
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Edit Section Modal -->
                                <div class="modal fade" id="edit-section-{{ $section->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Section: {{ $section->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('cms.update-section', $section) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                    <!-- Basic Info -->
                                                    <div class="mb-3">
                                                        <label for="edit-title-{{ $section->id }}" class="form-label"><strong>Title</strong></label>
                                                        <input type="text" id="edit-title-{{ $section->id }}" name="title" class="form-control" value="{{ $section->title }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit-type-{{ $section->id }}" class="form-label"><strong>Type</strong></label>
                                                        <select id="edit-type-{{ $section->id }}" name="type" class="form-select" required>
                                                            <option value="text" {{ $section->type === 'text' ? 'selected' : '' }}>Text</option>
                                                            <option value="image" {{ $section->type === 'image' ? 'selected' : '' }}>Image</option>
                                                            <option value="video" {{ $section->type === 'video' ? 'selected' : '' }}>Video</option>
                                                            <option value="slider" {{ $section->type === 'slider' ? 'selected' : '' }}>Slider</option>
                                                            <option value="hero" {{ $section->type === 'hero' ? 'selected' : '' }}>Hero Banner</option>
                                                            <option value="features" {{ $section->type === 'features' ? 'selected' : '' }}>Features</option>
                                                        </select>
                                                    </div>

                                                    <!-- Content -->
                                                    <div class="mb-3">
                                                        <label for="edit-content-{{ $section->id }}" class="form-label"><strong>Content</strong></label>
                                                        <textarea id="edit-content-{{ $section->id }}" name="content" class="form-control" rows="4" required>{{ $section->content }}</textarea>
                                                        <small class="text-muted">HTML is supported</small>
                                                    </div>

                                                    <!-- Image Settings -->
                                                    <hr>
                                                    <h6><strong>Image Settings</strong></h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit-image-{{ $section->id }}" class="form-label">Image URL</label>
                                                                <input type="text" id="edit-image-{{ $section->id }}" name="image_url" class="form-control" value="{{ $section->image_url ?? '' }}" placeholder="https://example.com/image.jpg">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit-image-alt-{{ $section->id }}" class="form-label">Image Alt Text</label>
                                                                <input type="text" id="edit-image-alt-{{ $section->id }}" name="image_alt" class="form-control" value="{{ $section->image_alt ?? '' }}" placeholder="Description">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Colors & Styling -->
                                                    <hr>
                                                    <h6><strong>Colors & Styling</strong></h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit-bg-color-{{ $section->id }}" class="form-label">Background Color</label>
                                                                <input type="color" id="edit-bg-color-{{ $section->id }}" name="background_color" class="form-control form-control-color" value="{{ $section->background_color ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit-text-color-{{ $section->id }}" class="form-label">Text Color</label>
                                                                <input type="color" id="edit-text-color-{{ $section->id }}" name="text_color" class="form-control form-control-color" value="{{ $section->text_color ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Layout Options -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit-heading-size-{{ $section->id }}" class="form-label">Heading Size</label>
                                                                <select id="edit-heading-size-{{ $section->id }}" name="heading_size" class="form-select">
                                                                    <option value="small" {{ ($section->heading_size ?? 'normal') === 'small' ? 'selected' : '' }}>Small</option>
                                                                    <option value="normal" {{ ($section->heading_size ?? 'normal') === 'normal' ? 'selected' : '' }}>Normal</option>
                                                                    <option value="large" {{ ($section->heading_size ?? 'normal') === 'large' ? 'selected' : '' }}>Large</option>
                                                                    <option value="xlarge" {{ ($section->heading_size ?? 'normal') === 'xlarge' ? 'selected' : '' }}>Extra Large</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit-text-align-{{ $section->id }}" class="form-label">Text Alignment</label>
                                                                <select id="edit-text-align-{{ $section->id }}" name="text_alignment" class="form-select">
                                                                    <option value="left" {{ ($section->text_alignment ?? 'left') === 'left' ? 'selected' : '' }}>Left</option>
                                                                    <option value="center" {{ ($section->text_alignment ?? 'left') === 'center' ? 'selected' : '' }}>Center</option>
                                                                    <option value="right" {{ ($section->text_alignment ?? 'left') === 'right' ? 'selected' : '' }}>Right</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit-padding-{{ $section->id }}" class="form-label">Padding</label>
                                                                <select id="edit-padding-{{ $section->id }}" name="padding" class="form-select">
                                                                    <option value="none" {{ ($section->padding ?? 'standard') === 'none' ? 'selected' : '' }}>None</option>
                                                                    <option value="small" {{ ($section->padding ?? 'standard') === 'small' ? 'selected' : '' }}>Small</option>
                                                                    <option value="standard" {{ ($section->padding ?? 'standard') === 'standard' ? 'selected' : '' }}>Standard</option>
                                                                    <option value="large" {{ ($section->padding ?? 'standard') === 'large' ? 'selected' : '' }}>Large</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit-layout-{{ $section->id }}" class="form-label">Layout Style</label>
                                                                <select id="edit-layout-{{ $section->id }}" name="layout_style" class="form-select">
                                                                    <option value="default" {{ ($section->layout_style ?? 'default') === 'default' ? 'selected' : '' }}>Default</option>
                                                                    <option value="grid" {{ ($section->layout_style ?? 'default') === 'grid' ? 'selected' : '' }}>Grid</option>
                                                                    <option value="masonry" {{ ($section->layout_style ?? 'default') === 'masonry' ? 'selected' : '' }}>Masonry</option>
                                                                    <option value="carousel" {{ ($section->layout_style ?? 'default') === 'carousel' ? 'selected' : '' }}>Carousel</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Button Settings -->
                                                    <hr>
                                                    <h6><strong>Button Settings</strong></h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit-btn-text-{{ $section->id }}" class="form-label">Button Text</label>
                                                                <input type="text" id="edit-btn-text-{{ $section->id }}" name="button_text" class="form-control" value="{{ $section->button_text ?? '' }}" placeholder="e.g., Learn More">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit-btn-link-{{ $section->id }}" class="form-label">Button Link</label>
                                                                <input type="url" id="edit-btn-link-{{ $section->id }}" name="button_link" class="form-control" value="{{ $section->button_link ?? '' }}" placeholder="https://example.com">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit-btn-color-{{ $section->id }}" class="form-label">Button Background</label>
                                                                <input type="color" id="edit-btn-color-{{ $section->id }}" name="button_color" class="form-control form-control-color" value="{{ $section->button_color ?? '#007bff' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit-btn-text-color-{{ $section->id }}" class="form-label">Button Text Color</label>
                                                                <input type="color" id="edit-btn-text-color-{{ $section->id }}" name="button_text_color" class="form-control form-control-color" value="{{ $section->button_text_color ?? '#ffffff' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> No sections added yet. Click "Add New Section" to get started.
                            </div>
                        @endif
                    </div>

                    <!-- Tab 3: SEO -->
                    <div class="tab-pane fade" id="page-seo" role="tabpanel">
                        <form action="{{ route('cms.update-page', $page) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="seo_title" class="form-label">SEO Title</label>
                                <input type="text" id="seo_title" name="seo_title" class="form-control @error('seo_title') is-invalid @enderror" 
                                       value="{{ old('seo_title', $page->seo_title) }}" maxlength="60">
                                <small class="form-text text-muted">Recommended: 30-60 characters</small>
                                @error('seo_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="seo_description" class="form-label">Meta Description</label>
                                <textarea id="seo_description" name="seo_description" class="form-control @error('seo_description') is-invalid @enderror" 
                                          rows="2" maxlength="160">{{ old('seo_description', $page->seo_description) }}</textarea>
                                <small class="form-text text-muted">Recommended: 120-160 characters</small>
                                @error('seo_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save SEO Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .section-item {
        transition: all 0.3s ease;
    }
    .section-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>
@endsection
