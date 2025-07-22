<?php
    require_once 'db_conn-inc.php';

    ini_set('log_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Невалидна обява.']);
        exit;
    }

    $job_id = (int)$_GET['id']; 

    $query = "SELECT * FROM jobs WHERE job_id = ? LIMIT 1";
    $stmt = $conn->prepare($query); 
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Грешка при подготовка на заявката.']);
        exit;
    }
    $stmt->bind_param('i', $job_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $job = $result->fetch_assoc();
            echo json_encode(['status' => 'success', 'job' => $job]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Обявата не е намерена.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Грешка при изпълнение на заявката.']);
    }
    $stmt->close();
    $conn->close();