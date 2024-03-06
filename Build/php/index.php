<?php
session_start();
include 'dbconn.php';
require_once 'rating.php';
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
   <header class="bg-white-400 py-3 px-20 mb-10 flex items-center justify-between sticky top-0 z-10 bg-slate-200">
      <div class="italic text-yellow-400 bg-black py-2 px-3 rounded-2xl">TechWave</div>
      <nav class="">
         <ul class="flex items-center text-black gap-5">
            <li><a href="index.php" class="hover:text-yellow-500">Home</a></li>
            <li><a href="product.php" class="hover:text-yellow-500">Product</a></li>
            <li><a href="contact.php" class="hover:text-yellow-500">Contact</a></li>
         </ul>
      </nav>
      <div>
         <input type="text" name="" id="" class="rounded-xl" />
      </div>
      <div class="flex items-center justify-center gap-6">
         <div>
            <a href="" class="hover:text-blue-800 py-1"><i class="fa-solid fa-cart-shopping"></i></a>
         </div>
         <div class="gap-2 inline-block">
            <a href="signup.php" class="font-semibold hover:bg-yellow-200 py-1 bg-slate-100 mx-0 px-4 rounded-md">Sign
               up</a>
            <a href="login.php"
               class="font-semibold hover:bg-slate-100 py-1 bg-yellow-200 mx-0 px-4 rounded-md">Login</a>
         </div>
      </div>
      <button class="hidden sm:text-slate-900"></button>
   </header>
   <main class="mt-[-2.5rem] px-20">
      <section class="flex items-center justify-center my-10">
         <!-- Slider main container -->
         <div class="swiper rounded-b-3xl">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper h-full w-full ease-in-out">
               <!-- Slides -->
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
                                    <p class="text-purple-500"><span>&#36;
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
            <button class="py-3 px-4 my-5 mx-auto block bg-slate-400 rounded-xl">See All</button>
         </div>
         </div>
      </section>
      <hr />
      <section class="px-10 my-10">
         <div class="main_product">
            <h2 class="text-3xl text-slate-800">Deals</h2>
            <div class="flex items-center justify-evenly gap-6 max-h-full mt-4">
               <div class="bg-slate-300 w-1/3 rounded-xl">
                  <div class="pro-container">
                     <?php
                     $sql = "SELECT * FROM product WHERE category = 'deals' limit 6";
                     $stmt = $conn->query($sql);

                     if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch()) {
                           $gadgetID = $row['g_id']; // Fetch the gadget ID from the row
                           echo '<a href="#" onclick="alertPopup()" class="slider-card">';
                           echo '<div class="w-full h-44 p-3">';
                           echo '<img class="h-full w-full rounded-xl" src="../img/' . $row['gimage'] . '" alt="Gadget Image">';
                           echo '</div>';
                           echo '<div class="text-slate-500 text-left p-1 m-2">';
                           echo '<p class="pro-name">' . $row['gname'] . '</p>';
                           echo '<p class="pro-name">Rs:' . $row['gprice'] . '</p>';
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
</body>

</html>