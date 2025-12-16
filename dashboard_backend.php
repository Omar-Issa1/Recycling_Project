<?php
require_once 'config.php';
require_once 'Admin.php';

// if (!isAdmin()) {
//     redirect('Page 1.php');
// }

$admin = new Admin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'update_user':
            $user_id = intval($_POST['user_id']);
            $username = sanitize($_POST['username']);
            $email = sanitize($_POST['email']);
            $phone = sanitize($_POST['phone']);
            $balance = floatval($_POST['balance']);
            $points = intval($_POST['points']);
            
            $result = $admin->updateUser($user_id, $username, $email, $phone, $balance, $points);
            echo json_encode($result);
            exit;
            
        case 'delete_user':
            $user_id = intval($_POST['user_id']);
            $result = $admin->deleteUser($user_id);
            echo json_encode($result);
            exit;
            
        case 'search_users':
            $search_term = sanitize($_POST['search_term']);
            $users = $admin->searchUsers($search_term);
            echo json_encode(['success' => true, 'users' => $users]);
            exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
    
    switch ($action) {
        case 'get_all_users':
            $users = $admin->getAllUsers();
            echo json_encode(['success' => true, 'users' => $users]);
            exit;
            
        case 'get_statistics':
            $stats = $admin->getStatistics();
            echo json_encode(['success' => true, 'statistics' => $stats]);
            exit;
    }
}

$users = $admin->getAllUsers();
$statistics = $admin->getStatistics();
?>