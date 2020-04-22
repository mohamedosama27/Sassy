@extends('bar')

@section('content')
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
.envelopeicon{
  float:right;
  font-size: 25px;
  margin-bottom:5px;

}
.fa-envelope{
  color:green;
}
.fa-envelope-open{
  color:red;
}

.chat_ib p {
  max-width:85%;

}
</style>
<input type="text" name="search" id="search" class="form-control" placeholder="Search by name"/>
<div id="result">
@foreach($messages as $message)
<a class="chatlink" href="{{route('chat',['id' => $message->sender->id])}}">

                <div class="chat_list">
                <div class="chat_people" >
                  <div class="chat_ib" >
                    <h3>{{$message->sender->name}} 
                    <span class="chat_date"> {{$message->created_at}}</span></h3>
                    <p>{{$message->message}}</p>  
                    @if($message->status==NULL || $message->status==2 ) <i class="fa fa-envelope envelopeicon"></i> 
                    @else
                    <a href="{{route('changeStatus',['id' => $message->id])}}">
                      <i class="fa fa-envelope-open envelopeicon"></i></a>
                    @endif               
                  </div>
                </div>
              </div>
              
              </a>
 @endforeach 
 </div>
 <script type="text/javascript">

window.onpageshow = function(evt) {
    // If persisted then it is in the page cache, force a reload of the page.
    if (evt.persisted) {
        document.body.style.display = "none";
        location.reload();
    }
};

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $(document).on('keyup', '#search', function(e)
    {
        e.preventDefault();


        var query = $(this).val();

        $.ajax({

        type:'POST',

        url:"{{ route('user.search') }}",

        data:{query:query},

        success:function(data)
        {

            $('#result').html(data.users);

        }

        });

        
    });
</script>
@endsection
