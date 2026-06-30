document.addEventListener('DOMContentLoaded', () => {
    // Efek navbar saat user scroll.
    const navbar = document.querySelector('.navbar-glass');
    if (navbar) {
        const toggleNavbar = () => {
            navbar.classList.toggle('scrolled', window.scrollY > 40);
        };

        toggleNavbar();
        window.addEventListener('scroll', toggleNavbar, { passive: true });
    }

    // Modal trailer dengan kontrol iframe.
    const trailerButtons = document.querySelectorAll('[data-trailer-key]');
    const trailerFrame = document.getElementById('trailerFrame');
    const trailerModal = document.getElementById('trailerModal');

    trailerButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const key = button.getAttribute('data-trailer-key');
            if (trailerFrame && key) {
                trailerFrame.src = `https://www.youtube.com/embed/${key}?autoplay=1&rel=0`;
            }
        });
    });

    if (trailerModal && trailerFrame) {
        trailerModal.addEventListener('hidden.bs.modal', () => {
            trailerFrame.src = '';
        });
    }
});
