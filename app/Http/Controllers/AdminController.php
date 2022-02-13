<?php

namespace App\Http\Controllers;

use App\Jobs\ExportCategories;
use App\Jobs\ImportCategories;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function admin () {
        return view('admin.admin');
    }

    public function users () {
        $users = User::get();
        $roles = Role::get();

        $data = [
            'title' => 'Список пользователей',
            'users' => $users,
            'roles' => $roles
        ];
        return view('admin.users', $data);
    }

    public function products () {
        return view('admin.products');
    }

    public function categories () {
        return view('admin.categories');
    }

    public function enterAsUser ($id) {
        Auth::loginUsingId($id);
        return redirect()->route('adminUsers');
    }

    public function exportCategories () 
    {
        ExportCategories::dispatch();
        session()->flash('starExportCategories');
        return back();
    }

    public function importCategories () 
    {
        ImportCategories::dispatch();
        session()->flash('starImportCategories');
        return back();
    }

    public function addRole () 
    {
        request()->validate([
            'name' => 'required|min:3'
        ]);
        Role::create([
            'name' => request('name')
        ]);

        return back();
    }

    public function deleteRole ($id)
    {
        Role::findOrFail($id)->delete();
        return back();
    }

    public function addRoleToUser ()
    {
        request()->validate([
            'user_id' => 'required',
            'role_id' => 'required'
        ]);

        $user = User::find(request('user_id'));
        $user->roles()->attach(Role::find(request('role_id')));
        return back();
    }
}
