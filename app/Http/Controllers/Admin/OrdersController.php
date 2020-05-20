<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoinPaymentsController;
use App\Http\Controllers\Controller;
use App\Order;
use App\Service;
use App\URL;
use App\User;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function list()
    {
        $viewData = array();

        $viewData['orders'] = Order::all();

        return view('admin.orders.list',$viewData);
    }

    public function add()
    {
        $viewData = array();
        return view('admin.orders.add',$viewData);
    }

    public function addProcess(Request $request)
    {

    }

    public function edit(Request $request, $id)
    {
        $viewData = array();

        if(!Order::where('id','=',$id)->count()){
            return redirect(route('admin_orders'));
        }

        $viewData['data'] = Order::where('id','=',$id)->first();


        $URL = URL::where('order_id', $viewData['data']->id)->first();

        if($URL){
            $viewData['data']->qtyProc = $URL->qty_showed;
            $viewData['data']->isURL = true;
        }else{
            $viewData['data']->isURL = false;
            $viewData['data']->qtyProc = "0";
        }


        return view('admin.orders.edit',$viewData);
    }

    public function editProcess(Request $request)
    {
        $validatedData = $request->validate([
            'edit_id' => ['required', 'integer', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $service = Order::where('id',$request->get('edit_id'))->first();
        $service->name = $request->get('name');
        $service->save();
        return redirect(route('admin_orders'));

    }

    public function delete(Request $request, $id)
    {

        if(!Order::where('id','=',$id)->count()){
            return redirect(route('admin_orders'));
        }

        $service = Order::where('id',$id)->first();
        $service->delete();

        return redirect(route('admin_orders'));
    }

    public function approve(Request $request, $id)
    {

        if(!Order::where('id','=',$id)->count()){
            return redirect(route('admin_orders'));
        }

        $service = Order::where('id',$id)->first();

        $user = User::where('id', $service->userId)->first();

        $service->approved = true;
        $service->save();

        if(!URL::where('order_id','=',$service->id)->count()){
            URL::create([
                'url' => $service->url,
                'userId' => $user->id,
                'qty' => $service->qty,
                'order_id' => $service->id,
                'active' => true,
            ]);
        }

        return redirect(route('admin_orders_edit', $service->id));
    }

    public function addUrlInList(Request $request, $id)
    {

        if(!Order::where('id','=',$id)->count()){
            return redirect(route('admin_orders'));
        }

        $service = Order::where('id',$id)->first();

        if(!URL::where('order_id','=',$service->id)->count()){
            $user = User::where('id', $service->userId)->first();

            URL::create([
                'url' => $service->url,
                'userId' => $user->id,
                'qty' => $service->qty,
                'order_id' => $service->id,
                'active' => false,
            ]);
        }

        return redirect(route('admin_orders_edit', $service->id));
    }



    public function activate(Request $request, $id){

        $service = Order::where('id',$id)->first();
        $service->active = 1;
        $service->save();

        $url = URL::where('order_id', $service->id)->count();

        if($url){
            $url = URL::where('order_id',$service->id)->first();
            $url->active = 1;
            $url->save();

        }

        return redirect(route('admin_orders_edit', $service->id));
    }

    public function stop(Request $request, $id){
        $service = Order::where('id',$id)->first();
        $service->active = 0;
        $service->save();

        $url = URL::where('order_id', $service->id)->count();

        if($url){
            $url = URL::where('order_id',$service->id)->first();
            $url->active = 0;
            $url->save();

        }
        return redirect(route('admin_orders_edit', $service->id));
    }

    public function refuse(Request $request, $id){
        $service = Order::where('id',$id)->first();

        $url = URL::where('order_id', $service->id)->first();

        if($url){
            $qtyProc = $url->qty_showed;
            $url->active = 0;
            $url->save();
        }else{
            $qtyProc = "0";
        }

        $pricePerThousand = SettingsController::getSetting($service->service);
        $spendPrice = ($qtyProc / 1000) * $pricePerThousand;
        $moneyLeft = $service->price - $spendPrice;
 
        $moneyLeft = $this->round_up($moneyLeft,2);

        $user = User::where('id', $service->userId)->first();
        $user->funds += $moneyLeft;
        $user->save();

        $service->paid = 'closed';
        $service->active = 0;
        $service->save();

        return redirect(route('orders_edit', $service->id));
    }

    private function round_up( $value, $precision ) {
        $pow = pow ( 10, $precision );
        return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow;
    }


}
