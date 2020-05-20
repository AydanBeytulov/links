<?php

namespace App\Http\Controllers\API;

use App\Block;
use App\Category;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Controller;
use App\Order;
use App\Rotator;
use App\Service;
use App\URL;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {

        $action = $request->get('action');

        if(method_exists($this, $action)){
            return $this->$action($request);
        }else{
            return response()->json(['message' => 'Not Found.'], 404);
        }
    }

    private function services(Request $request){

        $services = Service::select('id','name','rate')->get();

        return response()->json(['message' => $services ], 200);
    }

    private function balance(Request $request){

        if(Auth::user()){
            $balance = Auth::user()->funds;
        }else{
            $balance = NULL;
        }

        return response()->json(['message' => $balance ], 200);
    }

    private function add(Request $request){

        $qtyMin = SettingsController::getSetting('order_min_qty');
        $qtyMax = SettingsController::getSetting('order_max_qty');

        $validatedData = $request->validate([
            'service' => ['required', 'integer', 'exists:App\Service,id'],
            'comments' => ['max:255'],
            'link' => ['required', 'url', 'max:255'],
            'quantity' => ['required', 'integer', 'min:'.$qtyMin, 'max:'.$qtyMax],
        ]);

        $pricePerThousand = ServicesController::getServicePrice($request->get('service'));
        $price = ($request->get('quantity') / 1000) * $pricePerThousand;
        $price = $this->round_up($price,2);


        if($price > Auth::user()->funds){
            return response()->json(['message' => 'No enough funds. Please add fund in your account.'], 404);
        }

        if($price < 0.01){
            return response()->json(['message' => 'Order cost cannot be $0.'], 404);
        }


        $checkBlockURL = $this->InternatcheckBlockURL($request->get('link'));
        $checkURL = $this->InternatcheckURL($request->get('link'));

        if(!$checkURL && !$checkBlockURL){

            $getService = Service::where('id', $request->get('service'))->first();
            $categoryId = $getService->category;


            $order = Order::create([
                'category' => $categoryId,
                'service' => $request->get('service'),
                'url' => $request->get('link'),
                'description' => $request->get('comments'),
                'qty' => $request->get('quantity'),
                'userId' => Auth::id(),
            ]);

            if($order){
                $pricePerThousand = ServicesController::getServicePrice($request->get('service'));
                $price = ($request->get('quantity') / 1000) * $pricePerThousand;
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

                        $this->InternaladdUrlToRotator($url->id, $order->service);

                    }

                }

                return response()->json(['message' => "Order Created: #".$order->id  ], 200);
            }else{
                return response()->json(['message' => 'Something is wrong.'], 404);
            }


        }else{
            return response()->json(['message' => 'URL is banned.'], 404);
        }


    }

    private function closeOrder(Request $request){

        $validatedData = $request->validate([
            'order' => ['required', 'integer', 'exists:App\Order,id'],
        ]);

        $order = Order::where('id',$request->get('order'))->first();

        if($order->userId == Auth::id()){
            $url = URL::where('order_id', $order->id)->first();

            if($url){
                $qtyProc = $url->qty_showed;
                $url->active = 0;
                $url->save();
            }else{
                $qtyProc = "0";
            }

            $pricePerThousand = ServicesController::getServicePrice($order->service);
            $spendPrice = ($qtyProc / 1000) * $pricePerThousand;
            $moneyLeft = $order->price - $spendPrice;

            $moneyLeft = $this->round_up($moneyLeft,2);

            $user = User::where('id', Auth::id())->first();
            $user->funds += $moneyLeft;
            $user->save();

            $order->paid = 'closed';
            $order->active = 0;
            $order->save();


            return response()->json(['message' => "Order is closed" ], 200);

        }else{
            return response()->json(['message' => 'Bad request.'], 404);
        }
    }

    private function round_up( $value, $precision ) {
        $pow = pow ( 10, $precision );
        return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow;
    }

    private function InternaladdUrlToRotator($urlId, $service){
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

    private function InternatcheckBlockURL($url){
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

    private function InternatcheckURL($url){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://www.virustotal.com/vtapi/v2/url/report?apikey=244765e7b6ae1ad12de838bdc4895c554cad4d0933c5255b1408887e639bc0bc&resource=$url");
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


    private function status(Request $request){

        if($request->get('order')){

            $status = $this->get_order_status($request->get('order'));
            return response()->json(['message' => $status ], 200);

        }elseif ($request->get('orders')){

            $orders = explode(",", $request->get('orders'));

            $results = array();
            foreach ($orders as $order){
                $tmpArr = array();
                $tmpArr['order'] = $order;
                $tmpArr['status'] = $this->get_order_status($order);
                $results[] = $tmpArr;
            }

            return response()->json(['message' => $results ], 200);
        }else{
            return response()->json(['message' => 'Bad request.'], 404);
        }


    }

    private function get_order_status($order){
        if(!Order::where('id','=',$order)->where('userId',Auth::id())->count()){
            return $status = "Not found";
        }
        $order = Order::where('id','=',$order)->first();

        if($order->active){
            $status = "Active";
        }else{
            $status = "Stopped";
        }

        return $status;
    }
}
