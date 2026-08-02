const CARRITO_KEY = 'carrito_acrilinco';

function obtenerCarrito() {
    try {
        const legacy = localStorage.getItem('carrito');
        const actual = localStorage.getItem(CARRITO_KEY);

        if (!actual && legacy) {
            localStorage.setItem(CARRITO_KEY, legacy);
            localStorage.removeItem('carrito');
            return JSON.parse(legacy) || [];
        }

        return JSON.parse(actual) || [];
    } catch {
        return [];
    }
}

function guardarCarrito(carrito) {
    localStorage.setItem(CARRITO_KEY, JSON.stringify(carrito));
}

function agregarAlCarrito(productId, cantidad = 1) {
    const carrito = obtenerCarrito();
    const item = carrito.find(i => i.id === productId);

    if (item) {
        item.cantidad += cantidad;
    } else {
        carrito.push({ id: productId, cantidad });
    }

    guardarCarrito(carrito);
    actualizarContadorCarrito();
}

function actualizarContadorCarrito() {
    const carrito = obtenerCarrito();
    const total = carrito.reduce((sum, item) => sum + item.cantidad, 0);
    document.querySelectorAll('#carrito-count').forEach(el => {
        el.textContent = total;
    });
}

function formatearPrecio(precio) {
    return Number(precio).toLocaleString('es-CO');
}

function nombreCategoria(producto) {
    return producto.categoria?.nombre || producto.tipo || '-';
}

function nombreAcabado(producto) {
    return producto.acabado?.nombre || producto.acabado || '-';
}

function colorProducto(producto) {
    return producto.nombre_color || producto.color || 'Color';
}

function hexProducto(producto) {
    return producto.codigo_color_hex || producto.color || '#033380';
}
