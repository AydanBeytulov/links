<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Rotator;
use App\Service;
use App\URL;
use Illuminate\Http\Request;

class RotatorsController extends Controller
{
    public function list()
    {
        $viewData = array();

        $viewData['rotators'] = Rotator::all();

        return view('admin.rotators.list',$viewData);
    }

    public function add()
    {
        $viewData = array();

        $viewData['services'] = Service::all();
        $viewData['urls'] = URL::all();

        return view('admin.rotators.add',$viewData);
    }

    public function addProcess(Request $request){


        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'service' => ['required', 'integer', 'exists:App\Service,id'],
        ]);

        if($validatedData){

            $rotator = Rotator::create([
                'name' => $request->get('name'),
                'service' => $request->get('service'),
                'active' => $request->get('active')? true : false,
            ]);

            if($request->get('urls')){
                $rotator->urls()->sync( $request->get('urls') );
            }

        }

        return redirect(route('admin_rotators'));
    }


    public function edit(Request $request, $id)
    {
        $viewData = array();

        if(!Rotator::where('id','=',$id)->count()){
            return redirect(route('admin_rotators'));
        }

        $viewData['data'] = Rotator::where('id','=',$id)->first();
        $viewData['services'] = Service::all();
        $viewData['urls'] = URL::all();
        $viewData['selected_urls'] = $viewData['data']->urls()->pluck('urls.id')->toArray();

        return view('admin.rotators.edit',$viewData);
    }

    public function editProcess(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'service' => ['required', 'integer', 'exists:App\Service,id'],
        ]);

        $service = Rotator::where('id',$request->get('edit_id'))->first();
        $service->name = $request->get('name');
        $service->service = $request->get('service');
        $service->active = $request->get('active')? true : false;
        $service->save();

        if($request->get('urls')){
            $service->urls()->sync( $request->get('urls') );
        }else{
            $service->urls()->sync( array() );
        }



        return redirect(route('admin_rotators'));

    }

    public function delete(Request $request, $id)
    {

        if(!Rotator::where('id','=',$id)->count()){
            return redirect(route('admin_rotators'));
        }

        $service = Rotator::where('id',$id)->first();
        $service->delete();

        return redirect(route('admin_rotators'));
    }
}
