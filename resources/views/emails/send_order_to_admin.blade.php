@component('mail::message')
# {{ $details['title'] }}
    
Client name : {{$details['order']->user->name}} <br />
Client phone : {{$details['order']->user->phone}} <br />
Client address : {{$details['order']->address}} <br />


@foreach($details['order']->items as $item)
  - {{$item->pivot->quantity}} of {{ $item->name }}
@endforeach
 @endcomponent

