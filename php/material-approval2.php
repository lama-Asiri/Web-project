<?php
require_once 'config.php';
header('Content-Type: application/json');

$debug = true; // Change to false in production

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->prepare("SELECT * FROM materials WHERE status = 'pending'");
        $stmt->execute();
        $materials = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($debug) {
            error_log("[DEBUG][GET] Retrieved " . count($materials) . " pending materials");
        }

        echo json_encode($materials);
        exit;
    } catch (PDOException $e) {
        if ($debug) {
            error_log("[ERROR][GET] " . $e->getMessage());
        }
        echo json_encode(['success' => false, 'message' => 'Failed to fetch materials']);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($debug) {
            error_log("[DEBUG][POST] Raw POST data: " . json_encode($data));
        }

        if (!isset($data['material_id'], $data['action'])) {
            echo json_encode(['success' => false, 'message' => 'Missing data']);
            if ($debug) {
                error_log("[ERROR][POST] Missing material_id or action");
            }
            exit;
        }

        $materialId = (int)$data['material_id'];
        $action = strtolower($data['action']);

        if (!in_array($action, ['approve', 'reject'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            if ($debug) {
                error_log("[ERROR][POST] Invalid action: " . $action);
            }
            exit;
        }

        $newStatus = $action === 'approve' ? 'approved' : 'rejected';

        $stmt = $pdo->prepare("UPDATE materials SET status = :status WHERE material_id = :id");
        $success = $stmt->execute(['status' => $newStatus, 'id' => $materialId]);

        if ($debug) {
            error_log("[DEBUG][POST] Updated material_id: $materialId to status: $newStatus (Success: " . ($success ? "true" : "false") . ")");
        }

        echo json_encode(['success' => $success]);
        exit;
    } catch (Exception $e) {
        if ($debug) {
            error_log("[ERROR][POST] " . $e->getMessage());
        }
        echo json_encode(['success' => false, 'message' => 'Server error']);
        exit;
    }
}
?>
