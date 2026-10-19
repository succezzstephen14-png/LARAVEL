@extends('layouts.site-admin')

@section('title', 'Navigation Menu Manager')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
            <div>
                <h1 class="h3">Navigation Menu Manager</h1>
                <p class="text-muted">Create, reorder, and publish the main website navigation structure.</p>
            </div>
            <button id="addMenuItemBtn" class="btn btn-primary"> <i class="fas fa-plus me-2"></i> Add Menu Item</button>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Menu Items</h5>
                    <button id="saveMenuBtn" class="btn btn-success btn-sm">
                        <i class="fas fa-save me-1"></i> Save Menu
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light text-uppercase text-muted small">
                                <tr>
                                    <th>Order</th>
                                    <th>Label</th>
                                    <th>URL</th>
                                    <th>Icon</th>
                                    <th>Target</th>
                                    <th>Visible</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="menuItemsTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Menu Preview</h5>
                </div>
                <div class="card-body">
                    <div class="list-group" id="menuPreview"></div>
                    <div class="mt-3 text-muted small">
                        Use the menu builder to control what appears in the site header navigation.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Menu Item Modal -->
<div class="modal fade" id="menuItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="menuItemModalTitle">Add Menu Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="menuItemForm">
                    @csrf
                    <input type="hidden" id="menuItemIndex" value="-1">

                    <div class="mb-3">
                        <label for="menuItemLabel" class="form-label">Label</label>
                        <input type="text" id="menuItemLabel" class="form-control" placeholder="Home" required>
                    </div>

                    <div class="mb-3">
                        <label for="menuItemUrl" class="form-label">URL</label>
                        <input type="text" id="menuItemUrl" class="form-control" placeholder="/" required>
                    </div>

                    <div class="mb-3">
                        <label for="menuItemIcon" class="form-label">Icon (FontAwesome class)</label>
                        <input type="text" id="menuItemIcon" class="form-control" placeholder="fas fa-home">
                        <small class="form-text text-muted">Optional icon for menu links.</small>
                    </div>

                    <div class="mb-3">
                        <label for="menuItemTarget" class="form-label">Open in</label>
                        <select id="menuItemTarget" class="form-select">
                            <option value="_self">Same tab</option>
                            <option value="_blank">New tab</option>
                        </select>
                    </div>

                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="menuItemVisible" checked>
                        <label class="form-check-label" for="menuItemVisible">Visible in navigation</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer py-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveMenuItemBtn">Save Item</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const menuItems = @json($menuItems, JSON_HEX_TAG);
    const menuItemModalElement = document.getElementById('menuItemModal');
    const menuItemModal = new bootstrap.Modal(menuItemModalElement);

    function renderMenuItems() {
        const tbody = document.getElementById('menuItemsTableBody');
        const preview = document.getElementById('menuPreview');
        tbody.innerHTML = '';
        preview.innerHTML = '';

        if (!menuItems.length) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-4">No menu items defined yet.</td></tr>';
        }

        menuItems.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${item.label}</td>
                <td><code>${item.url}</code></td>
                <td>${item.icon || '<span class="text-muted">—</span>'}</td>
                <td>${item.target || '_self'}</td>
                <td><span class="badge ${item.visible ? 'bg-success' : 'bg-secondary'}">${item.visible ? 'Visible' : 'Hidden'}</span></td>
                <td class="text-end">
                    <button type="button" class="btn btn-sm btn-outline-primary me-1" onclick="editMenuItem(${index})"><i class="fas fa-pen"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="moveMenuItem(${index}, -1)"><i class="fas fa-arrow-up"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="moveMenuItem(${index}, 1)"><i class="fas fa-arrow-down"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeMenuItem(${index})"><i class="fas fa-trash"></i></button>
                </td>
            `;
            tbody.appendChild(row);

            const previewItem = document.createElement('div');
            previewItem.className = 'list-group-item d-flex justify-content-between align-items-center';
            previewItem.innerHTML = `
                <div>
                    <strong>${item.label}</strong><br>
                    <span class="text-muted">${item.url} • ${item.target}</span>
                </div>
                <span>${item.icon ? `<i class="${item.icon}"></i>` : ''}</span>
            `;
            preview.appendChild(previewItem);
        });
    }

    function openMenuItemModal(index = -1) {
        document.getElementById('menuItemIndex').value = index;

        if (index >= 0) {
            const item = menuItems[index];
            document.getElementById('menuItemLabel').value = item.label;
            document.getElementById('menuItemUrl').value = item.url;
            document.getElementById('menuItemIcon').value = item.icon || '';
            document.getElementById('menuItemTarget').value = item.target || '_self';
            document.getElementById('menuItemVisible').checked = item.visible !== false;
            document.getElementById('menuItemModalTitle').textContent = 'Edit Menu Item';
        } else {
            document.getElementById('menuItemForm').reset();
            document.getElementById('menuItemTarget').value = '_self';
            document.getElementById('menuItemVisible').checked = true;
            document.getElementById('menuItemModalTitle').textContent = 'Add Menu Item';
        }

        menuItemModal.show();
    }

    function editMenuItem(index) {
        openMenuItemModal(index);
    }

    function removeMenuItem(index) {
        if (!confirm('Remove this menu item?')) {
            return;
        }

        menuItems.splice(index, 1);
        renderMenuItems();
    }

    function moveMenuItem(index, direction) {
        const targetIndex = index + direction;
        if (targetIndex < 0 || targetIndex >= menuItems.length) {
            return;
        }

        const [item] = menuItems.splice(index, 1);
        menuItems.splice(targetIndex, 0, item);
        renderMenuItems();
    }

    function saveMenuItem() {
        const index = parseInt(document.getElementById('menuItemIndex').value, 10);
        const item = {
            label: document.getElementById('menuItemLabel').value.trim(),
            url: document.getElementById('menuItemUrl').value.trim(),
            icon: document.getElementById('menuItemIcon').value.trim(),
            target: document.getElementById('menuItemTarget').value,
            visible: document.getElementById('menuItemVisible').checked,
        };

        if (!item.label || !item.url) {
            toastr.error('Label and URL are required.');
            return;
        }

        if (index >= 0) {
            menuItems[index] = item;
        } else {
            menuItems.push(item);
        }

        renderMenuItems();
        menuItemModal.hide();
    }

    function saveMenu() {
        $.ajax({
            url: '{{ route('cms.menus.save') }}',
            method: 'POST',
            data: {
                menu_items: menuItems,
                _token: '{{ csrf_token() }}'
            },
            success(response) {
                toastr.success(response.message || 'Navigation menu saved.');
            },
            error(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Unable to save menu.');
            }
        });
    }

    document.getElementById('addMenuItemBtn').addEventListener('click', () => openMenuItemModal(-1));
    document.getElementById('saveMenuItemBtn').addEventListener('click', saveMenuItem);
    document.getElementById('saveMenuBtn').addEventListener('click', saveMenu);

    renderMenuItems();
</script>
@endpush