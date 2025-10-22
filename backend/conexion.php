<?php
/**
 * conexion.php
 * Archivo de configuración y conexión a la base de datos MySQL
 * @author Sistema de Gestión de Productos
 * @version 1.0.0
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gestion_productos');

// Crear conexión
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexión
if (!$conn) {
    // Enviar respuesta JSON de error
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(500);
    echo json_encode(array(
        'exito' => false,
        'mensaje' => 'Error de conexión a la base de datos: ' . mysqli_connect_error()
    ), JSON_UNESCAPED_UNICODE);
    exit;
}

// Configurar charset UTF-8 para evitar problemas con caracteres especiales
mysqli_set_charset($conn, "utf8");

?>
