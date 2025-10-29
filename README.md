# Sistema de Gestión de Productos

## Objetivo del Sistema
Sistema web para gestionar productos con base de datos MySQL, permitiendo visualizar, filtrar, buscar, ordenar y realizar operaciones CRUD completas a través de una interfaz intuitiva.


## Version 1.0.0

### Características principales
- Tabla dinámica con visualización de productos (ID, nombre, categoría, precio, stock, valor total)
- Sistema de filtrado por nombre (tiempo real), categoría y stock mínimo
- Ordenamiento por nombre, precio y stock (ascendente/descendente)
- Panel de estadísticas en tiempo real
- Cálculo automático del valor total del inventario
- Formato de moneda argentino

### Implementación técnica
- Métodos de arrays: forEach, filter, sort, reduce
- Funciones principales: mostrarProductos, aplicarFiltros, ordenarProductos, actualizarEstadisticas, limpiarFiltros
- 12 productos iniciales en 4 categorías
- Diseño responsive con tema verde Forest Green

## Version 1.0.1

### Características principales
- Refactorización del código JavaScript en módulos independientes
- 7 archivos separados: datos.js, actualizarEstadisticas.js, mostrarProductos.js, ordenarProductos.js, aplicarFiltros.js, limpiarFiltros.js, main.js
- Orden de carga de scripts optimizado por dependencias
- Mejora en mantenibilidad, escalabilidad y debugging





## Version 1.0.2

### Características principales
- Background SVG decorativo con efecto parallax
- Nueva paleta de colores white (3 tonos) para mejor legibilidad
- Overlay semi-transparente para mantener contraste
- Jerarquía visual mejorada con ratios de contraste WCAG AAA
- Variables CSS: white-200, white-300, white-400

## Version 2.0.0

### Características principales
- Integración completa con backend PHP y base de datos MySQL
- API REST con 4 endpoints CRUD (crear, leer, actualizar, eliminar)
- Arquitectura cliente-servidor con comunicación JSON
- Fetch API y async/await para operaciones asíncronas
- Validaciones de seguridad: sanitización SQL, validación de tipos y rangos
- Estructura de base de datos con timestamps automáticos e índices optimizados
- Respuestas HTTP estandarizadas con códigos apropiados

### Archivos backend
- procesar.php: API REST principal
- conexion.php: Capa de conexión a base de datos
- database.sql: Script de creación con 12 productos de ejemplo

### Instalación
1. Importar database.sql en phpMyAdmin
2. Verificar configuración en conexion.php
3. Iniciar Apache y MySQL en XAMPP
4. Acceder a frontend/index.php
