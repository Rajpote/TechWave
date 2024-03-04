<?php
include 'dbconn.php';

$id = $_GET['id'];
$query = "DELETE FROM registration WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
if ($stmt->execute()) {
    echo "<script>alert('User deleted successfully.'); window.location.href = 'manage_user.php';</script>";
} else {
    echo "Error deleting user record: " . $stmt->errorInfo()[2];
}

?>