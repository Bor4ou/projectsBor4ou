<?php
session_start();

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
  <meta charset="UTF-8">
  <title>Админ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="resources/favicon-32x32-1.png">
  <link href="css/admin.css" rel="stylesheet">
</head>
<body>

  <nav class="navbar bg-dark px-3">
    <a class="navbar-brand" href="#">
      <img src="resources/logo-1.png" class="logo">
    </a>
    <div class="d-flex align-items-center">
      <?php if (isset($_SESSION['admin_name'])): ?>
        <span class="text-white me-3">Админ: <?= htmlspecialchars($_SESSION['admin_name']) ?></span>
      <?php endif; ?>

      <a href="includes/logout-inc.php" class="btn btn-light">Изход</a>
    </div>
  </nav>

  <div class="container py-5">
    <h1 class="text-center mb-5">Заявления за Отпуск</h1>

    <div class="table-container">
      <table class="table table-bordered text-center">
        <thead class="table-primary">
          <tr>
            <th>#</th>
            <th>Име на служител</th>
            <th>Дата на подаване</th>
            <th>От</th>
            <th>До</th>
            <th>Връщане</th>
            <th>Вид отпуск</th>
            <th>Заместник</th>
            <th>Статус</th>
            <th>Действие</th>
          </tr>
        </thead>
        <tbody id="adminLeaveTableBody">
        </tbody>
      </table>
    </div>
  </div>

  <footer class="animated-waves-footer">
    <div class="waves">
      <svg class="wave wave1" viewBox="0 0 2400 200" preserveAspectRatio="none">
        <path d="M0,100 C600,0 1800,200 2400,100 L2400,200 L0,200 Z" fill="#ffffff" />
      </svg>
      <svg class="wave wave2" viewBox="0 0 2400 200" preserveAspectRatio="none">
        <path d="M0,100 C600,50 1800,150 2400,100 L2400,200 L0,200 Z" fill="#ffffff" />
      </svg>
      <svg class="wave wave3" viewBox="0 0 2400 200" preserveAspectRatio="none">
        <path d="M0,100 C600,80 1800,120 2400,100 L2400,200 L0,200 Z" fill="#ffffff" />
      </svg>
    </div>
    <div class="footer-content">
      <p>© 2025 Всички права запазени.</p>
    </div>
  </footer>

  <script src="js/admin.js?v=1234"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>