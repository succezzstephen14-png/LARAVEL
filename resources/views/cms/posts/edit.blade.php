@extends('layouts.site-admin')

@section('title', 'Edit Post')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Post: {{ $post->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('cms.posts') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Posts
                        </a>
                    </div>
                </div>
                <form action="{{ route('cms.update-post', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Main Content Column -->
                            <div class="col-md-8">
                                <!-- Basic Information -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="title">Title *</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                   id="title" name="title" value="{{ old('title', $post->title) }}" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                   id="slug" name="slug" value="{{ old('slug', $post->slug) }}">
                                            <small class="form-text text-muted">Auto-generated if empty</small>
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="excerpt">Excerpt</label>
                                            <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                                      id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
                                            <small class="form-text text-muted">Brief summary of the post</small>
                                            @error('excerpt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Content</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="content">Content *</label>
                                            <textarea class="form-control @error('content') is-invalid @enderror"
                                                      id="content" name="content" rows="15">{{ old('content', $post->content) }}</textarea>
                                            @error('content')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO Settings -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">SEO Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                                   id="meta_title" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}">
                                            <small class="form-text text-muted">Leave empty to use post title</small>
                                            @error('meta_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                                      id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $post->meta_description) }}</textarea>
                                            <small class="form-text text-muted">Brief description for search engines (150-160 characters)</small>
                                            @error('meta_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $post->meta_keywords) }}">
                                            <small class="form-text text-muted">Comma-separated keywords</small>
                                            @error('meta_keywords')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar Column -->
                            <div class="col-md-4">
                                <!-- Status & Publishing -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Publishing</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="scheduled" {{ old('status', $post->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group" id="publish_date_group" style="display: {{ old('status', $post->status) == 'scheduled' ? 'block' : 'none' }};">
                                            <label for="published_at">Publish Date & Time</label>
                                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                                   id="published_at" name="published_at" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                                            @error('published_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Featured Post</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Categories -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Categories</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <select multiple class="form-control @error('categories') is-invalid @enderror" id="categories" name="categories[]">
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('categories')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Tags -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Tags</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <select multiple class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags[]">
                                                @foreach($tags as $tag)
                                                <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                    {{ $tag->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('tags')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Featured Image -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Featured Image</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($post->featured_image)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Featured Image" class="img-fluid rounded">
                                        </div>
                                        @endif

                                        <div class="form-group">
                                            <label for="featured_image">Upload New Image</label>
                                            <input type="file" class="form-control-file @error('featured_image') is-invalid @enderror"
                                                   id="featured_image" name="featured_image" accept="image/*">
                                            <small class="form-text text-muted">Recommended: 1200x600px, max 2MB</small>
                                            @error('featured_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Post
                        </button>
                        <a href="{{ route('cms.posts') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-generate slug from title
    $('#title').on('input', function() {
        const title = $(this).val();
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        $('#slug').val(slug);
    });

    // Show/hide publish date based on status
    $('#status').on('change', function() {
        if ($(this).val() === 'scheduled') {
            $('#publish_date_group').show();
        } else {
            $('#publish_date_group').hide();
        }
    });

    // Initialize select2 for categories and tags
    $('#categories').select2({
        placeholder: 'Select categories...',
        allowClear: true
    });

    $('#tags').select2({
        placeholder: 'Select tags...',
        allowClear: true
    });

    // Initialize rich text editor (using Summernote as example)
    $('#content').summernote({
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'help']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                // Handle image upload to media library
                for (let i = 0; i < files.length; i++) {
                    uploadImage(files[i]);
                }
            }
        }
    });

    function uploadImage(file) {
        const data = new FormData();
        data.append('file', file);

        $.ajax({
            url: '{{ route("cms.upload-media") }}',
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#content').summernote('insertImage', response.url);
            },
            error: function(xhr) {
                alert('Image upload failed: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    }
});
</script>
@endpush