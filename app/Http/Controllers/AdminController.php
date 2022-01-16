<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function admin () {
        return view('admin.admin');
    }

    public function users () {
        $users = User::get();

        $data = [
            'title' => 'Список пользователей',
            'users' => $users
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
}
