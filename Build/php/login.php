<?php
// Start the session
session_start();

// Include the file containing the database connection code
include 'dbconn.php';

// Redirect the user to the home page if already logged in
if (isset($_SESSION['uname'])) {
   header('location: home.php');
   exit(); // Stop further execution
}

// Check if login form is submitted
if (isset($_POST['login_submit'])) {
   $email = $_POST['email'];
   $password = $_POST['password'];

   // Prepare and execute SELECT query to fetch user by email
   $stmt = $conn->prepare("SELECT * FROM registration WHERE email=:email");
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
               <form action="" method="post">
                  <div class="flex flex-col">
                     <label for="email" class="text-slate-700 font-semibold font-serif">Email</label>
                     <input type="text" name="email" id="email" placeholder="example@gmail.com"
                        class="px-2 py-1 rounded-md border-b-4 bg-transparent focus-within:bg-white focus:outline-none" />

                     <label for="password" class="text-slate-700 font-semibold font-serif">Password</label>
                     <div class="relative">
                        <input type="password" name="password" id="passwordField"
                           class="px-2 py-1 rounded-md border-b-4 bg-transparent focus-within:bg-white focus:outline-none" />
                        <span id="togglePassword" class="absolute top-0 right-0 mt-2 mr-2 cursor-pointer"><i
                              class="fas fa-eye" id="toggleIcon"></i></span>
                     </div>
                  </div>
                  <div class="flex justify-between px-0 py-1 gap-4">
                     <a href="" class="text-purple-700">Forget Password</a>
                     <a href="signup.php" class="text-blue-800">Sign</a>
                  </div>
                  <div class="flex justify-center">
                     <button type="submit"
                        class="bg-slate-500 rounded-xl my-3 hover:scale-110 shadow hover:shadow-xl ease-in px-4 py-3 font-bold"
                        name="login_submit">Login</button>
                  </div>
               </form>
               <!-- Error toast for failed login -->
               <?php if (isset($loginError)): ?>
                  <alert id="loginErrorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                     <div class="toast-header">
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                     </div>
                     <div class="toast-body">
                        <?php echo $loginError; ?>
                     </div>
                  </alert>
               <?php endif; ?>
            </div>
         </div>
      </section>
   </main>
   <script src="../javsscript/signup.js"></script>
</body>

</html>