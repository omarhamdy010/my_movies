<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request,$next){
            if (session('success')) {
                Alert::success(session('success'));
            }

            if (session('error')) {
                Alert::error(session('error'));
            }

            return $next($request);
        });
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
