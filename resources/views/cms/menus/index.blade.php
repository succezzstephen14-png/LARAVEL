@extends('layouts.cms')

@section('title', 'Menu Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Navigation Menus</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Description</th>
                                <th>Items Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menus as $menu)
                            <tr>
                                <td>
                                    <strong>{{ $menu->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $menu->location ?: 'Not set' }}</span>
                                </td>
                                <td>
                                    @if($menu->description)
                                        {{ Str::limit($menu->description, 60) }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $menu->items_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('cms.edit-menu', $menu) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-bars fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">No menus found</h6>
                                        <p class="text-muted">Menus will appear here once they are created.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection