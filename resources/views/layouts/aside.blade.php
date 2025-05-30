@php
  $prefix = Request::route()->getPrefix();
  $route = Route::current()->getName();
  $resp = request()->path();
  $exp = explode("/", $resp); 
@endphp
<aside class="main-sidebar style-modal-form elevation-2" >
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="color: #8d8989;">
      <img src="{{asset($logo)}}" class="brand-image img-circle">
      <span class=""><strong>{{strtoupper(substr($name,0,16))}}</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!--<div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/avatar04.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block" style="color: #8d8989;">{{ Auth::user()->name }}</a>
        </div>
      </div>-->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @can('haveaccess', 'admin.index')  
          <li class="nav-item has-treeview {{($prefix == '/admin')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Panel de control
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            @can('haveaccess', 'admin_user.index')
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a  href="{{url('admin/user')}}" class="nav-link {{'admin/user' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Usuarios</p> 
                </a> 
              </li>
            </ul>
            @endcan
            @can('haveaccess', 'admin_role.index')
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('admin/role')}}" class="nav-link {{'admin/role' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles</p>
                </a>
              </li>
            </ul>
            @endcan
          </li>
          @endcan
          @can('haveaccess', 'caja.index')
          <li class="nav-item has-treeview {{($exp[0] == 'caja')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>
                Caja
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('haveaccess', 'caja_apertura.index')
              <li class="nav-item">
                <a href="{{url('caja/cajainicio')}}" class="nav-link {{'caja/cajainicio' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Apertura de  caja</p>
                </a>
              </li>
              @endcan
              @can('haveaccess', 'caja_corte.index')
              <li class="nav-item">
                <a href="{{url('caja/corte')}}" class="nav-link {{'caja/corte' == request()->path() ?'active':''}}"">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Corte de caja</p>
                </a>
              </li>
              @endcan
              @can('haveaccess', 'caja_parcial.index')
              <li class="nav-item">
                <a href="{{url('caja/corteparcial')}}" class="nav-link {{'caja/corteparcial' == request()->path() ?'active':''}}"">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Corte parcial al cajero</p>
                </a>
              </li>
              @endcan
              @can('haveaccess', 'caja_historicolist.index')
              <li class="nav-item">
                <a href="{{url('caja/historial')}}" class="nav-link {{'caja/historial' == request()->path() ?'active':''}}"">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Historico de caja</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan
          @can('haveaccess', 'almacen.index')
          <li class="nav-item has-treeview {{($exp[0] == 'almacen')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Almacén
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('haveaccess', 'almacen_articulo.index')
              <li class="nav-item">
                <a href="{{url('almacen/articulo')}}" class="nav-link {{'almacen/articulo' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Articulos</p>
                </a>
              </li>
              @endcan
              @can('haveaccess', 'almacen_categoria.index')
              <li class="nav-item">
                <a href="{{url('almacen/categoria')}}" class="nav-link {{'almacen/categoria' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categorías</p>
                </a>
              </li>
              @endcan
              @can('haveaccess', 'almacen_inventario.index')
              <li class="nav-item">
                <a href="{{url('/inventory')}}" class="nav-link {{'/inventory' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inventario</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan
          @can('haveaccess', 'compras.index')
          <li class="nav-item has-treeview {{($exp[0] == 'compras')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Compras
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('haveaccess', 'compras_entrada.index')
              <li class="nav-item">
                <a href="{{route('entradas.create')}}" class="nav-link {{'compras/entradas/create' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Entradas de productos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('compras/entradas')}}" class="nav-link {{'compras/entradas' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Detalle entradas</p>
                </a>
              </li>
              @endcan
              @can('haveaccess', 'compras_proveedor.index')
              <li class="nav-item">
                <a href="{{url('compras/proveedor')}}" class="nav-link {{'compras/proveedor' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Proveedores</p>
                </a>
              </li>
              @endcan
              <!--<li class="nav-item">
                <a href="pages/forms/editors.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Editors</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/forms/validation.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Validation</p>
                </a>
              </li>-->
            </ul>
          </li>
          @endcan
          @can('haveaccess', 'ventas.index')
          <li class="nav-item has-treeview {{($exp[0] == 'ventas')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-bill-alt"></i>
              <p>
                Ventas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('haveaccess', 'ventas_venta.index')
              <li class="nav-item">
                <a href="{{route('venta.create')}}" class="nav-link {{'ventas/venta/create' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Posventa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('ventas/venta')}}" class="nav-link {{'ventas/venta' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Detalle Ventas</p>
                </a>
              </li>
              @endcan
              @can('haveaccess', 'ventas_cliente.index')
              <li class="nav-item">
                <a href="{{url('ventas/cliente')}}" class="nav-link {{'ventas/cliente' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Clientes</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan
          @can('haveaccess', 'cotizaciones.index')
           <li class="nav-item has-treeview {{($exp[0] == 'cotizaciones')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Cotizaciones
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('haveaccess', 'cotizaciones_cliente.index')
              <li class="nav-item">
                <a href="{{url('quote/create')}}" class="nav-link {{'quote/create' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Generar cotizacion</p>
                </a>
              </li>
              @endcan
              @can('haveaccess', 'cotizaciones_cotizacion.index')
              <li class="nav-item">
                <a href="{{url('quote')}}" class="nav-link {{'quote' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado cotizacion</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan
          @can('haveaccess', 'devolucion.index')
          <li class="nav-item has-treeview {{($exp[0] == 'devoluciones')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-reply-all"></i>
              <p>
                Devoluciones
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('haveaccess', 'devolucion_producto.index')
              <li class="nav-item">
                <a href="{{url('devoluciones/venta')}}" class="nav-link {{'devoluciones/venta' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Devolucion venta</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan
          @can('haveaccess', 'reporte.index')
          <li class="nav-item has-treeview {{($exp[0] == 'graph')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                Reportes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('graph')}}" class="nav-link {{'graph' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reportes graficos</p>
                </a>
              </li>
            </ul>
          </li>
          @endcan
          @can('haveaccess', 'configuracion.index')
          <li class="nav-item has-treeview {{($exp[0] == 'config')?'menu-open':''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Configuracion
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('config')}}" class="nav-link {{'config' == request()->path() ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Datos de la empresa</p>
                </a>
              </li>
            </ul>
          </li>
          @endcan

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>