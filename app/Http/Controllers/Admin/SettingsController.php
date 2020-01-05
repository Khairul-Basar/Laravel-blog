<?php

namespace App\Http\Controllers\Admin;


use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Types\This;

class SettingsController extends Controller
{
    public function index(){

        return view('admin.settings');

    }

    public function updateProfile(Request $request){

        $this->validate($request,[
            'name'  => 'required',
            'email' => 'required|email',
            'profile-image' => 'required|image'
        ]);

        $image = $request->file('profile-image');
        $slug = str_slug($request->name);

        $user = User::findOrFail(Auth::id());

        if (isset($image)){

            $current_date = Carbon::now()->toDateString();

            $imageName = $slug.'-'.$current_date.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('profile')){
                Storage::disk('public')->makeDirectory('profile');
            }


//            Delete old image for this user

            if (Storage::disk('public')->exists('profile/'.$user->image)){

                Storage::disk('public')->delete('profile/'.$user->image);

            }

            $profile = Image::make($image)->resize(500,500)->save();
            Storage::disk('public')->put('profile/'.$imageName,$profile);

        }else{
            $imageName = $user->image;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageName;
        $user->about = $request->about;
        $user->save();

        Toastr::success('Profile Successfully Updated','Success');

        return redirect()->back();

    }


    public function updatePassword(Request $request){

        $this->validate($request,[

            'old_password'=> 'required',

             'password'   => 'required|confirmed'

            ]);


        $hasPassword = Auth::user()->password;

        if (Hash::check($request->old_password,$hasPassword)){

            if (!Hash::check($request->password,$hasPassword)){

                $user = User::find(Auth::id());

                $user->password = Hash::make($request->password);

                $user->save();

                Toastr::success('Password Successfully Changed','Success');

                Auth::logout();

                return redirect()->back();

            }else{
                Toastr::error('New Password can not be same as old Password','Error');
                return redirect()->back();
            }


        }else{
            Toastr::error('Current Password does not match...!! please tray again','Error');
            return redirect()->back();
        }

    }


}
