document.addEventListener('DOMContentLoaded', () => {
    const taskForm = document.getElementById("taskForm");
    const taskInput = document.getElementById("taskInput");
    const categoryDropdown = document.getElementById("categoryDropdown");
    const dropdownButton = document.getElementById('dropdownMenuButton');

    let selectedCategoryId = null;

    // Listen for clicks on dropdown items to set selected category
    categoryDropdown.addEventListener('click', (e) => {
        e.preventDefault();
        if (e.target && e.target.matches('a.dropdown-item')) {
            console.log("Clicked element dataset:", e.target.dataset);
            selectedCategoryId = e.target.dataset.categoryId;
            dropdownButton.textContent = e.target.textContent;
            console.log("Selected category ID:", selectedCategoryId);
        }
    });

    // On form submit, send the data via fetch
    taskForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const taskName = taskInput.value.trim();

        if (!taskName) {
            alert("Please enter a task.");
            return;
        }

        if (!selectedCategoryId) {
            alert("Please select a category.");
            return;
        }

        fetch('includes/tasks-inc.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                taskInput: taskName,
                categoryId: selectedCategoryId
            })
        })
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    alert("Error: " + data.error);
                } else {
                    alert("Task added successfully!");
                    taskInput.value = '';
                    dropdownButton.textContent = "Select a Category";
                    selectedCategoryId = null;
                }
            })
            .catch(err => {
                console.error(err);
                alert("An error occurred.");
            });
    });
});