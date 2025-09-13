<?php
    require_once 'db_conn-inc.php';
    session_start();
    header('Content-Type: application/json');

    $employeeId = $_SESSION['employee_id'] ?? null;
    $leaveId = $_POST['leave_id'] ?? null;

    if (!$employeeId || !$leaveId) {
        echo json_encode(['success' => false, 'message' => 'Невалидна заявка.']);
        exit;
    }

    // Ensure the leave belongs to the employee and is still pending
    $stmt = $conn->prepare("SELECT status FROM leaves WHERE leave_id = ? AND employee_id = ?");
    $stmt->bind_param("ii", $leaveId, $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $leave = $result->fetch_assoc();

    if (!$leave) {
        echo json_encode(['success' => false, 'message' => 'Заявката не е намерена.']);
        exit;
    }

    if ($leave['status'] !== 'Очаква обработка') {
        echo json_encode(['success' => false, 'message' => 'Само чакащи заявки могат да бъдат анулирани.']);
        exit;
    }

    // Delete it
    $delStmt = $conn->prepare("DELETE FROM leaves WHERE leave_id = ?");
    $delStmt->bind_param("i", $leaveId);
    $delStmt->execute();

    echo json_encode(['success' => true]);
    exit;
