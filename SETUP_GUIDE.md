# Vehicle & Driver Recruitment System - Setup Guide

## Project Structure Overview

This is a complete Laravel-based Vehicle & Driver Recruitment System with the following components:

### Database Schema
- **users**: Added `role` (admin/user), `phone`, and `address` columns
- **vehicles**: User-submitted vehicles with make, model, year, type, status
- **drivers**: Driver profiles with license info, rating, and availability
- **recruitments**: Job posting system for driver and vehicle owner positions

### Key Features

#### 1. Authentication & Authorization
- User and Admin role-based access
- Admin middleware checks in AdminController
- User authentication via Laravel's built-in system

#### 2. Vehicle Management
- Users can add, edit, delete vehicles
- Vehicle types: car, van, truck, motorcycle
- Status tracking: available, unavailable, maintenance
- Live search and filtering by type
- API endpoint for available vehicles

#### 3. Driver Management
- Driver profile creation with license information
- License class system (A-E)
- Rating system (0-5 stars)
- Trip counter
- Live search and filtering
- API endpoint for available drivers

#### 4. Recruitment System
- Create, edit, delete job postings
- Position types: driver, vehicle_owner, both
- Salary range tracking
- Status management: open, closed, filled
- Live search and filtering
- API endpoint for open positions

#### 5. Admin Dashboard
- Overall statistics and analytics
- User management with role assignment
- Vehicle moderation
- Driver profile moderation
- Recruitment post management
- Analytics data visualization

## Installation & Setup

### Prerequisites
- PHP 8.2+
- Composer
- Laravel 12
- SQLite (or MySQL)
- Node.js & npm (for frontend build)

### Step 1: Install Dependencies
```bash
composer install
npm install
```

### Step 2: Environment Configuration
The `.env` file has been pre-configured with:
- APP_KEY=base64:Z1QwbHBaVnhLVm1GeFZtRnhNSGxVVG14MmEzbHhWbU5uTWpObVpXdHo= (required for encryption)
- DB_CONNECTION=sqlite (uses database/database.sqlite)
- SESSION_DRIVER=database

### Step 3: Database Setup
Create the database file and run migrations:
```bash
# Create SQLite database file
touch database/database.sqlite

# Run migrations to create tables
php artisan migrate

# (Optional) Seed the database with sample data
php artisan db:seed
```

### Step 4: Build Frontend Assets
```bash
npm run build
# or for development with hot reload
npm run dev
```

### Step 5: Start the Application
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## File Structure

### Application Files Created

#### Models (app/Models/)
- **User.php**: Extended with relationships and `isAdmin()` method
- **Vehicle.php**: Relationships, scopes, and full naming
- **Driver.php**: License validation and rating system
- **Recruitment.php**: Job posting management

#### Controllers (app/Http/Controllers/)
- **VehicleController.php**: Full CRUD + search + API endpoints
- **DriverController.php**: Profile management + rating system
- **RecruitmentController.php**: Job posting management
- **AdminController.php**: Admin dashboard and moderation

#### Migrations (database/migrations/)
- **2026_04_27_000000_add_role_to_users_table.php**: Role system
- **2026_04_27_000001_create_vehicles_table.php**: Vehicle storage
- **2026_04_27_000002_create_drivers_table.php**: Driver profiles
- **2026_04_27_000003_create_recruitments_table.php**: Job postings

#### Routes
- **routes/web.php**: All web routes with auth middleware
- **routes/api.php**: API endpoints for live data

#### Views (resources/views/)
- **layouts/app.blade.php**: Base layout with Bootstrap 5
- **dashboard.blade.php**: User dashboard
- **admin/dashboard.blade.php**: Admin dashboard
- **vehicles/create.blade.php**: Vehicle creation form
- **drivers/create.blade.php**: Driver profile form
- **recruitments/create.blade.php**: Job posting form
- **welcome.blade.php**: Live frontend with auto-refresh data

## API Endpoints

### Live Data Endpoints (Auto-refresh every 30 seconds)
- `GET /api/vehicles/available` - Get available vehicles
- `GET /api/drivers/available` - Get available drivers  
- `GET /api/recruitments/open` - Get open positions

### Vehicle Routes
- `GET /vehicles` - List all vehicles
- `POST /vehicles` - Create new vehicle
- `GET /vehicles/{id}` - View vehicle
- `PUT /vehicles/{id}` - Update vehicle
- `DELETE /vehicles/{id}` - Delete vehicle
- `GET /vehicles/search?q=term` - Search vehicles

### Driver Routes
- `GET /drivers` - List all drivers
- `POST /drivers` - Create new driver profile
- `GET /drivers/{id}` - View driver profile
- `PUT /drivers/{id}` - Update driver profile
- `DELETE /drivers/{id}` - Delete driver profile
- `POST /drivers/{id}/rate` - Rate a driver
- `GET /drivers/search?q=term` - Search drivers

