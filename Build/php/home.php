<?php
// session_start();
include 'dbconn.php';

// if (!isset($_SESSION['username'])) {
//    header('location: home.php');
//    exit(); // Ensure that the script stops here if the user is not logged in.
// }

// $g_id;
// $i = 0;
// $searchValue;
// $count = isset($_GET['count']) ? (int) $_GET['count'] : 0; // Ensure that $count is an integer.
// $username = $_SESSION['username'];

// $stmt = $conn->prepare("SELECT id FROM register WHERE uname = :username");
// $stmt->bindParam(':username', $username);
// $stmt->execute();
// $uid = $stmt->fetch(PDO::FETCH_COLUMN);

function calculateAverageRating($conn, $gadgetID)
{
   $query = "SELECT AVG(rating) AS average_rating FROM feedback WHERE g_id = :gadgetID";
   $stmt = $conn->prepare($query);
   $stmt->bindParam(':gadgetID', $gadgetID);
   $stmt->execute();
   $result = $stmt->fetch(PDO::FETCH_ASSOC);
   return isset($result['average_rating']) ? $result['average_rating'] : 0;
}

$value = array(); // Initialize the $value array.

do {
   $g_id = isset($_GET[$i]) ? (int) $_GET[$i] : null; // Ensure that $g_id is an integer.

   if ($g_id !== null) {
      $stmt = $conn->prepare("SELECT * FROM product WHERE g_id = :g_id");
      $stmt->bindParam(':g_id', $g_id);

      $stmt->execute();
      $value[$i] = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $searchValue = true;
   } else {
      $searchValue = false;
   }
   $i++;
} while ($i < $count);

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
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>

   <?php
   if ($searchValue) { ?>
      <ul class="navbar">
         <form action="search.php" method="post">
            <input type="text" name="search" class="search-bars" placeholder="Search . . . " id="search" /><i
               class="fa-solid fa-magnifying-glass"></i>
         </form>
      </ul>
      <a class="back-arrow" href="user.php">&LeftArrow;</a>
      <h2 class="result">Found results.</h2>
      <?php
      echo '<div class="searchcontainer">';
      foreach ($value as $item) {
         echo '<a href="information.php?g_id=' . $item[0]['g_id'] . '" class="search-item">';
         echo "<img class='g-img' src='image/product/{$item[0]['gimage']}' alt='Gadget Image'>";
         echo '<div class="gadget-section">';
         echo '<div class="gadget-name">' . $item[0]['gname'] . '</div>';
         echo '<div class="gadget-price">Rs:' . $item[0]['gprice'] . '</div>';
         echo '<div class="gadget-rating">';
         $averageRating = calculateAverageRating($conn, $item[0]['g_id']); // Corrected variable name here.
         $rating = round($averageRating * 2) / 2; // Round to nearest half
         for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
               echo '<i class="fas fa-star" style="color: gold;"></i>';
            } elseif ($i - 0.5 == $rating) {
               echo '<i class="fas fa-star-half-alt" style="color: gold;"></i>';
            } else {
               echo '<i class="far fa-star" style="color: gold;"></i>';
            }
         }
         echo ' ' . number_format($averageRating, 1);
         echo '</div>';
         echo '</div>';
         echo '</a>';
      }
      echo '</div>';
      ?>
      <?php
   } else ?>

   <header class="bg-white-400 px-20 mb-10 py-3 flex items-center justify-between sticky top-0 z-10 bg-slate-200">
      <div class="italic text-yellow-400 bg-black py-2 px-3 rounded-2xl">TechWave</div>
      <nav class="">
         <ul class="flex items-center text-black gap-5">
            <li><a href="index.php" class="hover:text-yellow-500">Home</a></li>
            <li><a href="product.php" class="hover:text-yellow-500">Product</a></li>
            <li><a href="home.php" class="hover:text-yellow-500">Contact</a></li>
         </ul>
      </nav>
      <div>
         <form action="search.php" method="post">
            <input type="text" name="search" class="search-bar" placeholder="Search . . . " id="search" />
            <i id="search-icon" class="fa-solid fa-magnifying-glass"></i>
         </form>
      </div>
      <div class="flex items-center justify-center gap-6">
         <div>
            <a href="cart.php" class="hover:text-slate-100 py-1"><i class="fa-solid fa-cart-shopping"></i></a>
         </div>
         <div>
            <button id="popup-button"><i
                  class="text-center fa-solid fa-user rounded-full border-2 border-blue-500 h-auto w-8 hover:border-black"></i></button>
            <div id="overlay" class="hidden fixed top-10 left-0 w-full h-full bg-transparent z-10"></div>
            <div id="popup-container"
               class="hidden fixed top-16 right-0 translate-[-50%, -50%] bg-white p-5 shadow-2xl z-10">
               <div id="username" class="container">
                  <?php echo $_SESSION['username'] ?>
               </div>
               <div class="user-fun">
                  <div class="update-user">
                     <a href="update.php?id=<?php echo $uid; ?>">update</a>
                  </div>
                  <div class="logout">
                     <a href="logout.php">logout</a>
                  </div>
               </div>>
               <button id="close-popup">Close</button>
            </div>
         </div>
      </div>
      <button class="hidden sm:text-slate-900"></button>
   </header>
   <main class="px-20 mt-[-2.5rem]">
      <section class="flex items-center justify-center my-10">
         <!-- Slider main container -->
         <div class="swiper rounded-b-3xl">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper h-full w-full ease-in-out">
               <!-- Slides -->
               <div class="swiper-slide">
                  <img src=" ../img/vojtech-bruzek-J82GxqnwKSs-unsplash.jpg" alt=""
                     class="h-[70vh] w-full bg-cover block" />
                  <div class="absolute top-[30%] left-2 w-auto">
                     <h3 class="text-5xl text-slate-200 font-bold">hello world</h3>
                     <p class="text-2xl w-2/5 font-serif">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Blanditiis dicta inventore excepturi quae? A, in.</p>
                  </div>
               </div>
               <div class="swiper-slide">
                  <img src="../img/vojtech-bruzek-J82GxqnwKSs-unsplash.jpg" alt=""
                     class="h-[70vh] w-full bg-cover block" />
                  <div class="absolute top-[30%] left-2 w-auto">
                     <h3 class="text-5xl text-slate-200 font-bold">hello world</h3>
                     <p class="text-2xl w-2/5 font-serif">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Blanditiis dicta inventore excepturi quae? A, in.</p>
                  </div>
               </div>
               <div class="swiper-slide">
                  <img src="../img/vojtech-bruzek-J82GxqnwKSs-unsplash.jpg" alt=""
                     class="h-[70vh] w-full bg-cover block" />
                  <div class="absolute top-[30%] left-2 w-auto">
                     <h3 class="text-5xl text-slate-200 font-bold">hello world</h3>
                     <p class="text-2xl w-2/5 font-serif">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Blanditiis dicta inventore excepturi quae? A, in.</p>
                  </div>
               </div>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
         </div>
      </section>
      <hr />
      <section class="px-10 my-10">
         <div>
            <h2 class="text-4xl text-slate-900">Featured Product</h2>
            <div class="mx-20 my-5">
               <div class="flex items-center justify-center gap-9">
                  <?php
                  $sql = "SELECT * FROM product WHERE category = 'deals' LIMIT 6";
                  $stmt = $conn->query($sql);

                  if ($stmt->rowCount() > 0) {
                     while ($row = $stmt->fetch()) {
                        ?>
                        <div
                           class="w-1/5 h-2/6 bg-slate-100 rounded-xl hover:bg-white hover:text-slate-100 shadow hover:shadow-xl">
                           <a href="information.php?g_id=<?php echo $row['g_id']; ?>">
                              <img class="pro-img" src="../img/<?php echo $row['gimage']; ?>" alt="Gadget Image"
                                 class="rounded-xl">
                              <div class="gadget-section">
                                 <div>
                                    <h3 class="text-slate-700 font-semibold mx-4">
                                       <?php echo $row['gname']; ?>
                                    </h3>
                                    <p class="mx-4 text-purple-500"><span>&#36;
                                          <?php echo $row['gprice']; ?>
                                       </span></p>
                                 </div>
                                 <div class="gadget-rating">
                                    <?php
                                    $averageRating = calculateAverageRating($conn, $row['g_id']);
                                    $rating = round($averageRating * 2) / 2;

                                    for ($i = 1; $i <= 5; $i++) {
                                       if ($i <= $rating) {
                                          echo '<i class="fas fa-star" style="color: gold;"></i>';
                                       } elseif ($i - 0.5 == $rating) {
                                          echo '<i class="fas fa-star-half-alt" style="color: gold;"></i>';
                                       } else {
                                          echo '<i class="far fa-star" style="color: gold;"></i>';
                                       }
                                    }
                                    echo ' ' . number_format($averageRating, 1);
                                    ?>
                                 </div>
                              </div>
                           </a>
                        </div>
                        <?php
                     }
                  } else {
                     echo "No deals found.";
                  }
                  ?>

               </div>

            </div>
            <button class="py-3 px-4 my-0 mx-auto block bg-slate-400 rounded-xl">See All</button>
         </div>
         </div>
      </section>
      <hr />
      <section class="px-10 my-10">
         <div class="main_product">
            <h2 class="text-3xl text-slate-800">Deals</h2>
            <div class="flex items-center justify-evenly gap-6 max-h-full mt-4">
               <div class="bg-purple-300 w-1/3 rounded-xl">
                  <div class="w-full h-44 p-3">
                     <img src="../img/vojtech-bruzek-J82GxqnwKSs-unsplash.jpg" alt="" height="200px"
                        class="h-full w-full rounded-xl" />
                  </div>
                  <div class="text-slate-500 text-left p-1 m-2">
                     <p>Iphone 13 Pro Amx</p>
                     <span>&#36;760 </span>
                  </div>
               </div>
               <div class="bg-purple-300 w-1/3 rounded-xl">
                  <div class="w-full h-44 p-3">
                     <img src="../img/vojtech-bruzek-J82GxqnwKSs-unsplash.jpg" alt="" height="200px"
                        class="h-full w-full rounded-xl" />
                  </div>
                  <div class="text-slate-500 text-left p-1 m-2">
                     <p>Iphone 13 Pro Amx</p>
                     <span>&#36;760 </span>
                  </div>
               </div>
               <div class="bg-purple-300 w-1/3 rounded-xl">
                  <div class="w-full h-44 p-3">
                     <img src="../img/vojtech-bruzek-J82GxqnwKSs-unsplash.jpg" alt="" height="200px"
                        class="h-full w-full rounded-xl" />
                  </div>
                  <div class="text-slate-500 text-left p-1 m-2">
                     <p>Iphone 13 Pro Amx</p>
                     <span>&#36;760 </span>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <hr />
   </main>
   <footer class="bg-yellow-200 px-10 mt-10">
      <div class="italic text-yellow-400 bg-black py-2 px-3 mx-10 rounded-2xl w-[6%]">TechWave</div>
      <div
         class="flex items-start justify-between text-slate-800 bg-yellow-200 gap-2 px-14 py-4 mt-4 relative bottom-0">
         <ul>
            <li>ph:9800000000</li>
            <li><a href="">rrajpote666@gmail.com</a></li>
            <li>sjfnnfn</li>
         </ul>
         <ul>
            <li><a href="">About Us</a></li>
            <li><a href="">Term & Condition</a></li>
            <li><a href="">Support</a></li>
         </ul>
         <ul class="flex gap-3 justify-center items-center">
            <li>
               <a href=""><i class="fa-brands fa-square-facebook text-2xl hover:text-blue-500"></i></a>
            </li>
            <li>
               <a href=""><i class="fa-brands fa-youtube text-2xl hover:text-red-500"></i></a>
            </li>
            <li>
               <a href=""><i class="fa-brands fa-square-instagram text-2xl hover:text-purple-500"></i></a>
            </li>
         </ul>
      </div>
   </footer>
   <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
   <script src="../javsscript/script.js"></script>
   <script src="../javsscript/user.js"></script>
</body>

</html>