<?php
session_start();
include 'dbconn.php';
// Function to calculate average rating
require_once 'rating.php';

require_once 'user.php';

if (isset($_SESSION['id'])) {
   $id = $_SESSION['id'];
   $uname = $_SESSION['uname'];
}

if (isset($_POST['add-cart'])) {
   $id = $_SESSION['id'];
   $g_id = $_POST['g_id'];
   $name = $_POST['name'];
   $quantity = $_POST['quantity'];
   $price = $_POST['price'];

   $sql = "INSERT INTO cart (id, g_id, name, quantity, price) VALUES (:id, :g_id, :name, :quantity, :price)";
   $stmt = $conn->prepare($sql);
   $stmt->bindParam(':id', $id);
   $stmt->bindParam(':g_id', $g_id);
   $stmt->bindParam(':name', $name);
   $stmt->bindParam(':quantity', $quantity);
   $stmt->bindParam(':price', $price);
   $stmt->execute();
   echo '<script>alert("Added.");</script>';

}

function hasUserReviewed($conn, $gadgetID, $username)
{
   $query = "SELECT COUNT(*) AS review_count FROM feedback WHERE g_id = :gadgetID AND uname = :username";
   $stmt = $conn->prepare($query);
   $stmt->bindParam(':gadgetID', $gadgetID);
   $stmt->bindParam(':username', $username);
   $stmt->execute();
   $result = $stmt->fetch(PDO::FETCH_ASSOC);
   return $result['review_count'] > 0;
}


$selectedGadgetDetails = [];

if (isset($_POST['feedback-submit'])) {
   $uname = $_SESSION['uname'];
   $feedback = $_POST['feedback'];
   $rating = $_POST['rating'];
   $gadgetID = $_GET['g_id'];

   if (hasUserReviewed($conn, $gadgetID, $uname)) {
      echo '<script>alert("You have already reviewed this gadget.");</script>';
   } else {
      $sql = "INSERT INTO feedback (uname, feedback, rating, g_id, status) VALUES (:uname, :feedback, :rating, :gadgetID, 'Pending')";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':uname', $uname);
      $stmt->bindParam(':feedback', $feedback);
      $stmt->bindParam(':rating', $rating);
      $stmt->bindParam(':gadgetID', $gadgetID);
      $stmt->execute();
      echo '<script>alert("Feedback submitted successfully.");</script>';
   }
}

if (isset($_GET['g_id'])) {
   $g_id = $_GET['g_id'];

   $sql = "SELECT * FROM product WHERE g_id=:g_id";
   $stmt = $conn->prepare($sql);
   $stmt->bindParam(':g_id', $g_id);
   $stmt->execute();
   $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['compare-submit'])) {
   // Retrieve the selected gadgets for comparison
   $selectedGadgets = $_POST['comparison_gadgets'];

   // Retrieve gadget details for selected gadgets
   foreach ($selectedGadgets as $selectedGadgetID) {
      $sql = "SELECT * FROM product WHERE g_id=:g_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':g_id', $selectedGadgetID);
      $stmt->execute();
      $selectedGadget = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($selectedGadget) {
         // Check if the selected gadget has the same type as the current gadget
         if ($selectedGadget['type'] == $result[0]['type']) {
            $selectedGadgetDetails[] = $selectedGadget;
         }
      }
   }
}

// Retrieve all gadgets of the same type for the comparison select form
$sql = "SELECT * FROM product WHERE g_id != :g_id AND type = :type";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':g_id', $g_id);
$stmt->bindParam(':type', $result[0]['type']); // Filter by the type of the current gadget
$stmt->execute();
$comparisonGadgets = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Detail</title>

   <link rel="stylesheet" href="../css/output.css" />
   <link rel="stylesheet" href="../css/style.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
   <style>
      .rating {
         border: none;
         float: left;
         margin: 10px 10px 10px 10px;
      }

      .rating input[type="radio"] {
         display: none;
      }

      .rating>label:before {
         content: "\f005";
         font-family: FontAwesome;
         margin: 5px;
         font-size: 1.5rem;
         display: inline-block;
         cursor: pointer;
      }

      .rating>.half:before {
         content: "\f089";
         position: absolute;
         cursor: pointer;
      }

      .rating>label {
         color: #0a0101;
         float: right;
         cursor: pointer;
      }

      .rating>input:checked~label,
      .rating:not(:checked)>label:hover,
      .rating:not(:checked)>label:hover~label {
         color: darkorange;
      }

      .rating>input:checked+label:hover,
      .rating>input:checked~label:hover,
      .rating>label:hover~input:checked~label,
      .rating>input:checked~label:hover~label {
         color: darkorange;
      }
   </style>
</head>

