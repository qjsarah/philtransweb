  const logo = document.getElementById('logoWrapper');
const navBar = document.getElementById('navBar');

logo.addEventListener('mouseenter', () => {
    navBar.classList.add('show-nav');
});

navBar.addEventListener('mouseleave', () => {
    navBar.classList.remove('show-nav');
});