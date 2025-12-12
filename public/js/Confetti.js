// public/js/Confetti.js
const throwConfetti = () => {
    const colors = ['#dc2626', '#000000', '#ffffff']; // BULSCA red, black, white
    const confettiCount = 100;
    const container = document.createElement('div');
    container.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:9999';
    document.body.appendChild(container);

    for (let i = 0; i < confettiCount; i++) {
        const confetti = document.createElement('div');
        confetti.style.cssText = `
            position:absolute;
            width:${Math.random() * 10 + 5}px;
            height:${Math.random() * 10 + 5}px;
            background:${colors[Math.floor(Math.random() * colors.length)]};
            left:${Math.random() * 100}%;
            top:-10px;
            opacity:${Math.random()};
            transform:rotate(${Math.random() * 360}deg);
            animation:confettiFall ${Math.random() * 3 + 2}s linear forwards;
        `;
        container.appendChild(confetti);
    }

    const style = document.createElement('style');
    style.textContent = `
        @keyframes confettiFall {
            to {
                transform: translateY(100vh) rotate(${Math.random() * 720}deg);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    setTimeout(() => container.remove(), 5000);
};