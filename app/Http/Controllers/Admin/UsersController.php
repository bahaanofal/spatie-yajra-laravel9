<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewUserCreatedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        $this->authorize('viewAny', User::class);
        return $dataTable->render('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $user = new User();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.users.create', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'userRoles' => [],
            'userPermissions' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'image_path' => 'nullable|image',
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $request->merge([
            'password' => Hash::make('password'),
        ]);

        $data = $request->all();
        $user = User::create($data);

        $image_path = null;
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $image_path = $file->storeAs('users/images', $user->id . '.' . $file->getClientOriginalExtension() , [
                'disk' => 'public'
            ]);
            $data['image_path'] = $image_path;
        }

        $user->update($data);

        event(new Registered($user));
        $user->assignRole($request->roles);
        $user->givePermissionTo($request->permissions);

        $resevedUser = User::where('email', '=', 'bahaa2000no@gmail.com')->first();
        $resevedUser->notify(new NewUserCreatedNotification($user));

        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $roles = Role::all();
        $permissions = Permission::all();
        $userRoles = [];
        $userPermissions = [];
        foreach ($user->roles as $role) {
            $userRoles[$role->id] = $role->id;
        };
        foreach ($user->permissions as $permission) {
            $userPermissions[$permission->id] = $permission->id;
        };
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'userRoles' => $userRoles,
            'userPermissions' => $userPermissions,
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
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'image_path' => 'nullable|image',
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $data = $request->all();

        $image_path = null;
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $image_path = $file->storeAs('users/images', $user->id . '.' . $file->getClientOriginalExtension(), [
                'disk' => 'public'
            ]);
            $data['image_path'] = $image_path;
        }

        $user->update($data);
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);
        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();
        Storage::disk('public')->delete($user->image_path);
        return redirect(route('admin.users.index'));
    }
}
