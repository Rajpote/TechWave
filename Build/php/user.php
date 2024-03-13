<?php
include 'dbconn.php';

$stmt = $conn->prepare("SELECT id FROM registration WHERE email = :email");
$stmt->bindParam(':email', $_SESSION['uname']);
$stmt->execute();
$uid = $stmt->fetch(PDO::FETCH_COLUMN);

if ($uid === false) {
    echo "Error: Username not found.";
    exit();
}

$query = "SELECT * FROM registration WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $uid);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    echo "User not found.";
    exit();
} ?>