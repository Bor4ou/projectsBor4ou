const urlParams = new URLSearchParams(window.location.search);
const jobId = urlParams.get('id');
const jobContainer = document.getElementById('jobContainer');

async function fetchJobDetails() {
    try{
        const response = await fetch(`./includes/fetch_full_job-inc.php?id=${jobId}`);
        const data = await response.json();
        if (data.status === 'success') {
            const job = data.job;
            const logoPath = job.firm_logo
              ? job.firm_logo.replace(/^\./, '')
              : './resources/images/default_logo.png';

            jobContainer.innerHTML = `
              <h1>${job.position}</h1>
              <img src="${logoPath}" alt="Firm Logo" style="max-width: 200px;">
              <p><strong>Локация:</strong> ${job.address}</p>
              <p><strong>Сфера:</strong> ${job.job_sphere}</p>
              <p><strong>Заплата:</strong> ${job.salary} ${job.currency}</p>
              <p class="text-wrap text-break">${job.description.replace(/\n/g, '<br>')}</p>
              <br><br>
              <a href="jobs.php" class="btn btn-primary btn-lg">🡸 Назад към всички обяви</a>
            `;
          } else {
            jobContainer.innerHTML = `<p class="text-center text-danger">${data.message}</p>`;
          }
    } catch (error) {
        console.error('Грешка при извличане на обявата', error);
        jobContainer.innerHTML = '<p class="text-center text-danger">Възникна грешка при зареждането на обявата.</p>';
    }
}

document.addEventListener('DOMContentLoaded', fetchJobDetails);