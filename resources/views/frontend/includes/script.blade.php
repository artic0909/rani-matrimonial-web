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

// Photo Privacy Verification Engine
window.RaniPhotoPrivacy = {
    currentCandidate: @json(Auth::check() ? [
        'id' => Auth::id(),
        'candidate_code' => Auth::user()->candidate_code ?? null,
        'profile_id' => Auth::user()->profile_id ?? null,
        'is_bluetick_verified' => (bool)(Auth::user()->is_bluetick_verified ?? false),
        'selfie_verified' => (bool)(Auth::user()->selfie_verified ?? false),
    ] : null),

    shouldBlurProfilePhoto: function(targetCandidate) {
        if (!targetCandidate) return false;
        var viewer = this.currentCandidate;
        if (viewer) {
            var vId = viewer.id || viewer.candidate_code || viewer.profile_id;
            var tId = targetCandidate.id || targetCandidate.candidate_code || targetCandidate.profile_id;
            if (vId && tId && String(vId) === String(tId)) {
                return false;
            }
        }

        var privacy = targetCandidate.photo_privacy || 'Visible to all Members (Recommended)';
        if (privacy === 'Visible to all Members (Recommended)') {
            return false;
        }

        var isAccepted = !!targetCandidate.is_accepted || targetCandidate.request_type === 'accepted' || targetCandidate.status === 'accepted';
        var isReceived = !!targetCandidate.is_interest_received || targetCandidate.request_type === 'received' || targetCandidate.status === 'received';

        if (privacy === 'Visible only to Members I like') {
            return !isAccepted && !isReceived;
        }

        if (privacy === 'Visible to Members I like and to all Premium Members') {
            if (isAccepted || isReceived) return false;
            var isPremium = viewer && (viewer.is_bluetick_verified || viewer.selfie_verified);
            return !isPremium;
        }

        return false;
    },

    shouldBlurGalleryPhoto: function(targetCandidate, photoIndex) {
        if (!targetCandidate) return false;
        if (photoIndex === undefined || photoIndex === null || photoIndex === 0) {
            return this.shouldBlurProfilePhoto(targetCandidate);
        }
        var viewer = this.currentCandidate;
        if (viewer) {
            var vId = viewer.id || viewer.candidate_code || viewer.profile_id;
            var tId = targetCandidate.id || targetCandidate.candidate_code || targetCandidate.profile_id;
            if (vId && tId && String(vId) === String(tId)) {
                return false;
            }
        }

        var privacy = targetCandidate.album_privacy || 'Visible to all Members';
        if (privacy === 'Visible to all Members') {
            return false;
        }

        var isAccepted = !!targetCandidate.is_accepted || targetCandidate.request_type === 'accepted' || targetCandidate.status === 'accepted';

        if (privacy === 'Blur until request accepted' || privacy === 'Visible to all with request') {
            return !isAccepted;
        }

        if (privacy === 'Only visible to members I like') {
            var isReceived = !!targetCandidate.is_interest_received || targetCandidate.request_type === 'received' || targetCandidate.status === 'received';
            return !isAccepted && !isReceived;
        }

        if (privacy === 'Visible to Members I like and to all Premium Members') {
            if (isAccepted) return false;
            var isReceived = !!targetCandidate.is_interest_received || targetCandidate.request_type === 'received' || targetCandidate.status === 'received';
            if (isReceived) return false;
            var isPremium = viewer && (viewer.is_bluetick_verified || viewer.selfie_verified);
            return !isPremium;
        }

        return false;
    }
};
</script>

@yield('scripts')
@stack('scripts')
