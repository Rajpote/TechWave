<?php
session_start();
include 'dbconn.php';

$id = $_GET['id'];
$query = "SELECT * FROM registration where id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    // Handle the case where the query did not fetch any result
    echo "User not found.";
    // Optionally, you can redirect the user or display an error message
} else {
    if (isset($_POST['submit'])) {
        $uname = $_POST['uname'];
        $email = $_POST['email'];
        $phnumber = ($_POST['phnumber']);
        $email = ($_POST['email']);

        $sql = "UPDATE registration SET uname = :uname, email = :email, phnumber = :phnumber WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':uname', $uname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phnumber', $phnumber);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            echo '<script> alert("User updated successfully."); window.location.href = "user.php"; </script>';
        } else {
            echo "Error updating user: " . $stmt->errorInfo()[2];
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container1">
        <form action="" method="POST" class="register-form">
            <div>
                <h1>Update Form</h1>
            </div>
            <div class="container">
                <label for="uname">user name:</label>
                <input type="text" id="uname" name="uname" value="<?php echo $result['uname']; ?>" required />
            </div>
            <div class="container">
                <label for="phone number">Phone Number:</label>
                <input type="number" id="num" name="phnumber" value="<?php echo $result['phnumber']; ?>" required />
            </div>
            <div class="container">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo $result['email']; ?>" required />
            </div>

            <div class="container0">
                <input type="checkbox" required>
                <span>I agree with all thr <strong>term & condition</strong> </span>
            </div>
            <div class="reg-btn">
                <input type="submit" class="submit" name="submit" id="submit" value="update">
            </div>
        </form>
    </div>
</body>

</html>