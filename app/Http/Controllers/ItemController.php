<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;


class ItemController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $items_per_page = 10;
   public function validation($request){
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'description' => ['required', 'string'],
      'quantity' => ['required', 'numeric'],
      'price' => ['required', 'numeric'],
      'price' => ['required', 'numeric'],
      'barcode' => ['required','string', 'max:255']

  ]);

   }
   public function welcome() {

        $items = \App\item::paginate(10);

        return view('welcome',compact('items'));

  }
    public function index(Request $request) {
      if(\App\item::count()>10){

        $items = \App\item::orderBy('id', 'DESC')->paginate($this->items_per_page);
        if($request->ajax()) {
          return [
              'items' => view('ajax.index')->with(compact('items'))->render(),
              'next_page' => $items->nextPageUrl(),
              'numberofitems'=>count($items)
          ];
      }
      
        return view('home')->with(compact('items'));
      
      }
      else{
        $items = \App\item::orderBy('id', 'DESC')->get();
        return view('home')->with(compact('items'));

      }
        

    }

    public function fetchNextitemsSet($page) {



    }
    public function showAll()
    {
        $items = \App\item::all();

        return view('home',[
            'items'=>$items ?? 'Doesnot exist'
        ]);
       
    }

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      

        $categories = \App\category::all();

        return view('additem',[
            'categories'=>$categories
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validation($request);
        $item = new  \App\item;
        $item->name = $request['name'];
        $item->description=$request['description'];
        $item->quantity=$request['quantity'];
        $item->price=$request['price'];
        $item->barcode=$request['barcode'];
        $item->category_id=$request['category'];
        $item->save();
    
        $item_id = $item->id;
        $files = $request->file('img');
            foreach ($files as $file){
              $name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
             $file->move("images", $name);
             $image = new \App\image;
     
             $image->name = $name;
             $image->item_id=$item_id;
     
             $image->save();
           }
             return redirect('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = \App\item::find($id);

        return view('item',[
            'item'=>$item,
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = \App\item::find($id);

        $categories = \App\category::all();
        return view('edititem',[
            'item'=>$item,
            'categories'=>$categories
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validation($request);

        
        $item = \App\item::find($id);
        $item->name = $request['name'];
        $item->description=$request['description'];
        $item->quantity=$request['quantity'];
        $item->price=$request['price'];
        $item->category_id=$request['category'];
        $item->barcode=$request['barcode'];
        $item->save();
        $item_id = $item->id;
        if($files = $request->file('img')){
            foreach ($files as $file){
             $name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
             $file->move("images", $name);
            
             $image = new \App\image;
     
             $image->name = $name;
             $image->item_id=$item_id;
     
             $image->save();
           }
        }

        return redirect('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = \App\item::find($id);

        $item->delete();
        return redirect('home');

    }
    public function deleteImage($id)
    {
        $image = \App\image::find($id);
        DB::table('images')->where('id', '=', $id)->delete();
        echo $image->name;
        if(\File::exists(public_path('images/'.$image->name))){

            \File::delete(public_path('images/'.$image->name));
        
          }else{
        
           echo 'File does not exists.';
        
          }

        return redirect()->back();

    }
    function action(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = \App\item::where('name', 'ilike', '%'.$query.'%')
         ->orderBy('id', 'DESC')->get();
         
      }
      
    
   
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $item)
       {
        $images=DB::table('images')->where('item_id', '=',$item->id)->get();
        
        $output .= '<div class="w3-col l3 s6">
        <div class="w3-container div3">
        
         <div id="myCarousel'.$item->id.'" class="carousel slide" data-ride="carousel" data-interval="false" >
     
  
     
      
      <div class="carousel-inner div1" >';
     
      foreach($images as $index => $image){
        $url=asset('images/'.$image->name);
      if ($index == 0) {
        
        $output .='
        <div class="item active">
        
        <a href="'.route("item.show",["id" => $item->id]).'"> <img src="'.$url.'"></a>
        </div> ';
      }   
       else{
       $output .='<div class="item">
       <a href="'.route("item.show",["id" => $item->id]).'">  <img height="150" width="110" src="'.$url.'"></a>
          
        </div>';
    }
    }
       
     
    $output .='</div>
  
      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel'.$item->id.'" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control"  href="#myCarousel'.$item->id.'" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div> ';
    
    if($item->quantity == 0){
        $output .='<p style="color:red;">Available Soon</p>';
        }
        else{
          
        $output .='<p><a href="'.route("item.show",["id" => $item->id]).'">'.$item->name.'</a></p>';
        }
        $output .='<b>$'.$item->price.'</b><br>';

        if (Auth::check()) {
            if(Auth::user()->type == 1){
              $output .='<b>Quantity : '.$item->quantity.'</b><br>';
            $output .='<a href="'.route("item.delete",["id" => $item->id]).'"><button type="button" class="btn btn-default" style="margin-bottom:10px;" style="color:black;"><b>Delete</b></button></a>
            <a  href="'.route("item.edit",["id" => $item->id]).'"><button type="button" class="btn btn-default" style="margin-bottom:10px;" style="color:black;"><b>Edit</b></button></a>';
          }
    
            else{
              $output .=' <button type="button" class="btn btn-default btn-addtocart" data-value="'.$item->id.'" style="margin-bottom:10px;" style="color:black;"><b>Add to Cart</b></button>';
          }
      }
      else{
          $output .=' <button type="button" class="btn btn-default btn-addtocart" data-value="'.$item->id.'" style="margin-bottom:10px;" style="color:black;"><b>Add to Cart</b></button>';
      }  
      $output .=' <hr>
    </div>
    
    </div>
    
    ';
    
       }
      }
      else
      {
       $output = '
       <div class="alert alert-dark">
       <h3 >No items with this name</h3>
       </div>       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }

}

