document.querySelector('.sidemenu-toggle').addEventListener('click', function() {
  const sidebar = document.querySelector('.sidebar');
  sidebar.classList.toggle('show');
});

document.querySelector('.sidemenu-toggle-close').addEventListener('click', function() {
  document.getElementById('responsive-overlay').classList.remove('.active')
  const sidebar = document.querySelector('.sidebar');
  sidebar.classList.toggle('show');
});