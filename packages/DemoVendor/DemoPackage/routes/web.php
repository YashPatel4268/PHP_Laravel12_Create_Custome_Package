<?php

use DemoVendor\DemoPackage\Controllers\DemoController;

Route::get('/demo-package', [DemoController::class, 'index']);
