@extends('layouts.site-admin')

@section('title', 'Tags Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tags</h3>
                </div>
                <div class="card-body">
                    <!-- Add Tag Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form action="{{ route('cms.store-tag') }}" method="POST" class="border p-3 rounded">
                                @csrf
                                <h5>Add New Tag</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Name *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                   id="slug" name="slug">
                                            <small class="form-text text-muted">Auto-generated if empty</small>
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="color">Color</label>
                                            <input type="color" class="form-control @error('color') is-invalid @enderror"
                                                   id="color" name="color" value="#6c757d">
                                            @error('color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Tag
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Tags List -->
                    <div class="row">
                        @forelse($tags as $tag)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title mb-1">
                                                <span class="badge" style="background-color: {{ $tag->color }}; color: white;">
                                                    #{{ $tag->name }}
                                                </span>
                                            </h6>
                                            <small class="text-muted">{{ $tag->slug }}</small>
                                            <br>
                                            <small class="text-info">{{ $tag->usage_count }} posts</small>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary edit-tag"
                                                    data-id="{{ $tag->id }}"
                                                    data-name="{{ $tag->name }}"
                                                    data-slug="{{ $tag->slug }}"
                                                    data-color="{{ $tag->color }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('cms.delete-tag', $tag) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this tag?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted">
                            <i class="fas fa-hashtag fa-3x mb-3"></i>
                            <p>No tags found. Add your first tag above.</p>
                        </div>
                        @endforelse
                    </div>

                    @if($tags->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tags->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Tag Modal -->
<div class="modal fade" id="editTagModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tag</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editTagForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editName">Name *</label>
                                <input type="text" class="form-control" id="editName" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editSlug">Slug</label>
                                <input type="text" class="form-control" id="editSlug" name="slug">
                                <small class="form-text text-muted">Auto-generated if empty</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editColor">Color</label>
                        <input type="color" class="form-control" id="editColor" name="color">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let currentTagId = null;

    // Auto-generate slug from name
    $('#name').on('input', function() {
        const name = $(this).val();
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        $('#slug').val(slug);
    });

    // Edit tag
    $('.edit-tag').on('click', function() {
        currentTagId = $(this).data('id');
        $('#editName').val($(this).data('name'));
        $('#editSlug').val($(this).data('slug'));
        $('#editColor').val($(this).data('color'));
        $('#editTagModal').modal('show');
    });

    // Submit edit form
    $('#editTagForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("cms.update-tag", ":id") }}'.replace(':id', currentTagId),
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#editTagModal').modal('hide');
                location.reload(); // Simple reload for now
            },
            error: function(xhr) {
                alert('Update failed: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    });
});
</script>
@endpush