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
    $category_id = $data['category_id'] ?? null;

    if (!$category_id) {
        echo json_encode(['error' => 'Category ID required']);
        exit;
    }

    try {
        // Delete tasks first due to FK constraint
        $pdo->prepare("DELETE FROM tasks WHERE category_id = ?")->execute([$category_id]);
        $pdo->prepare("DELETE FROM categories WHERE category_id = ?")->execute([$category_id]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }