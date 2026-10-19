@extends('layouts.site-admin')

@section('title', 'Roles Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Roles & Permissions</h3>
                    <div class="card-tools">
                        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create Role
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Display Name</th>
                                    <th>Description</th>
                                    <th>Priority</th>
                                    <th>Users</th>
                                    <th>Permissions</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                <tr>
                                    <td>
                                        <code>{{ $role->name }}</code>
                                    </td>
                                    <td>
                                        <strong>{{ $role->display_name }}</strong>
                                    </td>
                                    <td>{{ Str::limit($role->description, 50) }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $role->priority }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $role->users->count() }} users</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">{{ $role->permissions->count() }} permissions</span>
                                    </td>
                                    <td>
                                        @if($role->is_system_role)
                                            <span class="badge badge-danger">System</span>
                                        @else
                                            <span class="badge badge-primary">Custom</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            @if(!$role->is_system_role)
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this role?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No roles found. <a href="{{ route('roles.create') }}">Create your first role</a>.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($roles->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $roles->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection