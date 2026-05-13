# Bitácora de Viajes - Implementation TODO

## Step 1: Dependencies & Auth Setup [COMPLETED]
- Breeze installed
- Sanctum installed
- Migrations ready

## Step 2: Add Role to Users [PENDING]
- Create migration: php artisan make:migration add_role_to_users_table
- Edit User model

## Step 3: Models & Migrations [COMPLETED]
- Travel, Place, Document models with relations
- Migrations with foreign keys

## Step 4: Middleware & Controllers [PENDING]
- php artisan make:middleware RoleMiddleware
- php artisan make:controller TravelController --resource
- etc. for Place/Document (admin/user variants)

## Step 5: Routes [PENDING]
- Edit web.php & api.php

## Step 6: Seeders [PENDING]
- php artisan make:seeder UserSeeder
- php artisan make:seeder TravelSeeder
- Edit DatabaseSeeder

## Step 7: Views [PENDING]
- Create layouts/app.blade.php
- Create travels/ dir with index/create/edit/show.blade.php etc.

## Step 8: API & Postman [PENDING]
- Test API
- Create postman collection

## Step 9: Final Setup & Test [PENDING]
- php artisan migrate:fresh --seed
- npm install && npm run build
- php artisan serve

*Update status as completed.*

