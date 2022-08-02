<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','show']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('roles.index',[
            'roles' => Role::all(),
            'title' => 'Halaman Role'
        ]);
    }

    public function show(Role $role)
    {
        return view();
    }

    public function create()
    {
        return view('roles.create', [
            'permissions' => Permission::get(),
            'title' => 'Buat Role'
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => request('name')]);
        $role->syncPermissions(request('permission'));

        toast('Data role berhasil ditambahkan!','success');
        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }

    public function edit(Role $role)
    {
        return view('roles.edit', [
            'role' => $role,
            'permissions' => Permission::get(),
            'title' => 'Edit Role',
        ]);
    }

    public function update(Role $role)
    {
        request()->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permission' => 'required',
        ]);

        $role->update(['name' => request('name')]);
        $role->syncPermissions(request('permission'));

        toast('Data role berhasil diedit!','success');
        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        toast('Data role berhasil dihapus!','success');
        return back();
    }
}
