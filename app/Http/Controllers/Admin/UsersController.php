<?php

namespace App\Http\Controllers\Admin;

use App\Funds;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function list()
    {
        $viewData = array();

        $viewData['users'] = User::all();

        return view('admin.users.list',$viewData);
    }

    public function add()
    {
        $viewData = array();
        return view('admin.users.add',$viewData);
    }

    public function addProcess(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required','digits_between:7,15'],
            'address' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ]);

        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'address' => $request->get('address'),
            'phone' => $request->get('phone'),
            'type' => $request->get('type'),
            'can_change_email' => $request->get('can_change_email')? true : false,
            'twostep' => $request->get('twostep')? true : false,
        ]);

        return redirect(route('admin_users'));
    }

    public function edit(Request $request, $id)
    {
        $viewData = array();

        if(!User::where('id','=',$id)->count()){
            return redirect(route('admin_users'));
        }

        $viewData['data'] = User::where('id','=',$id)->first();

        return view('admin.users.edit',$viewData);
    }

    public function editProcess(Request $request)
    {
        $saveId = $request->get('edit_id') ;
        $validatedData = $request->validate([
            'edit_id' => ['required', 'integer', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,$saveId"],
            'phone' => ['required','digits_between:7,15'],
            'address' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ]);

        $service = User::where('id',$request->get('edit_id'))->first();
        $service->name = $request->get('name');
        $service->email = $request->get('email');
        $service->phone = $request->get('phone');
        $service->address = $request->get('address');
        $service->type = $request->get('type');
        $service->can_change_email = $request->get('can_change_email')? true : false;
        $service->twostep = $request->get('twostep')? true : false;
        $service->save();
/*
        if($service->id == Auth::id()){

            $now = new \DateTime();

            DB::insert('insert into twoStepAuth (
userId,
authCode,
authCount,
authStatus,
authDate) values (?, ?, ?,?,?)', [Auth::id(), "0000", "0","1", $now ]);
        }

*/ 
        return redirect(route('admin_users_edit', $service->id));
    }

    public function editProcessFunds(Request $request){
        $validatedData = $request->validate([
            'edit_id' => ['required', 'integer', 'max:255'],
            'funds' => ['required','numeric', 'between:0,9999.99'],
        ]);

        $user = User::where('id',$request->get('edit_id'))->first();

        $funds = Funds::create([
            'funds' => $request->get('funds'),
            'status' => "Completed",
            'competeDate' => date('Y-m-d H:i'),
            'userID' => $user->id,

        ]);

        $funds->pay_address = "Added by admin";
        $funds->btc_price = "0";
        $funds->checkout_url = "Added by admin";
        $funds->status_url = "Added by admin";
        $funds->qrcode_url = "Added by admin";
        $funds->save();

        $user->funds += $funds->funds;
        $user->save();

        return redirect(route('admin_users_edit',$user->id));
    }

    public function editProcessPassword(Request $request){
        $validatedData = $request->validate([
            'edit_id' => ['required', 'integer', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $service = User::where('id',$request->get('edit_id'))->first();
        $service->password = Hash::make($request->get('password'));
        $service->save();
        return redirect(route('admin_users'));
    }

    public function delete(Request $request, $id)
    {
        if(!User::where('id','=',$id)->count()){
            return redirect(route('admin_users'));
        }

        $service = User::where('id',$id)->first();
        $service->delete();

        return redirect(route('admin_users'));
    }
}
