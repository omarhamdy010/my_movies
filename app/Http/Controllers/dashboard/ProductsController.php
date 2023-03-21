<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Images;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class ProductsController extends Controller
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
        return view('dashboard.products.index');
    }

    public function proajax(Request $request)
    {
        $data = Product::latest()->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $actionBtn1 = '';
                $actionBtn = '';
                if (Auth::guard('admin')->user()->hasPermission('product_update')) {

                    $actionBtn1 = '<a href="products/' . $row->id . '/edit"  class="edit btn btn-success btn-sm">Edit</a>';
                }
                if (Auth::guard('admin')->user()->hasPermission('product_delete')) {
                    $actionBtn = '<a   href="products/' . $row->id . '"  class="delete btn btn-danger btn-sm deleteProduct">Delete</a>';
                }
                return $actionBtn1 . '' . $actionBtn;

            })->addColumn('image', function ($artist) {
                $url = $artist->images()->first()->image_path;
                return '<img src="' . $url . '" border="0" width="100" class="img-rounded" align="center" />';
            })->editColumn('category_id', function ($row) {
                return $row->category->name;
            })
            ->rawColumns(['image', 'actions'])
            ->make(true);
    }

    public function create(Product $products)
    {
        $categories = Category::all();

        return view('dashboard.products.create', compact('products', 'categories'));
    }

    public function store(Request $request, Product $Product)
    {
        $request->validate([

            'ar.*' => 'required|unique:category_translations,name',
            'en.*' => 'required|unique:category_translations,name',
            'category_id' => 'required',
            'price'=>'required',
            'description'=>'required',
            'amount'=>'required',

        ]);

        $data = $request->except('images');

        $product = $Product->create($data);

        if (!$request->images) {

            Images::create([
                'name' => 'default.png',
                'product_id' => $product->id,
            ]);

            return redirect()->route('products.index');
        }
        $images = $request->images;

        foreach ($images as $image) {

            $name = $image->getClientOriginalName();

            $path = $image->storeAs('products', $name, 'public_upload');

            Images::create([
                'name' => $name,
                'path'=>'public/'.$path,
                'product_id' => $product->id,
            ]);
        }
        return redirect()->route('products.index');

    }

    public function edit($id)
    {

        $categories = Category::all();

        $Product = Product::find($id);

        Session()->flash('success', 'edit successfully');

        return view('dashboard.products.edit', compact('Product', 'categories'));

    }

    public function cart()
    {
        return view('front.site.cart');
    }

    public function update(Request $request, Product $Product)
    {

        $request->validate([

            'ar.*' => 'required|unique:category_translations,name',
            'en.*' => 'required|unique:category_translations,name',
            'category_id' => 'required',
            'price'=>'required',
            'description'=>'required',
            'amount'=>'required',

        ]);
        $data = $request->except('images');

        $Product->update($data);

        foreach ($Product->images as $Products) {

            if ($Products->name != 'default.png') {

                Storage::disk('public_upload')->delete('/products/' . $Products->name);

            }

            $Products->delete();
        }
        if (!$request->images) {

            Images::create([
                'name' => 'default.png',
                'product_id' => $Product->id,
            ]);

            return redirect()->route('products.index');
        }
        $images = $request->images;

        foreach ($images as $image) {

            $name = $image->getClientOriginalName();

            $path = $image->storeAs('products', $name, 'public_upload');

            Images::create([
                'name' => $name,
                'product_id' => $Product->id,
            ]);
        }
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $Products = Product::with('images')->find($id);

        foreach ($Products->images as $image) {
            if ($image->name != 'default.png') {

                Storage::disk('public_upload')->delete('/products/' . $image->name);

            }

        }

        $Products->delete();


        return redirect()->route('products.index');
    }


}
