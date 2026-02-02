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
