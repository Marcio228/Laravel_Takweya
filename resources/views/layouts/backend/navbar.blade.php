<header class="main-header">
  <!-- Logo -->
  <a href="/admin" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>TB</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">Admin panel</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
     <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <?php $currentUser = \App\User::where('id', Sentinel::getUser()->id)->firstOrFail() ?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('/storage/img/users/user1.png') }}" class="user-image" alt="Admin">
            <span class="hidden-xs">Admin</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="{{ asset('/storage/img/users/user1.png') }}" class="img-circle" alt="User Image">

              <p>
                Admin - Owner
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{ url('/') }}" class="btn btn-default btn-flat">Site</a>
              </div>
              <div class="pull-right">
                <a href="{{ route('logout') }}"
                   class="btn btn-default btn-flat"
                   onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>

              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
