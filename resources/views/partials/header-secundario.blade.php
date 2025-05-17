<header class="headerTienda">
    <div class="general-header">
        <div class="logo-wrapper">
            <a href="{{ route('home') }}"><img src="{{ asset('image/logo/OUTWORLD-WHITE.png') }}" class="logoHeader" alt="Logo OUTWORLD"></a>
        </div>

        <div class="search-bar-inline">
            <div class="search-input">
                <input type="text" placeholder="¿Ya has elegido con cual vas a brindar?" id="productSearch" />
                <button id="searchBtn"><i class="fas fa-search"></i></button>
            </div>
        </div>

        <nav class="nav">
            <ul class="nav-links">
                <li class="account-menu">
                    @if(session()->has('admin'))
                    <a href="{{ route('panel') }}" class="account-trigger"><span>Administracion</span></a>
                    @endif
                </li>
                <li class="account-menu">
                    <a href="{{ route('miCuenta') }}" class="account-trigger">
                            <span>@if(session()->has('usuario')){{ session('usuario') }}@else Mi cuenta @endif</span>
                        <img src="{{ asset('image/iconos/cuenta.png') }}"></a>
                </li>
                <li class="cart-link" id="cartButton">
                    <a href="{{ route('carrito') }}"><img src= "{{ asset('image/iconos/carrito.png') }}" alt="Carrito"><span class="cart-count">0</span></a>
                </li>
            </ul>
        </nav>
    </div>
</header>
