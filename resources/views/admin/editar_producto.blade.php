<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Editar Producto</title>
    <style>
        :root {
            --brand: #0651B4;
            --bg-card: #fff;
            --text: #333;
            --shadow: rgba(0,0,0,0.1);
        }
        * { box‐sizing: border-box; margin:0; padding:0; }
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
        .form-group { margin-bottom: 15px; }
        .form-group label {
            display:block; margin-bottom:6px; font-weight:bold;
        }
        .form-control, select, textarea {
            width:100%; padding:8px 10px;
            border:1px solid #ccc; border-radius:4px;
            font-size:14px; background:#fff;
        }
        .form-section { margin-bottom:30px; }
        .form-section h2 {
            margin-bottom:15px;
            color:var(--brand);
            border-bottom:2px solid var(--brand);
            display:inline-block; padding-bottom:4px;
        }
        .categorias-checkboxes label {
            display:block; margin-bottom:6px; cursor:pointer;
        }
        .categorias-checkboxes input { margin-right:8px; }
        .form-actions {
            text-align:right; margin-top:30px;
        }
        .btn-submit {
            background:var(--brand); color:#fff; border:none;
            padding:10px 20px; border-radius:4px; cursor:pointer;
            font-size:16px;
        }
        .btn-cancel {
            margin-right:10px; text-decoration:none;
            color:var(--brand); font-size:16px;
        }
        .note {
            font-size:13px; color:#555; margin-top:-10px; margin-bottom:15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Editar Producto</h1>
    <form method="POST"
          action="{{ route('panel.updateProducto', $producto->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Datos Básicos --}}
        <div class="form-section">
            <h2>Datos Básicos</h2>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre"
                       class="form-control"
                       value="{{ old('nombre', $producto->nombre) }}"
                       required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción corta</label>
                <input type="text" id="descripcion" name="descripcion"
                       class="form-control"
                       value="{{ old('descripcion', $producto->descripcion) }}"
                       required>
            </div>

            <div class="form-group">
                <label for="texto">Texto completo</label>
                <textarea id="texto" name="texto"
                          class="form-control" rows="4"
                          required>{{ old('texto', $producto->texto) }}</textarea>
            </div>

            <div class="form-group">
                <label for="precio">Precio (€)</label>
                <input type="number" id="precio" name="precio"
                       class="form-control" step="0.01"
                       value="{{ old('precio', $producto->precio) }}"
                       required>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock"
                       class="form-control" min="0"
                       value="{{ old('stock', $producto->stock) }}"
                       required>
            </div>
        </div>

        {{-- Imágenes (opcional) --}}
        <div class="form-section">
            <h2>Imágenes (opcional)</h2>
            <p class="note">Si subes nuevas imágenes, reemplazarán las existentes.</p>

            <div class="form-group">
                <label for="imagen1">Imagen 1</label>
                <input type="file" id="imagen1" name="imagenes[0]"
                       class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label for="imagen2">Imagen 2</label>
                <input type="file" id="imagen2" name="imagenes[1]"
                       class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label for="imagen3">Imagen 3</label>
                <input type="file" id="imagen3" name="imagenes[2]"
                       class="form-control" accept="image/*">
            </div>
        </div>

        {{-- Categorías --}}
        @php
            $selected = old('categorias',
                         $producto->categorias->pluck('id')->toArray());
        @endphp
        <div class="form-section">
            <h2>Categorías</h2>
            <div class="categorias-checkboxes">
                @foreach($categorias as $cat)
                    <label>
                        <input type="checkbox" name="categorias[]"
                               value="{{ $cat->id }}"
                            {{ in_array($cat->id, $selected) ? 'checked' : '' }}>
                        {{ $cat->nombre }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Botones --}}
        <div class="form-actions">
            <a href="{{ route('panel') }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-submit">Actualizar Producto</button>
        </div>
    </form>
</div>
</body>
</html>
