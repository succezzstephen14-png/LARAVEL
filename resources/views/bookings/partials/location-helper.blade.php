<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('useMyLocationBtn');
        const input = document.getElementById('location');
        if (!btn || !input || !('geolocation' in navigator)) return;

        btn.addEventListener('click', function() {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            navigator.geolocation.getCurrentPosition(function(pos) {
                const lat = pos.coords.latitude.toFixed(6);
                const lon = pos.coords.longitude.toFixed(6);
                input.value = `${lat}, ${lon}`;
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-location-arrow"></i>';
            }, function(err) {
                alert('Unable to get location: ' + err.message);
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-location-arrow"></i>';
            }, { enableHighAccuracy: true, timeout: 10000 });
        });
    });
</script>