### Recruitment Routes
- `GET /recruitments` - List all job postings
- `POST /recruitments` - Create new job posting
- `GET /recruitments/{id}` - View job posting
- `PUT /recruitments/{id}` - Update job posting
- `DELETE /recruitments/{id}` - Delete job posting
- `GET /recruitments/search?q=term` - Search job postings

### Admin Routes (Requires admin role)
- `GET /admin/dashboard` - Admin dashboard
- `POST /admin/users/{id}/role` - Change user role
- `POST /admin/vehicles/{id}/moderate` - Moderate vehicle
- `POST /admin/drivers/{id}/moderate` - Moderate driver profile
- `POST /admin/recruitments/{id}/moderate` - Moderate job posting

## User Roles

### Regular User
- View dashboard
- Create, edit, delete own vehicles
- Create, edit, delete own driver profiles
- Post, edit, delete own job recruitments
- Search all vehicles, drivers, and jobs
- Rate other drivers

### Admin
- Access to admin dashboard
- View all users with role management
- Moderate vehicles, driver profiles, and recruitments
- View platform analytics
- All user permissions

## Frontend Features

### Welcome Page (Live Frontend)
- Auto-refreshing data every 30 seconds
- Vehicle count and recent listings
- Driver count and recent profiles
- Job opening count and recent posts
- Bootstrap 5 responsive cards
- Real-time statistics

### Dashboard
- User statistics
- Quick action buttons
- Links to all management areas

### Forms
- Vehicle creation/editing
- Driver profile setup
- Job posting creation
- Form validation on both client and server

## Database Relationships

```
User
├── hasMany Vehicles
├── hasMany Drivers
└── hasMany Recruitments

Vehicle
├── belongsTo User
└── hasMany Ratings (implied)

Driver
├── belongsTo User
└── hasMany Ratings (implied)

Recruitment
└── belongsTo User
```

## Security Features

- CSRF protection on all forms
- Authentication required for sensitive routes
- Admin middleware for admin-only routes
- Blade templating prevents XSS
- Password hashing with bcrypt
- Role-based authorization

## Troubleshooting

### Composer Dependency Issues
If you encounter composer errors, try:
```bash
composer install --no-dev  # Remove dev dependencies
composer install           # Reinstall all dependencies
```

### Database Issues
If migrations fail:
```bash
php artisan migrate:reset   # Reset all migrations
php artisan migrate         # Run migrations fresh
```

### Cache Issues
Clear application cache:
```bash
php artisan config:cache
php artisan cache:clear
php artisan view:clear
```

### Asset Issues
Rebuild frontend assets:
```bash
npm install
npm run build
```

## Next Steps

1. **User Registration**: Create accounts and test the system
2. **Add Vehicles**: Submit vehicles for listing
3. **Create Driver Profiles**: Set up driver information
4. **Post Recruitments**: Create job opportunities
5. **Admin Panel**: Access admin features and moderate content

## Support

For issues or questions, check the Laravel documentation at https://laravel.com/docs

#### 6. Frontend with Live Data
- Beautiful responsive design with Bootstrap 5
- JavaScript fetch API for live data loading
- Auto-refresh every 30 seconds
- Search and filter capabilities
- Card-based layout for vehicles, drivers, and recruitments

## Controllers Created

1. **VehicleController** - Full CRUD for vehicles + search
2. **DriverController** - Driver profile management + rating
3. **RecruitmentController** - Job posting management
4. **AdminController** - Admin dashboard and moderation

## Routes

### Public Routes
- `/vehicles` - View all available vehicles
- `/drivers` - View available drivers
- `/recruitments` - View open positions

### Authenticated Routes
- `/my-vehicles` - User's vehicle list
- `/vehicles/create` - Add new vehicle
- `/my-driver-profile` - Driver profile management
- `/driver/create` - Create driver profile
- `/my-recruitments` - User's recruitment posts
- `/recruitments/create` - Create new posting

### Admin Routes (Prefix: `/admin`)
- `/dashboard` - Admin dashboard
- `/users` - Manage users
- `/vehicles` - Moderate vehicles
- `/drivers` - Moderate drivers
- `/recruitments` - Moderate postings
- `/analytics` - View analytics

### API Routes
- `/api/vehicles/available` - Get available vehicles (JSON)
- `/api/drivers/available` - Get available drivers (JSON)
- `/api/recruitments/open` - Get open positions (JSON)

## Models & Relationships

### User Model
```
- hasMany('vehicles')
- hasOne('driver')
- hasMany('recruitments')
- isAdmin() method
```

