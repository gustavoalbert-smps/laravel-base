<?php

namespace App\Http\Controllers;

use App\Models\Permissions\Group;
use App\Models\Permissions\Permission;
use App\Models\Permissions\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permission-edit', ['only' => ['edit']]);
    }

    public function edit($id) 
    {
        $role = Role::findOrFail($id);

        $groups = Group::all();
        $data = [];

        foreach ($groups as $group) {
            $data[$group->id] = [ 
                'text' => $group->name,
                'expanded' => true,
                'icon' => 'bi bi-dash-square-dotted'
            ];

            $permissions = Permission::where('group_id', $group->id)->get();
            
            foreach ($permissions as $permission) {
                $data[$group->id]['nodes'][] = [
                    'text' => $permission->display_name,
                    'icon' => 'bi bi-dash-square-dotted'
                ];
            }
        }

        return view('admin.role.edit', compact('role','data'));
    }
}
