<header class="headerTienda">
    <div class="general-header">
        <div class="logo-wrapper">
            <a href="{{ route('home') }}"><img src="{{ asset('image/logo/OUTWORLD-WHITE.png') }}" class="logoHeader" alt="Logo OUTWORLD"></a>
        </div>

        <div class="search-bar-inline">
            <form action="{{ route('buscadorTienda') }}" method="GET" class="search-bar-inline">
                <div class="search-input">
                    <input
                        type="text"
                        name="q"
                        id="productSearch"
                        placeholder="¿Ya has elegido con cuál vas a brindar?"
                        value="{{ request('q') }}"
                    />
                    <button type="submit" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <nav class="nav">
            <ul class="nav-links">
                @if(session()->has('admin'))
                    <li class="account-menu">
                        <a href="{{ route('panel') }}" class="account-trigger">
                            <span>Administración</span>
                        </a>
                    </li>
                @endif

                <li class="account-menu">
                    @if(session()->has('usuario'))
                        <a href="{{ route('miCuenta') }}" class="account-trigger">
                            <span>{{ session('usuario') }}</span>
                            <img src="{{ asset('image/iconos/cuenta.png') }}">
                        </a>
                    @else
                        <a href="{{ route('cuenta', ['redirect' => route('tienda')]) }}" class="account-trigger">
                            <span>Mi cuenta</span>
                            <img src="{{ asset('image/iconos/cuenta.png') }}">
                        </a>
                    @endif
                </li>

                <li class="cart-link" id="cartButton">
                    <a href="{{ route('carrito') }}">
                        <img src="{{ asset('image/iconos/carrito.png') }}" alt="Carrito">
                        <span class="cart-count">0</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
