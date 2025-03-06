<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use illuminate\support\Str;
use App\Models\Role;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SupervisorRequest;
use App\Models\Permission;
use App\Models\RoleUsers;
use App\Models\User;
use App\Models\UserPermissions;
use Illuminate\Http\Request;

class UserPermissionsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability(['admin', 'supervisor', 'users'], 'manage_user_permissions , show_user_permissions')) {
            return redirect('admin/index');
        }

        // Get RoleUsers where the role is 'users'
        $role_users = User::whereHas('roles', function ($query) {
            $query->where('name', 'users');
        })->with('roles')->get();


        return view('backend.user_permissions.index', compact('role_users'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_user_permissions')) {
            return redirect('admin/index');
        }

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'users');
        })->get(['id', 'first_name', 'last_name']);

        $roles = Role::where('name', 'users')->get(['id', 'display_name']);

        $permissions = Permission::tree();



        return view('backend.user_permissions.create', compact('roles', 'permissions','users'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->ability('admin', 'create_user_permissions')) {
            return redirect('admin/index');
        }


        $user = User::where('id', $request->user_id)->first();


           //add roles
           if (isset($request->roles) && count($request->roles) > 0) {
                $user->roles()->sync($request->roles);
            }



        // if (isset($request->user_groups) && count($request->user_groups) > 0) {
        //     $supervisor->roles()->sync($request->user_groups);
        // }

        // dd($request->user_groups[0]);

        // if (isset($request->all_permissions)) {
        //     $permissions = Permission::get(['id']);
        //     $supervisor->permissions()->sync($permissions);
        // } else if (isset($request->permissions) && count($request->permissions) > 0) {
        //     $supervisor->permissions()->sync($request->permissions);
        // }



        return redirect()->route('admin.user_permissions.index')->with([
            'message' => 'created successfully',
            'alert-type' => 'success'
        ]);
    }

    public function show(User $supervisor)
    {
        if (!auth()->user()->ability('admin', 'display_user_permissions')) {
            return redirect('admin/index');
        }
        return view('backend.user_permissions.show', compact('supervisor'));
    }

    public function edit($user)
    {
        if (!auth()->user()->ability('admin', 'update_user_permissions')) {
            return redirect('admin/index');
        }

        $user = User::where('id', $user)->first();


        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'users');
        })->get(['id', 'first_name', 'last_name']);

        $roles = Role::where('name', 'users')->get(['id', 'display_name']);

        $permissions = Permission::tree();


        return view('backend.user_permissions.edit', compact('users', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->ability('admin', 'update_user_permissions')) {
            return redirect('admin/index');
        }

        $input['first_name'] = $request->first_name;
        $input['last_name'] = $request->last_name;
        $input['username'] = $request->username;
        $input['email'] = $request->email;
        $input['mobile'] = $request->mobile;
        if (trim($request->password) != '') {
            $input['password'] = bcrypt($request->password);
        }
        $input['status'] = $request->status;
        $input['updated_by'] = auth()->user()->full_name;


        if ($image = $request->file('user_image')) {

            if ($supervisor->user_image != null && File::exists('assets/users/' . $supervisor->user_image)) {
                unlink('assets/users/' . $supervisor->user_image);
            }

            $manager = new ImageManager(new Driver());
            $file_name = Str::slug($request->username) . '_' . time() .  "." . $image->getClientOriginalExtension();
            $img = $manager->read($request->file('user_image'));
            // $img = $img->resize(370, 246);
            $img->toJpeg(80)->save(base_path('public/assets/users/' . $file_name));


            $input['user_image'] = $file_name;
        }

        $supervisor->update($input);
        //update permission
        //add permissions

        // if (isset($request->all_permissions)) {
        //     $permissions = Permission::get(['id']);
        //     $supervisor->permissions()->sync($permissions);
        // } else if (isset($request->permissions) && count($request->permissions) > 0) {
        //     $supervisor->permissions()->sync($request->permissions);
        // }

        if (isset($request->user_groups) && count($request->user_groups) > 0) {
            $supervisor->roles()->sync($request->user_groups);
        }

        return redirect()->route('admin.user_permissions.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(User $supervisor)
    {
        if (!auth()->user()->ability('admin', 'delete_user_permissions')) {
            return redirect('admin/index');
        }

        // first: delete image from users path
        if (File::exists('assets/users/' . $supervisor->user_image)) {
            unlink('assets/users/' . $supervisor->user_image);
        }
        //second : delete supervisor from users table
        $supervisor->delete();

        return redirect()->route('admin.user_permissions.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_user_permissions')) {
            return redirect('admin/index');
        }

        $supervisor = User::findOrFail($request->supervisor_id);
        if (File::exists('assets/users/' . $supervisor->user_image)) {
            unlink('assets/users/' . $supervisor->user_image);
            $supervisor->user_image = null;
            $supervisor->save();
        }
        if ($supervisor->user_image != null) {
            $supervisor->user_image = null;
            $supervisor->save();
        }

        return true;
    }

    public function updateuser_permissionstatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            User::where('id', $data['supervisor_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'supervisor_id' => $data['supervisor_id']]);
        }
    }
}
