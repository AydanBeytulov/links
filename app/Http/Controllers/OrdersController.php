<?php

namespace App\Http\Controllers;

use App\Block;
use App\Category;
use App\Http\Controllers\Admin\ServicesController;
use App\Order;
use App\Rotator;
use App\Service;
use App\URL;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function redirectHome(){
        return \redirect(route('home'));
    }

    public function list()
    {
        $viewData = array();

        $viewData['orders'] = Order::where('userId','=',Auth::id())->get();


        foreach ($viewData['orders'] as $key => $order){
            $URL = URL::where('order_id', $order->id)->first();

            if($URL){
                $viewData['orders'][$key]->qtyProc = $URL->qty_showed;
            }else{
                $viewData['orders'][$key]->qtyProc = "0";
            }
        }


        return view('orders.list',$viewData);
    }

    public function add()
    {
        $viewData = array();

        $viewData['categories'] = Category::all();
        $viewData['services'] = Service::all();

        $viewData['price_per_pack'] = \App\Http\Controllers\Admin\SettingsController::getSetting('price_per_pack');

        return view('orders.add',$viewData);
    }

    public function addProcess(Request $request){
   
        $qtyMin = \App\Http\Controllers\Admin\SettingsController::getSetting('order_min_qty');
        $qtyMax = \App\Http\Controllers\Admin\SettingsController::getSetting('order_max_qty');

     $validatedData = $request->validate([
            'category' => ['required', 'integer', 'exists:App\Category,id'],
            'service' => ['required', 'integer', 'exists:App\Service,id'],
            'description' => ['max:255'],
            'url' => ['required', 'url', 'max:255'],
            'qty' => ['required', 'integer', 'min:'.$qtyMin, 'max:'.$qtyMax],
        ]);

        $pricePerThousand = ServicesController::getServicePrice($request->get('service'));
        $price = ($request->get('qty') / 1000) * $pricePerThousand;
        $price = $this->round_up($price,2);


        if($price > Auth::user()->funds){
            return Redirect::back()->withInput()->withErrors(['No enough funds. Please add fund in your account.']);
        }

        if($price < 0.01){
            return Redirect::back()->withInput()->withErrors(['Order cost cannot be $0.']);
        }


        $checkBlockURL = $this->checkBlockURL($request->get('url'));
        $checkURL = $this->checkURL($request->get('url'));

        if(!$checkURL && !$checkBlockURL){

            $order = Order::create([
                'category' => $request->get('category'),
                'service' => $request->get('service'),
                'url' => $request->get('url'),
                'description' => $request->get('description'),
                'qty' => $request->get('qty'),
                'userId' => Auth::id(),
            ]);

            if($order){
                $pricePerThousand = ServicesController::getServicePrice($request->get('service'));
                $price = ($request->get('qty') / 1000) * $pricePerThousand;
                $price = $this->round_up($price,2);
                $order->price = $price;
                $order->save();

                $user = Auth::user();

                $order->paid = "payed";
                $order->save();

                $user->funds -= $order->price;
                $user->save();


                if(Auth::user()->type == "fast" || Auth::user()->type == "admin"){
                    $order->active = true;
                    $order->approved = true;
                    $order->save();

                    if(!URL::where('order_id','=',$order->id)->count()){
                        $url = URL::create([
                            'url' => $order->url,
                            'userId' => Auth::id(),
                            'qty' => $order->qty,
                            'order_id' => $order->id,
                            'active' => true,
                        ]);

                        $this->addUrlToRotator($url->id, $order->service);

                    }

                }

                return redirect(route('orders_edit', $order->id));

            }else{
                return redirect(route('orders_list'));
            }


        }else{
            return Redirect::back()->withInput()->withErrors(['URL is banned.']);
        }


    }

    private function addUrlToRotator($urlId, $service){
        if(!Rotator::where('service','=',$service)->count()){
            $serviceName = Service::where('id', $service)->first(); $serviceName = $serviceName->name;
            $rotator = Rotator::create([
                'name' => $serviceName,
                'service' => $service,
                'active' => true,
            ]);
        }else{
            $rotator = Rotator::where('service','=',$service)->first();
        }

        DB::insert('insert into url_rotator (url_id, rotator_id) values (?, ?)', [$urlId, $rotator->id]);
        return true;
    }


    public function edit(Request $request, $id)
    {
        $viewData = array();

        if(!Order::where('id','=',$id)->count()){
            return redirect(route('orders_list'));
        }

        $viewData['data'] = Order::where('id','=',$id)->first();

        $URL = URL::where('order_id', $viewData['data']->id)->first();

        if($URL){
            $viewData['data']->qtyProc = $URL->qty_showed;
        }else{
            $viewData['data']->qtyProc = "0";
        }

        $pricePerThousand = ServicesController::getServicePrice($viewData['data']->service);
        $spendPrice = ($viewData['data']->qtyProc / 1000) * $pricePerThousand;

        $moneyLeft = $viewData['data']->price - $spendPrice;
        $moneyLeft = $this->round_up($moneyLeft,2);
        $viewData['money_back'] = array(
            "spend" => $spendPrice,
            "back" => $moneyLeft,
        );

        return view('orders.edit',$viewData);
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
        return redirect(route('orders_list'));

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

        return redirect(route('orders_edit', $service->id));
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

        return redirect(route('orders_edit', $service->id));
    }

    public function close(Request $request, $id){
        $service = Order::where('id',$id)->first();

        $url = URL::where('order_id', $service->id)->first();

        if($url){
            $qtyProc = $url->qty_showed;
            $url->active = 0;
            $url->save();
        }else{
            $qtyProc = "0";
        }

        $pricePerThousand = ServicesController::getServicePrice($service->service);
        $spendPrice = ($qtyProc / 1000) * $pricePerThousand;
        $moneyLeft = $service->price - $spendPrice;

        $moneyLeft = $this->round_up($moneyLeft,2);

        $user = User::where('id', Auth::id())->first();
        $user->funds += $moneyLeft;
        $user->save();

        $service->paid = 'closed';
        $service->active = 0;
        $service->save();

        return redirect(route('orders_edit', $service->id));
    }

    public function checkBlockURL($url){
        $blocksH = Block::all();
        $blocks = array();

        foreach ($blocksH as $block){
            $blocks[] = $block->pattern ;
        }

        foreach ($blocks as $block){
            if(strpos($url,$block) > 0){
                return true;
            }
        }

        return false;
    }

    public function checkURL($url){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://www.virustotal.com/vtapi/v2/url/report?apikey=7fd323239ea9190ef65f447048b3fbade13a9bc516b1a784b5a1eb5371031d90&resource=$url");
        curl_setopt($ch, CURLOPT_POST, 0);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        $server_output = json_decode($server_output);

        if($server_output->response_code == "1" && $server_output->positives > 0){
            return true;
        }else{
            return false;
        }


    }


    private function round_up( $value, $precision ) {
        $pow = pow ( 10, $precision );
        return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow;
    }

}
