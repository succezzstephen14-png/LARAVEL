# Admin Dashboard & Booking Workflow Implementation Guide

**Date:** April 30, 2026  
**Status:** ✅ Complete

---

## Overview

This implementation provides a fully functional admin dashboard with booking and payment workflows, approval system, and user management capabilities.

---

## Features Implemented

### ✅ Admin Features

#### 1. **Admin Authentication & Logout**
- Admin middleware check in `AdminController` constructor
- Role-based access control (users with role='admin' or email='admin@example.com')
- POST-based logout functionality
- Admin dashboard accessible at `/admin/dashboard`

#### 2. **User Management**
- View all users: `/admin/users` 
- Edit user details: `/admin/users/{user}`
- Update user information (name, email, phone, address, role)
- Paginated user list (15 per page)

#### 3. **Approval System**
The admin can approve or reject:
- **Drivers:** `/admin/pending-drivers` - Review driver profiles before listing
- **Vehicles:** `/admin/pending-vehicles` - Approve vehicle details
- **Recruitments:** `/admin/pending-recruitments` - Approve job postings
- **Bookings:** `/admin/pending-bookings` - Approve user reservations
- **Payments:** `/admin/pending-payments` - Review payment transactions

Each approval/rejection stores:
- Approval status (pending/approved/rejected)
- Approved timestamp
- Rejection reason (if rejected)

---

### ✅ Front-End Functionality

#### 1. **Book Now Button**
- Appears on all approved drivers (`drivers.show`)
- Appears on all approved vehicles (`vehicles.show`)
- Only visible to users who are NOT the owner
- Authenticated users can book
- Unauthenticated users directed to login

#### 2. **Apply Now Button**
- Appears on all approved recruitment listings (`recruitments.show`)
- Only visible to users who did NOT post the job
- No payment required for applications
- Applications saved and marked as pending admin approval

#### 3. **Booking Workflow**
1. User clicks "Book Now" on driver/vehicle
2. User fills booking form (date, time, location, description)
3. Booking record created with status='pending'
4. User redirected to payment page
5. Payment completed via Paystack
6. Booking approval status set to 'pending' for admin review
7. Admin reviews and approves/rejects booking
8. Approved bookings visible in user's "My Bookings"

---

### ✅ Payment Integration

#### **Payment Gateway:** Paystack

#### **Payment Flows:**
1. **Driver Registration Payment**
   - Amount: GHC 5,000
   - Route: `/drivers/payment/initiate`
   - On success: Driver created with status='pending' approval

2. **Vehicle Registration Payment**
   - Amount: GHC 3,000
   - Route: `/vehicles/payment/initiate`
   - On success: Vehicle created with status='pending' approval

3. **Recruitment Posting Payment**
   - Amount: GHC 2,000
   - Route: `/recruitments/payment/initiate`
   - On success: Recruitment created with status='pending' approval

4. **Booking Payment** (NEW)
   - Driver booking: GHC 50
   - Vehicle booking: GHC 100
   - Recruitment application: No payment required
   - Route: `/bookings/payment/initiate`
   - On success: Booking created and awaiting admin approval

#### **Payment Flow:**
1. Form submission → Payment record created
2. Paystack form displayed with transaction reference
3. User completes payment in Paystack modal
4. Success callback → `/payment/success?reference=XXX`
5. Server verifies payment with Paystack API
6. Upon verification: Resource created and stored

#### **Security Features:**
- Unique payment references (format: TYPE-RANDOMHEX)
- Duplicate payment prevention
- Amount verification with Paystack response
- Payment status tracking (pending/completed/failed/cancelled)

---

### ✅ Booking & Application Management

#### **Booking Model Fields:**
```
- id
- user_id (who made the booking)
- driver_id (nullable)
- vehicle_id (nullable)
- recruitment_id (nullable)
- booking_type (driver|vehicle|recruitment)
- status (pending|confirmed|in_progress|completed|cancelled)
- approval_status (pending|approved|rejected)
- booking_date (datetime)
- start_time (nullable)
- end_time (nullable)
- location (nullable)
- description (nullable)
- amount (decimal)
- payment_status (pending|paid|failed)
- payment_reference (unique)
- payment_date (nullable)
- rejection_reason (nullable)
- approved_at (nullable)
```

#### **Booking Creation Endpoints:**
- Driver booking: `POST /drivers/{driver}/book`
- Vehicle booking: `POST /vehicles/{vehicle}/book`
- Recruitment application: `POST /recruitments/{recruitment}/apply`

