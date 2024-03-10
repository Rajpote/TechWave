<?php
// Start the session
session_start();

// Include the file containing the database connection code
include 'dbconn.php';

// Redirect the user to the home page if already logged in
if (isset($_SESSION['uname'])) {
    header('location: admin.php');
    exit(); // Stop further execution
}

// Check if login form is submitted
if (isset($_POST['login_submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SELECT query to fetch user by email
    $stmt = $conn->prepare("SELECT * FROM admin_ragister WHERE email=:email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $userauth = $stmt->fetch();

    // Verify password if user exists
    if ($userauth && password_verify($password, $userauth['password'])) {
        // Set session variables
        $_SESSION['uname'] = $userauth['email'];
        $_SESSION['id'] = $userauth['id'];

        // Redirect to home page
        header('location: home.php');
        exit(); // Stop further execution
    } else {
        // Authentication failed, display error message
        $loginError = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link to CSS files and external libraries -->
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <main>
        <section class="flex items-center justify-center min-h-[100vh] p-5 bg-slate-400 bg-cover bg-center bg-no-repeat"
            style="background-image: url(../img/vojtech-bruzek-J82GxqnwKSs-unsplash.jpg)">
            <div>
                <div class="p-10 backdrop-blur-xl rounded-xl">
                    <form action="" method="post" class="flex flex-col space-y-4">
                        <div>
                            <label for="email" class="text-slate-700 font-semibold font-serif">Email</label>
                            <input type="text" name="email" id="email" placeholder="example@gmail.com"
                                class="px-4 py-2 rounded-md border-b-2 bg-transparent focus:outline-none focus:border-blue-500 transition-colors duration-300" />
                        </div>
                        <div>
                            <label for="password" class="text-slate-700 font-semibold font-serif">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="passwordField"
                                    class="px-4 py-2 rounded-md border-b-2 bg-transparent focus:outline-none focus:border-blue-500 transition-colors duration-300" />
                                <span id="togglePassword"
                                    class="absolute top-0 right-0 mt-2 mr-4 cursor-pointer text-slate-700"><i
                                        class="fas fa-eye" id="toggleIcon"></i></span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <a href="" class="text-purple-700 text-sm">Forget Password</a>
                            <a href="signup.php" class="text-blue-800 text-sm">Sign Up</a>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit"
                                class="bg-slate-500 rounded-lg my-3 hover:scale-110 shadow-lg hover:shadow-xl transition-transform ease-in px-6 py-3 font-bold text-white">Login</button>
                        </div>
                    </form>
                    <!-- Error toast for failed login -->
                    <?php if (isset($loginError)): ?>
                        <div id="loginErrorToast" class="toast bg-red-500 text-white px-4 py-2 rounded-md">
                            <button type="button" class="ml-auto focus:outline-none">&times;</button>
                            <p>
                                <?php echo $loginError; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

    </main>
    <script src="../javsscript/signup.js"></script>
</body>

</html>