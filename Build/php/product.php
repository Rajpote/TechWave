<?php
session_start();
include 'dbconn.php';
require_once 'rating.php';
if (!isset($_SESSION['uname'])) {
   header('location: home.php');
   exit(); // Ensure that the script stops here if the user is not logged in.
}

use PSpell\Dictionary;

// Determine the current page number
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset based on the page number and limit
$limit = 8;
$offset = ($page - 1) * $limit;

$g_id;
$i = 0;
$searchValue;
@$count = $_GET['count'];

do {
   @$g_id = $_GET[$i];

   if ($g_id != null) {
      $stmt = $conn->prepare("SELECT * FROM product WHERE g_id = :g_id LIMIT $limit OFFSET $offset");
      $stmt->bindParam(':g_id', $g_id);

      $stmt->execute();
      $value[$i] = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $searchValue = true;
   } else {
      $searchValue = false;
   }
   $i++;
} while ($i < $count);


/// Handle Filter Submission
if (isset($_GET['filter-submit'])) {
   // Retrieve the submitted filter values
   $category = isset($_GET['category']) ? $_GET['category'] : '';
   $max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';
   $type = isset($_GET['type']) ? $_GET['type'] : '';

   // Construct the base SQL query
   $sql = "SELECT product.*, AVG(feedback.rating) AS average_rating
           FROM product
           LEFT JOIN feedback ON product.g_id = feedback.g_id";

   // Initialize an array to store WHERE clause conditions
   $whereClause = [];

   // Add conditions to the WHERE clause based on submitted filter values
   if (!empty($category)) {
      $whereClause[] = "category = :category";
   }
   if (!empty($max_price)) {
      $whereClause[] = "gprice <= :max_price";
   }
   if (!empty($type)) {
      $whereClause[] = "type = :type";
   }

   // If there are any conditions in the WHERE clause, append them to the SQL query
   if (!empty($whereClause)) {
      $sql .= " WHERE " . implode(" AND ", $whereClause);
   }

   // Group by product ID
   $sql .= " GROUP BY product.g_id";

   // Modify the SQL query to include the limit and offset
   $sql .= " LIMIT $limit OFFSET $offset";

   // Prepare the SQL statement
   $stmt = $conn->prepare($sql);

   // Bind parameters if necessary
   if (!empty($category)) {
      $stmt->bindParam(':category', $category);
   }
   if (!empty($max_price)) {
      $stmt->bindParam(':max_price', $max_price);
   }
   if (!empty($type)) {
      $stmt->bindParam(':type', $type);
   }

   // Execute the query
   $stmt->execute();
   $value = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
   <main class="bg-slate-300 w-full">
      <article class="bg-slate-300 w-full px-16 flex items-start justify-center">
         <article class="w-4/5">
            <section>
               <div class=" p-5 flex item-center gap-4 flex-wrap ">
                  <?php
                  $sql = "SELECT product.*, AVG(feedback.rating) AS average_rating
                  FROM product
                  LEFT JOIN feedback ON product.g_id = feedback.g_id";
                  if (isset($_GET['type'])) {
                     $type = $_GET['type'];
                     $sql .= " WHERE product.type = '$type'";
                  }
                  $sql .= " GROUP BY product.g_id";


                  // Get the total count of rows without limit and offset
                  $totalRows = $conn->query($sql)->rowCount();

                  // Calculate the total number of pages
                  $totalPages = ceil($totalRows / $limit);

                  // Modify the SQL query to include the limit and offset
                  $sql .= " LIMIT $limit OFFSET $offset";

                  $stmt = $conn->query($sql);

                  if ($stmt->rowCount() > 0) {
                     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $gadgetID = $row['g_id']; // Fetch the gadget ID from the row
                        $gadget_id = $row['g_id'];
                        $average_rating = $row['average_rating'];

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
                     echo "No gadgets found.";
                  }
                  ?>
            </div>
            </section>
         </article>


         <article class="bg-slate-600 w-1/6">
            <div id="filter-section" class="mr-10">
               <h1 class="text-xl font-bold mb-4">Filter Gadgets</h1>
               <form action="" method="GET" class="filter-form">
                  <div class="input-container">
                     <div class="filterbox">
                        <div class="select-container mb-2">
                           <select name="category" id="category-filter"
                              class="border border-gray-300 rounded px-3 py-2 w-full mb-2">
                              <option value="">All Categories</option>
                              <option value="bestbuy">Best Buy</option>
                              <option value="deals">Deals</option>
                              <!-- Add more options as needed -->
                           </select>
                        </div>
                        <input type="number" class="price border border-gray-300 rounded px-3 py-2 mb-2 w-full"
                           name="max_price" placeholder="Max Price">

                        <!-- New select field for type -->
                        <select name="type" id="type-filter"
                           class="border border-gray-300 rounded px-3 py-2 w-full mb-2">
                           <option value="">All Brands</option>
                           <option value="Apple">Apple</option>
                           <option value="Samsung">Samsung</option>
                           <option value="Xiaomi">Xiaomi</option>
                           <option value="Realme">Realme</option>
                           <option value="Oneplus">Oneplus</option>
                           <!-- Add more options as needed -->
                        </select>

                        <button type="submit"
                           class="submit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                           name="filter-submit" id="filter-submit">Filter</button>
                     </div>
                  </div>
               </form>
            </div>
         </article>
      </article>
      <center>
         <div class="pagination">
            <?php
            // Previous page link
            if ($page > 1) {
               echo '<a class="page-link" href="?page=' . ($page - 1) . '">&laquo; Previous</a>';
            }

            for ($i = 1; $i <= $totalPages; $i++) {
               $activeClass = ($i === $page) ? "active" : "";
               echo '<a class="page-link ' . $activeClass . '" href="?page=' . $i . '">' . $i . '</a>';
            }

            // Next page link
            if ($page < $totalPages) {
               echo '<a class="page-link" href="?page=' . ($page + 1) . '">Next &raquo;</a>';
            }
            ?>
         </div>
      </center>
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

   <script src="../javsscript/user.js"></script>
</body>

</html>