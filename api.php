<?php
/**
 * API Backend for Contact Form & Project Filtering
 * Portfolio Hao
 */

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/config.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'submit_contact') {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $service = trim($_POST['service'] ?? 'Website Portfolio');
    $message = trim($_POST['message'] ?? '');

    if (empty($fullname) || empty($phone) || empty($message)) {
        echo json_encode([
            'success' => false,
            'message' => 'Vui lòng điền đầy đủ Họ tên, Số điện thoại và Lời nhắn.'
        ]);
        exit;
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'message' => 'Địa chỉ email không đúng định dạng.'
        ]);
        exit;
    }

    if ($db_connected && $conn) {
        $stmt = $conn->prepare("INSERT INTO `contacts` (`fullname`, `email`, `phone`, `service`, `message`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $fullname, $email, $phone, $service, $message);
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Cảm ơn bạn! Thông tin liên hệ đã được gửi thành công. Tôi sẽ phản hồi bạn trong thời gian sớm nhất.'
            ]);
            $stmt->close();
            exit;
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lưu thông tin. Vui lòng thử lại sau.'
            ]);
            $stmt->close();
            exit;
        }
    } else {
        // Fallback response if DB offline
        echo json_encode([
            'success' => true,
            'message' => 'Cảm ơn bạn! Thông tin liên hệ đã được tiếp nhận.'
        ]);
        exit;
    }
}

if ($action === 'get_projects') {
    $projects = get_all_projects();
    echo json_encode([
        'success' => true,
        'count' => count($projects),
        'data' => $projects
    ]);
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Yêu cầu không hợp lệ.'
]);
