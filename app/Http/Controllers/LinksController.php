<?php

namespace App\Http\Controllers;

use App\Order;
use App\Rotator;
use App\Service;
use App\Settings;
use App\URL;
use Illuminate\Http\Request;

class LinksController extends Controller
{

    public function link(){

        $url = $this->getData();

        if($url->count()){
            $selectURL = $url->random();
            $selectURL->qty_showed++;
            $selectURL->save();

            if($selectURL->spoof_url){
                return redirect($selectURL->spoof_url);
            }else{

                if($selectURL->order_id){
                    $order = Order::select('service')->where('id',$selectURL->order_id)->first();
                    $service = $order->service;

                    if(!Service::where('id','=',$service)->count()){
                        return redirect($selectURL->url);
                    }else{
                        $spoof_url = Service::select('spoof_url')->where('id','=',$service)->first();
                        $spoof_url = $spoof_url->spoof_url;
                        if($spoof_url){
                            $redirectURL = str_replace("{url}", $selectURL->url, $spoof_url);
                            return redirect($redirectURL);
                        }else{
                            return redirect($selectURL->url);
                        }
                    }
                }

                return redirect($selectURL->url);
            }

        }else{
            echo "There isn't links available";
        }
    }

    private function getData(){


        $overdelivery = \App\Http\Controllers\Admin\SettingsController::getSetting('overdelivery');


/*
        $rotator = Rotator::inRandomOrder()->first();

        if(!$rotator){ die("Can't select Rotator");}

        if($overdelivery > 0){
            $url = $rotator->urls()->whereRaw('  (`urls`.`qty` + (('.$overdelivery.' / 100)) * `urls`.`qty`) > `urls`.`qty_showed`')->where('active','1')->inRandomOrder()->get();
        } else{
            $url = $rotator->urls()->whereRaw('`urls`.`qty` > `urls`.`qty_showed`')->where('active','1')->inRandomOrder()->get();
        }

*/
        if($overdelivery > 0){
            $url = URL::whereHas('rotators', function($query){
                $query->where('rotators.active', '1');
            })->whereRaw('  (`urls`.`qty` + (('.$overdelivery.' / 100)) * `urls`.`qty`) > `urls`.`qty_showed`')->where('active','1')->inRandomOrder()->get();
        } else{
            $url = URL::whereHas('rotators', function($query){
                $query->where('rotators.active', '1');
            })->whereRaw('`urls`.`qty` > `urls`.`qty_showed`')->where('active','1')->inRandomOrder()->get();
        }

        return $url ;
    }
}
