
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

  if (image.style.maxWidth = '90px') {
    console.log('hello', image);
    
    
  } else {
     console.log('hi', image);
  }

}