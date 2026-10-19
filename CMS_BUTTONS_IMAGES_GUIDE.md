# CMS - Buttons and Images User Guide

## Quick Start

### 1. Login to CMS
Navigate to `http://yoursite.com/cms` and login with your admin credentials

### 2. Add or Edit a Section

#### To Add a New Section:
1. Go to **Pages** → Select a page → **Edit**
2. Click the **Sections** tab
3. Click **Add New Section**
4. Fill in the form (see sections below)
5. Click **Add Section**

#### To Edit Existing Section:
1. Go to **Pages** → Select a page → **Edit**
2. Click the **Sections** tab
3. Find the section you want to edit
4. Click **Edit** button
5. Update the form
6. Click **Save Changes**

---

## Adding Images to Sections

### Image Settings

In the CMS form, look for the **Image Settings** section:

**Image URL**
- Enter the full URL to your image
- Example: `https://example.com/images/banner.jpg`
- Or use a local file: `/storage/uploads/image.jpg`
- Supports: JPG, PNG, GIF, WebP

**Image Alt Text**
- Describe the image for accessibility
- Example: "Happy customers using our service"
- This is important for SEO and accessibility

### Where Images Display
- **Image Section Type** - Displays image prominently
- Other section types - Image displays if "Image URL" is filled

### Image Best Practices
✓ Use high-quality images (at least 800x600px)
✓ Optimize file size (compress images for faster loading)
✓ Use descriptive alt text
✓ Test on mobile devices

---

## Adding Buttons to Sections

### Button Settings

In the CMS form, look for the **Button Settings** section:

**Button Text**
- What the button says
- Examples: "Learn More", "Get Started", "Book Now", "Contact Us"
- Keep it short and actionable (2-4 words)

**Button Link**
- Where the button goes when clicked
- Full URL: `https://example.com/page`
- Relative URL: `/services`
- Email: `mailto:info@example.com`
- Phone: `tel:+1234567890`

**Button Background** (Color)
- Click the color box to choose
- Or paste a hex color: `#6366f1`
- Should contrast well with text color

**Button Text Color**
- Click the color box to choose
- Or paste a hex color: `#ffffff`
- Should be readable on button background

### Where Buttons Display
Buttons appear below the content in ANY section type:
- Text sections - below content
- Image sections - below image
- Hero sections - centered below content
- Features sections - centered at bottom
- Video sections - below video
- Slider sections - centered below carousel

### Button Examples

**Example 1: Learn More Button**
- Button Text: `Learn More`
- Button Link: `/services`
- Background: `#6366f1` (Primary color)
- Text Color: `#ffffff` (White)

**Example 2: Contact Button**
- Button Text: `Contact Us`
- Button Link: `mailto:info@succezz.com`
- Background: `#ef4444` (Red)
- Text Color: `#ffffff` (White)

**Example 3: Call-to-Action**
- Button Text: `Book Now`
- Button Link: `/book`
- Background: `#10b981` (Green)
- Text Color: `#ffffff` (White)

---

## Section Types & Buttons

### Text Section + Button
Perfect for: Paragraphs with call-to-action

**What you see:**
```
[Title]
[Content paragraph]
[Button]
```

### Image Section + Button
Perfect for: Hero images with action

**What you see:**
```
[Title]
[Large Image]
[Button]
```

### Hero Section + Button
Perfect for: Banner with prominent action

**What you see:**
```
[Colored Background Banner]
[Large Title]
[Description]
[Button] ← Centered
```

### Features Section + Button
Perfect for: Feature grid with main action

**What you see:**
```
[Feature Grid - 3-4 boxes]
[Button] ← Centered below all features
```

---

## Styling Options

### Text Alignment
- **Left** - Content starts from left edge
- **Center** - Content centered on page
- **Right** - Content ends at right edge

### Heading Size
- **Small** - Smaller heading (good for subtitles)
- **Normal** - Standard heading (default)
- **Large** - Bigger heading (prominent)
- **Extra Large** - Largest heading (hero sections)

### Padding
- **None** - Minimal spacing
- **Small** - Compact spacing
- **Standard** - Normal spacing (default)
- **Large** - Generous spacing

### Layout Style
- **Default** - Standard layout
- **Grid** - Multi-column grid
- **Masonry** - Pinterest-style layout
- **Carousel** - Sliding layout

---

## Tips & Best Practices

### Button Colors
✓ Use your brand colors
✓ Ensure good contrast (dark text on light buttons, vice versa)
✓ Use 2-3 consistent colors across your site
✓ Test on mobile - colors should still be visible

### Button Text
✓ Be specific - "Learn More" > "Click Here"
✓ Use action words - Get, Book, Schedule, Join, Start
✓ Keep it short - Most people scan, don't read
✓ Add urgency - "Book Now" > "Book Later"

### Images
✓ Use high quality images (but optimize for web)
✓ Keep images consistent in style
✓ Use alt text - it helps SEO and accessibility
✓ Test on mobile - ensure images are responsive

### Links
✓ Test all button links before publishing
✓ Use full URLs for external links: `https://...`
✓ Use relative paths for internal links: `/services`
✓ Include `/` at start for relative paths

---

## Troubleshooting

### Button Not Showing
- Check that BOTH "Button Text" and "Button Link" are filled in
- Button only shows if both fields have values
- Click Save/Update after changes

### Image Not Showing
- Verify image URL is complete and correct
- Check image file exists at that location
- Test URL in browser address bar
- For local files, use `/storage/uploads/filename.jpg` format

### Colors Look Different Than Expected
- Try a different color picker
- Use hex codes directly: `#6366f1`
- Test on different browsers
- Clear browser cache (Ctrl+F5)

### Page Layout Looks Wrong
- Check text alignment setting
- Verify padding setting is correct
- Test on mobile devices too
- Buttons should never break the layout

---

## Need Help?

Check these resources:
1. **CMS Dashboard** - `/cms` - All pages and sections
2. **Live Preview** - Preview button shows how page looks
3. **Website Settings** - Customize colors, fonts, theme
4. **Search for Pages** - Find specific pages quickly

## Support
For technical issues or questions about CMS features, contact your site administrator.
