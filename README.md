# TOY MODEL SHOP - Website Bán Mô Hình Đồ Chơi

Website bán mô hình đồ chơi được xây dựng với PHP theo kiến trúc **BTL-Web-2025 MVC**, sử dụng MySQL, HTML5, CSS3, JavaScript.

## Tính năng

### Phần khách (Public)
- ✅ Xem danh sách sản phẩm với pagination
- ✅ Tìm kiếm sản phẩm theo tên, danh mục
- ✅ Xem chi tiết sản phẩm
- ✅ Đăng ký, đăng nhập với authentication
- ✅ Giỏ hàng và đặt hàng
- ✅ Trang giới thiệu, liên hệ, FAQ
- ✅ Xem tin tức

### Phần thành viên (Member)
- ✅ Quản lý thông tin cá nhân
- ✅ Xem lịch sử đơn hàng
- ✅ Hủy đơn hàng
- ✅ Thay đổi mật khẩu

### Phần quản trị (Admin/Staff)
- ✅ **Dashboard**: Thống kê tổng quan (sản phẩm, đơn hàng, doanh thu)
- ✅ **Quản lý sản phẩm**: CRUD đầy đủ với upload ảnh, validation
- ✅ **Quản lý đơn hàng**: Xem chi tiết, cập nhật trạng thái
- ✅ **Quản lý liên hệ**: Đọc, xóa với filter read/unread
- ✅ **Quản lý người dùng**: Xem danh sách, edit
- ✅ **Quản lý tin tức**: CRUD tin tức
- ✅ **FAQ Management**: Hệ thống 4 bảng (BTL-Web-2025)
- ✅ **Cài đặt**: Cấu hình website

## Công nghệ sử dụng

