<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    public function index()
    {
        $roles = Role::orderBy('id', 'asc')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
            // 'permissions.*' => 'exists:permissions,id',
        ]);


        $role = Role::create([
            'name' => $request->name
        ]);

        // $role->syncPermissions($request->permissions);
        $role->permissions()->attach($request->permissions);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol creado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array',
            // 'permissions.*' => 'exists:permissions:id',
        ]);

        $role->update([
            'name' => $request->name
        ]);

        // $role->syncPermissions($request->permissions);
        $role->permissions()->sync($request->permissions);


        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol actualizado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol eliminado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.roles.index');
    }
}