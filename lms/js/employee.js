 
document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("leaveForm");
    const tableBody = document.querySelector("#applicationsTable tbody");

    function formatDateToBG(dateString) {
        const [year, month, day] = dateString.split("-");
        return `${day}/${month}/${year}`;
    }

    fetch('includes/get_leaves-inc.php')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                data.leaves.forEach(leave => {
                    const isPending = leave.status === 'Очаква обработка';

                    const newRow = `
                        <tr data-leave-id="${leave.leave_id}">
                            <td data-label="Дата">${formatDateToBG(leave.submitted_date)}</td>
                            <td data-label="От - До">${formatDateToBG(leave.from_date)} – ${formatDateToBG(leave.to_date)}</td>
                            <td data-label="Вид">${leave.type}</td>
                            <td data-label="Статус">
                                <span class="badge ${getStatusClass(leave.status)}">${leave.status}</span>
                            </td>
                            <td data-label="Действия">
                                ${isPending ? '<button class="btn btn-sm btn-danger cancel-btn">Анулирай</button>' : ''}
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', newRow);
                });
            } else {
                console.warn('Неуспешно зареждане на заявките:', data.message);
            }
        })
        .catch(err => console.error('Грешка при зареждане на заявките:', err));

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        if (!fromDate || !toDate || !leaveType || !returnDate || !replacementEmployee) {
            alert("Моля, попълнете всички полета.");
            return;
        }

        const formData = new FormData(form);

        fetch("includes/submit_leave-inc.php", {
        method: "POST",
        body: formData
        })
        .then(res => res.json())
        .then(data => {
        if (data.success) {
            const leave = data.leave;
            const isPending = leave.status === 'Очаква обработка';

            const newRow = `
            <tr>
                <td data-label="Дата">${formatDateToBG(leave.submitted_date)}</td>
                <td data-label="От - До">${formatDateToBG(leave.from_date)} – ${formatDateToBG(leave.to_date)}</td>
                <td data-label="Вид">${leave.type}</td>
                <td data-label="Статус"><span class="badge bg-warning text-dark">${leave.status}</span></td>
                <td data-label="Действия">
                    ${isPending ? '<button class="btn btn-sm btn-danger cancel-btn">Анулирай</button>' : ''}
                </td>   
            </tr>
            `;

            tableBody.insertAdjacentHTML('afterbegin', newRow);
            form.reset();
        } else {
            alert(data.message || "Възникна грешка при изпращането.");
        }
        })
        .catch(error => {
        console.error("Грешка:", error);
        alert("Възникна проблем със заявката.");
        });
    });

    tableBody.addEventListener("click", function (e) {
        if (e.target.classList.contains("cancel-btn")) {
            const row = e.target.closest("tr");
            const leaveId = row.getAttribute("data-leave-id");

            if (confirm("Сигурни ли сте, че искате да анулирате заявката?")) {
                fetch("includes/delete_leave-inc.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `leave_id=${leaveId}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        row.remove();
                    } else {
                        alert(data.message || "Неуспешно анулиране.");
                    }
                })
                .catch(err => {
                    console.error("Грешка при анулиране:", err);
                    alert("Възникна грешка при заявката.");
                });
            }
        }
    });

    function getStatusClass(status) {
        switch (status) {
            case "Очаква обработка":
                return "bg-warning text-dark";
            case "Одобрено":
                return "bg-success";
            case "Отказано":
                return "bg-danger";
            default:
                return "bg-secondary";
        }
    }



    const countElements = document.querySelectorAll('.count-number');

    const animateCount = (element) => {
    const targetNumber = parseInt(element.getAttribute('data-target-number'));
    const duration = 1500;
    let start = 0;

    const startTime = performance.now();

    const updateCount = (currentTime) => {
        const elapsed = currentTime - startTime; 
        const progress = Math.min(elapsed / duration, 1); 
        const currentValue = Math.floor(progress * targetNumber); 

        element.textContent = currentValue; 

        if (progress < 1) {
        requestAnimationFrame(updateCount); 
        }
    };

    requestAnimationFrame(updateCount); 
    };

    
    const observerOptions = {
    root: null, 
    rootMargin: '0px',
    threshold: 0.5 
    };

    const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
        animateCount(entry.target); 
        observer.unobserve(entry.target); 
        }
    });
    }, observerOptions);

    
    countElements.forEach(element => {
    observer.observe(element);
    });

});