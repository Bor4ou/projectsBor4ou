<?php
    require_once 'db_conn-inc.php';
    require_once 'check_message-inc.php';

    header('Content-Type: application/json');
    
    try{
        $validated = validateContactForm($_POST);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    $query = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Грешка при подготовка на заявката.']);
        exit;
    }
    $stmt->bind_param(
        'sss',
        $validated['name'],
        $validated['email'],
        $validated['message']
    );

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Съобщението е изпратено успешно.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Грешка при изпращане на съобщението.']);
    }
    $stmt->close();
    $conn->close();