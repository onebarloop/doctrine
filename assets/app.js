/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

function nestedLink() {
  const links = document.querySelectorAll('.note');

  links.forEach((link) => {
    link.addEventListener('click', () => {
      window.location.href = `notes/show/${link.id}`;
    });
  });
}

// function timer() {
//   const error = document.querySelector('.error');
//   if (error) {
//     // setInterval(() => error.remove(), 3000);
//     error.classList.add('!opacity-0');
//   }
// }

document.addEventListener('DOMContentLoaded', () => {
  nestedLink();
  // timer();
});
