@extends('layouts.admin')
@section('contenido')
<div class="container"><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>Mostar Rol</strong></div>
                <div class="card-body">
                    @include('custom.message')
                    <form action="{{route('role.update',$role->id)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="container">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name',$role->name)}}" placeholder="Nombre" readonly>
                        </div>
                        <div class="form-group" style="display: none">
                            <input type="text" class="form-control"  name="slug" id="slug" value="{{old('slug',$role->slug)}}" placeholder="slug" readonly>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description"  id="description" rows="3" placeholder="Descripción" readonly>{{old('description',$role->description)}}</textarea>    
                        </div>
                        <hr>
                        <strong>Acceso completo</strong><br>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="fullaccessyes" name="full-access" class="custom-control-input" disabled value="yes"
                            @if($role['full-access'] == "yes")
                                checked
                            
                            @elseif(old('full-access') == "yes")
                                checked
                            @endif
                            >
                            <label class="custom-control-label" for="fullaccessyes">Yes</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="fullaccessno" name="full-access" class="custom-control-input" disabled value="no"
                             @if($role['full-access'] == "no")
                                checked
                            
                            @elseif(old('full-access') == "no")
                                checked
                            @endif
                           
                            >
                            <label class="custom-control-label" for="fullaccessno">No</label>
                        </div>
                        <br>
                        <hr>
                        <strong>Lista de permisos</strong>
                        @foreach($permissions as $permission)
                            
                      
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" disabled id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permission[]"
                            @if(is_array(old('permission')) && in_array("$permission->id", old('permission')))
                                checked
                            @elseif(is_array($permission_role) && in_array("$permission->id", $permission_role))
                                checked    
                            @endif
                            >

                            <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->id}}-{{$permission->name}}<em> ( {{$permission->description}} ) </em></label>
                        </div>
                        @endforeach
                        <br>
                        {{-- <input type="submit"  value="Guardar"> --}}
                        <a class="btn btn8 mr-3" href="{{route('role.edit',$role->id)}}"><i class="fas fa-edit text-dark mr-2"></i>Editar</a>
                        <a class="btn btn5" href="{{route('role.index')}}"><i class="fas fa-window-close mr-2 "></i>Regresar</a>
                    </div>
                    </form>
                    {{-- {!! dd(old()) !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
