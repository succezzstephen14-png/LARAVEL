# CMS Content Management Guide

## Overview
Your SUCCEZZ platform now has a complete Content Management System (CMS) that allows you to edit all website pages and sections without touching code.

## Available Editable Pages

### 1. **Homepage** (slug: `home`)
The main landing page with 7 editable sections:
- **Hero Carousel** - Eye-catching banner with call-to-action
- **Intelligent Driving Starts Here** - Introduction section
- **Why Choose SUCCEZZ** - 4 benefit features with icons
- **Our Services** - Service offerings cards
- **Key Benefits** - 4 key benefits with icons
- **What Our Customers Say** - Customer testimonials
- **Ready to Get Started?** - Call-to-action section

**Access:** `/cms/pages` → Find "Home" → Click "Edit"

### 2. **Services Page** (slug: `services`)
Detailed services offering with 3 editable sections:
- Professional Driver Services
- Vehicle Rental Solutions
- Easy Booking System

**Access:** `/cms/pages` → Find "Services" → Click "Edit"  
**Frontend:** `http://yoursite.com/services`

### 3. **About Page** (slug: `about`)
Company information with 4 editable sections:
- Who We Are
- Our Mission
- Our Values
- Why Choose Us

**Access:** `/cms/pages` → Find "About" → Click "Edit"  
**Frontend:** `http://yoursite.com/about`

### 4. **Contact Page** (slug: `contact`)
Contact information with 3 editable sections:
- Get in Touch
- Contact Information
- Follow Us (Social Media Links)

**Access:** `/cms/pages` → Find "Contact" → Click "Edit"  
**Frontend:** `http://yoursite.com/contact`

## How to Edit Content

### Step 1: Login to CMS
1. Go to `http://yoursite.com/login`
2. Login with your CMS admin account
3. Click "CMS Dashboard" or navigate to `/cms`

### Step 2: Navigate to Pages
1. In the CMS sidebar, click **Pages**
2. You'll see a list of all editable pages

### Step 3: Edit a Page
1. Click the **Edit** button on the page you want to modify
2. You'll see **Page Details** and **Sections** tabs

### Step 4: Edit Sections
In the **Sections** tab:
- Click **Edit** on any section to modify its content
- Update the title, type, and content
- Click **Save** to update

### Step 5: Add New Sections
1. In the **Sections** tab, scroll to "Add New Section"
2. Fill in the section details:
   - **Title**: Section heading
   - **Type**: Choose from:
     - `text` - HTML text content
     - `image` - Image display
     - `hero` - Large banner with background color
     - `features` - Grid of feature items
     - `video` - Video embed
     - `slider` - Carousel/slider content
   - **Content**: Your section content (HTML supported)
   - **Background Color** (for hero sections): Choose a color
3. Click **Add Section**

### Step 6: Publish Changes
- Ensure the page has `is_published` enabled
- Changes are live immediately on the frontend

## Content Section Types

### Text Section
- Supports HTML formatting
- Perfect for paragraphs, lists, and formatted content
- Example: Service descriptions, about content

### Hero Section
- Large banner-style display
- Supports background colors
- Perfect for CTAs and featured messages

### Features Section
- Grid layout for feature items
- Great for displaying benefits, features, or key points
- Supports HTML content in each feature

### Image Section
- Display single images
- Supports responsive sizing
- File path should be relative to `public/` folder

### Video Section
- Embed video players
- Content should include iframe HTML

### Slider Section
- Carousel-style content display
- Content should include Bootstrap carousel markup

## Frontend Display

All editable pages are automatically displayed on your frontend:

| Page | Frontend URL | CMS Slug |
|------|--------------|----------|
| Home | `/` | `home` |
| Services | `/services` | `services` |
| About | `/about` | `about` |
| Contact | `/contact` | `contact` |

Dynamic pages are routed through the catch-all route that looks up pages by slug.

## Website Settings

Configure site-wide settings at **CMS → Website Settings**:
- Primary and secondary colors (applied across all pages)
- Font color
- Social media links
- Email settings
- Other global configurations

## Preview Before Publishing

Before publishing a page:
1. Click the **Preview** button in the page editor
2. See exactly how your changes will look on the frontend
3. Make adjustments as needed

## Tips & Best Practices

1. **Use HTML wisely** - Text sections support full HTML. Use proper tags for formatting.
2. **Optimize images** - Use compressed images for better performance
3. **Test on mobile** - Preview your pages on mobile devices
4. **Keep it simple** - Don't overload sections with too much content
5. **Use consistent styling** - Leverage the website color settings for consistency
6. **Draft before publishing** - Create pages with `is_published` unchecked first, then publish when ready

## Creating Custom Pages

To create additional editable pages:

1. Go to **CMS → Pages → Add New Page**
2. Enter page details:
   - **Title**: Your page title
   - **Slug**: URL slug (e.g., `blog`, `team`, `pricing`)
   - **Description**: Brief page description (optional)
   - **Template**: Choose layout
   - **SEO Title & Description**: For search engines
3. Click **Create Page**
4. Add sections to your new page
5. Publish when ready

The page will be accessible at `http://yoursite.com/{slug}`

## Troubleshooting

### Page not showing on frontend?
- Check if `is_published` is enabled in page settings
- Verify the page slug matches the URL
- Clear browser cache

### Styling looks wrong?
- Check website color settings in **Website Settings**
- Verify HTML content is properly formatted
- Use browser developer tools to inspect CSS

### Changes not appearing?
- Refresh your browser (Ctrl+F5 for hard refresh)
- Check that you clicked "Save"
- Verify the page is published

## Questions or Issues?

For technical support or to add new content types:
- Contact your development team
- Check the Laravel error logs at `storage/logs/`
- Review recent changes at **CMS → Activity Log** (if available)

---

**Last Updated:** 2024
**CMS Version:** 1.0
**Framework:** Laravel 12 with Bootstrap 5
