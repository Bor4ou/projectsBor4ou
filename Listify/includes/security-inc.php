<?php
declare(strict_types=1);

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit();
}

// Start session & enforce secure cookie params
require_once 'config_session-inc.php';

// DB connection
require_once 'dbh-inc.php';

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// Grab & trim inputs
$question = trim((string)($_POST['securityQuestion'] ?? ''));
$answer   = trim((string)($_POST['securityAnswer']  ?? ''));

// Validate
$errors = [];
if ($question === '' || $answer === '') {
    $errors[] = 'Please fill in both the security question and answer.';
}
if (mb_strlen($question) > 255) {
    $errors[] = 'Security question must be under 255 characters.';
}
if (mb_strlen($answer) > 255) {
    $errors[] = 'Security answer must be under 255 characters.';
}

if (!empty($errors)) {
    $_SESSION['errors_security'] = $errors;
    header('Location: ../index.php');
    exit();
}

// Hash the answer
$hashedAnswer = password_hash($answer, PASSWORD_DEFAULT);

try {
    // Update the user's security question & answer
    $sql = "
        UPDATE users
        SET security_question = :question,
            security_answer   = :answer
        WHERE user_id = :uid
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':question', $question, PDO::PARAM_STR);
    $stmt->bindParam(':answer',   $hashedAnswer, PDO::PARAM_STR);
    $stmt->bindParam(':uid',      $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();

    // Success message
    $_SESSION['success_security'] = 'Your security question has been set.';
    header('Location: ../index.php?security=success');
    exit();
    
} catch (PDOException $e) {
    // In production you might log this instead
    die('Database error: ' . htmlspecialchars($e->getMessage()));
}