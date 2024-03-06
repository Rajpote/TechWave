<?php
session_start();
include 'dbconn.php';
// Function to calculate average rating
require_once 'rating.php';

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


// Query to retrieve feedback for the gadget
$sqlFeedback = "SELECT f.*, u.uname FROM feedback f
                JOIN registration u ON f.uname = u.uname
                WHERE f.g_id = :gadgetID";
$stmtFeedback = $conn->prepare($sqlFeedback);
$stmtFeedback->bindParam(':gadgetID', $g_id);
$stmtFeedback->execute();
$feedbackResults = $stmtFeedback->fetchAll(PDO::FETCH_ASSOC);
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
         <header class="bg-white-400 px-20 py-3 flex items-center justify-between sticky top-0 z-10 bg-slate-200">
            <div class="italic text-yellow-400 bg-black py-2 px-3 rounded-2xl">TechWave</div>
            <nav class="">
               <ul class="flex items-center text-black gap-5">
                  <li><a href="index.php" class="hover:text-yellow-500">Home</a></li>
                  <li><a href="product.php" class="hover:text-yellow-500">Product</a></li>
                  <li><a href="home.php" class="hover:text-yellow-500">Contact</a></li>
               </ul>
            </nav>
            <div>
               <input type="text" name="" id="" class="rounded-xl" />
            </div>
            <div class="flex items-center justify-center gap-6">
               <div>
                  <a href="cart.php" class="hover:text-slate-100 py-1"><i class="fa-solid fa-cart-shopping"></i></a>
               </div>
               <div class="gap-2 inline-block w-auto h-auto">
                  <i
                     class="text-center fa-solid fa-user rounded-full border-2 border-blue-500 h-auto w-8 hover:border-black"></i>
               </div>
            </div>
            <button class="hidden sm:text-slate-900"></button>
         </header>
         <main class="mx-10">
            <article class="flex items-center justify-center px-10 gap-6 mt-[-10px]">
               <section>
                  <div>
                     <div class="h-auto w-full rounded-xl">
                        <?php
                        echo "<img class='w-full h-auto md:h-48 lg:h-64 xl:h-80 2xl:h-96 rounded-xl' src='../img/{$row['gimage']}' alt='Gadget Image'>";
                        ?>
                     </div>
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
                                    echo '<i class="fas fa-star"></i>';
                                 } elseif ($i - 0.5 == $rating) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                 } else {
                                    echo '<i class="far fa-star"></i>';
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
                              echo "<p class='gprice'>RS: {$row['gprice']} </p>";
                              ?>
                           </div>
                        </div>
                        <div class="py-5 w-3/4">
                           <p>
                              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ad recusandae itaque facere,
                              quae, facilis animi saepe id aut inventore ipsum reiciendis odit porro veritatis
                              deserunt suscipit iure, error sed.
                           </p>
                        </div>
                        <form action="" method="POST">
                           <div class="flex items-center px-4 gap-5">
                              <div class="cart-item">
                                 <input type="number" name="quantity">
                              </div>

                              <input type="number" name="g_id" value="<?php echo $g_id ?>" hidden>
                              <input type="text" name="name" value="<?php echo $row['gname'] ?>" hidden>
                              <input type="number" name="price" value="<?php echo $row['gprice'] ?>" hidden>


                           </div>
                           <br>
                           <input type="submit" class="bg-blue-500" name="add-cart" value="Add to Cart">
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
                              href="#discription">Discription</a></li>
                        <li class="p-2 hover:bg-purple-500 rounded-md hover:text-white bg-slate-400"><a
                              href="#specification">Specification</a></li>
                        <li class="p-2 hover:bg-purple-500 rounded-md hover:text-white bg-slate-400"><a
                              href="#review">Review</a></li>
                     </ul>
                  </div>
               </section>
               <section id="discription">
                  <?php
                  $gdis = explode("\n", $row['gdis']);
                  echo "<ul>";
                  foreach ($gdis as $point) {
                     echo "<li class='points' style='font-size: 1.15rem;'>$point</li>";
                  }
                  echo "</ul>";
                  ?>
               </section>
               <section id="specification">
                  <table>
                     <tr>
                        <th class="table-heading">
                           <?php echo $row['gname']; ?>
                        </th>
                        <?php

                        foreach ($selectedGadgetDetails as $selectedGadget) {
                           echo '<th class="table-heading">' . $selectedGadget['gname'] . '</th>';
                        }
                        ?>
                     </tr>
                     <tr>
                        <td class="table-body">
                           <?php
                           $gspecifation = explode("\n", $row['gspecification']);
                           echo "<ul>";
                           foreach ($gspecifation as $point) {
                              echo "<li class='point' style='font-size: 1.15rem; margin-bottom: 1vh; text-align: justify;'>$point</li>";
                           }
                           echo "</ul>";
                           ?>
                        </td>
                        <td class="table-body">
                           <p>Gadgets comparison:</p>
                           <form class="compare-form" action="" method="POST">
                              <div class="select-container">
                                 <select name="comparison_gadgets[]">
                                    <?php
                                    foreach ($comparisonGadgets as $compGadget) {
                                       echo '<option value="' . $compGadget['g_id'] . '">' . $compGadget['gname'] . '</option>';
                                    }
                                    ?>
                                 </select>
                              </div>
                              <input type="submit" name="compare-submit" value="Compare">
                           </form>
                           <?php
                           if (count($selectedGadgetDetails) > 0) {
                              foreach ($selectedGadgetDetails as $selectedGadget) {
                                 $selectedSpecs = explode("\n", $selectedGadget['gspecification']);
                                 echo "<ul>";
                                 foreach ($selectedSpecs as $spec) {
                                    echo "<li class='point' style='font-size: 1.15rem; margin-bottom: 1vh; text-align: justify;'>$spec</li>";
                                 }
                                 echo "</ul>";
                              }
                           }
                           ?>
                        </td>
                     </tr>
                  </table>
               </section>
               <section id="review">
                  <!-- Feedback Form -->
                  <form action="" method="POST" class="feedback-link">
                     <div class="feedback-username">
                        <?php echo $_SESSION['uname']; ?>
                     </div>
                     <div class="container">
                        <div class="rating">
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
                     <textarea name="feedback" id="" cols="20" rows="3" class="textarea" required></textarea>
                     <div class="feedback" id="submit-btn">
                        <input type="submit" name="feedback-submit" id="feedback-btn" value="Submit" />
                     </div>
                  </form>
                  <div class="submitted-feedback">
                     <h2>Reviews</h2>
                     <ul>
                        <?php
                        foreach ($feedbackResults as $feedback) {
                           if ($feedback['status'] === 'Approved') {
                              echo '<li>';
                              echo '<strong>Username:</strong> ' . $feedback['uname'] . '<br>';
                              echo '<strong>Rating:</strong> ' . $feedback['rating'] . '<br>';
                              echo '<strong>Feedback:</strong> ' . $feedback['feedback'];
                              echo '</li>';
                           }
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
   <script>
      document.addEventListener("DOMContentLoaded", function () {
         const showComparison = document.querySelector(".showcomparison");
         const showLink = document.querySelector(".showlink");
         const showFeedback = document.querySelector(".showfeedback");


         const comparisonContainer = document.querySelector(".comparison-container");
         const linkContainer = document.querySelector(".link-container");
         const feedbackContainer = document.querySelector(".feedback-container");

         linkContainer.style.display = "none";
         feedbackContainer.style.display = "none";

         showComparison.addEventListener("click", function () {
            linkContainer.style.display = "none";
            feedbackContainer.style.display = "none";
            comparisonContainer.style.display = "block";
         });

         showLink.addEventListener("click", function () {
            linkContainer.style.display = "block";
            feedbackContainer.style.display = "none";
            comparisonContainer.style.display = "none";
         });

         showFeedback.addEventListener("click", function () {
            linkContainer.style.display = "none";
            feedbackContainer.style.display = "block";
            comparisonContainer.style.display = "none";
         });
      });
   </script>
   <script src="../javsscript/user.js"></script>
</body>

</html>