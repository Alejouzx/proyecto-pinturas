// ============================================
// API.JS - Conexión con el Backend Acrilinco
// ============================================

// URL base del backend (cambiar cuando subamos a producción)
const API_URL = 'http://127.0.0.1:8000/api';

// ============================================
// FUNCIONES DE PRODUCTOS
// ============================================

/**
 * Obtiene todos los productos (con filtros opcionales)
 */
async function obtenerProductos(filtros = {}) {
    try {
        let url = `${API_URL}/productos`;
        
        // Agregar filtros como query params
        const params = new URLSearchParams();
        if (filtros.tipo) params.append('tipo', filtros.tipo);
        if (filtros.nombre) params.append('nombre', filtros.nombre);
        if (filtros.precioMin) params.append('precio_min', filtros.precioMin);
        if (filtros.precioMax) params.append('precio_max', filtros.precioMax);
        
        if (params.toString()) {
            url += '?' + params.toString();
        }

        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error obteniendo productos:', error);
        return [];
    }
}

/**
 * Obtiene un producto específico por ID
 */
async function obtenerProducto(id) {
    try {
        const response = await fetch(`${API_URL}/productos/${id}`);
        
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error obteniendo producto:', error);
        return null;
    }
}

/**
 * Crea un nuevo producto (para admin)
 */
async function crearProducto(producto) {
    try {
        const response = await fetch(`${API_URL}/productos`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(producto)
        });
        
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error creando producto:', error);
        return null;
    }
}

// ============================================
// FUNCIONES DE PEDIDOS
// ============================================

/**
 * Crea un nuevo pedido
 */
async function crearPedido(pedido) {
    try {
        const response = await fetch(`${API_URL}/pedidos`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(pedido)
        });
        
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error creando pedido:', error);
        return null;
    }
}

/**
 * Obtiene el estado de un pedido
 */
async function obtenerPedido(id) {
    try {
        const response = await fetch(`${API_URL}/pedidos/${id}`);
        
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error obteniendo pedido:', error);
        return null;
    }
}

// ============================================
// FUNCIONES DE UTILIDAD
// ============================================

/**
 * Formatea un número como precio en pesos colombianos
 */
function formatearPrecio(numero) {
    return '$' + numero.toLocaleString('es-CO');
}

/**
 * Muestra un mensaje de error genérico en un contenedor
 */
function mostrarError(containerId, mensaje = 'Ocurrió un error. Intenta de nuevo.') {
    const container = document.getElementById(containerId);
    if (container) {
        container.innerHTML = `<p style="text-align: center; color: #E74C3C; padding: 2rem;">⚠️ ${mensaje}</p>`;
    }
}

/**
 * Muestra un mensaje de carga en un contenedor
 */
function mostrarCargando(containerId, mensaje = 'Cargando...') {
    const container = document.getElementById(containerId);
    if (container) {
        container.innerHTML = `<p class="loading">${mensaje}</p>`;
    }
}