<?php
// get_question-inc.php
require_once 'dbh-inc.php';      // adjust the path if needed
header('Content-Type: application/json');

// parse JSON body
$input = json_decode(file_get_contents('php://input'), true);
$username = isset($input['username']) ? trim($input['username']) : '';

// validate
if ($username === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Please provide a username.']);
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT security_question FROM users WHERE username = :u LIMIT 1');
    $stmt->execute(['u' => $username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        http_response_code(404);
        echo json_encode(['error' => 'That username does not exist.']);
    } else {
        echo json_encode(['question' => $row['security_question']]);
    }
} catch (PDOException $e) {
    // log $e->getMessage() securely
    http_response_code(500);
    echo json_encode(['error' => 'Server error. Please try again later.']);
}