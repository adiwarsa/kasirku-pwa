<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg" id="sidebarr"><i
                        class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        @if (View::getSection('profile') == 'index-profile')
            <a href="{{ route('logout') }}" class=" has-icon text-danger">
                <i class="fas fa-sign-out-alt" style="font-size: 36px"></i>
            </a>
        @else
            <li class="dropdown"><a href="#" data-toggle="dropdown"
                    class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    @if (auth()->user()->foto == null ||
                            auth()->user()->foto == '' ||
                            file_exists('/image/profile/' . auth()->user()->foto) == 0)
                        <img alt="image" src="{{ asset('../assets/img/avatar/avatar-1.png') }}"
                            class="rounded-circle mr-1">
                    @else
                        <img alt="image" src="{{ asset('/image/profile/' . auth()->user()->foto) }}"
                            class="rounded-circle mr-1">
                    @endif
                    <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('profile.index') }}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </li>
        @endif
    </ul>
</nav>
