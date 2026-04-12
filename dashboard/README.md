# NJSMA Admin Dashboard

## Overview
The NJSMA (New Juaben South Municipal Assembly) Admin Dashboard is a comprehensive content management system for managing a municipal website.

## Features

### Content Management
- **News & Posts** - Create, edit, publish/unpublish articles with image uploads
- **Events Calendar** - Manage upcoming municipal events with dates, venues, and registration links
- **Gallery** - Upload and organize photos in categories
- **Static Pages** - Manage custom pages (About, Services, etc.)

### Municipal Management
- **Departments** - Manage department information including head of department photos and details
- **Assembly Members** - Track elected members and appointees with photos
- **Management Team** - Municipal executive staff directory
- **Projects** - Development projects with progress tracking
- **Tenders & Procurement** - Public procurement notices and tender documents

### Documents & Finance
- **Budgets & Financial Reports** - Upload and categorize financial documents
- **Documents Center** - Repository for forms, bye-laws, and official documents

### Citizen Portal
- **Feedback & Messages** - View citizen inquiries and feedback
- **FAQs** - Manage frequently asked questions
- **Careers** - Job postings and opportunities
- **Zonal Councils** - Local council information

## Dashboard Access

### Default Credentials
- **Username:** admin
- **Password:** admin123

> **Important:** Change the default password immediately after first login via System Settings.

## File Structure

```
dashboard/
├── index.php              # Dashboard home
├── login.php              # Admin login
├── logout.php             # Logout handler
├── posts.php              # News/Posts management
├── events-manage.php      # Events management
├── gallery-manage.php     # Photo gallery
├── pages-manage.php       # Static pages
├── departments.php        # Department management
├── members-manage.php     # Assembly members
├── management-manage.php  # Management team
├── projects-manage.php    # Projects
├── tenders-manage.php     # Procurement/tenders
├── budgets-manage.php     # Financial reports
├── repository-manage.php  # Document repository
├── messages-manage.php    # Citizen feedback
├── faqs-manage.php        # FAQ management
├── careers-manage.php     # Job postings
├── zonal-councils.php     # Zonal councils
├── system-settings.php    # Site configuration
├── css/
│   └── admin.css          # Admin styles
├── assets/
│   └── img/
│       ├── gallery/       # Gallery images
│       ├── departments/   # Department head photos
│       ├── members/       # Member photos
│       ├── management/    # Management photos
│       ├── projects/      # Project images
│       ├── events/        # Event images
│       └── profileImg/    # Profile images
├── postimages/            # Blog post images
└── partials/
    ├── header.php         # Admin header
    └── sidebar.php        # Navigation sidebar
```

## Image Upload Guidelines

### Supported Formats
- JPG/JPEG
- PNG
- GIF

### Recommended Sizes
- **Department Head Photos:** 400x400px (square)
- **Gallery Images:** 1200x800px (landscape)
- **Event Posters:** 800x600px
- **Member Photos:** 400x400px (square)
- **Project Images:** 1200x800px

### Maximum File Size
- Images: 5MB per file
- Documents (PDF): 10MB per file

## Database Tables

### Core Tables
- `tbladmin` - Admin users
- `tblcategory` - Post categories
- `tblposts` - News articles
- `tblevents` - Events
- `tblgallery` - Gallery items
- `tbldepartments` - Departments
- `tblassembly_members` - Assembly members
- `tblmanagement` - Management team
- `tblprojects` - Development projects
- `tbltenders` - Procurement tenders
- `tblbudgets` - Financial reports
- `tblrepository` - Document repository
- `tblfaqs` - FAQs
- `tblcareers` - Job postings
- `tblmessages` - Contact form submissions

## Security Features

### Authentication
- Session-based authentication
- Password hashing (bcrypt)
- Login required for all admin pages

### File Upload Security
- Extension validation
- File size limits
- Automatic filename sanitization

### Input Validation
- XSS protection via htmlspecialchars
- SQL injection prevention via prepared statements
- CSRF protection (recommended for production)

## Production Checklist

Before deploying to production:

1. **Change default admin password**
   - Go to System Settings → Update credentials

2. **Update SITE_URL in .env file**
   ```
   SITE_URL=https://yourdomain.com/njsma
   ```

3. **Set up database**
   - Import database schema from `sql_backup/`
   - Update database credentials in `.env`

4. **Configure error handling**
   - Set `display_errors = 0` in production
   - Enable error logging

5. **File permissions**
   - Ensure `dashboard/assets/img/` folders are writable
   - Ensure `docs/` folder is writable for uploads
   - Protect sensitive folders from direct access

6. **Enable HTTPS**
   - Update `.htaccess` to redirect HTTP to HTTPS
   - Install SSL certificate

7. **Backup strategy**
   - Schedule regular database backups
   - Backup uploaded files (`assets/img/`, `docs/`)

## Troubleshooting

### Common Issues

**Uploads not working:**
- Check folder permissions (should be 755 or 775)
- Verify PHP file upload limits in php.ini
- Check available disk space

**Database connection errors:**
- Verify DB credentials in `.env` file
- Ensure MySQL service is running
- Check database exists

**Images not displaying:**
- Verify paths are correct (use `/njsma/` prefix)
- Check images exist in the correct folders
- Ensure proper file extensions

### Support
For technical support, contact your system administrator or development team.

## License
Copyright © 2024 New Juaben South Municipal Assembly. All rights reserved.
