const jobsDisplay = document.getElementById('jobsDisplay');

document.addEventListener('DOMContentLoaded', () => {
  loadJobs();
});

document.getElementById('applyFilters').addEventListener('click', () => {
  const selectedCities = Array.from(document.querySelectorAll('#cityFilters input:checked')).map(cb => cb.value);
  const selectedSpheres = Array.from(document.querySelectorAll('#sphereFilters input:checked')).map(cb => cb.value);
  const minSalary = document.getElementById('minSalary').value;
  const maxSalary = document.getElementById('maxSalary').value;

  const params = new URLSearchParams();

  if (selectedCities.length > 0) params.append('cities', selectedCities.join(','));
  if (selectedSpheres.length > 0) params.append('spheres', selectedSpheres.join(','));
  if (minSalary) params.append('min', minSalary);
  if (maxSalary) params.append('max', maxSalary);

  fetch(`./includes/filter_jobs-inc.php?${params.toString()}`)
    .then(res => res.json())
    .then(data => {
      renderJobs(data.jobs);
    })
    .catch(err => console.error('Error fetching filtered jobs:', err));
});

function loadJobs() {
  fetch('./includes/filter_jobs-inc.php')
    .then(res => res.json())
    .then(data => {
      renderJobs(data.jobs);
    })
    .catch(err => console.error('Error loading jobs:', err));
}

function renderJobs(jobs) {
  jobsDisplay.innerHTML = '';

  if (!jobs || jobs.length === 0) {
    jobsDisplay.innerHTML = '<p class="text-center">Няма намерени обяви в момента.</p>';
    return;
  }

  jobs.forEach(job => {
    const jobCard = document.createElement('a');
    jobCard.href = `view_job.php?id=${job.job_id}`;
    jobCard.className = 'card mb-3 text-decoration-none text-dark';
    jobCard.innerHTML = `
      <div class="row g-0">
        <div class="col-md-9">
          <div class="card-body">
            <h5 class="card-title">Позиция: ${job.position}</h5>
            <p class="card-text"><strong>Сфера:</strong> ${job.job_sphere}</p>
            <p class="card-text"><strong>Локация:</strong> ${job.address}</p>
            <p class="card-text"><strong>Заплата:</strong> ${job.salary} ${job.currency}</p>
            <p class="card-text job-description">${job.description}</p>
          </div>
        </div>
        <div class="col-md-3 d-flex align-items-center justify-content-center p-3">
            <img src="${job.firm_logo ? job.firm_logo.replace(/^\./, '') : './resources/images/default_logo.png'}" alt="Firm Logo" class="img-fluid" style="max-height: 200px; max-width: 100%;">
        </div>
      </div>
    `;
    jobsDisplay.appendChild(jobCard);
  });
}