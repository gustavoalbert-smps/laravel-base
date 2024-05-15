<?php

namespace App\Http\Controllers;

use App\Models\Permissions\Group;
use App\Models\Permissions\Permission;
use App\Models\Permissions\PermissionRole;
use App\Models\Permissions\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permission-edit', ['only' => ['edit','update']]);
    }

    public function edit($id) 
    {
        $role = Role::findOrFail($id);
        $groups = Group::all();
        $rolePermissions = PermissionRole::where('role_id',$role->id)->get()->pluck('permission_id');
        $allPermissions = Permission::all()->pluck('id');

        $data = [];

        foreach ($groups as $group) {
            if (!empty($group->parent_id)) {
                $sequence = $this->getSequenceGroupIds($group);

                $permissions = Permission::where('group_id', $group->id)->get();
                $permissionsArray = [];
                foreach ($permissions as $permission) {
                    $permissionsArray[] = [
                        'label' => $permission->display_name,
                        'name'  => 'permissions[]',
                        'value' => $permission->id
                    ];
                }

                $subgroupData = [
                    'id' => $group->id,
                    'label' => $group->name,
                ];

                $this->addSubgroup($data, $sequence, $subgroupData, $permissionsArray);
            } else {
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
        }

        return view('admin.role.edit', compact('role','data','rolePermissions','allPermissions'));
    }

    public function update($id, Request $request) 
    {
        $role = Role::findOrFail($id);
        
        $permissions = $request->has('permissions') ? array_map('intval',$request->permissions) : [];
        $role->permissions()->sync($permissions);

        return redirect()->route('admin');
    }

    public function addSubgroup(&$data, $sequence, $subgroupData, $permissions) {
        $current = &$data;
        foreach ($sequence as $seq) {
            if (isset($seq['group'])) {
                if (!isset($current[$seq['group']])) {
                    $current[$seq['group']] = ['subgroups' => []];
                }
                $current = &$current[$seq['group']]['subgroups'];
            } elseif (isset($seq['subgroup'])) {
                if (!isset($current[$seq['subgroup']])) {
                    $current[$seq['subgroup']] = ['subgroups' => []];
                }
                $current = &$current[$seq['subgroup']]['subgroups'];
            }
        }
    
        $current[$subgroupData['id']] = [
            'label' => $subgroupData['label'],
            'childs' => $permissions
        ];
    }

    public function getSequenceGroupIds($group) {
        $sequence = [];
        $parent = $group->parent;

        while (!empty($parent)) {
            if (!empty($parent->parent_id))
                array_unshift($sequence, ['subgroup' => $parent->id]);
            else
                array_unshift($sequence, ['group' => $parent->id]);
            $parent = $parent->parent;
        }

        return $sequence;
    }
}
