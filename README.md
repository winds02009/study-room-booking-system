# Study Room Booking System

Individual project (SEHS4517 Web Application Development and Management). A PHP + MySQL study room reservation system with session-based authentication, server-side form validation, and an admin panel.

## Features
- Booking form (name, student ID, email, campus, date, time slot 09:00-21:00 in 3-hour slots)
- Server-side validation with per-field error messages kept in the session (`validateForm.php`)
- Double-booking check (same slot, date and campus) before inserting a reservation (PDO prepared statements)
- Admin login with session protection; list all bookings or search bookings by student ID (`admin.php`)

## Tech stack
PHP (mysqli / PDO), MySQL, HTML/CSS

## Structure
| File | Purpose |
|---|---|
| `reserve.php` | Reservation form |
| `validateForm.php` | Validation and booking insert |
| `admin.php` | Admin login and booking management |
| `db.php` | Database connection |

## How to run
1. Install XAMPP (Apache + MySQL) and copy the files into `htdocs/`.
2. Create database `SEHS45171A` with a `booking` table (id, fname, sid, email, campus, date, slot).
3. Set your DB credentials in `db.php` / `admin.php` and the admin password in `admin.php` (placeholder `CHANGE_ME`).
4. Open `http://localhost/reserve.php`.