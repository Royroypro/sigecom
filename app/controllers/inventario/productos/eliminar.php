<?php
include '../../../config.php'; // Incluye el archivo de conexión
include '../../../../layout/sesion.php'; // Incluye el archivo de conexión

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $id_producto = $data['id_producto']; // Verifica que el ID sea válido

        if (empty($id_producto)) {
            throw new Exception('El ID del producto es obligatorio.');
        }

        $stmt = $pdo->prepare("DELETE FROM productos WHERE id_producto = :id_producto");
        $stmt->execute(['id_producto' => $id_producto]);

        echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente.']);
    } else {
        throw new Exception('Método de solicitud no válido.');
    }
} catch (Exception $e) {
    error_log("Error en eliminar.php: " . $e->getMessage(), 3, __DIR__ . '/error_log.txt');
    echo json_encode(['success' => false, 'error' => 'Error interno del servidor. ' . $e->getMessage()]);
}
