<?php
    require_once 'db_conn-inc.php';
    session_start();


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $role = isset($_POST['role']) ? trim($_POST['role']) : '';
        if ($role == 'employee') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Моля, попълнете всички полета.";
                header("Location: ../login.php?error=emptyfields");
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Невалиден имейл адрес.";
                header("Location: ../login.php?error=invalidemail");
                exit();
            }

            $stmt = $conn->prepare("SELECT * FROM employees WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                if(password_verify($password, $row['password'])) {
                    $_SESSION['employee_id'] = $row['employee_id'];
                    $_SESSION['employee_name'] = $row['name'];
                    $_SESSION['user_role'] = 'employee';
                    $_SESSION['success'] = "Успешно влизане!";
                    header("Location: ../employee.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Грешен имейл или парола.";
                    header("Location: ../login.php?error=wrongcredentials");
                    exit();
                }
            } else {
                $_SESSION['error'] = "Не съществува потребител с този имейл.";
                header("Location: ../login.php?error=wrongcredentials");
                exit();
            }
            
            $stmt->close();
            $conn->close();
        }
        elseif ($role == 'admin') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Моля, попълнете всички полета.";
                header("Location: ../login.php?error=emptyfields");
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Невалиден имейл адрес.";
                header("Location: ../login.php?error=invalidemail");
                exit();
            }

            $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                if(password_verify($password, $row['password'])) {
                    $_SESSION['admin_id'] = $row['admin_id'];
                    $_SESSION['admin_name'] = $row['name'];
                    $_SESSION['user_role'] = 'admin';
                    $_SESSION['success'] = "Успешно влизане!";
                    header("Location: ../admin.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Грешен имейл или парола.";
                    header("Location: ../login.php?error=wrongcredentials");
                    exit();
                }
            } else {
                $_SESSION['error'] = "Не съществува потребител с този имейл.";
                header("Location: ../login.php?error=wrongcredentials");
                exit();
            }
            
            $stmt->close();
            $conn->close();
        } else {
            $_SESSION['error'] = "Невалидна роля.";
            header("Location: ../login.php?error=invalidrole");
            exit();
        }
    } else {
        $_SESSION['error'] = "Невалидна заявка.";
        header("Location: ../login.php?error=invalidrequest");
        exit();
    }