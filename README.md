# Ejercicio 16: Sistema de Gestión de Productos con JavaScript
📋 Consigna
Crear un sistema de gestión de productos utilizando JavaScript puro que permita visualizar, filtrar, buscar y ordenar productos. Este ejercicio simula el trabajo con datos que normalmente vendrían de una base de datos.

🎯 Objetivos de Aprendizaje
Trabajar con arrays de objetos (estructura similar a registros de base de datos)
Aplicar métodos de arrays: filter(), sort(), reduce(), forEach()
Manipular el DOM dinámicamente
Implementar filtros y búsquedas en tiempo real
Calcular estadísticas sobre conjuntos de datos
Preparar conceptos para trabajar con PHP y MySQL

📝 Requisitos Funcionales
El sistema debe permitir:
Visualizar productos en una tabla con las siguientes columnas:


ID
Nombre
Categoría
Precio
Stock
Valor Total (precio × stock)
Filtrar productos por:


Nombre (búsqueda en tiempo real)
Categoría (dropdown)
Stock mínimo
Ordenar productos por:


Nombre (A-Z / Z-A)
Precio (menor a mayor / mayor a menor)
Stock (menor a mayor / mayor a menor)
Mostrar estadísticas:


Total de productos
Productos filtrados actualmente
Valor total del stock
Limpiar filtros con un botón para resetear



💾 Datos Iniciales
Los productos están definidos en un array de objetos:
const productos = [
    { id: 1, nombre: "Laptop Dell", categoria: "Electrónica", precio: 45000, stock: 5 },
    { id: 2, nombre: "Mouse Logitech", categoria: "Electrónica", precio: 1500, stock: 25 },
    { id: 3, nombre: "Teclado Mecánico", categoria: "Electrónica", precio: 8000, stock: 15 },
    { id: 4, nombre: "Remera Nike", categoria: "Ropa", precio: 3500, stock: 50 },
    { id: 5, nombre: "Pantalón Levis", categoria: "Ropa", precio: 12000, stock: 30 },
    { id: 6, nombre: "Zapatillas Adidas", categoria: "Ropa", precio: 25000, stock: 20 },
    { id: 7, nombre: "Arroz 1kg", categoria: "Alimentos", precio: 800, stock: 100 },
    { id: 8, nombre: "Fideos", categoria: "Alimentos", precio: 600, stock: 150 },
    { id: 9, nombre: "Aceite", categoria: "Alimentos", precio: 1200, stock: 80 },
    { id: 10, nombre: "Lámpara LED", categoria: "Hogar", precio: 2500, stock: 40 },
    { id: 11, nombre: "Silla Gamer", categoria: "Hogar", precio: 35000, stock: 8 },
    { id: 12, nombre: "Monitor 24 pulgadas", categoria: "Electrónica", precio: 55000, stock: 3 }
];


🔧 Funciones a Implementar
1. mostrarProductos(arrayProductos)
Recibe un array de productos y los muestra en la tabla del HTML.
Debe:
Limpiar el contenido actual de la tabla
Recorrer el array con forEach()
Crear filas de tabla dinámicamente
Calcular el valor total de cada producto (precio × stock)
Mostrar mensaje si no hay productos

2. aplicarFiltros()
Filtra los productos según los criterios seleccionados.
Debe:
Obtener los valores de los inputs de filtro
Usar filter() para filtrar el array original
Llamar a ordenarProductos() con los resultados
Considerar múltiples condiciones (nombre AND categoría AND stock)

3. ordenarProductos(arrayProductos)
Ordena los productos según el criterio seleccionado.
Debe:
Usar sort() con funciones de comparación
Manejar ordenamiento ascendente y descendente
Llamar a mostrarProductos() con los resultados ordenados

4. actualizarEstadisticas(arrayProductos)
Calcula y muestra las estadísticas.
Debe:
Contar total de productos
Contar productos filtrados
Usar reduce() para calcular el valor total del stock
Actualizar los elementos HTML correspondientes
5. limpiarFiltros()

