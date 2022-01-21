<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin','auth:user']);
    }
    public function index()
    {
        $users =User::count();
        $category =Category::count();
        $product =Product::count();
        $admin =Admin::count();
        return view('dashboard.index' , compact('admin','users', 'category','product'));
    }

    public function handleAdmin()
    {
        return view('handelAdmin');
    }
}
