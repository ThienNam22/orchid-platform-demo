# Giới thiệu:
- Orchid là một Laravel open-source package, nó trừu tượng hóa những mẫu ứng dụng kinh doanh điển hình nhằm giúp các nhà phát triển có thể triển khai giao diện đẹp một cách nhanh chóng và không tốn nhiều công sức
- Chức năng chính:
	- Form builder: cung cấp nhiều API để tạo nên các phần tử trong form một cách nhanh chóng, được khai báo trong Layout
	- Screen: tạo ra màn hình giao diện đẹp một cách nhanh chóng, sử dụng lệnh với `php artisan`
	- Fields: các phần tử của form, có hơn 40 API
	- Permission: cung cấp khả năng quản lý quyền hạn
	- Menu, biểu đồ, thông báo, v.v..

# Tập lệnh Orchid:
- Orchid cung cấp tập lệnh sử dụng với `php artisan`:
```
  orchid:admin         Create user administrator
  orchid:chart         Create a new chart layout class
  orchid:filter        Create a new filter class
  orchid:install       Publish files for ORCHID and install package
  orchid:link          Create a symbolic link from resource orchid
  orchid:listener      Create a new listener class
  orchid:metrics       Create a new metrics class
  orchid:presenter     Create a new Presenter class
  orchid:rows          Create a new rows layout class
  orchid:screen        Create a new screen class
  orchid:selection     Create a new selection layout class
  orchid:table         Create a new table layout class
```

# Cài đặt sử dụng Orchid:
- https://orchid.software/en/docs/installation/

# Tạo tài khoản admin:
> php artisan orchid:admin [username] [email] [password]
- Cấp quyền cao nhất cho tài khoản admin: - *sử dụng option `--id`, 1 ở đây là id tài khoản*
> php artisan orchid:admin --id=1

# Cấu hình cho app:
- Orchid sử dụng hệ thống cấu hình tiêu chuẩn của Laravel, file config nằm ở `/config/platform.php`
- Tut nhanh: https://orchid.software/en/docs/configuration/

# Làm việc với Orchid:
- Lấy ví dụ: Tạo Model Car và các Screen để thực hiện CRUD với Car

## B1: Tạo migration
> php artisan make:migration create_cars_table
- 1 file sẽ được tạo ở `/database/migrations/`
- thực hiện cấu trúc table cho table Cars trong file này sau đó chạy lệnh để tạo table trong db
> php artisan migrate

## B2: Tạo screen: https://orchid.software/en/docs/screens/
- Tạo 2 Screen: CarEditScreen và CarListScreen sẽ được tạo ở `app/Orchid/Screens`
> php artisan orchid:screen CarEditScreen
> php artisan orchid:screen CarListScreen
- 2 file được tạo ra: `app/Orchid/Screens/CarEditScreen.php` và `app/Orchid/Screens/CarListScreen.php`

## B3: Đăng ký Screen với Route và tạo Breadrumb, tạo Menu cho Screen: 
- Đăng ký Route và Breadrumb tại: `routes/platform.php`
- Đăng ký Screen với Menu chính tại: `/app/Orchid/PlatformProvider.php`
- sử dụng các mẫu đăng ký có sẵn trong đó, copy lại

## B4: Nên tạo ra một mẫu Layout, có thể tái sử dụng:
- Trong ví dụ này, tạo một Layout là bảng hiển thị các bản ghi của Cars cho CarListScreen
> php artisan orchid:table CarListLayout
- một file được tạo ra tại `app/Orchid/Layouts`
- thực hiện cấu hình cho Layout Table

## B5: Tạo Model:
> php artisan make:model Car
- 1 file được tạo ra: `app/Models/Car.php`
- thực hiện triển khai cho Model như code đã viết

## B6: Hoàn thiện:
- hoàn thiện nốt 2 Screen
> php artisan serve
- truy cập: localhost:8000/admin

# Data Management: https://orchid.software/en/docs/quickstart-crud/
- Orchid có cung cấp một package CRUD đơn giản, hoặc không thì cũng thể thao tác đơn giản với database
- Trong ví dụ trên: các method trong `CarEditScreen.php` được áp dụng, ngoải ra sử dụng kèm với API của Laravel
	- method: `query()`
	- method: `createOrUpdate()`
	- method: `remove()`

# Manage attachments: https://orchid.software/en/docs/quickstart-files/
- Nối tiếp Data Management, phần này thực hiện thêm attach file cho đối tượng Car, cụ thể là file ảnh
- Thực hiện:
1. Tạo một migration khác:
> php artisan make:migration add_image_column_for_car_table
2. Triển khai migration:
- Thực hiện chỉnh sửa migration để thêm cột mới vào table Cars, cột mới có tên `image`, cột này sẽ lưu lại link file ảnh khi người dùng up ảnh lên cho từng bản ghi
3. Thêm Cropper trong `CarListLayout.php` 
> Đôi khi việc upload không thành công, có thể do `upload_max_filesize` và `post_max_size` trong `php.ini`, sửa chúng
## Notes:
- Nếu thay đổi domain hoặc chuyển sang sử dụng https, nên thêm dòng sau đối với Cropper:
> ->targetRelativeUrl()
- Một lựa chọn khác để ghi vào column 'image' là sử dụng `relationships` [https://laravel.com/docs/master/eloquent-relationships], với điều này, Cropper sẽ ghi lại số lượng file đã tải xuống, sử dụng cho Cropper:
> ->targetId()

# Sorting and filtering table: https://orchid.software/en/docs/quickstart-sort-filter-table/
- Orchid cung cấp khả năng sắp xếp và lọc theo giá trị cho cho bảng một cách nhanh chóng và gọn nhẹ, cụ thể áp dụng đối với `CarListScreen.php`
- Tut nhanh tại: link bên trên
> Note: Such an expression will be performed by `sql` with `like` filtering. In order for the search to be case-insensitive, you need to check the database encoding.

# Permission:
- chủ yếu sử dụng của Laravel framework
- một số options có thể sử dụng để quản lý role:
```php
// Check whether the user has permissions
// Check is carried out both for the user and for his role
Auth::user()->hasAccess($string);

// Get all user roles
Auth::user()->getRoles();

// Check whether the user has a role
Auth::user()->inRole($role);

// Add role to user
Auth::user()->addRole($role);
```
- role cũng có các method:
```php
// Returns all users with this role.
$role->getUsers();
```
- Có thể thêm Permission tại: `registerPermissions()` trong `app/Orchid/PlatformProvider.php`
- Khi Permission được thêm có thể cấp cho từng role
- Với mỗi Screen, khai báo thêm `$permission=[]` để giới hạn quyền hạn truy cập. Giả sử role ADMIN có quyền `car.edit`, role USER không có, vậy với tài khoản mang role ADMIN sẽ được truy cập vào CarEditScreen và role USER thì không
- Quản lý Role, Permission, User tại Main menu

# Thêm:
- Tài liệu về Orchid: https://orchid.software/en/docs/
- API về các thành phần, screen, v.v.. có thê được tìm thấy trong `app/Orchid`, đó là các ví dụ, code mẫu, chúng cũng được hiển thị mẫu ở Main menu, ngoài ra có thể tìm kiếm trong doc

<hr>

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[CMS Max](https://www.cmsmax.com/)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
