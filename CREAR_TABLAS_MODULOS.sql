-- ===== MÓDULO BANCARIO =====
CREATE TABLE IF NOT EXISTS cuentas_bancarias (
  id INT PRIMARY KEY AUTO_INCREMENT,
  banco VARCHAR(100) NOT NULL,
  numero_cuenta VARCHAR(50) NOT NULL UNIQUE,
  tipo_cuenta VARCHAR(50),
  titular VARCHAR(150),
  saldo_inicial DECIMAL(15,2) DEFAULT 0,
  saldo_actual DECIMAL(15,2) DEFAULT 0,
  estado VARCHAR(20) DEFAULT 'activa',
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS movimientos_bancarios (
  id INT PRIMARY KEY AUTO_INCREMENT,
  cuenta_id INT NOT NULL,
  tipo ENUM('ingreso', 'salida') NOT NULL,
  monto DECIMAL(15,2) NOT NULL,
  descripcion TEXT,
  fecha DATE,
  referencia VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (cuenta_id) REFERENCES cuentas_bancarias(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS conciliaciones_bancarias (
  id INT PRIMARY KEY AUTO_INCREMENT,
  cuenta_id INT NOT NULL,
  saldo_banco DECIMAL(15,2),
  saldo_sistema DECIMAL(15,2),
  diferencia DECIMAL(15,2),
  fecha DATE,
  estado VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (cuenta_id) REFERENCES cuentas_bancarias(id)
);

-- ===== MÓDULO PAGOS =====
CREATE TABLE IF NOT EXISTS proveedores (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(150) NOT NULL,
  ruc VARCHAR(20) UNIQUE,
  email VARCHAR(100),
  telefono VARCHAR(20),
  direccion TEXT,
  estado VARCHAR(20) DEFAULT 'activo',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS comisiones (
  id INT PRIMARY KEY AUTO_INCREMENT,
  proveedor_id INT,
  porcentaje DECIMAL(5,2),
  monto_minimo DECIMAL(15,2),
  descripcion TEXT,
  estado VARCHAR(20) DEFAULT 'activa',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (proveedor_id) REFERENCES proveedores(id)
);

CREATE TABLE IF NOT EXISTS pagos_proveedores (
  id INT PRIMARY KEY AUTO_INCREMENT,
  proveedor_id INT NOT NULL,
  monto DECIMAL(15,2) NOT NULL,
  fecha_pago DATE,
  metodo_pago VARCHAR(50),
  referencia VARCHAR(100),
  estado VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (proveedor_id) REFERENCES proveedores(id)
);

CREATE TABLE IF NOT EXISTS recibos_honorarios (
  id INT PRIMARY KEY AUTO_INCREMENT,
  numero_recibo VARCHAR(50) UNIQUE,
  beneficiario VARCHAR(150),
  monto DECIMAL(15,2),
  concepto TEXT,
  fecha DATE,
  estado VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===== MÓDULO TRIBUTARIO =====
CREATE TABLE IF NOT EXISTS compras (
  id INT PRIMARY KEY AUTO_INCREMENT,
  numero_documento VARCHAR(50),
  proveedor VARCHAR(150),
  ruc_proveedor VARCHAR(20),
  monto_bruto DECIMAL(15,2),
  igv DECIMAL(15,2),
  monto_total DECIMAL(15,2),
  fecha_compra DATE,
  descripcion TEXT,
  estado VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS ventas (
  id INT PRIMARY KEY AUTO_INCREMENT,
  numero_comprobante VARCHAR(50),
  cliente VARCHAR(150),
  ruc_cliente VARCHAR(20),
  monto_bruto DECIMAL(15,2),
  igv DECIMAL(15,2),
  monto_total DECIMAL(15,2),
  fecha_venta DATE,
  tipo_comprobante VARCHAR(50),
  estado VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS declaraciones_tributarias (
  id INT PRIMARY KEY AUTO_INCREMENT,
  periodo VARCHAR(20),
  total_ventas DECIMAL(15,2),
  total_compras DECIMAL(15,2),
  igv_ventas DECIMAL(15,2),
  igv_compras DECIMAL(15,2),
  igv_a_pagar DECIMAL(15,2),
  fecha_declaracion DATE,
  estado VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS costos_proyecto (
  id INT PRIMARY KEY AUTO_INCREMENT,
  proyecto_id INT,
  concepto VARCHAR(150),
  monto DECIMAL(15,2),
  fecha DATE,
  categoria VARCHAR(100),
  descripcion TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS clasificaciones_compra (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100),
  descripcion TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===== MÓDULO DOCUMENTAL =====
CREATE TABLE IF NOT EXISTS archivos_digitales (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(200),
  ruta_archivo VARCHAR(255),
  tipo VARCHAR(100),
  tamaño INT,
  fecha_subida DATETIME,
  usuario_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS requerimientos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  numero_requerimiento VARCHAR(50),
  descripcion TEXT,
  usuario_solicitante VARCHAR(150),
  fecha_requerimiento DATE,
  fecha_entrega_esperada DATE,
  prioridad VARCHAR(50),
  estado VARCHAR(20),
  observaciones TEXT,
  fecha_completado DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS documentos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  titulo VARCHAR(200),
  descripcion TEXT,
  tipo_documento VARCHAR(100),
  estado VARCHAR(20),
  fecha_creacion DATE,
  usuario_responsable INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
