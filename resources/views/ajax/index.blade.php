@foreach($items as $item)


<div class="w3-col l3 s6">

      <div class="w3-container div3">
      
  <div id="myCarousel{{$item->id}}" class="carousel slide" data-ride="carousel" data-interval="false" >
   

    <!-- Wrapper for slides -->
    
    <div class="carousel-inner div1" >
   
    @foreach($item->images as $image)
    @if ($loop->first)
    <div class="item active">
        <img src='{{ URL::asset("images/{$image->name}")}}'>
      </div>    
     @else
      <div class="item">
        <img height="150" width="110" src='{{ URL::asset("images/{$image->name}")}}'>
        
      </div>
      @endif
      @endforeach

   
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel{{$item->id}}" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel{{$item->id}}" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  @if($item->quantity == 0)
  <p style="color:red;">Available Soon</p>
  @else
  <p><a href="{{route('item.show',['id' => $item->id])}}">{{$item->name}}</a></p>
  @endif
  <b>${{$item->price}}</b><br>
      @auth
        @if(Auth::user()->type == 1)
        <b>Quantity : {{$item->quantity}}</b><br>

        <a href="{{route('item.delete',['id' => $item->id])}}"><button type="button" class="btn btn-default" style="margin-bottom:10px;" style="color:black;"><b>Delete</b></button></a>
        <a href="{{route('item.edit',['id' => $item->id])}}"><button type="button" class="btn btn-default" style="margin-bottom:10px;" style="color:black;"><b>Edit</b></button></a>


        @else
        <button type="button" class="btn btn-default btn-addtocart" data-value="{{$item->id}}" style="margin-bottom:10px;" style="color:black;"><b>Add to Cart</b></button>

        @endif
        @else
        <button type="button" class="btn btn-default btn-addtocart" data-value="{{$item->id}}" style="margin-bottom:10px;" style="color:black;"><b>Add to Cart</b></button>
      @endauth

        <hr>
</div>

</div>


@endforeach