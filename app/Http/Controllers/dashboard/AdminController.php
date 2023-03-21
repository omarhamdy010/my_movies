<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
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

    public function index(Request $request)
    {
        return view('dashboard.Admins.index');

    }

    public function ajax(Request $request)
    {



        if ($request->ajax()) {

            $data = Admin::whereHas(
                'roles', function($q){
                $q->where('name', 'admin');
            }
            )->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $actionBtn1= '';
                    $actionBtn= '';
                    if (Auth::guard('admin')->user()->hasPermission('admins_update')) {
                        $actionBtn1 = '<a href="admins/' . $row->id . '/edit"  class="edit btn btn-success btn-sm">Edit</a>';
                    }
                    if (Auth::guard('admin')->user()->hasPermission('admins_delete')) {
                        $actionBtn = '<a href="admins/' . $row->id . '"  class="delete btn btn-danger btn-sm">Delete</a>';
                    }
                    return $actionBtn1 . ' ' . $actionBtn;

                })->addColumn('image', function ($artist) {
                    $url = $artist->image_path;
                    return '<img src="' . $url . '" border="0" width="100" class="img-rounded" align="center" />';
                })->rawColumns(['actions','image'])
                ->make(true);

        }
    }

    public function create(Admin $admins)
    {
        $permissions = Permission::all();

        return view('dashboard.admins.create', compact('admins', 'permissions'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required:unique',
            'name' => 'required',
            'password' => 'required|min:8',
        ]);

        $data = $request->except(['password', 'permissions', 'image']);
        $data['password'] = bcrypt($request->password);

        if ($request->image)
        {
            $img = Image::make($request->image);
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/upload/admins/'. $request->image->hashName())

            );

            $data['image']= $request->image->hashName();

        }

        $admin = Admin::create($data);

        $admin->attachRole('admin');

        $admin->permissions()->sync($request->permissions);

        Alert::success('success', 'You\'ve Successfully created');

        return redirect()->route('admins.index');

    }

    public function edit(Admin $admin)
    {

        $permissions = Permission::all();

        return view('dashboard.admins.edit', compact('admin', 'permissions'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'email' => 'required:unique',
            'name' => 'required',
        ]);
        $data = $request->except(['permissions']);

        if ($admin->image!= 'default.png')
        {
            Storage::disk('public_upload')->delete('/admins/'.$admin->image);
        }
        if ($request->image)
        {
            $img = Image::make($request->image);
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/upload/admins/'. $request->image->hashName())
            );

            $data['image']= $request->image->hashName();
        }
        $admin->update($data);

        $admin->permissions()->sync($request->permissions);

        Alert::success('success', 'You\'ve Successfully updated');

        return redirect()->route('admins.index');
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        if ($admin->image!= 'default.png')
        {
            Storage::disk('public_upload')->delete('/admins/'.$admin->image);
        }
        $admin->delete();

        Alert::success('success', 'You\'ve Successfully deleted');

        return redirect()->route('admins.index');
    }



}
