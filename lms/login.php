<?php
session_start();

if (isset($_SESSION['error'])) {
    echo "<script>alert('" . addslashes($_SESSION['error']) . "');</script>";
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo "<script>alert('" . addslashes($_SESSION['success']) . "');</script>";
    unset($_SESSION['success']);
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
  <meta charset="UTF-8" />
  <title>Вход</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="resources/favicon-32x32-1.png">
  <link href="css/login.css" rel="stylesheet" >
  </head>
<body>
    <div class="wrapper">
    <div class="back">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
    <div class="card p-4 shadow w-100" style="max-width: 27em;">
      <h4 class="text-center mb-3">Вход в системата</h4>
      <form id="loginForm" action="includes/employee_login-inc.php" method="POST">
        <input type="hidden" name="role" id="roleInput" value="employee" />
        
        <div class="d-flex justify-content-between mb-3">
          <button type="button" class="btn btn-light w-50 role-btn" id="employeeBtn">Служител</button>
          <button type="button" class="btn btn-light w-50 role-btn" id="adminBtn">Администратор</button>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Имейл</label>
          <input type="email" name="email" class="form-control" id="email" required />
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Парола</label>
          <input type="password" name="password" class="form-control" id="password" required />
        </div>

        <button type="submit" class="btn btn-primary w-100">Вход</button>
      </form>
    </div>
  </div>

  <script src="js/login.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
