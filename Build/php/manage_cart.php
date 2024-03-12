<?php
session_start();

// Include the file containing the database connection code
include 'dbconn.php';

if (!isset($_SESSION['aname'])) {
    header('location: admin_login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <header class="w-1/6 h-full bg-slate-600 fixed top-0 left-0 z-10">
        <div class="italic text-yellow-400 bg-black py-2 mx-10 px-3 rounded-2xl ml-10">TechWave</div>
        <nav class="my-10">
            <ul class="">
                <li>
                    <a href="admin.php"
                        class="block w-full text-white text-xl p-2 rounded-r-md hover:bg-slate-100 hover:text-black transition-all duration-300">
                        Home
                    </a>
                </li>
                <li>
                    <a href="manage_cart.php"
                        class="block w-full text-white text-xl p-2 rounded-r-md hover:bg-slate-100 hover:text-black transition-all duration-300">Cart</a>
                </li>
                <li>
                    <a href="product_info.php"
                        class="block w-full text-white text-xl p-2 rounded-r-md hover:bg-slate-100 hover:text-black transition-all duration-300">Product
                        info</a>
                </li>
                <li>
                    <a href="manage_user.php"
                        class="block w-full text-white text-xl p-2 rounded-r-md hover:bg-slate-100 hover:text-black transition-all duration-300">User</a>
                </li>
                <li>
                    <a href=" manage_review.php"
                        class="block w-full text-white text-xl p-2 rounded-r-md hover:bg-slate-100 hover:text-black transition-all duration-300">
                        Review</a>
                </li>
                <li>
                    <a href=" manage_feedback.php"
                        class="block w-full text-white text-xl p-2 rounded-r-md hover:bg-slate-100 hover:text-black transition-all duration-300">
                        feedback</a>
                </li>
            </ul>
        </nav>
    </header>
    <main class=" min-h-screen p-4 flex justify-end">

        <div class="admin-content w-full max-w-screen-lg bg-white rounded-md shadow-md p-4 ">
            <?php
            $sql = "SELECT * FROM order_data";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            ?>

            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="font-bold text-center border border-gray-300 py-2">S.N.</th>
                        <th class="font-bold text-center border border-gray-300 py-2">User</th>
                        <th class="font-bold border border-gray-300 py-2">Product</th>
                        <th class="font-bold border border-gray-300 py-2">Price</th>
                        <th class="font-bold border border-gray-300 py-2">Quantity</th>
                        <th class="font-bold border border-gray-300 py-2">Transaction ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row['id'];
                        $gname = $row['gname'];
                        $price = $row['price'];
                        $quantity = $row['quantity'];
                        $transaction_id = $row['transaction_id'];

                        echo '<tr>';
                        echo '<td class="text-center border border-gray-300 py-2">' . $count . '</td>';
                        echo '<td class="border border-gray-300 py-2">' . $id . '</td>';
                        echo '<td class="border border-gray-300 py-2">' . $gname . '</td>';
                        echo '<td class="border border-gray-300 py-2">NRs. ' . $price . '</td>';
                        echo '<td class="border border-gray-300 py-2">' . $quantity . '</td>';
                        echo '<td class="border border-gray-300 py-2">' . $transaction_id . '</td>';
                        echo '</tr>';

                        $count++;
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </main>



</body>

</html>