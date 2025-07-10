<?php
require_once "includes/config_session-inc.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: reglog.php");
    exit();
}

require_once "includes/signup_view-inc.php";
require_once "includes/login_view-inc.php";
require_once 'includes/security_view-inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style_nav.css">
    <link rel="shortcut icon" href="pics/favicon-32x32.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Huninn&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Libertinus+Math&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Raleway:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
<!--header-->
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="resources/logo.png" class="navbar-logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php
                    if (isset($_SESSION["user_id"])) { ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="addtasks.php">Add Tasks</a>
                        </li>
                    <?php } else { ?>
                        <span class="header-login-message"><?php output_username() ?></span>
                    <?php } ?>
                </ul>
                <div class="header-signup">
                    <div class="testings">
                        <div class="header-buttons">

                            <?php if (isset($_SESSION["user_id"])) { ?>
                                <div class=" dropdown ms-auto pe-4 d-flex align-items-center gap-3">
                                    <img src="includes/show_pfp-inc.php" alt="Profile picture" id="pfp" >
                                    <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php output_username(); ?>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                        <li>
                                            <form action="includes/logout-inc.php" method="post" class="dropdown-item p-0">
                                                <button type="submit" class="btn">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            <?php } else { ?>
                                <button class="header-button-register">REGISTER</button>
                                <button class="header-button-login">LOGIN</button>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Register Modal -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeRegister">&times;</span>
        <h2>Welcome to Listify!</h2>
        <br>
        <h3>Please make a new account</h3>

        <form action="includes/signup-inc.php" method="post">

            <label for="security_question" class="form-label center">Mandatory for registering:</label>
            <?php
            signup_input()
            ?>
            <br>

            <label for="security_question" class="form-label center">Optional:</label>
            <input type="text" name="security_question" placeholder="security_question">
            <label for="security_question" class="form-label"></label>
            <input type="text" name="security_answer" placeholder="security_answer">

            <button type="submit">Register</button>

            <?php
            check_signup_errors();
            ?>
        </form>
    </div>
</div>

<!-- Auth (Login/Reset) Modal -->
<div id="authModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeAuth">&times;</span>

        <!-- LOGIN STATE -->
        <div id="loginState">
            <h2>Welcome back to Listify!</h2>
            <h3>Enter your email and password</h3>
            <form id="loginForm" action="includes/login-inc.php" method="post">
                <input type="text" name="username" placeholder="name" required>
                <input type="password" name="pwd" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <p class="switch-link" id="toReset">Forgot password?</p>
            <?php check_login_errors(); ?>
        </div>

        <!-- RESET STATE -->
        <div class="reset-state" id="resetState" style="display:none;">
            <h2>Reset your password</h2>
            <h3>Enter your username</h3>

            <!-- Step 1: ask for username -->
            <form id="usernameForm">
                <input type="text" id="resetUsername" name="username" placeholder="Account name" required>
                <button type="submit">Next</button>
            </form>

            <!-- Step 2: secret answer -->
            <form id="answerForm" style="display:none;">
                <p id="securityQuestion"></p>
                <input type="text" id="securityAnswer" name="answer" placeholder="Your secret answer" required>
                <button type="submit">Next</button>
            </form>

            <!-- Step 3: new password form -->
            <form id="newPasswordForm" style="display:none;">
                <input type="password" id="newPassword" name="newPassword" placeholder="New password" required>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" required>
                <button type="submit">Set new password</button>
            </form>

            <!-- feedback / result -->
            <p id="resetMessage" style="margin-top:1rem;"></p>

            <p class="switch-link" id="toLogin">Back to login</p>
        </div>
    </div>
</div>

<!-- change-pfp Modal -->
<div id="pfpModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closePfp">&times;</span>
        <h2>Change Profile Picture</h2>

        <form id="pfpForm" action="includes/upload_pfp-inc.php" method="post" enctype="multipart/form-data">
            <label for="newPfp">Select new image:</label><br>
            <input type="file" name="newPfp" id="newPfp" accept="image/*" required><br><br>

            <button type="submit">Upload</button>
        </form>

        <?php if (!empty($_SESSION['pfp_error'])): ?>
            <div class="error"><?= htmlspecialchars($_SESSION['pfp_error']) ?></div>
            <?php unset($_SESSION['pfp_error']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['pfp_success'])): ?>
            <div class="success"><?= htmlspecialchars($_SESSION['pfp_success']) ?></div>
            <?php unset($_SESSION['pfp_success']); ?>
        <?php endif; ?>


        <div id="pfpError" style="color: red; margin-top:10px;"></div>
    </div>
</div>

<!--content-->
<div class="container-md">
    <h1>Listify – Organize your day, your way</h1>
    <div class="container mt-4" id="taskTableContainer">
    </div>
</div>

<!-- footer -->
<footer>
    <p>© 2025 Listify. All rights reserved.</p>
</footer>

<!-- dropdown & popup scripts -->
<script src="js/get_tasks.js"></script>
<script src="js/popup.js"></script>
<script src="js/dropdown.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>