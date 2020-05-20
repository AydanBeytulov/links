<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $viewData = array();

        $viewData['data'] = Auth::user();

        return view('settings.index',$viewData);
    }

    public function editProcess(Request $request){
        $saveId = Auth::id() ;

        $validatedData = $request->validate([
            'edit_id' => ['required', 'integer', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,$saveId"],
            'phone' => ['required','digits_between:7,15'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $service = Auth::user();
        $service->name = $request->get('name');

        if($service->can_change_email){
            $service->email = $request->get('email');
        }

        $service->phone = $request->get('phone');
        $service->address = $request->get('address');
        $service->twostep = $request->get('twostep')? true : false;
        $service->save();

        if($request->get('twostep')){
            return redirect(route('home'));

            /*
                        $now = new \DateTime();

                        DB::insert('insert into twoStepAuth (
            userId,
            authCode,
            authCount,
            authStatus,
            authDate) values (?, ?, ?,?,?)', [Auth::id(), "0000", "0","1", $now ]);  */
        }


        return redirect(route('settings'));
    }

    public function editProcessPassword(Request $request){
        $validatedData = $request->validate([
            'edit_id' => ['required', 'integer', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $service = Auth::user();
        $service->password = Hash::make($request->get('password'));
        $service->save();
        return redirect(route('settings'));
    }
}
