@extends('layouts.cms')

@section('title', 'Preview - ' . $page->title)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-eye"></i> Page Preview: {{ $page->title }}
                </h5>
                <div>
                    <a href="{{ route('cms.edit-page', $page) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit Page
                    </a>
                    <a href="{{ route('cms.pages') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <!-- Page Preview Container -->
                <div class="page-preview" style="background: white;">
                    <!-- Page Header -->
                    <div class="bg-light border-bottom p-4">
                        <div class="container">
                            <h1 class="mb-2">{{ $page->title }}</h1>
                            @if($page->description)
                                <p class="text-muted mb-0">{{ $page->description }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Page Sections -->
                    @if($page->sections->count() > 0)
                        @foreach($page->sections as $section)
                            <div class="section" style="padding: 3rem 0; {{ $section->background_color ? 'background-color: ' . $section->background_color . '; color: white;' : '' }}">
                                <div class="container">
                                    @if($section->title)
                                        <h2 class="mb-3">{{ $section->title }}</h2>
                                    @endif

                                    @switch($section->type)
                                        @case('text')
                                            <div class="content">
                                                {!! nl2br(e($section->content)) !!}
                                            </div>
                                            @break

                                        @case('image')
                                            <div class="text-center">
                                                @if(filter_var($section->content, FILTER_VALIDATE_URL))
                                                    <img src="{{ $section->content }}" alt="{{ $section->title }}" class="img-fluid rounded" style="max-height: 500px;">
                                                @else
                                                    <div class="alert alert-warning">
                                                        <i class="fas fa-image"></i> Invalid image URL
                                                    </div>
                                                @endif
                                            </div>
                                            @break

                                        @case('video')
                                            <div class="ratio ratio-16x9">
                                                @if(str_contains($section->content, 'youtube.com') || str_contains($section->content, 'youtu.be'))
                                                    <iframe src="{{ $section->content }}" title="{{ $section->title }}" allowfullscreen></iframe>
                                                @else
                                                    <video controls>
                                                        <source src="{{ $section->content }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @endif
                                            </div>
                                            @break

                                        @case('hero')
                                            <div class="hero-section text-center py-5"
                                                 @if($section->background_color)
                                                     style="background: linear-gradient(135deg, {{ $section->background_color }} 0%, rgba(0,0,0,0.1) 100%);"
                                                 @endif>
                                                <h1 class="display-4 fw-bold mb-3">{{ $section->title }}</h1>
                                                <p class="lead">{{ $section->content }}</p>
                                            </div>
                                            @break

                                        @case('features')
                                            <div class="row">
                                                @foreach(explode("\n", $section->content) as $feature)
                                                    @if(trim($feature))
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <div class="card h-100">
                                                                <div class="card-body">
                                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                                    {{ trim($feature) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @break

                                        @case('slider')
                                            <div id="slider-{{ $section->id }}" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    @php $slides = array_filter(explode("\n", $section->content)); @endphp
                                                    @foreach($slides as $index => $slide)
                                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                            <img src="{{ trim($slide) }}" class="d-block w-100" alt="Slide {{ $index + 1 }}" style="max-height: 400px; object-fit: cover;">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#slider-{{ $section->id }}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#slider-{{ $section->id }}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                            </div>
                                            @break

                                        @default
                                            <div class="alert alert-secondary">
                                                Section type "{{ $section->type }}" - No preview available
                                            </div>
                                    @endswitch
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info m-4">
                            <i class="fas fa-info-circle"></i> No sections added to this page yet.
                            <a href="{{ route('cms.edit-page', $page) }}" class="alert-link">Add sections now</a>
                        </div>
                    @endif

                    <!-- Footer -->
                    <div class="bg-light border-top p-4 mt-4">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Status:</strong> 
                                        @if($page->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </small>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <small class="text-muted">
                                        <strong>Last Updated:</strong> {{ $page->updated_at->format('M d, Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-preview {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .page-preview h1, .page-preview h2, .page-preview h3 {
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .page-preview .section {
        border-bottom: 1px solid #eee;
    }

    .page-preview .section:last-child {
        border-bottom: none;
    }

    .page-preview img {
        max-width: 100%;
        height: auto;
    }

    .ratio {
        width: 100%;
    }
</style>
@endsection
