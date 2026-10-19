@extends('layouts.admin')

@section('title', 'Report Settings')
@section('page-title', 'Report Settings')
@section('page-description', 'Customize your analytics reports and CMS content')

@section('content')
<div class="admin-row">
    <div class="admin-card" style="grid-column: span 12;">
        @if($settings == null)
        <div style="padding: 2rem; background: #fef3c7; border: 1px solid #fcd34d; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            <h4 style="color: #d97706; margin: 0 0 0.5rem 0;"><i class="fas fa-exclamation-triangle"></i> Database Migration Required</h4>
            <p style="color: #92400e; margin: 0;">The report settings table hasn't been created yet. Please run the database migrations first.</p>
        </div>
        @endif

        <div class="section-header">
            <h3>Report Page Settings</h3>
            <p>Customize the appearance and functionality of the analytics reports page</p>
        </div>

        <form action="{{ route('admin.report-settings.update') }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h4>Page Content</h4>
                
                <div class="form-group">
                    <label for="page_title">Page Title</label>
                    <input type="text" id="page_title" name="page_title" value="{{ $settings?->page_title ?? 'Reports & Analytics' }}" required class="form-control">
                    @error('page_title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="page_description">Page Description</label>
                    <textarea id="page_description" name="page_description" rows="3" class="form-control">{{ $settings?->page_description ?? '' }}</textarea>
                    @error('page_description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="banner_image_url">Banner Image URL</label>
                    <input type="url" id="banner_image_url" name="banner_image_url" value="{{ $settings?->banner_image_url ?? '' }}" placeholder="https://..." class="form-control">
                    @error('banner_image_url') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="banner_color">Banner Color</label>
                    <input type="color" id="banner_color" name="banner_color" value="{{ $settings?->banner_color ?? '#0ea5e9' }}" class="form-control" style="height: 50px; padding: 3px;">
                    @error('banner_color') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-section" style="margin-top: 2rem;">
                <h4>Display Options</h4>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="show_export_buttons" value="1" {{ $settings?->show_export_buttons ?? true ? 'checked' : '' }}>
                        Show Export Buttons (CSV, PDF, Print)
                    </label>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="show_filters" value="1" {{ $settings?->show_filters ?? true ? 'checked' : '' }}>
                        Show Filter Options
                    </label>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="show_charts" value="1" {{ $settings?->show_charts ?? true ? 'checked' : '' }}>
                        Show Charts
                    </label>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="show_tables" value="1" {{ $settings?->show_tables ?? true ? 'checked' : '' }}>
                        Show Data Tables
                    </label>
                </div>
            </div>

            <div class="form-section" style="margin-top: 2rem;">
                <h4>Auto-Refresh Settings</h4>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="auto_refresh" value="1" {{ $settings?->auto_refresh ?? true ? 'checked' : '' }}>
                        Enable Auto-Refresh
                    </label>
                </div>

                <div class="form-group">
                    <label for="refresh_interval">Refresh Interval (milliseconds)</label>
                    <input type="number" id="refresh_interval" name="refresh_interval" value="{{ $settings?->refresh_interval ?? 30000 }}" min="5000" max="300000" step="1000" class="form-control">
                    <small class="text-muted">Minimum: 5000ms (5 seconds), Maximum: 300000ms (5 minutes)</small>
                    @error('refresh_interval') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions" style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" {{ $settings == null ? 'disabled' : '' }}>
                    <i class="fas fa-save"></i> Save Settings
                </button>
                <a href="{{ route('admin.analytics') }}" class="btn btn-soft">
                    <i class="fas fa-arrow-left"></i> Back to Reports
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .admin-form {
        max-width: 800px;
    }

    .form-section {
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 1.5rem;
    }

    .form-section h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 500;
        color: #475569;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-group input[type="checkbox"] {
        margin-right: 0.5rem;
    }

    .form-group input[type="checkbox"] + label {
        display: inline;
        margin: 0;
    }

    .form-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #cbd5e1;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: #0ea5e9;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
    }

    .form-control:disabled {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .text-danger {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }

    .text-muted {
        color: #64748b;
        font-size: 0.875rem;
        display: block;
        margin-top: 0.25rem;
    }

    .form-actions {
        padding-top: 1.5rem;
    }

    button[disabled] {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>
@endsection

