@extends('layouts.site-admin')

@section('title', 'Categories Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories</h3>
                </div>
                <div class="card-body">
                    <!-- Add Category Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form action="{{ route('cms.store-category') }}" method="POST" class="border p-3 rounded">
                                @csrf
                                <h5>Add New Category</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name">Name *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="color">Color</label>
                                            <input type="color" class="form-control @error('color') is-invalid @enderror"
                                                   id="color" name="color" value="#007bff">
                                            @error('color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label><br>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                                                <label class="form-check-label" for="is_active">Active</label>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm mt-2">
                                                <i class="fas fa-plus"></i> Add Category
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      id="description" name="description" rows="2"></textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="icon">Icon Class</label>
                                            <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                                   id="icon" name="icon" placeholder="fas fa-tag">
                                            <small class="form-text text-muted">FontAwesome icon class (optional)</small>
                                            @error('icon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Categories List -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th>Posts</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    <td>
                                        @if($category->icon)
                                            <i class="{{ $category->icon }}" style="color: {{ $category->color }};"></i>
                                        @endif
                                        <strong>{{ $category->name }}</strong>
                                    </td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ Str::limit($category->description, 50) }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $category->posts->count() }} posts</span>
                                    </td>
                                    <td>
                                        @if($category->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary edit-category"
                                                data-id="{{ $category->id }}"
                                                data-name="{{ $category->name }}"
                                                data-slug="{{ $category->slug }}"
                                                data-description="{{ $category->description }}"
                                                data-color="{{ $category->color }}"
                                                data-icon="{{ $category->icon }}"
                                                data-active="{{ $category->is_active }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('cms.delete-category', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No categories found. Add your first category above.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($categories->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $categories->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editCategoryForm">
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editColor">Color</label>
                                <input type="color" class="form-control" id="editColor" name="color">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editIcon">Icon Class</label>
                                <input type="text" class="form-control" id="editIcon" name="icon" placeholder="fas fa-tag">
                                <small class="form-text text-muted">FontAwesome icon class (optional)</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editDescription">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="editIsActive" name="is_active" value="1">
                        <label class="form-check-label" for="editIsActive">Active</label>
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
    let currentCategoryId = null;

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

    // Edit category
    $('.edit-category').on('click', function() {
        currentCategoryId = $(this).data('id');
        $('#editName').val($(this).data('name'));
        $('#editSlug').val($(this).data('slug'));
        $('#editDescription').val($(this).data('description'));
        $('#editColor').val($(this).data('color'));
        $('#editIcon').val($(this).data('icon'));
        $('#editIsActive').prop('checked', $(this).data('active') == 1);
        $('#editCategoryModal').modal('show');
    });

    // Submit edit form
    $('#editCategoryForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("cms.update-category", ":id") }}'.replace(':id', currentCategoryId),
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#editCategoryModal').modal('hide');
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