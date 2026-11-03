# MANJU WORLDWIDE EXPRESS — Secure Tracking Website

This package contains a PHP + MySQL production-oriented starter based on the requested customer UI.

## Important: GitHub vs hosting
GitHub is suitable for storing the code. GitHub Pages cannot execute PHP or MySQL. Deploy the PHP project on Hostinger/cPanel or another PHP + MySQL host, and keep the GitHub repository for source control.

## Setup
1. Create a MySQL database on your hosting.
2. Import `sql/schema.sql` in phpMyAdmin.
3. Copy `config/config.example.php` to `config/config.php`.
4. Put your real DB host/name/user/password in `config/config.php`.
5. Upload the project to your PHP hosting.
6. Open `/admin/setup_admin.php` once and create a strong admin username/password (10+ character password).
7. DELETE `admin/setup_admin.php` from the server immediately after setup.
8. Admin login: `/admin/`.
9. Customer website: `/index.php` (or set your domain document root to this folder).

## Security model
- Admin password is stored as a PHP `password_hash`, not plaintext.
- Customer tracking endpoint returns only public shipment fields; it does NOT return actual AWB or customer name/phone.
- Actual AWB is server/database-side.
- PDO prepared statements are used.
- Admin endpoints require a session and CSRF token.
- Real DB credentials belong in `config/config.php`, which is ignored by Git.
- Use HTTPS on the live domain.

## Excel
Admin can export `.xlsx` and import edited `.xlsx/.xls/.csv`. The browser uses SheetJS only for file conversion; the authoritative records remain in MySQL.

## Courier tracking
The public prototype intentionally does not expose the actual AWB. To add live courier status later, integrate each courier's official API on the server side. Do not put courier API keys in browser JavaScript.
# manjuWorldwideExpress
