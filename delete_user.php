
<?php
session_start();
require_once 'models/UserModel.php';

$userModel = new UserModel();
$user = NULL;
$id = NULL;

// Kiểm Tra  token CSRF
if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $_GET['token']) {
  die("CSRF Token không khớp: CSRF token không hợp lệ");
}

// Get id
if (!empty($_GET['id'])) {
  $id = $_GET['id'];

  // Xóa người dùng theo id
  $deleted = $userModel->deleteUserById($id);

  // Kiểm tra xem thao tác xóa có thành công không
  if ($deleted) {
    echo "User with ID $id has been deleted successfully.";
  } else {
    echo "Error: Failed to delete the user with ID $id.";
  }
}

// Reset token 
unset($_SESSION['csrf_token']);

// Redirect to users page
header('location: list_users.php');

?>