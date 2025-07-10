<?php

declare(strict_types=1);

function get_user(object $pdo, string $username) {
    
    $query = "SELECT * FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query); //prevents sql injection (nqkak si)

    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}