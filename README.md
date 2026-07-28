# Bazaar Multivendor Laravel Starter

This is a Laravel-ready starter for the **Bazaar** university project, rewritten as a **multivendor e-commerce** application with the same visual theme from your mockups.

## What is included

- Public storefront with product browsing, product detail, cart, checkout, orders, and profile pages
- Vendor onboarding, vendor dashboard, vendor product management, and vendor order views
- Admin dashboard, vendor approval, category management, product management, and order management
- Custom auth pages for login and registration
- Theme matched to your screenshots:
  - `Plus Jakarta Sans` for body text
  - `Sora` for headings
  - warm cream canvas
  - white cards
  - charcoal sidebar/footer
  - orange accent

## Main assumptions

- Laravel 10
- PHP 8.2+
- Session-based cart
- Cash on Delivery or bKash as a simple payment choice
- Vendors must be approved by admin before they can access the vendor dashboard

## Files to copy into Laravel

Copy the following folders/files into a fresh Laravel project:

- `app/Http/Controllers`
- `app/Http/Middleware`
- `app/Models`
- `database/migrations`
- `database/seeders`
- `resources/views`
- `public/css`
- `public/js`
- `public/images`
- `routes/web.php`
- `app/Http/Kernel.php`

## Setup steps

1. Create a fresh Laravel 10 project.
2. Copy these files into the project.
3. Run:

```bash
composer install
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
```

## Login accounts created by seeder

- Admin: `admin@bazaar.test`
- Vendor 1: `vendor1@bazaar.test`
- Vendor 2: `vendor2@bazaar.test`
- Customer: `customer@bazaar.test`

Password for all seed accounts:

`password`

## Important notes

- Products belong to vendors through `products.vendor_id`.
- Order items also store `vendor_id` so each vendor can see only their own items.
- Vendor accounts are marked `pending` until admin approves them.
- If you want, this starter can be expanded next into a fully polished production build with the exact screenshot pages wired to real data.
