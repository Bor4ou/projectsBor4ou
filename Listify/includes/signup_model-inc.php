<?php

declare(strict_types=1);

function get_username(object $pdo, string $username) {

    $query = "SELECT username FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query); //prevents sql injection (nqkak si)

    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_email(object $pdo, string $email) {

    $query = "SELECT username FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query); //prevents sql injection (nqkak si)

    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}


function set_user(
    object $pdo,
    string $pwd,
    string $username,
    string $email,
    ?string $security_question = null,
    ?string $security_answer = null
): void {

    $options = [
        "cost" => 12
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    if ($security_question !== null && $security_answer !== null) {
        $hashedAnswer = password_hash($security_answer, PASSWORD_BCRYPT, $options);

        $query = "INSERT INTO users (username, pwd, email, security_question, security_answer)
                  VALUES (:username, :pwd, :email, :question, :answer);";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pwd", $hashedPwd);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":question", $security_question);
        $stmt->bindParam(":answer", $hashedAnswer);
    } else {
        $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :pwd, :email);";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pwd", $hashedPwd);
        $stmt->bindParam(":email", $email);
    }

    $stmt->execute();
}
