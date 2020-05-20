<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Log;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function __construct()
    {

    }

    public function login()
    {
        if(Auth::id()){
            return redirect(route('admin_users'));
        }

        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email','=',$credentials['email'])->first();

        if($user){
            if($user->type != "admin"){
                $credentials['email'] = "";
            }
        }

        $auth = Auth::attempt($credentials);

        if($auth){

            $user = Auth::user();

            Log::create([
                'userId' => $user->id,
                'ip' => $request->ip(),
                'browser' => $request->server('HTTP_USER_AGENT'),
            ]);

            $subject = "New log in to your account!";
            $to = $user->email;
            $html = "<html><h1>New log in!</h1><p>IP: <b>".$request->ip()."</b> <br> Browser: <b>".$request->server('HTTP_USER_AGENT')."</b></p></html>";

            Mail::send([], [], function($message) use ($html, $to, $subject) {
                $message->from("noreply@mmummy.com", "Links");
                $message->to($to);
                $message->subject($subject);
                $message->setBody($html, 'text/html');
            });
        }


        return redirect('/admin');
    }
}