Resetea todos los filtros a sus valores por defecto.
Debe:
Limpiar inputs y selects
Mostrar todos los productos nuevamente

📁 Archivos a Entregar
Archivo único: productos.html
Este archivo debe contener:
Estructura HTML
Estilos CSS
Código JavaScript


# Feature - Version 1.0.0

## 🎉 Características Implementadas

### ✅ Funcionalidades Core

#### 1. **Visualización de Productos**
- Tabla dinámica con todas las columnas requeridas (ID, Nombre, Categoría, Precio, Stock, Valor Total)
- Cálculo automático del valor total (precio × stock) para cada producto
- Formato de moneda argentino para precios y totales
- Mensaje informativo cuando no hay productos que mostrar

#### 2. **Sistema de Filtrado Inteligente**
- **Búsqueda por nombre**: Filtrado en tiempo real mientras el usuario escribe
- **Filtro por categoría**: Dropdown con 4 categorías (Electrónica, Ropa, Alimentos, Hogar)
- **Filtro por stock mínimo**: Input numérico para establecer un umbral
- **Filtros combinados**: Aplica múltiples condiciones simultáneamente (AND)

#### 3. **Sistema de Ordenamiento**
- **Por nombre**: Alfabético ascendente (A-Z) o descendente (Z-A)
- **Por precio**: De menor a mayor o de mayor a menor
- **Por stock**: De menor a mayor o de mayor a menor
- Preserva los filtros aplicados al ordenar

#### 4. **Panel de Estadísticas en Tiempo Real**
- **Total de productos**: Muestra el número total en la base de datos (12 productos)
- **Productos filtrados**: Cantidad de productos que cumplen los criterios actuales
- **Valor total del stock**: Suma del valor total de todos los productos filtrados

#### 5. **Gestión de Filtros**
- Botón "Aplicar Filtros" para ejecutar el filtrado
- Botón "Limpiar Filtros" para resetear todos los criterios
- Actualización automática en tiempo real para búsqueda por nombre

### 🛠️ Implementación Técnica

#### Métodos de Arrays Utilizados
- **`forEach()`**: Para recorrer productos y crear filas de tabla
- **`filter()`**: Para filtrar productos según criterios múltiples
- **`sort()`**: Para ordenar productos con comparadores personalizados
- **`reduce()`**: Para calcular el valor total del inventario
- **`map()`**: Para transformaciones de datos (implícito en operaciones)

#### Funciones Principales
```javascript
1. mostrarProductos(arrayProductos)
   - Limpia y renderiza la tabla
   - Crea filas dinámicamente con DOM
   - Formatea valores monetarios

2. aplicarFiltros()
   - Obtiene valores de inputs
   - Aplica filter() con condiciones AND
   - Delega ordenamiento

3. ordenarProductos(arrayProductos)
   - Ordena con sort() y comparadores
   - Maneja 6 criterios diferentes
   - Muestra resultados

4. actualizarEstadisticas(arrayProductos)
   - Calcula totales con reduce()
   - Actualiza DOM con resultados
   - Formatea números

5. limpiarFiltros()
   - Resetea inputs a valores default
   - Restaura vista completa
```

### 🎨 Diseño Visual

#### Paleta de Colores (Forest Green Theme)
- **Fondo principal**: Verde oscuro (#001502)
- **Acentos**: Verde brillante (#00fe53)
- **Alertas**: Rojo antorcha (#ff1f31)
- **Destacados**: Amarillo dorado (#f8f800)

#### Características de UI/UX
- Diseño responsive para móviles y tablets
- Efectos hover en filas de tabla
- Transiciones suaves en botones y inputs
- Sombras y bordes para profundidad visual
- Focus states accesibles en inputs

### 📊 Datos Iniciales
- **12 productos** distribuidos en 4 categorías
- Rangos de precio: $600 - $55,000
- Rangos de stock: 3 - 150 unidades
- Valor total del inventario: **$1,663,600**

### 🔄 Flujo de Usuario
1. Al cargar la página, se muestran todos los productos ordenados alfabéticamente
2. El usuario puede escribir en el campo de búsqueda (actualización en tiempo real)
3. Puede seleccionar categoría y stock mínimo
4. Puede elegir criterio de ordenamiento
5. Presiona "Aplicar Filtros" o los filtros se aplican automáticamente
6. Las estadísticas se actualizan dinámicamente
7. Puede limpiar filtros con un solo clic

### 📈 Estadísticas de la Implementación
- **Líneas de código JavaScript**: ~200
- **Funciones implementadas**: 5 principales + event listeners
- **Event listeners**: 6 (carga, botones, inputs en tiempo real)
- **Métodos de array utilizados**: 4 principales (forEach, filter, sort, reduce)

### 🚀 Preparación para PHP + MySQL
Esta versión prepara el terreno para:
- Migración de array local a base de datos MySQL
- Implementación de CRUD completo
- Paginación de resultados
- Búsqueda en servidor
- Autenticación de usuarios

---

## 📝 Notas de Desarrollo
- Código comentado siguiendo estándares JSDoc
- Variables con nombres descriptivos
- Funciones puras y reutilizables
- Separación de responsabilidades
- Compatible con navegadores modernos

## 🐛 Testing Manual Realizado
✅ Filtrado por nombre (case insensitive)  
✅ Filtrado por categoría (todas las opciones)  
✅ Filtrado por stock mínimo  
✅ Combinación de filtros múltiples  
✅ Ordenamiento en ambas direcciones  
✅ Cálculo correcto de estadísticas  
✅ Limpieza de filtros  
✅ Responsive design  
✅ Búsqueda en tiempo real

# Feature - Version 1.0.1

## 🔧 Refactorización: Código Modular

### 🎯 Objetivo
Separar el código JavaScript monolítico en módulos independientes para mejorar:
- **Mantenibilidad**: Cada función en su propio archivo
- **Escalabilidad**: Fácil agregar nuevas funcionalidades
- **Legibilidad**: Código organizado y estructurado
- **Reutilización**: Funciones independientes y portables
- **Debugging**: Más fácil identificar y corregir errores

### 📁 Nueva Estructura de Archivos

```
frontend/
├── productos.html          # HTML principal (sin código JS inline)
├── styles.css             # Estilos (sin cambios)
└── js/                    # Nueva carpeta de módulos JavaScript
    ├── datos.js           # Array de productos
    ├── actualizarEstadisticas.js
    ├── mostrarProductos.js
    ├── ordenarProductos.js
    ├── aplicarFiltros.js
    ├── limpiarFiltros.js
    └── main.js            # Inicialización y event listeners
```

### 📦 Módulos Implementados

#### 1. **datos.js** (23 líneas)
**Propósito**: Contiene el array de productos que simula datos de base de datos
- Define el array `productos` como variable global
- 12 productos con estructura: `{id, nombre, categoria, precio, stock}`
- Accesible por todos los demás módulos
- En producción, este archivo se reemplazará por llamadas a API/Base de datos

```javascript
const productos = [ /* 12 productos */ ];
```

#### 2. **actualizarEstadisticas.js** (31 líneas)
**Propósito**: Calcular y mostrar estadísticas del inventario
- **Entrada**: Array de productos filtrados
- **Proceso**: 
  - Cuenta total de productos originales
  - Cuenta productos filtrados actuales
  - Usa `reduce()` para calcular valor total del stock
- **Salida**: Actualiza 3 elementos del DOM
- **Métodos usados**: `reduce()`

#### 3. **mostrarProductos.js** (48 líneas)
**Propósito**: Renderizar productos en la tabla HTML
- **Entrada**: Array de productos a mostrar
- **Proceso**:
  - Limpia contenido previo de la tabla
  - Valida si hay productos (muestra mensaje si está vacío)
  - Usa `forEach()` para iterar productos
  - Crea filas dinámicamente con `createElement()`
  - Calcula valor total por producto (precio × stock)
  - Formatea moneda con `toLocaleString('es-AR')`
- **Salida**: Tabla HTML poblada
- **Dependencias**: Llama a `actualizarEstadisticas()`
- **Métodos usados**: `forEach()`

#### 4. **ordenarProductos.js** (45 líneas)
**Propósito**: Ordenar productos según criterio seleccionado
- **Entrada**: Array de productos a ordenar
- **Proceso**:
  - Obtiene criterio del select (6 opciones)
  - Crea copia del array con spread operator `[...]`
  - Usa `sort()` con comparadores personalizados
  - Switch para manejar 6 casos diferentes
- **Salida**: Array ordenado
- **Dependencias**: Llama a `mostrarProductos()`
- **Métodos usados**: `sort()`, spread operator

**Criterios de ordenamiento**:
- `nombre_asc/desc`: Alfabético con `localeCompare()`
- `precio_asc/desc`: Numérico ascendente/descendente
- `stock_asc/desc`: Numérico ascendente/descendente

#### 5. **aplicarFiltros.js** (30 líneas)
**Propósito**: Filtrar productos según múltiples criterios
- **Entrada**: Ninguna (lee valores del DOM)
- **Proceso**:
  - Obtiene valores de 3 inputs (buscar, categoría, stock)
  - Usa `filter()` con función de predicado compleja
  - Aplica 3 condiciones con operador AND
  - `toLowerCase()` para búsqueda case-insensitive
- **Salida**: Array filtrado
- **Dependencias**: Llama a `ordenarProductos()`
- **Métodos usados**: `filter()`, `includes()`, `toLowerCase()`

**Condiciones de filtrado**:
- `cumpleNombre`: Búsqueda parcial en nombre
- `cumpleCategoria`: Match exacto o "todas"
- `cumpleStock`: Stock >= valor mínimo

#### 6. **limpiarFiltros.js** (22 líneas)
**Propósito**: Resetear todos los filtros a valores por defecto
- **Entrada**: Ninguna
- **Proceso**:
  - Limpia campo de búsqueda
  - Resetea select de categoría a "todas"
  - Resetea stock mínimo a "0"
  - Resetea ordenamiento a "nombre_asc"
- **Salida**: Vista completa de productos
- **Dependencias**: Llama a `ordenarProductos(productos)`

#### 7. **main.js** (28 líneas)
**Propósito**: Inicialización y gestión de eventos
- **Event Listeners** configurados:
  - `DOMContentLoaded`: Carga inicial de productos
  - `click` en botón "Aplicar Filtros"
  - `click` en botón "Limpiar Filtros"
  - `input` en campo búsqueda (tiempo real)
  - `change` en select categoría
  - `input` en stock mínimo
  - `change` en select ordenamiento
- **Rol**: Punto de entrada de la aplicación
- **Patrón**: Event-driven architecture

### 🔗 Orden de Carga de Scripts (Crítico)

El orden en `productos.html` es **fundamental** debido a dependencias:

```html
<!-- 1. Datos primero (usado por todos) -->
<script src="js/datos.js"></script>

<!-- 2. Estadísticas (usada por mostrarProductos) -->
<script src="js/actualizarEstadisticas.js"></script>

<!-- 3. Mostrar (usada por ordenarProductos) -->
<script src="js/mostrarProductos.js"></script>

<!-- 4. Ordenar (usada por aplicarFiltros y limpiarFiltros) -->
<script src="js/ordenarProductos.js"></script>

<!-- 5. Funciones de filtrado -->
<script src="js/aplicarFiltros.js"></script>
<script src="js/limpiarFiltros.js"></script>

<!-- 6. Inicialización (última) -->
<script src="js/main.js"></script>
```

### 📊 Diagrama de Dependencias

```
datos.js (productos[])
    ↓
actualizarEstadisticas.js
    ↓
mostrarProductos.js ────┐
    ↓                   │
ordenarProductos.js ←───┘
    ↓           ↓
aplicarFiltros  limpiarFiltros
    ↓           ↓
    main.js (Event Listeners)
```



