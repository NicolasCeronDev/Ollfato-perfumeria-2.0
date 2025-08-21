<?php
// Configuración
ini_set('display_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json');

// Conexión
require 'conexion_db.php';
if ($conexion->connect_error) {
    error_log("Error de conexión: " . $conexion->connect_error);
    echo json_encode(['success' => false, 'error' => 'Error de conexión']);
    exit();
}

// Validación básica
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    $conexion->close();
    exit();
}

// Procesar datos
$datos = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE || !isset($datos['cliente'], $datos['carrito'], $datos['pago'], $datos['total'])) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    $conexion->close();
    exit();
}

// Iniciar transacción
$conexion->begin_transaction();

try {
    // 1. Preparar datos del cliente (variables separadas para bind_param)
    $nombre = htmlspecialchars($datos['cliente']['nombre'] ?? '');
    $email = htmlspecialchars($datos['cliente']['email'] ?? '');
    $telefono = htmlspecialchars($datos['cliente']['telefono'] ?? '');
    $direccion = htmlspecialchars($datos['cliente']['direccion'] ?? '');
    $ciudad = htmlspecialchars($datos['cliente']['ciudad'] ?? '');
    $barrio = htmlspecialchars($datos['cliente']['barrio'] ?? '');
    $notas = htmlspecialchars($datos['cliente']['notas'] ?? '');
    $metodo_pago = htmlspecialchars($datos['pago']['metodo'] ?? 'Desconocido');
    $detalles_pago = json_encode($datos['pago']['detalles'] ?? []);
    $estado = 'Pendiente';

    // 2. Insertar orden principal
    $stmt_orden = $conexion->prepare("INSERT INTO ordenes (
        fecha_orden, 
        estado_orden, 
        total_orden,
        nombre_cliente,
        email_cliente,
        telefono_cliente,
        direccion_envio,
        ciudad,
        barrio,
        notas_cliente,
        metodo_pago,
        detalles_pago
    ) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt_orden->bind_param(
        "sdsssssssss",
        $estado,
        $datos['total'],
        $nombre,
        $email,
        $telefono,
        $direccion,
        $ciudad,
        $barrio,
        $notas,
        $metodo_pago,
        $detalles_pago
    );

    if (!$stmt_orden->execute()) {
        throw new Exception("Error al guardar orden: " . $stmt_orden->error);
    }

    $id_orden = $conexion->insert_id;
    $stmt_orden->close();

    // 3. Procesar items del carrito
    $stmt_detalle = $conexion->prepare("INSERT INTO detalles_ordenes (
        id_orden,
        id_producto,
        cantidad,
        precio_unitario,
        subtotal,
        tamaño,
        color
    ) VALUES (?, ?, ?, ?, ?, ?, ?)");

    foreach ($datos['carrito'] as $item) {
        // Validar item
        if (empty($item['id']) || empty($item['cantidad']) || empty($item['tamano'])) {
            continue;
        }

        // Obtener precio real
        $stmt_precio = $conexion->prepare("SELECT precio FROM precios_tamaños WHERE id_producto = ? AND tamaño = ?");
        $stmt_precio->bind_param("is", $item['id'], $item['tamano']);
        $stmt_precio->execute();
        $resultado = $stmt_precio->get_result();

        if ($resultado->num_rows === 0) {
            $stmt_precio->close();
            continue;
        }

        $precio = $resultado->fetch_assoc()['precio'];
        $subtotal = $precio * $item['cantidad'];
        $stmt_precio->close();

        // Preparar variables para bind_param
        $tamano = htmlspecialchars($item['tamano']);
        $color = htmlspecialchars($item['color'] ?? '');

        $stmt_detalle->bind_param(
            "iiidsss",
            $id_orden,
            $item['id'],
            $item['cantidad'],
            $precio,
            $subtotal,
            $tamano,
            $color
        );

        if (!$stmt_detalle->execute()) {
            throw new Exception("Error al guardar detalle: " . $stmt_detalle->error);
        }
    }

    $stmt_detalle->close();
    $conexion->commit();

    echo json_encode([
        'success' => true,
        'order_id' => $id_orden,
        'message' => 'Pedido procesado correctamente'
    ]);

} catch (Exception $e) {
    // Rollback seguro
    try {
        $conexion->rollback();
    } catch (Exception $rbEx) {
        error_log("Error en rollback: " . $rbEx->getMessage());
    }

    error_log("Error en pedido: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Error al procesar el pedido. Por favor, inténtalo nuevamente.'
    ]);
}

$conexion->close();
?>