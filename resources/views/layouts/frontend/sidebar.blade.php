<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('/storage/img/users/user1.png') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ $currentUser->first_name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li>
        <a href="{{ url('/') }}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-pencil"></i>
          <span>Profile</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('/') }}"><i class="fa fa-circle-o"></i> Profile</a></li>
          <li><a href="/edit-profile"><i class="fa fa-circle-o"></i> Edit profile</a></li>
        </ul>
      </li>
      {{--<li><a href="/history"><i class="fa fa-envelope"></i> <span>History</span></a></li>--}}
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
