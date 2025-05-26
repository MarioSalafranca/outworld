<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="crear-producto-view">
<div class="container">
    <h1>Crear Nuevo Producto</h1>
    <form method="POST" action="{{ route('panel.registrarProductoAdmin') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-section">
            <h2>Datos Básicos</h2>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción corta</label>
                <input type="text" id="descripcion" name="descripcion" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="texto">Texto completo</label>
                <textarea id="texto" name="texto" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="precio">Precio (€)</label>
                <input type="number" id="precio" name="precio" class="form-control" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" class="form-control" min="0" required>
            </div>
        </div>

        <div class="form-section">
            <h2>Imágenes del Producto</h2>

            <div class="form-group">
                <label for="imagen1">Imagen 1</label>
                <input type="file" id="imagen1" name="imagenes[]" class="form-control" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="imagen2">Imagen 2</label>
                <input type="file" id="imagen2" name="imagenes[]" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label for="imagen3">Imagen 3</label>
                <input type="file" id="imagen3" name="imagenes[]" class="form-control" accept="image/*">
            </div>
        </div>

        <div class="form-section">
            <h2>Categorías</h2>
            <div class="form-group categorias-checkboxes">
                @foreach($categorias as $cat)
                    <label style="display: block; margin-bottom: 6px;">
                        <input type="checkbox" name="categorias[]" value="{{ $cat->id }}">
                        {{ $cat->nombre }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- … sección Categorías … --}}

        <div class="form-section">
            <h2>Atributos</h2>

            <div class="form-group">
                <label for="sabor">Sabor</label>
                <input type="text" id="sabor" name="sabor" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="tamanio">Tamaño</label>
                <select id="tamanio" name="tamanio" class="form-control" required>
                    @foreach($tamanios as $t)
                        <option
                            value="{{ $t }}"
                            {{ old('tamanio') == $t ? 'selected' : '' }}
                        >{{ $t }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="porcentaje_alcohol">Porcentaje de Alcohol (%)</label>
                <input type="number" id="porcentaje_alcohol" name="porcentaje_alcohol" class="form-control" step="1" min="0" max="100" required>
            </div>

            <div class="form-group">
                <label for="metodo_destilacion">Método de Destilación</label>
                <select id="metodo_destilacion" name="metodo_destilacion" class="form-control" required>
                    @foreach($metodos as $m)
                        <option
                            value="{{ $m }}"
                            {{ old('metodo_destilacion') == $m ? 'selected' : '' }}
                        >{{ $m }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="color">Color</label>
                <input type="text" id="color" name="color" class="form-control" required>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('panel') }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-submit">Crear Producto</button>
        </div>
    </form>
</div>
</body>
</html>
