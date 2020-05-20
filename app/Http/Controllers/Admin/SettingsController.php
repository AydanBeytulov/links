<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Ip2nationcountries;
use App\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function edit()
    {
        $viewData = array();
        $settings = array();

        $settingsHolder = Settings::all()->toArray();

        foreach ($settingsHolder as $set){
            $settings[$set['name']] = $set['value'];
        }

        $viewData['settings'] = $settings;

        $viewData['countries'] = Ip2nationcountries::all();

        return view('admin.settings.edit',$viewData);
    }

    public function editProcess(Request $request)
    {
        $setting = Settings::where('name','overdelivery')->first();
        $setting->value = $request->get('overdelivery');
        $setting->save();

        $setting = Settings::where('name','price_per_pack')->first();
        $setting->value = $request->get('price_per_pack');
        $setting->save();

        $setting = Settings::where('name','order_min_qty')->first();
        $setting->value = $request->get('order_min_qty');
        $setting->save();

        $setting = Settings::where('name','order_max_qty')->first();
        $setting->value = $request->get('order_max_qty');
        $setting->save();


        DB::table('ip2nationCountries')->update(array('blocked' => 0));

        if($request->get('blocked_countries')){
            $blocked_countries = $request->get('blocked_countries');
            DB::table('ip2nationCountries')->whereIn('code', $blocked_countries)->update(array('blocked' => 1));
        }



        return redirect(route('admin_settings_edit'));
    }

    static function getSetting($name){
        $setting = Settings::where('name',$name)->first();

        if($setting){
            return $setting->value ;
        }else{
            return null;
        }

    }
}
