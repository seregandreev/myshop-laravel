<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile (User $user) {
        if (!Auth::user())
            return redirect()->route('home');
        if (Auth::user()->isAdmin() || $user->id == Auth::user()->id)
            return view('profile', compact('user'));
        
        return redirect()->route('home');
    }

    public function save (Request $request) {
        $input = request()->all();

        $name = $input['name'];
        $email = $input['email'];
        $picture = $input['picture'] ?? null;
        $userId = $input['userId'];
        $newAddress = $input['new_address'];
        //$mainAddrUser = $input['mainAddrUser'];
        $user = User::find($userId);

        request()->validate([
            'name' => 'required',
            'email' => "email|required|unique:users,email,{$user->id}",
            'picture' => 'mimetypes:image/*',
            'current_password' => 'current_password|required_with:password|nullable',
            'password' => 'confirmed|min:8|nullable'
        ]);

        if($input['password']) {
            $user->password = Hash::make($input['password']);
            $user->save();
        }

        Address::where('user_id', $user->id)->update([
            'main' => 0
        ]);
        Address::where('id', $input['main_address'])->update([
            'main' => 1
        ]);


        if($newAddress) {
            if($request['mainAddrUser']) {
                Address::where('user_id', $user->id)->update([
                    'main' => 0
                ]);
                Address::create([
                    'user_id' => $user->id,
                    'address' => $newAddress,
                    'main' => 1
                ]);
            } else {
                Address::create([
                    'user_id' => $user->id,
                    'address' => $newAddress,
                    'main' => 0
                ]);
            }

        }

        if($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/users', $fileName);
            $user->picture = "users/$fileName";
        }

        $user->name = $name;
        $user->email = $email;

        session()->flash('saveProfileFlash');
        $user->save();
        return back();
    }

    public function deleteAddress($id)
    {
        Address::findOrFail($id)->delete();
        session()->flash('deleteAddress');
        return back();
    }
}
