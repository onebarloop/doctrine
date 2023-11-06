const confirm = document.querySelector('.js-update-confirm');
const abort = document.querySelector('.js-update-abort');
const input = document.querySelector('.js-update-field');
const backBtn = document.querySelector('#js-back-btn');

const toggle = () => {
  confirm.classList.toggle('h-0');
  confirm.classList.toggle('h-12');
  abort.classList.toggle('hidden');
  input.classList.toggle('border-r-2');
};

export function showButton() {
  if (confirm && input) {
    backBtn.addEventListener('mousedown', (e) => {
      if (document.activeElement === input) {
        backBtn.click();
      }
    });
    input.addEventListener('focus', toggle);
    input.addEventListener('blur', toggle);
    input.addEventListener('keydown', (e) => {
      if (e.keyCode == 13) {
        e.preventDefault();
      }
    });

    abort.addEventListener('mousedown', () => {
      abort.click();
      document.activeElement.blur();
    });
  }
}
