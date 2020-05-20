<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestAPIController extends Controller
{
    public $api_url = 'http://mm.mmummy.com/api/v1'; // API URL

    public $api_key = '4Ot1I6@VawhuMtURcLPU!3kn6d6McfYG#iK6JSl@'; // Your API key

    public function order($data) { // add order
        $post = array_merge(array('key' => $this->api_key, 'action' => 'add'), $data);
        return json_decode($this->connect($post));
    }

    public function status($order_id) { // get order status
        return json_decode($this->connect(array(
            'key' => $this->api_key,
            'action' => 'status',
            'order' => $order_id
        )));
    }

    public function closeOrder($order_id) { // get order status
        return json_decode($this->connect(array(
            'key' => $this->api_key,
            'action' => 'closeOrder',
            'order' => $order_id
        )));
    }


    public function multiStatus($order_ids) { // get order status
        return json_decode($this->connect(array(
            'key' => $this->api_key,
            'action' => 'status',
            'orders' => implode(",", (array)$order_ids)
        )));
    }

    public function services() { // get services

        return json_decode($this->connect(array(
            'key' => $this->api_key,
            'action' => 'services',
        )));
    }

    public function balance() { // get balance
        return json_decode($this->connect(array(
            'key' => $this->api_key,
            'action' => 'balance',
        )));
    }


    private function connect($post) {
        $_post = Array();
        $key = "";
        if (is_array($post)) {
            foreach ($post as $name => $value) {
                $_post[] = $name.'='.urlencode($value);

                if($name == "key"){
                    $key = $value;
                }
            }
        }

        $ch = curl_init($this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Authorization: Bearer '.$key));
        if (is_array($post)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }
        curl_close($ch);

        return $result;
    }


    function test(Request $request,$type){
        if($type == 1){
            var_dump($this->services());
        }elseif($type == 2){
            var_dump($this->balance());
        }elseif($type == 3){
            var_dump($this->order(array('service' => 8, 'link' => 'http://example.com/test', 'quantity' => 20)));
        }elseif($type == 4){
            var_dump($this->order(array('service' => 8, 'link' => 'http://example.com/test', 'comments' => "good pic\ngreat photo\n:)\n;)", 'quantity' => 20)));
        }elseif($type == 5){
            var_dump($this->status(283));
        }elseif($type == 6){
            var_dump($this->multiStatus([28, 29, 399]));
        }elseif($type == 7){
            var_dump($this->closeOrder(34));
        }
    }
}
