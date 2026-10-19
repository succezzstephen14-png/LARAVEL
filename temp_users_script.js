@section('scripts')
<script>
// ============================================================================
// USER MANAGEMENT INTERFACE JAVASCRIPT
// ============================================================================

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded fired - JavaScript is working');
    
    // Simple test function
    window.testFunction = function() {
        alert('JavaScript is working!');
    };
    
    // Attach event listeners to buttons
    attachButtonListeners();
});

function attachButtonListeners() {
    console.log('Attaching button listeners...');
    
    // Attach listeners to view details buttons
    document.querySelectorAll('.action-btn.view').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            console.log('View button clicked for user:', userId);
            if (userId) {
                alert('View user: ' + userId);
            }
        });
        btn.removeAttribute('onclick');
    });
    
    console.log('Button listeners attached successfully');
}

// ============================================================================
// CHECKBOX AND SELECTION MANAGEMENT
// ============================================================================

function attachCheckboxListeners() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('input[name="user_ids[]"]');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionsUI();
        });
    }
    
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActionsUI();
        });
    });
}

function updateBulkActionsUI() {
    const selectedCount = document.querySelectorAll('input[name="user_ids[]"]:checked').length;
    const bulkActionsDiv = document.getElementById('bulkActions');
    const selectedCountSpan = document.getElementById('selectedCount');
    
    if (selectedCount > 0) {
        bulkActionsDiv.style.display = 'block';
        selectedCountSpan.textContent = `${selectedCount} user${selectedCount !== 1 ? 's' : ''} selected`;
    } else {
        bulkActionsDiv.style.display = 'none';
        selectedCountSpan.textContent = '0 users selected';
    }
}

// ============================================================================
// INDIVIDUAL USER ACTIONS
// ============================================================================

function viewUserDetails(userId) {
    fetch(`/admin/users/${userId}/details`)
        .then(response => response.json())
        .then(data => {
            showDetailModal(data);
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load user details', 'error');
        });
}

function showDetailModal(user) {
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    `;
    
    const modalContent = document.createElement('div');
    modalContent.style.cssText = `
        background: white;
        border-radius: 12px;
        padding: 2rem;
        max-width: 600px;
        width: 90%;
        box-shadow: 0 20px 25px rgba(0,0,0,0.15);
    `;
    
    modalContent.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
            <h4 style="margin: 0; color: #1f2937; font-size: 1.25rem;">User Details</h4>
            <button onclick="this.closest('.modal-overlay').remove()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #64748b;">×</button>
        </div>
        
        <div style="display: grid; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; border-left: 4px solid #3b82f6;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Name</div>
                <div style="font-size: 1rem; font-weight: 600; color: #1f2937;">${user.name}</div>
            </div>
            
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; border-left: 4px solid #10b981;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Email</div>
                <div style="font-size: 1rem; font-weight: 600; color: #1f2937;">${user.email}</div>
            </div>
            
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; border-left: 4px solid #f59e0b;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Phone</div>
                <div style="font-size: 1rem; font-weight: 600; color: #1f2937;">${user.phone || 'Not provided'}</div>
            </div>
            
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; border-left: 4px solid #8b5cf6;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Role</div>
                <div style="font-size: 1rem; font-weight: 600; color: #1f2937;">
                    <span style="background: ${user.role === 'admin' ? '#fef08a' : '#d1fae5'}; color: ${user.role === 'admin' ? '#92400e' : '#065f46'}; padding: 0.25rem 0.75rem; border-radius: 20px;">
                        ${user.role.toUpperCase()}
                    </span>
                </div>
            </div>
            
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; border-left: 4px solid #06b6d4;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Status</div>
                <div style="font-size: 1rem; font-weight: 600; color: #1f2937;">
                    <span style="background: ${user.status === 'active' ? '#d1fae5' : '#fee2e2'}; color: ${user.status === 'active' ? '#065f46' : '#991b1b'}; padding: 0.25rem 0.75rem; border-radius: 20px;">
                        ${user.status ? user.status.toUpperCase() : 'UNKNOWN'}
                    </span>
                </div>
            </div>
            
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; border-left: 4px solid #ec4899;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Onboarding Status</div>
                <div style="font-size: 1rem; font-weight: 600; color: #1f2937;">
                    <span style="background: ${user.onboarding_completed ? '#d1fae5' : '#fef3c7'}; color: ${user.onboarding_completed ? '#065f46' : '#92400e'}; padding: 0.25rem 0.75rem; border-radius: 20px;">
                        ${user.onboarding_completed ? 'COMPLETED' : 'PENDING'}
                    </span>
                </div>
            </div>
            
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; border-left: 4px solid #14b8a6;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Member Since</div>
                <div style="font-size: 1rem; font-weight: 600; color: #1f2937;">${new Date(user.created_at).toLocaleDateString()}</div>
            </div>
        </div>
        
        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
            <button onclick="this.closest('.modal-overlay').remove()" style="background: #e5e7eb; color: #374151; border: none; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-weight: 600;">Close</button>
            <a href="/admin/users/${user.id}/edit" style="background: #3b82f6; color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block;">Edit User</a>
        </div>
    `;
    
    modal.appendChild(modalContent);
    document.body.appendChild(modal);
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
}

