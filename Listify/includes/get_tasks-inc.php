<?php
    session_start();
    require 'dbh-inc.php';
    global $pdo;

    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['error' => 'User not logged in']);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("
            SELECT t.task_id, t.task_name, t.created_at ,c.category_id, c.category_name
            FROM tasks t
            JOIN categories c ON t.category_id = c.category_id
            WHERE c.user_id = ?
            ORDER BY c.category_name, t.created_at DESC
        ");
        $stmt->execute([$user_id]);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Group tasks by category
        $grouped = [];
        foreach ($tasks as $task) {
            $cat = $task['category_name'];
            $cat_id = $task['category_id'];
            if (!isset($grouped[$cat_id])) {
                $grouped[$cat_id] = [
                    'category_id' => $cat_id,
                    'category_name' => $cat,
                    'tasks' => [],
                ];
            }
            $grouped[$cat_id]['tasks'][] = [
                'task_id' => $task['task_id'],
                'task_name' => $task['task_name'],
                'created_at' => $task['created_at'],
            ];
        }

        echo json_encode(array_values($grouped));
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }