document.querySelector('.sidemenu-toggle').addEventListener('click', function() {
  const sidebar = document.querySelector('.sidebar');
  sidebar.classList.toggle('show');
});

document.querySelector('.sidemenu-toggle-close').addEventListener('click', function() {
  let html = document.querySelector('html');
  html.setAttribute('data-toggled', 'close');
  document.querySelector("#responsive-overlay").classList.remove("active");
  const sidebar = document.querySelector('.sidebar');
  sidebar.classList.toggle('show');
});