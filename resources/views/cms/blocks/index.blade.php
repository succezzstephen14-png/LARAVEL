@extends('layouts.cms')

@section('title', 'Reusable Blocks Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Reusable Blocks</h5>
                <a href="{{ route('cms.create-block') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Block
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blocks as $block)
                            <tr>
                                <td>
                                    <code>{{ $block->name }}</code>
                                </td>
                                <td>
                                    <strong>{{ $block->title }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($block->block_type) }}</span>
                                </td>
                                <td>
                                    @if($block->description)
                                        {{ Str::limit($block->description, 50) }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('cms.edit-block', $block) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('cms.delete-block', $block) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this block?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-cubes fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">No blocks found</h6>
                                        <p class="text-muted">Get started by creating your first reusable block.</p>
                                        <a href="{{ route('cms.create-block') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Create First Block
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($blocks->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $blocks->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection