<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('season') }}'><i class='nav-icon la la-question'></i> Seasons</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('university') }}'><i class='nav-icon la la-question'></i> Universities</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('league-competition') }}'><i class='nav-icon la la-question'></i> League competitions</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('season-uni') }}'><i class='nav-icon la la-question'></i> Season unis</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('competition-uni-place') }}'><i class='nav-icon la la-question'></i> Competition uni places</a></li>
<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>