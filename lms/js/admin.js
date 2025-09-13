document.addEventListener("DOMContentLoaded", function () {
    fetch("includes/get_leaves_admin-inc.php")
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const tableBody = document.querySelector("#adminLeaveTableBody");
                tableBody.innerHTML = "";
                data.leaves.forEach(leave => {
                    const row = document.createElement("tr");

                    row.innerHTML = `
                        <td data-label="ID">${leave.leave_id}</td>
                        <td data-label="Служител">${leave.employee_name}</td>
                        <td data-label="Дата на заявка">${formatDateToBG(leave.submitted_date)}</td>
                        <td data-label="От">${formatDateToBG(leave.from_date)}</td>
                        <td data-label="До">${formatDateToBG(leave.to_date)}</td>
                        <td data-label="Връщане">${formatDateToBG(leave.return_date)}</td>
                        <td data-label="Тип">${leave.type}</td>
                        <td data-label="Заместник">${leave.substitute_name || "—"}</td>
                        <td data-label="Статус"><span class="badge ${getStatusClass(leave.status)}">${leave.status}</span></td>
                        <td data-label="Действия">
                            ${leave.status === "Очаква обработка" ? `
                                <button class="btn btn-success btn-sm approve-btn" data-id="${leave.leave_id}">Одобряване</button>
                                <button class="btn btn-danger btn-sm reject-btn" data-id="${leave.leave_id}">Отказване</button>
                            ` : "—"}
                        </td>
                    `;

                    tableBody.appendChild(row);
                });
                attachActionHandlers();
            } else {
                alert("Грешка при зареждане на заявките: " + data.message);
            }
        })
        .catch(error => {
            console.error("Грешка при заявката:", error);
            alert("Възникна проблем при зареждането на заявките.");
        });
});

function formatDateToBG(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("bg-BG");
}

function getStatusClass(status) {
    switch (status) {
        case "Очаква обработка": return "bg-warning text-dark";
        case "Одобрено": return "bg-success";
        case "Отказано": return "bg-danger";
        default: return "bg-secondary";
    }
}

function attachActionHandlers() {
    document.querySelectorAll(".approve-btn").forEach(button => {
        button.addEventListener("click", function () {
            const leaveId = this.dataset.id;
            updateLeaveStatus(leaveId, "Одобрено");
        });
    });

    document.querySelectorAll(".reject-btn").forEach(button => {
        button.addEventListener("click", function () {
            const leaveId = this.dataset.id;
            updateLeaveStatus(leaveId, "Отказано");
        });
    });
}

function updateLeaveStatus(leaveId, newStatus) {
    fetch("includes/update_leave_status-inc.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ leave_id: leaveId, status: newStatus }),
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert("Грешка при обновяване: " + data.message);
        }
    })
    .catch(error => {
        console.error("Грешка при заявката:", error);
        alert("Възникна проблем при изпращането.");
    });
}
