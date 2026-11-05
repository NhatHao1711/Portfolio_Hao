/**
 * Portfolio Hao — Mathias Adolfsson Inspired Creative Engine
 * Features:
 * - Fluid Mouse Wheel & Trackpad Physics (Continuous Lerp Interpolation)
 * - 3D Perspective Curved Carousel with Smooth Momentum & Snapping
 * - Dynamic Ambient Lighting matching active project accent
 * - Web Audio API Synthetic Haptic Sound FX
 * - Dual View Engine: 3D Stage & Bento Grid Index
 * - Real Website Screenshot Showcase
 * - Slide-out Dossier Drawer & Project Detail Inspector
 * - AJAX Contact Form & Copy Link Toast
 */

document.addEventListener('DOMContentLoaded', () => {
    // ================= 1. STATE & DATA INITIALIZATION =================
    const stageCards = Array.from(document.querySelectorAll('.stage-card'));
    const totalProjects = stageCards.length;
    
    // Virtual Scroll Physics Engine
    let currentPos = 0;       // Current interpolated position (float)
    let targetPos = 0;        // Target position driven by wheel / buttons (float)
    let is3DActive = true;    // Track if 3D Stage is current view
    let isAudioEnabled = localStorage.getItem('portfolio_audio') === 'true';
    let lastSnappedIndex = 0; // For triggering subtle audio & badge updates
    let snapTimeout = null;

    // DOM Elements
    const counterIndexEl = document.getElementById('counterIndex');
    const progressFillEl = document.getElementById('progressFill');
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const toggle3D = document.getElementById('toggle3D');
    const toggleGrid = document.getElementById('toggleGrid');
    const carouselStage = document.getElementById('carouselStage');
    const gridStage = document.getElementById('gridStage');
    const stageControls = document.getElementById('stageControls');
    const audioToggleBtn = document.getElementById('audioToggleBtn');
    const localTimeEl = document.getElementById('localTime');

    // Drawer & Modal
    const btnAbout = document.getElementById('btnAbout');
    const drawerBackdrop = document.getElementById('drawerBackdrop');
    const btnCloseDrawer = document.getElementById('btnCloseDrawer');
    const modalBackdrop = document.getElementById('modalBackdrop');
    const btnCloseModal = document.getElementById('btnCloseModal');

    // ================= 2. WEB AUDIO API SYNTHESIZER =================
    let audioCtx = null;

    function initAudio() {
        if (!audioCtx && (window.AudioContext || window.webkitAudioContext)) {
            const AudioContextClass = window.AudioContext || window.webkitAudioContext;
            audioCtx = new AudioContextClass();
        }
    }

    function playSound(type = 'click') {
        if (!isAudioEnabled) return;
        try {
            initAudio();
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }

            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            const now = audioCtx.currentTime;

            osc.connect(gain);
            gain.connect(audioCtx.destination);

            if (type === 'click') {
                osc.type = 'sine';
                osc.frequency.setValueAtTime(800, now);
                osc.frequency.exponentialRampToValueAtTime(300, now + 0.05);
                gain.gain.setValueAtTime(0.08, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.05);
                osc.start(now);
                osc.stop(now + 0.05);
            } else if (type === 'slide') {
                osc.type = 'sine';
                osc.frequency.setValueAtTime(320, now);
                osc.frequency.exponentialRampToValueAtTime(180, now + 0.09);
                gain.gain.setValueAtTime(0.04, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.09);
                osc.start(now);
                osc.stop(now + 0.09);
            } else if (type === 'success') {
                osc.type = 'sine';
                osc.frequency.setValueAtTime(523.25, now);
                osc.frequency.setValueAtTime(659.25, now + 0.08);
                gain.gain.setValueAtTime(0.08, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.22);
                osc.start(now);
                osc.stop(now + 0.22);
            }
        } catch (e) {
            // Audio policy fallback
        }
    }

    // Audio Toggle Action
    if (audioToggleBtn) {
        function updateAudioBtnUI() {
            if (isAudioEnabled) {
                audioToggleBtn.classList.add('active');
                audioToggleBtn.innerHTML = `
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                        <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                    </svg>
                    <span>SOUND ON</span>
                `;
            } else {
                audioToggleBtn.classList.remove('active');
                audioToggleBtn.innerHTML = `
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                        <line x1="23" y1="9" x2="17" y2="15"></line>
                        <line x1="17" y1="9" x2="23" y2="15"></line>
                    </svg>
                    <span>MUTED</span>
                `;
            }
        }
        updateAudioBtnUI();

        audioToggleBtn.addEventListener('click', () => {
            isAudioEnabled = !isAudioEnabled;
            localStorage.setItem('portfolio_audio', isAudioEnabled);
            updateAudioBtnUI();
            if (isAudioEnabled) playSound('click');
        });
    }

    // ================= 3. BUTTER-SMOOTH MOUSE WHEEL & RAF ENGINE =================
    function hexToRgb(hex) {
        let clean = (hex || '#00f0ff').replace('#', '');
        if (clean.length === 3) {
            clean = clean.split('').map(c => c + c).join('');
        }
        const num = parseInt(clean, 16);
        return `${(num >> 16) & 255}, ${(num >> 8) & 255}, ${num & 255}`;
    }

    function renderCarouselFrame() {
        if (!is3DActive || !stageCards.length) {
            requestAnimationFrame(renderCarouselFrame);
            return;
        }

        // Fluid Lerp Interpolation
        currentPos += (targetPos - currentPos) * 0.085;

        const isMobile = window.innerWidth <= 768;
        const spacing = isMobile ? 300 : 430;
        const rotFactor = isMobile ? 22 : 26;
        const depthFactor = isMobile ? 140 : 180;

        let closestIdx = 0;
        let minAbsDiff = Infinity;

        stageCards.forEach((card, i) => {
            // Circular wrapping calculation
            let diff = i - (currentPos % totalProjects);
            while (diff > totalProjects / 2) diff -= totalProjects;
            while (diff < -totalProjects / 2) diff += totalProjects;

            const absDiff = Math.abs(diff);

            if (absDiff < minAbsDiff) {
                minAbsDiff = absDiff;
                closestIdx = i;
            }

            if (absDiff > 2.3) {
                // Out of viewport - hide completely
                card.style.transform = `translate3d(${diff > 0 ? 1100 : -1100}px, 0, -600px) scale(0.4)`;
                card.style.opacity = '0';
                card.style.zIndex = '1';
                card.style.pointerEvents = 'none';
                card.classList.remove('is-active');
                return;
            }

            // Continuous 3D transforms
            const transX = diff * spacing;
            const transZ = -Math.pow(absDiff, 1.35) * depthFactor;
            const rotY = -diff * rotFactor;
            const scale = Math.max(0.45, 1 - absDiff * 0.15);
            
            // Continuous opacity curve
            let opacity = 1;
            if (absDiff > 0.4) {
                opacity = Math.max(0, 1 - (absDiff - 0.4) * 0.58);
            }

            card.style.transform = `translate3d(${transX.toFixed(2)}px, 0, ${transZ.toFixed(2)}px) rotateY(${rotY.toFixed(2)}deg) scale(${scale.toFixed(3)})`;
            card.style.opacity = opacity.toFixed(3);
            card.style.zIndex = Math.round(30 - absDiff * 10);
            card.style.pointerEvents = absDiff < 0.75 ? 'auto' : (absDiff < 1.4 ? 'auto' : 'none');

            if (absDiff < 0.45) {
                card.classList.add('is-active');
            } else {
                card.classList.remove('is-active');
            }
        });

        // Trigger updates when entering new active card zone
        if (closestIdx !== lastSnappedIndex && minAbsDiff < 0.3) {
            lastSnappedIndex = closestIdx;
            const activeCard = stageCards[closestIdx];
            if (activeCard) {
                const accent = activeCard.dataset.accent || '#00f0ff';
                document.documentElement.style.setProperty('--ambient-rgb', hexToRgb(accent));
                document.documentElement.style.setProperty('--active-accent', accent);
            }

            if (counterIndexEl) {
                counterIndexEl.textContent = String(closestIdx + 1).padStart(2, '0');
            }
            if (progressFillEl) {
                const pct = ((closestIdx + 1) / totalProjects) * 100;
                progressFillEl.style.width = `${pct}%`;
            }
            playSound('slide');
        }

        requestAnimationFrame(renderCarouselFrame);
    }

    // Start RAF Loop
    requestAnimationFrame(renderCarouselFrame);

    // ================= 4. MOUSE WHEEL SCROLL LISTENER =================
    window.addEventListener('wheel', (e) => {
        if (!is3DActive) return; // Allow normal page scroll in Grid mode

        // Check if cursor is inside open modal or drawer
        if (modalBackdrop.classList.contains('is-open') || drawerBackdrop.classList.contains('is-open')) {
            return;
        }

        // Prevent standard page vertical bounce
        e.preventDefault();

        // Normalize mouse wheel vs trackpad deltas
        let delta = e.deltaY;
        if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) {
            delta = e.deltaX;
        }

        // Smooth virtual scroll sensitivity
        targetPos += delta * 0.0032;

        // Auto-snap gently to nearest card after user pauses scrolling
        clearTimeout(snapTimeout);
        snapTimeout = setTimeout(() => {
            targetPos = Math.round(targetPos);
        }, 180);
    }, { passive: false });

    // Touch Swipe Gesture on Mobile
    let touchStartX = 0;
    let touchPrevX = 0;
    if (carouselStage) {
        carouselStage.addEventListener('touchstart', (e) => {
            if (e.target.closest('a, button')) return;
            touchStartX = e.touches[0].clientX;
            touchPrevX = touchStartX;
        }, { passive: true });

        carouselStage.addEventListener('touchmove', (e) => {
            if (!touchPrevX) return;
            const currentX = e.touches[0].clientX;
            const deltaX = touchPrevX - currentX;
            touchPrevX = currentX;
            targetPos += deltaX * 0.0045;
        }, { passive: true });

        carouselStage.addEventListener('touchend', () => {
            touchPrevX = 0;
            targetPos = Math.round(targetPos);
        });
    }

    // Click on neighbor card brings it to center smoothly
    stageCards.forEach((card, i) => {
        card.addEventListener('click', (e) => {
            if (e.target.closest('a, button, .btn-launch, .btn-icon-square')) return;
            
            let d = i - (Math.round(targetPos) % totalProjects);
            while (d > totalProjects / 2) d -= totalProjects;
            while (d < -totalProjects / 2) d += totalProjects;

            if (Math.abs(d) > 0.1) {
                targetPos = Math.round(targetPos) + d;
                playSound('click');
            }
        });
    });

    // Control Buttons (Smooth Increments)
    if (btnNext) {
        btnNext.addEventListener('click', () => {
            targetPos = Math.round(targetPos) + 1;
            playSound('click');
        });
    }

    if (btnPrev) {
        btnPrev.addEventListener('click', () => {
            targetPos = Math.round(targetPos) - 1;
            playSound('click');
        });
    }

    // Keyboard Navigation
    window.addEventListener('keydown', (e) => {
        if (modalBackdrop.classList.contains('is-open') || drawerBackdrop.classList.contains('is-open')) {
            if (e.key === 'Escape') {
                closeModal();
                closeDrawer();
            }
            return;
        }

        if (is3DActive) {
            if (e.key === 'ArrowRight' || e.key === 'PageDown') {
                targetPos = Math.round(targetPos) + 1;
                playSound('click');
            } else if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
                targetPos = Math.round(targetPos) - 1;
                playSound('click');
            }
        }
    });

    // ================= 5. DUAL VIEW ENGINE (3D STAGE vs BENTO GRID) =================
    if (toggle3D && toggleGrid) {
        toggle3D.addEventListener('click', () => {
            is3DActive = true;
            toggle3D.classList.add('active');
            toggleGrid.classList.remove('active');
            carouselStage.style.display = 'flex';
            if (stageControls) stageControls.style.display = 'flex';
            gridStage.classList.remove('is-active-view');
            playSound('click');
        });

        toggleGrid.addEventListener('click', () => {
            is3DActive = false;
            toggleGrid.classList.add('active');
            toggle3D.classList.remove('active');
            carouselStage.style.display = 'none';
            if (stageControls) stageControls.style.display = 'none';
            gridStage.classList.add('is-active-view');
            playSound('click');
        });
    }

    // Grid Filter & Search
    const gridSearchInput = document.getElementById('gridSearchInput');
    const gridFilterBtns = document.querySelectorAll('.grid-filter-btn');
    const bentoCards = document.querySelectorAll('.bento-card');

    let gridCategory = 'all';
    let gridQuery = '';

    function filterGrid() {
        bentoCards.forEach(card => {
            const group = card.dataset.group || '';
            const title = card.querySelector('.bento-title')?.textContent.toLowerCase() || '';
            const desc = card.querySelector('.bento-desc')?.textContent.toLowerCase() || '';
            const category = card.dataset.category?.toLowerCase() || '';

            const matchesCategory = gridCategory === 'all' || group === gridCategory || category.includes(gridCategory);
            const matchesQuery = gridQuery === '' || title.includes(gridQuery) || desc.includes(gridQuery) || category.includes(gridQuery);

            if (matchesCategory && matchesQuery) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    gridFilterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            gridFilterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            gridCategory = btn.dataset.filter;
            filterGrid();
            playSound('click');
        });
    });

    if (gridSearchInput) {
        gridSearchInput.addEventListener('input', (e) => {
            gridQuery = e.target.value.trim().toLowerCase();
            filterGrid();
        });
    }

    // ================= 6. PROJECT DETAIL INSPECTOR MODAL =================
    const modalTitle = document.getElementById('modalTitle');
    const modalCategory = document.getElementById('modalCategory');
    const modalVisual = document.getElementById('modalVisual');
    const modalClient = document.getElementById('modalClient');
    const modalType = document.getElementById('modalType');
    const modalYear = document.getElementById('modalYear');
    const modalTech = document.getElementById('modalTech');
    const modalNote = document.getElementById('modalNote');
    const modalBtnLaunch = document.getElementById('modalBtnLaunch');
    const modalBtnCopy = document.getElementById('modalBtnCopy');

    function openModalWithData(cardData) {
        if (!cardData) return;
        modalTitle.textContent = cardData.name;
        modalCategory.textContent = cardData.category;
        modalClient.textContent = cardData.client;
        modalType.textContent = cardData.type;
        modalYear.textContent = cardData.year || '2024';
        modalTech.textContent = cardData.tech || 'Web Architecture, UI/UX';
        modalNote.textContent = cardData.note;

        modalVisual.innerHTML = `
            <img src="${cardData.image}" alt="${cardData.name}">
        `;

        modalBtnLaunch.href = cardData.url;
        modalBtnCopy.dataset.url = cardData.url;

        modalBackdrop.classList.add('is-open');
        playSound('click');
    }

    function closeModal() {
        modalBackdrop.classList.remove('is-open');
        playSound('click');
    }

    if (btnCloseModal) btnCloseModal.addEventListener('click', closeModal);
    if (modalBackdrop) {
        modalBackdrop.addEventListener('click', (e) => {
            if (e.target === modalBackdrop) closeModal();
        });
    }

    // Trigger Modal from card "inspect" button
    document.querySelectorAll('.btn-inspect').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const card = btn.closest('.stage-card') || btn.closest('.bento-card');
            if (card) {
                const data = {
                    name: card.dataset.name,
                    category: card.dataset.category,
                    client: card.dataset.client,
                    type: card.dataset.type,
                    year: card.dataset.year,
                    tech: card.dataset.tech,
                    note: card.dataset.note,
                    url: card.dataset.url,
                    accent: card.dataset.accent,
                    gradient: card.dataset.gradient,
                    image: card.dataset.image
                };
                openModalWithData(data);
            }
        });
    });

    // ================= 7. ABOUT / DOSSIER SLIDE DRAWER =================
    function openDrawer() {
        drawerBackdrop.classList.add('is-open');
        playSound('click');
    }

    function closeDrawer() {
        drawerBackdrop.classList.remove('is-open');
        playSound('click');
    }

    if (btnAbout) btnAbout.addEventListener('click', openDrawer);
    if (btnCloseDrawer) btnCloseDrawer.addEventListener('click', closeDrawer);
    if (drawerBackdrop) {
        drawerBackdrop.addEventListener('click', (e) => {
            if (e.target === drawerBackdrop) closeDrawer();
        });
    }

    // ================= 8. COPY LINK UTILITY & TOAST =================
    function showToast(message) {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'toast-item';
        toast.innerHTML = `
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#00f0ff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <span>${message}</span>
        `;
        container.appendChild(toast);

        requestAnimationFrame(() => toast.classList.add('show'));
        playSound('success');

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        }, 2800);
    }

    document.querySelectorAll('.btn-copy').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const url = btn.dataset.url;
            if (!url || url === '#' || url === '') {
                showToast('Dự án này đang được cập nhật tên miền!');
                return;
            }

            navigator.clipboard.writeText(url).then(() => {
                showToast(`Đã sao chép: ${url}`);
            }).catch(() => {
                prompt('Copy link dự án:', url);
            });
        });
    });

    // ================= 9. AJAX CONTACT FORM SUBMISSION =================
    const contactForm = document.getElementById('contactForm');
    const contactFeedback = document.getElementById('contactFeedback');

    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(contactForm);
            formData.append('action', 'submit_contact');

            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const origText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'ĐANG GỬI TIN NHẮN...';

            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.textContent = origText;
                if (data.success) {
                    contactFeedback.style.display = 'block';
                    contactFeedback.style.color = '#10b981';
                    contactFeedback.textContent = data.message;
                    contactForm.reset();
                    showToast('Cảm ơn bạn! Tin nhắn đã được gửi thành công.');
                } else {
                    contactFeedback.style.display = 'block';
                    contactFeedback.style.color = '#ef4444';
                    contactFeedback.textContent = data.message || 'Có lỗi xảy ra, vui lòng thử lại.';
                }
            })
            .catch(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = origText;
                contactFeedback.style.display = 'block';
                contactFeedback.style.color = '#ef4444';
                contactFeedback.textContent = 'Lỗi kết nối máy chủ, vui lòng thử lại sau.';
            });
        });
    }

    // ================= 10. REAL-TIME SAIGON TIME CLOCK =================
    function updateClock() {
        if (!localTimeEl) return;
        const now = new Date();
        const options = { timeZone: 'Asia/Ho_Chi_Minh', hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit' };
        const timeString = now.toLocaleTimeString('en-US', options);
        localTimeEl.textContent = `SAIGON // ${timeString} (GMT+7)`;
    }
    updateClock();
    setInterval(updateClock, 1000);
});