function toggleUserStatus(userId) {
    showConfirmDialog('Are you sure you want to toggle this user\'s status?', (confirmed) => {
        if (!confirmed) return;
        
        fetch(`/admin/users/${userId}/toggle-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('User status toggled successfully', 'success');
            location.reload();
        } else {
            showNotification(data.message || 'Failed to toggle user status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function sendNotification(userId) {
    const message = prompt('Please enter the notification message to send:');
    if (!message) return;
    
    fetch(`/admin/users/${userId}/notify`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Notification sent successfully', 'success');
        } else {
            showNotification(data.message || 'Failed to send notification', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function deleteUser(userId) {
    showConfirmDialog('Are you sure you want to delete this user? This action cannot be undone!', (confirmed) => {
        if (!confirmed) return;
        
        const form = document.getElementById(`deleteUserForm-${userId}`);
        if (form) {
            form.submit();
        } else {
            // Fallback if form doesn't exist
            fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (response.ok) {
                showNotification('User deleted successfully', 'success');
                location.reload();
            } else {
                showNotification('Failed to delete user', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    }
}

// ============================================================================
// BULK ACTIONS
// ============================================================================

function getSelectedUserIds() {
    return Array.from(document.querySelectorAll('input[name="user_ids[]"]:checked')).map(cb => cb.value);
}

function bulkChangeRole(role) {
    const selectedIds = getSelectedUserIds();
    if (selectedIds.length === 0) {
        showNotification('Please select at least one user', 'warning');
        return;
    }
    
    showConfirmDialog(`Are you sure you want to change the role of ${selectedIds.length} user(s) to '${role}'?`, (confirmed) => {
        if (!confirmed) return;
        
        fetch('/admin/users/bulk-role', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_ids: selectedIds, role: role })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`Role changed for ${selectedIds.length} user(s)`, 'success');
            location.reload();
        } else {
            showNotification(data.message || 'Failed to change roles', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function bulkToggleStatus() {
    const selectedIds = getSelectedUserIds();
    if (selectedIds.length === 0) {
        showNotification('Please select at least one user', 'warning');
        return;
    }
    
    showConfirmDialog(`Are you sure you want to toggle the status of ${selectedIds.length} user(s)?`, (confirmed) => {
        if (!confirmed) return;
    
    fetch('/admin/users/bulk-toggle-status', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_ids: selectedIds })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`Status toggled for ${selectedIds.length} user(s)`, 'success');
            location.reload();
        } else {
            showNotification(data.message || 'Failed to toggle statuses', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function bulkSendNotification() {
    const selectedIds = getSelectedUserIds();
    if (selectedIds.length === 0) {
        showNotification('Please select at least one user', 'warning');
        return;
    }
    
    const message = prompt('Please enter the notification message to send:');
    if (!message) return;
    
    fetch('/admin/users/bulk-notify', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_ids: selectedIds, message: message })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`Notification sent to ${selectedIds.length} user(s)`, 'success');
        } else {
            showNotification(data.message || 'Failed to send notifications', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function bulkExport() {
    const selectedIds = getSelectedUserIds();
    if (selectedIds.length === 0) {
        showNotification('Please select at least one user', 'warning');
        return;
    }
    
    const format = prompt('Please choose an export format (enter 1, 2, or 3):\n1. CSV\n2. JSON\n3. Excel', '1');
    if (!format) return;
    
    const formatMap = { '1': 'csv', '2': 'json', '3': 'excel' };
    const exportFormat = formatMap[format];
    
    if (!exportFormat) {
        showNotification('Invalid format selected', 'error');
        return;
    }
    
    window.location.href = `/admin/users/bulk-export?user_ids=${selectedIds.join(',')}&format=${exportFormat}`;
}

function bulkDelete() {
    const selectedIds = getSelectedUserIds();
    if (selectedIds.length === 0) {
        showNotification('Please select at least one user', 'warning');
        return;
    }
    
    showConfirmDialog(`Are you sure you want to DELETE ${selectedIds.length} user(s)? This action CANNOT be undone!`, (confirmed) => {
        if (!confirmed) return;
        
        showConfirmDialog('This is your FINAL confirmation. Are you absolutely sure?', (finalConfirmed) => {
            if (!finalConfirmed) return;
            
            fetch('/admin/users/bulk-delete', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_ids: selectedIds })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`${selectedIds.length} user(s) deleted successfully`, 'success');
            location.reload();
        } else {
            showNotification(data.message || 'Failed to delete users', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

// ============================================================================
// FILTERING AND SEARCHING
// ============================================================================

function setupFilterListeners() {
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    
    if (roleFilter) {
        roleFilter.addEventListener('change', applyFilters);
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', applyFilters);
    }
}

function setupSearchListener() {
    const searchInput = document.getElementById('userSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', debounce(applyFilters, 500));
    }
}

function applyFilters() {
    const searchValue = document.getElementById('userSearch')?.value || '';
    const role = document.getElementById('roleFilter')?.value || '';
    const status = document.getElementById('statusFilter')?.value || '';
    
    const params = new URLSearchParams();
    if (searchValue) params.append('search', searchValue);
    if (role) params.append('role', role);
    if (status) params.append('status', status);
    
    window.location.href = `/admin/users?${params.toString()}`;
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ============================================================================
// CUSTOM CONFIRMATION MODAL
// ============================================================================

function showConfirmDialog(message, callback, title = 'Confirm Action') {
    // Remove any existing modal
    const existingModal = document.getElementById('customConfirmModal');
    if (existingModal) existingModal.remove();

    const modal = document.createElement('div');
    modal.id = 'customConfirmModal';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3000;
        animation: fadeIn 0.2s ease-out;
    `;

    modal.innerHTML = `
        <div style="
            background: white;
            border-radius: 16px;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease-out;
            border: 1px solid rgba(0, 0, 0, 0.1);
        ">
            <div style="
                display: flex;
                align-items: center;
                margin-bottom: 1.5rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #e5e7eb;
            ">
                <div style="
                    width: 48px;
                    height: 48px;
                    border-radius: 12px;
                    background: linear-gradient(135deg, #fbbf24, #f59e0b);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-right: 1rem;
                    color: white;
                    font-size: 1.2rem;
                ">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 style="
                    margin: 0;
                    color: #1f2937;
                    font-size: 1.25rem;
                    font-weight: 700;
                ">${title}</h3>
            </div>
            <p style="
                margin: 0 0 2rem 0;
                color: #6b7280;
                line-height: 1.6;
                font-size: 1rem;
            ">${message}</p>
            <div style="
                display: flex;
                gap: 1rem;
                justify-content: flex-end;
            ">
                <button id="confirmCancel" style="
                    padding: 0.75rem 1.5rem;
                    border: 2px solid #d1d5db;
                    background: white;
                    color: #6b7280;
                    border-radius: 8px;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.2s ease;
                ">Cancel</button>
                <button id="confirmOk" style="
                    padding: 0.75rem 1.5rem;
                    border: none;
                    background: linear-gradient(135deg, #ef4444, #dc2626);
                    color: white;
                    border-radius: 8px;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.2s ease;
                    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
                ">Confirm</button>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    // Add event listeners
    document.getElementById('confirmCancel').onclick = () => {
        modal.style.animation = 'fadeOut 0.2s ease-out';
        setTimeout(() => {
            modal.remove();
            if (callback) callback(false);
        }, 200);
    };

    document.getElementById('confirmOk').onclick = () => {
        modal.style.animation = 'fadeOut 0.2s ease-out';
        setTimeout(() => {
            modal.remove();
            if (callback) callback(true);
        }, 200);
    };

    // Close on background click
    modal.onclick = (e) => {
        if (e.target === modal) {
            modal.style.animation = 'fadeOut 0.2s ease-out';
            setTimeout(() => {
                modal.remove();
                if (callback) callback(false);
            }, 200);
        }
    };

    // Close on Escape key
    document.addEventListener('keydown', function escHandler(e) {
        if (e.key === 'Escape') {
            modal.style.animation = 'fadeOut 0.2s ease-out';
            setTimeout(() => {
                modal.remove();
                if (callback) callback(false);
            }, 200);
            document.removeEventListener('keydown', escHandler);
        }
    });
}

// ============================================================================
// NOTIFICATIONS
// ============================================================================

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        z-index: 9999;
        animation: slideIn 0.3s ease-in-out;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    `;
    
    const colors = {
        success: { bg: '#d1fae5', text: '#065f46', border: '#6ee7b7' },
        error: { bg: '#fee2e2', text: '#991b1b', border: '#fca5a5' },
        info: { bg: '#dbeafe', text: '#1d4ed8', border: '#93c5fd' },
        warning: { bg: '#fef3c7', text: '#92400e', border: '#fcd34d' }
    };
    
    const color = colors[type] || colors.info;
    notification.style.background = color.bg;
    notification.style.color = color.text;
    notification.style.border = `2px solid ${color.border}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-in-out';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
    
    @keyframes slideUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    #customConfirmModal button:hover {
        transform: translateY(-1px);
    }
    
    #customConfirmModal #confirmCancel:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }
    
    #customConfirmModal #confirmOk:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
    }
`;
document.head.appendChild(style);
</script>
@endsection
