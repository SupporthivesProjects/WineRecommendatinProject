
"use strict";
(() => {
  window.addEventListener('scroll', stickyFn);
  var navbar = document.getElementById("sidebar");

  // If the element is not found, we exit the script
  if (!navbar) {
    console.log("Sidebar element not found, skipping sticky function.");
    return; // Exit the function if the element doesn't exist
  }

  var sticky = navbar.offsetTop;
  function stickyFn() {
    if (window.scrollY >= 75) {
      navbar.classList.add("sticky-pin")
    } else {
      navbar.classList.remove("sticky-pin");
    }
  }
  window.addEventListener('scroll', stickyFn);
  window.addEventListener('DOMContentLoaded', stickyFn);
})();

function smallLogoByMehul() {
  let image = document.getElementById('dash-logo');
  let admin_name = document.getElementById('admin-name');

  let condition1 = image.style.maxWidth = '90px';
  let condition2 = admin_name.style.opacity = '0';
  console.log("hello");
  
  if (condition1) {
    image.style.maxWidth = '55px';
    admin_name.style.opacity = '0';
  } else {
    image.style.maxWidth = '90px';
    admin_name.style.opacity = '1';
  }
}