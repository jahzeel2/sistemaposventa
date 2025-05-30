<!-- Navbar -->
<nav class="main-header navbar py-1 navbar-expand navbar-white navbar-light shadow-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url($link)}}" class="nav-link"><strong>Dashboard</strong></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
        <li class="dropdown notification-list">
          <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
              aria-expanded="false">
              <span class=""> 
                  <img src="{{asset('dist/img/avatar04.png')}}" alt="User Image" width="28" height="28" class=" brand-image img-circle">
              </span>
              <span>
                  <span class="account-user-name">{{substr(Auth::user()->name,0,10)}}</span>
              </span>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
              <!-- item-->
              <div class=" dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Bienvenido</h6>
              </div>

              <!-- item-->
              <!--<a href="javascript:void(0);" class="dropdown-item notify-item">
                  <i class="mdi mdi-account-circle me-1"></i>
                  <span>My Account</span>
              </a>-->

              <!-- item-->
              <!--<a href="javascript:void(0);" class="dropdown-item notify-item">
                  <i class="mdi mdi-account-edit me-1"></i>
                  <span>Settings</span>
              </a>-->

              <!-- item-->
              <!--<a href="javascript:void(0);" class="dropdown-item notify-item">
                  <i class="mdi mdi-lifebuoy me-1"></i>
                  <span>Support</span>
              </a>-->

              <!-- item-->
              <!--<a href="javascript:void(0);" class="dropdown-item notify-item">
                  <i class="mdi mdi-lock-outline me-1"></i>
                  <span>Lock Screen</span>
              </a>-->

              <!-- item-->
              <a href="{{ url('/logout') }}" class="dropdown-item notify-item">
                  <i class="mdi mdi-logout me-1"></i>
                  <span>Cerrar cesion</span>
              </a>
          </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->