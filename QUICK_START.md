# Vehicle & Driver Recruitment System - Quick Start Guide

## Pre-Flight Checklist

✅ All models created (User, Vehicle, Driver, Recruitment)
✅ All controllers implemented (Vehicle, Driver, Recruitment, Admin)
✅ All migrations prepared (7 total)
✅ Routes configured (web.php and api.php)
✅ Blade templates created (9 files)
✅ Frontend with auto-refresh implemented
✅ Admin dashboard built
✅ Role-based authorization setup

## Starting the Application

### Step 1: Install Dependencies
```bash
cd "c:\Users\succe\OneDrive\Desktop\NEW SITE\LARAVEL"
composer install
npm install
```

### Step 2: Create Database
```bash
# Create SQLite database file
php artisan tinker
>>> touch(database_path('database.sqlite'))
>>> exit
```

### Step 3: Run Migrations
```bash
php artisan migrate
```

**Expected Output:**
```
Migrating: 2026_04_27_000000_add_role_to_users_table
Migrated:  2026_04_27_000000_add_role_to_users_table (XXms)
Migrating: 2026_04_27_000001_create_vehicles_table
Migrated:  2026_04_27_000001_create_vehicles_table (XXms)
...
```

### Step 4: Build Frontend
```bash
npm run build
# or for development
npm run dev
```

### Step 5: Start Server
```bash
php artisan serve
```

**Output:**
```
Laravel development server started on [http://127.0.0.1:8000]
```

## Testing the Application

### 1. Create Test User
Visit: `http://localhost:8000/register`
- Create a regular user account
- Use any email and strong password

### 2. Create Admin User (via database)
```bash
php artisan tinker
>>> App\Models\User::create([
...   'name' => 'Admin User',
...   'email' => 'admin@example.com',
...   'password' => Hash::make('password123'),
...   'role' => 'admin'
... ])
>>> exit
```

### 3. Test User Features
1. Login with your user account
2. Go to `/dashboard`
3. Create a vehicle: `/vehicles/create`
4. Create a driver profile: `/drivers/create`
5. Post a recruitment: `/recruitments/create`
6. Search for vehicles/drivers/jobs

### 4. Test Admin Features
1. Login with admin account
2. Visit `/admin/dashboard`
3. Moderate vehicles, drivers, and recruitments
4. View platform analytics

### 5. Test Live Frontend
1. Visit `http://localhost:8000/` (root)
2. Watch the statistics update every 30 seconds
3. Open browser console to see API requests

## API Testing

### Get Available Vehicles
```bash
curl http://localhost:8000/api/vehicles/available
```

### Get Available Drivers
```bash
curl http://localhost:8000/api/drivers/available
```

### Get Open Recruitments
```bash
curl http://localhost:8000/api/recruitments/open
```

## Useful Artisan Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Database operations
php artisan migrate:reset     # Reset all migrations
php artisan migrate:refresh   # Rollback and re-run
php artisan seed:Database     # Run seeders
php artisan tinker            # Laravel interactive shell

# Generate key (if needed)
php artisan key:generate

# Make new model with migration
php artisan make:model ModelName -m

# Make new controller
php artisan make:controller ControllerName --resource

# List all routes
php artisan route:list
```

## Directory Structure Quick Reference

```
app/
├── Http/Controllers/          ← Controllers (Vehicle, Driver, Recruitment, Admin)
└── Models/                    ← Models (User, Vehicle, Driver, Recruitment)
database/
├── migrations/                ← Database migrations (7 files)
└── database.sqlite            ← SQLite database
resources/
├── css/
│   └── app.css               ← Application styles
├── js/
│   ├── app.js                ← Main JS file
│   └── bootstrap.js          ← Bootstrap initialization
└── views/
    ├── layouts/
    │   └── app.blade.php     ← Main layout
    ├── admin/
    │   └── dashboard.blade.php
    ├── drivers/
    │   └── create.blade.php
    ├── vehicles/
    │   └── create.blade.php
    ├── recruitments/
    │   └── create.blade.php
    ├── dashboard.blade.php
    └── welcome.blade.php     ← Live frontend
routes/
├── api.php                    ← API routes
└── web.php                    ← Web routes
```

## Common Issues & Solutions

### Issue: "bootstrap/cache directory must be writable"
**Solution:**
```bash
# Ensure cache directory exists
mkdir -p bootstrap/cache
# Directory should be created automatically by Laravel
```

### Issue: Database migration fails
**Solution:**
```bash
php artisan migrate:reset
php artisan migrate
```

### Issue: Routes not working
**Solution:**
```bash
php artisan route:clear
php artisan cache:clear
```

### Issue: Frontend not loading
**Solution:**
```bash
npm install
npm run build
# Then refresh browser and clear cache
```

## Key File Locations

| Feature | File | Location |
|---------|------|----------|
| Vehicle CRUD | VehicleController.php | app/Http/Controllers/ |
| Driver Management | DriverController.php | app/Http/Controllers/ |
| Job Postings | RecruitmentController.php | app/Http/Controllers/ |
| Admin Panel | AdminController.php | app/Http/Controllers/ |
| Vehicle Model | Vehicle.php | app/Models/ |
| Driver Model | Driver.php | app/Models/ |
| Recruitment Model | Recruitment.php | app/Models/ |
| Web Routes | web.php | routes/ |
| API Routes | api.php | routes/ |
| Welcome Page | welcome.blade.php | resources/views/ |
| Admin Dashboard | dashboard.blade.php | resources/views/admin/ |

## Database Tables

After running migrations, these tables will be created:

1. `users` - User accounts with role system
2. `vehicles` - Vehicle listings
3. `drivers` - Driver profiles
4. `recruitments` - Job postings
5. `cache` - Cache storage
6. `jobs` - Queue jobs
7. `sessions` - Session storage (configured in .env)

## Environment Variables

Key `.env` settings:
- `APP_KEY` - Encryption key (already set)
- `APP_DEBUG` - Set to true for development
- `DB_CONNECTION` - Set to 'sqlite'
- `DB_DATABASE` - Points to database/database.sqlite
- `SESSION_DRIVER` - Set to 'database'

## Performance Tips

1. Use `php artisan serve` for development only
2. Use a proper web server (Apache/Nginx) for production
3. Monitor database queries: `php artisan query:listen`
4. Use caching for frequently accessed data
5. Optimize images before upload

## Next Steps After Setup

1. ✅ Run migrations to create tables
2. ✅ Create test accounts
3. ✅ Test all CRUD operations
4. ✅ Verify admin features work
5. ✅ Check live frontend updates
6. 📝 Add your own data
7. 🚀 Deploy to production

## Support Resources

- Laravel Documentation: https://laravel.com/docs
- Bootstrap 5: https://getbootstrap.com/docs
- Blade Templating: https://laravel.com/docs/blade
- Eloquent ORM: https://laravel.com/docs/eloquent

## Summary

You now have a fully functional Vehicle & Driver Recruitment System with:
- ✅ User authentication and roles
- ✅ Vehicle management system
- ✅ Driver profile system with ratings
- ✅ Job recruitment posting system
- ✅ Admin dashboard with moderation
- ✅ Live frontend with auto-refresh
- ✅ RESTful API endpoints
- ✅ Bootstrap responsive design

**Ready to start?** Run `php artisan serve` and visit `http://localhost:8000`
