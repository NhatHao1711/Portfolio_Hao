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
    <title>My Portfolio — Danh Sách Dự Án Đã Triển Khai</title>
    
    <!-- Meta SEO Tags -->
    <meta name="description" content="Portfolio Hào - Tổng hợp các dự án website đã triển khai thực tế đa ngành nghề: Doanh nghiệp, F&B, Y tế, Giáo dục, Bán lẻ, Logistics...">
    <meta name="keywords" content="Portfolio Hào, Dự án website, WordPress, PHP, Landing Page">
    <meta name="author" content="Trương Văn Hào">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- ================= SITE HEADER ================= -->
    <header class="site-header">
        <div class="container">
            <div class="header-inner">
                <a href="./" class="brand-logo">
                    <div class="logo-symbol">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <div class="logo-text">MY <span>PORTFOLIO</span></div>
                </a>

                <div class="header-badge-count">
                    <span class="pulse-dot"></span>
                    <span><strong><?= $total_projects ?></strong> Dự Án Đã Hoàn Thành</span>
                </div>
            </div>
        </div>
    </header>


    <!-- ================= PORTFOLIO SHOWCASE SECTION ================= -->
    <section class="portfolio-section" id="projects">
        <div class="container">

            <!-- Filter & Instant Search Controls -->
            <div class="filter-controls-wrap">
                <div class="search-input-group">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="projectSearch" class="search-input" placeholder="Tìm kiếm nhanh dự án theo tên, ngành nghề, khách hàng hoặc từ khóa (ví dụ: F&B, Logistics, Y tế, Ads, Giáo dục, Du lịch...)...">
                </div>

                <div class="filter-pills">
                    <button class="filter-btn active" data-filter="all">Tất Cả (<?= $total_projects ?>)</button>
                    <button class="filter-btn" data-filter="logistics">Logistics & Vận tải</button>
                    <button class="filter-btn" data-filter="media">Truyền Thông</button>
                    <button class="filter-btn" data-filter="agency">Agency & Sáng Tạo</button>
                    <button class="filter-btn" data-filter="education">Giáo Dục & Đào Tạo</button>
                    <button class="filter-btn" data-filter="healthcare">Y Tế & Sức Khỏe</button>
                    <button class="filter-btn" data-filter="fnb">F&B & Nhà Hàng</button>
                    <button class="filter-btn" data-filter="retail">Bán Lẻ & Thương Mại</button>
                    <button class="filter-btn" data-filter="hospitality">Du Lịch & Khách Sạn</button>
                    <button class="filter-btn" data-filter="construction">Xây Dựng & Nhôm Kính</button>
                    <button class="filter-btn" data-filter="realestate">Bất Động Sản</button>
                    <button class="filter-btn" data-filter="fashion">Thời Trang & Lifestyle</button>
                    <button class="filter-btn" data-filter="services">Dịch Vụ Khác</button>
                </div>

                <div class="filter-results-info">
                    <span>Đang hiển thị: <strong id="visibleCount"><?= $total_projects ?></strong> / <?= $total_projects ?> dự án</span>
                    <span class="info-note">Nhấn vào <strong>Truy Cập Web</strong> để xem trực tiếp website thực tế</span>
                </div>
            </div>

            <!-- Projects Grid -->
            <div class="projects-grid" id="projectsContainer">
                <?php foreach ($projects as $item): 
                    $badgeClass = 'project-badge-chip';
                    if (stripos($item['badge'], 'Ads') !== false) {
                        $badgeClass .= ' badge-ads';
                    } elseif (stripos($item['badge'], 'Case Study') !== false || stripos($item['badge'], '300%') !== false) {
                        $badgeClass .= ' badge-growth';
                    } elseif (stripos($item['badge'], 'Global') !== false || stripos($item['badge'], 'Đại học') !== false) {
                        $badgeClass .= ' badge-featured';
                    }

                    $domainDisplay = parse_url($item['url'], PHP_URL_HOST);
                    if (!$domainDisplay || $domainDisplay === '') {
                        $domainDisplay = str_replace(['https://', 'http://', '/'], '', $item['url']);
                    }
                    if ($item['url'] === '#' || empty($item['url'])) {
                        $domainDisplay = 'Đang cập nhật domain';
                    }
                ?>
                <div class="project-card" data-category="<?= htmlspecialchars($item['category']) ?>" data-group="<?= htmlspecialchars($item['group_tag']) ?>">
                    <!-- Card Top Mockup -->
                    <div class="project-banner">
                        <div class="project-banner-inner">
                            <div class="mockup-header">
                                <div class="mockup-dots">
                                    <span class="mockup-dot red"></span>
                                    <span class="mockup-dot yellow"></span>
                                    <span class="mockup-dot green"></span>
                                </div>
                                <div class="mockup-url-pill"><?= htmlspecialchars($domainDisplay) ?></div>
                            </div>
                            <div class="mockup-preview-logo">
                                <?= htmlspecialchars($item['name']) ?>
                            </div>
                            <div style="display: flex; justify-content: flex-end;">
                                <span style="font-size: 0.72rem; color: var(--sky-700); background: rgba(255,255,255,0.85); padding: 2px 8px; border-radius: 20px; font-weight: 600;">
                                    <?= htmlspecialchars($item['type'] ?? 'Website') ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="project-body">
                        <div class="project-meta-top">
                            <span class="project-category-chip"><?= htmlspecialchars($item['category']) ?></span>
                            <?php if (!empty($item['badge'])): ?>
                                <span class="<?= $badgeClass ?>"><?= htmlspecialchars($item['badge']) ?></span>
                            <?php endif; ?>
                        </div>

                        <h3 class="project-title"><?= htmlspecialchars($item['name']) ?></h3>

                        <?php if (!empty($item['client'])): ?>
                            <div class="project-client-name">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span>Khách hàng: <strong><?= htmlspecialchars($item['client']) ?></strong></span>
                            </div>
                        <?php endif; ?>

                        <p class="project-note">
                            <?= htmlspecialchars(!empty($item['note']) ? $item['note'] : 'Dự án website tối ưu giao diện và chuẩn công nghệ hiện đại.') ?>
                        </p>

                        <!-- Card Footer -->
                        <div class="project-footer">
                            <?php if ($item['url'] !== '#' && !empty($item['url'])): ?>
                                <a href="<?= htmlspecialchars($item['url']) ?>" target="_blank" rel="noopener noreferrer" class="btn-visit">
                                    <span>Truy Cập Web</span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="7" y1="17" x2="17" y2="7"></line>
                                        <polyline points="7 7 17 7 17 17"></polyline>
                                    </svg>
                                </a>
                                <button class="btn-copy" data-url="<?= htmlspecialchars($item['url']) ?>" title="Sao chép liên kết">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                    </svg>
                                    <span>Copy Link</span>
                                </button>
                            <?php else: ?>
                                <span style="font-size: 0.85rem; color: var(--slate-400); font-style: italic;">
                                    ⏳ Đang phát triển / cập nhật tên miền
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Empty Search Fallback -->
                <div class="empty-state" id="emptyState" style="display: none;">
                    <div class="empty-icon">🔍</div>
                    <h3 style="font-size: 1.3rem; color: var(--slate-800); margin-bottom: 8px;">Không tìm thấy dự án phù hợp</h3>
                    <p style="color: var(--slate-500); font-size: 0.95rem;">Hãy thử tìm kiếm với từ khóa khác hoặc chọn xem danh mục "Tất cả".</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-inner">
                <div class="footer-brand">
                    My <span style="color: var(--sky-600);">PORTFOLIO</span>
                </div>
                <div class="footer-desc">
                    Tuyển tập <?= $total_projects ?>+ dự án website đã triển khai thực tế.
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
</body>
</html>
