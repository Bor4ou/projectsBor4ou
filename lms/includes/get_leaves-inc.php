<?php
    require_once 'db_conn-inc.php';
    session_start();
    header('Content-Type: application/json');

    $employeeId = $_SESSION['employee_id'] ?? null;

    if (!$employeeId) {
        echo json_encode(['success' => false, 'message' => 'Служител не е влязъл']);
        exit;
    }

    $query = $conn->prepare("
        SELECT 
            l.leave_id,
            l.submitted_date,
            l.from_date,
            l.to_date,
            l.return_date,
            l.type,
            l.status,
            e.name AS substitute
        FROM leaves l
        JOIN employees e ON l.substitute_id = e.employee_id
        WHERE l.employee_id = ?
        ORDER BY l.submitted_date DESC
    ");
    $query->bind_param("i", $employeeId);
    $query->execute();
    $result = $query->get_result();

    $leaves = [];
    while ($row = $result->fetch_assoc()) {
        $leaves[] = $row;
    }

    echo json_encode(['success' => true, 'leaves' => $leaves]);

    $conn->close();
    exit;