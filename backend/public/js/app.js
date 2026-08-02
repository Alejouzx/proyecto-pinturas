async function cargarProductosDestacados() {
    const container = document.getElementById('productos-destacados');
    if (!container) return;

    try {
        const response = await fetch('/api/productos?destacados=1');
        const productos = await response.json();

        if (!productos.length) {
            container.innerHTML = '<p style="text-align:center;color:#7f8c8d;">No hay productos disponibles</p>';
            return;
        }

        container.innerHTML = productos.map(p => `
            <div class="producto-card">
                <div class="producto-img" style="background:${hexProducto(p)};">🎨</div>
                <div class="producto-info">
                    <h4>${p.nombre}</h4>
                    <p><strong>Categoría:</strong> ${nombreCategoria(p)}</p>
                    <p style="color:${hexProducto(p)};">● ${colorProducto(p)}</p>
                    <div class="producto-precio">$${formatearPrecio(p.precio)}</div>
                    <a href="pages/producto.html?id=${p.id}" class="btn btn-primary" style="display:block;text-align:center;margin-top:0.5rem;">
                        Ver detalles
                    </a>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error cargando destacados:', error);
        container.innerHTML = '<p style="text-align:center;color:#E74C3C;">Error al cargar productos</p>';
    }
}

window.addEventListener('load', () => {
    actualizarContadorCarrito();
    cargarProductosDestacados();
});
