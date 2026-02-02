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
