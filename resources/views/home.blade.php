@extends('bar')

@section('content')
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="csrf-token" content="{{ csrf_token() }}" />

<link rel="stylesheet" href="{{ asset('css/home.css') }}">


<br>

 
  <div class="cardspace ">
  <input type="text" name="search" id="search" class="form-control" placeholder="Search by name" />
  <input type="number" id="countitems" value="{{count($items)}}"hidden/>
<div class="cardspace">

  <div class=" w3-grayscale" id="results">
  

<section class="items endless-pagination" @if(count($items)>10) data-next-page="{{ $items->nextPageUrl() }}" @endif>
    @foreach($items as $item)

<div class="w3-col l3 s6">
      <div class="w3-container div3">
      
  <div id="myCarousel{{$item->id}}" class="carousel slide" data-ride="carousel" data-interval="false" >
   
 
    <!-- Wrapper for slides -->
    
    <div class="carousel-inner div1" >
    

    @foreach($item->images as $image)

    @if ($loop->first)
    <div class="item active" >
    <a href="{{route('item.show',['id' => $item->id])}}"> <img src={{ URL::asset("images/{$image->name}")}}></a>
      </div>    
     @else
      <div class="item">
      <a href="{{route('item.show',['id' => $item->id])}}">  <img src={{ URL::asset("images/{$image->name}")}}></a>
        
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

        <a href="{{route('item.delete',['id' => $item->id])}}" onclick="return confirm('Are you sure to delete {{$item->name}}?')"><button type="button" class="btn btn-default" style="margin-bottom:10px;" style="color:black;"><b>Delete</b></button></a>
        <a href="{{route('item.edit',['id' => $item->id])}}"><button type="button" class="btn btn-default" style="margin-bottom:10px;" style="color:black;"><b>Edit</b></button></a>


        @else
        <button  
        @if($item->quantity == 0)
        disabled
        @endif type="button" class="btn btn-default btn-addtocart" data-value="{{$item->id}}" style="margin-bottom:10px;" style="color:black;" ><b>Add to Cart</b></button>

        @endif
        @else
        <button  @if($item->quantity == 0)
        disabled
        @endif
         type="button" class="btn btn-default btn-addtocart" data-value="{{$item->id}}" style="margin-bottom:10px;" style="color:black;" ><b>Add to Cart</b></button>
      @endauth

        <hr>
</div>

</div>

    @endforeach
    </section>

    </div>

</div>

<br>


</div>
<br>
<i class="fa fa-lg fa-spinner fa-spin" style="margin-left:50%"></i>
@include('errormessage')

{{--{!! $items->render() !!}--}}

<script type="text/javascript">


    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });

    
$(document).on("click", '.btn-addtocart', function(e) { 

       e.preventDefault();

           var str =  $(this).data('value');;
        $.ajax({

           type:'POST',

           url:"{{ route('item.addToCart') }}",

           data:{name:str},

           success:function(data){

            if(data.message===undefined)
            {

              $("#countcart").text(data.countCart);
            }
            else
            {
              $('#messaga').text(data.message)
              $('#errormessage').modal();
            }
              
           }

        });

  

	});
  $(document).ready(function(){

      fetch_customer_data();

      function fetch_customer_data(query = '')
      {
      $.ajax({
        url:"{{ route('ItemController.action') }}",
        method:'GET',
        data:{query:query},
        dataType:'json',
        success:function(data)
        {
        $('#results').html(data.table_data);
        $('.fa-spinner').hide();

        }
      })
      }

$(document).on('keyup', '#search', function(){
 var query = $(this).val();
 if(query != '')
      {
 fetch_customer_data(query);
      }
      else{
        location.reload(true);

              }
  
});
$(window).scroll(fetchitems);


function fetchitems() {


    var page = $('.endless-pagination').data('next-page');

    if(page !== null) {

        clearTimeout( $.data( this, "scrollCheck" ) );

        $.data( this, "scrollCheck", setTimeout(function() {
            var scroll_position_for_items_load = $(window).height() + $(window).scrollTop() + 100;

            if(scroll_position_for_items_load >= $(document).height()) {
                $.get(page, function(data){
                    
                    var numberofitems=$("#countitems").val();
                    if(numberofitems<=10)
                    {
                      $('.items').html(data.items);
                    $('.endless-pagination').data('next-page', data.next_page);
                      $("#countitems").val(numberofitems+data.numberofitems);

                    }
                    else{
                      $('.items').append(data.items);
                    $('.endless-pagination').data('next-page', data.next_page);
                    }
                    
                });
            }
        }, 350))

    }
    else{
      
      $('.fa-spinner').hide();
        }
}


});

</script>



@endsection
