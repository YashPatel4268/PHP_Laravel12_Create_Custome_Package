<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use DemoVendor\DemoPackage\Controllers\DemoController;

// =====================================
// MAIN PACKAGE ROUTE (WITH LOGGER)
// =====================================
Route::get('/demo-package', [DemoController::class, 'index'])
    ->middleware('demopackage.log');


// =====================================
// DIRECT VIEW ROUTE
// =====================================
Route::get('/demo-view', function () {
    return view('demopackage::index');
});


// =====================================
// FEATURE 2: UPDATE MESSAGE
// =====================================
Route::get('/demo-update-message/{msg}', function ($msg) {

    $path = config_path('demopackage.php');

    $config = config('demopackage');

    $config['message'] = $msg;

    File::put($path, '<?php return ' . var_export($config, true) . ';');

    return "Message updated successfully: " . $msg;
});


// =====================================
// ⭐ FEATURE 3: CHANGE THEME VIA URL
// =====================================
Route::get('/demo-package/theme/{theme}', function ($theme) {

    $path = config_path('demopackage.php');

    $config = config('demopackage');

    $config['theme'] = $theme;

    File::put($path, '<?php return ' . var_export($config, true) . ';');

    return "Theme updated to: " . $theme;
});


// =====================================
// ⭐ FEATURE 4: CHANGE FONT SIZE VIA URL
// =====================================
Route::get('/demo-package/font/{size}', function ($size) {

    $path = config_path('demopackage.php');

    $config = config('demopackage');

    $config['font_size'] = $size;

    File::put($path, '<?php return ' . var_export($config, true) . ';');

    return "Font size updated to: " . $size;
});