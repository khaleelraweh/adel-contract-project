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

        // Fetch the user to be edited
        $user = User::where('id', $user)->first();

        // Fetch all users with the role 'users'
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'users');
        })->get(['id', 'first_name', 'last_name']);

        // Fetch roles with the name 'users'
        $roles = Role::where('name', 'users')->get(['id', 'display_name']);

            // Fetch the IDs of roles assigned to the user
        $assignedRoles = $user->roles->pluck('id')->toArray();


        // Fetch permissions in a tree structure
        $permissions = Permission::tree();

        return view('backend.user_permissions.edit', compact('user', 'users', 'assignedRoles','roles', 'permissions'));
    }

    public function update(Request $request,  $user)
    {
        if (!auth()->user()->ability('admin', 'update_user_permissions')) {
            return redirect('admin/index');
        }

        $user = User::where('id', $user)->first();

        //add roles
        if (isset($request->roles) && count($request->roles) > 0) {
             $user->roles()->sync($request->roles);
         }


        return redirect()->route('admin.user_permissions.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy($user)
    {
        if (!auth()->user()->ability('admin', 'delete_user_permissions')) {
            return redirect('admin/index');
        }

        // Fetch the user to be deleted
        $user = User::where('id', $user)->first();

        if ($user) {
            // Check if the user has an image and if the file exists
            if ($user->user_image && File::exists('assets/users/' . $user->user_image)) {
                // Ensure that $user->user_image is a file, not a directory
                if (is_file('assets/users/' . $user->user_image)) {
                    unlink('assets/users/' . $user->user_image);
                } else {
                    // Log or handle the case where $user->user_image is a directory
                    \Log::warning("Attempted to delete a directory instead of a file: assets/users/{$user->user_image}");
                }
            }

            // Delete the user from the database
            $user->delete();

            return redirect()->route('admin.user_permissions.index')->with([
                'message' => 'Deleted successfully',
                'alert-type' => 'success'
            ]);
        }

        // If the user doesn't exist, redirect with an error message
        return redirect()->route('admin.user_permissions.index')->with([
            'message' => 'User not found',
            'alert-type' => 'error'
        ]);
    }

}
