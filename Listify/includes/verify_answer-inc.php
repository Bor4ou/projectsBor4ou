<?php
// verify_answer-inc.php
declare(strict_types=1);
require_once 'dbh-inc.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['error'=>'Method not allowed']);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$username = trim((string)($input['username'] ?? ''));
$answer   = trim((string)($input['answer']   ?? ''));

if ($username === '' || $answer === '') {
  http_response_code(400);
  echo json_encode(['error' => 'Missing username or answer.']);
  exit;
}

try {
  $stmt = $pdo->prepare('
    SELECT security_answer AS hashed
    FROM users
    WHERE username = :u
    LIMIT 1
  ');
  $stmt->execute(['u'=>$username]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$row || !password_verify($answer, $row['hashed'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Secret answer is incorrect.']);
    exit;
  }

  // Instead of returning pwd, signal that they passed the Q&A step:
  echo json_encode(['success' => true]);
  
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(['error'=>'Server error.']);
}