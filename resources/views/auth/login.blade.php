@extends('bar')
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
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
    <form method="POST" action="{{ route('login') }}">
    @csrf

  <div class="input-group mb-3 space">
  <div class="input-group-prepend margintop">
    <span class="input-group-text" >
    <i class="fa fa-envelope formicon"></i>
    </span>
  

  
  <input type="email" class="form-control  @error('email') is-invalid @enderror" id="basic-addon1" name="email" value="{{ old('email') }}" type="email" placeholder="Email" name="email" required autocomplete="email"  aria-describedby="basic-addon1">
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
  <i class="fa  fa-key formicon"></i>

  </span>

    <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" required autocomplete="current-password">
    </div>
    @error('password')
                                    <span role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror  
</div>
<a href="register" class="margintop" style="float:right;margin-bottom:10px;">Create Account</a>

  <button type="submit" class="w3-btn btn-block w3-round-xxlarge w3-light-blue" style="margin-bottom:10px;">Login</button>
<br>
</form>
</div>
</div>
<!-- <a class="btn btn-lg btn-primary btn-block" href="{{ url('auth/facebook') }}">
 <strong>Login With Facebook</strong>
 </a> -->



@endsection
