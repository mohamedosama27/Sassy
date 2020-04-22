@extends('bar')

@section('content')
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="csrf-token" content="{{ csrf_token() }}" />

<style>
.chat {
    
  margin: 0 auto;
  padding: 0 20px;
}


.footer {
    height:50px;
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: white;
   color: black;
   
}
@media (min-width:992px){
    .footer {
        margin-left:300px;
        width:80%;

    }
    
  
}
.messageinput{
    margin:5px;
    width:85%;
    display:inline;
}
.messagebutton{
    background-color: blue;
    border:none;

    border-radius: 50%;
}
.sendicon{
    color:white;
}

.msg-right{
    z-index:-1;
    background:#3BA1EE;
    padding:5px;
    padding-right:10px;
padding-left:10px;
    text-align:right;
    color:#fff;
    margin:5px;
    width:auto;
     max-width:70%;
         float:right;
  margin-right: 30px;
  border-radius: 15px;
  
  

}
.msg-left{
    z-index:-1;
    background:#ddd;
    padding:5px;
    padding-right:10px;
    margin:5px;
     width:auto;
     max-width:70%;
    float:left;
  margin-left: 30px;
  border-radius: 15px;

}
.msg-left:before {
    z-index:-1;
   width: 0;
    height: 0;
    content: "";
    top:17px;
    left: -16px;
    position: relative;
    border-style: solid;
    border-width: 20px 0px 0px 20px;
    border-color: #ddd transparent transparent transparent;
   
}
.msg-right:after {
    z-index:-1;
   width: 0;
    height: 0;
    content: "";
    top: 16px;
    left: 16px;
    position: relative;
    border-style: solid;
    border-width: 20px 20px 00px 0px;
    border-color: #3BA1EE transparent transparent transparent;
  
   
}
.time-right{
    float:right;
}
@media (max-width:470px){
    .messageinput{
    margin:5px;
    width:75%;
    display:inline;
}
.sendicon {
    font-size: 20px;
  }

}

</style>
<div class=" chat">
<input id="senderid" value="{{$sender_id}}" hidden/>
<input type="number" id="countMessages" value="{{count($messages)}}" hidden/>
@foreach($messages as $message)
@if($message->sender_id == Auth::user()->id)

<div class="msg-right msg" @if($loop->last) style="margin-bottom:50px" @endif>
  
 {{$message->message}} 
</div>
<br clear="all" />

@elseif($message->sender_id == 0 && Auth::user()->type==1)


<div class="msg-right msg" @if($loop->last) style="margin-bottom:50px" @endif>
  
{{$message->message}} 
</div>
<br clear="all" />


@else
<div class="msg-left msg"  @if($loop->last) style="margin-bottom:50px" @endif>
{{$message->message}}
</div>

<br clear="all" />
@endif
@endforeach
<div class="footer">

<input class="form-control messageinput" id="message" autocomplete="off">
  <button type="button" class="messagebutton btn-send"> <i class="fa fa-paper-plane sendicon" ></i></button>
</div>

<div>

<script type="text/javascript">

   

$.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

});
setInterval(getmessage, 5000);
$(document).on("click", '.btn-send', function(e) { 

    e.preventDefault();
   
        var message =  $("#message"). val();
        var id =  $("#senderid"). val();
    $.ajax({

        type:'POST',
        _token: $('meta[name=csrf_token]').attr('content'),

        url:"{{ route('sendmessage') }}",

        data:{message:message,id:id},
        datatype:'json',

        success:function(data){
            $("#message").val('');
            $('.msg').css('margin-bottom','0px')
            $( ".chat" ).append( $( data.output ) );
            if($("#countMessages").val()==0){
                $("#countMessages").val('1')
                automatedmessage();  
            }
       $(function(){
    $('html, body').animate({scrollTop: $(document).height()-$(window).height()}, 0);
      });
        }

    });

});
function getmessage() { 

    var sender_id =  $("#senderid"). val();

$.ajax({

    type:'POST',
    _token: $('meta[name=csrf_token]').attr('content'),

    url:"{{ route('getmessage') }}",

    data:{sender_id:sender_id},
    datatype:'json',

    success:function(data){
      if(data.output!=''){
        $("#countMessages").val('1')
        $('.msg').css('margin-bottom','0px')
        $( ".chat" ).append( $( data.output ) );
        $(function(){
$('html, body').animate({scrollTop: $(document).height()-$(window).height()}, 0);
  });
    }
  
    }

});

}
function automatedmessage() { 


$.ajax({

type:'POST',
_token: $('meta[name=csrf_token]').attr('content'),

url:"{{ route('automatedmessage') }}",

data:{},
datatype:'json',

success:function(data){

  if(data.output!=''){
    $('.msg').css('margin-bottom','0px')
    $( ".chat" ).append( $( data.output ) );
    $(function(){
$('html, body').animate({scrollTop: $(document).height()-$(window).height()}, 0);
});
}

}

});

}
$(function(){
    $('html, body').animate({scrollTop: $(document).height()-$(window).height()}, 0);
});
</script>
@endsection
