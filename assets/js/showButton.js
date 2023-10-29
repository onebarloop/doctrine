const confirm = document.querySelector('.js-update-confirm');
const abort = document.querySelector('.js-update-abort');
const input = document.querySelector('.js-update-field');

const toggle = () => {
  confirm.classList.toggle('h-0');
  confirm.classList.toggle('h-12');
  abort.classList.toggle('hidden');
  input.classList.toggle('border-r-2');
};

export function showButton() {
  if (confirm && input) {
    input.addEventListener('focus', toggle);
    input.addEventListener('blur', toggle);
    abort.addEventListener('click', (e) => {
      e.preventDefault();
      document.activeElement == null;
    });
  }
}
