<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Service;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function list()
    {
        $viewData = array();
        $viewData['categories'] = Category::all();
        return view('admin.categories.list',$viewData);
    }

    public function add()
    {
        $viewData = array();
        return view('admin.categories.add',$viewData);
    }

    public function addProcess(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Category::create([
            'name' => $request->get('name')
        ]);

        return redirect(route('admin_categories'));
    }

    public function edit(Request $request, $id)
    {
        $viewData = array();

        if(!Category::where('id','=',$id)->count()){
            return redirect(route('admin_categories'));
        }

        $viewData['data'] = Category::where('id','=',$id)->first();

        return view('admin.categories.edit',$viewData);
    }

    public function editProcess(Request $request)
    {
        $validatedData = $request->validate([
            'edit_id' => ['required', 'integer', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $service = Category::where('id',$request->get('edit_id'))->first();
        $service->name = $request->get('name');
        $service->save();
        return redirect(route('admin_categories'));

    }

    public function delete(Request $request, $id)
    {

        if(!Category::where('id','=',$id)->count()){
            return redirect(route('admin_categories'));
        }

        $service = Category::where('id',$id)->first();
        $service->delete();

        return redirect(route('admin_categories'));
    }

}
