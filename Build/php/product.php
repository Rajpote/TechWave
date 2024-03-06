<?php
// session_start();


use PSpell\Dictionary;

include 'dbconn.php';
require_once 'rating.php';
// if (!isset($_SESSION['username'])) {
//    header('location: home.php');
// }

// Determine the current page number
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset based on the page number and limit
$limit = 5;
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
         margin: 20px auto;
         text-align: center;
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
   <main class="bg-slate-300 w-full">
      <article class="bg-slate-300 w-full px-16 flex items-center justify-center">
         <article class="w-4/5">
            <section>
               <div class="bg-purple-300 p-5 flex flex-wrap gap-5">
                  <?php
                  $sql = "SELECT product.*, AVG(feedback.rating) AS average_rating
                 FROM product
                 LEFT JOIN feedback ON product.g_id = feedback.g_id
                 GROUP BY product.g_id";
                  if (isset($_GET['type'])) {
                     $type = $_GET['type'];
                     $sql .= " WHERE type = '$type'";
                  }

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

                        echo '<a href="information.php?g_id=' . $gadget_id . '" class="g-item">';
                        echo '<div class="w-2/5 bg-slate-100 p-3 hover:bg-white">';

                        if (isset($row['gimage']) && !empty($row['gimage'])) {
                           echo "<img class='h-auto w-full' src='../img/{$row['gimage']}' alt='Gadget Image'>";
                        }

                        echo '<section class="gadget-section">';

                        if (isset($row['gname']) && !empty($row['gname'])) {
                           echo '<div class="text-slate-700 font-semibold mt-2">' . $row['gname'] . '</div>';
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
         <article class="bg-slate-600 w-1/5">filyer</article>
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

   <footer class="bg-yellow-200 px-10 w-full">
      <div class="italic text-yellow-400 bg-black py-2 px-3 mx-10 rounded-2xl w-[6%]">TechWave</div>
      <div
         class="flex items-start justify-between text-slate-800 bg-yellow-200 gap-2 px-14 py-4 mt-4 relative bottom-0">
         <ul>
            <li>ph:9800000000</li>
            <li><a href="">rrajpote666@gmail.com</a></li>
            <li>sjfnnfn</li>
         </ul>
         <ul>
            <li><a href="contact.php">About Us</a></li>
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
</body>

</html>