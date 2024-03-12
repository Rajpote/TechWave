<?php
session_start();
include 'dbconn.php';

$cartTotal = 0;
$total = 0;
$charge = 5;

if (isset($_SESSION['uname'])) {
    $uname = $_SESSION['uname'];
    $id = $_SESSION['id'];
}

$stmt = $conn->prepare("SELECT COUNT(itemId) AS item_count FROM cart WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$itemCount = $result['item_count'];

if (isset($_POST['delete-btn']) && isset($_POST['delete_product_id'])) {
    $g_id = $_POST['delete_product_id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE id = :id AND g_id = :g_id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':g_id', $g_id);
    $stmt->execute();

    header('location: cart.php');
    exit();
}


if (isset($_POST['update-cart'])) {
    if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
        $quantities = $_POST['quantity'];

        foreach ($quantities as $g_id => $newQuantity) {
            $g_id = intval($g_id);
            $newQuantity = intval($newQuantity);

            if ($newQuantity <= 0) {
                $stmt = $conn->prepare("DELETE FROM cart WHERE id = :id AND g_id = :g_id");
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':g_id', $g_id);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id AND g_id = :g_id");
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':g_id', $g_id);
                $stmt->bindParam(':quantity', $newQuantity);
                $stmt->execute();
            }
            $total = 0;
        }
        header('location: cart.php');
        exit();
    }
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
    <main class="mx-20">
        <div class="mt-3">
            <div class="container mx-auto py-8">
                <?php
                $sql = "SELECT * FROM cart WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                ?>

                <h4 class="text-3xl font-bold mb-4">Shopping Cart</h4>
                <p class="mb-4">You currently have
                    <?php echo $itemCount; ?> item(s) in your cart.
                </p>

                <div class="">
                    <div class="p-4 bg-white rounded shadow-md">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Item</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Product Name</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Unit Price</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Sub Total</th>
                                        <th scope="col" class="relative px-6 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php
                                    $count = 1;

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $g_id = $row['g_id'];
                                        $name = $row['name'];
                                        $price = $row['price'];
                                        $quantity = $row['quantity'];

                                        $subTotal = $price * $quantity;
                                        $total += $subTotal;
                                        $cartTotal = $total + $charge;

                                        echo '<tr>';
                                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">' . $count . '</td>';
                                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">' . $name . '</td>';
                                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">' . '$' . $price . '</td>';
                                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><input type="number" class="form-control" name="quantity[' . $g_id . ']" value="' . $quantity . '"></td>';
                                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">' . '$' . $subTotal . '</td>';
                                        echo '<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="" method="POST">
                                                <input type="hidden" name="delete_product_id" value="' . $g_id . '">
                                                <button type="submit" name="delete-btn" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>';
                                        echo '</tr>';
                                        ;

                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>


                            <div class="p-4 bg-white rounded shadow-md">
                                <div class="row">
                                    <?php if ($itemCount > 0): ?>
                                        <div class="col-md-3">
                                            <a href="home.php" class="nav-link btn cart-btn py-2 fw-bold" role="button"><i
                                                    class="fa-solid fa-chevron-left fa-2xs me-1"></i>Continue
                                                Shopping</a>
                                        </div>
                                        <div class="col text-end">
                                            <button class="btn cart-btn px-5 py-2 fw-bold" name="update-cart">Update
                                                Cart</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 border-start border-2">
            <div class="order-summary">
                <table class="table text-start">
                    <tr>
                        <td class="fw-bold text-center" colspan="2">Order Summary</td>
                    </tr>
                    <tr>
                        <td>Order Subtotal</td>
                        <td>
                            <?php echo '$' . $total; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Delivery Cost</td>
                        <td>
                            <?php echo '$' . $charge; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Total</td>
                        <td class="fw-bold">
                            <?php echo '$' . $cartTotal; ?>
                        </td>
                    </tr>
                </table>

                <div class="mt-5">
                    <form action="payment.php" method="POST">
                        <input type="number" name="amount" id="amount" value="<?php echo $cartTotal ?>" hidden>
                        <input type="text" name="username" id="username" value="<?php echo $username ?>" hidden>
                        <input type="submit" class="btn cart-btn px-5 py-2 fw-bold w-100" value="Checkout">
                    </form>
                </div>
                <div>
                </div>
            </div>
        </div>
    </main>
    <script src="../javsscript/user.js"></script>

</body>

</html>