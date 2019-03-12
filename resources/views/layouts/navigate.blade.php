{{-- <div class="mobule-menu__wr d-block d-md-none">
    burger
    <button></button>
</div>


<div class="custom-menu col-2 px-1 py-4 d-none d-md-block">
    <div class="avatar__wr col-12">
        <img src="https://picsum.photos/100/100?random" alt="">
    </div>


        <ul class="navbar-nav menu-items pt-2 mb-3">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav menu-items">
            {{--  --}}
        {{-- </ul>
</div>
 --}}

    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        Вийти
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

 <custom-menu
 :username   = "{{ json_encode($username) }}"
 :menu       = "{{ json_encode($menu) }}"
 ></custom-menu>
