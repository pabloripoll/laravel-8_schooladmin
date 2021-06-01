<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About School Admin

This project is intended to be a laravel 8 fresh start for a simple web application including its backoffice, using a school admin managment as example. Its includes login page for the app adminer, schools and students CRUD, and also an image upload store with public access for schools and private access for students and adminer.

It has:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Step 1 - Laravel 8.x Pre Requisites

https://laravel.com/docs/8.x/installation#server-requirements

Composer must be installed locally or globally.

### Laravel on Nignx server
To serve laravel on Nginx create a new site server block 
```bash
$ sudo nano /etc/nginx/sites-available/{domain-name}.conf
```
#### Option: Deploying directly from Nginx server
```bash
server {
        listen 80;
        listen [::]:80;

        # SSL configuration
        # listen 443 ssl;
        # listen [::]:443 ssl;

        root /var/www/{path-to-project};

        # Add index.php to the list if you are using PHP
        index index.php index.html index.htm;

        server_name {domain-name.extension} www.{domain-name.extension};

        location / {
                try_files $uri $uri/ /public/index.php?$query_string;
        }
        
        error_page 403 /public/; #<- empty url to default public script
        #error_page 404 /public/404.blade.php;
        
        #error_page 500 502 503 504 /50x.html;        
        #location = /50x.html {
        #       root /var/www/{nginx-handle-error-page};
        #}

        # pass the PHP scripts to FastCGI
        location ~ \.php$ {
                include snippets/fastcgi-php.conf;
        #       # With php7.x-fpm:
                fastcgi_pass unix:/run/php/php7.x-fpm.sock;
        }

}
```
#### Option: Deploying from Nginx as reversed proxy for Apache server
```bash                                                                
server {
        listen 80;
        listen [::]:80;

        # Domain or subdomain with its top level domain
        server_name {domain-name.extension} www.{domain-name.extension};

        location / {
                # Reverse Proxy to Apache
                proxy_pass http://127.0.0.1:8080;
                proxy_set_header Host $host;
                proxy_set_header X-Real-IP $remote_addr;
                proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                proxy_set_header X-Forwarded-Proto $scheme;
                # Do not use 404 or any error code handler manage by nginx as followed example
                # try_files $uri $uri/ =404;
                # this will avoid apache .htaccess to handle rewrite rules
        }

        # Deny access to .htaccess files, if Apache's document root concurs with nginx's one
        location ~ /\.ht {
                deny all;
        }
}
```
Create symlink to make project enabled
```bash
$ sudo ln -s /etc/nginx/sites-available/{domain-name}.conf /etc/nginx/sites-enabled/
```
Check Nginx any syntax error
```bash
$ sudo nginx -t
```
Restart Nginx
```bash
$ sudo systemctl restart nginx
```

### Laravel on Apache server
To serve laravel on Apache create a new virtual host
```bash
$ sudo nano /etc/apache2/sites-available/{domain-name.extension}.conf
```
```bash
<VirtualHost *:8080>
    ServerName {domain-name.extension}
    ServerAlias www.{domain-name.extension}
    
    DocumentRoot /var/www/{path-to-project}

    <Directory /var/www/{path-to-project}>
        Options -Indexes +FollowSymLinks -MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    # Enable PHP-FPM adding the following block
    <FilesMatch \.php$>
        # 2.4.10+ can proxy to unix socket
        SetHandler "proxy:unix:/var/run/php/php7.4-fpm.sock|fcgi://localhost"
    </FilesMatch>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
Enable new virtual host
```bash
$ sudo a2ensite {domain-name.extension}.conf
```
Reload Apache service
```bash
$ sudo a2ensite {domain-name.extension}.conf
```

#### Database
Database can be set up remotly with a database client such as DBeaver or through PhpMyadmin application, or by terminal as follows:

Log into the database server:
```bash
$ mysql -u root -p
```
Then create a database called magento (or whatever it need to be called):
```bash
mysql > CREATE DATABASE {new_db_name};
```
Create a database user called magentouser with new password: (Do not use '#' in password)
```bash
mysql > CREATE USER '{db-user}'@'localhost' IDENTIFIED BY '{db-password}';
```
Then grant the user full access to the database:
```bash
mysql > GRANT ALL ON {new_db_name}.* TO '{db-user}'@'localhost' IDENTIFIED BY '{db-password}' WITH GRANT OPTION;
```
Finally, save your changes and exit:
```bash
mysql > FLUSH PRIVILEGES;
mysql > EXIT;
```

## Copy this repo or install Laravel 8.x
Change to laravel project directory
```bash
$ cd /var/www/{laravel-project-path}/
```
Create Laravel Project
```bash
$ composer create-project laravel/laravel {project-name}
```
Or specific version
```bash
$ composer create-project --prefer-dist laravel/laravel:^8.{version} {project-directory-name}

