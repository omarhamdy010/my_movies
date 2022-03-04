<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
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

        return view('dashboard.users.index');

    }

    public function ajax(Request $request)
    {


        if ($request->ajax()) {

            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $actionBtn = '';
                    if (Auth::guard('admin')->user()->hasPermission('user_delete')) {
                        $actionBtn = '<a   href="users/' . $row->id . '"  class="delete btn btn-danger btn-sm">Delete</a>';
                    }
                    return $actionBtn;
                })->addColumn('image', function ($artist) {
                    $url = $artist->image_path;
                    return '<img src="' . $url . '" border="0" width="100" class="img-rounded" align="center" />';
                })->rawColumns(['actions', 'image'])
                ->make(true);

        }
    }

    public function create(User $users)
    {
        $permissions = Permission::all();
        return view('dashboard.users.create', compact('users', 'permissions'));

    }


    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->image != 'default.png') {
            Storage::disk('public_upload')->delete('/users/' . $user->image);
        }
        $user->delete();

        Alert::success('success', 'You\'ve Successfully deleted');

        return redirect()->route('users.index');
    }
}
