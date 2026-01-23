function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}


/**
 * Universal tab switching
 * @param {string} activeTab - Tab to activate
 * @param {Array} allTabs - Array of all tab names
 * @param {string} storageKey - Optional sessionStorage key
 */
function switchTab(activeTab, allTabs, storageKey = null) {
    if (storageKey) {
        sessionStorage.setItem(storageKey, activeTab);
    }

    allTabs.forEach(tab => {
        const tabBtn = document.getElementById('tab-' + tab);
        const tabContent = document.getElementById('content-' + tab);
        const tabFilter = document.getElementById('filter-' + tab);

        if (tabBtn) tabBtn.classList.remove('active');
        if (tabContent) tabContent.classList.add('hidden');
        if (tabFilter) tabFilter.classList.add('hidden');
    });

    const activeTabBtn = document.getElementById('tab-' + activeTab);
    const activeContent = document.getElementById('content-' + activeTab);
    const activeFilter = document.getElementById('filter-' + activeTab);

    if (activeTabBtn) activeTabBtn.classList.add('active');
    if (activeContent) activeContent.classList.remove('hidden');
    if (activeFilter) activeFilter.classList.remove('hidden');
}

/**
 * Universal delete confirmation
 * @param {Object} config - Configuration object
 * @param {string} config.type - Type of data (harian, bulanan, masuk, keluar, domestik)
 * @param {string} config.id - ID of item to delete
 * @param {string} config.label - Display label for item
 * @param {string} config.route - Delete route URL
 */
function confirmDelete(config) {
    const { type, id, label, route } = config;

    const itemNameEl = document.getElementById('deleteItemName');
    if (itemNameEl) {
        itemNameEl.textContent = label;
    }

    const form = document.getElementById('formDeleteConfirm');
    if (form) {
        form.action = route;
    }

    openModal('modalDeleteConfirm');
}

function autoHideAlerts(delay = 5000) {
    setTimeout(function () {
        const alerts = document.querySelectorAll('.alert, .alert-success, .alert-error, .alert-danger');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.3s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
                if (alert.parentElement) {
                    alert.remove();
                }
            }, 300);
        });
    }, delay);
}

function initModalClickOutside() {
    const modals = document.querySelectorAll('.modal-overlay');
    modals.forEach(modal => {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                const modalId = modal.id;
                closeModal(modalId);
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Auto-hide alerts
    autoHideAlerts(5000);

    // Init modal click outside
    initModalClickOutside();
});