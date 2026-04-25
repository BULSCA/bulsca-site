<a href="#" class="maps-link" data-address="{{ $event->address }}">
    📍 {{ $event->address }}
</a>

<script>
document.querySelectorAll('.maps-link').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        const address = encodeURIComponent(link.dataset.address);
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
        const url = isIOS
            ? `maps://maps.apple.com/?q=${address}`
            : `https://www.google.com/maps/search/?api=1&query=${address}`;
        window.open(url, '_blank');
    });
});
</script>