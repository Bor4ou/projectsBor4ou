document.addEventListener('DOMContentLoaded', loadTasks);

let originalCategories = []; // to reset sorting when "Clear" is clicked

async function loadTasks() {
    try {
        const response = await fetch('includes/get_tasks-inc.php');
        const categories = await response.json();

        originalCategories = JSON.parse(JSON.stringify(categories)); // Deep clone

        renderCategories(categories);
    } catch (err) {
        console.error('Error loading tasks:', err);
    }
}

function renderCategories(categories) {
    const container = document.getElementById('taskTableContainer');
    container.innerHTML = '';

    if (!Array.isArray(categories) || categories.length === 0) {
        container.innerHTML = '<p style="text-align: center;">No tasks yet. Check if you are logged in or have any added tasks.</p>';
        return;
    }

    categories.forEach(category => {
        const table = document.createElement('table');
        table.className = 'table table-bordered mb-4';

        // Header with category name and delete button
        const header = document.createElement('thead');
        header.innerHTML = `
            <tr>
                <th colspan="3">
                    ${category.category_name}
                    <button class="btn btn-danger btn-sm float-end" onclick="deleteCategory(${category.category_id})">Delete Category</button>
                </th>
            </tr>
            <tr>
                <th colspan="3">
                    <div class="btn-group d-flex justify-content-center my-2" role="group">
                        <button class="btn btn-outline-primary btn-sm" onclick="sortTasks(${category.category_id}, 'az')">A-Z</button>
                        <button class="btn btn-outline-primary btn-sm" onclick="sortTasks(${category.category_id}, 'za')">Z-A</button>
                        <button class="btn btn-outline-primary btn-sm" onclick="sortTasks(${category.category_id}, 'new')">Newest</button>
                        <button class="btn btn-outline-primary btn-sm" onclick="sortTasks(${category.category_id}, 'old')">Oldest</button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="sortTasks(${category.category_id}, 'clear')">Clear Sort</button>
                    </div>
                </th>
            </tr>
            <tr>
                <th>Task</th>
                <th>Created at</th>
                <th>Action</th>
            </tr>
        `;
        table.appendChild(header);

        const tbody = document.createElement('tbody');
        category.tasks.forEach(task => {
            const row = document.createElement('tr');
            const formattedDate = new Date(task.created_at).toLocaleString();
            row.innerHTML = `
                <td>${task.task_name}</td>
                <td>${formattedDate}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteTask(${task.task_id})">Delete</button>
                </td>
            `;
            tbody.appendChild(row);
        });
        table.appendChild(tbody);
        container.appendChild(table);
    });
}

function sortTasks(categoryId, type) {
    const updatedCategories = originalCategories.map(category => {
        if (category.category_id !== categoryId) return category;

        const tasks = [...category.tasks];
        switch (type) {
            case 'az':
                tasks.sort((a, b) => a.task_name.localeCompare(b.task_name));
                break;
            case 'za':
                tasks.sort((a, b) => b.task_name.localeCompare(a.task_name));
                break;
            case 'new':
                tasks.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                break;
            case 'old':
                tasks.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                break;
            case 'clear':
                // reset to original order
                return originalCategories.find(c => c.category_id === categoryId);
        }

        return { ...category, tasks };
    });

    renderCategories(updatedCategories);
}

async function deleteTask(taskId) {
    if (!confirm("Are you sure you want to delete this task?")) return;

    try {
        const res = await fetch(`includes/delete_task-inc.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ task_id: taskId })
        });
        const result = await res.json();
        if (result.success) await loadTasks();
        else alert('Delete failed: ' + result.error);
    } catch (e) {
        alert('Error deleting task: ' + e.message);
    }
}

async function deleteCategory(categoryId) {
    if (!confirm("Are you sure you want to delete this entire category and all its tasks?")) return;

    try {
        const res = await fetch(`includes/delete_category-inc.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ category_id: categoryId })
        });
        const result = await res.json();
        if (result.success) await loadTasks();
        else alert('Delete failed: ' + result.error);
    } catch (e) {
        alert('Error deleting category: ' + e.message);
    }
}
