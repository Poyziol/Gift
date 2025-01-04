// This main file is for each view, not only for the view main  
// Theme toggling
$(document).ready(function () {
    const $html = $('html');
    const $themeToggler = $('#themeToggler');

    // Load the theme from localStorage
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        $html.attr('data-bs-theme', savedTheme);
        $themeToggler.attr('data-theme', savedTheme);
    }

    // Toggle theme and save to localStorage
    $themeToggler.on('click', function () {
        const currentTheme = $html.attr('data-bs-theme');
        const newTheme = currentTheme == 'light' ? 'dark' : 'light';
        $html.attr('data-bs-theme', newTheme);
        $themeToggler.attr('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    });
});

// Main margin to the header
document.addEventListener('DOMContentLoaded', function () {
    const header = document.querySelector('header');
    const main = document.querySelector('main');
    
    if (header && main) {
        const headerHeight = header.offsetHeight;
        main.style.marginTop = `${headerHeight + 50}px`;
    }
});

// Used in other scripts
function showModalMessage(message) {
    const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
    document.querySelector('#messageModal .modal-body p').textContent = message;
    messageModal.show();
}