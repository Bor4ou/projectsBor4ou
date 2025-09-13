let selectedRole = "employee"; // default

const employeeBtn = document.getElementById("employeeBtn");
const adminBtn = document.getElementById("adminBtn");
const roleInput = document.getElementById("roleInput");

employeeBtn.addEventListener("click", () => {
    selectedRole = "employee";
    roleInput.value = "employee";
    employeeBtn.classList.add("active");
    adminBtn.classList.remove("active");
});

adminBtn.addEventListener("click", () => {
    selectedRole = "admin";
    roleInput.value = "admin";
    adminBtn.classList.add("active");
    employeeBtn.classList.remove("active");
});