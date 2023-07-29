## Backend Flopos

Backend Flopos
-Laravel 8.7
-Sanctum
-Cloudinary storage

### 1. Masuk ke dalam project yang telah disalin

```sh
cd back-flopos
```
<br />


### 2. Install package yang dibutuhkan

```sh
composer install
```
<br />

### 3. Buat database baru dengan nama flopos

```sh
> mysql -u root -p
> create database flopos;
```
<br />

### 4. Migrate table yang sudah dibuat

```sh
php artisan migrate
```
<br />

### 5. Buat data buatan dari seeder

```sh
php artisan db:seed
```
<br />

### 6. Jalankan project backend

```sh
php artisan serve
```
<br />

