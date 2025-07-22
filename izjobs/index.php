<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index_style.css">
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><img src="./resources/images/izjobs_logo.png" alt="Logo" width="200px"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="jobs.php">Обяви</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add_job.php">Създай обява</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Контакти</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="d-flex align-items-center justify-content-center bg-light py-5">
    <div class="text-center">
      <h1 class="display-4">IZ Jobs. Платформата свързваща кандидати и работодатели.</h1>
      <p class="lead mb-4">Помагаме ви да откриете вашата мечтана позиция, или да създадете привлекателни обяви за вашата фирма, в рамките на няколко клика!</p>
      <a href="jobs.php" class="btn btn-primary btn-lg">Разгледай обявите 🡺</a>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-dark text-white py-4 mt-auto">
    <div class="container text-center text-lg-start">
      <div class="row align-items-center justify-content-between text-center text-lg-start">
        
        <div class="col-12 col-lg-4 mb-3 mb-lg-0">
          <a href="index.php"><img src="./resources/images/izjobs_logo_white.png" alt="IZ Jobs Logo" style="width: 200px; height: auto;"></a>
        </div>

        <div class="col-12 col-lg-8">
          <div class="d-flex flex-column flex-lg-row justify-content-lg-end align-items-center gap-2 gap-lg-4">
            <a href="jobs.php" class="text-white text-decoration-none">Обяви</a>
            <a href="add_job.php" class="text-white text-decoration-none">Създай обява</a>
            <a href="contact.php" class="text-white text-decoration-none">Контакти</a>
          </div>
          <p class="mt-3 mb-0 small text-center text-lg-end">© 2025 IZ Jobs. All rights reserved.</p>
        </div>

      </div>
    </div>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>