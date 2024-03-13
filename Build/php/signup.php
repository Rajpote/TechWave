<?php
// Start the session
session_start();

// Include the file containing the database connection code
include 'dbconn.php';

// Handle form submission
if (isset($_POST['register-submit'])) {
   // Retrieve form data
   $uname = $_POST['uname'];
   $phnumber = $_POST['phnumber'];
   $email = $_POST['email'];
   $password = $_POST['password'];

   // Hash the password for security
   $hashed_password = password_hash($password, PASSWORD_DEFAULT);

   // Check if the user already exists
   $sql = "SELECT * FROM registration WHERE phnumber = ? OR email = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$phnumber, $email]);
   $result = $stmt->fetch();

   // If the user doesn't exist, register the user
   if (!$result) {
      // Insert user data into registration table
      $sql = "INSERT INTO registration (uname, phnumber, email, password) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);

      if ($stmt->execute([$uname, $phnumber, $email, $hashed_password])) {
         // Insert user data into profile_data table
         $sql = "INSERT INTO profile_info (uname, phnumber, email) VALUES (?, ?, ?)";
         $stmt = $conn->prepare($sql);

         if ($stmt->execute([$uname, $phnumber, $email])) {
            // Registration successful
            $success = 1;
         }
      }
   }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Document</title>
   <link rel="stylesheet" href="../css/output.css" />
   <link rel="stylesheet" href="../css/style.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
   <main>
      <section class="flex items-center justify-center min-h-[100vh] bg-slate-500 bg-center bg-cover "
         style="background-image: url(../img/vojtech-bruzek-J82GxqnwKSs-unsplash.jpg);">
         <div class="backdrop-blur-2xl rounded-xl p-3">
            <a href="index.php" class="p-4 rounded-2xl flex items-center justify-center">
               <img src="../techwave-logo-zip-file/png/logo-no-background.png" alt="" class="w-auto h-16">
            </a>
            <form action="" method="post" class="flex items-center justify-center flex-col py-2 rounded-md" id="myForm">
               <div class="flex flex-col px-5 py-3">
                  <label for="uname" class="text-slate-700 font-semibold font-serif pt-2">User Name:</label>
                  <input type="text" name="uname" id="uname"
                     class="px-2 py-1 rounded-md border-b-4 bg-transparent focus-within:bg-white focus:outline-none" />
                  <div id="unameError" class="text-red-500"></div>

                  <label for="phnumber" class="text-slate-700 font-semibold font-serif pt-2">Phone Number:</label>
                  <input type="text" name="phnumber" id="phnumber"
                     class="px-2 py-1 rounded-md border-b-4 bg-transparent focus-within:bg-white focus:outline-none" />
                  <div id="phnumberError" class="text-red-500"></div>

                  <label for="email" class="pt-2 text-slate-700 font-semibold font-serif">Email</label>
                  <input type="email" name="email" id="email"
                     class="px-2 py-1 rounded-md border-b-4 bg-transparent focus-within:bg-white focus:outline-none" />
                  <div id="emailError" class="text-red-500"></div>

                  <label for="password" class="pt-2 text-slate-700 font-semibold font-serif">Password</label>
                  <div class="relative">
                     <input type="password" name="password" id="passwordField"
                        class="px-2 py-1 rounded-md border-b-4 bg-transparent focus-within:bg-white focus:outline-none"
                        required />
                     <span id="togglePassword" class="absolute top-0 right-0 mt-2 mr-2 cursor-pointer"><i
                           class="fas fa-eye" id="toggleIcon"></i></span>
                  </div>
                  <div id="passwordError" class="text-red-500"></div>
               </div>
               <div class="mb-4">
                  <p>Already Have Account <a href="login.php" class="text-blue-700 hover:text-black">login</a></p>
               </div>
               <button type="submit" name="register-submit" class="p-2 bg-slate-400 hover:scale-105 rounded-md">Sign
                  In</button>
            </form>
         </div>
      </section>
   </main>
   <script src="../javsscript/signup.js"></script>
</body>

</html>