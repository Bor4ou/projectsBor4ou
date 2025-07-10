<?php
    session_start();
    require 'dbh-inc.php';
    global $pdo;

    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['error' => 'User not logged in']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);
    $task_id = $data['task_id'] ?? null;

    if (!$task_id) {
        echo json_encode(['error' => 'Task ID required']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE task_id = ?");
        $stmt->execute([$task_id]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
