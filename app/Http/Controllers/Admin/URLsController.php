<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class URLsController extends Controller
{
    public function list()
    {
        $viewData = array();

        $viewData['urls'] = URL::all();

        return view('admin.urls.list',$viewData);
    }

    public function add()
    {
        $viewData = array();
        return view('admin.urls.add',$viewData);
    }

    public function addProcess(Request $request)
    {
        $qtyMin = SettingsController::getSetting('order_min_qty');
        $qtyMax = SettingsController::getSetting('order_max_qty');

        $validatedData = $request->validate([
            'url' => ['required', 'string', 'max:255'],
            'qty' => ['required', 'integer', 'min:'.$qtyMin, 'max:'.$qtyMax],
        ]);

        URL::create([
            'url' => $request->get('url'),
            'spoof_url' => $request->get('spoof_url'),
            'userId' => Auth::id(),
            'qty' => $request->get('qty'),
            'active' => $request->get('active')? true : false,
        ]);

        return redirect(route('admin_urls'));

    }

    public function edit(Request $request, $id)
    {
        $viewData = array();

        if(!URL::where('id','=',$id)->count()){
            return redirect(route('admin_urls'));
        }

        $viewData['data'] = URL::where('id','=',$id)->first();

        return view('admin.urls.edit',$viewData);
    }

    public function editProcess(Request $request)
    {

        $qtyMin = SettingsController::getSetting('order_min_qty');
        $qtyMax = SettingsController::getSetting('order_max_qty');

        $validatedData = $request->validate([
            'edit_id' => ['required', 'integer', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'qty' => ['required', 'integer', 'min:'.$qtyMin, 'max:'.$qtyMax],
            'qtyshowed' => ['required', 'integer'],
        ]);

        $service = URL::where('id',$request->get('edit_id'))->first();
        $service->url = $request->get('url');
        $service->qty = $request->get('qty');
        $service->spoof_url = $request->get('spoof_url');
        $service->qty_showed = $request->get('qtyshowed');

        if($service->order_id){}else{
            $service->active = $request->get('active')? true : false ;
        }

        $service->save();
        return redirect(route('admin_urls'));
    }

    public function delete(Request $request, $id)
    {
        if(!URL::where('id','=',$id)->count()){
            return redirect(route('admin_urls'));
        }

        $service = URL::where('id',$id)->first();
        $service->delete();

        return redirect(route('admin_urls'));
    }
}
