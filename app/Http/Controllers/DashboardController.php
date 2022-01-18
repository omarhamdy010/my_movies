<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users =User::count();
        $category =Category::count();
        $product =Product::count();
        return view('dashboard.index' , compact('users', 'category','product'));
    }

    public function handleAdmin()
    {
        return view('handelAdmin');
    }
}
