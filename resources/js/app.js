/**
 * Rani Matrimonial - Anti-Inspection, Anti-Screenshot & Content Privacy Protection Suite
 */
(function() {
    'use strict';

    // Toast notification function
    let toastTimeout = null;
    function showPrivacyToast(message = ' Inspecting & copying are restricted on Rani Matrimonial.') {
        let toast = document.getElementById('rani-privacy-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'rani-privacy-toast';
            toast.style.cssText = `
                position: fixed;
                bottom: 24px;
                left: 50%;
                transform: translateX(-50%) translateY(100px);
                background: linear-gradient(135deg, #1a0000 0%, #4a0404 100%);
                color: #f9f1d8;
                border: 1px solid #d4af37;
                padding: 12px 24px;
                border-radius: 9999px;
                font-size: 13px;
                font-weight: 600;
                font-family: 'Outfit', sans-serif;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7), 0 0 15px rgba(212, 175, 55, 0.4);
                z-index: 9999999;
                pointer-events: none;
                transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
                opacity: 0;
                display: flex;
                align-items: center;
                gap: 8px;
            `;
            document.body.appendChild(toast);
        }

        toast.innerHTML = `<svg style="width:16px;height:16px;color:#d4af37;fill:currentColor;" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg> ${message}`;
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(-50%) translateY(0)';

        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(-50%) translateY(100px)';
            }
        }, 2500);
    }

    // Trigger momentary blur shield
    let shieldTimeout = null;
    function triggerPrivacyShield(duration = 1400, message = '🔒 Inspect & screenshots are restricted for privacy.') {
        document.body.classList.add('privacy-shield-active');
        showPrivacyToast(message);

        // Clear clipboard
        if (navigator.clipboard && navigator.clipboard.writeText) {
            try {
                navigator.clipboard.writeText('Protected Content - Rani Matrimonial');
            } catch (err) {}
        }

        clearTimeout(shieldTimeout);
        shieldTimeout = setTimeout(() => {
            document.body.classList.remove('privacy-shield-active');
        }, duration);
    }

    // ================= 1. ABSOLUTE RIGHT-CLICK BLOCK =================
    function blockContextMenu(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        showPrivacyToast('🔒 Right-click is restricted for candidate privacy & security.');
        return false;
    }

    window.addEventListener('contextmenu', blockContextMenu, { capture: true, passive: false });
    document.addEventListener('contextmenu', blockContextMenu, { capture: true, passive: false });
    document.documentElement.addEventListener('contextmenu', blockContextMenu, { capture: true, passive: false });
    document.oncontextmenu = function() { return false; };

    // ================= 2. PREVENT IMAGE / MEDIA DRAGGING =================
    document.addEventListener('dragstart', function(e) {
        e.preventDefault();
        e.stopPropagation();
        return false;
    }, { capture: true });

    // ================= 3. COMPREHENSIVE DEVTOOLS & INSPECT SHORTCUTS BLOCKER =================
    function blockInspectKeys(e) {
        const key = (e.key || '').toLowerCase();
        const code = e.code || '';
        const keyCode = e.keyCode || e.which;
        const ctrl = e.ctrlKey;
        const meta = e.metaKey; // Cmd on Mac
        const alt = e.altKey;   // Option on Mac
        const shift = e.shiftKey;

        // F12 (Windows / Linux Inspect)
        if (key === 'f12' || keyCode === 123 || code === 'F12') {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            showPrivacyToast('🔒 Developer Tools inspection is restricted.');
            return false;
        }

        // Shift + F10 / Shift + F12 (Context menu / Debugger)
        if (shift && (key === 'f10' || key === 'f12' || keyCode === 121 || keyCode === 123)) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }

        // Windows & Mac Developer Tools & Element Inspector:
        // - Ctrl + Shift + I (Inspect)
        // - Ctrl + Shift + J (Console)
        // - Ctrl + Shift + C (Inspect Element)
        // - Ctrl + Shift + K (Firefox Console)
        // - Ctrl + Shift + E (Firefox Network)
        // - Ctrl + Shift + M (Device Mode)
        // - Cmd + Option + I (Mac Chrome/Safari DevTools)
        // - Cmd + Option + J (Mac Chrome Console)
        // - Cmd + Option + C (Mac Inspect Element)
        // - Cmd + Option + U (Mac View Source)
        // - Cmd + Shift + C (Mac Inspect Element)
        // - Cmd + Shift + I (Mac DevTools)
        // - Cmd + Shift + J (Mac Console)
        const isInspectCombination = 
            // Windows / Linux Ctrl+Shift+...
            (ctrl && shift && ['i', 'j', 'c', 'k', 'e', 'm'].includes(key)) ||
            // Mac Cmd+Option+...
            (meta && alt && ['i', 'j', 'c', 'u', 'k', 'z'].includes(key)) ||
            // Mac Cmd+Shift+...
            (meta && shift && ['i', 'j', 'c', 'k', 'm'].includes(key)) ||
            // Ctrl+Shift keyCode fallback (73=I, 74=J, 67=C, 75=K, 69=E, 77=M)
            (ctrl && shift && [73, 74, 67, 75, 69, 77].includes(keyCode)) ||
            // Mac Cmd+Option keyCode fallback
            (meta && alt && [73, 74, 67, 85, 75, 90].includes(keyCode)) ||
            // Mac Cmd+Shift keyCode fallback
            (meta && shift && [73, 74, 67, 75, 77].includes(keyCode));

        if (isInspectCombination) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            triggerPrivacyShield(1200, 'Inspect Element is strictly restricted.');
            return false;
        }

        // View Source: Ctrl + U or Cmd + U
        if ((ctrl || meta) && (key === 'u' || keyCode === 85)) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            showPrivacyToast('Source code inspection is protected.');
            return false;
        }

        // Print: Ctrl + P or Cmd + P
        if ((ctrl || meta) && (key === 'p' || keyCode === 80)) {
            e.preventDefault();
            e.stopPropagation();
            triggerPrivacyShield(1200, 'Printing is restricted.');
            return false;
        }

        // Save Page: Ctrl + S or Cmd + S
        if ((ctrl || meta) && (key === 's' || keyCode === 83)) {
            e.preventDefault();
            e.stopPropagation();
            showPrivacyToast('Saving page offline is disabled.');
            return false;
        }

        // PrintScreen Key / Snipping tool
        if (
            key === 'printscreen' || code === 'PrintScreen' || keyCode === 44 ||
            (meta && shift && ['3', '4', '5', 's'].includes(key)) ||
            (ctrl && shift && key === 's')
        ) {
            e.preventDefault();
            e.stopPropagation();
            triggerPrivacyShield(1600, 'Screenshot blocked for candidate privacy.');
            return false;
        }
    }

    window.addEventListener('keydown', blockInspectKeys, { capture: true, passive: false });
    document.addEventListener('keydown', blockInspectKeys, { capture: true, passive: false });

    // ================= 4. ANTI-DEBUGGER TRAP (TEMPORARILY DISABLED FOR TESTING RESPONSIVENESS) =================
    let antiDebugActive = false;
    function runAntiDebugger() {
        if (!antiDebugActive) return;
        try {
            const start = performance.now();
            (function() {
                return false;
            }['constructor']('debugger')['call']());
            const duration = performance.now() - start;
            // If devtools paused execution, duration will be large
            if (duration > 100) {
                document.body.classList.add('privacy-shield-active');
            }
        } catch (e) {}
    }
    setInterval(runAntiDebugger, 250);

    // ================= 5. CONSOLE OVERWRITE =================
    try {
        if (window.console) {
            const noop = function() {};
            window.console.log = noop;
            window.console.warn = noop;
            window.console.info = noop;
            window.console.error = noop;
            window.console.table = noop;
            window.console.debug = noop;
        }
    } catch (e) {}

    // ================= 6. RESTRICT UNAUTHORIZED COPYING OUTSIDE INPUTS =================
    document.addEventListener('copy', function(e) {
        const target = e.target;
        if (target && (target.tagName === 'INPUT' || target.tagName === 'TEXTAREA' || target.isContentEditable)) {
            return true;
        }
        e.preventDefault();
        showPrivacyToast('🔒 Copying text & photos is protected.');
        return false;
    }, { capture: true });

})();
