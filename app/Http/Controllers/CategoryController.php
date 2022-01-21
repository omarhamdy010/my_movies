<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
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
        return view('dashboard.categories.index');
    }

    public function catajax(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn1= '';
                    $actionBtn= '';
                    if (auth()->login(Admin::all())->hasPermission('category_update')) {

                        $actionBtn1 = '<a href="categories/' . $row->id . '/edit" class="edit btn btn-success btn-sm">Edit</a>';
                    }
//                    if (auth()->user()->hasPermission('category_delete')) {

                        $actionBtn = '<a href="categories/' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
//                    }
                    return $actionBtn1 . '  ' . $actionBtn;
                })->addColumn('image', function ($artist) {
                    $url = $artist->image_path;
                    return '<img src="' . $url . '" border="0" width="100" class="img-rounded" align="center" />';
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
    }

    public function create(Category $categories)
    {

        return view('dashboard.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ar.*' => 'required | unique:category_translations,name',
            'en.*' => 'required | unique:category_translations,name',
        ]);
        $data = $request->except('image');
        if ($request->image) {
            Image::make($request->image)->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/upload/categories/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }

        $category = Category::create($data);

        Alert::success('success', 'You\'ve Successfully created');


        return redirect()->route('categories.index');

    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'ar.*' => 'required | unique:category_translations,name',
            'en.*' => 'required | unique:category_translations,name',
        ]);
        $data = $request->all();

        if ($category->image != 'default.png')
        {
            Storage::disk('public_upload')->delete('categories/' . $category->image);
        }

        if ($request->image)
        {
            Image::make($request->image)->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/upload/categories/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }
        $category->update($data);

        Alert::success('success', 'You\'ve Successfully updated');

        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category->image != 'default.png')
        {
            Storage::disk('public_upload')->delete('categories/' . $category->image);
        }

        $category->delete();

        Alert::success('success', 'You\'ve Successfully deleted');

        return redirect()->route('categories.index');

    }
}
