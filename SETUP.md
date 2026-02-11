# Food Ordering System - Setup Instructions

## Overview
A complete PHP-based Food Ordering System with MySQL database. Features include user registration, ordering, cart management, and admin panel for managing foods, orders, and users.

## Folder Structure

```
food_ordering/
├── admin/
│   ├── dashboard.php      # Admin dashboard
│   ├── foods.php          # Manage foods
│   ├── header.php         # Admin header
│   ├── index.php          # Admin dashboard (alias)
│   ├── logs.php           # System logs
│   ├── orders.php         # Manage orders
│   ├── order_details.php  # View order details
│   ├── sidebar.php        # Admin sidebar
│   └── users.php          # Manage users
├── assets/
│   ├── css/
│   │   └── style.css      # Main stylesheet
│   ├── images/
│   │   ├── food.jpg
│   │   ├── foods/
│   │   │   ├── food1.svg
│   │   │   ├── food2.svg
│   │   │   └── food3.svg
│   │   ├── homepage_pic.jpg
│   │   └── menu.jpg
│   └── uploads/           # User uploads
├── config/
│   ├── db.php            # Database connection
│   └── functions.php     # Helper functions
├── includes/
│   ├── footer.php        # Page footer
│   └── header.php        # Page header
├── admin/               # Admin pages folder
├── cancel_order.php     # Cancel order page
├── cart.php            # Shopping cart
├── dashboard.php       # User dashboard
├── foods.php           # Menu/foods page
├── index.php           # Homepage with slider
├── login.php           # Login page
├── logout.php          # Logout page
├── my_orders.php       # User order history
├── order_details.php   # View order details
├── profile.php         # User profile
├── register.php        # Registration page
├── setup_database.sql  # Database setup
├── SETUP.md           # This file
└── settings.php       # Settings page
```

## Prerequisites

1. **XAMPP** (or any PHP/MySQL server)
   - Apache web server
   - MySQL database
   - PHP 7.0 or higher

2. **Web Browser**
   - Chrome, Firefox, Edge, etc.

## Installation Steps

### Step 1: Install XAMPP
1. Download XAMPP from https://www.apachefriends.org
2. Install XAMPP with Apache and MySQL
3. Start Apache and MySQL services

### Step 2: Place Files
1. Copy the `food_ordering` folder to:
   ```
   C:\xampp\htdocs\food_ordering
   ```

### Step 3: Setup Database
1. Open XAMPP Control Panel
2. Click "Admin" next to MySQL (opens phpMyAdmin)
3. Click "Import" in the top menu
4. Choose the `setup_database.sql` file
5. Click "Go" to import

**Alternative Method - Using Command Line:**
1. Open XAMPP Shell (click "Shell" in XAMPP Control Panel)
2. Run these commands:
   ```bash
   mysql -u root -p < setup_database.sql
   ```

### Step 4: Configure Database (if needed)
Edit `config/db.php` if you have different database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Your MySQL password
define('DB_NAME', 'food_ordering');
```

### Step 5: Access the Application
1. Open your browser
2. Go to: http://localhost/food_ordering/

## Default Login Credentials

### Admin Account:
- **Username:** admin
- **Password:** admin123

### Sample User Accounts:
- **Username:** john_doe
- **Password:** password (or any password when registering)

## Features

### User Features:
- Register new account
- Login/Logout
- View homepage with food slider
- Browse menu by category
- Search for foods
- Add items to cart
- Update cart quantities
- Remove items from cart
- Place orders
- View order history
- View order details
- Cancel pending orders
- Edit profile

### Admin Features:
- Login/Logout
- View dashboard with statistics
- View all orders
- Update order status (pending, approved, rejected, completed)
- View order details
- Add new foods
- Edit foods
- Delete foods
- View all users
- Delete users
- View system logs

## Database Tables

The system uses 6 normalized tables (3NF):

1. **users** - User accounts (admin/user roles)
2. **categories** - Food categories
3. **foods** - Food items with prices
4. **orders** - Customer orders
5. **order_items** - Items in each order
6. **logs** - System activity logs

## Security Features

- **Password Hashing:** Uses `password_hash()` with BCRYPT
- **Session Management:** Secure session handling
- **SQL Injection Protection:** Uses prepared statements with mysqli
- **XSS Protection:** Uses `htmlspecialchars()` for output
- **Input Sanitization:** Server-side validation
- **Role-based Access:** Admin-only pages protected

## How to Use

### For Users:
1. Register a new account or login
2. Browse the menu using categories or search
3. Click "Add to Cart" on items you want
4. Go to Cart to review and update quantities
5. Enter delivery address and notes
6. Click "Place Order"
7. View your orders in "My Orders" page
8. Wait for admin to approve your order

### For Admin:
1. Login at http://localhost/food_ordering/login.php
2. Use admin credentials
3. Go to Admin Panel
4. View and manage orders
5. Add/Edit/Delete foods
6. Manage users
7. View system logs

## Customization

### Adding Sample Images:
Place food images in `assets/images/` folder:
- `food1.jpg`, `food2.jpg`, etc.
- Update database or admin panel to reference images

### Changing Colors:
Edit `assets/css/style.css`:
```css
:root {
    --primary-color: #ff6b35;  /* Main color */
    --secondary-color: #2c3e50; /* Secondary color */
    --accent-color: #e74c3c;   /* Accent color */
}
```

## Troubleshooting

### Database Connection Error:
1. Check XAMPP MySQL is running
2. Verify database credentials in `config/db.php`
3. Ensure database was imported correctly

### Session Errors:
1. Check PHP session settings in php.ini
2. Ensure session folder is writable

### Page Not Found:
1. Check URL is correct
2. Ensure all files are in the right location

### Images Not Showing:
1. Check image paths in database
2. Ensure images are in `assets/images/` folder

## File Permissions
Make sure these folders are writable:
- `assets/uploads/`
- `assets/images/` (if uploading images)

## PHP Requirements
- PHP 7.0 or higher
- MySQLi extension enabled
- Session support enabled

## Support
For issues or questions:
1. Check all error logs in XAMPP
2. Verify all files are uploaded
3. Check database tables were created

## License
This is an educational project. Feel free to use and modify.
