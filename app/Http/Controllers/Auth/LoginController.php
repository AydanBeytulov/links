<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Log;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {

        $user = User::where('email','=',$request->email)->first();

        if($user){
            if($user->type == "admin"){
                $request->email = "";
            }
        }

        return (auth()->attempt(['email' => $request->email, 'password' => $request->password]));
    }

    protected function authenticated(Request $request, $user) {

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


        if ($user->isAdmin()) {
            Auth::logout();
        }

        return redirect(route('home'));
    }
}
