<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="https://ui-avatars.com/api/?name={{urlencode(Auth::user()->name) }}" class="img-circle elevation-2" alt="User Image" />
        </div>
        <div class="info">
            <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @foreach ($menus as $menu)
            @if(count($menu->childs) > 0)
            <li class="nav-item {{ DB::table('role_has_menus')->where('menu_id', $menu->id)->where('role_id', Auth()->user()->roles[0]->id)->get()->count() > 0 ? '': 'd-none' }} {{ (request()->segment(1) == explode('/', $menu->childs[0]->menu_link)[1]) ? 'menu-open' : '' }}">
                <a href="{{$menu->menu_link}}" class="nav-link {{ (request()->segment(1) == explode('/', $menu->childs[0]->menu_link)[1]) ? 'active' : '' }}">
                    <i class="nav-icon {{$menu->menu_icon}}"></i>
                    <p>
                        {{$menu->menu_name}}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach ($menu->childs as $submenu)
                    <li class="nav-item {{ DB::table('role_has_menus')->where('menu_id', $submenu->id)->where('role_id', Auth()->user()->roles[0]->id)->get()->count() > 0 ? '': 'd-none' }}">
                        <a href="{{$submenu->menu_link}}" class="nav-link {{ (request()->segment(2) == explode('/', $submenu->menu_link)[2]) ? 'active' : '' }}">
                            <i class="nav-icon {{$submenu->menu_icon}}"></i>
                            <p>
                                {{$submenu->menu_name}}
                            </p>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @else
            <li class="nav-item {{ DB::table('role_has_menus')->where('menu_id', $menu->id)->where('role_id', Auth()->user()->roles[0]->id)->get()->count() > 0 ? '': 'd-none' }}">
                <a href="{{$menu->menu_link}}" class="nav-link {{ (request()->segment(1) == 'home') ? 'active' : '' }}">
                    <i class="nav-icon {{$menu->menu_icon}}"></i>
                    <p>
                        {{$menu->menu_name}}
                    </p>
                </a>
            </li>
            @endif
            @endforeach
        </ul>
    </nav>
</div>