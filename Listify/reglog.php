<?php
require_once "includes/config_session-inc.php";
require_once "includes/signup_view-inc.php";
require_once "includes/login_view-inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register / Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style/style.css" rel="stylesheet">
</head>
<body>

<div class="form-container">
  <h2 id="formTitle">Login</h2>
  
  <form id="authForm" method="post" action="includes/login-inc.php">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" name="username" id="username" class="form-control">
    </div>

    <div class="mb-3">
      <label for="pwd" class="form-label">Password</label>
      <input type="password" name="pwd" id="pwd" class="form-control">
    </div>

    <div id="extraFields" style="display: none;">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control">
      </div>
      <div class="mb-3">
        <label for="security_question" class="form-label">Security Question</label>
        <input type="text" name="security_question" id="security_question" class="form-control">
      </div>
      <div class="mb-3">
        <label for="security_answer" class="form-label">Security Answer</label>
        <input type="text" name="security_answer" id="security_answer" class="form-control">
      </div>
      <?php check_signup_errors(); ?>
    </div>

    <button type="submit" class="btn btn-primary w-100" id="submitButton">Login</button>
    <?php check_login_errors(); ?>
  </form>

  <div class="mt-2">
    <p class="text-center"><a href="#" id="forgotPasswordLink">Forgot password?</a></p>
  </div>

  <div class="mt-3 d-flex justify-content-between">
    <button class="btn btn-outline-success" id="switchToRegister">Register</button>
    <button class="btn btn-outline-primary" id="switchToLogin">Login</button>
  </div>

  <!-- 🔷 Password reset panel -->
  <div id="resetPanel" class="mt-4 p-3 border rounded" style="display:none;">
    <h4>Password Reset</h4>

    <div id="resetStep1">
      <label>Username:</label>
      <input type="text" id="resetUsername" class="form-control mb-2">
      <button class="btn btn-primary w-100" id="fetchQuestion">Get Security Question</button>
    </div>

    <div id="resetStep2" style="display:none;">
      <p id="securityQuestionText" class="fw-bold"></p>
      <input type="text" id="securityAnswer" placeholder="Your Answer" class="form-control mb-2">
      <button class="btn btn-success w-100" id="verifyAnswer">Verify Answer</button>
    </div>

    <div id="resetStep3" style="display:none;">
      <input type="password" id="newPassword" placeholder="New Password" class="form-control mb-2">
      <input type="password" id="confirmPassword" placeholder="Confirm New Password" class="form-control mb-2">
      <button class="btn btn-warning w-100" id="resetPassword">Reset Password</button>
    </div>

    <div id="resetMessage" class="mt-2 text-center text-success"></div>
  </div>

</div>

<script src="js/get_tasks.js"></script>
<script src="js/popup.js"></script>
<script src="js/dropdown.js"></script>
<script src="js/reglog.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>