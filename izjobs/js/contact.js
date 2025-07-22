const contactForm = document.getElementById('contactForm');

contactForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(contactForm);
    const submitBtn = contactForm.querySelector('button[type="submit"]');
    submitBtn.disabled = true;

    fetch('./includes/insert_message-inc.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.status === 'success') {
            contactForm.reset();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Възникна грешка при изпращането на съобщението.');
    })
    .finally(() => {
        submitBtn.disabled = false;
    });
});