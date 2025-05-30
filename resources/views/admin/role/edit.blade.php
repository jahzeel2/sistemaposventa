@extends('layouts.admin')
@section('contenido')

<form action="{{route('role.update',$role->id)}}" method="post" autocomplete="off">
@csrf
@method('put')
<section class="margin">
    <div class="card">
        <div class="card-header">
            <strong>Editar el rol</strong> 
        </div>
        <div class="card-body">
            @include('custom.message')
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Nombre del rol</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name',$role->name)}}" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="col-md-3" style="display: none">
                        <div class="form-group">
                            <label for="">Nombre del slug</label>
                            <input type="text" class="form-control"  name="slug" id="slug" value="{{old('slug',$role->slug)}}" placeholder="slug">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Descripcion del rol</label>
                            <textarea class="form-control" name="description"  id="description" rows="1" placeholder="Descripción">{{old('description',$role->description)}}</textarea>    
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4>Acceso completo</h4>
                    <small class="form-text text-muted">
                    Si usted checked Yes no es necesario checked la lista de permisos
                    </small>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="fullaccessyes" name="full-access" class="custom-control-input" value="yes"
                        @if($role['full-access'] == "yes")
                            checked
                        
                        @elseif(old('full-access') == "yes")
                            checked
                        @endif
                        >
                        <label class="custom-control-label" for="fullaccessyes">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="fullaccessno" name="full-access" class="custom-control-input" value="no"
                            @if($role['full-access'] == "no")
                            checked
                        
                        @elseif(old('full-access') == "no")
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
<section style="margin-top:-1%;">
    <div class="card-group">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Menu principal</h5>
                @foreach($permissions as $permission)
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permission[]"
                    @if(is_array(old('permission')) && in_array("$permission->id", old('permission')))
                        checked
                    @elseif(is_array($permission_role) && in_array("$permission->id", $permission_role))
                        checked    
                    @endif
                    >
                    <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->id}}-{{$permission->name}} <em> ( {{$permission->description}} )</em></label>
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
                    @elseif(is_array($permission_role) && in_array("$caja->id", $permission_role))
                        checked    
                    @endif
                    >
                    <label class="custom-control-label" for="permission_{{$caja->id}}">{{$caja->id}}-{{$caja->name}} <em> ( {{$caja->description}} )</em></label>
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
                    @elseif(is_array($permission_role) && in_array("$almacen->id", $permission_role))
                        checked    
                    @endif
                    >
                    <label class="custom-control-label" for="permission_{{$almacen->id}}">{{$almacen->id}}-{{$almacen->name}} <em> ( {{$almacen->description}} )</em></label>
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
                    @elseif(is_array($permission_role) && in_array("$compras->id", $permission_role))
                        checked    
                    @endif
                    >
                    <label class="custom-control-label" for="permission_{{$compras->id}}">{{$compras->id}}-{{$compras->name}} <em> ( {{$compras->description}} )</em></label>
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
                @foreach($permission_ventas as $venta)
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="permission_{{$venta->id}}" value="{{$venta->id}}" name="permission[]"
                    @if(is_array(old('permission')) && in_array("$venta->id", old('permission')))
                        checked
                    @elseif(is_array($permission_role) && in_array("$venta->id", $permission_role))
                        checked    
                    @endif
                    >
                    <label class="custom-control-label" for="permission_{{$venta->id}}">{{$venta->id}}-{{$venta->name}} <em> ( {{$venta->description}} )</em></label>
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
                    @elseif(is_array($permission_role) && in_array("$devolucion->id", $permission_role))
                        checked    
                    @endif
                    >
                    <label class="custom-control-label" for="permission_{{$devolucion->id}}">{{$devolucion->id}}-{{$devolucion->name}} <em> ( {{$devolucion->description}} )</em></label>
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
                <h5 class="card-title">Menu de reportes</h5><br>
                @foreach($permission_reports as $reports)
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="permission_{{$reports->id}}" value="{{$reports->id}}" name="permission[]"
                    @if(is_array(old('permission')) && in_array("$reports->id", old('permission')))
                        checked
                    @elseif(is_array($permission_role) && in_array("$reports->id", $permission_role))
                        checked    
                    @endif
                    >
                    <label class="custom-control-label" for="permission_{{$reports->id}}">{{$reports->id}}-{{$reports->name}} <em> ( {{$reports->description}} )</em></label>
                </div>
                @endforeach
            </div>
            <div class="card-footer">
            <small class="text-muted">Roles y permisos</small>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Menu de configuracion</h5><br>
                @foreach($permission_configuracion as $conf)
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="permission_{{$conf->id}}" value="{{$conf->id}}" name="permission[]"
                    @if(is_array(old('permission')) && in_array("$conf->id", old('permission')))
                        checked
                    @elseif(is_array($permission_role) && in_array("$conf->id", $permission_role))
                        checked    
                    @endif
                    >
                    <label class="custom-control-label" for="permission_{{$conf->id}}">{{$conf->id}}-{{$conf->name}} <em> ( {{$conf->description}} )</em></label>
                </div>
                @endforeach
            </div>
            <div class="card-footer">
            <small class="text-muted">Roles y permisos</small>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Menu de configuracion</h5><br>
                @foreach($permission_cotizaciones as $cot)
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="permission_{{$cot->id}}" value="{{$cot->id}}" name="permission[]"
                    @if(is_array(old('permission')) && in_array("$cot->id", old('permission')))
                        checked
                    @elseif(is_array($permission_role) && in_array("$cot->id", $permission_role))
                        checked    
                    @endif
                    >
                    <label class="custom-control-label" for="permission_{{$cot->id}}">{{$cot->id}}-{{$cot->name}} <em> ( {{$cot->description}} )</em></label>
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
    <div class="container margin">
        <div class="card">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-12">
                        <!--input type="submit" class="btn btn-primary" value="Guardar"-->
                        <button type="submit" class="btn btn6 mr-3"><i class="fas fa-check-circle text-success mr-2"></i>Guardar</button>
                        <a class="btn btn5" href="{{route('role.index')}}"><i class="fas fa-window-close mr-2 "></i>Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</form>


<style>
.margin{
    margin-top: 5px;
}
</style>
<script>
    const slug = document.querySelector("#slug");
    const nameRol = document.querySelector("#name");
    nameRol.addEventListener("keyup", (event) => {
        //e.preventDefault;
        //console.log(event.target.value)
        slug.value = event.target.value;
    });
</script>
@endsection
