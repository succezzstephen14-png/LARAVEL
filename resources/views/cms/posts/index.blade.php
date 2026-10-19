@extends('layouts.site-admin')

@section('title', 'Blog Posts Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Blog Posts</h3>
                    <div class="card-tools">
                        <a href="{{ route('cms.create-post') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> New Post
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Categories</th>
                                <th>Author</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                            <tr>
                                <td>
                                    <strong>{{ $post->title }}</strong>
                                    @if($post->is_featured)
                                        <span class="badge badge-warning ml-2">Featured</span>
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ Str::limit($post->excerpt, 50) }}</small>
                                </td>
                                <td>
                                    @if($post->status === 'published')
                                        <span class="badge badge-success">Published</span>
                                    @elseif($post->status === 'scheduled')
                                        <span class="badge badge-info">Scheduled</span>
                                    @else
                                        <span class="badge badge-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    @foreach($post->categories as $category)
                                        <span class="badge badge-primary">{{ $category->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $post->author_name ?: 'Anonymous' }}</td>
                                <td>
                                    @if($post->published_at)
                                        {{ $post->published_at->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('cms.edit-post', $post) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($post->status !== 'published')
                                        <form action="{{ route('cms.publish-post', $post) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Publish">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('cms.delete-post', $post) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No posts found. <a href="{{ route('cms.create-post') }}">Create your first post</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($posts->hasPages())
                <div class="card-footer">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection