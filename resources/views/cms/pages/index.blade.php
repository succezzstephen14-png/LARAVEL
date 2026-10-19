@extends('layouts.cms')

@section('title', 'Pages Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">CMS Pages</h5>
                <a href="{{ route('cms.create-page') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Page
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Template</th>
                                <th>Status</th>
                                <th>Home Page</th>
                                <th>Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                            <tr>
                                <td>
                                    <strong>{{ $page->title }}</strong>
                                    @if($page->description)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($page->description, 60) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <code>{{ $page->slug }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $page->template ?: 'default' }}</span>
                                </td>
                                <td>
                                    @if($page->is_published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    @if($page->is_home)
                                        <span class="badge bg-primary">Home Page</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $page->order }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('cms.edit-page', $page) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(!$page->is_published)
                                        <form action="{{ route('cms.publish-page', $page) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Publish">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('cms.delete-page', $page) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this page?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">No pages found</h6>
                                        <p class="text-muted">Get started by creating your first page.</p>
                                        <a href="{{ route('cms.create-page') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Create First Page
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($pages->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $pages->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection