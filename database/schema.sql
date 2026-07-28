-- Tabla de Usuarios (admin)
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(50) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Productos (Pinturas)
CREATE TABLE productos (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    tipo VARCHAR(100),
    color VARCHAR(100),
    acabado VARCHAR(100),
    imagen VARCHAR(255),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Pedidos
CREATE TABLE pedidos (
    id SERIAL PRIMARY KEY,
    cliente_nombre VARCHAR(255) NOT NULL,
    cliente_email VARCHAR(255),
    cliente_telefono VARCHAR(20),
    total DECIMAL(10, 2) NOT NULL,
    estado VARCHAR(50) DEFAULT 'confirmado',
    notas TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Items en Pedidos
CREATE TABLE pedido_items (
    id SERIAL PRIMARY KEY,
    pedido_id INT REFERENCES pedidos(id) ON DELETE CASCADE,
    producto_id INT REFERENCES productos(id),
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2),
    subtotal DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Inventario
CREATE TABLE inventario (
    id SERIAL PRIMARY KEY,
    producto_id INT REFERENCES productos(id) ON DELETE CASCADE,
    stock_actual INT DEFAULT 0,
    stock_minimo INT DEFAULT 10,
    ultima_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Consultas (para analytics)
CREATE TABLE consultas (
    id SERIAL PRIMARY KEY,
    tipo VARCHAR(100),
    producto_id INT REFERENCES productos(id),
    cliente_telefono VARCHAR(20),
    mensaje TEXT,
    estado VARCHAR(50) DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Presupuestos
CREATE TABLE presupuestos (
    id SERIAL PRIMARY KEY,
    cliente_nombre VARCHAR(255),
    cliente_email VARCHAR(255),
    cliente_telefono VARCHAR(20),
    metros_cuadrados DECIMAL(10, 2),
    tipo_superficie VARCHAR(100),
    costo_material DECIMAL(10, 2),
    costo_mano_obra DECIMAL(10, 2),
    total DECIMAL(10, 2),
    estado VARCHAR(50) DEFAULT 'enviado',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);