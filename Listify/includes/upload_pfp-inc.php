<?php
// includes/upload_pfp-inc.php

// ————————————————————————
// 1) Bootstrap session & DB
// ————————————————————————
require_once 'config_session-inc.php'; // starts session, etc.
require_once 'dbh-inc.php';            // sets up $pdo

// ————————————————————————
// 2) Guard: must be POST & logged in
// ————————————————————————
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['user_id'])) {
    http_response_code(403);
    exit('Forbidden');
}

// ————————————————————————
// 3) Check the upload array
// ————————————————————————
if (
    !isset($_FILES['newPfp']) ||
    $_FILES['newPfp']['error'] !== UPLOAD_ERR_OK
) {
    $_SESSION['pfp_error'] = 'No file uploaded or upload error.';
    header('Location: ../index.php');
    exit;
}

// ————————————————————————
// 4) Validate file size & type
// ————————————————————————
$file    = $_FILES['newPfp'];
$maxSize = 2 * 1024 * 1024; // 2 MB

if ($file['size'] > $maxSize) {
    $_SESSION['pfp_error'] = 'File too large (max 2 MB).';
    header('Location: ../index.php');
    exit;
}

// use finfo to detect real MIME type
$finfo    = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

$allowed = ['image/jpeg','image/png','image/gif'];
if (! in_array($mimeType, $allowed, true)) {
    $_SESSION['pfp_error'] = 'Invalid file type. Use JPG, PNG, or GIF.';
    header('Location: ../index.php');
    exit;
}

// ————————————————————————
// 5) Read binary data
// ————————————————————————
$imgData = file_get_contents($file['tmp_name']);
if ($imgData === false) {
    $_SESSION['pfp_error'] = 'Could not read uploaded file.';
    header('Location: ../index.php');
    exit;
}

// ————————————————————————
// 6) Update the BLOB in users.profile_image
// ————————————————————————
$sql = '
    UPDATE users
       SET profile_image = :img
     WHERE user_id      = :uid
';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':img', $imgData, PDO::PARAM_LOB);
$stmt->bindParam(':uid', $_SESSION['user_id'], PDO::PARAM_INT);

if ($stmt->execute()) {
    if ($stmt->rowCount() > 0) {
        $_SESSION['pfp_success'] = 'Profile picture updated.';
    } else {
        // no rows matched—maybe session ID mismatch
        $_SESSION['pfp_error'] = 'Update failed. Are you logged in?';
    }
} else {
    $_SESSION['pfp_error'] = 'Database error during update.';
}

// ————————————————————————
// 7) Redirect back
// ————————————————————————
header('Location: ../index.php');
exit;