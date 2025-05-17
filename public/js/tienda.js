document.addEventListener("DOMContentLoaded", () => {
    carritoFlotante();  // Coger info y guardar en localStorage
    actualizarCarritoFlotante(); // Actualizar carrito (añadir y eliminar)
    actualizarContadorCarrito(); // Contador de arriba
    carritoSticky();
    mostrarOcultar();
    filtros();
});

function carritoFlotante() {
    // Capturamos ambos tipos de botón
    const addToCartButtons = document.querySelectorAll('.btn-compra, .btn-add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            // 1) Buscamos el contenedor que tenga los data-…
            const productElement = this.closest('[data-product-id]');
            const id    = productElement.dataset.productId;
            const stock = parseInt(productElement.dataset.productStock, 10);
            const price = parseFloat(productElement.dataset.productPrice);

            // 2) Leemos la cantidad elegida (solo existirá en detalle)
            const qtyDropdown = productElement.querySelector('.quantity-dropdown');
            const cantidad    = qtyDropdown
                ? parseInt(qtyDropdown.value, 10)
                : 1;

            // 3) Validamos contra stock
            let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            const existente = carrito.find(p => p.id === id);
            const nuevaCant = existente
                ? existente.cantidad + cantidad
                : cantidad;
            if (nuevaCant > stock) {
                alert(`No hay suficiente stock. Solo quedan ${stock} unidades.`);
                return;
            }

            // 4) Obtenemos nombre e imagen (adaptado a detail o listado)
            const nombre = productElement.querySelector('.product-titulo h3')?.innerText
                || productElement.querySelector('h2')?.innerText;
            const imgEl  = productElement.querySelector('img');
            const imgSrc = imgEl
                ? imgEl.src.substring(imgEl.src.indexOf('/storage'))
                : '';

            // 5) Creamos el objeto y lo guardamos
            const producto = { id, nombre, precio: price, imagen: imgSrc, cantidad, stock };
            addToLocalStorage(producto);

            // 6) Actualizamos vistas
            actualizarCarritoFlotante();
            actualizarContadorCarrito();
        });
    });
}


function addToLocalStorage(producto) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const existente = carrito.find(p => p.id === producto.id);
    if (existente) {
        // sumamos la cantidad que venga en el objeto
        existente.cantidad += producto.cantidad;
    } else {
        carrito.push(producto);
    }
    localStorage.setItem('carrito', JSON.stringify(carrito));
}

function actualizarCarritoFlotante() {
    const cartItemsContainer = document.getElementById('cartItems');
    const cartSubtotalElement = document.getElementById('cartSubtotal');

    cartItemsContainer.innerHTML = '';

    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    let subtotal = 0;

    carrito.forEach(producto => {
        const itemElement = document.createElement('div');
        itemElement.classList.add('cart-item');

        itemElement.innerHTML = `
            <img src="${producto.imagen}" class="cart-item-img" alt="${producto.nombre}">
            <div class="cart-item-info">
                <span class="item-nombre">${producto.nombre}</span><br>
                <span class="item-precio">${producto.precio}€ x ${producto.cantidad}</span><br>
            </div>
            <button class="remove-item" data-product-id="${producto.id}">❌</button>
        `;

        cartItemsContainer.appendChild(itemElement);

        subtotal += producto.precio * producto.cantidad;
    });

    cartSubtotalElement.textContent = `${subtotal.toFixed(2)}€`;

    // Añadir eventos de eliminar
    const removeButtons = document.querySelectorAll('.remove-item');
    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            eliminarProductoCarrito(productId);
        });
    });
    actualizarContadorCarrito();
}

function actualizarContadorCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const totalItems = carrito.reduce((sum, producto) => sum + producto.cantidad, 0);

    const contador = document.querySelector('.cart-count');
    if (contador) {
        contador.textContent = totalItems;
    }
}

function eliminarProductoCarrito(productId) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    carrito = carrito.filter(producto => producto.id !== productId);
    localStorage.setItem('carrito', JSON.stringify(carrito));

    // Actualizamos la vista del carrito
    actualizarCarritoFlotante();
}

function carritoSticky() {
    let lastScrollTop = 0;
    const cartPopup1 = document.getElementById('cartPopup');

    window.addEventListener('scroll', function() {
        let scrollTop = window.scrollY || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop) {
            cartPopup1.style.transform = 'translateY(100px)';
            cartPopup1.style.opacity = '0';
            cartPopup1.style.transition = 'all 0.4s ease';
        } else {
            cartPopup1.style.transform = 'translateY(0)';
            cartPopup1.style.opacity = '1';
            cartPopup1.style.transition = 'all 0.4s ease';
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }, false);
}

function mostrarOcultar() {
    const cartButton = document.getElementById('cartButton');
    const cartPopup = document.getElementById('cartPopup');

    cartButton.addEventListener('click', function(event) {
        event.preventDefault();
        cartPopup.style.display = cartPopup.style.display === 'block' ? 'none' : 'block';
    });
}

function filtros() {
    const filterButtons = document.querySelectorAll('.filter-btn, .filter-sub');
    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            const category = this.getAttribute('data-category');
            const subcategory = this.getAttribute('data-subcategory');
            let url = new URL(window.location.href);

            if (category && category !== 'all') {
                url.searchParams.set('categoria', category);
            } else {
                url.searchParams.delete('categoria');
            }

            if (subcategory) {
                url.searchParams.set('subcategoria', subcategory);
            } else {
                url.searchParams.delete('subcategoria');
            }

            window.location.href = url.toString();
        });
    });
}
