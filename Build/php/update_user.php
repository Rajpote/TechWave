<?php
session_start();
include 'dbconn.php';

// Check if user is logged in
if (!isset($_SESSION['uname'])) {
    header('location: home.php');
    exit();
}

// Check if user ID is provided
if (!isset($_GET['id'])) {
    echo "User ID not provided.";
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM registration WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    echo "User not found.";
    exit();
}

if (isset($_POST['submit'])) {
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $phnumber = intval($_POST['phnumber']); // Convert to integer

    $sql = "UPDATE registration SET uname = :uname, email = :email, phnumber = :phnumber WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':uname', $uname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phnumber', $phnumber, PDO::PARAM_INT); // Bind as integer
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo '<script> alert("User updated successfully."); window.location.href = "home.php"; </script>';
        exit();
    } else {
        echo "Error updating user: " . $stmt->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <div class="container mx-auto p-4 w-1/2">
        <h1 class="text-2xl font-bold mb-4 text-center">Update User</h1>
        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="uname" class="block">Username:</label>
                <input type="text" id="uname" name="uname" value="<?php echo $result['uname']; ?>" required
                    class="w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="phnumber" class="block">Phone Number:</label>
                <input type="text" id="phnumber" name="phnumber" value="<?php echo $result['phnumber']; ?>" required
                    class="w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="email" class="block">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $result['email']; ?>" required
                    class="w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <input type="submit" name="submit" value="Update"
                    class="w-1/3 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 cursor-pointer">
            </div>
        </form>
    </div>
</body>

</html>