<?php
    session_start();
    require 'dbh-inc.php';
    global $pdo;
    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode([]);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("SELECT category_id, category_name FROM categories WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($categories);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
