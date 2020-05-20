<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAPIController extends Controller
{
    private $APIkeyLength = 40 ;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $viewData = array();

        $viewData['api_key'] = $this->getUserAPIkey();
        $viewData['allowed_data'] = Auth::user()->allowed_data;

        return view('myAPI.index',$viewData);
    }

    public function regenerate(){

        $user = Auth::user();
        $user->api_token = $this->generateApiToken();
        $user->save();

        return redirect(route('my_api'));
    }

    public function allowDataProcess(Request $request){

        $allowed_data = $request->get('allowed_data');

        $user = Auth::user();
        $user->allowed_data = $allowed_data;
        $user->save();

        return redirect(route('my_api'));
    }

    private function getUserAPIkey(){
        if(Auth::user()->api_token){
            return Auth::user()->api_token;
        }else{
            $user = Auth::user();
            $user->api_token = $this->generateApiToken();
            $user->save();

            return $user->api_token;
        }
    }

    private function generateApiToken(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $this->APIkeyLength; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
