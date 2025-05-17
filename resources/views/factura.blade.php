<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ public_path('css/styles.css') }}">
</head>
<body class="tienda">
<div class="invoice-wrapper">
    <div class="invoice-header">
        <img src="{{ public_path('storage/image/logo/OUTWORLD-BLACK.png') }}" alt="Outworld Logo" class="invoice-logo">
        <div class="invoice-title">Factura de Compra #{{ $compra->id }}</div>
        <div class="invoice-meta">Fecha: {{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</div>
    </div>

    <div class="invoice-client">
        <h2>Datos del Cliente</h2>
        @if($usuario->deleted_at)
            <span style="color: #e53e3e; font-style: italic;">Usuario Eliminado</span>
        @endif
        <p><strong>Usuario:</strong> {{ $usuario->usuario_user }}</p>
        <p><strong>Email:</strong> {{ $usuario->email }}</p>
        <p><strong>Dirección:</strong> {{ $usuario->calle }}, {{ $usuario->numero }}, {{ $usuario->ciudad }}, {{ $usuario->cp }}, {{ $usuario->pais }}</p>
        <p><strong>Teléfono:</strong> {{ $usuario->telefono }}</p>
    </div>

    <table class="invoice-table">
        <thead>
        <tr>
            <th>Producto</th>
            <th style="width:10%;">Cant.</th>
            <th style="width:20%;">Precio unitario</th>
            <th style="width:20%;">Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item['nombre'] }}</td>
                <td>{{ $item['cantidad'] }}</td>
                <td>{{ number_format($item['precio'], 2, ',', '.') }} €</td>
                <td>{{ number_format($item['precio'] * $item['cantidad'], 2, ',', '.') }} €</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="invoice-totals">
        <div class="invoice-row">
            <span>Subtotal:</span>
            <span>{{ number_format($compra->total - $compra->envio, 2, ',', '.') }} €</span>
        </div>
        <div class="invoice-row">
            <span>Gastos de envío:</span>
            <span>{{ number_format($compra->envio, 2, ',', '.') }} €</span>
        </div>
        <div class="invoice-row total">
            <span>Total:</span>
            <span>{{ number_format($compra->total, 2, ',', '.') }} €</span>
        </div>
    </div>

    <div class="invoice-footer">
        OUTWORLD. LEADING THE EDGE.
    </div>
</div>
</body>
</html>
