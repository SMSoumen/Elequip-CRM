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
        $rules =[
            'name' => ['required', 'string', 'max:255'],
            'phone' => 'required|string|digits:10',
        ];
        if(!empty($request->current_password) && !empty($request->password)){
            $rules['current_password'] = 'required';
            $rules['password'] = 'required|confirmed|min:8|max:25';          
        }
        $request->validate($rules);
        $user = Admin::where(['id' => auth('admin')->user()->id])->first();

        if (Admin::where('id', "!=", auth('admin')->user()->id)->where('phone', $request->phone)->get()->count() > 0) {
            return redirect()->back()->withErrors('Phone no already is in use, Try with another.');
        }

        if ($user) {
            
            Admin::where(['id' => auth('admin')->user()->id])->update(['phone' => $request->phone, 'name' => $request->name]);

            if(!empty($request->current_password) && !empty($request->password)){
                if (Hash::check($request->current_password, $user->password)) {
                    Admin::where(['id' => auth('admin')->user()->id])->update([
                        'password' => Hash::make($request->password),
                    ]);
                    return redirect()->back()->withSuccess('Password changed !!!');
                } else {
                    return redirect()->back()->withErrors('Password could not be changed');
                }
            }

            return redirect()->back()->withSuccess('Profile updated successfully !!!');
        } 
        else {
            return redirect()->back()->withErrors('User Not Found');
        }
    }
}
