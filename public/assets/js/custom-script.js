document.querySelector('.sidemenu-toggle').addEventListener('click', function() {
  const sidebar = document.querySelector('.sidebar');
  sidebar.classList.toggle('show');
});

document.querySelector('.sidemenu-toggle-close').addEventListener('click', function() {
  document.querySelector('#responsive-overlay').classList.remove('.active')
  const sidebar = document.querySelector('.sidebar');
  sidebar.classList.toggle('show');
});