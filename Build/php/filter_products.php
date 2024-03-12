<?php
include 'dbconn.php';

// Get the category and type parameters from the form submission
$category = isset($_POST['category']) ? $_POST['category'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';

// Build the SQL query based on the received parameters
$sql = "SELECT * FROM product";

if (!empty($category) && !empty($type)) {
    // Filter by both category and type
    $sql .= " WHERE category = :category AND type = :type";
} elseif (!empty($category)) {
    // Filter only by category
    $sql .= " WHERE category = :category";
} elseif (!empty($type)) {
    // Filter only by type
    $sql .= " WHERE type = :type";
}

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Bind parameters if necessary
if (!empty($category) && !empty($type)) {
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':type', $type);
} elseif (!empty($category)) {
    $stmt->bindParam(':category', $category);
} elseif (!empty($type)) {
    $stmt->bindParam(':type', $type);
}

// Execute the SQL statement
$stmt->execute();

// Fetch the filtered products
$filteredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the filtered products as JSON
echo json_encode($filteredProducts);
?>