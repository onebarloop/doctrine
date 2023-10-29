export function nestedLink() {
  const links = document.querySelectorAll('.note');

  links.forEach((link) => {
    link.addEventListener('click', () => {
      window.location.href = `/notes/show/${link.id}`;
    });
  });
}
