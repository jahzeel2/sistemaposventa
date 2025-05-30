@extends('layouts.admin')
@section('contenido')
<div class="container"><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5>Crear Rol</h5></div>

                <div class="card-body">
                    @include('custom.message')
                    <form action="{{route('role.store')}}" method="post">
                    @csrf
                    <div class="container">
                        <h4>Datos requeridos</h4>
                        <div class="form-group">
                            
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            
                            <input type="text" class="form-control"  name="slug" id="slug" value="{{old('slug')}}" placeholder="slug">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description"  id="description" rows="3" placeholder="Descripción">
                            {{old('description')}}
                            </textarea>    
                        </div>
                        <hr>
                        <h4>Full Access</h4>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="fullaccessyes" name="full-access" class="custom-control-input" value="yes"
                            @if(old('full-access') == "yes")
                                checked
                            @endif
                            >
                            <label class="custom-control-label" for="fullaccessyes">Yes</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="fullaccessno" name="full-access" class="custom-control-input" value="no"
                            @if(old('full-access') == "no")
                                checked
                            @endif
                            @if(old('full-access') === null)
                                checked
                            @endif
                            >
                            <label class="custom-control-label" for="fullaccessno">No</label>
                        </div>
                        <hr>
                        <h4>Lista de permisos</h4>
                        @foreach($permissions as $permission)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permission[]"
                            @if(is_array(old('permission')) && in_array("$permission->id", old('permission')))
                                checked
                            @endif
                            >

                            <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->id}}-{{$permission->name}}<em> ( {{$permission->description}} )</em></label>
                        </div>
                        @endforeach
                        <br>
                        <input type="submit" class="btn btn-primary" value="Guardar">
                    </div>
                    </form>
                    {{-- {!! dd(old()) !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
