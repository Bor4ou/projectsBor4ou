<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index_style.css">
    <link rel="stylesheet" href="./css/jobs_style.css">
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
  <main class="d-flex flex-column align-items-center justify-content-center bg-light py-5">
    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#filtersModal">
      Филтри
    </button>

    <!-- Filter Modal -->
    <div class="modal fade" id="filtersModal" tabindex="-1" aria-labelledby="filtersModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="filtersModalLabel">Филтри</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <!-- Cities -->
            <div class="mb-3">
              <label class="form-label">Град</label>
              <div id="cityFilters" class="scrollable-filter border rounded p-2" style="max-height: 300px; overflow-y: auto;">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Благоевград" id="city-blagoevgrad">
                  <label class="form-check-label" for="city-blagoevgrad">Благоевград</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Бургас" id="city-burgas">
                  <label class="form-check-label" for="city-burgas">Бургас</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Варна" id="city-varna">
                  <label class="form-check-label" for="city-varna">Варна</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Велико Търново" id="city-veliko-tarnovo">
                  <label class="form-check-label" for="city-veliko-tarnovo">Велико Търново</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Видин" id="city-vidin">
                  <label class="form-check-label" for="city-vidin">Видин</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Враца" id="city-vratsa">
                  <label class="form-check-label" for="city-vratsa">Враца</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Габрово" id="city-gabrovo">
                  <label class="form-check-label" for="city-gabrovo">Габрово</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Добрич" id="city-dobrich">
                  <label class="form-check-label" for="city-dobrich">Добрич</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Кърджали" id="city-kardzhali">
                  <label class="form-check-label" for="city-kardzhali">Кърджали</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Кюстендил" id="city-kyustendil">
                  <label class="form-check-label" for="city-kyustendil">Кюстендил</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Ловеч" id="city-lovech">
                  <label class="form-check-label" for="city-lovech">Ловеч</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Монтана" id="city-montana">
                  <label class="form-check-label" for="city-montana">Монтана</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Пазарджик" id="city-pazardzhik">
                  <label class="form-check-label" for="city-pazardzhik">Пазарджик</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Перник" id="city-pernik">
                  <label class="form-check-label" for="city-pernik">Перник</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Плевен" id="city-pleven">
                  <label class="form-check-label" for="city-pleven">Плевен</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Пловдив" id="city-plovdiv">
                  <label class="form-check-label" for="city-plovdiv">Пловдив</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Разград" id="city-razgrad">
                  <label class="form-check-label" for="city-razgrad">Разград</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Русе" id="city-ruse">
                  <label class="form-check-label" for="city-ruse">Русе</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Силистра" id="city-silistra">
                  <label class="form-check-label" for="city-silistra">Силистра</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Сливен" id="city-sliven">
                  <label class="form-check-label" for="city-sliven">Сливен</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Смолян" id="city-smolyan">
                  <label class="form-check-label" for="city-smolyan">Смолян</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="София" id="city-sofia">
                  <label class="form-check-label" for="city-sofia">София</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="София област" id="city-sofia-region">
                  <label class="form-check-label" for="city-sofia-region">София област</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Стара Загора" id="city-stara-zagora">
                  <label class="form-check-label" for="city-stara-zagora">Стара Загора</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Търговище" id="city-targovishte">
                  <label class="form-check-label" for="city-targovishte">Търговище</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Хасково" id="city-haskovo">
                  <label class="form-check-label" for="city-haskovo">Хасково</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Шумен" id="city-shumen">
                  <label class="form-check-label" for="city-shumen">Шумен</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Ямбол" id="city-yambol">
                  <label class="form-check-label" for="city-yambol">Ямбол</label>
                </div>
              </div>
            </div>

            <!-- Spheres -->
            <div class="mb-3">
              <label class="form-label">Сфера</label>
              <div id="sphereFilters" class="scrollable-filter border rounded p-2" style="max-height: 300px; overflow-y: auto;">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Информационни технологии" id="sphere-it">
                  <label class="form-check-label" for="sphere-it">Информационни технологии</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Здравеопазване" id="sphere-health">
                  <label class="form-check-label" for="sphere-health">Здравеопазване</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Образование" id="sphere-education">
                  <label class="form-check-label" for="sphere-education">Образование</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Финанси и счетоводство" id="sphere-finance">
                  <label class="form-check-label" for="sphere-finance">Финанси и счетоводство</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Продажби" id="sphere-sales">
                  <label class="form-check-label" for="sphere-sales">Продажби</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Маркетинг и реклама" id="sphere-marketing">
                  <label class="form-check-label" for="sphere-marketing">Маркетинг и реклама</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Строителство" id="sphere-construction">
                  <label class="form-check-label" for="sphere-construction">Строителство</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Транспорт и логистика" id="sphere-logistics">
                  <label class="form-check-label" for="sphere-logistics">Транспорт и логистика</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Хотелиерство и ресторантьорство" id="sphere-hospitality">
                  <label class="form-check-label" for="sphere-hospitality">Хотелиерство и ресторантьорство</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Администрация" id="sphere-admin">
                  <label class="form-check-label" for="sphere-admin">Администрация</label>
                </div>
              </div>
            </div>

            <!-- Salary Range -->
            <div class="mb-3 d-flex gap-2">
              <input type="number" id="minSalary" class="form-control" placeholder="Мин. заплата">
              <input type="number" id="maxSalary" class="form-control" placeholder="Макс. заплата">
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-center">
            <button id="applyFilters" class="btn btn-primary">Приложи</button>
          </div>
        </div>
      </div>
    </div>

    <div id="jobsDisplay" class="container">
      
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
  <script src="./js/jobs.js"></script>
</body>
</html>