#### **Booking Visibility:**
- User can only see own bookings: `/bookings/my-bookings`
- User can view booking details: `/bookings/{booking}`
- Admin can view all bookings: `/admin/pending-bookings`

---

### ✅ System Behavior

#### **Visibility Rules (Front-End):**
```
NO resource appears on front-end UNLESS approval_status = 'approved'
```

- **Drivers list:** Only approved drivers show
- **Vehicles list:** Only approved vehicles show  
- **Recruitments list:** Only approved recruitments show
- **Booking page:** Only approved drivers/vehicles/recruitments available for booking

#### **Admin Approval Rules:**
- New drivers start with `approval_status='pending'`
- New vehicles start with `approval_status='pending'`
- New recruitments start with `approval_status='pending'`
- New bookings start with `approval_status='pending'`
- Admin can approve or reject with reason

#### **Payment Status Tracking:**
- Booking payment: pending → paid
- Driver/Vehicle/Recruitment: pending → completed
- Payment records linked to resources via `payment_reference`

---

## Key Files Modified/Created

### Controllers
- `app/Http/Controllers/AdminController.php` - Admin logic
- `app/Http/Controllers/BookingController.php` - Booking creation + payment initiation
- `app/Http/Controllers/PaymentController.php` - Payment handling (driver/vehicle/recruitment/booking)

### Models
- `app/Models/User.php` - Added `bookings()` relationship
- `app/Models/Booking.php` - Full booking model with relationships
- `app/Models/Payment.php` - Payment tracking

### Routes
- `routes/web.php` - Admin routes, booking routes, payment routes

### Views
- `resources/views/admin/dashboard.blade.php` - Admin dashboard
- `resources/views/admin/pending-bookings.blade.php` - Booking approval interface
- `resources/views/admin/pending-drivers.blade.php` - Driver approval
- `resources/views/admin/pending-vehicles.blade.php` - Vehicle approval
- `resources/views/admin/pending-recruitments.blade.php` - Recruitment approval
- `resources/views/admin/pending-payments.blade.php` - Payment approval
- `resources/views/admin/users.blade.php` - User management
- `resources/views/admin/users-edit.blade.php` - Edit user details
- `resources/views/bookings/index.blade.php` - Public booking page
- `resources/views/bookings/driver-book.blade.php` - Driver booking form
- `resources/views/bookings/vehicle-book.blade.php` - Vehicle booking form
- `resources/views/bookings/recruitment-book.blade.php` - Application form
- `resources/views/bookings/show.blade.php` - Booking details
- `resources/views/bookings/my-bookings.blade.php` - User's bookings
- `resources/views/payments/paystack-form.blade.php` - Payment page (updated)

### Database Migrations
- `database/migrations/2026_04_29_add_approval_system.php` - Bookings table + approval columns

---

## Testing Checklist

### ✅ Admin Access
- [x] Admin can log in with `admin@example.com` / `password`
- [x] Admin dashboard accessible at `/admin/dashboard`
- [x] Admin can log out
- [x] Non-admin users get 403 error on admin routes

### ✅ User Management
- [x] Admin can view all users at `/admin/users`
- [x] Admin can edit user details
- [x] Admin can change user role

### ✅ Approval Workflows
- [x] Drivers show in pending list until approved
- [x] Vehicles show in pending list until approved
- [x] Recruitments show in pending list until approved
- [x] Bookings show in pending list until approved
- [x] Admin can approve with success message
- [x] Admin can reject with reason

### ✅ Front-End Visibility
- [x] Only approved drivers show on public driver list
- [x] Only approved vehicles show on public vehicle list
- [x] Only approved recruitments show on public recruitment list
- [x] Unapproved resources NOT visible to regular users

### ✅ Booking Flow
- [x] "Book Now" button visible on driver/vehicle show pages
- [x] "Apply Now" button visible on recruitment show pages
- [x] Booking form validates input
- [x] Booking cannot be created by resource owner
- [x] Unauthenticated users redirected to login

### ✅ Payment Flow
- [x] Paystack form displays correctly
- [x] Payment reference generated uniquely
- [x] Payment can be verified with test card
- [x] Success page redirects properly
- [x] Cancelled payment handled gracefully
- [x] Duplicate payments prevented

### ✅ Database Integrity
- [x] Bookings stored with all required fields
- [x] Payment records linked via reference
- [x] Relationships working (user→bookings, booking→driver/vehicle/recruitment)

---

