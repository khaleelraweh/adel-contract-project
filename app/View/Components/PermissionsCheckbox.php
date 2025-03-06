<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Permission;

class PermissionsCheckbox extends Component
{
    public $permission;
    public $assignedPermissions;

    /**
     * Create a new component instance.
     *
     * @param Permission $permission
     * @param array $assignedPermissions
     */
    public function __construct($permission, $assignedPermissions = [])
    {
        $this->permission = $permission;
        $this->assignedPermissions = $assignedPermissions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.permissions-checkbox');
    }
}
