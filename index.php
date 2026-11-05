<?php
require_once __DIR__ . '/config.php';
$projects = get_all_projects();
$total_projects = count($projects);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trương Huy Nhật Hào — Web Developer</title>
    
    <!-- Meta SEO Tags -->
    <meta name="description" content="Portfolio Trương Huy Nhật Hào - Web Developer tốt nghiệp Đại học Công Nghệ TP.HCM (HUTECH). Chuyên sâu WordPress (Custom Theme & WooCommerce), PHP, Frontend và tối ưu hiệu năng website.">
    <meta name="keywords" content="Portfolio Hào, Trương Huy Nhật Hào, Web Developer, WordPress Developer, PHP, Frontend, HUTECH">
    <meta name="author" content="Trương Huy Nhật Hào">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Trương Huy Nhật Hào — Web Developer">
    <meta property="og:description" content="Showcase 9 dự án tiêu biểu với hình ảnh thực tế và phong cách 3D cinematic sáng tạo.">
    <meta property="og:type" content="website">
    
    <!-- Performance Preconnect & Optimized Fonts -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500&family=Outfit:wght@700;800&family=Plus+Jakarta+Sans:wght@400;600&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Ambient Glow & Stage Effects -->
    <div class="ambient-bg" aria-hidden="true">
        <div class="ambient-glow-1"></div>
        <div class="ambient-glow-2"></div>
        <div class="ambient-grid"></div>
        <div class="ambient-noise"></div>
    </div>

    <!-- ================= TOP NAVIGATION BAR ================= -->
    <header class="site-nav">
        <a href="./" class="nav-brand">
            <div class="brand-symbol">NH</div>
            <div class="brand-info">
                <span class="brand-name">NHẬT HÀO</span>
                <span class="brand-role">WEB DEVELOPER</span>
            </div>
        </a>

        <div class="nav-center">
            <div class="status-badge">
                <span class="status-pulse"></span>
                <span>AVAILABLE FOR WORK</span>
            </div>
            <div class="local-time" id="localTime">
                SAIGON // 00:00:00 (GMT+7)
            </div>
        </div>

        <div class="nav-actions">
            <!-- Sound FX Toggle Button -->
            <button class="btn-nav" id="audioToggleBtn" title="Bật/Tắt âm thanh tương tác">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                </svg>
                <span>SOUND</span>
            </button>

            <!-- About & Contact Button -->
            <button class="btn-nav primary" id="btnAbout">
                <span>INFO / ABOUT</span>
                <span style="font-family:'Space Grotesk',sans-serif; font-weight:700;">[i]</span>
            </button>
        </div>
    </header>


    <!-- ================= MAIN SHOWCASE STAGE ================= -->
    <main class="main-stage-wrapper">

        <!-- Stage Header Metadata -->
        <div class="stage-meta">
            <h1 class="stage-title">
                <span>SELECTED WORKS</span>
                <span style="color: var(--accent-cyan); font-family: 'JetBrains Mono', monospace; font-size: 18px;">[<?= str_pad($total_projects, 2, '0', STR_PAD_LEFT) ?>]</span>
            </h1>
            <p class="stage-tagline">INTERACTIVE 3D PERSPECTIVE // CRAFTED EXPERIENCES</p>
        </div>

        <!-- View Mode Switcher -->
        <div class="stage-view-toggle">
            <button class="toggle-opt active" id="toggle3D">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
                <span>3D STAGE</span>
            </button>
            <button class="toggle-opt" id="toggleGrid">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span>GRID INDEX</span>
            </button>
        </div>

        <!-- ================= 3D PERSPECTIVE CAROUSEL STAGE ================= -->
        <div class="carousel-stage" id="carouselStage">
            <div class="carousel-track" id="carouselTrack">
                <?php foreach ($projects as $idx => $p): 
                    $indexFormatted = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
                    $domain = parse_url($p['url'], PHP_URL_HOST);
                    if (!$domain) $domain = str_replace(['https://', 'http://', '/'], '', $p['url']);
                    $accentColor = $p['accent'] ?? '#00f0ff';
                    $bgGradient = $p['gradient'] ?? 'linear-gradient(135deg, #09090b, #18181b)';
                    $imagePath = $p['image'] ?? ('assets/images/projects/project_' . $p['id'] . '.jpg');
                ?>
                <article class="stage-card" 
                         id="card-<?= $idx ?>"
                         data-index="<?= $idx ?>"
                         data-name="<?= htmlspecialchars($p['name']) ?>"
                         data-category="<?= htmlspecialchars($p['category']) ?>"
                         data-group="<?= htmlspecialchars($p['group_tag']) ?>"
                         data-client="<?= htmlspecialchars($p['client']) ?>"
                         data-type="<?= htmlspecialchars($p['type']) ?>"
                         data-year="<?= htmlspecialchars($p['year'] ?? '2024') ?>"
                         data-tech="<?= htmlspecialchars($p['tech'] ?? 'Modern Web') ?>"
                         data-note="<?= htmlspecialchars($p['note']) ?>"
                         data-url="<?= htmlspecialchars($p['url']) ?>"
                         data-accent="<?= htmlspecialchars($accentColor) ?>"
                         data-gradient="<?= htmlspecialchars($bgGradient) ?>"
                         data-image="<?= htmlspecialchars($imagePath) ?>">
                    
                    <!-- Visual Mockup Top Banner with Screenshot -->
                    <div class="card-visual-banner">
                        <img src="<?= htmlspecialchars($imagePath) ?>" 
                             alt="<?= htmlspecialchars($p['name']) ?>" 
                             class="card-screenshot-img" 
                             width="800"
                             height="500"
                             decoding="async"
                             <?= $idx < 2 ? 'fetchpriority="high"' : 'loading="lazy"' ?>>

                        <!-- Top Bar inside Mockup -->
                        <div class="banner-top-bar">
                            <div class="mockup-controls">
                                <span class="control-dot red"></span>
                                <span class="control-dot yellow"></span>
                                <span class="control-dot green"></span>
                                <span class="mockup-domain"><?= htmlspecialchars($domain) ?></span>
                            </div>
                        </div>

                        <!-- Bottom Numbers inside Mockup -->
                        <div class="banner-bottom-meta">
                            <span class="banner-index-num"><?= $indexFormatted ?></span>
                        </div>
                    </div>

                    <!-- Card Body Content -->
                    <div class="card-content-body">
                        <div>
                            <h2 class="card-title"><?= htmlspecialchars($p['name']) ?></h2>
                            <p class="card-desc"><?= htmlspecialchars($p['note']) ?></p>
                        </div>

                        <!-- Card Action Buttons -->
                        <div class="card-action-bar">
                            <a href="<?= htmlspecialchars($p['url']) ?>" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="btn-launch"
                               title="Mở trực tiếp website">
                                <span>TRUY CẬP WEBSITE</span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7"></line>
                                    <polyline points="7 7 17 7 17 17"></polyline>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ================= STAGE NAVIGATION CONTROLS ================= -->
        <div class="stage-controls" id="stageControls">
            <div class="controls-left">
                <button class="stage-arrow-btn" id="btnPrev" title="Dự án trước [Phím Mũi tên Trái]">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </button>
            </div>

            <div class="controls-center">
                <span class="counter-index" id="counterIndex">01</span>
                <div class="stage-progress-track">
                    <div class="stage-progress-fill" id="progressFill"></div>
                </div>
                <span class="counter-total"><?= str_pad($total_projects, 2, '0', STR_PAD_LEFT) ?></span>
            </div>

            <div class="controls-right" style="display: flex; align-items: center; gap: 14px;">
                <div class="scroll-hint">
                    <span class="scroll-icon-wheel"></span>
                    <span>CUỘN CHUỘT</span>
                </div>
                <button class="stage-arrow-btn" id="btnNext" title="Dự án kế tiếp [Phím Mũi tên Phải]">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>
            </div>
        </div>

        <!-- ================= GRID SHOWROOM VIEW (EDITORIAL) ================= -->
        <section class="grid-stage" id="gridStage">
            <div class="grid-filter-bar">
                <div class="grid-search-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="gridSearchInput" class="grid-search-input" placeholder="Tìm kiếm nhanh dự án theo tên hoặc từ khóa...">
                </div>
            </div>

            <div class="bento-projects-grid">
                <?php foreach ($projects as $idx => $p): 
                    $accentColor = $p['accent'] ?? '#00f0ff';
                    $bgGradient = $p['gradient'] ?? 'linear-gradient(135deg, #09090b, #18181b)';
                    $imagePath = $p['image'] ?? ('assets/images/projects/project_' . $p['id'] . '.jpg');
                ?>
                <div class="bento-card"
                     data-name="<?= htmlspecialchars($p['name']) ?>"
                     data-category="<?= htmlspecialchars($p['category']) ?>"
                     data-group="<?= htmlspecialchars($p['group_tag']) ?>"
                     data-client="<?= htmlspecialchars($p['client']) ?>"
                     data-type="<?= htmlspecialchars($p['type']) ?>"
                     data-year="<?= htmlspecialchars($p['year'] ?? '2024') ?>"
                     data-tech="<?= htmlspecialchars($p['tech'] ?? 'Modern Web') ?>"
                     data-note="<?= htmlspecialchars($p['note']) ?>"
                     data-url="<?= htmlspecialchars($p['url']) ?>"
                     data-accent="<?= htmlspecialchars($accentColor) ?>"
                     data-gradient="<?= htmlspecialchars($bgGradient) ?>"
                     data-image="<?= htmlspecialchars($imagePath) ?>">
                    
                    <div class="bento-visual">
                        <img src="<?= htmlspecialchars($imagePath) ?>" 
                             alt="<?= htmlspecialchars($p['name']) ?>" 
                             class="card-screenshot-img" 
                             width="800"
                             height="500"
                             decoding="async"
                             <?= $idx < 2 ? 'fetchpriority="high"' : 'loading="lazy"' ?>>
                    </div>

                    <div class="bento-body">
                        <div>
                            <h3 class="bento-title"><?= htmlspecialchars($p['name']) ?></h3>
                            <p class="bento-desc"><?= htmlspecialchars($p['note']) ?></p>
                        </div>

                        <div class="card-action-bar" style="margin-top: 14px;">
                            <a href="<?= htmlspecialchars($p['url']) ?>" target="_blank" rel="noopener noreferrer" class="btn-launch">
                                <span>TRUY CẬP WEBSITE</span>
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7"></line>
                                    <polyline points="7 7 17 7 17 17"></polyline>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

    </main>


    <!-- ================= ABOUT / DOSSIER SLIDE-OUT DRAWER ================= -->
    <div class="drawer-backdrop" id="drawerBackdrop">
        <aside class="about-drawer" aria-label="Hồ sơ năng lực & Thông tin cá nhân">
            <div class="drawer-header">
                <span class="drawer-title">PROFILE // TRƯƠNG HUY NHẬT HÀO</span>
                <button class="btn-close-drawer" id="btnCloseDrawer" title="Đóng">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="drawer-body">
                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="profile-avatar">NH</div>
                    <div>
                        <h2 class="profile-name">Trương Huy Nhật Hào</h2>
                        <p class="profile-title">WEB DEVELOPER</p>
                    </div>
                </div>

                <!-- Quick Contact Info Grid -->
                <div class="contact-quick-grid">
                    <a href="tel:0898245387" class="contact-quick-item" title="Gọi điện thoại">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <span>0898 245 387</span>
                    </a>

                    <a href="mailto:truonghuynhathao@gmail.com" class="contact-quick-item" title="Gửi email">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">truonghuynhathao@gmail.com</span>
                    </a>

                    <div class="contact-quick-item">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Thủ Đức, TP.HCM</span>
                    </div>

                    <a href="https://github.com/NhatHao1711" target="_blank" rel="noopener noreferrer" class="contact-quick-item" title="Xem GitHub">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                        </svg>
                        <span>github.com/NhatHao1711</span>
                    </a>
                </div>

                <!-- Tóm tắt chuyên môn -->
                <div>
                    <span class="section-label">// TÓM TẮT CHUYÊN MÔN</span>
                    <p class="about-bio">
                        Cử nhân Công nghệ Thông tin tốt nghiệp Đại học Công Nghệ TP.HCM (HUTECH) với định hướng chuyên sâu về Lập trình Web và Phát triển phần mềm. Đã có kinh nghiệm thực tế thiết kế, phát triển và tối ưu website doanh nghiệp / E-commerce (WordPress, PHP, Frontend), cùng kỹ năng quản trị hosting, tên miền và CSDL. Mong muốn đóng góp chuyên môn để tạo ra các sản phẩm chất lượng cao cho doanh nghiệp.
                    </p>
                </div>

                <!-- Kinh nghiệm làm việc -->
                <div>
                    <span class="section-label">// KINH NGHIỆM LÀM VIỆC</span>
                    <div class="experience-timeline">
                        <div class="exp-item">
                            <div class="exp-header">
                                <span class="exp-role">Web Developer</span>
                                <span class="exp-time">01/2026 – 07/2026</span>
                            </div>
                            <span class="exp-company">CÔNG TY TNHH MTSOLUTIONS</span>
                            <p class="exp-desc">
                                • Trực tiếp tham gia thiết kế, xây dựng và tùy biến giao diện website cho khách hàng doanh nghiệp và sàn thương mại điện tử trên nền tảng WordPress (Custom Theme & WooCommerce).<br>
                                • Tối ưu hóa tốc độ tải trang, nâng cao trải nghiệm người dùng (UX/UI) và đảm bảo tính tương thích đa nền tảng trên mọi thiết bị.<br>
                                • Quản trị hệ thống: cấu hình web hosting, cPanel, trỏ DNS/tên miền, kết nối và backup cơ sở dữ liệu MySQL định kỳ.
                            </p>
                        </div>

                        <div class="exp-item">
                            <div class="exp-header">
                                <span class="exp-role">Frontend Developer Intern</span>
                                <span class="exp-time">11/2024 – 01/2025</span>
                            </div>
                            <span class="exp-company">CÔNG TY TNHH MMTeck</span>
                            <p class="exp-desc">
                                • Phối hợp cùng đội ngũ phát triển chuyển đổi các bản thiết kế UI thành giao diện web chuẩn sử dụng HTML5, CSS3 và JavaScript.<br>
                                • Học hỏi và áp dụng quy trình kiểm soát phiên bản bằng GitHub trong môi trường dự án thực tế.
                            </p>
                        </div>

                        <div class="exp-item">
                            <div class="exp-header">
                                <span class="exp-role">IT Intern</span>
                                <span class="exp-time">05/2023 – 06/2023</span>
                            </div>
                            <span class="exp-company">ITSTARVN</span>
                            <p class="exp-desc">
                                • Hỗ trợ chuẩn hóa, rà soát và nhập liệu dữ liệu dự án vào hệ thống cơ sở dữ liệu nội bộ.<br>
                                • Phối hợp cùng các thành viên trong nhóm nghiên cứu tài liệu kỹ thuật, quy trình vận hành và báo cáo tiến độ công việc.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Học vấn & Chứng chỉ -->
                <div>
                    <span class="section-label">// HỌC VẤN & NGOẠI NGỮ</span>
                    <div class="edu-card">
                        <div class="edu-school">TRƯỜNG ĐẠI HỌC CÔNG NGHỆ TP.HCM (HUTECH)</div>
                        <div class="edu-meta">Cử nhân Công Nghệ Thông tin (2022 – 2026) • Viện Công nghệ Việt - Hàn • GPA: 7.0/10</div>
                        <div class="edu-badges-row">
                            <span class="edu-badge">Google for Education: Gemini Certified</span>
                            <span class="edu-badge">Tiếng Hàn: TOPIK Level 3</span>
                            <span class="edu-badge">Tiếng Anh: TOEIC 550</span>
                        </div>
                    </div>
                </div>

                <!-- Kỹ năng chuyên môn -->
                <div>
                    <span class="section-label">// KỸ NĂNG CHUYÊN MÔN</span>
                    <div class="skills-cloud">
                        <span class="skill-tag">PHP</span>
                        <span class="skill-tag">WordPress (Custom Theme & Plugins)</span>
                        <span class="skill-tag">WooCommerce</span>
                        <span class="skill-tag">JavaScript (ES6+)</span>
                        <span class="skill-tag">HTML5 / CSS3</span>
                        <span class="skill-tag">Responsive Web Design</span>
                        <span class="skill-tag">MySQL Server & SQL Server</span>
                        <span class="skill-tag">Quản trị cPanel & Hosting</span>
                        <span class="skill-tag">Cấu hình DNS / Tên miền</span>
                        <span class="skill-tag">Tích hợp API</span>
                        <span class="skill-tag">Git / GitHub</span>
                        <span class="skill-tag">Google Gemini & Prompt Engineering</span>
                        <span class="skill-tag">Java / C#</span>
                    </div>
                </div>

                <!-- Footer Copyright -->
                <div style="font-family:'JetBrains Mono',monospace; font-size:11px; color:var(--text-muted); text-align:center; padding-top:10px;">
                    © 2026 TRƯƠNG HUY NHẬT HÀO. ALL RIGHTS RESERVED.
                </div>
            </div>
        </aside>
    </div>


    <!-- ================= PROJECT DETAIL MODAL (INSPECTOR) ================= -->
    <div class="modal-backdrop" id="modalBackdrop">
        <div class="modal-dialog" role="dialog" aria-modal="true">
            <div class="modal-top-bar">
                <div>
                    <span id="modalCategory" style="font-family:'JetBrains Mono',monospace; font-size:11px; color:var(--accent-cyan); text-transform:uppercase;">
                        DANH MỤC
                    </span>
                    <h2 id="modalTitle" style="font-family:'Outfit',sans-serif; font-size:20px; font-weight:700; color:#fff; margin-top:2px;">
                        Tên Dự Án
                    </h2>
                </div>
                <button class="btn-close-drawer" id="btnCloseModal" title="Đóng cửa sổ">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="modal-body">
                <div class="modal-visual-preview" id="modalVisual"></div>

                <div class="modal-info-grid">
                    <div>
                        <span class="info-label">Khách Hàng</span>
                        <div class="info-val" id="modalClient">—</div>
                    </div>
                    <div>
                        <span class="info-label">Loại Dự Án</span>
                        <div class="info-val" id="modalType">—</div>
                    </div>
                    <div>
                        <span class="info-label">Năm Thực Hiện</span>
                        <div class="info-val" id="modalYear">2024</div>
                    </div>
                    <div>
                        <span class="info-label">Công Nghệ / Vai Trò</span>
                        <div class="info-val" id="modalTech">—</div>
                    </div>
                </div>

                <div>
                    <span class="info-label">Mô Tả & Mục Tiêu Triển Khai</span>
                    <p id="modalNote" style="font-size:13.5px; color:var(--text-secondary); line-height:1.7; margin-top:6px;"></p>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn-nav btn-copy" id="modalBtnCopy" data-url="" title="Sao chép link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                    <span>COPY LINK</span>
                </button>

                <a href="#" target="_blank" rel="noopener noreferrer" class="btn-launch" id="modalBtnLaunch">
                    <span>MỞ TRANG WEB THỰC TẾ</span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="7" y1="17" x2="17" y2="7"></line>
                        <polyline points="7 7 17 7 17 17"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </div>


    <!-- ================= SCRIPTS ================= -->
    <script src="assets/js/main.js" defer></script>
</body>
</html>
