<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Crear Nueva Compra</title>
    <style>
        :root {
            --brand: #0651B4;
            --bg-card: #fff;
            --text: #333;
            --shadow: rgba(0,0,0,0.1);
        }
        * { box-sizing: border-box; margin:0; padding:0; }
        body {
            font-family: Arial, sans-serif;
            background: #f2f5f8;
            color: var(--text);
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: var(--bg-card);
            border-radius: 6px;
            box-shadow: 0 2px 8px var(--shadow);
        }
        h1 { text-align: center; color: var(--brand); margin-bottom: 20px; }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }
        .form-control, select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-section {
            margin-bottom: 30px;
        }
        .form-section h2 {
            margin-bottom: 15px;
            color: var(--brand);
            border-bottom: 2px solid var(--brand);
            display: inline-block;
            padding-bottom: 4px;
        }
        .productos-list .producto-entry {
            display: flex;
            gap: 10px;
            align-items: flex-end;
            margin-bottom: 10px;
        }
        .productos-list .producto-entry > * {
            flex: 1;
        }
        .productos-list .producto-entry .btn-remove {
            flex: 0 0 auto;
            background: #e53e3e;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        #add-product {
            background: var(--brand);
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .total-group {
            text-align: right;
            margin-top: 20px;
        }
        .total-group label {
            font-weight: bold;
        }
        .total-group input {
            width: 150px;
            display: inline-block;
            text-align: right;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background: #f5f5f5;
        }
        .form-actions {
            text-align: right;
            margin-top: 30px;
        }
        .btn-submit {
            background: var(--brand);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-cancel {
            margin-right: 10px;
            text-decoration: none;
            color: var(--brand);
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Crear Nueva Compra</h1>
    <form method="POST" action="{{ route('panel.registrarCompraAdmin') }}">
        @csrf
        <div class="form-section">

            <div class="form-group">
                <label for="usuario_user">Usuario</label>
                <select id="usuario_user" name="usuario_user" class="form-control" required>
                    <option value="">-- Selecciona usuario --</option>
                    @foreach($usuarios as $u)
                        <option value="{{ $u->usuario_user }}">
                            {{ $u->nombre }} ({{ $u->usuario_user }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="envio">Gastos de envío (€)</label>
                <input type="number" id="envio" name="envio" class="form-control" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="email">Email de envío</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="calle">Calle</label>
                <input type="text" id="calle" name="calle" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="numero">Número</label>
                <input type="text" id="numero" name="numero" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <input type="text" id="ciudad" name="ciudad" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="cp">Código Postal</label>
                <input type="text" id="cp" name="cp" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="pais">País</label>
                <input type="text" id="pais" name="pais" class="form-control" required>
            </div>
        </div>

        <div class="form-section">
            <h2>Productos</h2>
            <div id="productos-list" class="productos-list">
                <div class="producto-entry">
                    <select name="productos[0][producto_id]" class="form-control producto-select" required>
                        <option value="">-- Selecciona producto --</option>
                        @foreach($productos as $p)
                            <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                        @endforeach
                    </select>
                    <input type="number"
                           name="productos[0][cantidad]"
                           class="form-control cantidad-input"
                           min="1"
                           placeholder="Cantidad"
                           required>
                    <div class="form-control precio-display">0,00 €</div>
                    <input type="hidden"
                           name="productos[0][precio_unitario]"
                           class="precio-hidden"
                           value="0">
                    <button type="button" class="btn-remove">✕</button>
                </div>
            </div>
            <button type="button" id="add-product">+ Añadir producto</button>
        </div>

        {{-- Total calculado --}}
        <div class="total-group">
            <label>Total de la compra (€):</label>
            <input type="text" id="total-display" readonly value="0,00 €">
            <input type="hidden" name="total" id="total-hidden" value="0">
        </div>

        {{-- Botones --}}
        <div class="form-actions">
            <a href="{{ route('panel') }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-submit">Crear Compra</button>
        </div>
    </form>
</div>

<script>
    // Preparamos un map de precios
    const productPrices = {
        @foreach($productos as $p)
            {{ $p->id }}: {{ $p->precio }},
        @endforeach
    };

    let index = 1;
    const productosList = document.getElementById('productos-list');
    const addBtn = document.getElementById('add-product');
    const totalDisplay = document.getElementById('total-display');
    const totalHidden = document.getElementById('total-hidden');

    // Función para recalcular total
    function recalcTotal() {
        let total = 0;
        document.querySelectorAll('.producto-entry').forEach(entry => {
            const id = entry.querySelector('.producto-select').value;
            const qty = parseInt(entry.querySelector('.cantidad-input').value) || 0;
            const price = productPrices[id] || 0;
            total += price * qty;
        });
        totalHidden.value = total.toFixed(2);
        totalDisplay.value = total.toLocaleString('es-ES',{minimumFractionDigits:2}) + ' €';
    }

    // Función para actualizar el precio de una línea
    function updateLine(entry) {
        const select = entry.querySelector('.producto-select');
        const qtyInput = entry.querySelector('.cantidad-input');
        const precioDisplay = entry.querySelector('.precio-display');
        const precioHidden = entry.querySelector('.precio-hidden');
        const price = productPrices[select.value] || 0;
        precioDisplay.textContent = price.toLocaleString('es-ES',{minimumFractionDigits:2}) + ' €';
        precioHidden.value = price.toFixed(2);
        recalcTotal();
    }

    // Delegación de eventos en lista
    productosList.addEventListener('change', e => {
        const entry = e.target.closest('.producto-entry');
        if (e.target.matches('.producto-select') || e.target.matches('.cantidad-input')) {
            updateLine(entry);
        }
    });

    // Añadir producto
    addBtn.addEventListener('click', () => {
        const template = document.querySelector('.producto-entry');
        const clone = template.cloneNode(true);
        clone.querySelectorAll('select, input, .precio-display').forEach(el => {
            if (el.tagName==='SELECT') el.value = '';
            else if (el.tagName==='INPUT') el.value = '';
            else el.textContent = '0,00 €';
        });
        // Actualiza names
        clone.querySelector('.producto-select').name = `productos[${index}][producto_id]`;
        clone.querySelector('.cantidad-input').name = `productos[${index}][cantidad]`;
        clone.querySelector('.precio-hidden').name = `productos[${index}][precio_unitario]`;
        productosList.appendChild(clone);
        index++;
    });

    // Quitar línea
    productosList.addEventListener('click', e => {
        if (e.target.classList.contains('btn-remove')) {
            const all = productosList.querySelectorAll('.producto-entry');
            if (all.length > 1) {
                e.target.closest('.producto-entry').remove();
                recalcTotal();
            }
        }
    });
</script>
</body>
</html>
