<?php
    session_start();
    require 'dbh-inc.php';
    global $pdo;
    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['error' => 'User not logged in']);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Decode JSON input
        $data = json_decode(file_get_contents("php://input"), true);

        $task = $data['taskInput'] ?? '';
        $category_id = $data['categoryId'] ?? null;

        if (empty($task) || empty($category_id)) {
            echo json_encode(['error' => 'Missing task or category']);
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO tasks (task_name, category_id) VALUES (?, ?)");
            $stmt->execute([$task, $category_id]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }