<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index_style.css">
    <link rel="stylesheet" href="./css/add_job_style.css">
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
    <div class="container pt-3">
      <h1 class="mb-4 text-center">Създай нова обява</h1>
      <form id="addJobForm" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
          <label for="logo" class="form-label">Фирмено лого</label>
          <input class="form-control" type="file" id="logo" name="logo" accept="image/*">
        </div>

        <div class="mb-3">
          <label for="position" class="form-label">Позиция <span>*</span></label>
          <input type="text" class="form-control" id="position" name="position" required>
        </div>

        <div class="mb-3">
          <label for="city" class="form-label">Град <span>*</span></label>
          <select class="form-select" id="city" name="address" required>
            <option value="" disabled selected>Изберете град</option>
            <option value="София">гр. София</option>
            <option value="Пловдив">гр. Пловдив</option>
            <option value="Варна">гр. Варна</option>
            <option value="Бургас">гр. Бургас</option>
            <option value="Русе">гр. Русе</option>
            <option value="Стара Загора">гр. Стара Загора</option>
            <option value="Ямбол">гр. Ямбол</option>
            <option value="Сливен">гр. Сливен</option>
            <option value="Добрич">гр. Добрич</option>
            <option value="Монтана">гр. Монтана</option>
            <option value="Плевен">гр. Плевен</option>
            <option value="Велико Търново">гр. Велико Търново</option>
            <option value="Смолян">гр. Смолян</option>
            <option value="Благоевград">гр. Благоевград</option>
            <option value="Кърджали">гр. Кърджали</option>
            <option value="Кюстендил">гр. Кюстендил</option>
            <option value="Перник">гр. Перник</option>
            <option value="Хасково">гр. Хасково</option>
            <option value="Разград">гр. Разград</option>
            <option value="Търговище">гр. Търговище</option>
            <option value="Габрово">гр. Габрово</option>
            <option value="Ловеч">гр. Ловеч</option>
            <option value="Видин">гр. Видин</option>
            <option value="Силистра">гр. Силистра</option>
            <option value="Шумен">гр. Шумен</option>
            <option value="Пазарджик">гр. Пазарджик</option>
            <option value="Враца">гр. Враца</option>
          </select>
        </div>


        <div class="mb-3">
          <label for="category" class="form-label">Сфера на работа <span>*</span></label>
          <select class="form-select" id="category" name="job_sphere" required>
            <option value="" disabled selected>Изберете сфера</option>
            <option value="Информационни технологии">Информационни технологии</option>
            <option value="Здравеопазване">Здравеопазване</option>
            <option value="Образование">Образование</option>
            <option value="Финанси и счетоводство">Финанси и счетоводство</option>
            <option value="Продажби">Продажби</option>
            <option value="Маркетинг и реклама">Маркетинг и реклама</option>
            <option value="Строителство">Строителство</option>
            <option value="Транспорт и логистика">Транспорт и логистика</option>
            <option value="Хотелиерство и ресторантьорство">Хотелиерство и ресторантьорство</option>
            <option value="Администрация">Администрация</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Заплата <span>*</span></label>
          <div class="row g-2">
            <div class="col-8">
              <input type="text" class="form-control" id="salary" name="salary" placeholder="напр. 3000" required>
            </div>
            <div class="col-4">
              <select class="form-select" id="currency" name="currency" required>
                <option value="BGN" selected>BGN</option>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
                <option value="USD">USD</option>
              </select>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Описание за позицията <span>*</span></label>
          <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary btn-lg">Създай</button>
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
  <script src="./js/add_job.js"></script>
</body>
</html>