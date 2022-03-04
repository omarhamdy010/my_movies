<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $data = Category::latest()->with('parent')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn1 = '';
                    $actionBtn = '';
                    if (Auth::guard('admin')->user()->hasPermission('category_update')) {

                        $actionBtn1 = '<a href="categories/' . $row->id . '/edit" class="edit btn btn-success btn-sm">Edit</a>';
                    }
                    if (Auth::guard('admin')->user()->hasPermission('category_delete')) {

                        $actionBtn = '<a href="categories/' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    }
                    return $actionBtn1 . '  ' . $actionBtn;
                })->addColumn('image', function ($row) {
                    $url = $row->image_path;
                    return '<img src="' . $url . '" border="0" width="100" class="img-rounded" align="center" />';
                })->addColumn('parent_category', function ($row) {
                    return $row->parent  ?  $row->parent->name : 'None' ;
                })->rawColumns(['action', 'image', 'parent_category'])->make(true);
        }
    }

    public function create()
    {
        $categories = Category::all();
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
        Category::create($data);

        if ($request->parent_category) {

            $category = new Subcategory();

            $category->category_id = $request->parent_category;

            if ($category->save())
            {

                return redirect()->route('categories.index')->with(['success' => 'Category added successfully.']);
            }

            return redirect()->back()->with(['fail' => 'Unable to add category.']);

        }
        Alert::success('success', 'You\'ve Successfully created');


        return redirect()->route('categories.index');

    }

    public function edit(Category $category)
    {
        $categories = Category::all();

        return view('dashboard.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'ar.*' => 'required | unique:category_translations,name',
            'en.*' => 'required | unique:category_translations,name',
        ]);
        $data = $request->all();

        if ($category->image != 'default.png') {
            Storage::disk('public_upload')->delete('categories/' . $category->image);
        }

        if ($request->image) {
            Image::make($request->image)->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/upload/categories/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }
        $category->update($data);
        if ($request->parent_category) {

            $category = new Subcategory();

            $category->category_id = $request->parent_category;

            if ($category->save()) {

                Alert::success('success', 'You\'ve Successfully updated');

                return redirect()->route('categories.index');
            }

            return redirect()->back()->with(['fail' => 'Unable to update category.']);
        }

        Alert::success('success', 'You\'ve Successfully updated');

        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category->image != 'default.png') {
            Storage::disk('public_upload')->delete('categories/' . $category->image);
        }

        $category->delete();


        Alert::success('success', 'You\'ve Successfully deleted');

        return redirect()->route('categories.index');

    }
}
