# PHP_Laravel12_Create_Custome_Package

## Project Overview

This project demonstrates how to create a custom Laravel 12 package called DemoPackage inside a Laravel application.

The package is fully modular and includes:

Its own routes, controllers, views, config, and service provider.

Easy integration into the main Laravel project.

Configurable message via config/demopackage.php.

Demonstrates package route rendering and direct view rendering.

## Key Features:

Custom package inside packages/ directory.

Separate package routes and views.

Configurable package message via config/demopackage.php.

Package Service Provider automatically registers routes and views.

Demonstrates both package route and direct package view rendering.



## Application Features:

View demo package content via routes /demo and /demo-view.

Load package views from a separate package folder (packages/DemoVendor/DemoPackage).

Configurable package message via config/demopackage.php.

Demonstrates using both package controller and direct package view.

Illustrates publishing package assets (views & config) to the main project.

## This project is designed especially for beginners and freshers to understand:

Laravel 12 project and package folder structure.

Creating custom Laravel packages with controllers, routes, views, and config.

Using Service Providers for auto-registration of routes and views.

Autoloading package classes via PSR-4 namespaces.

How to publish package assets to the main Laravel project.

Backend–Frontend integration using Blade templates.

Best practices for organizing reusable Laravel code in packages.

## Technologies Used

- PHP 8.x
- Laravel 12
- Composer
- Blade Templating
- PSR-4 Autoloading


---



# Project SetUp

---



## STEP 1: Create New Laravel 12 Project

### Run Command :

```
composer create-project laravel/laravel PHP_Laravel12_Create_Custome_Package "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Create_Custome_Package

```

Make sure Laravel 12 is installed successfully.





## STEP 2: Setup Database

### Open .env

```

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_custome_package
DB_USERNAME=root
DB_PASSWORD=


APP_NAME="laravel12_custome package"
APP_ENV=local


```
### Create database:

```
laravel12_custome_package

```

### Now run:

```
php artisan migrate

```



## STEP 3: CREATE packages FOLDER AND PACKAGE NAMESPACE

Laravel does not create a packages folder by default, so we make it manually.

### From your Laravel project root, run:

```

# Create packages folder
mkdir packages

# Create vendor folder inside packages
mkdir packages/DemoVendor

# Create package folder inside vendor
mkdir packages/DemoVendor/DemoPackage

```

### After this step, your folder tree looks like:

```
your-laravel-project/
└── packages/
    └── DemoVendor/
        └── DemoPackage/

```


## STEP 4: CREATE FULL PACKAGE STRUCTURE

### Now we create the subfolders for the package code, config, routes, views:

```
#  Create src folder for PHP classes
mkdir packages/DemoVendor/DemoPackage/src

# Create Controllers and Providers folders inside src
mkdir packages/DemoVendor/DemoPackage/src/Controllers
mkdir packages/DemoVendor/DemoPackage/src/Providers

# Create routes folder
mkdir packages/DemoVendor/DemoPackage/routes

# Create resources/views folder for blade templates
mkdir -p packages/DemoVendor/DemoPackage/resources/views

# Create config folder for package config
mkdir packages/DemoVendor/DemoPackage/config

```


### Resulting Folder Structure

```
DemoPackage/
├── composer.json
├── config/
│   └── demopackage.php
├── routes/
│   └── web.php
├── resources/
│   └── views/
│       └── index.blade.php
├── src/
│   ├── Controllers/
│   │   └── DemoController.php
│   ├── Providers/
│   │   └── DemoPackageServiceProvider.php
│   └── helpers.php

```

## STEP 5: CREATE PACKAGE composer.json (IMPORTANT)

### File: packages/DemoVendor/DemoPackage/composer.json

```

{
    "name": "demovendor/demopackage",
    "description": "Demo Laravel 12 Custom Package",
    "type": "library",
    "authors": [
        {
            "name": "Your Nmae",
            "email": "your@example.com"
        }
    ],
    "require": {},
    "autoload": {
        "psr-4": {
            "DemoVendor\\DemoPackage\\": "src/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "DemoVendor\\DemoPackage\\Providers\\DemoPackageServiceProvider"
            ]
        }
    }
}

```

Meaning:

psr-4 → package namespace

providers → auto register service provider



## STEP 6: REGISTER PACKAGE AUTOLOAD IN MAIN PROJECT

Open main project file:

composer.json


### Update autoload like this:

```
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "DemoVendor\\DemoPackage\\": "packages/DemoVendor/DemoPackage/src/"
    }
}

```
### Now run:

```
composer dump-autoload

```

## STEP 7: CREATE SERVICE PROVIDER (CORE PART)

### File: packages/DemoVendor/DemoPackage/src/Providers/DemoPackageServiceProvider.php

