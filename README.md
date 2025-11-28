# Certificate Generation & Verification System

A complete professional web application for generating, managing, and verifying certificates. Built with Core PHP, MySQL, HTML, CSS, JavaScript, and Bootstrap.

## 🎯 Features

### Employee Portal (Frontend)
- **Premium Landing Page** - Beautiful, modern design with gradient backgrounds and animations
- **Certificate Verification** - Instant verification by certificate number
- **Responsive Design** - Works perfectly on all devices
- **User-Friendly Interface** - Clean and intuitive UI

### Admin Dashboard (Backend)
- **Secure Admin Login** - Password-protected admin access
- **Dashboard Overview** - Statistics and quick actions
- **Certificate Management** - Create, edit, view, and delete certificates
- **Search Functionality** - Search certificates by multiple criteria
- **Print Certificate** - Professional certificate printing
- **Status Management** - Activate/revoke certificates

## 📁 Project Structure

```
certificates-creatation-web-app/
├── index.php                 # Employee verification landing page
├── verify.php                # Verification result page
├── api/
│   └── verify.php            # API endpoint for verification
├── admin/
│   ├── index.php             # Admin login page
│   ├── dashboard.php         # Admin dashboard
│   ├── create-certificate.php # Create new certificate
│   ├── manage-certificates.php # Manage all certificates
│   ├── edit-certificate.php  # Edit certificate
│   ├── view-certificate.php  # View certificate details
│   ├── print-certificate.php # Print certificate
│   ├── logout.php            # Admin logout
│   └── includes/
│       ├── auth.php           # Authentication check
│       ├── header.php         # Admin header
│       └── footer.php         # Admin footer
├── config/
│   └── database.php          # Database configuration
├── includes/
│   └── functions.php         # Helper functions
├── assets/
│   └── js/
│       └── main.js           # JavaScript utilities
└── database/
    └── schema.sql            # Database schema
```

## 🚀 Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server

### Setup Steps

1. **Clone or download the project**
   ```bash
   cd certificates-creatation-web-app
   ```

2. **Create Database**
   - Open phpMyAdmin or MySQL command line
   - Import `database/install.sql` (recommended - includes everything) or `database/schema.sql` to create the database and tables
   - Or run the SQL file manually

3. **Configure Database**
   - Open `config/database.php`
   - Update database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     define('DB_NAME', 'certificates');
     ```

4. **Create Admin Account**
   - Run `setup.php` in your browser: `http://localhost/certificates-creatation-web-app/setup.php`
   - This will create/update the admin account with password hash
   - **Delete `setup.php` after setup for security!**

5. **Set Up Web Server**
   - Point your web server document root to the project directory
   - For XAMPP/WAMP: Place project in `htdocs` folder
   - For Linux: Place in `/var/www/html/`

6. **Access the Application**
   - Employee Portal: `http://localhost/certificates-creatation-web-app/`
   - Admin Login: `http://localhost/certificates-creatation-web-app/admin/`

## 🔐 Default Admin Credentials

- **Username:** `admin`
- **Password:** `admin123`

**⚠️ Important:** 
- Run `setup.php` first to create the admin account properly
- Change the default password after first login!
- Delete `setup.php` after setup for security

## 📊 Database Schema

### `admins` Table
- id (INT, Primary Key)
- username (VARCHAR, Unique)
- password (VARCHAR, Hashed)
- role (VARCHAR)
- created_at (TIMESTAMP)

### `certificates` Table
- id (INT, Primary Key)
- certificate_number (VARCHAR, Unique)
- employee_name (VARCHAR)
- email (VARCHAR)
- phone (VARCHAR)
- course_name (VARCHAR)
- duration (VARCHAR)
- issue_date (DATE)
- status (BOOLEAN)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

## 🎨 Design Features

- **Premium Color Scheme** - Modern gradient designs
- **Responsive Layout** - Mobile-first approach
- **Smooth Animations** - CSS animations and transitions
- **Professional UI** - Clean and modern interface
- **Print-Ready Certificates** - Professional certificate templates

## 🔒 Security Features

- Password hashing (bcrypt)
- SQL injection prevention (prepared statements)
- Input sanitization
- Session-based authentication
- CSRF protection ready

## 📝 Usage

### For Employees:
1. Visit the verification page
2. Enter certificate number
3. Click "Verify Certificate"
4. View verification result

### For Admins:
1. Login to admin panel
2. View dashboard statistics
3. Create new certificates
4. Manage existing certificates
5. Print certificates
6. Search and filter certificates

## 🛠️ Technologies Used

- **Backend:** Core PHP
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Framework:** Bootstrap 5.3
- **Icons:** Font Awesome 6.4

## 📱 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## 🔄 Future Enhancements

- QR code generation for certificates
- Email certificate to employees
- Certificate expiry dates
- PDF download functionality
- API access for third-party integration
- Activity logs
- Multi-admin support
- Certificate templates customization

## 📄 License

This project is open source and available for use.

## 👨‍💻 Support

For issues or questions, please check the code comments or create an issue in the repository.

---

**Built with ❤️ using Core PHP and MySQL**
