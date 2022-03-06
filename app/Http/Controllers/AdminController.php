<?php

namespace App\Http\Controllers;

use App\Jobs\ExportCategories;
use App\Jobs\ExportProducts;
use App\Jobs\ImportCategories;
use App\Jobs\ImportProducts;
use App\Models\Role;
use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function saveImportCategoriesFile(Request $request)
    {
        if($request->file('importCategoriesFile')) {
            $file = $request->file('importCategoriesFile');
            $ext = $file->getClientOriginalExtension();
            $fileName = 'categories' . '.' . $ext;
            $upload_folder = 'public/import';
            Storage::putFileAs($upload_folder, $file, $fileName);
        }
        session()->flash('saveImportCategoriesFileFlash');
        return back();
    }

    public function deleteExportFile() 
    {
        Storage::delete('public/export/exportCategories.csv');
        session()->flash('deleteExportCategoriesFileFlash');
        return back();
    }

    public function downloadExportFile()
    {
        $file = Storage::disk('local')->path('public/export/exportCategories.csv');

        $headers = [
            'Content-Type' => 'application/csv',
         ];

        return response()->download($file, 'exportCategories.csv', $headers);
    }

    public function exportProducts () 
    {
        ExportProducts::dispatch();
        session()->flash('starExportProducts');
        return back();
    }

    public function importProducts () 
    {
        ImportProducts::dispatch();
        session()->flash('starImportProducts');
        return back();
    }

    public function saveImportProductsFile(Request $request)
    {
        if($request->file('importProductsFile')) {
            $file = $request->file('importProductsFile');
            $ext = $file->getClientOriginalExtension();
            $fileName = 'products' . '.' . $ext;
            $upload_folder = 'public/import';
            Storage::putFileAs($upload_folder, $file, $fileName);
        }
        session()->flash('saveImportProductsFileFlash');
        return back();
    }

    public function downloadExportProductsFile()
    {
        $file = Storage::disk('local')->path('public/export/exportProducts.csv');

        $headers = [
            'Content-Type' => 'application/csv',
         ];

        return response()->download($file, 'exportProducts.csv', $headers);
    }
}
