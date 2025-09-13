<?php
    require_once 'db_conn-inc.php';
    require_once 'send_email-inc.php';
    session_start();
    header('Content-Type: application/json');

    $adminEmail = 'borislavdnk6@gmail.com';
    $adminName = 'Дария Женова';
    $adminPassword = 'pqab ieum glfy rqsa';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $employeeId = $_SESSION['employee_id'] ?? null;
        $employeeName = $_SESSION['employee_name'] ?? '';

        $from = $_POST['from_date'] ?? '';
        $to = $_POST['to_date'] ?? '';
        $return = $_POST['return_date'] ?? '';
        $type = $_POST['type'] ?? '';
        $substituteId = $_POST['substitute_id'] ?? '';

        if (!$employeeId || !$from || !$to || !$return || !$type || !$substituteId) {
            echo json_encode(['success' => false, 'message' => 'Моля, попълнете всички полета.']);
            exit;
        }

        $empStmt = $conn->prepare("SELECT remaining_days FROM employees WHERE employee_id = ?");
        $empStmt->bind_param("i", $employeeId);
        $empStmt->execute();
        $empResult = $empStmt->get_result()->fetch_assoc();
        $remainingDays = (int)($empResult['remaining_days'] ?? 0);

        $start = new DateTime($from);
        $end = new DateTime($to);
        $requestedDays = $start->diff($end)->days + 1;

        if ($requestedDays > $remainingDays) {
            echo json_encode([
                'success' => false,
                'message' => "Исканите $requestedDays дни надвишават оставащите $remainingDays дни отпуск."
            ]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO leaves (employee_id, submitted_date, from_date, to_date, return_date, type, substitute_id, status)
                                VALUES (?, CURDATE(), ?, ?, ?, ?, ?, 'Очаква обработка')");
        $stmt->bind_param("issssi", $employeeId, $from, $to, $return, $type, $substituteId);

        if ($stmt->execute()) {
            $adminEmails = [];
            $res = $conn->query("SELECT email FROM admins");
            while ($row = $res->fetch_assoc()) {
                $adminEmails[] = $row['email'];
            }

            $subject = "Нова заявка за отпуск";
            $body = "
                <p>Имате нова заявка за отпуск от <strong>{$employeeName}</strong>.</p>
                <p>От: {$from}<br>До: {$to}<br>Тип: {$type}</p>
            ";

            foreach ($adminEmails as $email) {
                    sendEmail($email, $subject, $body, $adminEmail, $adminName, $adminPassword);
            }

            echo json_encode(['success' => true, 'message' => 'Заявката е изпратена успешно.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Грешка при запазване на заявката.']);
        }

        $stmt->close();
        $empStmt->close();
        $conn->close();
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Невалидна заявка.']);
        exit;
    }