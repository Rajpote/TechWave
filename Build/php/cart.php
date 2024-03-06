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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <name>Document</name>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
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
    <main>
        <div class="mt-3">
            <div class="cart-content p-3">
                <?php
                $sql = "SELECT * FROM cart WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                ?>

                <h4 class="fw-bold">Shopping Cart</h4>
                <p>You currently have
                    <?php echo $itemCount; ?> item(s) in your cart.
                </p>

                <div class="row">
                    <div class="col">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <table class="table">
                                <tr>
                                    <td class="fw-bold text-center">Item</td>
                                    <td class="fw-bold">Lego Name</td>
                                    <td class="fw-bold">Unit Price</td>
                                    <td class="fw-bold text-center">Quantity</td>
                                    <td class="fw-bold">Sub Total</td>
                                    <td></td>
                                </tr>

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
                                    echo '<td class="text-center">' . $count . '</td>';
                                    echo '<td>' . $name . '</td>';
                                    echo '<td>' . '$' . $price . '</td>';
                                    echo '<td class="text-center quantity-change px-5"><input type="number" class="form-control text-center p-0" name="quantity[' . $g_id . ']" value="' . $quantity . '"></td>';
                                    echo '<td>' . '$' . $subTotal . '</td>';
                                    echo '<td><i class="fa-solid fa-trash" style="color: #cfcfcf; cursor: pointer" id="showDeleteConfirmation" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-lego-id="' . $g_id . '" onclick="setg_idToDelete(this.getAttribute(\'data-lego-id\'))"></i></td>';
                                    echo '</tr>';

                                    $count++;
                                }
                                ?>
                            </table>

                            <div class="mt-5">
                                <div class="row">
                                    <?php if ($itemCount > 0): ?>
                                        <div class="col-md-3">
                                            <a href="userpage.php" class="nav-link btn cart-btn py-2 fw-bold"
                                                role="button"><i class="fa-solid fa-chevron-left fa-2xs me-1"></i>Continue
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
                                    <input type="number" name="amount" id="amount" value="<?php echo $cartTotal ?>"
                                        hidden>
                                    <input type="text" name="username" id="username" value="<?php echo $username ?>"
                                        hidden>
                                    <input type="submit" class="btn cart-btn px-5 py-2 fw-bold w-100" value="Checkout">
                                </form>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
    </main>
</body>

</html>