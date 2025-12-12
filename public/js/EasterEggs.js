const addEasterEggCorners = (containerId = null) => {
    const container = containerId ? document.getElementById(containerId) : document.body;
    if (!container) {
        console.error(`Container ${containerId} not found`);
        return;
    }

    // Easter egg emojis
    const eggs = ['🥚', '🐰', '🐣', '🌷', '🌸'];
    
    // Create corner decorations
    const corners = [
        { class: 'bottom-left', style: 'bottom: 0; left: 0;' },
        { class: 'bottom-right', style: 'bottom: 0; right: 0;' },
        { class: 'top-left', style: 'top: 0; left: 0;' },
        { class: 'top-right', style: 'top: 0; right: 0;' }
    ];

    corners.forEach(corner => {
        const pile = document.createElement('div');
        pile.className = `easter-egg-pile ${corner.class}`;
        pile.style.cssText = `
            position: absolute;
            ${corner.style}
            font-size: 24px;
            pointer-events: none;
            z-index: 999;
            display: flex;
            flex-wrap: wrap;
            ${corner.class.includes('left') ? 'padding-left: 10px;' : 'padding-right: 10px;'}
            ${corner.class.includes('top') ? 'padding-top: 10px;' : 'padding-bottom: 10px;'}
            ${corner.class.includes('right') ? 'justify-content: flex-end;' : ''}
            ${corner.class.includes('bottom') ? 'align-items: flex-end;' : ''}
            max-width: 150px;
            opacity: 0.8;
        `;

        // Add 5-8 random eggs to each corner
        const eggCount = Math.floor(Math.random() * 4) + 5;
        for (let i = 0; i < eggCount; i++) {
            const egg = document.createElement('span');
            egg.textContent = eggs[Math.floor(Math.random() * eggs.length)];
            egg.style.cssText = `
                display: inline-block;
                margin: 2px;
                transform: rotate(${Math.random() * 40 - 20}deg);
            `;
            pile.appendChild(egg);
        }

        container.appendChild(pile);
    });

    // Make sure container has position relative
    if (containerId) {
        const containerPosition = window.getComputedStyle(container).position;
        if (containerPosition === 'static') {
            container.style.position = 'relative';
        }
    }
};