@extends('bar')

@section('content')

<link href="css/cart.css" rel="stylesheet" type="text/css" media="all" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>

.item{
      text-align:center;
      }
     
      .carousel img {
        width:100%;
        height: 100%!important;
        display:inline-block  !important;
      }

/* Create two equal columns that floats next to each other */
.column1 {
  float: left;
  width: 50%;
  padding: 10px;
}



/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  
  .column1 {
    width: 100%;
  }
}
.product-details{
  width: auto;
}

</style>
@php
$totalprice=0
@endphp
@if(Session::get('number_of_items')!=0)
<br>
<div class="w3-card cardspace">

<div class="cardspace">
<div class="shopping-cart">

<br>


@foreach($items as $selecteditem)
  <div class="product row" >
    <div class="column1">
  <div id="myCarousel{{$loop->iteration}}" class="carousel slide div1" data-ride="carousel" data-interval="false" >
   

   <!-- Wrapper for slides -->
   
   <div class="carousel-inner div1" >
  
   @foreach($selecteditem->item->images as $image)
   @if ($loop->first)
   <div class="item active div1">
       <img src="images\{{$image->name}}" height="150" width="110">
     </div>    
    @else
     <div class="item div1">
       <img height="150" width="110" src="images\{{$image->name}}">
       
     </div>
     @endif
     @endforeach

     
   </div>

   <!-- Left and right controls -->
   <a class="left carousel-control" href="#myCarousel{{$loop->iteration}}" data-slide="prev">
     <span class="glyphicon glyphicon-chevron-left"></span>
     <span class="sr-only">Previous</span>
   </a>
   <a class="right carousel-control" href="#myCarousel{{$loop->iteration}}" data-slide="next">
     <span class="glyphicon glyphicon-chevron-right"></span>
     <span class="sr-only">Next</span>
   </a>
 </div>
 </div>
 <div class="column1">
 <h3>{{$selecteditem->item->name}}</h3>
    <div class="product-details">
      
      <p class="product-description">{{$selecteditem->item->description}}</p>
    </div>
    
    </div>
    <div class="product-price">{{$selecteditem->item->price}}</div>
    <div class="row product-quantity" >

    <button type="button" class="btn-increment" data-value="{{$selecteditem->item->id}}" style="margin-bottom:10px;" style="color:black;">
    <i class="fa fa-plus-square"></i></button>

  
      <p id="quantity{{$selecteditem->item->id}}">{{$selecteditem->Quantity}}</p>

      <button type="button" class="btn-decrement" data-value="{{$selecteditem->item->id}}" style="margin-bottom:10px;" style="color:black;">
      <i class="fa fa-minus-square"></i>
      </button>
  
</div>
    
    <div class="product-removal">
    <a href="{{route('removefromcart',['id' => $selecteditem->item->id])}}">
    <button class="remove-product">
        Remove
      </button></a>
    </div>
    
    <b class="totalprice">Total price : </b><div class="product-line-price" style="margin-left:10px;" id="totalprice{{$selecteditem->item->id}}">{{$selecteditem->item->price*$selecteditem->Quantity}}</div>
  
  </div>
  
  @php $totalprice+=$selecteditem->item->price*$selecteditem->Quantity @endphp
  @endforeach
  </div>
  </div>
  </div>



  <div class="totals cardspace">
    <div class="totals-item">
      <label>Subtotal : </label>
      <div class="totals-value" id="cart-subtotal">{{$totalprice}}</div>
    </div>
    <div class="totals-item">
      <label>Delivery : </label>
      <div class="totals-value" id="cart-tax">10</div>
    </div>
   
    <div class="totals-item totals-item-total">
      <label>Total Price : </label>
      <div class="totals-value" id="cart-total">{{$totalprice+10}}</div>
    </div>
  </div>
  @include('errormessage')
  @include('addaddress')

  <a  @auth data-toggle="modal" data-target="#addaddress" @else href=" login" @endauth >
  <button class="checkout">Checkout</button>
</div>
<br>

</div>
@else
<div class="alert alert-dark" role="alert">
<h1 style="margin-left:13%">No items in cart</h1>
</div>

@endif


<script type="text/javascript">

   

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $(document).on("click", '.btn-decrement', function(e) { 

        e.preventDefault();

            var id =  $(this).data('value');
        $.ajax({

            type:'POST',

            url:"{{ route('decrementItem') }}",

            data:{id:id},
            datatype:'json',

            success:function(data){
              $("#cart-subtotal").text(data.totalprice);
              $("#cart-total").text(data.totalprice+10);
              $("#quantity"+id).text(data.quantity); 
              $("#totalprice"+id).text(data.item_total_price)             
              $("#countcart").text(data.countCart);
              

       
            }

        });

});
    $(document).on("click", '.btn-increment', function(e) { 


  

       e.preventDefault();

           var id =  $(this).data('value');
        $.ajax({

           type:'POST',

           url:"{{ route('incrementItem') }}",

           data:{id:id},
           datatype:'json',

           success:function(data){

            if(data.message===undefined){

              $("#quantity"+id).text(data.quantity);
              $("#cart-total").text(data.totalprice+10);    
              $("#totalprice"+id).text(data.item_total_price);   
              $("#countcart").text(data.countCart);
              $("#cart-subtotal").text(data.totalprice);

            }
            else
            {
              $('#messaga').text(data.message)
              $('#errormessage').modal();
            }

    
           }

        });

	});

 

</script>

@endsection