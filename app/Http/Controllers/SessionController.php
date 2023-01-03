<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\False_;
use function PHPUnit\Framework\isFalse;

class  SessionController
{

    public function create()
    {
       return view ('sessions.create');
    }


    public function store()
    {
        //validate the request
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'

        ]);
        // attempt to authenticate and log in the user
        // based on the provided credentials
        if (auth()->attempt($attributes)){
            if(auth()->user()->account_type == 1) {

                return redirect('user/')->with('welcome','you do have admin access');
            } else {            // redirect with a succes flash messgage
//                return redirect('/')->with('error','you do not have admin access');
                return redirect('user/bprofiel')->with('','');

                //      return redirect('/')->with('success','welcome');
            }

//  auth failed
            return back()
                ->withInput()
                ->withErrors(['email' => 'your provided credentials could not be verified']);

        }}


    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 //       return response()->noContent();
        return redirect('/login')->with('sucess','Goodbye');
    }

}
