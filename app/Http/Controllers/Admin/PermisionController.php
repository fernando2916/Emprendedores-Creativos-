<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermisionController extends Controller
{
    //
    public function index()
    {
        $permissions = Permission::orderBy('id', 'asc')->paginate(10);
        return view('admin.permisos.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permisos.create');
    }

    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required|unique:permissions,name|string'
        ]);

        Permission::create([
            'name' => $request->name,
        ]);

         session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Permiso creado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.permissions.index');

    }

    public function edit(Permission $permission)
    {

        return view('admin.permisos.edit', compact('permission'));
        
    }
    
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

         session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Permiso actualizado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.permissions.index');

    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

         session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Permiso Eliminado correctamente',
            'background' => '#120024',
            'color' => '#ffffff',
        ]);

        return redirect()->route('admin.permissions.index');

    }
}