{{-- Privacy & Protection Fallback Scripts --}}
<script>
(function() {
    'use strict';
    // Immediate fallback right-click restriction in case bundle is delayed
    function disableRightClick(e) {
        e.preventDefault();
        return false;
    }
    window.addEventListener('contextmenu', disableRightClick, { capture: true, passive: false });
    document.addEventListener('contextmenu', disableRightClick, { capture: true, passive: false });
    document.documentElement.addEventListener('contextmenu', disableRightClick, { capture: true, passive: false });
    document.oncontextmenu = function() { return false; };

    // Prevent image drag
    document.addEventListener('dragstart', function(e) {
        if (e.target && e.target.nodeName === 'IMG') {
            e.preventDefault();
            return false;
        }
    }, { capture: true });
})();
</script>

@yield('scripts')
@stack('scripts')
