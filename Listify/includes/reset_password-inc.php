<?php
// reset_password-inc.php
declare(strict_types=1);
require_once 'dbh-inc.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['error'=>'Method not allowed']);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$username    = trim((string)($input['username']    ?? ''));
$newPassword = trim((string)($input['newPassword'] ?? ''));

if ($username === '' || $newPassword === '') {
  http_response_code(400);
  echo json_encode(['error'=>'Missing data.']);
  exit;
}

// hash the new password
$hashed = password_hash($newPassword, PASSWORD_BCRYPT);

try {
  $stmt = $pdo->prepare("
    UPDATE users
    SET pwd = :pwd
    WHERE username = :u
  ");
  $stmt->execute([
    'pwd'=>$hashed,
    'u'=>$username
  ]);
  echo json_encode(['success'=>true]);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(['error'=>'Server error.']);
}