<?php
session_start();
include 'dbconn.php';

$status = $_GET['status'];
$amount = $_GET['amount'];
$id = $_SESSION['id'];
$transaction_id = $_GET['transaction_id'];

$total = $amount / 100;

$sql = "SELECT * FROM cart WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

$cartItems = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $cartItems[] = array(
        'g_id' => $row['g_id'],
        'gname' => $row['name'],
        'price' => $row['price'],
        'quantity' => $row['quantity'],
    );
}

foreach ($cartItems as $item) {
    $g_id = $item['g_id'];
    $gname = $item['gname'];
    $price = $item['price'];
    $quantity = $item['quantity'];

    $sql = "INSERT INTO order_data (id, g_id, gname, price, quantity, transaction_id) VALUES (:id, :g_id, :gname, :price, :quantity, :transaction_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':g_id', $g_id);
    $stmt->bindParam(':gname', $gname);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':transaction_id', $transaction_id);
    $stmt->execute();
}

$stmt = $conn->prepare("DELETE FROM cart WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Lego Empire</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../../favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../favicon/favicon-16x16.png">
    <link rel="manifest" href="../../favicon/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/louis-george-cafe" rel="stylesheet">
    <link rel="stylesheet" href="../../css/user.css">

    <style>
        body {
            background-color: #f6f4f9;
        }
    </style>
</head>

<body>
    <div class="container payment-container">
        <div class="row text-center">
            <div class="col-md-12">
                <div>
                    <img src="../../images/success.png" class="mt-5" alt="">
                    <h3 class="fw-bold mt-5">Payment Success</h3>
                    <h6 class="mt-3 mb-5">Thank you for purchasing via Khalti Payment Gateway! Your payment has been
                        confirmed successfully.</p>

                        <h6 class="fw-bold">Paid Amount: NRs.
                            <?php echo $total ?>
                        </h6>
                        <h6 class="fw-bold">Transaction ID:
                            <?php echo $transaction_id ?>
                        </h6>
                </div>
            </div>

            <div class="col-md-12">
                <a href="home.php">
                    <button class="btn cart-btn py-2 fw-bold w-50">Back to userpage</button>
                </a>
            </div>
        </div>
    </div>
</body>

</html>