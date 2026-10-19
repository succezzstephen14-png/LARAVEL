@extends('layouts.site-admin')

@section('title', 'Website Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Website Settings</h3>
                    <div class="card-tools">
                        <button class="btn btn-warning btn-sm" onclick="resetSettings()">
                            <i class="fas fa-undo"></i> Reset to Defaults
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Settings Navigation -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                                @foreach($groups as $group)
                                <li class="nav-item">
                                    <a class="nav-link {{ $group == $currentGroup ? 'active' : '' }}"
                                       id="{{ $group }}-tab" data-bs-toggle="tab" href="#{{ $group }}" role="tab">
                                        {{ ucfirst(str_replace('_', ' ', $group)) }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Settings Content -->
                    <div class="tab-content" id="settingsTabContent">
                        @foreach($groups as $group)
                        <div class="tab-pane fade {{ $group == $currentGroup ? 'show active' : '' }}"
                             id="{{ $group }}" role="tabpanel">
                            <form id="settingsForm_{{ $group }}">
                                @csrf
                                <div class="row">
                                    @php
                                        $groupSettings = collect($settings)->where('group', $group);
                                    @endphp

                                    @forelse($groupSettings as $setting)
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="setting_{{ $setting->key }}">
                                                {{ $setting->label }}
                                                @if($setting->description)
                                                    <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" title="{{ $setting->description }}"></i>
                                                @endif
                                            </label>

                                            @switch($setting->type)
                                                @case('boolean')
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input setting-input"
                                                               id="setting_{{ $setting->key }}" name="{{ $setting->key }}"
                                                               value="1" {{ $setting->value == 'true' || $setting->value == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="setting_{{ $setting->key }}">
                                                            {{ $setting->value == 'true' || $setting->value == '1' ? 'Enabled' : 'Disabled' }}
                                                        </label>
                                                    </div>
                                                    @break

                                                @case('color')
                                                    <input type="color" class="form-control setting-input"
                                                           id="setting_{{ $setting->key }}" name="{{ $setting->key }}"
                                                           value="{{ $setting->value }}">
                                                    @break

                                                @case('json')
                                                    <textarea class="form-control setting-input" rows="3"
                                                              id="setting_{{ $setting->key }}" name="{{ $setting->key }}">{{ json_encode(json_decode($setting->value, true), JSON_PRETTY_PRINT) }}</textarea>
                                                    @break

                                                @case('file')
                                                    <div class="input-group">
                                                        <input type="text" class="form-control setting-input"
                                                               id="setting_{{ $setting->key }}" name="{{ $setting->key }}"
                                                               value="{{ $setting->value }}" readonly>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button" onclick="uploadFile('{{ $setting->key }}')">
                                                                <i class="fas fa-upload"></i> Upload
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @if($setting->value)
                                                        <small class="form-text text-muted">Current file: {{ basename($setting->value) }}</small>
                                                    @endif
                                                    @break

                                                @default
                                                    @if($setting->options)
                                                        <select class="form-control setting-input"
                                                                id="setting_{{ $setting->key }}" name="{{ $setting->key }}">
                                                            @foreach(json_decode($setting->options, true) as $optionValue => $optionLabel)
                                                            <option value="{{ $optionValue }}" {{ $setting->value == $optionValue ? 'selected' : '' }}>
                                                                {{ $optionLabel }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <input type="text" class="form-control setting-input"
                                                               id="setting_{{ $setting->key }}" name="{{ $setting->key }}"
                                                               value="{{ $setting->value }}">
                                                    @endif
                                            @endswitch
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            No settings found for this group.
                                        </div>
                                    </div>
                                    @endforelse
                                </div>

                                <div class="form-group mt-4">
                                    <button type="button" class="btn btn-primary" onclick="saveSettings('{{ $group }}')">
                                        <i class="fas fa-save"></i> Save {{ ucfirst(str_replace('_', ' ', $group)) }} Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- File Upload Modal -->
<div class="modal fade" id="fileUploadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="fileUploadForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fileInput">Select File</label>
                        <input type="file" class="form-control-file" id="fileInput" name="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentSettingKey = null;

$(document).ready(function() {
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
        new bootstrap.Tooltip(el);
    });

    // Auto-save on input change (debounced)
    let saveTimeout;
    $('.setting-input').on('input change', function() {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(() => {
            const input = $(this);
            const key = input.attr('name');
            const value = input.attr('type') === 'checkbox' ? (input.is(':checked') ? '1' : '0') : input.val();

            saveSetting(key, value);
        }, 1000);
    });
});

function saveSettings(group) {
    const formData = new FormData(document.getElementById('settingsForm_' + group));
    const settings = {};

    for (let [key, value] of formData.entries()) {
        if (key !== '_token') {
            settings[key] = value;
        }
    }

    $.ajax({
        url: '{{ route("cms.settings.bulk-update") }}',
        type: 'POST',
        data: {
            settings: Object.entries(settings).map(([key, value]) => ({ key, value })),
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            toastr.success('Settings saved successfully!');
        },
        error: function(xhr) {
            toastr.error('Failed to save settings: ' + (xhr.responseJSON?.message || 'Unknown error'));
        }
    });
}

function saveSetting(key, value) {
    $.ajax({
        url: '{{ route("cms.settings.update", ":key") }}'.replace(':key', key),
        type: 'PUT',
        data: {
            value: value,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            // Silent success - no notification for auto-save
        },
        error: function(xhr) {
            console.error('Failed to save setting:', key, xhr);
        }
    });
}

function uploadFile(settingKey) {
    currentSettingKey = settingKey;
    const modalElement = document.getElementById('fileUploadModal');
    const bootstrapModal = bootstrap.Modal.getOrCreateInstance(modalElement);
    bootstrapModal.show();
}

$('#fileUploadForm').on('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    $.ajax({
        url: '{{ route("cms.upload-media") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#setting_' + currentSettingKey).val(response.path || response.url);
            const fileUploadModalElement = document.getElementById('fileUploadModal');
            const fileUploadModal = bootstrap.Modal.getOrCreateInstance(fileUploadModalElement);
            fileUploadModal.hide();
            toastr.success('File uploaded successfully!');
        },
        error: function(xhr) {
            toastr.error('File upload failed: ' + (xhr.responseJSON?.message || 'Unknown error'));
        }
    });
});

function resetSettings() {
    if (confirm('Are you sure you want to reset all settings to defaults? This action cannot be undone.')) {
        $.ajax({
            url: '{{ route("cms.settings.reset", ":group") }}'.replace(':group', '{{ $currentGroup }}'),
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                toastr.error('Failed to reset settings: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    }
}
</script>
@endpush