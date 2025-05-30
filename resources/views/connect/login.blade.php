@extends('connect.master')
{{-- @section('title', 'Login') --}}
@section('content')
<div class="login-box style-login shadow-lg p-3 bg-body rounded"> 
  <!--div class="login-logo">
    <a href="../../index2.html">ROGER VENTAS</a>
  </div-->
  <div class=" row justify-content-center">
    <div class="justify-content-center brand-link ">
        <img src="{{$logo}}" alt="" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class=""><strong>{{strtoupper(substr($name,0,17))}}</strong></span>
    </div>
  </div>

  <!-- /.login-logo -->
  <div class="card ">
    <div class="card-body login-card-body style-login">
      <p class="login-box-msg">Inicia sesión con tu cuenta</p>
      <!--inicio del formulario-->
      {!! Form::open(['url'=>'/login','autocomplete'=>'off'])!!}  
      {{-- <form action="../../index3.html" method="post"> --}}
        <div class="input-group mb-3">
          {{-- <input type="email" class="form-control" placeholder="Email"> --}}
          {!! Form::email('email',null,['class'=>'form-control style-input','placeholder'=>'Correo']) !!}
          <div class="input-group-append">
            <div class="input-group-text style-icon-fas">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          {{-- <input type="password" class="form-control" placeholder="Password"> --}}
          {!! Form::password('password',['class'=>'form-control style-input','placeholder'=>'password']) !!}
          <div class="input-group-append">
            <div class="input-group-text style-icon-fas">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          {{-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> --}}
          <!-- /.col -->
          <div class="container">
            {{-- <button type="submit" class="btn btn-primary btn-block">Sign In</button> --}}
            {!! Form::submit('Ingresar',['class'=>'btn btn-login btn-block']) !!}
          </div>
          <!-- /.col -->
        </div>
      {{-- </form> --}}
      {!! Form::close()!!}
      @if(Session::has('message'))
      <div class="container"><br>
        <div class="alert alert-{{ Session::get('typealert') }}" style="display:none;">
        {{ Session::get('message') }}
          @if($errors->any())
            <ul>
              @foreach($errors->all() as $error )
                <li>{{$error}}</li>
              @endforeach
            </ul>
          @endif
          <script>
          //$(".alert").slideDown();
          setTimeout(function(){ $('.alert').slideDown(); }, 1000);
          setTimeout(function(){ $('.alert').slideUp(); }, 5000);

          </script>
        </div>
      </div>
      @endif
      <!--fin del formulario-->  
      {{-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> --}}
      <!-- /.social-auth-links -->

      {{-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> --}}
      <p class="mb-0">
        {{-- <a href="{{ url('/register') }}" class="text-center">Registrar un nuevo usuario</a> --}}
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<style>
  .style-body{
    background-color: rgb(35,38,39);
  }
  .style-login{
    background-color: #0C162D;
    color: #ffffff !important;
    opacity: 2;

  }
  .style-input{
      background-color: #04193E !important;
      color:white !important;
  }
  .style-icon-fas{
      background-color: #04193E !important;
      color:white !important;
  }
  .btn-login{
    background-color:#242D3E;
    color: #ffffff;
  }
  .btn-login:hover{
    color: aquamarine;
    font-size: 17px;
  }
</style>
@stop