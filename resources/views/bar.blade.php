<!DOCTYPE html>
<html>
<link rel="icon" type="image/png" href={{ URL::asset("images/icn.ico")}} >
<title>Sassy</title>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content= "width=device-width, user-scalable=no">

<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="csrf-token" content="{{ csrf_token() }}" />

<link rel="stylesheet" href="{{ asset('css/w3schools.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
a{
  color:black;
}
.wrapper{
position: relative;
}
.wrapper .countCart{
position: absolute;
top: -2px;
right: 0px; 
}
.countCart{
  background-color:red;
}
.wrapper .countmessage{
position: absolute;
top: 1px;
right: -9px; 
}
.countmessage{
  background-color:red;
}
body{
  margin-top:70px;
}
.icon {
  margin:5px;
  display:inline-block;
}
.toptitle
{
  margin:-5px;
  margin-top:5px;
  margin-bottom:-10px;
  letter-spacing: 7px;
  font-size: 24px;
}
.w3-bar{
  height:50px;
}
@media (max-width:370px){
  .toptitle
{
  margin-bottom:-10px;
  letter-spacing: 0px;
  font-size:20px ;
}
.topicons {
  margin-top:5px;
    font-size: 23px;
}

}
.topicons {
  margin-top:5px;
    font-size: 25px;
}

.chat_list {
	margin: 0;
	padding: 18px 16px 10px;
}
.chat_people {
	overflow: hidden;
	clear: both;
}
.chat_ib {
	float: left;
	padding: 0 0 0 15px;
	width: 88%;
  border-bottom: 1px solid #ddd;
}
.chat_ib h3 {
	font-size: 20px;
	color: #464646;
	margin: 0 0 8px 0;
}

.chat_ib h3 span {
	font-size: 13px;
	float: right;
}

.chat_ib p {
    font-size: 16px;
    color: #989898;
    margin: auto;
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    max-width:90%;
    text-overflow: ellipsis;
}

</style>
@auth
    @if(Auth::user()->type == 1)
@include('addcategory')
@endif
@endauth
<body >


<div class="w3-bar w3-black w3-large w3-top">


<a href="{{route('home')}}" style="color:white;">
<div class="w3-bar-item w3-wide toptitle"><b>Sassy</b></div></a>
  <a href="javascript:void(0)" class="w3-bar-item w3-button  w3-right" onclick="w3_open()">
  <i class="fa fa-2x fa-bars topicons"></i></a>
  <a href="{{ Request::is('cart') ? route('home') : route('cart') }}" class="w3-bar-item w3-button  w3-right" >
  <div class="wrapper">
  <i class="fa fa-shopping-cart fa-2x  w3-margin-right topicons"></i>
  <span class="badge countCart" id='countcart'>{{Session::has('number_of_items') ? Session::get('number_of_items'): ''}}</span>
  </div>
  </a>

  
</a>
 @auth 
@if(Auth::user()->type == 1)
<a href="javascript:void(0)"
   onclick="senders_open()" class="w3-bar-item w3-button w3-right" >
   @else
   <a href="{{ route('chat',['id' => Auth::user()->id]) }}" class="w3-bar-item w3-button w3-right" >
@endif
 @else
 <a href="{{ route('login')}}" class="w3-bar-item w3-button w3-right" >
  @endauth 

  <div class="wrapper">
          <i class="fa fa-2x fa-comments topicons"></i>
          <span class="badge countmessage" id='countmessages'></span>
          </div>
    </a>
  

                   
</div>


<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
    <h2 class="w3-wide">
