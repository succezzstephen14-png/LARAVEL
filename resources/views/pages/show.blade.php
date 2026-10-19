@extends('layouts.app')

@section('title', $page->seo_title ?: $page->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Page Title -->
            <div class="page-header mb-5" style="border-bottom: 3px solid {{ $settings->primary_color ?? '#6366f1' }}; padding-bottom: 2rem;">
                <h1 style="color: {{ $settings->primary_color ?? '#6366f1' }}; font-weight: 700; margin-bottom: 0.5rem;">
                    {{ $page->title }}
                </h1>
                @if($page->description)
                    <p class="text-muted lead mb-0">
                        {{ $page->description }}
                    </p>
                @endif
            </div>

            <!-- Page Sections -->
            @if($page->sections->count() > 0)
                @foreach($page->sections as $section)
                    @if($section->is_visible !== false)
                        <div class="page-section mb-5">
                            @if($section->type === 'text')
                                <div class="text-section">
                                    @if($section->title)
                                        <h2 style="color: {{ $settings->primary_color ?? '#6366f1' }}; margin-bottom: 1.5rem;">
                                            {{ $section->title }}
                                        </h2>
                                    @endif
                                    <div class="content-body">
                                        {!! $section->content !!}
                                    </div>
                                    @if($section->button_text && $section->button_link)
                                        <div style="margin-top: 1.5rem;">
                                            <a href="{{ $section->button_link }}" class="btn" style="background-color: {{ $section->button_color ?? '#6366f1' }}; color: {{ $section->button_text_color ?? '#ffffff' }}; border: none; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                                                {{ $section->button_text }}
                                            </a>
                                        </div>
                                    @endif
                                </div>

                            @elseif($section->type === 'image')
                                <div class="image-section mb-4">
                                    @if($section->title)
                                        <h2 style="color: {{ $settings->primary_color ?? '#6366f1' }}; margin-bottom: 1rem;">
                                            {{ $section->title }}
                                        </h2>
                                    @endif
                                    @if($section->content)
                                        <img src="{{ asset($section->content) }}" alt="{{ $section->title }}" class="img-fluid rounded" style="max-height: 500px; object-fit: cover; width: 100%;">
                                    @elseif($section->image_url)
                                        <img src="{{ $section->image_url }}" alt="{{ $section->image_alt ?? $section->title }}" class="img-fluid rounded" style="max-height: 500px; object-fit: cover; width: 100%;">
                                    @endif
                                    @if($section->button_text && $section->button_link)
                                        <div style="margin-top: 1.5rem;">
                                            <a href="{{ $section->button_link }}" class="btn" style="background-color: {{ $section->button_color ?? '#6366f1' }}; color: {{ $section->button_text_color ?? '#ffffff' }}; border: none; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                                                {{ $section->button_text }}
                                            </a>
                                        </div>
                                    @endif
                                </div>

                            @elseif($section->type === 'hero')
                                <div class="hero-section mb-5" style="background: {{ $section->background_color ?? 'linear-gradient(135deg, ' . ($settings->primary_color ?? '#6366f1') . ' 0%, ' . ($settings->secondary_color ?? '#8b5cf6') . ' 100%)' }}; border-radius: 1rem; padding: 4rem 2rem; color: white; text-align: center;">
                                    @if($section->title)
                                        <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">
                                            {{ $section->title }}
                                        </h2>
                                    @endif
                                    @if($section->content)
                                        <p style="font-size: 1.1rem; opacity: 0.95; margin-bottom: 1.5rem;">
                                            {!! $section->content !!}
                                        </p>
                                    @endif
                                    @if($section->button_text && $section->button_link)
                                        <div>
                                            <a href="{{ $section->button_link }}" class="btn" style="background-color: {{ $section->button_color ?? '#ffffff' }}; color: {{ $section->button_text_color ?? '#000000' }}; border: none; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                                                {{ $section->button_text }}
                                            </a>
                                        </div>
                                    @endif
                                </div>

                            @elseif($section->type === 'features')
                                <div class="features-section mb-5">
                                    @if($section->title)
                                        <h2 style="color: {{ $settings->primary_color ?? '#6366f1' }}; margin-bottom: 2rem; text-align: center;">
                                            {{ $section->title }}
                                        </h2>
                                    @endif
                                    <div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                                        {!! $section->content !!}
                                    </div>
                                    @if($section->button_text && $section->button_link)
                                        <div style="margin-top: 2rem; text-align: center;">
                                            <a href="{{ $section->button_link }}" class="btn" style="background-color: {{ $section->button_color ?? '#6366f1' }}; color: {{ $section->button_text_color ?? '#ffffff' }}; border: none; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                                                {{ $section->button_text }}
                                            </a>
                                        </div>
                                    @endif
                                </div>

                            @elseif($section->type === 'video')
                                <div class="video-section mb-5">
                                    @if($section->title)
                                        <h2 style="color: {{ $settings->primary_color ?? '#6366f1' }}; margin-bottom: 1rem;">
                                            {{ $section->title }}
                                        </h2>
                                    @endif
                                    @if($section->content)
                                        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 1rem;">
                                            {!! $section->content !!}
                                        </div>
                                    @endif
                                    @if($section->button_text && $section->button_link)
                                        <div style="margin-top: 1.5rem;">
                                            <a href="{{ $section->button_link }}" class="btn" style="background-color: {{ $section->button_color ?? '#6366f1' }}; color: {{ $section->button_text_color ?? '#ffffff' }}; border: none; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                                                {{ $section->button_text }}
                                            </a>
                                        </div>
                                    @endif
                                </div>

                            @elseif($section->type === 'slider')
                                <div class="slider-section mb-5">
                                    @if($section->title)
                                        <h2 style="color: {{ $settings->primary_color ?? '#6366f1' }}; margin-bottom: 2rem;">
                                            {{ $section->title }}
                                        </h2>
                                    @endif
                                    <div class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            {!! $section->content !!}
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target=".carousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target=".carousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                    @if($section->button_text && $section->button_link)
                                        <div style="margin-top: 1.5rem; text-align: center;">
                                            <a href="{{ $section->button_link }}" class="btn" style="background-color: {{ $section->button_color ?? '#6366f1' }}; color: {{ $section->button_text_color ?? '#ffffff' }}; border: none; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                                                {{ $section->button_text }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    This page has no content sections yet. Add sections from the CMS to populate this page.
                </div>
            @endif

            <!-- Page Meta Info -->
            <div class="page-meta mt-5 pt-4" style="border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 0.875rem;">
                <p>
                    Last updated: {{ $page->updated_at->format('F j, Y') }}
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .page-section {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .content-body {
        line-height: 1.8;
        color: #374151;
    }

    .content-body p {
        margin-bottom: 1.5rem;
    }

    .content-body h3 {
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #1f2937;
    }

    .content-body ul,
    .content-body ol {
        margin-bottom: 1.5rem;
        margin-left: 1.5rem;
    }

    .content-body li {
        margin-bottom: 0.5rem;
    }

    .hero-section {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .features-grid > * {
        background: white;
        padding: 1.5rem;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem !important;
        }

        .hero-section {
            padding: 2rem 1rem !important;
        }

        .hero-section h2 {
            font-size: 1.75rem !important;
        }
    }
</style>
@endsection