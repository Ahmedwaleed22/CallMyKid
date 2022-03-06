window.addEventListener('load', () => {
  const burgerIcon = document.getElementById('burgerIcon');
  const navLinks = document.getElementById('navLinks');

  burgerIcon.addEventListener('click', () => {
    if (navLinks.classList.contains('opened')) {
      navLinks.classList.remove('opened');
      navLinks.classList.add('closed');
    } else if (navLinks.classList.contains('closed')) {
      navLinks.classList.remove('closed');
      navLinks.classList.add('opened');
    } else {
      navLinks.classList.add('opened');
    }
  });
});