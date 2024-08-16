<?php
    $menus = getMenu(Auth::user()->role_id);
?>
<div class="horizontal-menu">
    <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid">
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
            <ul class="navbar-nav navbar-nav-left">
            </ul>
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center flex-grow-1">
                    <h5 class="text-white bg-primary py-3 px-4 rounded-lg text-center font-weight-bold mb-0">
                        SISHOT SMP NEGERI 6 MOJOKERTO
                    </h5>
                </div>
            </div>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                    <span class="nav-profile-name">{{ auth()->user()->username }}</span>
                    <span class="online-status"></span>
                    <img src="images/faces/face28.png" alt="profile"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item">
                        <i class="mdi mdi-settings text-primary"></i>
                        Settings
                    </a>
                    <a href="{{ route('logout') }}" class="dropdown-item">
                        <i class="mdi mdi-logout text-primary"></i>
                        Logout
                    </a>
                </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
            <span class="mdi mdi-menu"></span>
            </button>
        </div>
        </div>
    </nav>
    <nav class="bottom-navbar">
        <div class="container">
            <ul class="nav page-navigation">
            @foreach($menus as $menu)
                <?php
                    $submenus = getSubMenu($menu->module_id, Auth::user()->role_id);
                ?>
                <li class="nav-item">
                    <a class="nav-link" >
                    <i class="{{ $menu->icon }} menu-icon"></i>
                    <span class="menu-title">{{ $menu->nama_module }}</span>
                    </a>
                    @if($submenus->isNotEmpty())
                        <div class="submenu">
                            <ul>
                                @foreach($submenus as $submenu)
                                    <li class="nav-item">
                                        @if(str_starts_with($submenu->routes, 'http://') || str_starts_with($submenu->routes, 'https://'))
                                            <a class="nav-link" href="{{ $submenu->routes }}" target="blank">{{ $submenu->nama_menu }}</a>
                                        @else
                                            <a class="nav-link" href="{{ route($submenu->routes) }}">{{ $submenu->nama_menu }}</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </li>
            @endforeach
            </ul>
        </div>
    </nav>
</div>
