// popup.js
document.addEventListener('DOMContentLoaded', () => {
// --- Modal & Button Elements ---
  const registerBtn = document.querySelector('.header-button-register');
  const loginBtn = document.querySelector('.header-button-login');
  const pfp = document.getElementById('pfp');
  const securityBtn = document.getElementById('security');

  const registerModal = document.getElementById('registerModal');
  const authModal = document.getElementById('authModal');
  const pfpModal = document.getElementById('pfpModal');
  const securityModal = document.getElementById('securityModal');

  const closeRegister = document.getElementById('closeRegister');
  const closeAuth = document.getElementById('closeAuth');
  const closePfp = document.getElementById('closePfp');
  const closeSecurity = document.getElementById('closeSecurity');

// --- Auth (Login/Reset) State Elements ---
  const loginState = document.getElementById('loginState');
  const resetState = document.getElementById('resetState');
  const toReset = document.getElementById('toReset');
  const toLogin = document.getElementById('toLogin');

// Reset‐flow forms & fields
  const usernameForm = document.getElementById('usernameForm');
  const resetUsername = document.getElementById('resetUsername');
  const answerForm = document.getElementById('answerForm');
  const securityQuestion = document.getElementById('securityQuestion');
  const securityAnswer = document.getElementById('securityAnswer');
  const newPasswordForm = document.getElementById('newPasswordForm');
  const newPasswordInput = document.getElementById('newPassword');
  const confirmPassword = document.getElementById('confirmPassword');
  const resetMessage = document.getElementById('resetMessage');

// --- Helper: Show/Hide States ---

// Show the login form, hide everything else
  function showLogin() {
    loginState.style.display = 'block';
    resetState.style.display = 'none';
    usernameForm.style.display = 'block';
    answerForm.style.display = 'none';
    newPasswordForm.style.display = 'none';
    resetMessage.textContent = '';
  }

// Show the initial reset‐username form
  function showResetUsername() {
    loginState.style.display = 'none';
    resetState.style.display = 'block';
    usernameForm.style.display = 'block';
    answerForm.style.display = 'none';
    newPasswordForm.style.display = 'none';
    resetMessage.textContent = '';
  }

// Show the secret‐answer form
  function showAnswerForm() {
    usernameForm.style.display = 'none';
    answerForm.style.display = 'block';
    newPasswordForm.style.display = 'none';
    resetMessage.textContent = '';
  }

// Show the new‐password form
  function showNewPasswordForm() {
    usernameForm.style.display = 'none';
    answerForm.style.display = 'none';
    newPasswordForm.style.display = 'block';
    resetMessage.textContent = '';
  }

// --- Modal Open Handlers ---
  if (registerBtn && registerModal) {
    registerBtn.addEventListener('click', () => {
      registerModal.style.display = 'flex';
    });
  }

  if (loginBtn && authModal) {
    loginBtn.addEventListener('click', () => {
      authModal.style.display = 'flex';
      showLogin();
    });
  }

  if (pfp && pfpModal) {
    pfp.style.cursor = 'pointer';
    pfp.addEventListener('click', () => {
      pfpModal.style.display = 'flex';
    });
  }

  if (securityBtn && securityModal) {
    securityBtn.addEventListener('click', () => {
      securityModal.style.display = 'flex';
    });
  }

// --- Modal Close Handlers ---
  if (closeRegister) closeRegister.addEventListener('click', () => registerModal.style.display = 'none');
  if (closeAuth) closeAuth.addEventListener('click', () => authModal.style.display = 'none');
  if (closePfp) closePfp.addEventListener('click', () => pfpModal.style.display = 'none');
  if (closeSecurity) closeSecurity.addEventListener('click', () => securityModal.style.display = 'none');

// Switch between login <-> reset
  if (toReset) toReset.addEventListener('click', showResetUsername);
  if (toLogin) toLogin.addEventListener('click', showLogin);

// Click outside to close any modal
  window.addEventListener('click', e => {
    if (e.target === registerModal) registerModal.style.display = 'none';
    if (e.target === authModal) authModal.style.display = 'none';
    if (e.target === pfpModal) pfpModal.style.display = 'none';
    if (e.target === securityModal) securityModal.style.display = 'none';
  });

// --- AJAX: Reset‐flow ---

// 1) Username -> get security question
  usernameForm.addEventListener('submit', async e => {
    e.preventDefault();
    resetMessage.textContent = '';
    const user = resetUsername.value.trim();
    if (!user) return;

    try {
      const resp = await fetch('includes/get_question-inc.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({username: user})
      });
      const data = await resp.json();

      if (data.error) {
        resetMessage.style.color = 'red';
        resetMessage.textContent = data.error;
      } else {
        securityQuestion.textContent = data.question;
        showAnswerForm();
      }
    } catch (err) {
      console.error('get_question failed', err);
      resetMessage.style.color = 'red';
      resetMessage.textContent = 'Network error. Try again.';
    }
  });

// 2) Answer -> verify, then show new‐password form
  answerForm.addEventListener('submit', async e => {
    e.preventDefault();
    resetMessage.textContent = '';
    const user = resetUsername.value.trim();
    const ans = securityAnswer.value.trim();
    if (!ans) return;

    try {
      const resp = await fetch('includes/verify_answer-inc.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({username: user, answer: ans})
      });
      const data = await resp.json();

      if (data.error) {
        resetMessage.style.color = 'red';
        resetMessage.textContent = data.error;
      } else {
        showNewPasswordForm();
      }
    } catch (err) {
      console.error('verify_answer failed', err);
      resetMessage.style.color = 'red';
      resetMessage.textContent = 'Network error. Try again.';
    }
  });

// 3) New password -> submit to reset_password‐endpoint
  newPasswordForm.addEventListener('submit', async e => {
    e.preventDefault();
    resetMessage.textContent = '';

    const pass1 = newPasswordInput.value;
    const pass2 = confirmPassword.value;
    if (pass1 === '' || pass2 === '') return;

    if (pass1 !== pass2) {
      resetMessage.style.color = 'red';
      resetMessage.textContent = 'Passwords do not match.';
      return;
    }

    try {
      const resp = await fetch('includes/reset_password-inc.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
          username: resetUsername.value.trim(),
          newPassword: pass1
        })
      });
      const data = await resp.json();

      if (data.error) {
        resetMessage.style.color = 'red';
        resetMessage.textContent = data.error;
      } else {
        resetMessage.style.color = 'green';
        resetMessage.textContent = 'Your password has been reset.';
        newPasswordForm.style.display = 'none';
      }
    } catch (err) {
      console.error('reset_password failed', err);
      resetMessage.style.color = 'red';
      resetMessage.textContent = 'Network error. Try again.';
    }
  });
});