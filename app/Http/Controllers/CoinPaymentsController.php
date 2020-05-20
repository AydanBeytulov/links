<?php

namespace App\Http\Controllers;

use App\Funds;
use App\Order;
use Illuminate\Http\Request;

class CoinPaymentsController extends Controller
{
    public function createTransaction($amount, $itemName, $itemID, $userName, $userEmail){
        $req = array();
        $req['amount'] = $amount ;
        $req['currency1'] = "USD" ;
        $req['currency2'] = "BTC" ;
        $req['buyer_email'] = $userEmail ;
        $req['buyer_name'] = $userName ;
        $req['item_name'] = $itemName ;
        $req['item_number'] = $itemID ;
        $req['ipn_url'] = env("APP_URL", "http://127.0.0.1:8000")."/ipn" ;
        return $this->coinpayments_api_call('create_transaction',$req);
    }

    public function getDepositAddress(){
        $req = array();
        $req['currency'] = "BTC" ;
        return $this->coinpayments_api_call('get_deposit_address',$req);
    }

    public function getRates(){
        return $this->coinpayments_api_call('rates');
    }

    private function coinpayments_api_call($cmd, $req = array()) {
        // Fill these in from your API Keys page
        $public_key = 'eefb58cc61e72ec57914412d84b5098f9188e4becb9b3a753a1d672b44cb4adb';
        $private_key = 'E269b31944a0930ebE30a8374bfDae97B6b4dd1e2eAe4e14db93B40490e692B6';

        // Set the API command and required fields
        $req['version'] = 1;
        $req['cmd'] = $cmd;
        $req['key'] = $public_key;
        $req['format'] = 'json'; //supported values are json and xml

        // Generate the query string
        $post_data = http_build_query($req, '', '&');

        // Calculate the HMAC signature on the POST data
        $hmac = hash_hmac('sha512', $post_data, $private_key);

        // Create cURL handle and initialize (if needed)
        static $ch = NULL;
        if ($ch === NULL) {
            $ch = curl_init('https://www.coinpayments.net/api.php');
            curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        // Execute the call and close cURL handle
        $data = curl_exec($ch);
        // Parse and return data if successful.
        if ($data !== FALSE) {
            if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
                // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
                $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
            } else {
                $dec = json_decode($data, TRUE);
            }
            if ($dec !== NULL && count($dec)) {
                return $dec;
            } else {
                // If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
                return array('error' => 'Unable to parse JSON result ('.json_last_error().')');
            }
        } else {
            return array('error' => 'cURL error: '.curl_error($ch));
        }
    }

    public function ipn(){
        // Fill these in with the information from your CoinPayments.net account.
        $cp_merchant_id = '143d9569ea9cf881da40addc8d0666fa';
        $cp_ipn_secret = 'Fa06c9E39Bc86F7db6c723b0E1862239eA52F739fc4486f707700e6d6409d4b6';
        $cp_debug_email = 'abeytulov@gmail.com';

        function errorAndDie($error_msg) {
            global $cp_debug_email;
            if (!empty($cp_debug_email)) {
                $report = 'Error: '.$error_msg."\n\n";
                $report .= "POST Data\n\n";
                foreach ($_POST as $k => $v) {
                    $report .= "|$k| = |$v|\n";
                }
                mail($cp_debug_email, 'CoinPayments IPN Error', $report);
            }
            die('IPN Error: '.$error_msg);
        }

        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
            errorAndDie('IPN Mode is not HMAC');
        }

        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            errorAndDie('No HMAC signature sent.');
        }

        $request = file_get_contents('php://input');
        if ($request === FALSE || empty($request)) {
            errorAndDie('Error reading POST data');
        }

        if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) {
            errorAndDie('No or incorrect Merchant ID passed');
        }

        $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret));
        if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
            //if ($hmac != $_SERVER['HTTP_HMAC']) { <-- Use this if you are running a version of PHP below 5.6.0 without the hash_equals function
            errorAndDie('HMAC signature does not match');
        }

        // HMAC Signature verified at this point, load some variables.

        $ipn_type = $_POST['ipn_type'];
        $txn_id = $_POST['txn_id'];
        $item_name = $_POST['item_name'];
        $item_number = $_POST['item_number'];
        $amount1 = floatval($_POST['amount1']);
        $amount2 = floatval($_POST['amount2']);
        $currency1 = $_POST['currency1'];
        $currency2 = $_POST['currency2'];
        $status = intval($_POST['status']);
        $status_text = $_POST['status_text'];
        $item_number = $_POST['item_number'];

        //These would normally be loaded from your database, the most common way is to pass the Order ID through the 'custom' POST field.
        $order_currency = 'USD';
        $fund = Funds::where('id',$item_number)->first();
        $order_total = $fund->funds;


        //depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point

        // Check the original currency to make sure the buyer didn't change it.
        if ($currency1 != $order_currency) {
            errorAndDie('Original currency mismatch!');
        }

        // Check amount against order total
        if ($amount1 < $order_total) {
            errorAndDie('Amount is less than order total!');
        }

        if ($status >= 100 || $status == 2) {

            $funds = new FundsController();
            $funds->payFund($item_number);

        } else if ($status < 0) {
            //payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent
        } else {
            //payment is pending, you can optionally add a note to the order page
        }
        die('IPN OK');
    }
}
