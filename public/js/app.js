/**
 * AcmeCRM — Main JavaScript
 */

(function () {
    'use strict';

    /* -------------------------------------------------------
       Theme (Dark / Light)
    ------------------------------------------------------- */
    function applyTheme() {
        const stored = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (stored === 'dark' || (!stored && prefersDark)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }

    // Apply immediately to avoid FOUC
    applyTheme();

    document.addEventListener('DOMContentLoaded', function () {

        /* ---------------------------------------------------
           Lucide Icons init
        --------------------------------------------------- */
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        /* ---------------------------------------------------
           Global Dropdown Management
        --------------------------------------------------- */
        window.toggleDropdown = function (id) {
            const el = document.getElementById(id);
            if (!el) return;

            // Close other dropdowns that might be open
            const dropdowns = document.querySelectorAll('[id$="Dropdown"]');
            dropdowns.forEach(d => {
                if (d.id !== id) d.classList.add('hidden');
            });

            el.classList.toggle('hidden');
            if (window.lucide) setTimeout(() => lucide.createIcons(), 10);
        };

        // Click outside to close dropdowns
        document.addEventListener('click', function (e) {
            const dropdowns = document.querySelectorAll('[id$="Dropdown"]');
            dropdowns.forEach(dd => {
                if (!dd.classList.contains('hidden')) {
                    // Find the button that toggles this dropdown (convention: id starts with "btn" and matches dropdown name)
                    // Or just use a smarter check: if click is NOT inside the dropdown AND NOT inside a button that toggles it.
                    const isClickInsideDropdown = dd.contains(e.target);
                    const isClickInsideTrigger = e.target.closest('[onclick^="toggleDropdown"]');

                    if (!isClickInsideDropdown && !isClickInsideTrigger) {
                        dd.classList.add('hidden');
                    }
                }
            });
        });

        /* ---------------------------------------------------
           Auto-dismiss alerts
        --------------------------------------------------- */
        const alerts = document.querySelectorAll('[data-auto-dismiss]');
        alerts.forEach(function (alert) {
            const delay = parseInt(alert.dataset.autoDismiss, 10) || 4000;
            setTimeout(function () {
                alert.style.transition = 'opacity 0.4s ease';
                alert.style.opacity = '0';
                setTimeout(function () { alert.remove(); }, 400);
            }, delay);
        });

        /* ---------------------------------------------------
           Ctrl+K — focus search
        --------------------------------------------------- */
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                const searchInput = document.querySelector('input[placeholder*="Search"]');
                if (searchInput) searchInput.focus();
            }
        });

        /* ---------------------------------------------------
           Form confirmation (data-confirm attribute)
        --------------------------------------------------- */
        document.querySelectorAll('form[data-confirm]').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const confirmMessage = form.dataset.confirm;

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: confirmMessage,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Cancel',
                        padding: '2rem',
                        borderRadius: '1.5rem',
                        customClass: {
                            title: 'text-2xl font-black text-slate-800 dark:text-white',
                            htmlContainer: 'text-sm font-medium text-slate-500 dark:text-slate-400 mt-2',
                            confirmButton: 'px-8 py-3 rounded-xl font-black text-sm uppercase tracking-widest',
                            cancelButton: 'px-8 py-3 rounded-xl font-black text-sm uppercase tracking-widest'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else {
                    if (window.confirm(confirmMessage)) {
                        form.submit();
                    }
                }
            });
        });
    });

    /* ---------------------------------------------------
       High-Fidelity Toast System (Toastr integration)
    --------------------------------------------------- */
    window.showToast = function (message, type = 'success', duration = 4000) {
        if (typeof toastr !== 'undefined') {
            toastr[type === 'error' ? 'error' : (type === 'success' ? 'success' : 'info')](message);
        } else {
            // ... fallback logic if needed
            alert(message);
        }
    };

    // Global override for generic JS alerts to use Toastr instead of native browser popup.
    window.alert = function (message) {
        if (typeof toastr !== 'undefined') {
            toastr.info(message);
        } else {
            console.log("Alert Intercepted: " + message);
        }
    };

    /* ---------------------------------------------------
       Global Export Logic
    --------------------------------------------------- */
    window.exportReport = function (format = 'CSV', source = 'Report') {
        // Show initial progress toast
        const progressToast = document.createElement('div');
        progressToast.className = `fixed bottom-8 right-8 px-8 py-4 bg-slate-800 text-white rounded-[1.5rem] font-black text-sm shadow-2xl z-[999] animate-in fade-in slide-in-from-bottom-4 duration-300 flex items-center gap-4`;
        progressToast.innerHTML = `
            <div class="w-5 h-5 border-2 border-indigo-400 border-t-transparent rounded-full animate-spin"></div>
            <span>Preparing ${source} (${format})...</span>
        `;
        document.body.appendChild(progressToast);

        // Simulate preparation delay
        setTimeout(() => {
            if (progressToast && progressToast.parentNode) progressToast.remove();
            window.showToast(`${source} exported as ${format} successfully! ✨`);

            // Simulate file download
            console.log(`[Static Demo] Downloading ${source}.${format.toLowerCase()}`);
        }, 1500);
    };

    // Legacy Support Aliases
    window.exportData = window.exportReport;
    window.toggleExportDropdown = function () { window.toggleDropdown('exportDropdown'); };

    /* ---------------------------------------------------
       Global SweetAlert2 Delete Handler
    --------------------------------------------------- */
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.swal-delete');
        if (!btn) return;

        e.preventDefault();
        const formId = btn.dataset.formId;
        const form = document.getElementById(formId);
        const name = btn.dataset.name || 'this item';

        if (!form) return;

        if (typeof Swal === 'undefined') {
            if (confirm(`Are you sure you want to delete ${name}?`)) {
                form.submit();
            }
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete ${name}. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48', // rose-600
            cancelButtonColor: '#64748b', // slate-500
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            padding: '2rem',
            borderRadius: '1.5rem',
            customClass: {
                title: 'text-2xl font-black text-slate-800 dark:text-white',
                htmlContainer: 'text-sm font-medium text-slate-500 dark:text-slate-400 mt-2',
                confirmButton: 'px-8 py-3 rounded-xl font-black text-sm uppercase tracking-widest',
                cancelButton: 'px-8 py-3 rounded-xl font-black text-sm uppercase tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

})();
