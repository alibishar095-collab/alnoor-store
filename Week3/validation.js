// =============================================
// Alnoor Store – Form Validation
// BIT3208: Advanced Web Design and Development
// Week 3 – JavaScript Basics
// =============================================

// ── Helpers ──────────────────────────────────

function showError(id, show) {
    const el = document.getElementById(id);
    if (el) el.style.display = show ? 'block' : 'none';
}

function isValidEmail(email) {
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(email);
}

// ── Password strength checker ─────────────────

function checkStrength(password) {
    const bar  = document.getElementById('strengthBar');
    const text = document.getElementById('strengthText');
    if (!bar || !text) return;

    if (password.length === 0) {
        bar.style.width = '0%';
        bar.style.background = '#eee';
        text.textContent = '';
        return;
    }

    let score = 0;
    if (password.length >= 6)                        score++;
    if (password.length >= 10)                       score++;
    if (/[A-Z]/.test(password))                      score++;
    if (/[0-9]/.test(password))                      score++;
    if (/[^A-Za-z0-9]/.test(password))              score++;

    const levels = [
        { label: 'Very weak',  color: '#e74c3c', width: '20%' },
        { label: 'Weak',       color: '#e67e22', width: '40%' },
        { label: 'Fair',       color: '#f1c40f', width: '60%' },
        { label: 'Strong',     color: '#2ecc71', width: '80%' },
        { label: 'Very strong',color: '#1a7a3c', width: '100%' },
    ];

    const level = levels[Math.min(score - 1, 4)];
    bar.style.width    = level.width;
    bar.style.background = level.color;
    text.style.color   = level.color;
    text.textContent   = level.label;
}

// ── Login form validation ─────────────────────

const loginForm = document.getElementById('loginForm');

if (loginForm) {

    // Live password strength
    document.getElementById('password').addEventListener('input', function () {
        checkStrength(this.value);
    });

    // Show / hide password
    const togglePw = document.getElementById('togglePw');
    const pwField  = document.getElementById('password');

    if (togglePw && pwField) {
        togglePw.addEventListener('click', function () {
            const isHidden = pwField.type === 'password';
            pwField.type        = isHidden ? 'text' : 'password';
            togglePw.textContent = isHidden ? 'Hide' : 'Show';
        });
    }

    // Submit validation
    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const email    = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        let valid = true;

        // Email check
        if (!isValidEmail(email)) {
            showError('emailError', true);
            valid = false;
        } else {
            showError('emailError', false);
        }

        // Password check
        if (password.length < 6) {
            showError('passwordError', true);
            valid = false;
        } else {
            showError('passwordError', false);
        }

        if (valid) {
            // Passed — submit the form
            loginForm.submit();
        }
    });

    // Hide errors on input
    document.getElementById('email').addEventListener('input', function () {
        showError('emailError', false);
    });

    document.getElementById('password').addEventListener('input', function () {
        showError('passwordError', false);
    });
}

// ── Register form validation ──────────────────

const registerForm = document.getElementById('registerForm');

if (registerForm) {

    document.getElementById('reg_password').addEventListener('input', function () {
        checkStrength(this.value);
    });

    const toggleReg = document.getElementById('toggleRegPw');
    const regPw     = document.getElementById('reg_password');

    if (toggleReg && regPw) {
        toggleReg.addEventListener('click', function () {
            const isHidden = regPw.type === 'password';
            regPw.type           = isHidden ? 'text' : 'password';
            toggleReg.textContent = isHidden ? 'Hide' : 'Show';
        });
    }

    registerForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const name     = document.getElementById('reg_name').value.trim();
        const email    = document.getElementById('reg_email').value.trim();
        const password = document.getElementById('reg_password').value;
        const confirm  = document.getElementById('reg_confirm').value;

        let valid = true;

        if (name.length < 2) {
            showError('nameError', true);
            valid = false;
        } else { showError('nameError', false); }

        if (!isValidEmail(email)) {
            showError('regEmailError', true);
            valid = false;
        } else { showError('regEmailError', false); }

        if (password.length < 6) {
            showError('regPasswordError', true);
            valid = false;
        } else { showError('regPasswordError', false); }

        if (confirm !== password) {
            showError('confirmError', true);
            valid = false;
        } else { showError('confirmError', false); }

        if (valid) {
            registerForm.submit();
        }
    });

    // Clear errors on input
    ['reg_name','reg_email','reg_password','reg_confirm'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', function () {
            showError(id.replace('reg_', '') + 'Error', false);
            showError('reg' + id.charAt(0).toUpperCase() + id.slice(1) + 'Error', false);
            showError('confirmError', false);
            showError('regEmailError', false);
            showError('regPasswordError', false);
            showError('nameError', false);
        });
    });
}