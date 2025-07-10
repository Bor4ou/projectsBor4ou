const categoryForm = document.getElementById("categoryForm");
const categoryInput = document.getElementById("categoryInput");
const dropdown = document.getElementById('categoryDropdown');

categoryForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const categoryName = categoryInput.value.trim();
    if (!categoryName) return;

    fetch('includes/categories-inc.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ categoryInput: categoryName })
    })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert('Error: ' + data.error);
            } else {
                alert('Category added successfully!');
                const categoryName = categoryInput.value.trim();
                categoryInput.value = '';
                updateCategoryDropdown();
            }
        })
});

function updateCategoryDropdown() {
    dropdown.innerHTML = '';
    fetch('includes/get_categories-inc.php?nocache=' + new Date().getTime())
        .then(res => res.json())
        .then(data => {
            data.forEach(category => {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.classList.add('dropdown-item');
                a.href = '#';
                a.textContent = category.category_name;
                console.log('category.category_id:', category.category_id);
                a.dataset.categoryId = category.category_id;
                li.appendChild(a);
                dropdown.appendChild(li);
            });
        })
        .catch(error => {
            console.error('Error fetching categories:', error);
        });
}

document.addEventListener("DOMContentLoaded", function () {
    updateCategoryDropdown();
});