## Environment Setup

### Required ENV Variables
```
PAYSTACK_PUBLIC_KEY=pk_test_xxx
PAYSTACK_SECRET_KEY=sk_test_xxx
```

### Test Payment Card
- Number: `4111 1111 1111 1111`
- Expiry: Any future date
- CVC: Any 3 digits

---

## API Endpoints Summary

### Admin Routes (all require auth + admin role)
```
GET  /admin/dashboard          - Dashboard
POST /admin/logout             - Logout
GET  /admin/users              - List users
GET  /admin/users/{user}       - Edit user form
PUT  /admin/users/{user}       - Update user
GET  /admin/pending-drivers    - Pending drivers list
POST /admin/drivers/{id}/approve - Approve driver
POST /admin/drivers/{id}/reject  - Reject driver
GET  /admin/pending-vehicles   - Pending vehicles list
POST /admin/vehicles/{id}/approve - Approve vehicle
POST /admin/vehicles/{id}/reject  - Reject vehicle
GET  /admin/pending-recruitments - Pending recruitments list
POST /admin/recruitments/{id}/approve - Approve recruitment
POST /admin/recruitments/{id}/reject  - Reject recruitment
GET  /admin/pending-bookings   - Pending bookings list
POST /admin/bookings/{id}/approve - Approve booking
POST /admin/bookings/{id}/reject  - Reject booking
GET  /admin/pending-payments   - Pending payments list
POST /admin/payments/{id}/approve - Approve payment
POST /admin/payments/{id}/reject  - Reject payment
```

### Booking Routes (require auth)
```
GET  /bookings/my-bookings     - User's bookings
GET  /bookings/{booking}       - Booking details
GET  /drivers/{driver}/book    - Driver booking form
POST /drivers/{driver}/book    - Store driver booking
GET  /vehicles/{vehicle}/book  - Vehicle booking form
POST /vehicles/{vehicle}/book  - Store vehicle booking
GET  /recruitments/{id}/apply  - Application form
POST /recruitments/{id}/apply  - Store application
```

### Payment Routes (require auth)
```
POST /drivers/payment/initiate        - Driver registration payment
POST /vehicles/payment/initiate       - Vehicle registration payment
POST /recruitments/payment/initiate   - Recruitment posting payment
POST /bookings/payment/initiate       - Booking payment
GET  /payment/success                 - Payment success page
GET  /payment/cancelled               - Payment cancelled page
POST /payment/webhook                 - Paystack webhook
```

---

## Deployment Notes

1. **Database Migrations:** Run `php artisan migrate` to create bookings table
2. **Paystack Setup:**
   - Create account at https://paystack.com
   - Get test keys from dashboard
   - Add to `.env`
3. **Admin User:**
   - Existing: `admin@example.com` / `password` 
   - Or run: `php artisan tinker` → Create user with role='admin'
4. **Payment Webhook:** Configure Paystack webhook to point to `/payment/webhook`

---

## Security Considerations

✅ **Implemented:**
- Admin middleware prevents unauthorized access
- Payment verification with Paystack API
- Duplicate payment prevention
- Authorization checks on user data
- CSRF protection on forms
- Input validation on all endpoints

⚠️ **Review Before Production:**
- Use environment-based payment amounts
- Implement rate limiting on payment endpoints
- Add audit logging for admin actions
- Monitor for fraudulent booking patterns
- Enable payment webhook verification with Paystack signature

---

## Support & Troubleshooting

### Admin Can't Login
- Verify user exists with `email='admin@example.com'` and `role='admin'`
- Check `.env` for auth configuration

### Bookings Not Showing
- Verify payment status is 'completed' in database
- Check booking created with correct driver_id/vehicle_id/recruitment_id
- Confirm admin hasn't rejected booking

### Paystack Not Working
- Verify `.env` has correct PAYSTACK_PUBLIC_KEY and PAYSTACK_SECRET_KEY
- Check browser console for JavaScript errors
- Test with provided test card number

### User Can't Book Own Resource
- System prevents users from booking their own drivers/vehicles
- Ensure booking creation checks `Auth::id() !== owner_id`

---

## Future Enhancements

- Email notifications for approvals/rejections
- SMS notifications for users
- Booking status updates (confirmed → in_progress → completed)
- Payment refunds and cancellations
- Advanced search and filtering
- Analytics dashboard
- Driver/vehicle ratings and reviews
- Automated approval based on criteria
- Subscription plans for premium features

---

**Implementation Complete ✅**
