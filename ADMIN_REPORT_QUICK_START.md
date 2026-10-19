# Quick Navigation Guide - Admin Report Page

## 🎯 Access Points

### Main Analytics Page
**URL:** `/admin/analytics`
**Route Name:** `admin.analytics`
**Title:** Reports & Analytics
**Description:** View all platform metrics, charts, and statistics

### Report Settings
**URL:** `/admin/report-settings`
**Route Name:** `admin.report-settings`
**How to Access:**
- Click "Settings" button on analytics page
- Direct URL: `/admin/report-settings`

---

## 📊 Features Quick Access

### Filters
Location: Top of analytics page, "Filters & Export" section
- **Start Date**: Select period beginning
- **End Date**: Select period ending
- **Group By**: Choose aggregation level (Day/Week/Month)
- **Apply Button**: Submit filter changes
- **Reset Button**: Clear filters to defaults

### Export Options
Location: "Filters & Export" section, below filters
- **CSV Export Button**: Download as spreadsheet (green button)
- **PDF Export Button**: Generate formatted report (blue button)
- **Print Button**: Open browser print dialog
- **Settings Button**: Customize report page

### Summary Statistics
Location: "Summary Statistics" section
Shows 6 key metrics:
- Total Revenue (GHC)
- Total Transactions
- Total Bookings
- Approved Drivers
- Approved Vehicles
- Pending Approvals

### Live Statistics Cards
Location: "Live Analytics Dashboard" section
Shows 6 real-time metrics:
- New Users Today
- New Bookings Today
- Pending Approvals
- Active Drivers
- Active Vehicles
- Open Recruitments

### Charts Available
1. **User Registration Trends** - Monthly user signups (line chart)
2. **Booking Activity** - Monthly booking volume (line chart)
3. **Revenue Trends** - Revenue over time (line chart) ⭐ NEW
4. **Revenue by Type** - Revenue distribution (doughnut chart) ⭐ NEW
5. **Vehicle Types Distribution** - Vehicle breakdown (doughnut chart)
6. **Driver Status Overview** - Driver availability (bar chart)
7. **Payment Status Distribution** - Payment approval status (pie chart)

### Data Tables
Location: Bottom of analytics page
Shows most recent 5 items each:
1. **Recent Transactions** - Approved payments
2. **Recent Drivers** - Latest registered drivers
3. **Recent Vehicles** - Latest registered vehicles
4. **Recent Bookings** - Latest bookings

---

## ⚙️ Settings Page Options

### Page Content
- **Page Title**: Main heading for analytics page
- **Page Description**: Subtitle/description text
- **Banner Image URL**: URL to custom banner image
- **Banner Color**: Color picker for banner background

### Display Options
Toggle on/off:
- Export buttons (CSV, PDF, Print)
- Filter controls
- Charts
- Data tables

### Auto-Refresh Settings
- **Enable Auto-Refresh**: Toggle automatic data refresh
- **Refresh Interval**: Set how often to refresh (ms)
  - Minimum: 5000ms (5 seconds)
  - Maximum: 300000ms (5 minutes)
  - Default: 30000ms (30 seconds)

---

## 🔄 Data Flow

```
User Action
    ↓
Filters Applied (date range, grouping)
    ↓
JavaScript fetches data
    ↓
Two API calls:
  - /analytics-data (basic stats)
  - /analytics-data-advanced (filtered data)
    ↓
Data received
    ↓
Update: Summary Cards, Charts, Tables
    ↓
Display updated page
```

---

## 📥 Export Flow

### CSV Export
1. Click "Export CSV" button
2. Select date range (already filtered)
3. File downloads: `analytics_YYYY-MM-DD.csv`
4. Open in Excel/Sheets

### PDF Export
1. Click "Export PDF" button
2. Select date range (already filtered)
3. File downloads: `analytics_YYYY-MM-DD.pdf`
4. Open in PDF viewer

### Print
1. Click "Print" button
2. Browser print dialog opens
3. Select printer and settings
4. Print or save as PDF

---

## 🎨 Default Customizations via Settings

**Out of Box:**
- Page Title: "Reports & Analytics"
- Banner Color: Blue (#0ea5e9)
- Auto-Refresh: Enabled (30 seconds)
- All Features: Enabled

**Recommended Customizations:**
- Add company logo as banner image
- Match banner color to brand color
- Adjust refresh interval based on data volume
- Toggle features based on user needs

---

## 🚀 First Time Setup

1. **Navigate to Analytics**
   - URL: `/admin/analytics`
   - All data loads automatically

2. **Try Filters**
   - Change date range
   - Change grouping
   - Click "Apply Filters"
   - Observe data update

3. **Try Exports**
   - Click "Export CSV" to download spreadsheet
   - Click "Export PDF" to generate report
   - Click "Print" to print page

4. **Customize Settings** (Optional)
   - Click "Settings" button
   - Update page title and description
   - Toggle features as needed
   - Save changes
   - Refresh analytics page to see updates

---

## 📱 Mobile Access

Analytics page is fully responsive:
- Filters stack vertically on mobile
- Charts stack single column
- Tables scroll horizontally
- All buttons remain functional
- Data updates work on mobile

Access on mobile: Same URL as desktop
`/admin/analytics`

---

## 🔐 Permissions

Admin-only page. Users must have:
- Authentication (logged in)
- Admin role (or appropriate permission)

Access denied for non-admins.

---

## ❓ Troubleshooting

### Charts not loading?
- Refresh page
- Check browser console for errors
- Ensure JavaScript enabled

### Filters not working?
- Click "Reset" first
- Then apply new filters
- Check date range is valid

### Export not downloading?
- Check browser download settings
- Ensure pop-ups not blocked
- Try different export format

### Settings not saving?
- Ensure database migration ran: `php artisan migrate`
- Check for validation errors on page
- Try again after page refresh

---

## 📞 Support

For technical issues:
1. Check ADMIN_REPORT_IMPLEMENTATION.md
2. Check ADMIN_REPORT_ENHANCEMENTS.md
3. Review error messages in browser console
4. Contact development team

---

**Last Updated:** 2026-05-19
**Version:** 1.0
