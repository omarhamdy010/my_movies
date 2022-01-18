<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{

    public function index(Request $request)
    {

        return view('dashboard.users.index');

    }

    public function ajax(Request $request)
    {



        if ($request->ajax()) {

            $data = User::where('id', '<>', auth()->user()->id)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $actionBtn1= '';
                    $actionBtn= '';
                    if (auth()->user()->hasPermission('users_update')) {
                        $actionBtn1 = '<a href="users/' . $row->id . '/edit"  class="edit btn btn-success btn-sm">Edit</a>';
                    }
                    if (auth()->user()->hasPermission('users_delete')) {
                        $actionBtn = '<a   href="users/' . $row->id . '"  class="delete btn btn-danger btn-sm">Delete</a>';
                    }
                    return $actionBtn1 . ' ' . $actionBtn;

                })->addColumn('image', function ($artist) {
                    $url = $artist->image_path;
                    return '<img src="' . $url . '" border="0" width="100" class="img-rounded" align="center" />';
                })->rawColumns(['actions','image'])
                       ->make(true);

        }
    }

    public function create(User $users)
    {
        $permissions = Permission::all();
        return view('dashboard.users.create', compact('users', 'permissions'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required:unique',
            'name' => 'required',
            'password' => 'required|min:8',
            'permissions' => 'required'
        ]);

        $data = $request->except(['password', 'permissions', 'image']);
        $data['password'] = bcrypt($request->password);

        if ($request->image)
        {
            $img = Image::make($request->image);
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/upload/users/'. $request->image->hashName())

            );

            $data['image']= $request->image->hashName();

        }

        $user = User::create($data);

        $user->attachRole('admin');

        $user->permissions()->sync($request->permissions);

        Session()->flash('success', 'added successfully');

        return redirect()->route('users.index');

    }

    public function edit(User $user)
    {

        $permissions = Permission::all();

        return view('dashboard.users.edit', compact('user', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required:unique',
            'name' => 'required',
            'permissions' => 'required'
        ]);
        $data = $request->except(['permissions']);

        if ($user->image!= 'default.png')
        {
            Storage::disk('public_upload')->delete('/users/'.$user->image);
        }
        if ($request->image)
        {
            $img = Image::make($request->image);
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/upload/users/'. $request->image->hashName())
            );

            $data['image']= $request->image->hashName();
        }
        $user->update($data);

        $user->permissions()->sync($request->permissions);

        Session()->flash('success', 'edit successfully');

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->image!= 'default.png')
        {
            Storage::disk('public_upload')->delete('/users/'.$user->image);
        }
        $user->delete();

        Session()->flash('success', 'deleted successfully');

        return redirect()->route('users.index');
    }
}
