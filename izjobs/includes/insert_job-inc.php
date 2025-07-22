<?php
    require_once 'db_conn-inc.php';
    require_once 'check_fields-inc.php';

    header('Content-Type: application/json');

    try {
        $validated = validateJobForm($_POST, $_FILES);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit;
    }

    $query = "INSERT INTO jobs (position, address, job_sphere, salary, currency, description, firm_logo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Грешка при подготовка на заявката.']);
        exit;
    }

    $stmt->bind_param(
        'sssdsss',
        $validated['position'],
        $validated['address'],
        $validated['job_sphere'],
        $validated['salary'],
        $validated['currency'],
        $validated['description'],
        $validated['logoPath']
    );

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Обявата е успешно създадена.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Грешка при създаване на обявата.']);
    }
    $stmt->close();
    $conn->close();