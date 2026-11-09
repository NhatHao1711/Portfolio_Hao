<?php
/**
 * Database & Project Configuration for Portfolio_Hao
 * Mathias Adolfsson Inspired Creative Showcase Edition
 */

$db_host = '127.0.0.1';
$db_user = 'root';
$db_pass = '';
$db_name = 'portfolio_hao_db';

$conn = null;
$db_connected = false;

// Attempt to connect and initialize database if available
try {
    $conn = @new mysqli($db_host, $db_user, $db_pass);
    
    if (!$conn->connect_error) {
        $conn->query("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $conn->select_db($db_name);
        $db_connected = true;

        // Create projects table
        $conn->query("CREATE TABLE IF NOT EXISTS `projects` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `category` VARCHAR(100) NOT NULL,
            `group_tag` VARCHAR(50) NOT NULL,
            `url` VARCHAR(255) DEFAULT '',
            `type` VARCHAR(50) DEFAULT 'Website',
            `client` VARCHAR(100) DEFAULT '',
            `note` TEXT DEFAULT '',
            `status` VARCHAR(50) DEFAULT 'Hoàn thành',
            `badge` VARCHAR(100) DEFAULT '',
            `tech` VARCHAR(255) DEFAULT '',
            `year` VARCHAR(50) DEFAULT '2024',
            `image` VARCHAR(255) DEFAULT '',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        // Create contacts table
        $conn->query("CREATE TABLE IF NOT EXISTS `contacts` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `fullname` VARCHAR(150) NOT NULL,
            `email` VARCHAR(150) NOT NULL,
            `phone` VARCHAR(50) NOT NULL,
            `service` VARCHAR(100) DEFAULT 'Website Portfolio',
            `message` TEXT NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    }
} catch (Exception $e) {
    $db_connected = false;
}

// Curated Master Dataset (9 Key Projects)
$default_projects = [
    [
        'id' => 1,
        'name' => 'An Giang Travel',
        'category' => 'Du lịch & Trải nghiệm',
        'group_tag' => 'hospitality',
        'url' => 'https://angiangtravel.com',
        'type' => 'Travel Portal',
        'client' => 'An Giang Travel',
        'note' => 'Cổng thông tin & tour khám phá du lịch miền Tây sông nước. Thiết kế trực quan, tối ưu trải nghiệm đặt tour và tìm kiếm cẩm nang văn hóa bản địa.',
        'status' => 'Hoàn thành',
        'badge' => 'Travel & Hospitality',
        'tech' => 'PHP, UI/UX, Dynamic Tour Engine, SEO',
        'year' => '2024',
        'accent' => '#10b981',
        'gradient' => 'linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%)',
        'image' => 'assets/images/projects/project_1.jpg'
    ],
    [
        'id' => 2,
        'name' => 'Hwatch (v2)',
        'category' => 'E-Commerce & Bán lẻ',
        'group_tag' => 'retail',
        'url' => 'http://hwatch.vn',
        'type' => 'High-Conversion Landing',
        'client' => 'Hwatch Official',
        'note' => 'Landing page thế hệ mới tối ưu tỷ lệ chuyển đổi, đặt hàng 1-click cho bộ sưu tập đồng hồ cao cấp sang trọng và đẳng cấp.',
        'status' => 'Hoàn thành',
        'badge' => 'High Conversion 🚀',
        'tech' => 'Landing Page CRO, High-Speed Checkout, Mobile First',
        'year' => '2024',
        'accent' => '#f59e0b',
        'gradient' => 'linear-gradient(135deg, #1c1917 0%, #451a03 50%, #78350f 100%)',
        'image' => 'assets/images/projects/project_2.jpg'
    ],
    [
        'id' => 3,
        'name' => 'Độ Khớp',
        'category' => 'Dược phẩm & Làm đẹp',
        'group_tag' => 'services',
        'url' => 'https://daugoi.dokhop.com/',
        'type' => 'DTC Landing Page',
        'client' => 'Độ Khớp Official',
        'note' => 'Landing Page bán lẻ trực tiếp (DTC) dòng sản phẩm dầu gội thảo dược. Hiệu ứng thị giác mượt mà, cấu trúc chốt đơn và bằng chứng thuyết phục.',
        'status' => 'Hoàn thành',
        'badge' => 'Direct To Consumer',
        'tech' => 'DTC Conversion, Interactive UI, Smooth Flow',
        'year' => '2024',
        'accent' => '#059669',
        'gradient' => 'linear-gradient(135deg, #064e3b 0%, #047857 50%, #10b981 100%)',
        'image' => 'assets/images/projects/project_3.jpg'
    ],
    [
        'id' => 4,
        'name' => 'Kia Đà Nẵng',
        'category' => 'Ô tô & Showroom',
        'group_tag' => 'retail',
        'url' => 'https://kiadanang.com.vn/',
        'type' => 'Showroom Portal',
        'client' => 'Kia Motors Đà Nẵng',
        'note' => 'Cổng thông tin showroom ô tô Kia chính hãng, hệ thống bảng giá tương tác, bảng thông số kỹ thuật xe và đăng ký lái thử trực tuyến.',
        'status' => 'Hoàn thành',
        'badge' => 'Automotive Official',
        'tech' => 'Car Catalog, Quotation Form, Test Drive Booking',
        'year' => '2024',
        'accent' => '#ef4444',
        'gradient' => 'linear-gradient(135deg, #450a0a 0%, #7f1d1d 50%, #991b1b 100%)',
        'image' => 'assets/images/projects/project_4.jpg'
    ],
    [
        'id' => 5,
        'name' => 'Chay Xanh',
        'category' => 'F&B & Ẩm thực',
        'group_tag' => 'fnb',
        'url' => 'http://chayxanh.vn/',
        'type' => 'Nhà hàng & F&B',
        'client' => 'Chay Xanh Restaurant',
        'note' => 'Website thương hiệu ẩm thực chay vì sức khỏe. Thiết kế mộc mạc, tĩnh tại, mang đậm tinh thần cân bằng thân tâm và năng lượng an lành.',
        'status' => 'Hoàn thành',
        'badge' => 'F&B Gastronomy',
        'tech' => 'Gastronomy Branding, Digital Menu, Storytelling',
        'year' => '2024',
        'accent' => '#22c55e',
        'gradient' => 'linear-gradient(135deg, #14532d 0%, #166534 50%, #15803d 100%)',
        'image' => 'assets/images/projects/project_5.jpg'
    ],
    [
        'id' => 6,
        'name' => 'SoulMate by Anna',
        'category' => 'Tâm lý & Sức khỏe',
        'group_tag' => 'healthcare',
        'url' => 'https://soulmatebyanna.com/',
        'type' => 'Personal Brand & Care',
        'client' => 'Anna SoulMate',
        'note' => 'Nền tảng tư vấn tâm lý, thấu hiểu bản thân và hành trình chữa lành. Tone màu dịu nhẹ, tạo cảm giác an tâm, thấu cảm và sâu lắng.',
        'status' => 'Hoàn thành',
        'badge' => 'Mindfulness & Healing',
        'tech' => 'Personal Branding, Mental Care Booking, Audio Space',
        'year' => '2024',
        'accent' => '#a855f7',
        'gradient' => 'linear-gradient(135deg, #3b0764 0%, #581c87 50%, #6b21a8 100%)',
        'image' => 'assets/images/projects/project_6.jpg'
    ],
    [
        'id' => 7,
        'name' => 'Snack House',
        'category' => 'FMCG & Thực phẩm',
        'group_tag' => 'fnb',
        'url' => 'http://snackhouse.com.vn',
        'type' => 'FMCG Catalog',
        'client' => 'SnackHouse',
        'note' => 'Hệ thống sản phẩm ăn vặt & đồ ăn nhanh tiện lợi. Giao diện trẻ trung, màu sắc năng động, kích thích thị giác và vị giác người dùng.',
        'status' => 'Hoàn thành',
        'badge' => 'FMCG & Food',
        'tech' => 'Product Showcase, Fast Browsing, Snappy UI',
        'year' => '2024',
        'accent' => '#f97316',
        'gradient' => 'linear-gradient(135deg, #431407 0%, #7c2d12 50%, #9a3412 100%)',
        'image' => 'assets/images/projects/project_7.jpg'
    ],
    [
        'id' => 8,
        'name' => 'Sebastian',
        'category' => 'Creative Agency & B2B',
        'group_tag' => 'agency',
        'url' => 'https://sebastian.web1ngay.vn',
        'type' => 'Creative Showcase',
        'client' => 'MonSoon Creative',
        'note' => 'Landing Page truyền thông giải pháp sáng tạo & nhận diện thương hiệu B2B với phong cách thiết kế hiện đại, đột phá và khác biệt.',
        'status' => 'Hoàn thành',
        'badge' => 'Creative Agency ⭐',
        'tech' => 'Visual Storytelling, Typography Grid, B2B Impact',
        'year' => '2024',
        'accent' => '#6366f1',
        'gradient' => 'linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%)',
        'image' => 'assets/images/projects/project_8.jpg'
    ],
    [
        'id' => 9,
        'name' => 'GYLA Summer Camp',
        'category' => 'Giáo dục & Quốc tế',
        'group_tag' => 'education',
        'url' => 'https://summer.gylaedu.vn/',
        'type' => 'Trại hè Giáo dục',
        'client' => 'Gyla Education',
        'note' => 'Chương trình trại hè quốc tế tiếng Anh & phát triển kỹ năng toàn diện cho thanh thiếu niên với hình ảnh sinh động, thu hút phụ huynh & học sinh.',
        'status' => 'Hoàn thành',
        'badge' => 'International Camp 🔥',
        'tech' => 'Camp Experience, Parent Lead Capture, Responsive',
        'year' => '2024',
        'accent' => '#06b6d4',
        'gradient' => 'linear-gradient(135deg, #083344 0%, #0e7490 50%, #0891b2 100%)',
        'image' => 'assets/images/projects/project_9.jpg'
    ],
    [
        'id' => 10,
        'name' => 'Trivent',
        'category' => 'Đồ án tốt nghiệp',
        'group_tag' => 'graduation',
        'url' => 'https://github.com/NhatHao1711/HeThongQuanLyVeVaSuKien',
        'type' => 'Fullstack Event & Ticketing Platform',
        'client' => 'Đại học HUTECH (Đồ án tốt nghiệp)',
        'note' => 'Hệ thống quản lý sự kiện & đặt vé online toàn diện dành cho sinh viên. Tích hợp đặt vé realtime chống overselling với Redis Distributed Lock, xử lý hàng đợi bất đồng bộ RabbitMQ, thanh toán trực tuyến, soát vé tự động bằng QR Code và đóng gói Docker container hóa.',
        'status' => 'Hoàn thành',
        'badge' => 'Đồ án tốt nghiệp 🎓',
        'tech' => 'Spring Boot 3, Next.js 16, MySQL, Redis, RabbitMQ, Docker',
        'year' => '2026',
        'accent' => '#00f0ff',
        'gradient' => 'linear-gradient(135deg, #1e3a8a 0%, #0d9488 50%, #0284c7 100%)',
        'image' => 'assets/images/projects/project_10.jpg'
    ]
];

// Synchronize projects table in MySQL
if ($db_connected && $conn) {
    $conn->query("UPDATE `projects` SET `url` = 'https://daugoi.dokhop.com/' WHERE `id` = 3");
    $res = $conn->query("SELECT COUNT(*) as cnt FROM `projects`");
    $row = $res ? $res->fetch_assoc() : ['cnt' => 0];
    if ($row['cnt'] != count($default_projects)) {
        $conn->query("TRUNCATE TABLE `projects`");
        $stmt = $conn->prepare("INSERT INTO `projects` (`id`, `name`, `category`, `group_tag`, `url`, `type`, `client`, `note`, `status`, `badge`, `tech`, `year`, `image`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            foreach ($default_projects as $p) {
                $p_id = $p['id'];
                $p_name = $p['name'];
                $p_cat = $p['category'];
                $p_group = $p['group_tag'];
                $p_url = $p['url'];
                $p_type = $p['type'];
                $p_client = $p['client'];
                $p_note = $p['note'];
                $p_status = $p['status'];
                $p_badge = $p['badge'];
                $p_tech = $p['tech'];
                $p_year = $p['year'];
                $p_image = $p['image'];
                $stmt->bind_param('issssssssssss', $p_id, $p_name, $p_cat, $p_group, $p_url, $p_type, $p_client, $p_note, $p_status, $p_badge, $p_tech, $p_year, $p_image);
                $stmt->execute();
            }
            $stmt->close();
        }
    }
}

/**
 * Fetch all projects from database or fallback array
 */
function get_all_projects() {
    global $conn, $db_connected, $default_projects;
    if ($db_connected && $conn) {
        $result = $conn->query("SELECT * FROM `projects` ORDER BY `id` ASC");
        if ($result && $result->num_rows > 0) {
            $list = [];
            while ($row = $result->fetch_assoc()) {
                $id = (int)$row['id'];
                if (isset($default_projects[$id - 1])) {
                    $row['accent'] = $default_projects[$id - 1]['accent'] ?? '#38bdf8';
                    $row['gradient'] = $default_projects[$id - 1]['gradient'] ?? 'linear-gradient(135deg, #0f172a 0%, #1e293b 100%)';
                    $row['image'] = $default_projects[$id - 1]['image'] ?? ('assets/images/projects/project_' . $id . '.jpg');
                }
                $list[] = $row;
            }
            return $list;
        }
    }
    return $default_projects;
}
