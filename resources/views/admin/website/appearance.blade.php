@extends('layouts.site-admin')

@section('title', 'Appearance Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Website Appearance</h3>
                    <div class="card-tools">
                        <a href="{{ route('cms.settings') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Settings
                        </a>
                    </div>
                </div>
                <form action="{{ route('cms.appearance.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Branding Section -->
                            <div class="col-md-6">
                                <h5>Branding</h5>

                                <!-- Logo -->
                                <div class="form-group">
                                    <label for="logo">Website Logo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('logo') is-invalid @enderror"
                                               id="logo" name="logo" accept="image/*">
                                        <label class="custom-file-label" for="logo">Choose logo file...</label>
                                    </div>
                                    <small class="form-text text-muted">Recommended: PNG or SVG, max 2MB</small>
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if($logo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $logo) }}" alt="Current Logo" class="img-thumbnail" style="max-height: 100px;">
                                        <p class="text-muted mt-1">Current logo</p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Favicon -->
                                <div class="form-group">
                                    <label for="favicon">Favicon</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('favicon') is-invalid @enderror"
                                               id="favicon" name="favicon" accept="image/*">
                                        <label class="custom-file-label" for="favicon">Choose favicon file...</label>
                                    </div>
                                    <small class="form-text text-muted">Recommended: ICO, PNG, max 512KB</small>
                                    @error('favicon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if($favicon)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $favicon) }}" alt="Current Favicon" class="img-thumbnail" style="max-height: 50px;">
                                        <p class="text-muted mt-1">Current favicon</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Colors Section -->
                            <div class="col-md-6">
                                <h5>Color Scheme</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="primary_color">Primary Color</label>
                                            <input type="color" class="form-control @error('primary_color') is-invalid @enderror"
                                                   id="primary_color" name="primary_color" value="{{ $primaryColor }}">
                                            @error('primary_color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="secondary_color">Secondary Color</label>
                                            <input type="color" class="form-control @error('secondary_color') is-invalid @enderror"
                                                   id="secondary_color" name="secondary_color" value="{{ $secondaryColor }}">
                                            @error('secondary_color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="accent_color">Accent Color</label>
                                    <input type="color" class="form-control @error('accent_color') is-invalid @enderror"
                                           id="accent_color" name="accent_color" value="{{ old('accent_color', '#28a745') }}">
                                    @error('accent_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Typography Section -->
                        <div class="row">
                            <div class="col-12">
                                <h5>Typography</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="primary_font">Primary Font Family</label>
                                    <select class="form-control @error('primary_font') is-invalid @enderror" id="primary_font" name="primary_font">
                                        <option value="Inter, sans-serif" {{ old('primary_font', 'Inter, sans-serif') == 'Inter, sans-serif' ? 'selected' : '' }}>Inter</option>
                                        <option value="Roboto, sans-serif" {{ old('primary_font') == 'Roboto, sans-serif' ? 'selected' : '' }}>Roboto</option>
                                        <option value="Open Sans, sans-serif" {{ old('primary_font') == 'Open Sans, sans-serif' ? 'selected' : '' }}>Open Sans</option>
                                        <option value="Lato, sans-serif" {{ old('primary_font') == 'Lato, sans-serif' ? 'selected' : '' }}>Lato</option>
                                        <option value="Poppins, sans-serif" {{ old('primary_font') == 'Poppins, sans-serif' ? 'selected' : '' }}>Poppins</option>
                                        <option value="Nunito, sans-serif" {{ old('primary_font') == 'Nunito, sans-serif' ? 'selected' : '' }}>Nunito</option>
                                    </select>
                                    <small class="form-text text-muted">Font for headings and primary text</small>
                                    @error('primary_font')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="secondary_font">Secondary Font Family</label>
                                    <select class="form-control @error('secondary_font') is-invalid @enderror" id="secondary_font" name="secondary_font">
                                        <option value="Poppins, sans-serif" {{ old('secondary_font', 'Poppins, sans-serif') == 'Poppins, sans-serif' ? 'selected' : '' }}>Poppins</option>
                                        <option value="Inter, sans-serif" {{ old('secondary_font') == 'Inter, sans-serif' ? 'selected' : '' }}>Inter</option>
                                        <option value="Roboto, sans-serif" {{ old('secondary_font') == 'Roboto, sans-serif' ? 'selected' : '' }}>Roboto</option>
                                        <option value="Playfair Display, serif" {{ old('secondary_font') == 'Playfair Display, serif' ? 'selected' : '' }}>Playfair Display</option>
                                        <option value="Merriweather, serif" {{ old('secondary_font') == 'Merriweather, serif' ? 'selected' : '' }}>Merriweather</option>
                                    </select>
                                    <small class="form-text text-muted">Font for special elements and accents</small>
                                    @error('secondary_font')
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
                                <div class="border p-3 rounded" id="appearancePreview">
                                    <div class="d-flex align-items-center mb-3">
                                        @if($logo)
                                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo" style="height: 40px; margin-right: 15px;">
                                        @else
                                            <div style="width: 40px; height: 40px; background: {{ $primaryColor }}; margin-right: 15px; border-radius: 4px;"></div>
                                        @endif
                                        <h4 style="color: {{ $primaryColor }}; font-family: {{ old('primary_font', 'Inter, sans-serif') }}; margin: 0;">
                                            SUCCEZZ Drivers Agency
                                        </h4>
                                    </div>

                                    <p style="font-family: {{ old('primary_font', 'Inter, sans-serif') }};">
                                        This is how your website will look with the current color scheme and typography settings.
                                    </p>

                                    <button class="btn btn-primary mr-2" style="background-color: {{ $primaryColor }}; border-color: {{ $primaryColor }};">
                                        Primary Button
                                    </button>
                                    <button class="btn btn-secondary" style="background-color: {{ $secondaryColor }}; border-color: {{ $secondaryColor }};">
                                        Secondary Button
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Appearance Settings
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
    // Update file input labels
    $('.custom-file-input').on('change', function() {
        const fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Choose file...');
    });

    // Live preview updates
    $('#primary_color, #secondary_color, #primary_font, #secondary_font').on('change', function() {
        updatePreview();
    });

    function updatePreview() {
        const primaryColor = $('#primary_color').val();
        const secondaryColor = $('#secondary_color').val();
        const primaryFont = $('#primary_font').val();

        $('#appearancePreview h4').css('color', primaryColor);
        $('#appearancePreview h4').css('font-family', primaryFont);
        $('#appearancePreview p').css('font-family', primaryFont);
        $('#appearancePreview .btn-primary').css('background-color', primaryColor);
        $('#appearancePreview .btn-primary').css('border-color', primaryColor);
        $('#appearancePreview .btn-secondary').css('background-color', secondaryColor);
        $('#appearancePreview .btn-secondary').css('border-color', secondaryColor);
    }
});
</script>
@endpush