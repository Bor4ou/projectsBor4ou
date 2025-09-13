<?php
session_start();
require_once 'includes/db_conn-inc.php';

$employees = [];
$currentEmployeeId = $_SESSION['employee_id'];

$query = "SELECT employee_id, name FROM employees WHERE employee_id != ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $currentEmployeeId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

$stmt->close();

$availableDays = 0;
$remainingDays = 0;

if (isset($_SESSION['employee_id'])) {
    $employeeId = $_SESSION['employee_id'];
    $stmt = $conn->prepare("SELECT available_days, remaining_days FROM employees WHERE employee_id = ?");
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
    $stmt->bind_result($availableDays, $remainingDays);
    $stmt->fetch();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
  <meta charset="UTF-8" />
  <title>Служител</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="resources/favicon-32x32-1.png">
  <link href="css/employee.css" rel="stylesheet" />
</head>
<body>

  <nav class="navbar bg-dark px-3">
    <a class="navbar-brand" href="#">
      <img src="resources/logo-1.png" class="logo">
    </a>
    <div class="d-flex align-items-center">
      <?php if (isset($_SESSION['employee_name'])): ?>
        <span class="text-white me-3">Служител: <?= htmlspecialchars($_SESSION['employee_name']) ?></span>
      <?php endif; ?>

      <a href="includes/logout-inc.php" class="btn btn-light">Изход</a>
    </div>
  </nav>

  <div class="container py-5">
    <div class="bg-light border rounded p-4 mb-4">
      <h3 class="text-center w-100">Молба за отпуск</h3>
      <hr />

      <div class="row mb-4 text-center">
        <div class="col-md-6 mb-3 mb-md-0">
          <div class="info-box p-3 border rounded bg-white">
            <strong class="d-block mb-2">Полагаеми дни отпуск:</strong>
            <span class="count-number" data-target-number="<?= $availableDays ?>">0</span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="info-box p-3 border rounded bg-white">
            <strong class="d-block mb-2">Оставащи дни отпуск:</strong>
            <span class="count-number" data-target-number="<?= $remainingDays ?>">0</span>
          </div>
        </div>
      </div>

      <form id="leaveForm">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label" for="fromDate">От</label>
            <input type="date" class="form-control" id="fromDate" name="from_date" required/>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="toDate">До</label>
            <input type="date" class="form-control" id="toDate" name="to_date" requried/>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="leaveType">Вид отпуск</label>
            <select class="form-select" id="leaveType" name="type" required>
              <option>Платен</option>
              <option>Неплатен</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="returnDate">Дата на връщане</label>
            <input type="date" class="form-control" id="returnDate" name="return_date" required/>
          </div>
          <div class="col-md-12">
            <label class="form-label" for="replacementEmployee">Заместващ служител</label>
            <select class="form-select" name="substitute_id" id="replacementEmployee" required>
              <option value="">-- Изберете служител --</option>
              <?php foreach ($employees as $emp): ?>
                <option value="<?= htmlspecialchars($emp['employee_id']) ?>">
                  <?= htmlspecialchars($emp['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-success">Подай заявление</button>
          </div>
        </div>
      </form>

      <h5 class="mt-5">Подадени заявления</h5>
      <div class="table-responsive"> <table class="table table-bordered bg-white" id="applicationsTable">
          <thead class="table-light">
            <tr>
              <th>Дата</th>
              <th>От - До</th>
              <th>Вид</th>
              <th>Статус</th>
              <th>Действия</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
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

  <script src="js/employee.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>