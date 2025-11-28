# Installation Guide

## Quick Setup Instructions

### Step 1: Database Setup

1. **Create Database**
   - Open phpMyAdmin or MySQL command line
   - Create a new database named `certificates`
   - Or import the `database/install.sql` file (recommended) or `database/schema.sql`

2. **Import Schema**
   ```sql
   -- Run the SQL file
   source database/schema.sql;
   ```
   Or import `database/schema.sql` through phpMyAdmin

### Step 2: Configure Database Connection

1. Open `config/database.php`
2. Update the database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'certificates');
   ```

### Step 3: Create Admin Account

**Option A: Using Setup Script (Recommended)**
1. Open `setup.php` in your browser
2. The script will create/update the admin account
3. **Delete `setup.php` after setup for security**

**Option B: Manual SQL**
```sql
-- Generate password hash using PHP
-- Run: php -r "echo password_hash('admin123', PASSWORD_DEFAULT);"
-- Then insert into database:
INSERT INTO admins (username, password, role) VALUES 
('admin', 'YOUR_GENERATED_HASH', 'admin');
```

### Step 4: Access the Application

- **Employee Portal:** `http://localhost/certificates-creatation-web-app/`
- **Admin Login:** `http://localhost/certificates-creatation-web-app/admin/`

### Default Login Credentials

- **Username:** `admin`
- **Password:** `admin123`

⚠️ **Important:** Change the default password immediately after first login!

## Troubleshooting

### Database Connection Error
- Check database credentials in `config/database.php`
- Ensure MySQL service is running
- Verify database name exists

### Admin Login Not Working
- Run `setup.php` to reset admin password
- Check if admin record exists in database
- Verify password hash is correct

### Permission Errors
- Ensure web server has read/write permissions
- Check file permissions (644 for files, 755 for directories)

## Security Checklist

- [ ] Change default admin password
- [ ] Delete `setup.php` file
- [ ] Update database credentials
- [ ] Set proper file permissions
- [ ] Enable HTTPS in production
- [ ] Configure `.htaccess` properly
- [ ] Regular database backups

## Production Deployment

1. Update `config/database.php` with production credentials
2. Remove or secure `setup.php`
3. Enable HTTPS/SSL
4. Set proper error reporting (disable display_errors)
5. Configure backup system
6. Set up monitoring and logs

---

For more details, see `README.md`

