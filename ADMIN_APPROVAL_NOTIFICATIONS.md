# Admin Approval Notifications & Frontend Visibility Implementation

## Overview
This document summarizes the implementation of user dashboard notifications and enhanced admin approval visibility, ensuring that:
1. Users receive real-time notifications when their applications/bookings are approved or rejected
2. Approved drivers, vehicles, and recruitments immediately appear on frontend pages
3. Unread notifications are prominently displayed in the user dashboard

---

## Changes Made

### 1. Database: Notifications Table
**File**: `database/migrations/2026_05_02_125257_create_notifications_table.php`

Created a new notifications table with the following schema:
- `id` (primary key)
- `user_id` (foreign key to users table)
- `title` (notification title)
- `message` (full notification message)
- `type` (system type identifier)
- `status` (unread/read)
- `timestamps` (created_at, updated_at)

**Migration Status**: ✅ Applied

### 2. Models

#### Notification Model
**File**: `app/Models/Notification.php`

- Fillable fields: `user_id`, `title`, `message`, `type`, `status`
- Belongs to User model
- Provides persistent notification storage

#### User Model (Enhanced)
**File**: `app/Models/User.php`

Added relationship:
```php
public function alerts()
{
    return $this->hasMany(Notification::class)->latest();
}
```

#### Driver Model (Enhanced)
**File**: `app/Models/Driver.php`

Added query scope:
```php
public function scopeApproved($query)
{
    return $query->where('approval_status', 'approved');
}
```

#### Vehicle Model (Enhanced)
**File**: `app/Models/Vehicle.php`

Added query scope:
```php
public function scopeApproved($query)
{
    return $query->where('approval_status', 'approved');
}
```

Added status filtering to index to show only available vehicles:
```php
->where('status', 'available')
```

#### Recruitment Model (Enhanced)
**File**: `app/Models/Recruitment.php`

Added query scope:
```php
public function scopeApproved($query)
{
    return $query->where('approval_status', 'approved');
}
```

### 3. Controllers

#### AdminController (Enhanced)
**File**: `app/Http/Controllers/AdminController.php`

**Added Notification Helper**:
```php
private function notifyOwner($model, string $title, string $message): void
```
- Detects model type (Driver, Vehicle, Recruitment, Booking)
- Creates notification entry for the model owner
- Called after all approval/rejection actions

**Updated Approval Methods**:
- `approveDriver()` - sends "Driver profile approved" notification
- `rejectDriver()` - sends "Driver profile rejected" notification with reason
- `approveVehicle()` - sends "Vehicle approved" notification
- `rejectVehicle()` - sends "Vehicle rejected" notification with reason
- `approveRecruitment()` - sends "Recruitment approved" notification
- `rejectRecruitment()` - sends "Recruitment rejected" notification with reason
- `approveBooking()` - sends "Booking approved" notification
- `rejectBooking()` - sends "Booking rejected" notification with reason

**Updated AJAX Approval Methods**:
- `ajaxApprove()` - sends notifications for all types
- `ajaxReject()` - sends notifications for all types

#### AuthController (Enhanced)
**File**: `app/Http/Controllers/AuthController.php`

**Dashboard Method Enhancement**:
- Added notification retrieval: `$user->alerts()->take(6)->get()`
- Added unread count: `$user->alerts()->where('status', 'unread')->count()`
- Passes both to dashboard view

**New Notification Route Handler**:
```php
public function markNotificationRead(Request $request, Notification $notification)
```
- Allows users to mark notifications as read
- Validates ownership before marking

#### DriverController (Enhanced)
**File**: `app/Http/Controllers/DriverController.php`

**Frontend Query Changes**:
- `index()` - filters by `status='available'` AND `approval_status='approved'`
- `search()` - defaults to available unless different status is explicitly requested

#### VehicleController (Enhanced)
**File**: `app/Http/Controllers/VehicleController.php`

**Frontend Query Changes**:
- `index()` - filters by `status='available'` AND `approval_status='approved'`
- `search()` - defaults to available unless different status is explicitly requested

### 4. Routes
**File**: `routes/web.php`

Added new route for marking notifications as read:
```php
Route::post('/notifications/{notification}/read', [AuthController::class, 'markNotificationRead'])->name('notifications.read');
```

### 5. Views

#### Dashboard (Enhanced)
**File**: `resources/views/dashboard.blade.php`

**New Notifications Section** (placed after stats, before guidance):
- Displays user's 6 most recent notifications
- Shows unread count badge when available
- Each notification displays:
  - Title
  - Creation timestamp
  - Status badge (unread/read)
  - Full message text
  - "Mark as read" button for unread notifications
- Empty state message when no notifications exist

---

## Workflow

### When Admin Approves a Resource

1. Admin navigates to pending approvals page
2. Admin clicks approve button (legacy route or AJAX)
3. `AdminController` updates resource approval_status to "approved"
4. `AdminController.notifyOwner()` creates a Notification record:
   - Title: descriptive action (e.g., "Driver profile approved")
   - Message: user-friendly message about the approval
   - Status: "unread"
5. User logs in or refreshes dashboard
6. Dashboard controller loads latest 6 notifications + unread count
7. Notifications appear in dashboard with "Mark as read" button

### When Admin Rejects a Resource

1. Same flow as approval
2. Rejection reason is included in notification message
3. User sees detailed explanation of why application was rejected

### Frontend Visibility

1. When resource is approved with `approval_status='approved'`:
   - Driver listing queries: `where('status', 'available')` AND `where('approval_status', 'approved')`
   - Vehicle listing queries: `where('status', 'available')` AND `where('approval_status', 'approved')`
   - Recruitment listing queries: `where('status', 'open')` AND `where('approval_status', 'approved')`
2. Approved resources are immediately visible after approval
3. Unapproved (pending/rejected) resources remain hidden from public

---

## Database Query Reference

### Get unread notifications for a user
```php
$user->alerts()->where('status', 'unread')->get()
```

### Mark all notifications as read
```php
$user->alerts()->update(['status' => 'read'])
```

### Get approved and available drivers
```php
Driver::approved()->where('status', 'available')->get()
```

### Get approved and available vehicles
```php
Vehicle::approved()->where('status', 'available')->get()
```

### Get approved and open recruitments
```php
Recruitment::approved()->where('status', 'open')->get()
```

---

## Testing Checklist

- [ ] Create a driver profile and pay
- [ ] Navigate to admin → pending drivers
- [ ] Approve the driver
- [ ] Check user dashboard for approval notification
- [ ] Verify notification appears with correct title/message
- [ ] Click "Mark as read" button
- [ ] Verify notification status changes to read
- [ ] Navigate to /drivers page
- [ ] Verify approved driver appears in listing
- [ ] Repeat for vehicles and recruitments
- [ ] Test rejection flow with reason message
- [ ] Test AJAX approve/reject flows
- [ ] Verify unread count badge displays correctly
- [ ] Test empty notifications state message

---

## User Experience Improvements

✅ **Immediate Feedback**: Users see instant confirmation when approved  
✅ **Clear Messaging**: Each notification explains the action and any rejection reasons  
✅ **Persistent Storage**: Notifications are saved and visible across sessions  
✅ **Read/Unread Tracking**: Users can manage notification state  
✅ **Frontend Consistency**: Only approved resources show on public pages  
✅ **Central Hub**: All notifications in one dashboard section  

---

## Future Enhancements (Optional)

- Email notifications for approvals/rejections
- Notification filtering by type
- Batch mark-as-read functionality
- Notification deletion/archival
- Push notifications for mobile users
- Notification export/history
