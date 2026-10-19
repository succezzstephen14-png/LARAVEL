@extends('layouts.site-admin')

@section('title', 'Header & Footer Customization')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Header & Footer Customization</h3>
                    <div class="card-tools">
                        <a href="{{ route('cms.settings') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Settings
                        </a>
                    </div>
                </div>
                <form action="{{ route('cms.header-footer.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Header Section -->
                            <div class="col-md-6">
                                <h5>Header Settings</h5>

                                <div class="form-group">
                                    <label for="header_title">Header Title</label>
                                    <input type="text" class="form-control @error('header_title') is-invalid @enderror"
                                           id="header_title" name="header_title" value="{{ old('header_title', $headerTitle) }}">
                                    <small class="form-text text-muted">Title displayed in the website header</small>
                                    @error('header_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="header_code">Header Custom Code</label>
                                    <textarea class="form-control @error('header_code') is-invalid @enderror"
                                              id="header_code" name="header_code" rows="6">{{ old('header_code', $headerCode) }}</textarea>
                                    <small class="form-text text-muted">Custom HTML/CSS/JS code to add to the header (analytics, custom styles, etc.)</small>
                                    @error('header_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Footer Section -->
                            <div class="col-md-6">
                                <h5>Footer Settings</h5>

                                <div class="form-group">
                                    <label for="footer_text">Footer Copyright Text</label>
                                    <input type="text" class="form-control @error('footer_text') is-invalid @enderror"
                                           id="footer_text" name="footer_text" value="{{ old('footer_text', $footerText) }}">
                                    <small class="form-text text-muted">Copyright text displayed in footer</small>
                                    @error('footer_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="footer_code">Footer Custom Code</label>
                                    <textarea class="form-control @error('footer_code') is-invalid @enderror"
                                              id="footer_code" name="footer_code" rows="6">{{ old('footer_code', $footerCode) }}</textarea>
                                    <small class="form-text text-muted">Custom HTML/CSS/JS code to add to the footer</small>
                                    @error('footer_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5>Preview</h5>
                                <div class="border rounded">
                                    <!-- Header Preview -->
                                    <div class="bg-light p-3 border-bottom">
                                        <h6 class="mb-2">Header Preview:</h6>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white px-3 py-2 rounded mr-3" style="font-size: 14px;">
                                                LOGO
                                            </div>
                                            <h5 class="mb-0" id="headerTitlePreview">{{ old('header_title', $headerTitle ?: 'Your Website Title') }}</h5>
                                        </div>
                                        @if(old('header_code', $headerCode))
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <small class="text-muted">Custom header code will be inserted here</small>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Content Preview -->
                                    <div class="p-4 text-center">
                                        <h4>Your Website Content</h4>
                                        <p>This is where your main website content will appear.</p>
                                    </div>

                                    <!-- Footer Preview -->
                                    <div class="bg-light p-3 border-top">
                                        <h6 class="mb-2">Footer Preview:</h6>
                                        <div class="text-center">
                                            <p class="mb-1" id="footerTextPreview">{{ old('footer_text', $footerText ?: '© 2026 Your Company. All rights reserved.') }}</p>
                                            @if(old('footer_code', $footerCode))
                                            <div class="mt-2 p-2 bg-white border rounded">
                                                <small class="text-muted">Custom footer code will be inserted here</small>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Header & Footer Settings
                        </button>
                        <a href="{{ route('cms.settings') }}" class="btn btn-secondary ml-2">
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
    // Live preview updates
    $('#header_title, #footer_text').on('input', function() {
        updatePreview();
    });

    function updatePreview() {
        $('#headerTitlePreview').text($('#header_title').val() || 'Your Website Title');
        $('#footerTextPreview').text($('#footer_text').val() || '© 2026 Your Company. All rights reserved.');
    }
});
</script>
@endpush