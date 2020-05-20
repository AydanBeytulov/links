<?php

namespace App\Http\Controllers;

use App\Funds;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FundsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list()
    {
        $viewData = array();

        $viewData['funds'] = Funds::where('userId','=',Auth::id())->get();

        return view('funds.list',$viewData);
    }

    public function view(Request $request, $id)
    {
        $viewData = array();

        if(!Funds::where('id','=',$id)->count()){
            return redirect(route('funds_list'));
        }

        $viewData['data'] = Funds::where('id','=',$id)->first();

        return view('funds.view',$viewData);
    }


    public function add()
    {
        $viewData = array();

        return view('funds.add',$viewData);
    }

    public function addProcess(Request $request){
        $validatedData = $request->validate([
            'funds' => ['required','numeric', 'between:0,9999.99'],
        ]);

        $funds = Funds::create([
            'funds' => $request->get('funds'),
            'status' => "No Transaction",
            'competeDate' => null,
            'userID' => Auth::id(),
        ]);

        if($funds){
            $user = User::where('id', $funds->userID)->first();

            $paymentConnection = new CoinPaymentsController();
            $payment = $paymentConnection->createTransaction($funds->funds, 'funds', $funds->id, $user->name, $user->email);

            if($payment['error'] == "ok"){
                $funds->status = "Waiting";
                $funds->pay_address = $payment['result']['address'];
                $funds->btc_price = $payment['result']['amount'];
                $funds->checkout_url = $payment['result']['checkout_url'];
                $funds->status_url = $payment['result']['status_url'];
                $funds->qrcode_url = $payment['result']['qrcode_url'];
                $funds->save();
            }


            $funds->save();
            return redirect(route('funds_view', $funds->id));

        }else{
            return redirect(route('funds_list'));
        }
    }

    public function payFund($fundId){
        if(!Funds::where('id','=',$fundId)->count()){
            return redirect(route('funds_list'));
        }

        $funds = Funds::where('id','=',$fundId)->first();

        if(!User::where('id','=',$funds->userID)->count()){
            return redirect(route('funds_list'));
        }

        $user = User::where('id','=',$funds->userID)->first();

        $funds->competeDate = date('Y-m-d H:i');
        $funds->status = "Completed";
        $funds->save();

        $user->funds += $funds->funds;
        $user->save();
    }

}
