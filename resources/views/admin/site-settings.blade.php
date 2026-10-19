@extends('layouts.site-admin')

@section('title', 'Site Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Site Customization Settings</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('site-settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="site_title">Site Title</label>
                                    <input type="text" class="form-control" id="site_title" name="site_title" value="{{ old('site_title', $settings->site_title) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="site_description">Site Description</label>
                                    <textarea class="form-control" id="site_description" name="site_description" rows="2">{{ old('site_description', $settings->site_description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="primary_color">Primary Color</label>
                                    <input type="color" class="form-control" id="primary_color" name="primary_color" value="{{ old('primary_color', $settings->primary_color) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="secondary_color">Secondary Color</label>
                                    <input type="color" class="form-control" id="secondary_color" name="secondary_color" value="{{ old('secondary_color', $settings->secondary_color) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="font_color">Font Color</label>
                                    <input type="color" class="form-control" id="font_color" name="font_color" value="{{ old('font_color', $settings->font_color) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="font_family">Font Family</label>
                                    <select class="form-control" id="font_family" name="font_family" required>
                                        <option value="Arial, sans-serif" {{ $settings->font_family == 'Arial, sans-serif' ? 'selected' : '' }}>Arial</option>
                                        <option value="Helvetica, sans-serif" {{ $settings->font_family == 'Helvetica, sans-serif' ? 'selected' : '' }}>Helvetica</option>
                                        <option value="Times New Roman, serif" {{ $settings->font_family == 'Times New Roman, serif' ? 'selected' : '' }}>Times New Roman</option>
                                        <option value="Georgia, serif" {{ $settings->font_family == 'Georgia, serif' ? 'selected' : '' }}>Georgia</option>
                                        <option value="Verdana, sans-serif" {{ $settings->font_family == 'Verdana, sans-serif' ? 'selected' : '' }}>Verdana</option>
                                        <option value="Courier New, monospace" {{ $settings->font_family == 'Courier New, monospace' ? 'selected' : '' }}>Courier New</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="background_color">Background Color</label>
                                    <input type="color" class="form-control" id="background_color" name="background_color" value="{{ old('background_color', $settings->background_color) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="background_image">Background Image</label>
                            <input type="file" class="form-control" id="background_image" name="background_image" accept="image/*">
                            @if($settings->background_image)
                                <small class="form-text text-muted">Current image: {{ $settings->background_image }}</small>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="home_page_content">Home Page Content</label>
                            <textarea class="form-control" id="home_page_content" name="home_page_content" rows="4">{{ old('home_page_content', $settings->home_page_content) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="footer_text">Footer Text</label>
                            <input type="text" class="form-control" id="footer_text" name="footer_text" value="{{ old('footer_text', $settings->footer_text) }}">
                        </div>

                        <div class="form-group">
                            <label for="custom_css">Custom CSS</label>
                            <textarea class="form-control" id="custom_css" name="custom_css" rows="6" placeholder="Add custom CSS here...">{{ old('custom_css', $settings->custom_css) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection