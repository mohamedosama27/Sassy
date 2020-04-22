@extends('bar')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

@section('content')



<style>
    .cardspace{
        margin:10px;
    }
    .margintop{
        margin-top:10px;
    }
    .formicon {
    font-size: 20px;
  }
</style>
<br>
<div class="w3-card cardspace">

<div class="cardspace">
    <form method="POST" action="{{ route('register') }}">
    @csrf
<br>
  <h2>Create Account</h2>
  <br>
  <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" >
    <i class="fa fa-user formicon"></i>
    </span>
    <input class="form-control" type="text" placeholder="Name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
  </div>
  </div>

  <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" >
    <i class="fa fa-envelope formicon"></i>
    </span>
    <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" type="email" placeholder="Email" name="email" required autocomplete="email" autofocus>

</div>
@error('email')
                                     <span role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" >
    <i class="fa fa-key formicon"></i>
    </span>
    <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" required autocomplete="current-password">

  
</div>
@error('password')
                                    <span role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" >
    <i class="fa fa-key formicon"></i>
    </span>
    <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="Repeat Password" name="password_confirmation" required autocomplete="current-password">
</div>
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" >
    <i class="fa fa-phone-square formicon"></i>
    </span>
    <input class="form-control @error('phone') is-invalid @enderror" type="text" placeholder="Phone Number" name="phone" required>

   
</div>
@error('phone')
                                    <span role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror  
</div>
  <button type="submit" class="w3-btn btn-block w3-round-xxlarge w3-light-blue">Sign Up</button>
  <br>
</form>
</div>
</div>



@endsection
