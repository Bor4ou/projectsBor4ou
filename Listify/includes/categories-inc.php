<?php
    session_start();
    require 'dbh-inc.php';
    global $pdo;

    header('Content-Type: application/json');

    // Must match JSON input from JS
    $data = json_decode(file_get_contents("php://input"), true);
    $category = $data['categoryInput'] ?? '';

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['error' => 'User not logged in']);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($category)) {
            echo json_encode(['error' => 'Category name is required']);
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO categories (category_name, user_id) VALUES (?, ?)");
            $stmt->execute([$category, $user_id]);
            $lastId = $pdo->lastInsertId();
            echo json_encode(['success' => true, 'category_id' => $lastId]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
