<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use illuminate\support\Str;
use App\Models\Role;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Roles;
use App\Http\Requests\Backend\SupervisorRequest;
use App\Http\Requests\Backend\UserGroupRequest;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermissions;
use Illuminate\Http\Request;

class UserGroupsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_user_groups , show_user_groups')) {
            return redirect('admin/index');
        }

        $user_groups = Role::where('name', 'users')
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.user_groups.index', compact('user_groups'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_user_groups')) {
            return redirect('admin/index');
        }

        $permissions = Permission::tree();


        return view('backend.user_groups.create',compact('permissions'));
    }

    public function store(UserGroupRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_user_groups')) {
            return redirect('admin/index');
        }


        // $input['name'] = strtolower(str_replace(' ', '_', $request->display_name)); // Convert "Admin Group" to "admin_group"
        $input['name'] = 'users'; // Convert "Admin Group" to "admin_group"
        $input['display_name'] = $request->display_name;
        $input['description'] = $request->description;
        $input['allowed_route'] = 'admin';

        $user_groups = Role::create($input);

         // Attach the checked permissions to the role
        if ($request->has('permissions')) {
            $user_groups->attachPermissions($request->permissions);
        }



        return redirect()->route('admin.user_groups.index')->with([
            'message' => 'created successfully',
            'alert-type' => 'success'
        ]);
    }

    public function show(Role $user_group)
    {
        if (!auth()->user()->ability('admin', 'display_user_groups')) {
            return redirect('admin/index');
        }
        return view('backend.user_groups.show', compact('user_group'));
    }

    public function edit(Role $user_group)
    {
        if (!auth()->user()->ability('admin', 'update_user_groups')) {
            return redirect('admin/index');
        }

        return view('backend.user_groups.edit', compact('user_group'));
    }

    public function update(UserGroupRequest $request, Role $user_group)
    {
        if (!auth()->user()->ability('admin', 'update_user_groups')) {
            return redirect('admin/index');
        }


        $input['name'] = "users";
        $input['display_name'] = $request->display_name;
        $input['description'] = $request->description;
        $input['allowed_route'] = 'admin';


        $user_group->update($input);


        return redirect()->route('admin.user_groups.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(Role $user_group)
    {
        if (!auth()->user()->ability('admin', 'delete_user_groups')) {
            return redirect('admin/index');
        }

        $user_group->delete();

        return redirect()->route('admin.user_groups.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
