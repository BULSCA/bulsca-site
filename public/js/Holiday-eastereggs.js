const addCornerImages = (images, containerId = null) => {
    const container = containerId ? document.getElementById(containerId) : document.body;
    if (!container) {
        console.error(`Container ${containerId} not found`);
        return;
    }

    // Validate input
    if (!Array.isArray(images) || images.length === 0) {
        console.error('addCornerImages requires an array of image configurations');
        return;
    }

    const positionStyles = {
        'top-left': 'top: 50px; left: 0;',
        'top-right': 'top: 40px; right: 0;',
        'bottom-left': 'bottom: 0; left: 0;',
        'bottom-right': 'bottom: 0; right: 0;'
    };

    images.forEach(config => {
        if (!config.url || !config.position) {
            console.warn('Skipping image config - missing url or position:', config);
            return;
        }

        if (!positionStyles[config.position]) {
            console.warn(`Invalid position "${config.position}". Use: top-left, top-right, bottom-left, bottom-right`);
            return;
        }

        const img = document.createElement('img');
        img.src = config.url;
        img.className = `corner-decoration-image ${config.position}`;
        img.style.cssText = `
            position: absolute;
            ${positionStyles[config.position]}
            max-width: ${config.maxWidth || '150px'};
            max-height: ${config.maxHeight || '150px'};
            pointer-events: none;
            z-index: ${config.zIndex || 999};
            opacity: ${config.opacity || 0.9};
        `;
        
        // Debug logging
        img.onload = () => {
            console.log(`✓ Corner image loaded at ${config.position}:`, config.url);
        };
        
        img.onerror = () => {
            console.error(`✗ Failed to load corner image at ${config.position}:`, config.url);
            console.log('Check if the file exists at:', window.location.origin + config.url);
        };
        
        container.appendChild(img);
    });

    // Make sure container has position relative
    if (containerId) {
        const containerPosition = window.getComputedStyle(container).position;
        if (containerPosition === 'static') {
            container.style.position = 'relative';
        }
    }
    
    console.log(`Corner images initialized (${images.length} images) on container:`, containerId || 'body');
};