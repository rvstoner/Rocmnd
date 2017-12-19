<div class="side-menu" id="admin-side-menu">
  <aside class="menu m-t-30 m-l-10">
    <p class="menu-label">
      General
    </p>
    <ul class="menu-list">
      <li><a href="{{route('manage.dashboard')}}" class="{{Nav::isRoute('manage.dashboard')}}">Dashboard</a></li>
    </ul>

    <p class="menu-label">
      Content
    </p>
    <ul class="menu-list">
      {{-- <li><a href="{{route('policies.index')}}" class="{{Nav::isResource('policies', 2)}}">Policies</a></li> --}}
      <li><a href="#">Policies</a></li>
      <li><a href="#">Memos</a></li>
    </ul>

    <p class="menu-label">
      Administration
    </p>
    <ul class="menu-list">
      <li>
        <a class="has-submenu {{Nav::hasSegment(['users','onshift'], 2)}}">Manage Users</a>
        <ul class="submenu">
          <li><a href="{{route('users.index')}}" class="{{Nav::isResource('users')}}">Manage Users</a></li>
          <li><a href="{{route('users.onshift')}}" class="{{Nav::isResource('onshift')}}">Clocked In</a></li>
        </ul>
      </li>
      <li>
        <a class="has-submenu {{Nav::hasSegment(['roles', 'permissions'], 2)}}">Roles &amp; Permissions</a>
        <ul class="submenu">
          <li><a href="{{route('roles.index')}}" class="{{Nav::isResource('roles')}}">Roles</a></li>
          @role('serveradministrator')
            <li><a href="{{route('permissions.index')}}" class="{{Nav::isResource('permissions')}}">Permissions</a></li>
          @endrole
        </ul>
      </li>
      <li>
        <a class="has-submenu">Payroll</a>
        <ul class="submenu">
          <li><a href="{{route('timesheets.index')}} {{Nav::hasSegment('timesheets', 2)}}">Timesheet</a></li>
        </ul>
      </li>
      <li>
        <a class="has-submenu">Inventory</a>
        <ul class="submenu">
          <li><a href="#">New inventory item</a></li>
          <li><a href="#">Update inventory </a></li>
        </ul>
      </li>
    </ul>
  </aside>
</div>