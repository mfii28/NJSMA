---
description: Production Readiness Checklist and Implementation Steps for NJSMA PHP Site
---

# Overview
This workflow outlines the comprehensive steps required to transition the NJSMA website to a production‑ready state. It covers security hardening, performance optimization, environment configuration, logging, and deployment considerations.

## 1. Security Hardening
1. **Enforce HTTPS**
   - Add rewrite rule to redirect all HTTP requests to HTTPS.
   - Enable HSTS header.
2. **Security Headers** (add to `.htaccess`)
   - `Header set X-Content-Type-Options "nosniff"`
   - `Header set X-Frame-Options "SAMEORIGIN"`
   - `Header set X-XSS-Protection "1; mode=block"`
   - `Header set Referrer-Policy "strict-origin-when-cross-origin"`
   - `Header set Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; img-src 'self' data:; font-src 'self' https://fonts.gstatic.com;"`
3. **Disable Directory Listing**
   - `Options -Indexes`
4. **Restrict Access to Sensitive Files**
   - Deny access to `.env`, `config/`, and any backup files.
5. **SQL Injection Mitigation**
   - Ensure all DB queries use prepared statements (review `src/init.php` and other DB access files).
6. **Session Security**
   - Set `session.cookie_secure=On` and `session.cookie_httponly=On` in PHP configuration or via `ini_set`.

## 2. Performance Optimization
1. **Enable GZIP Compression**
   ```
   <IfModule mod_deflate.c>
     AddOutputFilterByType DEFLATE text/html text/css application/javascript application/json image/svg+xml
   </IfModule>
   ```
2. **Leverage Browser Caching** (using `mod_expires`)
   ```
   <IfModule mod_expires.c>
     ExpiresActive On
     ExpiresByType image/jpg "access plus 1 month"
     ExpiresByType image/jpeg "access plus 1 month"
     ExpiresByType image/gif "access plus 1 month"
     ExpiresByType image/png "access plus 1 month"
     ExpiresByType text/css "access plus 1 month"
     ExpiresByType application/javascript "access plus 1 month"
   </IfModule>
   ```
3. **Minify CSS/JS**
   - Run a build step (e.g., using `npm run build` with a minifier) and replace the original files with minified versions.
4. **Image Optimization**
   - Compress images in `lib/css/` and other asset folders using tools like `imagemin`.

## 3. Environment Configuration
1. **Create `.env` file** (outside web root) for sensitive config:
   ```
   DB_HOST=localhost
   DB_NAME=njsma
   DB_USER=your_user
   DB_PASS=your_password
   ```
2. **Load `.env` in PHP** using `vlucas/phpdotenv`:
   ```php
   require __DIR__.'/../vendor/autoload.php';
   $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
   $dotenv->load();
   ```
3. **Add `.env.example`** to repository for developers.

## 4. Logging & Error Handling
1. **Enable error logging to file** in `src/init.php`:
   ```php
   ini_set('log_errors', 1);
   ini_set('error_log', __DIR__.'/../logs/error.log');
   ```
2. **Set `display_errors` to Off** for production.
3. **Implement a global exception handler** to capture uncaught exceptions and log them.

## 5. Database Migration & Backup
1. **Create migration scripts** for any schema changes (use `sql_updates_dynamic_cms.sql`).
2. **Schedule regular backups** via a cron job that runs `mysqldump` and stores the dump in `sql_backup/` with timestamped filenames.

## 6. CI/CD & Deployment
1. **Version Control** – Ensure the repository is clean and all sensitive files are in `.gitignore`.
2. **Dockerize** (optional but recommended):
   - Write a `Dockerfile` that sets up Apache, PHP, and copies the code.
   - Use `docker-compose.yml` to spin up MySQL and the web container.
3. **Automated Tests** – Add PHPUnit tests for critical PHP functions.
4. **Deploy Script** – Create a simple Bash script that pulls the latest code, runs migrations, clears caches, and restarts Apache.

## 7. Accessibility & SEO
1. **Add meta tags** (title, description, viewport) to all HTML pages.
2. **Ensure proper heading hierarchy** (`<h1>` only once per page).
3. **Provide alt attributes for all images**.
4. **Generate an XML sitemap** and submit to search engines.

## 8. Final Verification
1. Run a security scanner (e.g., `nikto` or `OWASP ZAP`).
2. Perform Lighthouse audit for performance, accessibility, and SEO.
3. Conduct manual testing on major browsers and mobile devices.

---

**Execution**
- Follow the steps sequentially. After each major change, commit the changes and run the verification steps.
- Document any issues in the `walkthrough.md` artifact.

**End of Workflow**
