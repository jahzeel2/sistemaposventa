@extends('layouts.admin')
@section('contenido')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container"><br>
    <div class="row justify-content-center">
        <div class="card">
        <div class="card-header">
            <strong>Roles</strong>
            <a href="{{url('admin/role/create')}}" class="btn btn6 float-right">
            <i class="fas fa-plus-circle text-success mr-2"></i>
                Crear un nuevo Rol
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @include('custom.message')
                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Slug</th>
                            <th>Descripción</th>
                            <th>Acceso completo</th>
                            <th colspan="3">Acciones</th>
                        </tr>
                    </thead>
                    <body>
                        @foreach($roles as $role)
                        <tr>
                            @if ($role->name != 'Admin')
                            <td>{{$role->id}}</td>
                            <td><span class="badge bg-secondary">{{$role->name}}</span></td>
                            <td>{{$role->slug}}</td>
                            <td>{{$role->description}}</td>
                            <td class="text-center"><span class="badge bg-primary">{{$role['full-access']}}</span></td>
                            <td>
                                <a href="{{route('role.show',$role->id)}}" class="btn btn9 btn-sm">Mostrar</a>
                            </td>
                            <td>
                                <a href="{{route('role.edit',$role->id)}}" class="btn btn8 btn-sm">Editar</a>
                            </td>
                            <td>
                                <!--<form action="{{route('role.destroy',$role->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn5 btn-sm">Eliminar</button>
                                </form>-->
                                <button class="btn btn5 btn-sm" onclick="deleteRol('{{$role->id}}');">Eliminar</button>
                            </td>
                            @endif
                        </tr>    
                        @endforeach
                   
                    </body>
                </table>
                {{$roles->links()}}
            </div>
        </div>
        </div>
        
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{asset('js/funciones_role/role.js')}}"></script>
@endsection