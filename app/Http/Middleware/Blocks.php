<?php

namespace App\Http\Middleware;

use App\IPBlocks;
use Closure;
use Illuminate\Support\Facades\DB;

class Blocks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $userIP = $_SERVER['REMOTE_ADDR'];

        if($userIP == "199.231.188.252"){
            $userIP = $request->get('ip');
        }
       
        $sql = 'SELECT
	            c.*
	        FROM
	            ip2nationCountries c,
	            ip2nation i
	        WHERE
	            i.ip < INET_ATON("'.$userIP.'")
	            AND
	            c.code = i.country
	        ORDER BY
	            i.ip DESC
	        LIMIT 0,1';

        $results = DB::select( DB::raw($sql) );

        $userCountryIsBlocked = @$results[0] ? $results[0]->blocked : null;

        if($userCountryIsBlocked == 0 || $userCountryIsBlocked === null){
            if(IPBlocks::where('ip',$userIP)->where('active', true)->count() > 0){
                echo "You can't access this page. IP:".$userIP; exit;
            }
        }else{
            echo "You can't access this page. IP:".$userIP; exit;
        }

        return $next($request);
    }
}