- **Architecture**: BTL-Web-2025 MVC Pattern với PHP Namespaces
- **Backend**: PHP 7.4+ (PSR-4 Autoloading)
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (jQuery)
- **Admin UI**: [Tabler](https://tabler.io) - Modern Bootstrap Dashboard
- **Client UI**: Bootstrap 5.3
- **Icons**: Tabler Icons, Bootstrap Icons
- **Routing**: Custom Router với dynamic parameters

## Yêu cầu hệ thống

- PHP >= 7.0
- MySQL >= 5.7
- Apache/Nginx web server
- XAMPP/WAMP/MAMP (khuyến nghị cho development)

## Hướng dẫn cài đặt

### 1. Clone hoặc tải project

```bash
git clone [repository-url]
```

Hoặc giải nén file zip vào thư mục web root của bạn (htdocs cho XAMPP, www cho WAMP)

### 2. Cấu hình database

**Bước 1:** Tạo database
- Mở phpMyAdmin (http://localhost/phpmyadmin)
- Tạo database mới tên `toy_shop`

**Bước 2:** Import database
- Chọn database `toy_shop` vừa tạo
- Click tab "Import"
- Chọn file `database.sql` trong thư mục project
- Click "Go" để import

### 3. Cấu hình kết nối

Mở file `config/database.php` và chỉnh sửa thông tin kết nối:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');  // Username MySQL của bạn
define('DB_PASS', '');      // Password MySQL của bạn
define('DB_NAME', 'toy_shop');
```

Mở file `config/config.php` và chỉnh sửa BASE_URL:

```php
// Thay đổi theo đường dẫn thực tế của bạn
define('BASE_URL', 'http://localhost/ass');
```

### 4. Tạo thư mục uploads

Đảm bảo thư mục `public/uploads` có quyền ghi (chmod 755 hoặc 777)

```bash
chmod -R 755 public/uploads
```

### 5. Truy cập website

- **Trang chủ**: http://localhost/ass
- **Admin CMS**: http://localhost/ass/cms
- **Đăng nhập**: http://localhost/ass/login

### Tài khoản mặc định

**Admin:**
- Email: `admin@toyshop.com`
- Password: `admin123`

**Staff:**
- Email: `staff@toyshop.com`
- Password: `staff123`

**User:**
- Email: `user@example.com`
- Password: `123456`

## Cấu trúc thư mục (BTL-Web-2025)

```
ass/
├── controllers/         # Controllers (BTL-Web-2025)
│   ├── BaseController.php       # Base controller
│   ├── HomeController.php       # Public homepage
│   ├── AuthController.php       # Login/Register
│   ├── ProductController.php    # Public products
│   ├── DashboardController.php  # Admin dashboard
│   ├── CMSProductController.php # Admin products CRUD
│   ├── CMSOrderController.php   # Admin orders
│   ├── CMSContactController.php # Admin contacts
│   └── ...
├── models/              # Models (BTL-Web-2025)
│   ├── BaseModel.php           # Base model với CRUD
│   ├── ProductModel.php        # Product logic
│   ├── OrderModel.php          # Order logic
│   ├── ContactModel.php        # Contact logic
│   ├── DashboardModel.php      # Dashboard stats
│   └── ...
├── views/               # Views (BTL-Web-2025)
│   ├── admin/                  # Admin views (Tabler UI)
│   │   ├── layouts/           # Header, Footer, Sidebar
│   │   ├── home/              # Dashboard
│   │   ├── products/          # Products CRUD views
│   │   ├── orders/            # Orders views
│   │   ├── contacts/          # Contacts views
│   │   └── users/             # Users views
│   ├── client/                 # Public views
│   │   ├── layouts/           # Header, Footer
│   │   ├── home/              # Homepage
│   │   ├── products/          # Product list, detail
│   │   └── ...
│   └── auth/                   # Login, Register
├── core/                # Core classes (BTL-Web-2025)
│   ├── http/
│   │   └── Route.php          # Router với params
│   ├── route/
│   │   └── routes.php         # Route definitions
│   └── Auth.php               # Authentication
├── database/            # Database (BTL-Web-2025)
│   └── Database.php           # Singleton PDO connection
├── config/              # Configuration
│   ├── config.php            # General config
│   └── database.php          # DB credentials
├── includes/            # Helpers
│   ├── autoload.php          # PSR-4 autoloader
│   └── functions.php         # Helper functions
├── public/              # Public assets
│   ├── uploads/              # User uploads
│   ├── css/                  # Stylesheets
│   └── js/                   # Scripts
├── admin/               # Legacy admin (users, settings only)
│   ├── users.php
│   └── settings.php
├── define-params.php    # Constants definition
├── index.php            # Application entry point
├── .htaccess            # Apache rewrite rules
└── README.md            # This file
```

## Tính năng bảo mật

- Prepared Statements để chống SQL Injection
- Password hashing với bcrypt
- XSS protection với htmlspecialchars
- CSRF protection (đang phát triển)
- Validation dữ liệu đầu vào (client-side & server-side)

## Tính năng SEO

- Meta tags động
- Friendly URL (slug)
- Sitemap (đang phát triển)
- Structured data (đang phát triển)

## Responsive Design

- Tương thích với mọi thiết bị (desktop, tablet, mobile)
- Sử dụng Bootstrap 5 Grid System
- Mobile-first approach

## W3C Validation

- HTML5 chuẩn W3C
- CSS3 chuẩn W3C
- Có thể kiểm tra tại: https://validator.w3.org

## Admin CMS Features

### Dashboard (`/cms`)
- Thống kê tổng sản phẩm, đơn hàng, doanh thu
- Biểu đồ đơn hàng theo trạng thái
- Danh sách đơn hàng gần đây

### Products Management (`/cms/products`)
- **List**: Search, pagination, filter by status
- **Add**: Form đầy đủ với upload ảnh, SKU validation
- **Edit**: Preview ảnh cũ, update all fields
- **Delete**: Xóa sản phẩm và ảnh đính kèm
- **Features**:
  - Auto generate slug from name
  - SKU uniqueness check
  - Price validation (sale_price < price)
  - Stock management
  - Image upload với resize

### Orders Management (`/cms/orders`)
- **List**: Filter by status (pending, processing, completed, cancelled)
- **View**: Chi tiết đơn hàng với order items
- **Update Status**: Workflow management
- **Customer Info**: Name, email, phone, address

### Contacts Management (`/cms/contacts`)
- **List**: Filter by read/unread status
- **View**: Auto mark as read when opened
- **Delete**: Remove contact
- **Features**: Subject preview, date sorting

### Users Management (`/cms/users`)
- **List**: Display all users với role badges
- **Edit**: Link to legacy admin for complex operations

### Settings (`/cms/settings`)
- Redirect to legacy admin
- Site configuration

## Troubleshooting

### Lỗi kết nối database
- Kiểm tra thông tin trong `config/database.php`
- Đảm bảo MySQL đang chạy
- Kiểm tra tên database đã tạo chưa

### Lỗi không hiển thị CSS/JS
- Kiểm tra BASE_URL trong `config/config.php`
- Clear cache trình duyệt

### Lỗi upload file
- Kiểm tra quyền thư mục `public/uploads`
- Kiểm tra cấu hình `upload_max_filesize` trong php.ini

## Liên hệ

- Email: your-email@example.com
- GitHub: your-github-url

## License

MIT License - Dự án học tập
