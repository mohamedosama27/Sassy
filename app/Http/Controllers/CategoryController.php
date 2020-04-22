<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $items_per_page = 10;

    public function index(Request $request,$id) {

        $items = \App\item::where('category_id','=',$id)->paginate($this->items_per_page);

        if($request->ajax()) {
            return [
                'items' => view('ajax.index')->with(compact('items'))->render(),
                'next_page' => $items->nextPageUrl()
            ];
        }

        return view('home')->with(compact('items'));

    }
    public function store(Request $request)
    {
        $category = new  \App\category;
 
        $category->name = $request['name'];
        $category->save();
        return redirect('home');
    }
    public function edit()
    {
        $categories = \App\category::all();

        return view('editcategory',[
            'categories'=>$categories
        ]);
    }
    public function update(Request $request, $id)
    {
        
        $category = \App\category::find($id);
        $category->name=$request['name'];
        $category->save();
        return redirect('editcategory');
    }
    public function destroy($id)
    {
        $category = \App\category::find($id);

        $category->delete();
        return redirect('editcategory');

    }
}
