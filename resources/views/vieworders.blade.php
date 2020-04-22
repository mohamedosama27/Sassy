@extends('bar')

@section('content')

<table class="table" style="margin-top:100px;">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Phone</th>
      <th scope="col">Address</th>
      <th scope="col">items</th>
      <th scope="col" colspan="3">Actions</th>
      

      
    </tr>
  </thead>
  <tbody>
  @foreach($orders as $order)

    <tr>
      <th scope="row">
        <a href="{{ route('chat',['id' =>$order->user->id ]) }}">
          {{$order->user->name}}</a></th>
      <td>{{$order->user->phone}}</td>
      <td>{{$order->address}}</td>
      <td><ul>
      @foreach($order->items as $item)
        <li>{{$item->pivot->quantity}} of 
          <a href="{{route('item.show',['id' => $item->id])}}">{{$item->name}}</a></li>
        @endforeach

      </ul>
      </td>
      @if($order->status==NULL)
      <td><a href="{{route('order.accept',['id' => $order->id])}}"><i class="fa fa-2x fa-check-circle" style="color:green;"></i></a></td>
      <td><a href="{{route('order.reject',['id' => $order->id])}}"><i class="fa fa-2x fa-times-circle" style="color:red"></i></a></td>
      @endif
      <td><a href="{{route('order.delete',['id' => $order->id])}}"><i class="fa fa-2x fa-trash"></i></a></td>

    </tr>
  @endforeach
  </tbody>
</table>
    @endsection