<?php

include '../../../config.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $id_det_tecnico_producto = $data['Id_det_tecnico_producto'] ?? null;

        if (empty($id_det_tecnico_producto)) {
            throw new Exception('El ID del detalle de t&eacute;cnico producto es obligatorio.');
        }

        // Verificar si hay una relacion con el id de cliente tecnico
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM detalle_cliente_tecnico WHERE ID_detalle_cliente_producto = ?");
        $stmt->execute([$id_det_tecnico_producto]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            throw new Exception('No se puede eliminar la salida porque esta relacionado con un tecnico y un cliente. Si desa eliminar vaya a "Designar tecnico" para modificar primero y luego reintenta eliminar');
        }

        $stmt = $pdo->prepare("DELETE FROM detalle_tecnico_producto WHERE Id_det_tecnico_producto = ?");
        $stmt->execute([$id_det_tecnico_producto]);

        echo json_encode(['success' => true, 'message' => 'Salida eliminada correctamente.']);
    } else {
        throw new Exception('M&eacute;todo de solicitud no v&aacute;lido.');
    }
} catch (Exception $e) {
    error_log("Error en eliminar_salida.php: " . $e->getMessage(), 3, __DIR__ . '/error_log.txt');
    echo json_encode(['success' => false, 'error' => '' . $e->getMessage()]);
}





