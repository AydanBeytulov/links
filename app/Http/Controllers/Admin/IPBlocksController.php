<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\IPBlocks;
use Illuminate\Http\Request;

class IPBlocksController extends Controller
{
    public function list()
    {
        $viewData = array();

        $viewData['blocks'] = IPBlocks::all();

        return view('admin.ipblocks.list',$viewData);
    }

    public function add()
    {
        $viewData = array();
        return view('admin.ipblocks.add',$viewData);
    }

    public function addProcess(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ip' => ['required', 'string', 'max:255'],
        ]);

        IPBlocks::create([
            'name' => $request->get('name'),
            'ip' => $request->get('ip'),
            'active' => $request->get('active')? true : false,
        ]);
        return redirect(route('admin_ip_blocks'));

    }

    public function edit(Request $request, $id)
    {
        $viewData = array();

        if(!IPBlocks::where('id','=',$id)->count()){
            return redirect(route('admin_ip_blocks'));
        }

        $viewData['data'] = IPBlocks::where('id','=',$id)->first();

        return view('admin.ipblocks.edit',$viewData);
    }

    public function editProcess(Request $request)
    {
        $validatedData = $request->validate([
            'edit_id' => ['required', 'integer', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'ip' => ['required', 'string', 'max:255'],
        ]);

        $data = IPBlocks::where('id',$request->get('edit_id'))->first();
        $data->name = $request->get('name');
        $data->ip = $request->get('ip');
        $data->active = $request->get('active')? true : false;
        $data->save();
        return redirect(route('admin_ip_blocks'));
    }

    public function delete(Request $request, $id)
    {
        if(!IPBlocks::where('id','=',$id)->count()){
            return redirect(route('admin_ip_blocks'));
        }

        $service = IPBlocks::where('id',$id)->first();
        $service->delete();

        return redirect(route('admin_ip_blocks'));
    }
}
