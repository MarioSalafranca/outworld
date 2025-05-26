<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="panel">

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
    <div class="form-actions">
        <a href="{{ route('tienda') }}" class="btn-cancel">Cancelar</a>
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
<script src="{{ asset('js/adminTabs.js') }}"></script>
</body>
</html>
