<?php

namespace App\Http\Controllers\Admin;

use App\Block;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlocksController extends Controller
{
    public function list()
    {
        $viewData = array();

        $viewData['blocks'] = Block::all();

        return view('admin.blocks.list',$viewData);
    }

    public function add()
    {
        $viewData = array();
        return view('admin.blocks.add',$viewData);
    }

    public function addProcess(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'pattern' => ['required', 'string', 'max:255'],
        ]);

        Block::create([
            'name' => $request->get('name'),
            'pattern' => $request->get('pattern'),
            'active' => $request->get('active')? true : false,
        ]);
        return redirect(route('admin_blocks'));

    }

    public function edit(Request $request, $id)
    {
        $viewData = array();

        if(!Block::where('id','=',$id)->count()){
            return redirect(route('admin_blocks'));
        }

        $viewData['data'] = Block::where('id','=',$id)->first();

        return view('admin.blocks.edit',$viewData);
    }

    public function editProcess(Request $request)
    {
        $validatedData = $request->validate([
            'edit_id' => ['required', 'integer', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'pattern' => ['required', 'string', 'max:255'],
        ]);

        $data = Block::where('id',$request->get('edit_id'))->first();
        $data->name = $request->get('name');
        $data->pattern = $request->get('pattern');
        $data->active = $request->get('active')? true : false;
        $data->save();
        return redirect(route('admin_blocks'));
    }

    public function delete(Request $request, $id)
    {

        if(!Block::where('id','=',$id)->count()){
            return redirect(route('admin_blocks'));
        }

        $service = Block::where('id',$id)->first();
        $service->delete();

        return redirect(route('admin_blocks'));
    }
}
