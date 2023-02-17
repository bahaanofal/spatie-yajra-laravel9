<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PermissionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PermissionsDataTable $dataTable)
    {
        $this->authorize('viewAny', Permission::class);
        return $dataTable->render('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Permission::class);
        $permission = new Permission();
        return view('admin.permissions.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
            'guard_name' => 'nullable',
        ]);
        Permission::create(['name' => $request->name]);
        return redirect(route('admin.permissions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        $this->authorize('view', $permission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $this->authorize('update', $permission);
        return view('admin.permissions.edit', [
            'permission' => $permission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $this->authorize('update', $permission);
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,'.$id],
            'guard_name' => 'nullable',
        ]);
        $guard = $request->guard_name ?? 'web';
        $permission->update(['name' => $request->name, 'guard_name' => $guard]);
        return redirect(route('admin.permissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $this->authorize('delete', $permission);
        $permission->delete();
        return redirect(route('admin.permissions.index'));
    }
}
