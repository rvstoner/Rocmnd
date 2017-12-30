const accordions = document.getElementsByClassName('has-submenu')
const adminSlideButton = document.getElementById('admin-slideout-button')

function setSubmenuStyles (submenu, maxHeight, margins) {
  submenu.style.maxHeight = maxHeight
  submenu.style.marginTop = margins
  submenu.style.marginBottom = margins
}

adminSlideButton.onclick = function () {
  this.classList.toggle('is-active');
  document.getElementById('admin-side-menu').classList.toggle('is-active');
}

for (var i = 0; i < accordions.length; i++) {
  if (accordions[i].classList.contains('is-active')) {
    const submenu = accordions[i].nextElementSibling
    setSubmenuStyles(submenu, submenu.scrollHeight + "px", "0.75em")
  }

  accordions[i].onclick = function () {
    this.classList.toggle('is-active')

    const submenu = this.nextElementSibling
    if (submenu.style.maxHeight) {
      // menu is open, we need to close it now
      setSubmenuStyles(submenu, null, null)
    } else {
      // meny is close, so we need to open it
      setSubmenuStyles(submenu, submenu.scrollHeight + "px", "0.75em")
    }
  }
}

document.addEventListener('DOMContentLoaded', function () {

  // Get all "navbar-burger" elements
  var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach(function ($el) {
      $el.addEventListener('click', function () {

        // Get the target from the "data-target" attribute
        var target = $el.dataset.target;
        var $target = document.getElementById(target);

        // Toggle the class on both the "navbar-burger" and the "navbar-menu"
        $el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

      });
    });
  }

});