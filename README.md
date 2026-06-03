# ZenStyle - Salon & Spa Management Web Application

ZenStyle is a web application for managing salon and spa operations.  
The system supports online booking, staff management, appointment management, service management, inventory management, payment tracking, client management, comments, news, notifications, attendance, payroll, and dashboard reporting.

This project was built as an eProject using Laravel.

---

## Features

### Client Side

- View salon information, services, news, FAQ, and contact page
- Book appointments online
- Verify booking by email OTP
- View booking success page
- Comment on services

### Staff/Admin Side

- Staff login with JWT authentication
- Dashboard overview
- Manage appointments
- Confirm, complete, and cancel appointments
- Checkout appointment and create payment record
- Manage clients
- Manage staff accounts and staff profiles
- Manage services and categories
- Manage comments: approve or delete
- Manage news
- Manage staff schedules
- Manage attendance
- Manage payroll
- Manage inventory, suppliers, products, and purchase orders
- Receive Firebase notification for new booking

---

## Tech Stack

- Backend: Laravel 13
- Language: PHP 8.3+
- Database: MySQL
- Frontend: Blade, Tailwind CSS, Alpine.js
- Build tool: Vite
- Authentication: JWT stored in HttpOnly cookie
- Notification: Firebase Cloud Messaging
- Image upload: Cloudinary
- Calendar: FullCalendar
- Chart: Chart.js / ApexCharts

---

## Requirements

Before running this project, make sure your computer has:

- PHP 8.3 or higher
- Composer
- Node.js and npm
- MySQL
- Git
- Laragon / XAMPP / Laravel Herd / local PHP environment

Recommended for Windows students:

- Laragon
- MySQL from Laragon
- VS Code or PhpStorm

---

## Installation

Clone the project:

```bash
git clone https://github.com/BlackBeard1720/ZenStyle.git
cd ZenStyle
```

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

Create `.env` file:

```bash
cp .env.example .env
```

On Windows PowerShell, you can use:

```powershell
copy .env.example .env
```

Generate Laravel application key:

```bash
php artisan key:generate
```

---

## Environment Configuration

Open `.env` and update the database configuration:

```env
APP_NAME=ZenStyle
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
ASSET_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zenstyle
DB_USERNAME=root
DB_PASSWORD=
```

Create a MySQL database named:

```txt
zenstyle
```

Then add a JWT secret:

```env
JWT_SECRET=your_random_secret_key_here
```

Example:

```env
JWT_SECRET=zenstyle_secret_123456789
```

Do not use the example secret in production.

---

## Mail Configuration

For local development, you can keep mail as log:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@zenstyle.local"
MAIL_FROM_NAME="${APP_NAME}"
```

If you want to send real email OTP, configure SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

Use Gmail App Password, not your normal Gmail password.

---

## Firebase Configuration

If you want to use Firebase Cloud Messaging, fill these values in `.env`:

```env
FIREBASE_API_KEY=
FIREBASE_AUTH_DOMAIN=
FIREBASE_PROJECT_ID=
FIREBASE_STORAGE_BUCKET=
FIREBASE_MESSAGING_SENDER_ID=
FIREBASE_APP_ID=
FIREBASE_VAPID_KEY=
```

If Firebase is not configured, the main system can still run, but push notification features may not work.

---

## Cloudinary Configuration

For image upload, configure Cloudinary:

```env
CLOUDINARY_CLOUD_NAME=
CLOUDINARY_UPLOAD_PRESET=
```

The upload preset should be unsigned when using Cloudinary Upload Widget from the browser.

---

## Database Migration and Seeding

Run migrations:

```bash
php artisan migrate
```

Run seeders:

```bash
php artisan db:seed
```

Or reset the database and seed again:

```bash
php artisan migrate:fresh --seed
```

The seeders will create sample data for roles, users, staff, clients, categories, services, comments, appointments, payments, news, schedules, suppliers, products, and purchase orders.

---

## Running the Project

Run Laravel server:

```bash
php artisan serve
```

Run Vite development server:

```bash
npm run dev
```

Open the project in browser:

```txt
http://127.0.0.1:8000
```

Staff login page:

```txt
http://127.0.0.1:8000/staff/login
```

---

## Queue Worker

This project uses database queue connection.

Run the queue worker:

```bash
php artisan queue:listen
```

Or:

```bash
php artisan queue:work
```

If the queue tables do not exist, run:

```bash
php artisan queue:table
php artisan migrate
```

---

## Useful Commands

Clear config and cache:

```bash
php artisan optimize:clear
```

Build frontend assets:

```bash
npm run build
```

Run tests:

```bash
php artisan test
```

Run all development processes using Composer script:

```bash
composer run dev
```

Note: On Windows, `composer run dev` may fail because Laravel Pail requires the `pcntl` extension. If that happens, run these commands separately instead:

```bash
php artisan serve
npm run dev
php artisan queue:listen
```

---

## Demo Video

The demonstration video shows the main workflow of the ZenStyle system, including online booking, email OTP verification, appointment management, checkout, and email receipt.

Demo link:  
https://drive.google.com/file/d/1iTsosiqbSVH0YrMG8lAZQM1eJ7_bzzd2/view?usp=sharing

---

## Demo Accounts

After running seeders, you can login using these accounts.

### Admin

```txt
Email: minhpham@gmail.com
Password: minh123456
```

### Receptionist

```txt
Email: linhvn@gmail.com
Password: linh123456
```

### Stylist

```txt
Email: huyphg@gmail.com
Password: huy123456
```

Other stylist accounts are also created by `StaffSeeder`. Most of them use:

```txt
Password: password123
```

These accounts are for demo and testing only.

---

## Main Routes

Client pages:

```txt
/                    Home
/about               About
/news                News
/dich-vu             Services
/booking             Booking
/lien-he             Contact
/faq                 FAQ
```

Staff pages:

```txt
/staff/login         Staff login
/staff               Staff dashboard
/staff/appointments  Appointment management
/staff/services      Service management
/staff/categories    Category management
/staff/clients       Client management
/staff/inventory     Inventory management
/staff/payments      Payment management
/staff/comments      Comment management
/staff/news          News management
```

---

## Project Structure

Important folders:

```txt
app/Http/Controllers       Controllers
app/Models                 Eloquent models
app/Services               Service classes
app/Http/Middleware        Custom middleware
database/migrations        Database migrations
database/seeders           Sample data seeders
resources/views            Blade views
routes/web.php             Web routes
public                     Public assets
config/services.php        Third-party service configuration
```

---

## Notes

- Do not commit real `.env` file to GitHub.
- Do not commit real Firebase private keys or API secrets.
- Use demo credentials only for local testing.
- Run `php artisan optimize:clear` after changing `.env`.
- Run `npm run build` before deployment.
- Make sure MySQL is running before running migrations.
