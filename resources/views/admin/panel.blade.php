<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Panel de Administración</title>
    <style>
        :root {
            --brand: #0651B4;
            --bg-card: #fff;
            --text-primary: #333;
            --text-secondary: #555;
            --shadow: rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f2f5f8;
            color: var(--text-primary);
        }

        .container {
            width: 90%;
            max-width: 1300px;
            margin: 40px auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: var(--brand);
            margin-bottom: 20px;
            font-size: 32px;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            justify-content: center;
        }

        .tabs button {
            padding: 10px 20px;
            border: none;
            background: var(--bg-card);
            border-bottom: 2px solid transparent;
            font-size: 16px;
            cursor: pointer;
        }

        .tabs button.active {
            border-color: var(--brand);
            font-weight: bold;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .section-title {
            margin: 20px 0 10px;
            font-size: 20px;
            color: var(--brand);
            border-bottom: 2px solid var(--brand);
            display: inline-block;
            padding-bottom: 4px;
        }

        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            background: var(--bg-card);
            flex: 1 1 calc(33% - 20px);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px var(--shadow);
            position: relative;
        }

        .card h2 {
            font-size: 14px;
            text-transform: uppercase;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
        }

        .w-5.h-5 {
            display: none;
        }

        @media (max-width: 700px) {
            .card {
                flex: 1 1 100%;
            }
        }

        /* Tabla de usuarios */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-admin {
            background: var(--brand);
            color: #fff;
        }

        .btn-delete {
            background: #e53e3e;
            color: #fff;
        }

        .btn-create {
            background: var(--brand);
            color: #fff;
        }

        a {
            text-decoration: none;
        }

        .acciones-pag {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            align-content: center;
            flex-direction: column;
        }

        .acciones-pag ul {
            list-style: none;
            display: flex;
            gap: 1rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Panel de Administración</h1>

    <div class="tabs">
        <button id="tab-btn-main" class="active">Inicio</button>
        <button id="tab-btn-users">Usuarios</button>
        <button id="tab-btn-compras">Compras</button>
        <button id="tab-btn-productos">Productos</button>
        <button id="tab-btn-drinks">Drinks</button>
    </div>

    <!-- Sección Principal -->
    <div id="tab-main" class="content-section active">
        <div class="section-title">Totales acumulados</div>
        <div class="grid">
            <div class="card">
                <h2>Usuarios totales</h2>
                <p>{{ number_format($totalUsuarios, 0, ',', '.') }}</p>
            </div>
            <div class="card">
                <h2>Pedidos totales</h2>
                <p>{{ number_format($totalPedidos, 0, ',', '.') }}</p>
            </div>
            <div class="card">
                <h2>Dinero total</h2>
                <p>€{{ number_format($totalIngresos, 2, ',', '.') }}</p>
            </div>
        </div>

        <div class="section-title">Últimas 24 horas</div>
        <div class="grid">
            <div class="card">
                <h2>Usuarios nuevos</h2>
                <p>{{ number_format($usuarios24, 0, ',', '.') }}</p>
            </div>
            <div class="card">
                <h2>Pedidos realizados</h2>
                <p>{{ number_format($pedidos24, 0, ',', '.') }}</p>
            </div>
            <div class="card">
                <h2>Dinero ganado</h2>
                <p>€{{ number_format($ingresos24, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Sección Usuarios -->
    <div id="tab-users" class="content-section">
        <div class="section-title">Listado de Usuarios</div>
        <table>
            <thead>
            <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Ciudad</th>
                <th>CP</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usuariosAll as $u)
                <tr>
                    <td>{{ $u->usuario_user }}</td>
                    <td>{{ $u->nombre }}</td>
                    <td>{{ $u->apellido }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->telefono }}</td>
                    <td>{{ $u->ciudad }}</td>
                    <td>{{ $u->cp }}</td>
                    <td>{{ $u->rol }}</td>
                    <td>
                        @if($u->tipo !== 'admin')
                            <form action="{{ route('panel.makeAdmin', $u->usuario_user) }}" method="POST"
                                  style="display:inline">
                                @csrf
                                <button class="btn btn-admin">Hacer admin</button>
                            </form>
                        @endif
                        <form action="{{ route('panel.deleteUser', $u->usuario_user) }}" method="POST"
                              style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-delete">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="margin-top: 15px;">
            {{ $usuariosAll->links() }}
        </div>
    </div>

    <!-- === COMPRAS === -->
    <div id="tab-compras" class="content-section">
        <div class="section-title">Listado de Compras</div>
        <table>
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Total</th>
                <th>Envío</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($comprasAll as $compra)
                <tr>
                    <td>{{ $compra->created_at->format('d/m/Y H:i') }}</td>
                    <td>€{{ number_format($compra->total,2,',','.') }}</td>
                    <td>€{{ number_format($compra->envio,2,',','.') }}</td>
                    <td>{{ $compra->email }}</td>
                    <td>{{ $compra->telefono }}</td>
                    <td>{{ $compra->usuario_user }}</td>
                    <td>
                        <a href="{{ route('panel.invoice',$compra->id) }}" target="_blank"
                           class="btn btn-admin">Descargar factura</a>
                        <form action="{{ route('panel.deleteCompra',$compra->id) }}"
                              method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-delete">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- paginación -->
        <div class="acciones-pag">
            {!! $comprasAll->links('pagination::simple-bootstrap-4') !!}

            <div>
                <a href="{{ route('panel.createCompra') }}" class="btn btn-create">
                    Crear nueva compra
                </a>
            </div>
        </div>
    </div>

    <!-- === PRODUCTOS === -->
    <div id="tab-productos" class="content-section">
        <div class="section-title">Listado de Productos</div>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($productosAll as $prod)
                    <tr>
                        <td>{{ $prod->id }}</td>
                        <td>{{ $prod->nombre }}</td>
                        <td>€{{ number_format($prod->precio, 2, ',', '.') }}</td>
                        <td>{{ $prod->stock }}</td>
                        <td>
                            <a href="{{ route('panel.editarProducto', $prod->id) }}"
                               class="btn btn-admin">Actualizar</a>
                            <form action="{{ route('panel.deleteProducto', $prod->id) }}"
                                  method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-delete">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Paginación igual que antes -->
            <div class="acciones-pag">
                {!! $productosAll->links('pagination::simple-bootstrap-4') !!}
            </div>

            <!-- Botón crear producto -->
            <a href="{{ route('panel.createProducto') }}"
               class="btn btn-create" style="margin-top:15px; display:inline-block;">
                Crear nuevo producto
            </a>
        </div>

        <div id="tab-drinks" class="content-section">
            <div class="section-title">Listado de Drinks</div>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Base sabor</th>
                    <th>Tiempo</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($drinksAll as $d)
                    <tr>
                        <td>{{ $d->id }}</td>
                        <td>{{ $d->nombre }}</td>
                        <td>{{ $d->tipoCoctel->nombre }}</td>
                        <td>{{ $d->baseSabor->nombre }}</td>
                        <td>{{ $d->tiempoPreparacion->nombre }}</td>
                        <td>
                            <a href="{{ route('panel.editDrink', $d->id) }}"
                               class="btn btn-admin">Actualizar</a>
                            <form action="{{ route('panel.deleteDrink', $d->id) }}"
                                  method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-delete">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="acciones-pag">
                {!! $drinksAll->links('pagination::simple-bootstrap-4') !!}
            </div>
            <a href="{{ route('panel.createDrink') }}"
               class="btn btn-create" style="margin-top:15px;display:inline-block;">
                Crear nuevo Drink
            </a>
        </div>
    </div>


<script>
    const tabBtns = {
        main:      document.getElementById('tab-btn-main'),
        users:     document.getElementById('tab-btn-users'),
        compras:   document.getElementById('tab-btn-compras'),
        productos: document.getElementById('tab-btn-productos'),
        drinks:    document.getElementById('tab-btn-drinks'),
    };
    const tabs = {
        main:      document.getElementById('tab-main'),
        users:     document.getElementById('tab-users'),
        compras:   document.getElementById('tab-compras'),
        productos: document.getElementById('tab-productos'),
        drinks:    document.getElementById('tab-drinks'),
    };

    function activate(name) {
        for (let key in tabBtns) {
            tabBtns[key].classList.toggle('active', key === name);
            tabs[key].classList.toggle('active', key === name);
        }
    }

    tabBtns.main.addEventListener('click',      () => activate('main'));
    tabBtns.users.addEventListener('click',     () => activate('users'));
    tabBtns.compras.addEventListener('click',   () => activate('compras'));
    tabBtns.productos.addEventListener('click', () => activate('productos'));
    tabBtns.drinks.addEventListener('click',    () => activate('drinks'));

    window.addEventListener('DOMContentLoaded', () => {
        const hash = window.location.hash;
        if (hash === '#tab-users') {
            activate('users');
        } else if (hash === '#tab-compras') {
            activate('compras');
        } else if (hash === '#tab-productos') {
            activate('productos');
        } else if (hash === '#tab-drinks') {
            activate('drinks');
        } else {
            activate('main');
        }
    });
</script>


</body>
</html>
