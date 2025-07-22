<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/contact_style.css">
</head>
<body>
    
</body>
</html><!DOCTYPE html>
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
    <div class="container my-5" style="max-width: 600px;">
      <h1 class="text-center mb-4">Свържи се с нас</h1>
      <form id="contactForm" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
          <label for="name" class="form-label">Име <span>*</span></label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Имейл <span>*</span></label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
          <label for="message" class="form-label">Съобщение <span>*</span></label>
          <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary btn-lg">Изпрати</button>
        </div>
      </form>
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
  <script src="./js/contact.js"></script>
</body>
</html>