<body>
   <?php
   if (count($result) > 0) {
      foreach ($result as $row) {
         ?>
         <header class="bg-white px-20 py-3 flex items-center justify-between sticky top-0 z-10 shadow-md">
            <a href="home.php" class="italic text-yellow-400 px-3 rounded-2xl">
               <img src="../techwave-logo-zip-file/png/logo-no-background.png" alt="" class="w-auto h-16">
            </a>
            <nav>
               <ul class="flex items-center text-black gap-5">
                  <li><a href="home.php" class="hover:text-yellow-500">Home</a></li>
                  <li><a href="product.php" class="hover:text-yellow-500">Product</a></li>
                  <li><a href="contact.php" class="hover:text-yellow-500">Contact</a></li>
               </ul>
            </nav>
            <!-- Search Form -->
            <div class="relative">
               <form action="search.php" method="post" class="flex items-center">
                  <input type="text" name="search"
                     class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                     placeholder="Search . . . " id="search" />
                  <button type="submit"
                     class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 border border-gray-300 rounded-lg ml-2">
                     <i id="search-icon" class="fa-solid fa-magnifying-glass"></i>
                  </button>
               </form>
            </div>
            <div class="flex items-center justify-center gap-6">
               <div>
                  <a href="cart.php" class="hover:text-blue-500 py-1"><i class="fa-solid fa-cart-shopping"></i></a>
               </div>
               <div>
                  <button id="popup-button"
                     class="text-center rounded-full border-2 border-blue-500 h-auto w-8 hover:border-black focus:outline-none">
                     <i class="fa-solid fa-user"></i>
                  </button>
                  <div id="overlay" class="hidden fixed top-0 left-0 w-full h-full bg-transparent z-10"></div>
                  <div id="popup-container"
                     class="hidden fixed top-20 right--2 transform -translate-x-1/2 bg-white p-4 shadow-lg z-50 rounded-lg">
                     <div class="relative">
                        <button id="close-popup"
                           class="text-3xl hover:text-red-600 absolute top-[-2rem] right-0">&times;</button>
                        <div id="username" class="mt-6">
                           <?php echo $_SESSION['uname'] ?>
                           <div class="update-user mt-4">
                              <a href="update_user.php?id=<?php echo $uid; ?>" class="text-blue-500 hover:underline">Update
                                 Details</a>
                           </div>
                           <div class="logout mt-2">
                              <a href="logout.php" class="text-red-500 hover:underline">Logout</a>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
         </header>
         <main class="mx-10 mt-20">
            <article class="flex items-center justify-center px-10 gap-6 mt-[-10px]">
               <section class="h-auto w-1/3 rounded-xl">

                  <div class="h-auto w-full rounded-xl">
                     <?php
                     echo "<img class='w-full h-auto md:h-48 lg:h-64 xl:h-80 2xl:h-96 rounded-xl' src='../img/{$row['gimage']}' alt='Gadget Image'>";
                     ?>
                  </div>

               </section>
               <section class="pr-10">
                  <div>
                     <div>
                        <h2 class="text-start font-semibold text-4xl">
                           <?php echo $row['gname']; ?>
                        </h2>
                        <div class="flex items-center justify-between py-5">
                           <div>
                              <?php
                              $averageRating = calculateAverageRating($conn, $g_id);
                              $rating = round($averageRating * 2) / 2;
                              for ($i = 1; $i <= 5; $i++) {
                                 if ($i <= $rating) {
                                    echo '<i class="fas fa-star text-yellow-400"></i>';
                                 } elseif ($i - 0.5 == $rating) {
                                    echo '<i class="fas fa-star-half-alt text-yellow-400"></i>';
                                 } else {
                                    echo '<i class="far fa-star text-yellow-400"></i>';
                                 }
                              }
                              ?>
                              <?php
                              $averageRating = calculateAverageRating($conn, $g_id);
                              echo number_format($averageRating, 1);
                              ?>
                           </div>
                           <div class="text-3xl text-purple-400">
                              <?php
                              echo "<p class='gprice'>$ {$row['gprice']} </p>";
                              ?>
                           </div>
                        </div>
                        <div class="py-5 w-3/4">
                           <?php
                           echo "<p class='gprice'>{$row['gdis']} </p>";
                           ?>
                        </div>
                        <form action="" method="POST" class="flex items-center px-4 gap-5">
                           <div class="cart-item">
                              <input type="number" name="quantity"
                                 class="border border-gray-300 px-3 py-1 rounded-md focus:outline-none focus:border-blue-500">
                           </div>
                           <input type="number" name="g_id" value="<?php echo $g_id ?>" hidden>
                           <input type="text" name="name" value="<?php echo $row['gname'] ?>" hidden>
                           <input type="number" name="price" value="<?php echo $row['gprice'] ?>" hidden>
                           <input type="submit"
                              class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600"
                              name="add-cart" value="Add to Cart">
                        </form>
                     </div>
                  </div>
               </section>
            </article>

            <hr />
            <article class="px-10 my-10">
               <section class="w-1/3 shadow-md rounded-xl">
                  <div>
                     <ul class="flex items-center gap-4 p-2">
                        <li class="p-2 hover:bg-purple-500 rounded-md hover:text-white bg-slate-400"><a
                              href="#specification">Specification</a></li>
                        <li class="p-2 hover:bg-purple-500 rounded-md hover:text-white bg-slate-400"><a
                              href="#review">Review</a></li>
                     </ul>
                  </div>
               </section>
               <section id="specification">
                  <table class="w-2/3 border-collapse border border-gray-300">
                     <tr>
                        <th class="table-heading p-3 bg-gray-200 text-left">
                           <?php echo $row['gname']; ?>
                        </th>
                     </tr>
                     <tr>
                        <td class="table-body p-3">
                           <?php
                           $gspecification = explode("\n", $row['gspecification']);
                           echo "<ul class='list-disc pl-5'>";
                           foreach ($gspecification as $point) {
                              echo "<li class='text-base mb-2 list-none'>" . $point . "</li>";
                           }
                           echo "</ul>";
                           ?>
                        </td>
                     </tr>
                  </table>

               </section>
               <section id="review" class="py-8 flex items-center w-full">
                  <!-- Feedback Form -->
                  <form action="" method="POST" class="feedback-link bg-gray-100 p-4 rounded-md w-1/3">
                     <div class="feedback-username text-lg font-bold mb-4">
                        <?php echo $_SESSION['uname']; ?>
                     </div>
                     <div class="container">
                        <div class="rating mb-4">
                           <input type="radio" id="star5" name="rating" value="5" /><label for="star5" class="full"
                              title="Awesome"></label>
                           <input type="radio" id="star4.5" name="rating" value="4.5" /><label for="star4.5"
                              class="half"></label>
                           <input type="radio" id="star4" name="rating" value="4" /><label for="star4" class="full"></label>
                           <input type="radio" id="star3.5" name="rating" value="3.5" /><label for="star3.5"
                              class="half"></label>
                           <input type="radio" id="star3" name="rating" value="3" /><label for="star3" class="full"></label>
                           <input type="radio" id="star2.5" name="rating" value="2.5" /><label for="star2.5"
                              class="half"></label>
                           <input type="radio" id="star2" name="rating" value="2" /><label for="star2" class="full"></label>
                           <input type="radio" id="star1.5" name="rating" value="1.5" /><label for="star1.5"
                              class="half"></label>
                           <input type="radio" id="star1" name="rating" value="1" /><label for="star1" class="full"></label>
                           <input type="radio" id="star0.5" name="rating" value="0.5" /><label for="star0.5"
                              class="half"></label>
                        </div>
                     </div>
                     <textarea name="feedback" id="" cols="20" rows="3"
                        class="textarea w-full p-2 rounded-md border border-gray-300 focus:outline-none focus:border-indigo-500"
                        required></textarea>
                     <div class="feedback text-center mt-4" id="submit-btn">
                        <input type="submit" name="feedback-submit" id="feedback-btn" value="Submit"
                           class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-md cursor-pointer" />
                     </div>
                  </form>
                  <div class="submitted-feedback  mt-8 w-full">
                     <h2 class="text-xl font-bold mb-4">Reviews</h2>
                     <ul class="p-4">
                        <?php
                        // Prepare SQL command
                        $sqlFeedback = "SELECT * FROM feedback WHERE g_id = :gadgetID";
                        $stmtFeedback = $conn->prepare($sqlFeedback);
                        $stmtFeedback->bindParam(':gadgetID', $g_id);
                        $stmtFeedback->execute();

                        // Fetch feedback results
                        $feedbackResults = $stmtFeedback->fetchAll(PDO::FETCH_ASSOC);

                        // Check if any feedback records are returned
                        if ($stmtFeedback->rowCount() > 0) {
                           // Loop through the feedback results and display approved reviews
                           foreach ($feedbackResults as $feedback) {
                              if ($feedback['status'] === 'Approved') {
                                 echo '<li class="bg-red-200 rounded-md my-2 p-4">';
                                 echo '<strong><i class="fa-solid fa-user"></i>:</strong> ' . $feedback['uname'] . '<br>';
                                 echo '<strong><i class="fas fa-star text-yellow-500"></i>:</strong> ' . $feedback['rating'] . '<br>';
                                 echo '' . $feedback['feedback'];
                                 echo '</li>';
                              }
                           }
                        } else {
                           echo "No feedback records found for gadget  ";
                        }
                        ?>

                     </ul>
                  </div>
               </section>

            </article>
         </main>
         <?php
      }
   }
   ?>
   <script>
      function showDeviceType(type) {
         window.location.href = "category.php?type=" + type;
      }
   </script>

   <script src="../javsscript/user.js"></script>
</body>

</html>