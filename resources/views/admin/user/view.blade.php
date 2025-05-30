@extends('layouts.admin')

@section('contenido')
<div class="container"><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5>Mostra Usuario</h5></div>

                <div class="card-body">
                    @include('custom.message')
                    <form action="{{route('user.show',$user->id)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="container">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name',$user->name)}}" placeholder="Nombre" disabled>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"  name="email" id="email" value="{{old('email',$user->email)}}" placeholder="slug" disabled>
                        </div>
                        {{-- <div class="form-group">
                            <input type="text" class="form-control" name="password" id="password" value="{{Crypt::decrypt($user->password)}};" placeholder="Ingresa el password" disabled>
                        </div> --}}
                        {{-- {{$user->roles[0]->name}} --}}
                        <div class="form-group">
                            <select name="roles" id="roles" class="form-control" disabled>
                            <option>Seleciona un rol</option>
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
                        <hr>
                        {{-- <input type="submit"  value="Guardar"> --}}
                        {{-- <a class="btn btn-success" href="{{route('role.edit',$role->id)}}">Edit</a> --}}
                        <a class="btn btn-danger" href="{{route('user.index')}}">Regresar</a>
                    </div>
                    </form>
                    {{-- {!! dd(old()) !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
