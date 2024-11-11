<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('admin.auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8|max:25'
        ]);
        
        // dd(auth()->user());

        $user = Admin::where(['id' => auth()->user()->id])->first();

        if ($user) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
                return redirect()->back()->withSuccess('Password changed !!!');
            } else {
                return redirect()->back()->withErrors('Password could not be changed');
            }
        } else {
            return redirect()->back()->withErrors('User Not Found');
        }
    }
}
