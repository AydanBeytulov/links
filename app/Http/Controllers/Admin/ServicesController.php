<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function list()
    {
        $viewData = array();

        $viewData['services'] = Service::all();

        return view('admin.services.list',$viewData);
    }

    public function add()
    {
        $viewData = array();

        $viewData['categories'] = Category::all();

        return view('admin.services.add',$viewData);
    }

    public function addProcess(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'integer', 'exists:App\Category,id'],
            'rate' => ['numeric', 'between:0,9999.99'],
        ]);

        if($request->get('spoof_url')){
            $validatedData2 = $request->validate([
                'spoof_url' => ['regex:/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)+(.*)?$/', 'max:255'],
            ]);
        }


        Service::create([
            'name' => $request->get('name'),
            'category' => $request->get('category'),
            'spoof_url' => $request->get('spoof_url'),
            'rate' => $request->get('rate'),
        ]);
        return redirect(route('admin_services'));

    }

    public function edit(Request $request, $id)
    {
        $viewData = array();

        if(!Service::where('id','=',$id)->count()){
            return redirect(route('admin_services'));
        }

        $viewData['categories'] = Category::all();

        $viewData['data'] = Service::where('id','=',$id)->first();

        return view('admin.services.edit',$viewData);
    }

    public function editProcess(Request $request)
    {
        $validatedData = $request->validate([
            'edit_id' => ['required', 'integer', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'integer', 'exists:App\Category,id'],
            'rate' => ['numeric', 'between:0,9999.99'],
        ]);

        if($request->get('spoof_url')){
            $validatedData2 = $request->validate([
                'spoof_url' => ['regex:/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)+(.*)?$/', 'max:255'],
            ]);
        }

        $service = Service::where('id',$request->get('edit_id'))->first();
        $service->name = $request->get('name');
        $service->category = $request->get('category');
        $service->spoof_url = $request->get('spoof_url');
        $service->rate = $request->get('rate');
        $service->save();
        return redirect(route('admin_services'));
    }

    public function delete(Request $request, $id)
    {

        if(!Service::where('id','=',$id)->count()){
            return redirect(route('admin_services'));
        }

        $service = Service::where('id',$id)->first();
        $service->delete();

        return redirect(route('admin_services'));
    }

    public static function getServicePrice($serviceId = 0){
        if($serviceId > 0){
            $service = Service::where('id',$serviceId)->first();
            if($service){
                if($service->rate > 0){
                    return $service->rate;
                }else{
                    return SettingsController::getSetting('price_per_pack');
                }
            }
        }else{
            return SettingsController::getSetting('price_per_pack');
        }
    }
}
