<?php
session_start();
include 'dbconn.php';
require_once 'rating.php';
require_once 'user.php';
if (!isset($_SESSION['uname'])) {
   header('location: home.php');
   exit(); // Ensure that the script stops here if the user is not logged in.
}

$g_id;
$i = 0;
$searchValue;
$count = isset($_GET['count']) ? (int) $_GET['count'] : 0; // Ensure that $count is an integer.
$uname = $_SESSION['uname'];


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
   <title>Home</title>
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
            <input type="text" name="search" class="search-bars px-2 py-1 rounded" placeholder="Search . . . "
               id="search" /><i class="fa-solid fa-magnifying-glass"></i>
         </form>
      </ul>
      <a class="back-arrow" href="home.php">&LeftArrow;</a>
      <h2 class="result">Found results.</h2>
      <?php
      echo '<div class="searchcontainer grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">';
      foreach ($value as $item) {
         $gadgetID = $item[0]['g_id']; // Assign value to $gadgetID here
         echo '<a href="information.php?g_id=' . $item[0]['g_id'] . '" class="search-item block rounded overflow-hidden shadow-lg bg-slate-500 p-4">';
         echo "<img class='g-img w-1/4 h-auto' src='../img/{$item[0]['gimage']}' alt='Gadget Image'>";
         echo '<div class="gadget-section bg-white p-4">';
         echo '<div class="gadget-name text-xl font-semibold">' . $item[0]['gname'] . '</div>';
         echo '<div class="gadget-price text-lg text-gray-800">$' . $item[0]['gprice'] . '</div>';
         echo '<div class="gadget-rating mt-2">';
         echo '<div class="pro-name">' . displayRating($conn, $gadgetID) . '</div>'; // Use $gadgetID here
         echo '</div>';
         echo '</div>';
         echo '</a>';
      }
      echo '</div>';
      ?>

      <?php
   } else {
      ?>



      <header class="bg-white px-20 mb-10 py-3 flex items-center justify-between sticky top-0 z-10 shadow-md">
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


      <main class="px-20 mt-[-2.5rem]">
         <section class="flex items-center justify-center my-10">
            <!-- Slider main container -->
            <div class="swiper rounded-b-3xl">
               <!-- Additional required wrapper -->
               <div class="swiper-wrapper h-full w-full ease-in-out">
                  <!-- Slides -->
                  <?php
                  $sql = "SELECT * FROM product WHERE category = 'article' LIMIT 3";
                  $stmt = $conn->query($sql);

                  if ($stmt->rowCount() > 0) {
                     while ($row = $stmt->fetch()) {
                        ?>
                        <div class="swiper-slide">
                           <img src="../img/<?php echo $row['imagetwo']; ?>" alt="" class="h-[70vh] w-full bg-cover block" />
                           <div class="absolute top-[30%] left-2 w-auto">
                              <h3 class="text-5xl text-slate-500 font-bold">
                                 <?php echo $row['gname']; ?>
                              </h3>
                              <p class="text-lg w-2/5 font-serif mt-3">
                                 <?php echo $row['gdis']; ?>
                              </p>
                           </div>
                        </div>
                        <?php
                     }
                  } else {
                     echo "No deals found.";
                  }
                  ?>
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
                     $sql = "SELECT * FROM product WHERE category = 'bestbuy' LIMIT 4";
                     $stmt = $conn->query($sql);

                     if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch()) {
                           $gadgetID = $row['g_id'];
                           ?>
                           <div
                              class="w-1/5 h-2/6 bg-slate-100 rounded-xl hover:bg-white hover:text-slate-100 shadow hover:shadow-xl">
                              <a href="information.php?g_id=<?php echo $row['g_id']; ?>">
                                 <img src="../img/<?php echo $row['gimage']; ?>" alt="Gadget Image" class="rounded-xl">
                                 <div class="m-2">
                                    <div>
                                       <h3 class="text-slate-700 font-semibold">
                                          <?php echo $row['gname']; ?>
                                       </h3>
                                       <p class="text-purple-500"><span>$
                                             <?php echo $row['gprice']; ?>
                                          </span></p>
                                    </div>
                                    <div class="gadget-rating">
                                       <?php echo '<div class="pro-name">' . displayRating($conn, $gadgetID) . '</div>'; ?>
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
               <!-- <button class="py-3 px-4 my-0 mx-auto block bg-slate-400 rounded-xl">See All</button> -->
            </div>
            </div>
         </section>
         <hr />
         <section class="px-10 my-10">
            <div class="main_product">
               <h2 class="text-3xl text-slate-800">Deals</h2>
               <div class="flex items-center justify-evenly max-h-full w-full gap-4 mt-4 rounded-xl">
                  <div class=" w-full rounded-xl flex justify-evenly items-center">
                     <?php
                     $sql = "SELECT * FROM product WHERE category = 'deals' limit 3";
                     $stmt = $conn->query($sql);

                     if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch()) {
                           $gadgetID = $row['g_id']; // Fetch the gadget ID from the row
                           echo '<a href="information.php?g_id=' . $row['g_id'] . '" class="rounded-xl slider-card m-4 bg-slate-300">';
                           echo '<div class="w-full h-44 p-3 ">';
                           echo '<img class="h-full w-full rounded-xl" src="../img/' . $row['imageone'] . '" alt="Gadget Image">';
                           echo '</div>';
                           echo '<div class="text-slate-500 text-left p-1 m-2">';
                           echo '<p class="pro-name">' . $row['gname'] . '</p>';
                           echo '<p class="pro-name">$ ' . $row['gprice'] . '</p>';
                           echo '<div class="pro-name">' . displayRating($conn, $gadgetID) . '</div>';
                           echo '</div>';
                           echo '</a>';
                        }

                     } else {
                        echo "No deals found.";
                     }
                     ?>
                  </div>
               </div>
            </div>
         </section>
         <hr />
      </main>


      <footer class="bg-yellow-200 px-20 mt-10">
         <a href="home.php" class="italic text-yellow-400 px-4 rounded-2xl">
            <img src="../techwave-logo-zip-file/png/logo-no-background.png" alt="" class="w-auto h-12">
         </a>
         <div class="flex justify-between text-slate-800 gap-4 px-10 py-4 ">
            <ul class="flex flex-col gap-2">
               <li>ph: 9800000000</li>
               <li><a href="mailto:rrajpote666@gmail.com"
                     class="text-slate-800 hover:text-blue-500">rrajpote666@gmail.com</a></li>
               <li>sjfnnfn</li>
            </ul>
            <ul class="flex flex-col gap-2">
               <li><a href="#" class="text-slate-800 hover:text-blue-500">About Us</a></li>
               <li><a href="#" class="text-slate-800 hover:text-blue-500">Term & Condition</a></li>
               <li><a href="#" class="text-slate-800 hover:text-blue-500">Support</a></li>
            </ul>
            <ul class="flex gap-3 justify-center items-center">
               <li>
                  <a href="#" class="text-slate-800 hover:text-blue-500"><i
                        class="fab fa-facebook-square text-2xl"></i></a>
               </li>
               <li>
                  <a href="#" class="text-slate-800 hover:text-red-500"><i class="fab fa-youtube text-2xl"></i></a>
               </li>
               <li>
                  <a href="#" class="text-slate-800 hover:text-purple-500"><i
                        class="fab fa-instagram-square text-2xl"></i></a>
               </li>
            </ul>
         </div>
      </footer>


   <?php } ?>
   <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
   <script src="../javsscript/script.js"></script>
   <script src="../javsscript/user.js"></script>
</body>

</html>