```

<?php

namespace DemoVendor\DemoPackage\Providers;

use Illuminate\Support\ServiceProvider;

class DemoPackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'demopackage');

        // Publish config and views
        $this->publishes([
            __DIR__.'/../../config/demopackage.php' => config_path('demopackage.php'),
            __DIR__.'/../../resources/views' => resource_path('views/vendor/demopackage'),
        ], 'demopackage');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/demopackage.php',
            'demopackage'
        );
    }
}

```


## STEP 8: CREATE PACKAGE CONFIG FILE

### File: packages/DemoVendor/DemoPackage/config/demopackage.php

```

<?php

return [
    'message' => 'Hello from DemoPackage!',
];

```


## STEP 9: CREATE PACKAGE CONTROLLER

### File: packages/DemoVendor/DemoPackage/src/Controllers/DemoController.php

```

<?php

namespace DemoVendor\DemoPackage\Controllers;

use App\Http\Controllers\Controller;

class DemoController extends Controller
{
    public function index()
    {
        return view('demopackage::index');
    }
}

```


## STEP 10: CREATE PACKAGE ROUTE

### File: packages/DemoVendor/DemoPackage/routes/web.php

```

<?php

use DemoVendor\DemoPackage\Controllers\DemoController;

Route::get('/demo-package', [DemoController::class, 'index']);


```


## STEP 11: CREATE PACKAGE VIEW

### File: packages/DemoVendor/DemoPackage/resources/views/index.blade.php


```

<!DOCTYPE html>
<html>
<head>
    <title>Demo Package</title>
</head>
<body>
   <h1>{{ config('demopackage.message') }}</h1>
<p>This is a demo view from DemoPackage!</p>

</body>
</html>

```


## STEP 12: CREATE CONTROLLER


### Run:

```
php artisan make:controller DemoPackageController

```

### app/Http/Controllers/DemoPackageController.php

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoPackageController extends Controller
{
    public function index()
    {
        return "Demo Package route is working!";
    }
}

```


## STEP 13: Routes

### routes/web.php:

```

<?php

use Illuminate\Support\Facades\Route;
use DemoVendor\DemoPackage\Controllers\DemoController;


Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DemoPackageController;

Route::get('/app-demo-package', [DemoPackageController::class, 'index']);


// Route using the package controller
Route::get('/demo', [DemoController::class, 'index']);

// Optional: simple route directly to view
Route::get('/demo-view', function () {
    return view('demopackage::index'); // loads published package view
});

```



## STEP 14: Run Server

### Publish Package Assets

Before running the server, publish your package’s config and views to the main Laravel project:

```
php artisan vendor:publish --tag=demopackage

```

What this does:

Copies packages/DemoVendor/DemoPackage/config/demopackage.php → config/demopackage.php

Copies package views → resources/views/vendor/demopackage/

 This ensures your main project can use the package’s config and views

### Start the Laravel Development Server:

```
php artisan serve

```

### This starts the server at:

```
 http://127.0.0.1:8000

```
### Test the Package

Open these URLs in your browser:

```
URL	What it does
/demo	Loads the package controller (DemoController)
/demo-view	Loads the package view directly (index.blade.php)
/demo-package	Optional: Loads the app controller (DemoPackageController)

```

## So you can see this type output:

### Run php artisan vendor:publish --tag=demopackage then:


<img width="1914" height="235" alt="Screenshot 2026-02-02 125534" src="https://github.com/user-attachments/assets/1f02b466-665d-4cb2-8d90-a9c676a2d212" />


### /demo → Shows the message from package config:


<img width="1919" height="867" alt="Screenshot 2026-02-02 125450" src="https://github.com/user-attachments/assets/44719344-f66b-4c10-bd56-5524b5f34cc2" />


### /demo-view → Same as above (direct view rendering).

<img width="1915" height="907" alt="image" src="https://github.com/user-attachments/assets/a3ec1196-20ed-4d48-87ce-5858fa175a3f" />



### /app-demo-package → Shows text:


<img width="1919" height="881" alt="image" src="https://github.com/user-attachments/assets/1b8e108d-b487-4b4a-911a-97a36adc1d16" />



---

# Project Folder Structure:

```

PHP_Laravel12_Create_Custome_Package/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── DemoPackageController.php       <-- Optional app controller
│   │   ├── Middleware/
│   │   └── Kernel.php
│   ├── Models/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
├── packages/
│   └── DemoVendor/
│       └── DemoPackage/
│           ├── composer.json                   <-- Package composer
│           ├── config/
│           │   └── demopackage.php             <-- Package config
│           ├── routes/
│           │   └── web.php                     <-- Package routes
│           ├── resources/
│           │   └── views/
│           │       └── index.blade.php        <-- Package view
│           └── src/
│               ├── Controllers/
│               │   └── DemoController.php     <-- Package controller
│               ├── Providers/
│               │   └── DemoPackageServiceProvider.php   <-- Service provider
│               └── helpers.php
├── public/
├── resources/
├── routes/
│   └── web.php                                 <-- Main project routes
├── storage/
├── tests/
├── vendor/
├── artisan
├── composer.json
└── .env
```
