@extends('layouts.cms')

@section('title', 'Edit Block - ' . $block->title)

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Edit Block: {{ $block->title }}</h5>
                <a href="{{ route('cms.blocks') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('cms.update-block', $block) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Display Title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title', $block->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="2">{{ old('description', $block->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="block_type" class="form-label">Block Type <span class="text-danger">*</span></label>
                        <select id="block_type" name="block_type" class="form-select @error('block_type') is-invalid @enderror" required>
                            <option value="reusable" {{ old('block_type', $block->block_type) === 'reusable' ? 'selected' : '' }}>Reusable (Can be used on multiple pages)</option>
                            <option value="custom" {{ old('block_type', $block->block_type) === 'custom' ? 'selected' : '' }}>Custom (Page-specific)</option>
                        </select>
                        @error('block_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Block Content <span class="text-danger">*</span></label>
                        <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" 
                                  rows="10" required>{{ old('content', $block->content) }}</textarea>
                        <small class="form-text text-muted">Supports HTML markup</small>
                        @error('content')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <small>
                            <strong>Block ID:</strong> {{ $block->name }}<br>
                            <strong>Created:</strong> {{ $block->created_at->format('M d, Y H:i') }}<br>
                            <strong>Updated:</strong> {{ $block->updated_at->format('M d, Y H:i') }}
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <a href="{{ route('cms.blocks') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