### Vehicle Model
```
- belongsTo('user')
- available() scope
- getFullNameAttribute accessor
```

### Driver Model
```
- belongsTo('user')
- available() scope
- isLicenseExpired() method
- updateRating() method
```

### Recruitment Model
```
- belongsTo('user')
- open() scope
- getSalaryRangeAttribute accessor
```

## Installation & Setup

### Prerequisites
- PHP 8.2+
- Laravel 12
- MySQL/PostgreSQL
- Node.js (for frontend assets)

### Steps

1. **Install Composer Dependencies**
   ```bash
   composer install
   ```

2. **Create .env file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure Database**
   Update `.env` with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=vdr_system
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run Migrations**
   ```bash
   php artisan migrate
   ```

5. **Create Admin User (Optional)**
   ```bash
   php artisan tinker
   > User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => 'admin'])
   ```

6. **Install NPM Dependencies**
   ```bash
   npm install
   npm run build
   ```

7. **Start Development Server**
   ```bash
   php artisan serve
   ```

   Access at: `http://localhost:8000`

## Frontend Features

### Homepage (`/`)
- Hero section with call-to-action
- Live vehicles section with search/filter
- Available drivers section
- Open positions section
- Real-time data loading (refreshes every 30 seconds)
- Responsive design

### Search & Filter
- Vehicle search by make, type
- Driver search by availability, rating
- Recruitment search by keyword, type, location

### User Dashboard
- View their vehicles
- Add/edit/delete vehicles
- Manage driver profile
- Post recruitment jobs
- View recruitment posts

### Admin Panel
- Statistics overview
- User management with role assignment
- Vehicle moderation
- Driver profile review
- Recruitment post approval
- Analytics with charts

## API Responses (JSON)

### Vehicles Endpoint
```json
[
  {
    "id": 1,
    "user_id": 1,
    "make": "Toyota",
    "model": "Camry",
    "year": 2022,
    "license_plate": "ABC123",
    "vehicle_type": "car",
    "status": "available",
    "description": "Good condition",
    "user": {"id": 1, "name": "John Doe"}
  }
]
```

### Drivers Endpoint
```json
[
  {
    "id": 1,
    "user_id": 1,
    "license_number": "DL123456",
    "license_class": "B",
    "experience_years": "5 years",
    "status": "available",
    "rating": 4.5,
    "user": {"id": 1, "name": "Jane Doe"}
  }
]
```

### Recruitments Endpoint
```json
[
  {
    "id": 1,
    "user_id": 1,
    "title": "Experienced Driver Needed",
    "description": "Looking for experienced driver...",
    "position_type": "driver",
    "location": "New York",
    "status": "open",
    "salary_range_min": 2000,
    "salary_range_max": 3500,
    "user": {"id": 1, "name": "Company ABC"}
  }
]
```

## JavaScript Features

### Live Data Loading
- Fetch API calls to backend endpoints
- Auto-refresh on page load
- 30-second interval updates
- Loading spinner feedback
- Error handling

### Search Functions
```javascript
loadVehicles()      // Load all vehicles
loadDrivers()       // Load all drivers
loadRecruitments()  // Load all positions
```

### Rendering Functions
```javascript
renderVehicles(data, container)      // Display vehicles
renderDrivers(data, container)        // Display drivers
renderRecruitments(data, container)   // Display positions
```

## Security Features

- CSRF protection on all forms
- Authorization checks in controllers
- Mass assignment protection via `$fillable`
- Password hashing
- Role-based access control
- Database relationship constraints

## Next Steps

1. Update the welcome.blade.php with the live frontend code provided
2. Create additional blade views for vehicles, drivers, and recruitments pages
3. Run migrations to create database tables
4. Test all CRUD operations
5. Configure email for user notifications (optional)
6. Add file upload for vehicle images and driver photos
7. Implement real-time notifications with WebSockets (optional)

## Testing

Create test user accounts:
```
Regular User: user@example.com / password
Admin User: admin@example.com / password
```

Test each feature:
- User registration and login
- Add/edit/delete vehicles
- Create driver profile
- Post job opportunities
- Admin dashboard access
- User and content moderation
- Live search and filtering
- API endpoints

## Troubleshooting

### Composer Installation Stuck
```bash
COMPOSER_DISABLE_NETWORK=1 composer install --no-interaction
```

### Database Issues
```bash
php artisan migrate:fresh  # Reset all tables
php artisan migrate        # Re-run migrations
```

### Cache Issues
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## File Locations

- **Models**: `app/Models/`
- **Controllers**: `app/Http/Controllers/`
- **Migrations**: `database/migrations/`
- **Views**: `resources/views/`
- **Routes**: `routes/web.php` and `routes/api.php`