<b>Sassy</b></h2>
  </div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <a href="{{route('home')}}" class="w3-bar-item w3-button w3-white"><i class="fa fa-home" style="margin-right:5px;"></i>Home</a>

    @auth
    <a href="{{ route('user.edit',['id' => Auth::user()->id]) }}" class="w3-bar-item w3-button w3-white"><i class="fa fa-user" style="margin-right:5px;"></i>Edit profile</a>

    <a href="{{route('logout')}}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"
                    class="w3-bar-item w3-button w3-white"><i class="fa fa-sign-out" style="margin-right:5px;"></i>Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
   
    @if(Auth::user()->type == 1)
  
    <a href="{{route('addadminview')}}" class="w3-bar-item w3-button w3-white"><i class="fa fa-plus" style="margin-right:5px;"></i>Add Admin</a>

    <a href="{{route('item.create')}}" class="w3-bar-item w3-button w3-white"><i class="fa fa-plus" style="margin-right:5px;"></i>Add Item</a>
    <a href="{{route('vieworders')}}" class="w3-bar-item w3-button w3-white"><i class="fa fa-list" style="margin-right:5px;"></i>View Orders</a>
    <a href="{{route('category.edit')}}" class="w3-bar-item w3-button w3-white"><i class="fa fa-edit" style="margin-right:5px;"></i>Edit Categories</a>
    <a data-toggle="modal" data-target="#addcategory" class="w3-bar-item w3-button w3-white"><i class="fa fa-plus" style="margin-right:5px;"></i>Add Category</a>
    <!-- <a href="{{route('viewmails')}}" class="w3-bar-item w3-button w3-white"><i class="fa fa-envelope" style="margin-right:5px;"></i>View Mails</a>  -->

@endif
@else
<a href="{{ Request::is('login') ? route('home') : route('login') }}"" class="w3-bar-item w3-button w3-white"><i class="fa fa-sign-in fa-lg " style="margin-right:5px;"></i>Login</a>

@endauth

    <a onclick="myAccFunc()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="myBtn">
    <i class='fa fa-product-hunt'></i> Products <i class="fa fa-caret-down"></i>
    </a>
    <div id="demoAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium">
    @php( $categories = \App\category::all() )
    @foreach($categories as $category)
      <a href="{{route('category',['id' => $category->id])}}" class="w3-bar-item w3-button w3-white"><i class="fa fa-caret-right w3-margin-right"></i>{{$category->name}}</a>
        
      @endforeach
    </div>


    <!-- <a href="#" class="w3-bar-item w3-button w3-white">
      <i class='fa fa-phone' style="margin-right:5px;">
    </i>Contact</a>
    <a href="{{route('viewmails')}}" class="w3-bar-item w3-button w3-white"><i class="fa fa-envelope" style="margin-right:5px;"></i>Mail Us</a> 
   -->
  </div>
  
</nav>


<!-- Top menu on small screens -->

<nav class="w3-sidebar w3-bar-block w3-white w3-top" style="z-index:3;width:250px;display:none;" id="senders">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="senders_close()" class="fa fa-remove w3-button w3-display-topright"></i>
    <h2 class="w3-wide">
  <span class="icon">


</span><b>Notifications</b></h2>
  </div>
  <a href="{{route('users')}}" class="w3-bar-item w3-button w3-white">
  <button type="submit" class="w3-btn btn-block w3-round-xxlarge w3-light-blue">Show All</button>
</a>


  <div class="w3-padding-64 w3-large senders" style="font-weight:bold">
  
     </div>
  
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
<div class="w3-main" style="margin-left:250px">

  <!-- Push down content on small screens -->
  <div class="w3-hide-large" style="margin-top:83px"> </div>

  
  @yield('content')

 







</div>



<script>

// Accordion 
function myAccFunc() {
  var x = document.getElementById("demoAcc");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}
// Click on the "Jeans" link on page load to open the accordion for demo purposes
// document.getElementById("myBtn").click();
// Open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}
function senders_open() {
  document.getElementById("senders").style.display = "block";
  getSenders();
}
 
function senders_close() {
  document.getElementById("senders").style.display = "none";
}
$.ajaxSetup({

headers: {

    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

}

});
@auth
countmessages();

setInterval(countmessages, 5000);
@endauth
function countmessages() { 
$.ajax({

type:'POST',
_token: $('meta[name=csrf_token]').attr('content'),

url:"{{ route('countmessage') }}",

data:{},
datatype:'json',

success:function(data)
{
    if(data.countmessages != 0){
      $("#countmessages").text(data.countmessages);
    }
    else{
      $("#countmessages").text('');

    }
}

});
}

function getSenders() {

$.ajax({

type:'POST',
_token: $('meta[name=csrf_token]').attr('content'),

url:"{{ route('getSenders') }}",

data:{},
datatype:'json',

success:function(data)
{
  $( ".senders" ).html( $( data.senders ) );
}

});

}
</script>
</body>
</html>