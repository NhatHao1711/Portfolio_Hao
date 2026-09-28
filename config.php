<?php
/**
 * Database & Project Configuration for Portfolio_Hao
 * Soft Sky Blue Edition
 */

$db_host = '127.0.0.1';
$db_user = 'root';
$db_pass = '';
$db_name = 'portfolio_hao_db';

$conn = null;
$db_connected = false;

// Attempt to connect and initialize database if available
try {
    // Initial connection to MySQL server without database
    $conn = @new mysqli($db_host, $db_user, $db_pass);
    
    if (!$conn->connect_error) {
        // Create database if not exists
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

// Master Dataset of all projects from portfolio screenshots
$default_projects = [
    [
        'id' => 1,
        'name' => 'Song Triều Logistics',
        'category' => 'Logistics / B2B',
        'group_tag' => 'logistics',
        'url' => 'https://songtrieu.com.vn',
        'type' => 'Website',
        'client' => 'Song Triều',
        'note' => 'Hệ thống vận tải & logistics chuyên nghiệp',
        'status' => 'Hoàn thành',
        'badge' => 'B2B Logistics'
    ],
    [
        'id' => 2,
        'name' => 'Sài Gòn Today Communication',
        'category' => 'Truyền thông / B2B',
        'group_tag' => 'media',
        'url' => 'https://saigontodaymedia.com/',
        'type' => 'Website',
        'client' => 'Sài Gòn Today',
        'note' => 'Truyền thông & giải pháp thương hiệu',
        'status' => 'Hoàn thành',
        'badge' => 'Truyền thông'
    ],
    [
        'id' => 3,
        'name' => 'Hunter Agency & Creative',
        'category' => 'Agency / B2B',
        'group_tag' => 'agency',
        'url' => 'https://hunteragency.vn',
        'type' => 'Website',
        'client' => 'Hunter Agency',
        'note' => 'Sáng tạo & giải pháp Marketing tổng thể',
        'status' => 'Hoàn thành',
        'badge' => 'Agency Sáng tạo'
    ],
    [
        'id' => 4,
        'name' => 'On the Dot Comm',
        'category' => 'Truyền thông / B2B',
        'group_tag' => 'media',
        'url' => 'https://onthedotcomm.com',
        'type' => 'Website',
        'client' => 'On The Dot',
        'note' => 'Dịch vụ truyền thông hiện đại',
        'status' => 'Hoàn thành',
        'badge' => 'B2B Media'
    ],
    [
        'id' => 5,
        'name' => 'An Đức Phát Windows',
        'category' => 'Nhôm kính / Xây dựng',
        'group_tag' => 'construction',
        'url' => 'https://anducphatwindows.vn',
        'type' => 'Website',
        'client' => 'An Đức Phát',
        'note' => 'Client đang chạy Ads tối ưu chuyển đổi',
        'status' => 'Hoàn thành',
        'badge' => 'Đang chạy Ads 🔥'
    ],
    [
        'id' => 6,
        'name' => 'An Thanh Gia',
        'category' => 'Nhà thầu xây dựng',
        'group_tag' => 'construction',
        'url' => 'https://anthanhgia.com',
        'type' => 'Website',
        'client' => 'An Thanh Gia',
        'note' => 'Hồ sơ năng lực nhà thầu & dự án công trình',
        'status' => 'Hoàn thành',
        'badge' => 'Xây dựng'
    ],
    [
        'id' => 7,
        'name' => 'ĐH Ngân hàng – DTC Hub',
        'category' => 'Giáo dục',
        'group_tag' => 'education',
        'url' => 'https://dtc.hub.edu.vn',
        'type' => 'Website',
        'client' => 'ĐH Ngân hàng',
        'note' => 'Trung tâm đào tạo số & chuyển đổi công nghệ',
        'status' => 'Hoàn thành',
        'badge' => 'Giáo dục Đại học'
    ],
    [
        'id' => 8,
        'name' => 'Z+ Academy',
        'category' => 'Giáo dục',
        'group_tag' => 'education',
        'url' => 'https://hocvienzplus.mtsols.vn',
        'type' => 'Website',
        'client' => 'Z+ Academy',
        'note' => 'Học viện đào tạo kỹ năng & chuyên môn chuyên sâu',
        'status' => 'Hoàn thành',
        'badge' => 'Học viện Đào tạo'
    ],
    [
        'id' => 9,
        'name' => 'BIM Automotive Training',
        'category' => 'Giáo dục / Ô tô',
        'group_tag' => 'education',
        'url' => 'https://onlybim.vn',
        'type' => 'Website',
        'client' => 'OnlyBIM',
        'note' => 'Đào tạo kỹ thuật & chẩn đoán ô tô công nghệ cao',
        'status' => 'Hoàn thành',
        'badge' => 'Đào tạo Kỹ thuật'
    ],
    [
        'id' => 10,
        'name' => 'Tra English',
        'category' => 'Giáo dục / Anh ngữ',
        'group_tag' => 'education',
        'url' => 'https://traenglish.com',
        'type' => 'Website',
        'client' => 'Tra English',
        'note' => 'Khóa học tiếng Anh giao tiếp & luyện thi hiệu quả',
        'status' => 'Hoàn thành',
        'badge' => 'Anh ngữ'
    ],
    [
        'id' => 11,
        'name' => 'Châu Thành ESL',
        'category' => 'Giáo dục / Anh ngữ',
        'group_tag' => 'education',
        'url' => 'https://chauthanhesl.edu.vn',
        'type' => 'Website',
        'client' => 'Châu Thành ESL',
        'note' => 'Trung tâm đào tạo Anh ngữ chuẩn quốc tế',
        'status' => 'Hoàn thành',
        'badge' => 'Giáo dục Quốc tế'
    ],
    [
        'id' => 12,
        'name' => 'Urgo Medical Vietnam',
        'category' => 'Y tế / Thiết bị y khoa',
        'group_tag' => 'healthcare',
        'url' => 'https://urgomedical.vn',
        'type' => 'Website',
        'client' => 'Urgo Medical',
        'note' => 'Client đang training - Thương hiệu thiết bị y tế Pháp',
        'status' => 'Hoàn thành',
        'badge' => 'Y tế Cao cấp'
    ],
    [
        'id' => 13,
        'name' => 'Deep Tissue Massage',
        'category' => 'Wellness / Massage',
        'group_tag' => 'healthcare',
        'url' => 'http://deeptissuemassage.vn',
        'type' => 'Website',
        'client' => 'Deep Tissue',
        'note' => 'Client đang chạy Ads - Chăm sóc sức khỏe & trị liệu',
        'status' => 'Hoàn thành',
        'badge' => 'Đang chạy Ads 🔥'
    ],
    [
        'id' => 14,
        'name' => 'Nguyễn Phúc Quý Thanh',
        'category' => 'Y tế / Chuyên gia',
        'group_tag' => 'healthcare',
        'url' => 'http://nguyenphucquythanh.com',
        'type' => 'Website',
        'client' => 'Bác sĩ Quý Thanh',
        'note' => 'Website chuyên gia y tế & tư vấn sức khỏe gia đình',
        'status' => 'Hoàn thành',
        'badge' => 'Chuyên gia Y tế'
    ],
    [
        'id' => 15,
        'name' => 'Womb Body Wisdom',
        'category' => 'Wellness (EN)',
        'group_tag' => 'healthcare',
        'url' => 'https://wombbodywisdom.com',
        'type' => 'Website',
        'client' => 'Womb Body Wisdom',
        'note' => 'Website tiếng Anh chuẩn quốc tế phục vụ thị trường global',
        'status' => 'Hoàn thành',
        'badge' => 'Global Website 🌐'
    ],
    [
        'id' => 16,
        'name' => 'Grandma Lu\'s',
        'category' => 'F&B / Hospitality',
        'group_tag' => 'fnb',
        'url' => 'https://banhmigrandmalu.com/',
        'type' => 'Website',
        'client' => 'Grandma Lu',
        'note' => 'Case study nổi bật - Chuỗi bánh mì & ẩm thực độc đáo',
        'status' => 'Hoàn thành',
        'badge' => 'Case Study Nổi Bật ⭐'
    ],
    [
        'id' => 17,
        'name' => 'Lẩu Tao Ngộ',
        'category' => 'F&B / Nhà hàng',
        'group_tag' => 'fnb',
        'url' => 'https://lautaongo.com',
        'type' => 'Website',
        'client' => 'Lẩu Tao Ngộ',
        'note' => 'Đang chạy Ads thu hút hàng chục ngàn thực khách',
        'status' => 'Hoàn thành',
        'badge' => 'Đang chạy Ads 🔥'
    ],
    [
        'id' => 18,
        'name' => 'Hero Hostel & Billiards',
        'category' => 'Hospitality / Khách sạn',
        'group_tag' => 'hospitality',
        'url' => 'https://herohostelbilliards.com',
        'type' => 'Website',
        'client' => 'Hero Hostel',
        'note' => 'Case study: Tăng trưởng +300% doanh thu và lượt đặt phòng',
        'status' => 'Hoàn thành',
        'badge' => '+300% Doanh Thu 🚀'
    ],
    [
        'id' => 19,
        'name' => 'Châu Đình Linh',
        'category' => 'F&B / Personal Brand',
        'group_tag' => 'fnb',
        'url' => 'https://chaudinhlinh.com',
        'type' => 'Website',
        'client' => 'Châu Đình Linh',
        'note' => 'Thương hiệu cá nhân chuyên gia & tư vấn F&B',
        'status' => 'Hoàn thành',
        'badge' => 'Personal Brand'
    ],
    [
        'id' => 20,
        'name' => 'Rise Coffee Studio',
        'category' => 'F&B / Café',
        'group_tag' => 'fnb',
        'url' => 'https://www.risecoffeestudio.com',
        'type' => 'Website',
        'client' => 'Rise Coffee',
        'note' => 'Không gian cà phê & trải nghiệm sáng tạo tinh tế',
        'status' => 'Hoàn thành',
        'badge' => 'Café & Concept'
    ],
    [
        'id' => 21,
        'name' => 'Nhà Hàng Chay Hero',
        'category' => 'F&B / Nhà hàng chay',
        'group_tag' => 'fnb',
        'url' => 'https://nhahangchayhero.com',
        'type' => 'Website',
        'client' => 'Chay Hero',
        'note' => 'Ẩm thực chay thanh tịnh, dinh dưỡng và an lành',
        'status' => 'Hoàn thành',
        'badge' => 'Ẩm thực Chay'
    ],
    [
        'id' => 22,
        'name' => 'An Giang Travel',
        'category' => 'Du lịch',
        'group_tag' => 'hospitality',
        'url' => 'https://angiangtravel.com',
        'type' => 'Website',
        'client' => 'An Giang Travel',
        'note' => 'Tour & cẩm nang du lịch khám phá miền Tây sông nước',
        'status' => 'Hoàn thành',
        'badge' => 'Du lịch & Tour'
    ],
    [
        'id' => 23,
        'name' => 'Trang Sức HAS',
        'category' => 'Bán lẻ / Trang sức',
        'group_tag' => 'retail',
        'url' => 'https://trangsuchas.com',
        'type' => 'Website',
        'client' => 'HAS Silver',
        'note' => 'Đang chạy Ads - Thương mại điện tử trang sức bạc cao cấp',
        'status' => 'Hoàn thành',
        'badge' => 'Đang chạy Ads 🔥'
    ],
    [
        'id' => 24,
        'name' => 'Hwatch (v1)',
        'category' => 'Bán lẻ / Đồng hồ',
        'group_tag' => 'retail',
        'url' => 'https://hwatch.com.vn',
        'type' => 'Website',
        'client' => 'Hwatch',
        'note' => 'Hwatch - Version chính hãng & bộ sưu tập đồng hồ đẳng cấp',
        'status' => 'Hoàn thành',
        'badge' => 'E-Commerce (v1)'
    ],
    [
        'id' => 25,
        'name' => 'Hwatch (v2)',
        'category' => 'Bán lẻ / Đồng hồ',
        'group_tag' => 'retail',
        'url' => 'http://hwatch.vn',
        'type' => 'Website',
        'client' => 'Hwatch',
        'note' => 'Hwatch - Version phụ tối ưu hóa chuyển đổi đặt hàng nhanh',
        'status' => 'Hoàn thành',
        'badge' => 'Landing Page (v2)'
    ],
    [
        'id' => 26,
        'name' => 'Roar of Ra',
        'category' => 'Lifestyle / Fashion (EN)',
        'group_tag' => 'fashion',
        'url' => 'https://roarofra.com',
        'type' => 'Website',
        'client' => 'Roar of Ra',
        'note' => 'Website tiếng Anh - Thương hiệu phong cách thời trang ấn tượng',
        'status' => 'Hoàn thành',
        'badge' => 'Global Fashion 🌐'
    ],
    [
        'id' => 27,
        'name' => 'Xốp Hơi Gò Vấp',
        'category' => 'Vật liệu đóng gói',
        'group_tag' => 'logistics',
        'url' => 'https://xophoigovap.com',
        'type' => 'Website',
        'client' => 'Xốp Hơi Gò Vấp',
        'note' => 'Cung ứng màng xốp bọc hàng & vật liệu đóng gói giao nhanh',
        'status' => 'Hoàn thành',
        'badge' => 'Sản xuất & Cung ứng'
    ],
    [
        'id' => 28,
        'name' => 'Xốp Hơi Sài Gòn',
        'category' => 'Vật liệu đóng gói',
        'group_tag' => 'logistics',
        'url' => 'https://xophoisaigon.com',
        'type' => 'Website',
        'client' => 'Xốp Hơi Sài Gòn',
        'note' => 'Vật liệu bọc hàng chống sốc chuyên nghiệp toàn quốc',
        'status' => 'Hoàn thành',
        'badge' => 'B2B Packaging'
    ],
    [
        'id' => 29,
        'name' => 'Phalan Building Rental',
        'category' => 'Bất động sản',
        'group_tag' => 'realestate',
        'url' => 'https://phalan.com.vn/',
        'type' => 'Website',
        'client' => 'Phalan Building',
        'note' => 'Cho thuê tòa nhà văn phòng & mặt bằng kinh doanh vị trí đắc địa',
        'status' => 'Hoàn thành',
        'badge' => 'Bất Động Sản'
    ],
    [
        'id' => 30,
        'name' => 'Độ Khớp',
        'category' => 'Dịch vụ / Làm đẹp',
        'group_tag' => 'services',
        'url' => 'https://daugoi.dokhob.com/',
        'type' => 'Website/LandingPage',
        'client' => 'Độ Khớp',
        'note' => 'Landing Page tối ưu chuyển đổi sản phẩm dầu gội thảo dược',
        'status' => 'Hoàn thành',
        'badge' => 'Landing Page'
    ],
    [
        'id' => 31,
        'name' => 'BunniLD',
        'category' => 'Dịch vụ',
        'group_tag' => 'services',
        'url' => 'https://bunnild.com/',
        'type' => 'Website',
        'client' => 'BunniLD',
        'note' => 'Dịch vụ sáng tạo & giải pháp số hóa toàn diện',
        'status' => 'Hoàn thành',
        'badge' => 'Dịch vụ Số'
    ],
    [
        'id' => 32,
        'name' => 'Kia Đà Nẵng',
        'category' => 'Ô tô / Showroom',
        'group_tag' => 'retail',
        'url' => 'https://kiadanang.com.vn/',
        'type' => 'Website',
        'client' => 'Kia Đà Nẵng',
        'note' => 'Showroom ô tô Kia, bảng giá xe mới nhất & dịch vụ bảo dưỡng',
        'status' => 'Hoàn thành',
        'badge' => 'Showroom Ô tô'
    ],
    [
        'id' => 33,
        'name' => 'Freedom Transport',
        'category' => 'Dịch vụ Vận chuyển',
        'group_tag' => 'logistics',
        'url' => 'https://songtrieu.com.vn', // Link dự phòng
        'type' => 'Website',
        'client' => 'Freedom Transport',
        'note' => 'Giải pháp vận chuyển tiện lợi & an toàn',
        'status' => 'Hoàn thành',
        'badge' => 'Vận tải'
    ],
    [
        'id' => 34,
        'name' => 'Chay Xanh',
        'category' => 'F&B / Nhà hàng',
        'group_tag' => 'fnb',
        'url' => 'http://chayxanh.vn/',
        'type' => 'Website',
        'client' => 'Chay Xanh',
        'note' => 'Ẩm thực chay vì sức khỏe, cân bằng thân tâm',
        'status' => 'Hoàn thành',
        'badge' => 'Nhà hàng Chay'
    ],
    [
        'id' => 35,
        'name' => 'SoulMate by Anna',
        'category' => 'Tâm lý & Sức khỏe',
        'group_tag' => 'healthcare',
        'url' => 'https://soulmatebyanna.com/',
        'type' => 'Website',
        'client' => 'Anna SoulMate',
        'note' => 'Tư vấn tâm lý, thấu hiểu bản thân và hành trình chữa lành',
        'status' => 'Hoàn thành',
        'badge' => 'Tâm lý & Sức khỏe'
    ],
    [
        'id' => 36,
        'name' => 'MiLinaa',
        'category' => 'Thời trang / Fashion',
        'group_tag' => 'fashion',
        'url' => 'https://milinaa.com/',
        'type' => 'Website',
        'client' => 'MiLinaa',
        'note' => 'Bộ sưu tập thời trang thiết kế nữ tính, tinh tế và sang trọng',
        'status' => 'Hoàn thành',
        'badge' => 'Fashion Boutique'
    ],
    [
        'id' => 37,
        'name' => 'Enmusubi',
        'category' => 'Y tế / Thiết bị y khoa',
        'group_tag' => 'healthcare',
        'url' => 'https://urgomedical.vn', // Liên kết tham khảo
        'type' => 'Website',
        'client' => 'Emsubi',
        'note' => 'Thiết bị & công nghệ y khoa hiện đại chuẩn Nhật Bản',
        'status' => 'Đang phát triển',
        'badge' => 'Y tế Công nghệ'
    ],
    [
        'id' => 38,
        'name' => 'Snack House',
        'category' => 'FMCG / Thực phẩm',
        'group_tag' => 'fnb',
        'url' => 'http://snackhouse.com.vn',
        'type' => 'Website',
        'client' => 'SnackHouse',
        'note' => 'Sản phẩm ăn vặt & đồ ăn nhanh tiện lợi hợp khẩu vị',
        'status' => 'Hoàn thành',
        'badge' => 'FMCG Thực phẩm'
    ],
    [
        'id' => 39,
        'name' => 'Sebastian',
        'category' => 'Agency / B2B',
        'group_tag' => 'agency',
        'url' => 'https://sebastian.web1ngay.vn',
        'type' => 'Website/LandingPage',
        'client' => 'MonSoon',
        'note' => 'Landing Page truyền thông giải pháp sáng tạo & B2B',
        'status' => 'Hoàn thành',
        'badge' => 'Landing Page B2B'
    ],
    [
        'id' => 40,
        'name' => 'Trebra',
        'category' => 'Fashion / Thời trang',
        'group_tag' => 'fashion',
        'url' => 'https://trebra.vn',
        'type' => 'Website',
        'client' => 'TreBra',
        'note' => 'Thời trang & phụ kiện phong cách hiện đại cho giới trẻ',
        'status' => 'Hoàn thành',
        'badge' => 'Fashion Store'
    ],
    [
        'id' => 41,
        'name' => 'Trí Việt Sturdy',
        'category' => 'Giáo dục / Du học',
        'group_tag' => 'education',
        'url' => 'http://trivietedu.vn',
        'type' => 'Website',
        'client' => 'Trí Việt',
        'note' => 'Tư vấn giáo dục, định hướng học tập & du học quốc tế',
        'status' => 'Hoàn thành',
        'badge' => 'Tư vấn Du học'
    ]
];

// Seed projects into MySQL if table is currently empty
if ($db_connected && $conn) {
    $res = $conn->query("SELECT COUNT(*) as cnt FROM `projects`");
    $row = $res ? $res->fetch_assoc() : ['cnt' => 0];
    if ($row['cnt'] == 0) {
        $stmt = $conn->prepare("INSERT INTO `projects` (`name`, `category`, `group_tag`, `url`, `type`, `client`, `note`, `status`, `badge`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($default_projects as $p) {
            $stmt->bind_param('sssssssss', $p['name'], $p['category'], $p['group_tag'], $p['url'], $p['type'], $p['client'], $p['note'], $p['status'], $p['badge']);
            $stmt->execute();
        }
        $stmt->close();
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
                $list[] = $row;
            }
            return $list;
        }
    }
    return $default_projects;
}