```
#### Get server group
Nginx server user
```bash
$ ps aux|grep nginx|grep -v grep
```
Apache server user
```bash
$ ps aux | egrep '(apache|httpd)'
```

Set up .ENV file at project's root directory
```bash
$ sudo nano .env 
```
.env file with minimum params required
```bash
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:bFQsdwjwgdqiD9s9LEZ8MWa5CEvNG1GndzAc8HrDcF8=
APP_DEBUG=true
APP_URL=http://{domain-name.extension}

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={database_name}
DB_USERNAME={database_username}
DB_PASSWORD={database_password}

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
```
Create .htaccess file to point to `/public` directory at project's root directory
```bash
$ nano .env 
```
Correct permissions must be set to project's directories and files. `$USER` is for current logged user, or specify other instead.
```bash
$ sudo find . -type f -exec chmod 644 {} \;
$ sudo find . -type d -exec chmod 755 {} \;
$ sudo chown -R $USER:www-data .
$ sudo chgrp -R www-data storage bootstrap/cache
$ sudo chmod -R ug+rwx storage bootstrap/cache
```
Set up project start up
```bash
$ php artisan key:generate
$ php artisan cache:clear
$ php artisan config:clear
$ composer dump-autoload
```
If domain is browsed and shows 403 error page is because Laravel application access is through `/public` directory
```bash
/Laravel-Project
|_/app
|_/bootstrap
|_/config
|_/database
|_/public
|_/resources
|_/routes
|_/storage
|_/tests
|_/vendor
...
```
So, to redirect access to application, set up a .htaccess file on project's root directory
```bash
<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteCond %{REQUEST_URI} !^public
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### At this stage laravel project should be visible.

### File Storage
By default, files are uploaded into `storage` directory. Watch settings on:
```bash
config/filesystems.php
```
file could set as follows:
```php
<?php

return [
...
    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'permissions' => [
                'file' => [
                    'public' => 0664,
                    'private' => 0600,
                ],
                'dir' => [
                    'public' => 0775,
                    'private' => 0700,
                ],
            ],
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

    ],
...
];

```
For a better file administration with above setting, private and public files should be placed as:
```bash
/{project}
|_/storage
  |_/app
    |_/private
    |_/public

```
Once created these directories and before begin to develop any application, create a symlink
```bash
$ php artisan storage:link
```
Images or some other files will be save by school, student or user 9 digit code from column `idcode`. Then will be completed by date _ time of the upload. And last, with random digits to sort from uploading multiple files at the same time. This practice is usefull when some file information is missing or to compare or debug when something went wrong.

## Page route admin structure
To simplify app development progression, it took page structure example from Magento 2. So, I devided the navigation as `Panel`, `Section` and `Page`. Of course it can be changed but remember to change their $variables_name in `app/Http/Controllers/Admin/PageController.php`. For e.g.: Panel would be the container module, Section would be subsecuent category and Page, the layout view or action.
routes/web.php:
```php
$admin = env('ADMIN_PATH_PREFIX'); // this directory should have a more secured name from .env
Route::group(['prefix' => $admin, 'middleware' => 'auth'], function () {    
    Route::get('/', [AdminPageController::class, 'controller']);
    Route::get('/{panel?}', [AdminPageController::class, 'controller']);
    Route::get('/{panel?}/{section?}', [AdminPageController::class, 'controller']);    
    Route::get('/{panel?}/{section?}/{page?}', [AdminPageController::class, 'controller']);
    Route::get('/files/{target?}/{type?}/{file?}', [AdminFilesController::class, 'privateFiles']);
    Route::post('/json/{panel?}', [AdminDataController::class, 'jsonData']);
    Route::post('/json/{panel?}/{section?}', [AdminDataController::class, 'jsonData']);
    Route::post('/json/{panel?}/{section?}/{page?}', [AdminDataController::class, 'jsonData']);
    Route::post('/form/{panel?}', [AdminDataController::class, 'formData']);
    Route::post('/form/{panel?}/{section?}', [AdminDataController::class, 'formData']);
    Route::post('/form/{panel?}/{section?}/{page?}', [AdminDataController::class, 'formData']);    
});
```
app/Http/Controllers/Admin/PageController.php:
```php
...
class PageController extends Controller
{
    private $panel      = 'dashboard';
    private $section    = 'index';
    private $page       = 'index';    

    /* MAIN CONTROLLERS */
    
    public function controller (
            Request $request,
            $panel = '',
            $section = '',
            $page = ''
        )
    {
        !empty($panel) ? : $panel = $this->panel;
        !empty($section) ? : $section = $this->section;
        !empty($page) ? : $page = $this->page;
        $method = $panel.'_'.$section.'_'.$page; // auto composing method

        // $data object comes from method
        method_exists(new Pagecontroller, $method) ?
        $data = self::$method($request) :
        $data = self::error_index_index($request);
        
        $layout = $method;
        $data->layout = $layout; // include current method to data object

        if ( isset($data->error) ) {
            $layout = 'error_index_index'; $data->layout = $layout;            
        } 
        
        return view('admin.layouts.'.$layout, ['data' => $data]);
    }
...
```

Also remember that backoffice access can be changed from .env, line `ADMIN_PATH_PREFIX` in order to secure folder access from `sample-domain.com/admin` to `sample-domain.com/Admin73h98fy4h` 

### Using this app samples
Place into project root directory and perform these following commands
####Migrations
```bash
$ php artisan migrate
```
#### Seeders
It's reccommended to seed DB one per one seeders and checks results.
```bash
$ php artisan db:seed --class=UserSeeder
```

## Laravel CRUD *(Create /Read /Update / Delete)*

### Migration only
```bash
$ php artisan make:migration {NewMigrationExample}
```
### Migration with model
```bash
$ php artisan make:migration {NewMigrationExample}
```

## About Laravel

### Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

### Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

### Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
