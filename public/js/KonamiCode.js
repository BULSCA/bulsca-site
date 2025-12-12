// public/js/KonamiCode.js
let konamiCode = () => {
    const konamiSequence = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight'];
    let currentPosition = 0;

    document.addEventListener('keydown', (e) => {
        const key = e.key.toLowerCase();
        if (key === konamiSequence[currentPosition]) {
            currentPosition++;
            if (currentPosition === konamiSequence.length) {
                activateKonamiEasterEgg();
                currentPosition = 0;
            }
        } else {
            currentPosition = 0;
        }
    });
};

const activateKonamiEasterEgg = () => {
    // Add BULSCA logo rain
    console.log('🏊 BULSCA MODE ACTIVATED! 🏊');
    makeItRainLogos();
    // Or make all images spin
    // Or play a fun sound
};

const makeItRainLogos = () => {
    const logo = '/storage/logo/blogo.png';
    const container = document.createElement('div');
    container.style.position = 'fixed';
    container.style.top = '0';
    container.style.left = '0';
    container.style.width = '100%';
    container.style.height = '100%';
    container.style.pointerEvents = 'none';
    container.style.zIndex = '9999';
    document.body.appendChild(container);

    for (let i = 0; i < 50; i++) {
        setTimeout(() => {
            const img = document.createElement('img');
            img.src = logo;
            img.style.position = 'absolute';
            img.style.width = '50px';
            img.style.left = Math.random() * 100 + '%';
            img.style.top = '-50px';
            img.style.animation = 'fall 3s linear forwards';
            container.appendChild(img);

            setTimeout(() => img.remove(), 3000);
        }, i * 100);
    }

    const style = document.createElement('style');
    style.textContent = '@keyframes fall { to { transform: translateY(100vh) rotate(360deg); } }';
    document.head.appendChild(style);

    setTimeout(() => container.remove(), 5000);
};