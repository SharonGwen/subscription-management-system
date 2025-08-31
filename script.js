(function () {
  const q = new URLSearchParams(window.location.search);
  const msgBox = document.getElementById('msg');
  const success = q.get('success');
  const error = q.get('error');

  if (msgBox && (success || error)) {
    msgBox.classList.add('show');
    if (success) { msgBox.classList.add('success'); msgBox.textContent = success; }
    if (error)   { msgBox.classList.add('error');   msgBox.textContent = error; }
    // Clean the URL after showing
    window.history.replaceState({}, document.title, window.location.pathname);
  }

  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', (e) => {
      const username = loginForm.username.value.trim();
      const password = loginForm.password.value;

      if (username.length < 3) {
        e.preventDefault();
        showInline('Please enter a valid username (min 3 chars).');
        return;
      }
      if (password.length < 6) {
        e.preventDefault();
        showInline('Password must be at least 6 characters.');
        return;
      }
    });
  }

  const regForm = document.getElementById('registerForm');
  if (regForm) {
    regForm.addEventListener('submit', (e) => {
      const name = regForm.name.value.trim();
      const username = regForm.username.value.trim();
      const email = regForm.email.value.trim();
      const password = regForm.password.value;
      const confirm = regForm.confirm.value;

      if (name.length < 2) { e.preventDefault(); return showInline('Name must be at least 2 characters.'); }
      if (username.length < 3) { e.preventDefault(); return showInline('Username must be at least 3 characters.'); }
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { e.preventDefault(); return showInline('Enter a valid email.'); }
      if (password.length < 6) { e.preventDefault(); return showInline('Password must be at least 6 characters.'); }
      if (password !== confirm) { e.preventDefault(); return showInline('Passwords do not match.'); }
    });
  }

  function showInline(text) {
    if (!msgBox) return;
    msgBox.className = 'alert error show';
    msgBox.textContent = text;
  }
})();
