<?php
// includes/show_pfp.php
require_once __DIR__ . '/config_session-inc.php';  // session_start(), etc.
require_once __DIR__ . '/dbh-inc.php';             // gives you $pdo

// 1) Must be logged in
if (empty($_SESSION['user_id'])) {
    http_response_code(403);
    exit('Forbidden');
}

// 2) Fetch the blob
$stmt = $pdo->prepare('SELECT profile_image FROM users WHERE user_id = :uid LIMIT 1');
$stmt->execute([':uid' => $_SESSION['user_id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// 3) If there’s a blob, detect its MIME and output it
if ($row && $row['profile_image'] !== null) {
    // detect MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_buffer($finfo, $row['profile_image']);
    finfo_close($finfo);

    header('Content-Type: ' . $mime);
    // Tell browsers they can cache it for e.g. 1 hour:
    header('Cache-Control: public, max-age=3600');
    echo $row['profile_image'];
    exit;
}

// 4) Fallback to the default PNG
header('Content-Type: image/png');
readfile(__DIR__ . '/../pics/pfp.png');
exit;