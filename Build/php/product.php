<?php
session_start();
include 'dbconn.php';
require_once 'rating.php';
if (!isset($_SESSION['uname'])) {
   header('location: home.php');
   exit(); // Ensure that the script stops here if the user is not logged in.
}

use PSpell\Dictionary;

// Fetch categories from the database
$sql_categories = "SELECT DISTINCT category FROM product";
$stmt_categories = $conn->query($sql_categories);
$categories = $stmt_categories->fetchAll(PDO::FETCH_COLUMN);

// Fetch brands from the database
$sql_brands = "SELECT DISTINCT `type` FROM product";
$stmt_brands = $conn->query($sql_brands);
$types = $stmt_brands->fetchAll(PDO::FETCH_COLUMN);

// Initialize variables to store selected category and brand
$category = isset($_GET['category']) ? $_GET['category'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Build the SQL query based on selected filters
$sql = "SELECT * FROM product";

if (!empty($category) && !empty($type)) {
   // Filter by both category and type
   $sql .= " WHERE category = '$category' AND type = '$type'";
} elseif (!empty($category)) {
   // Filter only by category
   $sql .= " WHERE category = '$category'";
} elseif (!empty($type)) {
   // Filter only by type
   $sql .= " WHERE type = '$type'";
}

$stmt = $conn->query($sql);
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
      .pagination {
         margin: 0px auto;
         text-align: center;
         padding: 10px;
      }

      .pagination .page-link {
         display: inline-block;
         padding: 8px 16px;
         text-decoration: none;
         color: #010300;
         border: 1px solid #ddd;
         border-radius: 25px;
         margin-right: 4px;
      }

      .pagination .page-link.active {
         background-color: #333;
         color: #fff;
      }

      .pagination .page-link:hover {
         background-color: #333;
         color: #fff;
      }

      .pagination .page-link:first-child {
         margin-left: 0;
      }

      .pagination .page-link:last-child {
         margin-right: 0;
      }
   </style>
</head>

<body>
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
            <a href="cart.php" class="hover:text-slate-100 py-1"><i class="fa-solid fa-cart-shopping"></i></a>
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
                        <a href="update_user.php?id=<?php echo $uid; ?>"
                           class="text-blue-500 hover:underline">Update</a>
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

   <div class="filter-container my-4">
      <form action="" method="GET">
         <select name="category" id="category">
            <option value="">All Categories</option>
            <?php foreach ($categories as $categoryOption): ?>
               <option value="<?php echo $categoryOption; ?>" <?php echo ($category == $categoryOption) ? 'selected' : ''; ?>>
                  <?php echo $categoryOption; ?>
               </option>
            <?php endforeach; ?>
         </select>
         <select name="type" id="type">
            <option value="">All Brands</option>
            <?php foreach ($types as $brandOption): ?>
               <option value="<?php echo $brandOption; ?>" <?php echo ($type == $brandOption) ? 'selected' : ''; ?>>
                  <?php echo $brandOption; ?>
               </option>
            <?php endforeach; ?>
         </select>
         <button type="submit">Apply Filters</button>
      </form>
   </div>

   <main class="bg-slate-300 w-full">
      <article class="bg-slate-300 w-full px-16 flex items-start justify-center">
         <article class="w-4/5">
            <section>
               <div class=" p-5 flex item-center gap-4 flex-wrap ">
                  <?php
                  if ($stmt->rowCount() > 0) {
                     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $gadgetID = $row['g_id']; // Fetch the gadget ID from the row
                        $gadget_id = $row['g_id'];

                        echo '<a href="information.php?g_id=' . $gadget_id . '" class="g-item w-[23.5%] h-1/4 inline-block border rounded-lg overflow-hidden shadow-md">';
                        echo '<div class="w-full bg-slate-100 p-3 hover:bg-white">';

                        if (isset($row['gimage']) && !empty($row['gimage'])) {
                           echo "<img class='h-60 w-full object-fill' src='../img/{$row['gimage']}' alt='Gadget Image'>";
                        }

                        echo '<section class="gadget-section mt-2 text-center">';

                        if (isset($row['gname']) && !empty($row['gname'])) {
                           echo '<div class="text-slate-700 font-semibold">' . $row['gname'] . '</div>';
                        }

                        if (isset($row['gprice']) && !empty($row['gprice'])) {
                           echo '<div class="text-purple-500">Rs:' . $row['gprice'] . '</div>';
                        }
                        ?>
                        <!-- Display gadget rating with half stars -->
                        <?php displayRating($conn, $gadgetID); ?>

                  </section>
                  </div>
                  </a>

                  <?php
                     }
                  } else {
                     echo '<p class="text-2xl text-red-500 font-bold text-center h-full w-full">No Gadget Found</p>';
                  }
                  ?>
            </div>
            </section>
         </article>
      </article>
   </main>

   <footer class="bg-yellow-200 px-20">
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


   <script>
      document.addEventListener("DOMContentLoaded", function () {
         const form = document.querySelector('.filter-container form');
         const productList = document.querySelector('.p-5');

         form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Get selected filter values
            const formData = new FormData(form);

            // Send AJAX request
            fetch('filter_products.php', {
               method: 'POST',
               body: formData
            })
               .then(response => response.json()) // Parse JSON response
               .then(data => {
                  // Update product listing with filtered results
                  let productsHTML = '';
                  if (data.length === 0) {
                     productsHTML = '<p class="text-2xl text-red-500 font-bold text-center">No products found.</p>';
                  } else {
                     data.forEach(product => {
                        productsHTML += `
                        <a href="information.php?g_id=${product.g_id}" class="g-item w-[23.5%] h-1/4 inline-block border rounded-lg overflow-hidden shadow-md">
                            <div class="w-full bg-slate-100 p-3 hover:bg-white">
                                <img class="h-60 w-full object-fill" src="../img/${product.gimage}" alt="Gadget Image">
                                <section class="gadget-section mt-2 text-center">
                                    <div class="text-slate-700 font-semibold">${product.gname}</div>
                                    <div class="text-purple-500">Rs: ${product.gprice}</div>
                                    <!-- Display gadget rating with half stars -->
                                    ${product.displayRating}
                                </section>
                            </div>
                        </a>
                    `;
                     });
                  }
                  productList.innerHTML = productsHTML;
               })
               .catch(error => {
                  console.error('Error:', error);
               });
         });
      });


   </script>



   <script src="../javsscript/user.js"></script>
</body>

</html>