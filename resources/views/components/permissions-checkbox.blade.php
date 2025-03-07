<div class="permission-group">
    <!-- Parent Permission Checkbox -->
    <div class="permission-title">
        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
               id="permission_{{ $permission->id }}" class="parent-checkbox"
               {{ in_array($permission->id, $assignedPermissions) ? 'checked' : '' }} />
        <label class="fw-bold" for="permission_{{ $permission->id }}">
            {{ $permission->display_name }}
        </label>
    </div>

    <!-- Child Permissions -->
    @if ($permission->children->count() > 0)
        <ul class="child-permissions" style="list-style-type:none; padding-left: 20px;">
            @foreach ($permission->children as $childPermission)
                <li>
                    <!-- Recursively render child permissions -->
                    <x-permissions-checkbox :permission="$childPermission" :assignedPermissions="$assignedPermissions" />
                </li>
            @endforeach
        </ul>
    @endif
</div>
