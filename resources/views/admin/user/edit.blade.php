@extends('layouts.admin')
@section('contenido')
<div class="container"><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5>Editar Usuarios</h5></div>

                <div class="card-body">
                    @include('custom.message')
                    <form action="{{route('user.update',$user->id)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="container">
                        <div class="input-group mb-3">
                            <div class="input-group-append" >
                                <div class="input-group-text style-icon-fas">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control " name="name" id="name" value="{{old('name',$user->name)}}" placeholder="Nombre">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <div class="input-group-text style-icon-fas">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control "  name="email" id="email" value="{{old('email',$user->email)}}" placeholder="slug">
                        </div>
                        {{-- <div class="form-group">
                            <input type="password" class="form-control" name="password" id="password" value="old{{'email',$user->password}}" placeholder="Ingresa el password">
                        </div> --}}
                        {{-- {{$user->roles[0]->name}} --}}
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <div class="input-group-text style-icon-fas">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                            </div>
                            <select name="roles" id="roles" class="form-control ">
                            <option value="selecciona">Seleciona un rol</option>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}"
                                    @isset($user->roles[0]->name)
                                        @if($role->name == $user->roles[0]->name)
                                           selected 
                                        @endif
                                    @endisset
                                >{{$role->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <button type="submit" class="btn btn6 mx-2"><i class="fas fa-check-circle text-success mr-2"></i>Actualizar</button>
                        <a class="btn btn5" href="{{route('user.index')}}"><i class="fas fa-window-close mr-2 "></i>Regresar</a>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                    </form>
                    {{-- {!! dd(old()) !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
