<?php
    function validateContactForm($data){
        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        $message = trim($data['message'] ?? '');

        if (empty($name) || empty($email) || empty($message)) {
            throw new Exception('Моля, попълнете всички задължителни полета.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Невалиден имейл адрес.');
        }

        if (strlen($message) < 10) {
            throw new Exception('Съобщението трябва да бъде поне 10 символа.');
        }

        return [
            'name' => $name,
            'email' => $email,
            'message' => $message
        ];
    }