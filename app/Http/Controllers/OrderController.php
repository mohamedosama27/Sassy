<?php

namespace App\Http\Controllers;
use \App\Mail\SendMail;
use Illuminate\Http\Request;
use App\Event\CreateOrder;
use App\Http\Controllers\MessageController;
use Nexmo\Laravel\Facade\Nexmo;

use Session;
use DB;

class OrderController extends Controller
{
    public function showAll()
    {
        $orders = \App\order::orderBy('id', 'DESC')->get();
        $items=DB::table('item_order')->get();

        return view('vieworders',[
            'orders'=>$orders,
            'items'=>$items,

        ]);
       
    }
    public function create(Request $request)
    {
        $selcteditems = Session::has('selcteditems') ? Session::get('selcteditems') : array();

        $order = new  \App\order;
        $order->user_id = auth()->id();
        $order->address=$request['address'];
        $order->save();
        // $order = \App\order::find($order->id);
        $totalprice=0;
       
        foreach($selcteditems as $selecteditem)
        {
            $item = \App\item::find($selecteditem->item->id);
            $item->quantity-=$selecteditem->Quantity;
            $item->save();

            $totalprice+=$selecteditem->Quantity*$selecteditem->item->price;
            DB::table('item_order')->insert(
                ['item_id' => $selecteditem->item->id,
                 'order_id' => $order->id,
                'quantity' =>$selecteditem->Quantity]
            );
       
        }
        $order->total_price=$totalprice;
        $order->save();
        Session::put('number_of_items',0 );
        Session::put('selcteditems',array());
        
        $details = [
            'title' => 'You have new order',
            'order' => $order ,
        ];
        Nexmo::message()->send([
            'to'   => '+201118221684',
            'from' => '+201118221684',
            'text' => 'You submit new order  http://aqueous-dawn-37150.herokuapp.com/chat/'.auth()->id()." .",
        ]);
        // \Mail::to('mohamed1705725@miuegypt.edu.eg')->send(new SendMail($details));

             return redirect('home');
    }
    public function accept($id)
    {
        $order = \App\order::findorfail($id);
        $order->status=1;
        $order->save();
        $message=MessageController::createmessage('Your order accepted','0',$order->user->id);
        return redirect('vieworders');


    }
    public function reject($id)
    {
        $order = \App\order::findorfail($id);
        $order->status=0;
        $order->save();
        return redirect('vieworders');


    }
    public function destroy($id)
    {
        $order = \App\order::findorfail($id);
        $order->delete();
        DB::table('item_order')->where('order_id', '=', $id)->delete();
        return redirect('vieworders');

        


    }


 
}
