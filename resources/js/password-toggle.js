document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        const targetId = button.getAttribute('data-password-toggle');
        const input = targetId ? document.getElementById(targetId) : null;

        if (!input) {
            return;
        }

        const eyeOpen = button.querySelector('[data-password-eye-open]');
        const eyeClosed = button.querySelector('[data-password-eye-closed]');

        const syncIcons = () => {
            const visible = input.type === 'text';

            if (eyeOpen) {
                eyeOpen.classList.toggle('hidden', visible);
            }

            if (eyeClosed) {
                eyeClosed.classList.toggle('hidden', !visible);
            }

            button.setAttribute('aria-label', visible ? 'Hide password' : 'Show password');
        };

        syncIcons();

        button.addEventListener('click', () => {
            input.type = input.type === 'password' ? 'text' : 'password';
            syncIcons();
        });
    });
});
