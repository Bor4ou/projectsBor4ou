<?php
 function validateJobForm($data, $files) {
    
    $position = trim($data['position'] ?? '');
    $address = trim($data['address'] ?? '');
    $job_sphere = trim($data['job_sphere'] ?? '');
    $salary = $data['salary'] ?? '';
    $currency = $data['currency'] ?? 'BGN';
    $description = trim($data['description'] ?? '');
    $logo = $files['logo'] ?? null;

    if (empty($position) || empty($address) || empty($job_sphere) || empty($salary) || empty($description)) {
        throw new Exception('Моля, попълнете всички задължителни полета.');
    }

    if (!is_numeric($salary) || $salary < 0) {
        throw new Exception('Заплатата трябва да бъде положително число.');
    }

    if (!in_array($currency, ['BGN', 'EUR', 'USD', 'GBP'])) {
        throw new Exception('Неподдържаната валута.');
    }

    if (strlen($description) < 100) {
        throw new Exception('Описанието трябва да бъде поне 100 символа.');
    }

    if (strlen($position) < 3) {
        throw new Exception('Позицията трябва да бъде поне 3 символа.');
    }

    $logoPath = null;
    if ($logo && $logo['error'] === 0) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($logo['tmp_name']);

        if (!in_array($mimeType, $allowedTypes)) {
            throw new Exception('Неподдържан формат на лого.');
        }

        $ext = trim(pathinfo($logo['name'], PATHINFO_EXTENSION));
        $uniqueName = uniqid('logo_', true) . '.' . $ext;
        $logoPath = '../uploads/' . $uniqueName;

        if (!move_uploaded_file($logo['tmp_name'], $logoPath)) {
            throw new Exception('Грешка при качване на логото.');
        }
    }

    return [
        'position' => $position,
        'address' => $address,
        'job_sphere' => $job_sphere,
        'salary' => (double) $salary,
        'currency' => $currency,
        'description' => $description,
        'logoPath' => $logoPath
    ];
}
