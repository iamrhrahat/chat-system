<nav class="sidebar vertical-scroll  ps-container ps-theme-default ps-active-y">
        <div class="logo d-flex justify-content-between">
        <a href="{{ route('dashboard') }}"><img src="{{ asset('asset/dashboard/img/logo.png')}}" alt></a>
        <div class="sidebar_close_icon d-lg-none">
        <i class="ti-close"></i>
        </div>
        </div>
        <ul id="sidebar_menu">

        <li class>
        <a href="{{route('inbox') }}" aria-expanded="false">
        <div class="icon_menu">
        <img src="{{ asset('asset/dashboard/img/menu-icon/5.svg')}}" alt>
        </div>
        <span>Peoples</span>
        </a>
        </li>

        </ul>
    </nav>
