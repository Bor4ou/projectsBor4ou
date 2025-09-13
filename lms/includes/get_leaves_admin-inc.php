<?php
    require_once 'db_conn-inc.php';
    session_start();
    header('Content-Type: application/json');

    $adminId = $_SESSION['admin_id'] ?? null;
    if (!$adminId) {
        echo json_encode(['success' => false, 'message' => 'Администратор не е влязъл']);
        exit;
    }

    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        echo json_encode(['success' => false, 'message' => 'Неоторизиран достъп.']);
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
            l.employee_id,
            e1.name AS substitute_name,
            e2.name AS employee_name
        FROM leaves l
        LEFT JOIN employees e1 ON l.substitute_id = e1.employee_id
        LEFT JOIN employees e2 ON l.employee_id = e2.employee_id
        ORDER BY l.submitted_date DESC
    ");
    
    $query->execute();
    $result = $query->get_result();

    $leaves = [];

    while ($row = $result->fetch_assoc()) {
        $leaves[] = $row;
    }

    echo json_encode([
        'success' => true,
        'leaves' => $leaves
    ]);
    exit;