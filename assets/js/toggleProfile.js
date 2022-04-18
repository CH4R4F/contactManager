// listen for click on toggle profile button and show/hide dropdown
let toggleProfile = document.querySelector('#user-menu-button');
toggleProfile.addEventListener('click', function() {
  let profileDropdown = document.querySelector('[role="menu"]');
  profileDropdown.classList.toggle('scale-0');
});