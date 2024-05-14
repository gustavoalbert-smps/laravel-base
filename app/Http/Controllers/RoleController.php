<?php

namespace App\Http\Controllers;

use App\Models\Permissions\Group;
use App\Models\Permissions\Permission;
use App\Models\Permissions\Role;
use Illuminate\Http\Request;

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
                'label' => $group->name,
            ];

            $permissions = Permission::where('group_id', $group->id)->get();
            
            foreach ($permissions as $permission) {
                $data[$group->id]['childs'][] = [
                    'label' => $permission->display_name,
                    'name'  => 'permissions[]',
                    'value' => $permission->id
                ];
            }
        }

        return view('admin.role.edit', compact('role','data'));
    }

    public function update($id, Request $request) 
    {
        $role = Role::findOrFail($id);
        
        $permissions = $request->has('permissions') ? array_map('intval',$request->permissions) : [];
        $role->permissions()->sync($permissions);

        return redirect()->route('admin');
    }
}
