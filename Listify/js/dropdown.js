// grab elements
const toggle = document.getElementById('dropdownToggle');
const menu   = document.getElementById('dropdownMenu');

if (toggle && menu) {
  // toggle menu on arrow click
  toggle.addEventListener('click', e => {
    e.stopPropagation();
    menu.classList.toggle('show');
  });

  // close menu when clicking anywhere else
  document.addEventListener('click', () => {
    menu.classList.remove('show');
  });
} else {
  console.warn('Dropdown toggle or menu element not found');
}
