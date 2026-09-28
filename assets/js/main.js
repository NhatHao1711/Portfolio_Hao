/**
 * Portfolio Hao - Pure Project Showcase Scripts
 * Features: Instant Category Filter, Real-time Search, Copy Link Toast
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Project Filter & Live Instant Search
    const searchInput = document.getElementById('projectSearch');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card');
    const resultsCountEl = document.getElementById('visibleCount');
    const emptyState = document.getElementById('emptyState');

    let currentCategory = 'all';
    let searchQuery = '';

    function filterProjects() {
        let visibleCount = 0;

        projectCards.forEach(card => {
            const category = card.dataset.category || '';
            const group = card.dataset.group || '';
            const title = card.querySelector('.project-title')?.textContent.toLowerCase() || '';
            const note = card.querySelector('.project-note')?.textContent.toLowerCase() || '';
            const client = card.querySelector('.project-client-name')?.textContent.toLowerCase() || '';
            const badge = card.querySelector('.project-badge-chip')?.textContent.toLowerCase() || '';

            const matchesCategory = currentCategory === 'all' || group === currentCategory || category.toLowerCase().includes(currentCategory);
            const matchesSearch = searchQuery === '' || 
                title.includes(searchQuery) || 
                note.includes(searchQuery) || 
                client.includes(searchQuery) || 
                category.toLowerCase().includes(searchQuery) ||
                badge.includes(searchQuery);

            if (matchesCategory && matchesSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (resultsCountEl) {
            resultsCountEl.textContent = visibleCount;
        }

        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    // Category button click
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentCategory = btn.dataset.filter;
            filterProjects();
        });
    });

    // Search input
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.trim().toLowerCase();
            filterProjects();
        });
    }

    // 2. Copy Project Link to Clipboard with Toast Notification
    const copyButtons = document.querySelectorAll('.btn-copy');
    copyButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const url = btn.dataset.url;
            if (!url || url === '#' || url === '') {
                showToast('Dự án này đang được cập nhật tên miền!');
                return;
            }

            navigator.clipboard.writeText(url).then(() => {
                showToast(`Đã sao chép liên kết: ${url}`);
                const origHtml = btn.innerHTML;
                btn.innerHTML = '<span>✓ Đã chép</span>';
                setTimeout(() => {
                    btn.innerHTML = origHtml;
                }, 2000);
            }).catch(() => {
                prompt('Copy link dự án:', url);
            });
        });
    });

    // 3. Toast Notification Utility
    function showToast(message) {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            <span>${message}</span>
        `;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }
});
