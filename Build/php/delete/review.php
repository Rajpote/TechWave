<?php
// include '../dbconn.php';

// if (isset($_GET['id'])) {
//     $Id = $_GET['id'];
//     $query = "DELETE FROM feedback WHERE feedback_id  = :Id";
//     $stmt = $conn->prepare($query);
//     $stmt->bindParam(':Id', $Id);
//     if ($stmt->execute()) {
//         echo "<script>alert('Feedback deleted successfully.'); window.location.href = '../manage_review.php';</script>";
//         exit(); // Add exit() to prevent further execution
//     } else {
//         echo "Error deleting feedback record: " . $stmt->errorInfo()[2];
//         exit(); // Add exit() to prevent further execution
//     }
// }
?>

<?php
// Include the database connection file
include '../dbconn.php';

// Check if 'id' parameter is set in the GET request
$feedback_id = isset($_GET['id']) ? $_GET['id'] : null;

if (isset($_GET['id'])) {
    // Sanitize and validate the input
    $Id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Prepare the DELETE query using a prepared statement
    $query = "DELETE FROM feedback WHERE feedback_id = :Id";
    $stmt = $conn->prepare($query);

    // Bind the parameter
    $stmt->bindParam(':Id', $Id, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        // Feedback deleted successfully, redirect to manage_review.php
        echo "<script>alert('Feedback deleted successfully.'); window.location.href = '../manage_review.php';</script>";
        exit(); // Add exit() to prevent further execution
    } else {
        // Error occurred while deleting the feedback record
        echo "Error deleting feedback record: " . $stmt->errorInfo()[2];
        exit(); // Add exit() to prevent further execution
    }
}
?>