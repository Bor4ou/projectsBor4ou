const addJobForm = document.getElementById('addJobForm');

addJobForm.addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(addJobForm);
  const submitBtn = addJobForm.querySelector('button[type="submit"]');
  submitBtn.disabled = true;

  fetch('./includes/insert_job-inc.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    alert(data.message);
    if (data.status === 'success') {
      addJobForm.reset();
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Възникна грешка при добавянето.');
  })
  .finally(() => {
    submitBtn.disabled = false;
  });
});