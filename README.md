# Food Ordering System

A complete food ordering website built with PHP and MySQL.

## Features

- **User Features:**
  - Register and login
  - Browse foods by category
  - Search for foods
  - Add foods to cart
  - Place orders
  - View order history
  - Update profile

- **Admin Features:**
  - Dashboard with statistics
  - Manage users (delete users)
  - Manage foods (add/delete)
  - Manage orders (view/approve/reject)
  - View order details

## Installation

1. **Setup Database:**
   - Open XAMPP and start Apache and MySQL
   - Go to http://localhost/phpmyadmin
   - Create a new database named `food_ordering`
   - Import the `setup_database.sql` file

2. **Configure:**
   - Edit `config/db.php` if needed (database credentials)

3. **Access the website:**
   - Go to http://localhost/food%20oldering/

## Default Admin Account

- **Username:** admin
- **Password:** admin123

## File Structure

```
food_ordering/
├── config/
│   ├── db.php          # Database connection
│   └── functions.php   # Helper functions
├── admin/              # Admin panel
│   ├── dashboard.php   # Admin dashboard
│   ├── foods.php       # Manage foods
│   ├── orders.php      # Manage orders
│   └── users.php       # Manage users
├── includes/
│   ├── header.php      # Site header
│   └── footer.php      # Site footer
├── assets/
│   ├── css/style.css   # Main stylesheet
│   └── images/         # Images
├── index.php           # Homepage
├── login.php           # Login page
├── register.php        # Registration page
├── foods.php           # Food menu
├── cart.php            # Shopping cart
├── dashboard.php       # User dashboard
├── profile.php         # User profile
├── order_details.php   # View order details
└── setup_database.sql  # Database schema
```

## Database Tables

1. `users` - User accounts (admin/user roles)
2. `categories` - Food categories
3. `foods` - Food items
4. `orders` - Customer orders
5. `order_items` - Items in each order
6. `contact_messages` - Contact form messages

## Notes

- No Bootstrap or JavaScript frameworks used
- Pure vanilla CSS for styling
- Simple and easy to understand code
- Mobile responsive design
- Supports role-based access (admin vs user)
