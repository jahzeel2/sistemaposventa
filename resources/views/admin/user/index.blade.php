@extends('layouts.admin')
@section('contenido')
<div class="container"><br>
    <div class="row justify-content-center">
        <div class="card">
        <div class="card-header">
            <strong>Usuarios</strong>
            {{-- <a href="{{url('admin/user/create')}}" class="btn btn-primary float-right">Crear</a> --}}
            <!-- Button trigger modal -->
            <button type="button" class="btn btn6 float-right" data-toggle="modal" data-target="#ModalUserCreate">
            <i class="fas fa-plus-circle text-success mr-2"></i>
            Crear Nuevo Usuario
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @include('custom.message')
                <table class="table table-bordered  table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Roles(s)</th>
                            <th colspan="4">Acciones</th>
                        </tr>
                    </thead>
                    <body>
                    
                        @foreach($users as $user)
                        <tr>
                            @if ($user->email != 'admin@admin.com')
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                            @isset($user->roles[0]->name)
                                <span class="badge bg-primary">{{$user->roles[0]->name}}</span> 
                            @endisset
                            </td>
                            <td>
                            
                                <a href="{{route('user.show',$user->id)}}" class="btn btn9 btn-sm">Mostrar</a>
                            </td>
                            <td>
                                <a href="{{route('user.edit',$user->id)}}" class="btn btn8 btn-sm">Editar</a>
                            </td>
                            <td>
                                <form action="">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" name="{{$user->id}}" class="btn btn5 btn-sm btnuserdelete" >Eliminar</button>
                                </form>
                            </td>
                            <td>
                                <button type="button" class="btn btn7 btn-sm" onclick="changepassword( '{{$user->id}}','{{$user->email}}' );"> Cambiar password</button>
                            </td>
                            @endif
                        </tr>    
                        @endforeach
                   
                    </body>
                </table>
                {{$users->links()}}
            </div>
        </div>
        </div>
        
    </div>
</div>

<!-- Modal crear nuevo usuario para interactuar con el sistema-->
<div class="modal fade" id="ModalUserCreate" tabindex="-1" role="dialog" aria-labelledby="ModalUserCreateLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header style-modal-form" >
        <h5 class="modal-title" id="exampleModalLabel">Crear nuevo usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body style-modal-form">
        <div class="container">
            <form id="addnewuser" autocomplete="off">
                <div class="input-group mb-3" >
                    <div class="input-group-append" >
                        <div class="input-group-text style-icon-fas">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <input id="name" type="text" class="form-control style-input" name="name" required placeholder="Ingresa el nombre del usuario">
                </div>
                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control style-input" name="email" required placeholder="Ingresa el correo electronico">
                    <div class="input-group-append">
                        <div class="input-group-text style-icon-fas">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text style-icon-fas">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <input id="npassword" type="password" class="form-control style-input" name="npassword" required placeholder="Ingresa el password"> 
                </div>
                <div class="input-group mb-3">
                    <input id="cpassword" type="password" class="form-control style-input" name="cpassword" required placeholder="Confirma el password">
                    <div class="input-group-append">
                        <div class="input-group-text style-icon-fas">
                            <i class="fas fa-key"></i>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text style-icon-fas">
                            <i class="fas fa-user-tag"></i>
                        </div>
                    </div>
                    <select name="rol" id="rol" class="form-select style-input">
                        <option value="">Seleccionar un rol para el acceso al usuario</option>
                        @foreach ($roles as $rol)
                            <option value="{{$rol->id}}">{{$rol->name}}</option>
                        @endforeach
                    </select>
                </div>
            </form>
            <div id="erroruser">

            </div>
        </div>
      </div>
      <div class="modal-footer style-modal-form" >
        <button type="button" class="btn btn5" data-dismiss="modal"><i class="fas fa-window-close mr-2 "></i>Cerrar</button>
        <button type="button" id="adduser" class="btn btn6"><i class="fas fa-check-circle text-success mr-2"></i>Guardar</button>
      </div>
    </div>
  </div>
</div>

<!--Modal para actualizar password-->
<div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header style-modal-form">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar el password</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body style-modal-form">
                <form id="change_password">
                    <div class="form-group">
                        <input type="text" name="id_user_now" id="id_user_now" hidden="true">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <div class="input-group-text style-icon-fas">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                        <input type="text" name="email_user_now" id="email_user_now" class="form-control style-input" disabled>
                    </div>
                    <div class="input-group mb-3">
                       <input type="password" name="password" id="password" class="form-control style-input" placeholder="Ingresa el nuevo password">
                        <div class="input-group-text style-icon-fas">
                            <i class="fas fa-key"></i>
                        </div>
                    </div>
                </form>
                <div id="errorpass"></div>
            </div>
           <div class="modal-footer style-modal-form">
                <button type="button" class="btn btn5" id="closechange" data-bs-dismiss="modal"><i class="fas fa-window-close mr-2 "></i>Cerrar</button>
                <button type="button" class="btn btn6" id="btnchangepassword"><i class="fas fa-check-circle text-success mr-2"></i>Actualizar</button>
            </div>
        </div>
    </div>
</div>

@push('scriptusers')
<script src="{{asset('js/funciones_user/user.js')}}"></script>    
@endpush
@endsection