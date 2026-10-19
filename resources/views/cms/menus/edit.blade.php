@extends('layouts.cms')

@section('title', 'Edit Menu - ' . $menu->name)

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Edit Menu: {{ $menu->name }}</h5>
                <a href="{{ route('cms.menus') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('cms.update-menu', $menu) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Menu Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $menu->name) }}" required readonly>
                        <small class="form-text text-muted">Menu identifier (cannot be changed)</small>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="items" class="form-label">Menu Items (JSON)</label>
                        <textarea id="items" name="items" class="form-control @error('items') is-invalid @enderror" 
                                  rows="12" required>{{ old('items', $menu->items ?? '[]') }}</textarea>
                        <small class="form-text text-muted">
                            Enter menu items as JSON. Example:
                            <br><code>[
                            <br>  {"label": "Home", "url": "/", "icon": "fas fa-home"},
                            <br>  {"label": "About", "url": "/about", "icon": "fas fa-info-circle"},
                            <br>  {"label": "Contact", "url": "/contact", "icon": "fas fa-envelope"}
                            <br>]</code>
                        </small>
                        @error('items')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info mb-3">
                        <strong>Menu Information:</strong>
                        <ul class="small mb-0 mt-2">
                            <li>Each menu item should have: label, url, and icon (optional)</li>
                            <li>Use Font Awesome class names for icons (e.g., fas fa-home)</li>
                            <li>Make sure your JSON syntax is valid</li>
                            <li>URLs can be relative (e.g., /about) or absolute (e.g., https://example.com)</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Menu
                        </button>
                        <a href="{{ route('cms.menus') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-eye"></i> Menu Preview
                </h6>
            </div>
            <div class="card-body">
                <div id="menu-preview" class="d-flex gap-2 flex-wrap">
                    <!-- Menu preview will appear here -->
                </div>
                <small class="text-muted d-block mt-2">Preview updates as you type valid JSON</small>
            </div>
        </div>
    </div>
</div>

<script>
// Update menu preview as user types
document.getElementById('items').addEventListener('input', function() {
    try {
        const items = JSON.parse(this.value);
        const preview = document.getElementById('menu-preview');
        preview.innerHTML = '';
        
        if (Array.isArray(items) && items.length > 0) {
            items.forEach(item => {
                const badge = document.createElement('div');
                badge.className = 'badge bg-primary p-2';
                badge.innerHTML = `
                    <i class="fas fa-${item.icon ? item.icon.split(' ')[1] : 'link'}"></i>
                    ${item.label}
                `;
                preview.appendChild(badge);
            });
        }
    } catch (e) {
        // Invalid JSON, ignore
    }
});

// Trigger on page load
document.getElementById('items').dispatchEvent(new Event('input'));
</script>
@endsection
