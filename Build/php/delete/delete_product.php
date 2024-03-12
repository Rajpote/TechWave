<?php
include '../dbconn.php';

$g_id = $_GET['g_id'];
$query = "DELETE FROM product WHERE g_id = :g_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':g_id', $g_id);
if ($stmt->execute()) {
    echo "<script>alert('User deleted successfully.'); window.location.href = '../product_info.php';</script>";
} else {
    echo "Error deleting user record: " . $stmt->errorInfo()[2];
}

?>