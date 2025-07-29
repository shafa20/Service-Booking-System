<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About  Project

Title:Service Booking System

A simple Laravel-based service booking system with RESTful APIs for customers and admin. Customers can login , register, view services, and make bookings. Admins also can login , register , manage services and view all bookings.

## Features
- Token Based Authentication
- Customer Registration & Login 
- Admin Login (seeded credentials)
- Database seededer for admin and services
- Service List (Customer)
- Book a Service (Customer)
- View Bookings (Customer & Admin)
- Manage Services (Admin)
- Laravel Sanctum Authentication
- API Documentation (Postman Collection included)
- Unit test
- Proper Laravel naming conventions and RESTful design
- Organized code with service, API Resource classes for clean response formatting and FormRequest for validation, 
- Prevent booking a service on a past date.


## Tech Stack

- Laravel 12
- MySQL
- Laravel Sanctum
- Postman (for API Testing)
- Xampp
- Git

## Installation Guide


# Open Git Bash/Terminal then write Following Command
# To Clone && Install Project
1. git clone https://github.com/shafa20/Service-Booking-System.git                                                                     
2. cd service-booking                         
3. composer install
# For .env setup  
4. cp .env.example .env

# inside .env file you can write this 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=service-booking
DB_USERNAME=root
DB_PASSWORD=

if you want to use same database (inside project db folder(path:\service-booking\db) you will get my database file name service-booking.sql)

# To Genarate Key
5. php artisan key:generate
# only migration
6. php artisan migrate
# with migration Seed a few services and an admin user.
7. php artisan migrate:fresh --seed
# To Run Project.
php artisan serve

# To Postman Check.
# with below link download Postman Collection and Import to Postman
https://drive.google.com/file/d/1iGC829PwkNc-ORvXZQxiPJG__3UzJB_q/view?usp=drive_link
# Or also this project collection Folder postman collection included you can get collection from there then Import to Postman
https://github.com/shafa20/Service-Booking-System/blob/master/collection/Service%20Booking%20API.postman_collection.json

# customer Credential.
"email": "john@example.com",
"password": "password"

# Admin Credential.
"email": "admin@admin.com",
"password": "password"



# For API unit testing
# Open Git Bash/Terminal then run Following Command for login registration test

php artisan test --filter=AuthTest


# Open Git Bash/Terminal then run Following Command for customer and admin service and booking apis test

php artisan test --filter=BookingServiceApiTest

# Sample screenshot
# you can show screenshot from this link
https://drive.google.com/drive/folders/1KxtEwqY9GVCoYO8M1MR4UUmisE5qZEJa?usp=sharing
# Also i Have uploaded screenshot inside project sample screenshot folder you can see from there 
https://github.com/shafa20/Service-Booking-System/tree/master/Sample%20Screenshots

## Author
Hosain Mohammad Shafa Khan  
Email: shafakhan2018@gmail.com 
GitHub: [shafa20](https://github.com/shafa20)
