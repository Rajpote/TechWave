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
        <a href="admin.php" class="italic text-yellow-400 px-3 rounded-2xl flex items-center justify-center">
            <img src="../techwave-logo-zip-file/png/logo-no-background.png" alt="" class="w-auto h-16">
        </a>
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
                    <a href="manage_product.php"
                        class="block w-full text-white text-xl p-2 rounded-r-md hover:bg-slate-100 hover:text-black transition-all duration-300">Product</a>
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
    <main class="flex items-center justify-center mt-20">
        <div class="data">
            <h1 class="text-2xl font-semibold capitalize">product details</h1>
            <?php
            $query = "SELECT * FROM product";
            $stmt = $conn->query($query);
            $total = $stmt->rowCount();
            $count = 1;
            if ($total != 0)
            ?>
            <table class="border-collapse border border-gray-400">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border border-gray-400">S.N.</th>
                        <th class="p-2 border border-gray-400">Image</th>
                        <th class="p-2 border border-gray-400">product Name</th>
                        <th class="p-2 border border-gray-400">price</th>
                        <th class="p-2 border border-gray-400">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "
            <tr>
                <td class='p-2 border border-gray-400 text-center'>" . $count++ . "</td>
                <td class='p-2 border border-gray-400'>" . "<img class='w-full h-auto md:h-48 lg:h-64 xl:h-80 2xl:h-96 rounded-xl' src='../img/{$result['gimage']}' alt='Gadget Image'>" . "</td>
                <td class='p-2 border border-gray-400'>" . $result["gname"] . "</td>
                <td class='p-2 border border-gray-400'>" . $result["gprice"] . "</td>
                <td class='p-2 border border-gray-400'>
                    <a href='delete/delete_product.php?g_id=" . $result['g_id'] . "'>
                        <button class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>
                            Delete
                        </button>
                    </a>
                </td>
            </tr>";
                    }
                    ?>
                </tbody>
            </table>

    </main>
</body>

</html>