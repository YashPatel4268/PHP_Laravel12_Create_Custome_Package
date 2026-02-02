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
