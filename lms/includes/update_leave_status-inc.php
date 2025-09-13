<?php
    require_once 'db_conn-inc.php';
    require_once 'send_email-inc.php';
    session_start();
    header('Content-Type: application/json');

    $adminEmail = 'borislavdnk6@gmail.com';
    $adminName = 'Дария Женова';
    $adminPassword = 'pqab ieum glfy rqsa';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Невалидна заявка.']);
        exit;
    }

    if (!isset($_SESSION['admin_id'])) {
        echo json_encode(['success' => false, 'message' => 'Нямате достъп. Само администратори могат да извършват тази операция.']);
        exit;
    }

    $input = json_decode(file_get_contents("php://input"), true);

    $leaveId = $input['leave_id'] ?? null;
    $status = $input['status'] ?? '';

    $validStatuses = ['Одобрено', 'Отказано'];

    if (!$leaveId || !in_array($status, $validStatuses)) {
        echo json_encode(['success' => false, 'message' => 'Невалидни данни.']);
        exit;
    }

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("SELECT * FROM leaves WHERE leave_id = ?");
        $stmt->bind_param("i", $leaveId);
        $stmt->execute();
        $result = $stmt->get_result();
        $leave = $result->fetch_assoc();
        $stmt->close();

        if (!$leave) {
            throw new Exception('Заявката не беше намерена.');
        }

        if ($status === 'Одобрено') {
            $employeeId = $leave['employee_id'];
            $from = new DateTime($leave['from_date']);
            $to = new DateTime($leave['to_date']);
            $interval = $from->diff($to);
            $days = $interval->days + 1; 

            $stmt = $conn->prepare("UPDATE employees SET remaining_days = remaining_days - ? WHERE employee_id = ?");
            $stmt->bind_param("ii", $days, $employeeId);
            $stmt->execute();
            $stmt->close();
        }

        $stmt = $conn->prepare("UPDATE leaves SET status = ? WHERE leave_id = ?");
        $stmt->bind_param("si", $status, $leaveId);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        echo json_encode(['success' => true]);

        $stmt = $conn->prepare("
            SELECT e.email, e.name, l.type, l.from_date, l.to_date
            FROM leaves l
            JOIN employees e ON l.employee_id = e.employee_id
            WHERE l.leave_id = ?
        ");
        $stmt->bind_param("i", $leaveId);
        $stmt->execute();
        $result = $stmt->get_result();
        $emp = $result->fetch_assoc();
        $stmt->close();

        $subject = "Решение за заявка за отпуск";
        $body = "
            <p>Здравейте, <strong>{$emp['name']}</strong>,</p>
            <p>Вашата заявка за отпуск е <strong>{$status}</strong>.</p>
            <p>От: {$emp['from_date']}<br>До: {$emp['to_date']}<br>Тип: {$emp['type']}</p>
        ";

        sendEmail($emp['email'], $subject, $body, $adminEmail, $adminName, $adminPassword);


    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Грешка: ' . $e->getMessage()]);
    }

    $conn->close();
    exit;