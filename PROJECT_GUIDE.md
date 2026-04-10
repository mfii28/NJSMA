# NJSMA Project Architecture & Database Documentation

This document provides a comprehensive overview of the refactored architecture and database schema for the New Juaben South Municipal Assembly (NJSMA) website.

## 1. System Architecture

The project has been transitioned from a flat script-based structure to a modern **MVC-Lite** architecture.

### Directory Structure
- `/config`: Global configuration and environment constants (`config.php`).
- `/src`: Core application logic.
    - `/src/Core`: Fundamental classes like the `Database` singleton.
    - `/src/Models`: Data models (e.g., `Post`, `MceModel`) handling all SQL interactions.
- `/views`: Frontend templates.
    - `/views/partials`: Reusable UI components (`header`, `footer`, `navbar`).
- `/public`: (Planned) Publicly accessible assets and entry point.
- `/dashboard`: Administrative backend (currently being modernized).

### Core Design Patterns
1. **Singleton Pattern**: The `Core\Database` class ensures a single PDO connection is shared across the application.
2. **PSR-4 Autoloading**: Custom autoloader in `src/autoloader.php` maps namespaces to directories.
3. **Prepared Statements**: ALL database interactions use PDO prepared statements to prevent SQL injection.

---

## 2. Database Schema (MySQL)

### Current Tables

#### `mce`
Stores information about the Municipal Chief Executive.
- `id` (INT, PK)
- `first_name` (VARCHAR)
- `last_name` (VARCHAR)

#### `tblcategory`
News/Blog categories.
- `id` (INT, PK)
- `CategoryName` (VARCHAR)

#### `tblposts`
News and announcements.
- `id` (INT, PK)
- `PostTitle` (VARCHAR)
- `CategoryId` (INT, FK)
- `SubCategoryId` (INT)
- `PostDetails` (TEXT)
- `PostingDate` (TIMESTAMP)
- `PostImage` (VARCHAR)
- `Is_Active` (INT)

### Planned Tables (To be added)

#### `tbldocuments`
Resource repository (PDFs, Forms).
- `id` (INT, PK)
- `Title` (VARCHAR)
- `Description` (TEXT)
- `FilePath` (VARCHAR)
- `Category` (VARCHAR) -- e.g., 'Permit', 'Report', 'Bye-Law'
- `UploadDate` (TIMESTAMP)

#### `tbltenders`
Procurement and contract notices.
- `id` (INT, PK)
- `ReferenceNo` (VARCHAR)
- `Title` (VARCHAR)
- `Description` (TEXT)
- `Deadline` (DATE)
- `Status` (ENUM: 'Open', 'Closed')

#### `tbldepartments`
Detailed info for municipal departments.
- `id` (INT, PK)
- `DeptName` (VARCHAR)
- `Description` (TEXT)
- `HeadName` (VARCHAR)
- `HeadImage` (VARCHAR)
- `Icon` (VARCHAR)

#### `tblgallery`
Gallery folders and images.
- `id` (INT, PK)
- `Title` (VARCHAR)
- `ThumbImage` (VARCHAR)
- `CreatedDate` (TIMESTAMP)

---

## 3. Implementation Tracking

- [x] Refactor core architecture.
- [x] Implement PDO Singleton & Autoloader.
- [x] Secure Search/Blog functionality.
- [x] Create Document Repository (Frontend + Models).
- [x] Create Tenders/Notice board (Frontend + Models).
- [x] Implement Quick Links Sidebar.
- [x] Implement Management & Assembly Members Pages.
- [x] Implement Service Charter & Media Gallery.
- [ ] Develop Functional Admin Dashboard for News & Documents.
