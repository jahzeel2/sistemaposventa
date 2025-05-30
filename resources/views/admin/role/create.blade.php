@extends('layouts.admin')
@section('contenido')
<section class="margin">
    <div class="card">
        <div class="card-header">
            <strong>Crear un Rol</strong> 
        </div>
        <div class="card-body">
            @include('custom.message')
            <form action="{{route('role.store')}}" method="post" autocomplete="off">
            @csrf
            <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="group">
                        <label for="">Nombre del rol</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="Nombre, No debe de existir ningun otro rol con este mismo nombre">
                    </div>
                </div>
                <div class="col-md-3" style="display: none">
                    <div class="group">
                        <label for="">Nombre del slug</label>
                        <input type="text" class="form-control"  name="slug" id="slug" value="{{old('slug')}}" placeholder="slug, No debe de existir ningun otro rol con este mismo slug">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="group">
                        <label for="">Descripcion del rol</label>
                        <textarea class="form-control"  name="description"  id="description" rows="1" placeholder="Realiza una descripción, ejemplo (El usuario encargado de compras,ventas etc ...)">{{old('description')}}</textarea>  
                    </div>
                </div>
            </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h5><strong>Acceso completo</strong></h5>
                    <small class="form-text text-muted">Si usted checked Si no es necesario checked la lista de permisos</small>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="fullaccessyes" name="full-access" class="custom-control-input" onclick="getvalueradio(this.value);" value="yes"
                        @if(old('full-access') == "yes")
                            checked
                        @endif
                        >
                        <label class="custom-control-label" for="fullaccessyes">Si</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="fullaccessno" name="full-access" class="custom-control-input" onclick="getvalueradio(this.value);" value="no"
                        @if(old('full-access') == "no")
                            checked
                        @endif
                        @if(old('full-access') === null)
                            checked
                        @endif
                        >
                        <label class="custom-control-label" for="fullaccessno">No</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="div_roles_permisos">
    <section style="margin-top: -3px;">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menu principal</h5>
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
                </div>
                <div class="card-footer">
                <small class="text-muted">Roles y permisos</small>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menu caja</h5>
                    @foreach($permission_caja as $caja)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="permission_{{$caja->id}}" value="{{$caja->id}}" name="permission[]"
                        @if(is_array(old('permission')) && in_array("$caja->id", old('permission')))
                            checked
                        @endif
                        >
                        <label class="custom-control-label" for="permission_{{$caja->id}}">{{$caja->id}}-{{$caja->name}}<em> ( {{$caja->description}} )</em></label>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                <small class="text-muted">Roles y permisos</small>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menu almacen</h5>
                    @foreach($permission_almacen as $almacen)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="permission_{{$almacen->id}}" value="{{$almacen->id}}" name="permission[]"
                        @if(is_array(old('permission')) && in_array("$almacen->id", old('permission')))
                            checked
                        @endif
                        >
                        <label class="custom-control-label" for="permission_{{$almacen->id}}">{{$almacen->id}}-{{$almacen->name}}<em> ( {{$almacen->description}} )</em></label>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                <small class="text-muted">Roles y permisos</small>
                </div>
            </div>
        </div>
    </section>
    <section class="margin">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menu compras</h5>
                    @foreach($permission_compras as $compras)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="permission_{{$compras->id}}" value="{{$compras->id}}" name="permission[]"
                        @if(is_array(old('permission')) && in_array("$compras->id", old('permission')))
                            checked
                        @endif
                        >
                        <label class="custom-control-label" for="permission_{{$compras->id}}">{{$compras->id}}-{{$compras->name}}<em> ( {{$compras->description}} )</em></label>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                <small class="text-muted">Roles y permisos</small>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menu ventas</h5>
                    @foreach($permission_ventas as $ventas)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="permission_{{$ventas->id}}" value="{{$ventas->id}}" name="permission[]"
                        @if(is_array(old('permission')) && in_array("$ventas->id", old('permission')))
                            checked
                        @endif
                        >
                        <label class="custom-control-label" for="permission_{{$ventas->id}}">{{$ventas->id}}-{{$ventas->name}}<em> ( {{$ventas->description}} )</em></label>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                <small class="text-muted">Roles y permisos</small>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menu devolucion</h5>
                    @foreach($permission_devolucion as $devolucion)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="permission_{{$devolucion->id}}" value="{{$devolucion->id}}" name="permission[]"
                        @if(is_array(old('permission')) && in_array("$devolucion->id", old('permission')))
                            checked
                        @endif
                        >
                        <label class="custom-control-label" for="permission_{{$devolucion->id}}">{{$devolucion->id}}-{{$devolucion->name}}<em> ( {{$devolucion->description}} )</em></label>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                <small class="text-muted">Roles y permisos</small>
                </div>
            </div>
        </div>
    </section>
    <section class="margin">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menu de reportes</h5>
                    @foreach($permission_reports as $reports)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="permission_{{$reports->id}}" value="{{$reports->id}}" name="permission[]"
                        @if(is_array(old('permission')) && in_array("$reports->id", old('permission')))
                            checked
                        @endif
                        >
                        <label class="custom-control-label" for="permission_{{$reports->id}}">{{$reports->id}}-{{$reports->name}}<em> ( {{$reports->description}} )</em></label>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                <small class="text-muted">Roles y permisos</small>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menu de configuracion</h5>
                    @foreach($permission_configuracion as $conf)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="permission_{{$conf->id}}" value="{{$conf->id}}" name="permission[]"
                        @if(is_array(old('permission')) && in_array("$conf->id", old('permission')))
                            checked
                        @endif
                        >
                        <label class="custom-control-label" for="permission_{{$conf->id}}">{{$conf->id}}-{{$conf->name}}<em> ( {{$conf->description}} )</em></label>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                <small class="text-muted">Roles y permisos</small>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menu de cotizaciones</h5>
                    @foreach($permission_cotizaciones as $cot)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="permission_{{$cot->id}}" value="{{$cot->id}}" name="permission[]"
                        @if(is_array(old('permission')) && in_array("$cot->id", old('permission')))
                            checked
                        @endif
                        >
                        <label class="custom-control-label" for="permission_{{$cot->id}}">{{$cot->id}}-{{$cot->name}}<em> ( {{$cot->description}} )</em></label>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                <small class="text-muted">Roles y permisos</small>
                </div>
            </div>
        </div>
    </section>
</div><!--fin de contenido roles y permisos-->
    <section class="margin">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-12">
                        <!--input  class="btn btn6" value="Guardar"-->
                        <button type="submit" class="btn btn6 mr-3"><i class="fas fa-check-circle text-success mr-2"></i>Guardar</button>
                        <a class="btn btn5" href="{{route('role.index')}}"><i class="fas fa-window-close mr-2 "></i>Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>
<style>
.margin{
    margin-top: 5px;
}
</style>
@push('ScriptRoleCreate')
<script src="{{asset('js/funciones_role/role_create.js')}}"></script>
@endpush
@endsection
