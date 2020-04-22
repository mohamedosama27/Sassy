<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\cart;

class CartController extends Controller
{
    public function showCart()
    {   
        $selcteditems = Session::has('selcteditems') ? Session::get('selcteditems') : array();
        return view('cart',[
            'items'=>$selcteditems ?? 'Doesnot exist'
        ]);
    }
    public function removeItem($id)
    {
        $selcteditems = Session::get('selcteditems'); 
        $number_of_items = Session::has('number_of_items') ? Session::get('number_of_items') : 0;

        for($i=0;$i<sizeof($selcteditems);$i++)
        {
            if($selcteditems[$i]->item->id == $id)
            {
                $number_of_items-=$selcteditems[$i]->Quantity;
                unset($selcteditems[$i]);
                $selcteditems = array_values($selcteditems);
                Session::put('selcteditems', $selcteditems);
                Session::put('number_of_items',$number_of_items );

            }
        }
        return redirect('cart');

    }
    public function AddToCart(Request $request)
    {
        $id=$request['name'];
        $number_of_items = Session::has('number_of_items') ? Session::get('number_of_items') : 0;
        $selcteditems = Session::has('selcteditems') ? Session::get('selcteditems') : array();
        $found=false;
        $item = \App\item::find($id);

    foreach($selcteditems as $selcteditem)
    {
        if($selcteditem->item->id == $id)
        {
            if($item->quantity<$selcteditem->Quantity+1)
            {
                $message='No enough items available';
                return response()->json(['message'=>$message]);
            }
            else
            {
                $selcteditem->Quantity+=1;
                $found=true;
            }
        }
    }
    if($found==false)
    {
        $item = new cart($id);
        array_push($selcteditems,$item);
    }
    
    $number_of_items++;
    Session::put('number_of_items',$number_of_items );
    Session::put('selcteditems',$selcteditems);

    return response()->json(['countCart'=>$number_of_items]);

    }
    public function decrementItem(Request $request)
    {
        $id=$request['id'];
        $selcteditems = Session::get('selcteditems'); 
        $number_of_items = Session::has('number_of_items') ? Session::get('number_of_items') : 0;
        $totalprice=0;

        for($i=0;$i<sizeof($selcteditems);$i++)
        {
            if($selcteditems[$i]->item->id == $id && $selcteditems[$i]->Quantity > 1)
            {
                $number_of_items-=1;
                $selcteditems[$i]->Quantity-=1;
                $quantity=$selcteditems[$i]->Quantity;
                $item_total_price=$quantity*$selcteditems[$i]->item->price;
                Session::put('selcteditems', $selcteditems);
                Session::put('number_of_items',$number_of_items );

            }
            $totalprice+=$selcteditems[$i]->Quantity*$selcteditems[$i]->item->price;

        }
        return response()->json(['quantity'=>$quantity,
                                'item_total_price'=>$item_total_price,
                                'countCart'=>$number_of_items,
                                'totalprice'=>$totalprice]);
    }
    public function incrementItem(Request $request)
    {
        $id=$request['id'];
        $selcteditems = Session::get('selcteditems'); 
        $number_of_items = Session::has('number_of_items') ? Session::get('number_of_items') : 0;
        $totalprice=0;
        $item = \App\item::find($id);

        for($i=0;$i<sizeof($selcteditems);$i++)
        {
            if($selcteditems[$i]->item->id == $id)
            {
                if($item->quantity<$selcteditems[$i]->Quantity+1){
                    $message='No enough items available';
                    return response()->json(['message'=>$message]);
                }
                $number_of_items+=1;
                $selcteditems[$i]->Quantity+=1;
                $quantity=$selcteditems[$i]->Quantity;
                $item_total_price=$quantity*$selcteditems[$i]->item->price;
                Session::put('selcteditems', $selcteditems);
                Session::put('number_of_items',$number_of_items );

            }
            $totalprice+=$selcteditems[$i]->Quantity*$selcteditems[$i]->item->price;

        }
        return response()->json(['quantity'=>$quantity,
                                'item_total_price'=>$item_total_price,
                                'countCart'=>$number_of_items,
                                'totalprice'=>$totalprice]);

    }
    
}
