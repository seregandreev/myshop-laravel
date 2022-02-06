<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile ($id) {
        $user = User::findOrFail($id);
        return view('profile', compact('user'));
    }

    public function save (Request $request) {
        $input = request()->all();
        $name = $input['name'];
        $email = $input['email'];
        $picture = $input['picture'] ?? null;
        $userId = $input['userId'];
        $newAddress = $input['new_address'];
        $user = User::find($userId);

        request()->validate([
            'name' => 'required',
            'email' => "email|required|unique:users,email,{$user->id}",
            'picture' => 'mimetypes:image/*',
            'current_password' => 'current_password|nullable',
            'password' => 'confirmed|min:8|nullable'
        ]);

        if($input['current_password']) {
            $user->password = Hash::make($input['password']);
        }

        Address::where('user_id', $user->id)->update([
            'main' => 0
        ]);

        Address::where('id', $input['main_address'])->update([
            'main' => 1
        ]);

        if($newAddress) {
            Address::where('user_id', $user->id)->update([
                'main' => 0
            ]);

            Address::create([
                'user_id' => $user->id,
                'address' => $newAddress,
                'main' => 1
            ]);
        }

        if($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/users', $fileName);
            $user->picture = "users/$fileName";
        }

        $user->name = $name;
        $user->email = $email;

        $user->save();
        return back();
    }
}
