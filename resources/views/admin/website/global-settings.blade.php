@extends('layouts.site-admin')

@section('title', 'Global Website Settings')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
            <div>
                <h1 class="h3">Global Website Settings</h1>
                <p class="text-muted">Review and manage all configuration groups from a single global panel.</p>
            </div>
            <button id="saveGlobalSettingsBtn" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Save All Changes
            </button>
        </div>
    </div>

    <div class="row">
        @foreach($settings as $groupName => $groupSettings)
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-0 text-capitalize">{{ str_replace('_', ' ', $groupName) }}</h5>
                        <small class="text-muted">{{ count($groupSettings) }} settings</small>
                    </div>
                    <button class="btn btn-outline-danger btn-sm" onclick="resetGroup('{{ $groupName }}')">
                        <i class="fas fa-undo me-1"></i> Reset Group
                    </button>
                </div>
                <div class="card-body">
                    <form class="global-settings-group" data-group="{{ $groupName }}">
                        @foreach($groupSettings as $setting)
                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="setting_{{ $setting['key'] }}">
                                {{ $setting['label'] ?? str_replace('_', ' ', ucfirst($setting['key'])) }}
                            </label>
                            @if($setting['description'])
                            <p class="text-muted small mb-2">{{ $setting['description'] }}</p>
                            @endif

                            @switch($setting['type'])
                                @case('boolean')
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="setting_{{ $setting['key'] }}" name="{{ $setting['key'] }}" value="1" {{ $setting['value'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="setting_{{ $setting['key'] }}">
                                            {{ $setting['label'] ?? 'Enable feature' }}
                                        </label>
                                    </div>
                                    @break

                                @case('color')
                                    <input type="color" class="form-control form-control-color" id="setting_{{ $setting['key'] }}" name="{{ $setting['key'] }}" value="{{ $setting['value'] ?? '#000000' }}" title="Choose color">
                                    @break

                                @case('json')
                                    <textarea class="form-control" id="setting_{{ $setting['key'] }}" name="{{ $setting['key'] }}" rows="4">{{ json_encode(json_decode($setting['value'], true), JSON_PRETTY_PRINT) }}</textarea>
                                    @break

                                @case('file')
                                    <div class="input-group">
                                        <input type="text" readonly class="form-control" id="setting_{{ $setting['key'] }}" name="{{ $setting['key'] }}" value="{{ $setting['value'] }}">
                                        <button type="button" class="btn btn-outline-secondary" disabled>Upload</button>
                                    </div>
                                    @if($setting['value'])
                                    <div class="mt-2 text-muted small">Current: {{ basename($setting['value']) }}</div>
                                    @endif
                                    @break

                                @default
                                    @if($setting['options'])
                                        <select class="form-select" id="setting_{{ $setting['key'] }}" name="{{ $setting['key'] }}">
                                            @foreach($setting['options'] as $optionValue => $optionLabel)
                                            <option value="{{ $optionValue }}" {{ $setting['value'] == $optionValue ? 'selected' : '' }}>{{ $optionLabel }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" class="form-control" id="setting_{{ $setting['key'] }}" name="{{ $setting['key'] }}" value="{{ $setting['value'] }}">
                                    @endif
                            @endswitch
                        </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    function collectGlobalSettings() {
        const forms = document.querySelectorAll('.global-settings-group');
        const settings = [];

        forms.forEach(form => {
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                const key = input.name;
                if (!key) return;

                let value;

                if (input.type === 'checkbox') {
                    value = input.checked ? '1' : '0';
                } else {
                    value = input.value;
                }

                settings.push({ key, value });
            });
        });

        return settings;
    }

    function saveGlobalSettings() {
        const settings = collectGlobalSettings();

        $.ajax({
            url: '{{ route('cms.settings.bulk-update') }}',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                settings,
                _token: '{{ csrf_token() }}'
            }),
            success(response) {
                toastr.success(response.message || 'Global settings updated successfully.');
            },
            error(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Failed to update settings.');
            }
        });
    }

    function resetGroup(group) {
        if (!confirm('Reset all settings in "' + group + '" to default values?')) {
            return;
        }

        $.ajax({
            url: '{{ route('cms.settings.reset', ['group' => 'GROUP_KEY']) }}'.replace('GROUP_KEY', group),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success(response) {
                toastr.success(response.message || 'Group reset successfully.');
                window.location.reload();
            },
            error(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Unable to reset group.');
            }
        });
    }

    document.getElementById('saveGlobalSettingsBtn').addEventListener('click', saveGlobalSettings);
</script>
@endpush