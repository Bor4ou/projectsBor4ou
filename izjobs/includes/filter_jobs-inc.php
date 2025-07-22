<?php
    require_once 'db_conn-inc.php';

    header('Content-Type: application/json');

    $cities = isset($_GET['cities']) ? explode(',', $_GET['cities']) : [];
    $spheres = isset($_GET['spheres']) ? explode(',', $_GET['spheres']) : [];
    $minSalary = isset($_GET['min']) ? (int)$_GET['min'] : 0;
    $maxSalary = isset($_GET['max']) ? (int)$_GET['max'] : PHP_INT_MAX;

    $sql = "SELECT * FROM jobs WHERE salary >= ? AND salary <= ?";
    $params = [$minSalary, $maxSalary];
    $types = "ii";

    if (!empty($cities)) {
        $placeholders = implode(',', array_fill(0, count($cities), '?'));
        $sql .= " AND address IN ($placeholders)";
        $params = array_merge($params, $cities);
        $types .= str_repeat('s', count($cities));
    }

    if (!empty($spheres)) {
        $placeholders = implode(',', array_fill(0, count($spheres), '?'));
        $sql .= " AND job_sphere IN ($placeholders)";
        $params = array_merge($params, $spheres);
        $types .= str_repeat('s', count($spheres));
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $jobs = [];

    while ($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }

    echo json_encode(['jobs' => $jobs]);
    $stmt->close();
    $conn->close();