document.addEventListener('DOMContentLoaded', () => {
    const categoryDropdown = document.getElementById('categoryDropdown');
    const dropdownButton = document.getElementById('dropdownMenuButton');

    categoryDropdown.addEventListener('click', (e) => {
        if (e.target && e.target.matches('a.dropdown-item')) {
            e.preventDefault();

            const categoryName = e.target.textContent;
            const categoryId = e.target.dataset.categoryId;

            // Update dropdown button text
            dropdownButton.textContent = categoryName;

            // Optionally store categoryId somewhere (e.g., hidden input or variable)
            console.log('Selected Category ID:', categoryId);
        }
    });
});