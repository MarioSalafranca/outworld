document.addEventListener("DOMContentLoaded", () => {
    cargarCarrito(); // 🔄 Cuando cargue la página, llenamos el carrito
});

function cargarCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const contenedorProductos = document.querySelector('.carrito__productos');
    const subtotalElemento = document.querySelector('.carrito__fila span:last-child');
    const totalElemento = document.querySelector('.carrito__fila-total strong:last-child');
    const envioCosto = 5.00;

    contenedorProductos.innerHTML = '';

    let subtotal = 0;

    if (carrito.length === 0) {
        contenedorProductos.innerHTML = `<p class="carrito__vacio">Tu carrito está vacío</p>`;
        subtotalElemento.textContent = `0,00 €`;
        totalElemento.textContent = `5,00 €`;
        return;
    }

    carrito.forEach((producto, index) => {
        subtotal += producto.precio * producto.cantidad;

        const productoHTML = `
            <div class="carrito__producto" data-index="${index}">
                <img src="${producto.imagen}" alt="${producto.nombre}" class="carrito__imagen" />
                <div class="carrito__detalles">
                    <p class="carrito__nombre">${producto.nombre}</p>
                    <div class="carrito__cantidad">
                        <button class="carrito__btn btn-restar">−</button>
                        <span class="carrito__cantidad-numero">${producto.cantidad}</span>
                        <button class="carrito__btn btn-sumar">+</button>
                    </div>
                </div>
                <div class="carrito__precio">${(producto.precio * producto.cantidad).toFixed(2)} €</div>
                <button class="carrito__eliminar"><img src="image/iconos/papelera-de-reciclaje.png"></button>
            </div>
        `;

        contenedorProductos.insertAdjacentHTML('beforeend', productoHTML);
    });

    // 🔄 Actualizar subtotales y totales
    subtotalElemento.textContent = `${subtotal.toFixed(2)} €`;
    totalElemento.textContent = `${(subtotal + envioCosto).toFixed(2)} €`;

    // 🔄 Activar los botones para modificar cantidad o eliminar
    activarBotones();
}

function activarBotones() {
    const restarBotones = document.querySelectorAll('.btn-restar');
    const sumarBotones = document.querySelectorAll('.btn-sumar');
    const eliminarBotones = document.querySelectorAll('.carrito__eliminar');

    restarBotones.forEach((btn, index) => {
        btn.addEventListener('click', () => modificarCantidad(index, -1));
    });

    sumarBotones.forEach((btn, index) => {
        btn.addEventListener('click', () => modificarCantidad(index, 1));
    });

    eliminarBotones.forEach((btn, index) => {
        btn.addEventListener('click', () => eliminarProducto(index));
    });
}

function modificarCantidad(index, cantidad) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const producto = carrito[index];

    if (cantidad > 0) {
        if (producto.cantidad + cantidad > producto.stock) {
            alert(`No hay suficiente stock de ${producto.nombre}. Solo queda ${producto.stock} unidad.`);
            return;
        }
    }

    if (producto.cantidad + cantidad > 0) {
        producto.cantidad += cantidad;
        localStorage.setItem('carrito', JSON.stringify(carrito));
    }

    cargarCarrito();
}

function eliminarProducto(index) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    carrito.splice(index, 1);
    localStorage.setItem('carrito', JSON.stringify(carrito));
    cargarCarrito();
}
