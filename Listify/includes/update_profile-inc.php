<?php
require_once "dbh-inc.php";
require_once "config_session-inc.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $userId = $_SESSION["user_id"];

    // Sanitize input
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $pwd = trim($_POST["pwd"]);
    $security_question = trim($_POST["security_question"]);
    $security_answer = trim($_POST["security_answer"]);

    // ✅ Validate: if one of the security fields is filled, the other must be too
    $changingQuestion = !empty($security_question);
    $changingAnswer = !empty($security_answer);

    if (($changingQuestion && !$changingAnswer) || (!$changingQuestion && $changingAnswer)) {
        // One field is filled, but the other isn't — show error
        header("Location: ../profile.php?update=security_incomplete");
        exit();
    }

    // Build the dynamic SQL
    $updates = [];
    $params = [":id" => $userId];

    if (!empty($username)) {
        $updates[] = "username = :username";
        $params[":username"] = $username;
    }

    if (!empty($email)) {
        $updates[] = "email = :email";
        $params[":email"] = $email;
    }

    if (!empty($pwd)) {
        $updates[] = "pwd = :pwd";
        $params[":pwd"] = password_hash($pwd, PASSWORD_DEFAULT);
    }

    if ($changingQuestion && $changingAnswer) {
        $updates[] = "security_question = :question";
        $params[":question"] = $security_question;

        $updates[] = "security_answer = :answer";
        $params[":answer"] = password_hash($security_answer, PASSWORD_DEFAULT);
    }

    // If no fields were filled, do nothing
    if (empty($updates)) {
        header("Location: ../profile.php?update=none");
        exit();
    }

    // Join and execute
    $sql = "UPDATE users SET " . implode(", ", $updates) . " WHERE user_id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        header("Location: ../profile.php?update=success");
        exit();
    } catch (PDOException $e) {
        die("Error updating profile: " . $e->getMessage());
    }
} else {
    header("Location: ../profile.php");
    exit();
}