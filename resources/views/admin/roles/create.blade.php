@extends('layouts.site-admin')

@section('title', 'Create New Role')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Role</h3>
                    <div class="card-tools">
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Roles
                        </a>
                    </div>
                </div>
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Role Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    <small class="form-text text-muted">Unique identifier (e.g., 'content_manager')</small>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="display_name">Display Name *</label>
                                    <input type="text" class="form-control @error('display_name') is-invalid @enderror"
                                           id="display_name" name="display_name" value="{{ old('display_name') }}" required>
                                    <small class="form-text text-muted">Human-readable name (e.g., 'Content Manager')</small>
                                    @error('display_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="priority">Priority</label>
                                    <input type="number" class="form-control @error('priority') is-invalid @enderror"
                                           id="priority" name="priority" value="{{ old('priority', 0) }}" min="0" max="999">
                                    <small class="form-text text-muted">Higher priority = more permissions (0-999)</small>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                    <small class="form-text text-muted">Brief description of this role's purpose</small>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Permissions Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Assign Permissions</h5>
                                <p class="text-muted">Select the permissions this role should have:</p>

                                @php
                                    $permissionsByGroup = $permissions->groupBy('group');
                                @endphp

                                @foreach($permissionsByGroup as $group => $groupPermissions)
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <input type="checkbox" class="select-all-group" data-group="{{ $group }}">
                                            {{ ucfirst(str_replace('_', ' ', $group)) }} Permissions
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($groupPermissions as $permission)
                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input permission-checkbox"
                                                           id="permission_{{ $permission->id }}" name="permissions[]"
                                                           value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        <strong>{{ $permission->display_name }}</strong>
                                                        @if($permission->description)
                                                            <br><small class="text-muted">{{ $permission->description }}</small>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Role
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary ml-2">
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
    // Select all permissions in a group
    $('.select-all-group').on('change', function() {
        const group = $(this).data('group');
        const isChecked = $(this).is(':checked');

        $(`.permission-checkbox`).each(function() {
            const checkbox = $(this);
            const permissionId = checkbox.val();

            // Find the permission and check if it belongs to this group
            @foreach($permissions as $permission)
                if ({{ $permission->id }} == permissionId && '{{ $permission->group }}' == group) {
                    checkbox.prop('checked', isChecked);
                }
            @endforeach
        });
    });

    // Auto-generate display name from name
    $('#name').on('input', function() {
        if (!$('#display_name').val()) {
            const name = $(this).val();
            const displayName = name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            $('#display_name').val(displayName);
        }
    });
});
</script>
@endpush