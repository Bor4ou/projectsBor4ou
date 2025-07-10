const formTitle = document.getElementById("formTitle");
const authForm = document.getElementById("authForm");
const submitButton = document.getElementById("submitButton");
const extraFields = document.getElementById("extraFields");
const extraFieldsInputs = extraFields.querySelectorAll("input");

function disableExtraFields() {
  extraFieldsInputs.forEach(input => {
    input.required = false;
    input.disabled = true;
  });
  extraFields.style.display = "none";
}

function enableExtraFields() {
  extraFieldsInputs.forEach(input => {
    input.required = true;
    input.disabled = false;
  });
  extraFields.style.display = "block";
}

document.getElementById("switchToRegister").addEventListener("click", () => {
  formTitle.textContent = "Register";
  authForm.action = "includes/signup-inc.php";
  submitButton.textContent = "Register";
  disableResetPanel();
  enableExtraFields();
  document.getElementById("forgotPasswordLink").parentElement.style.display = "none";
});

document.getElementById("switchToLogin").addEventListener("click", () => {
  formTitle.textContent = "Login";
  authForm.action = "includes/login-inc.php";
  submitButton.textContent = "Login";
  disableResetPanel();
  disableExtraFields();
  document.getElementById("forgotPasswordLink").parentElement.style.display = "block";
});

disableExtraFields();


// 🔷 Password reset logic
const resetPanel = document.getElementById("resetPanel");
const forgotPasswordLink = document.getElementById("forgotPasswordLink");
const resetMessage = document.getElementById("resetMessage");

const resetStep1 = document.getElementById("resetStep1");
const resetStep2 = document.getElementById("resetStep2");
const resetStep3 = document.getElementById("resetStep3");

forgotPasswordLink.addEventListener("click", () => {
  resetPanel.style.display = "block";
  resetStep1.style.display = "block";
  resetStep2.style.display = "none";
  resetStep3.style.display = "none";
  resetMessage.textContent = "";
  resetMessage.style.color = "";
});

function disableResetPanel() {
  resetPanel.style.display = "none";
}

function showResetMessage(message, isError = false) {
  resetMessage.textContent = message;
  if (isError) {
    resetMessage.style.color = "red";
  } else {
    resetMessage.style.color = "green";
  }
}

document.getElementById("fetchQuestion").addEventListener("click", () => {
  const username = document.getElementById("resetUsername").value.trim();
  resetMessage.textContent = "";
  resetMessage.style.color = "";

  if (!username) {
    showResetMessage("Please enter a username.", true);
    return;
  }

  fetch("includes/get_question-inc.php", {
    method: "POST",
    body: JSON.stringify({ username })
  })
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        showResetMessage(data.error, true);
      } else {
        document.getElementById("securityQuestionText").textContent = data.question;
        resetStep1.style.display = "none";
        resetStep2.style.display = "block";
      }
    })
    .catch(() => {
      showResetMessage("Server error.", true);
    });
});

document.getElementById("verifyAnswer").addEventListener("click", () => {
  const username = document.getElementById("resetUsername").value.trim();
  const answer = document.getElementById("securityAnswer").value.trim();
  resetMessage.textContent = "";
  resetMessage.style.color = "";

  if (!answer) {
    showResetMessage("Please enter the answer.", true);
    return;
  }

  fetch("includes/verify_answer-inc.php", {
    method: "POST",
    body: JSON.stringify({ username, answer })
  })
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        showResetMessage(data.error, true);
      } else {
        resetStep2.style.display = "none";
        resetStep3.style.display = "block";
      }
    })
    .catch(() => {
      showResetMessage("Server error.", true);
    });
});

document.getElementById("resetPassword").addEventListener("click", () => {
  const username = document.getElementById("resetUsername").value.trim();
  const newPassword = document.getElementById("newPassword").value.trim();
  const confirmPassword = document.getElementById("confirmPassword").value.trim();
  resetMessage.textContent = "";
  resetMessage.style.color = "";

  if (!newPassword || !confirmPassword) {
    showResetMessage("Please fill both password fields.", true);
    return;
  }
  if (newPassword !== confirmPassword) {
    showResetMessage("Passwords do not match.", true);
    return;
  }

  fetch("includes/reset_password-inc.php", {
    method: "POST",
    body: JSON.stringify({ username, newPassword })
  })
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        showResetMessage(data.error, true);
      } else {
        showResetMessage("Password successfully reset!", false);
        resetStep3.style.display = "none";
      }
    })
    .catch(() => {
      showResetMessage("Server error.", true);
    });
});