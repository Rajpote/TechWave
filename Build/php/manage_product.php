<?php
// session_start();
include 'dbconn.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

// if (!isset($_SESSION['adminname'])) {
//     header('location: home.php');
// }

if (isset($_POST['submit'])) {
    $g_id = $_POST['g_id'];
    $type = $_POST['type'];
    $pricerange = $_POST['pricerange'];
    $category = $_POST['category'];
    $gname = $_POST['gname'];
    $gdis = $_POST['gdis'];
    $gspecification = $_POST['gspecification'];
    $gimage = $_POST['gimage'];
    $imageone = $_POST['imageone'];
    $imagetwo = $_POST['imagetwo'];
    $glink = $_POST['glink'];
    $gprice = $_POST['gprice'];

    // Check if the gadget already exists
    $sql = "SELECT * FROM product WHERE g_id = ? AND gdis = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$g_id, $gdis]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo '<script> alert("Gadget already exists."); </script>';
    } else {
        if (
            empty($g_id) || empty($type) || empty($pricerange) || empty($category) || empty($gname) || empty($gdis) || empty($gspecification) || empty($gimage) || empty($imageone) || empty($imagetwo) || empty($glink) || empty($gprice)
        ) {
            echo '<script> alert("Please fill all the fields."); window.location.href = "manage_product.php"; </script>';
        } else {
            $sql = "INSERT INTO product (g_id, type, pricerange, category, gname,  gdis, gspecification, gimage, imageone, imagetwo, glink, gprice) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                $g_id,
                $type,
                $pricerange,
                $category,
                $gname,
                $gdis,
                $gspecification,
                $gimage,
                $imageone,
                $imagetwo,
                $glink,
                $gprice
            ]);
            echo '<script> alert("Gadget added successfully."); window.location.href = "manage_product.php"; </script>';
        }
    }
}

if (isset($_POST['g_id'])) {
    $g_id = $_POST['g_id'];
}

$stmt = $conn->prepare("SELECT * FROM product WHERE g_id = :g_id");
$stmt->bindParam(":g_id", $g_id);
$stmt->execute();
$value = $stmt->fetch(PDO::FETCH_ASSOC);

$g_id = isset($value['g_id']) ? $value['g_id'] : '';
$gname = isset($value['gname']) ? $value['gname'] : '';
$type = isset($value['type']) ? $value['type'] : '';
$pricerange = isset($value['pricerange']) ? $value['pricerange'] : '';
$category = isset($value['category']) ? $value['category'] : '';
$gdis = isset($value['gdis']) ? $value['gdis'] : '';
$gspecification = isset($value['gspecification']) ? $value['gspecification'] : '';
$gimage = isset($value['gimage']) ? $value['gimage'] : '';
$imageone = isset($value['imageone']) ? $value['imageone'] : '';
$imagetwo = isset($value['imagetwo']) ? $value['imagetwo'] : '';
$glink = isset($value['glink']) ? $value['glink'] : '';
$gprice = isset($value['gprice']) ? $value['gprice'] : '';

if (isset($_POST['update-submit'])) {
    $g_id = $_POST['g_id'];
    $type = $_POST['type'];
    $pricerange = $_POST['pricerange'];
    $category = $_POST['category'];
    $gname = $_POST['gname'];
    $gdis = $_POST['gdis'];
    $gspecification = $_POST['gspecification'];
    $gimage = $_POST['gimage'];
    $imageone = $_POST['imageone'];
    $imagetwo = $_POST['imagetwo'];
    $glink = $_POST['glink'];
    $gprice = $_POST['gprice'];

    if (empty($_POST['g_id']) || empty($_POST['type']) || empty($_POST['pricerange']) || empty($_POST['category']) || empty($_POST['gname']) || empty($_POST['gdis']) || empty($_POST['gspecification']) || empty($_POST['gimage']) || empty($_POST['imageone']) || empty($_POST['imagetwo']) || empty($_POST['glink']) || empty($_POST['gprice'])) {
        echo '<script> alert("Please fill all the fields."); window.location.href = "manage_product.php"; </script>';
    } else {
        $sql = "UPDATE product SET g_id=:g_id, type=:type, pricerange=:pricerange, category=:category, gname=:gname, gdis=:gdis, gspecification=:gspecification, gimage=:gimage, imageone=:imageone, imagetwo=:imagetwo, glink=:glink, gprice=:gprice WHERE g_id=:g_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":g_id", $g_id);
        $stmt->bindParam(":type", $type);
        $stmt->bindParam(":pricerange", $pricerange);
        $stmt->bindParam(":category", $category);
        $stmt->bindParam(":gname", $gname);
        $stmt->bindParam(":gdis", $gdis);
        $stmt->bindParam(":gspecification", $gspecification);
        $stmt->bindParam(":gimage", $gimage);
        $stmt->bindParam(":imageone", $imageone);
        $stmt->bindParam(":imagetwo", $imagetwo);
        $stmt->bindParam(":glink", $glink);
        $stmt->bindParam(":gprice", $gprice);
        $stmt->execute();
        echo '<script> alert("Gadget updated successfully."); window.location.href = "manage_product.php"; </script>';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <!-- <header class="w-1/6 h-full bg-slate-600 fixed top-0 left-0 z-10">
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
    </header> -->
    <main class="">
        <div id="add-update">
            <div class="gadget-details" id="gadget-details">
                <form action="" method="POST" class="gadget-form">
                    <div class="input-container">
                        <div class="add">
                            <h1 class="addtitle">ADD GADGET</h1>
                            <input type="number" class="id" name="g_id" id="g_id" placeholder="Gadget ID" required>
                            <div class="select-container">
                                <select name="type" id="type">
                                    <option value="select">select</option>
                                    <option value="laptop">laptop</option>
                                    <option value="phone">phone</option>
                                    <option value="accessories">Accessories</option>
                                </select>
                                <select name="category" id="category">
                                    <option value="select">select</option>
                                    <option value="bestbuy">best buy</option>
                                    <option value="deals">deals</option>
                                </select>
                                <select name="pricerange" id="pricerange">
                                    <option value="1000-10000">1000-10000</option>
                                    <option value="10000-50000">10000-50000</option>
                                    <option value="50000-100000">50000-100000</option>
                                    <option value="100000-150000">100000-150000</option>
                                    <option value="150000-200000">150000-200000</option>
                                </select>
                            </div>
                            <input type="text" class="abbreviation" name="gname" id="gname" placeholder="Gadget Name"
                                required>
                            <input type="file" class="image" name="gimage" id="gimage" placeholder="Gadget Image URL"
                                required>
                            <textarea name="gdis" id="gdis" cols="60" rows="7"
                                placeholder="Gadget Description"></textarea>
                            <div class="box-content">
                                <div class="con">
                                    <input type="file" class="image" name="imageone" id="imageone"
                                        placeholder="Gadget Image URL" required>
                                    <input type="file" class="image" name="imagetwo" id="imagetwo"
                                        placeholder="Gadget Image URL">
                                </div>
                                <div class="con">
                                    <input type="text" class="link" name="glink" id="glink" placeholder="Gadget Link"
                                        required>
                                    <input type="number" class="price" name="gprice" id="gprice"
                                        placeholder="Gadget Price" required>
                                </div>
                            </div>
                            <textarea name="gspecification" id="gspecification" cols="60" rows="7"
                                placeholder="Gadget Specification" required></textarea>
                            <center>
                                <input type="submit" class="submit" name="submit" id="submit" value="Add">
                            </center>
                        </div>
                    </div>
                </form>
            </div>
            <div class="gadget-details" id="gadget-update">
                <form action="" method="POST" class="manage-gadget-form">
                    <div class="input-container">
                        <div class="updatebox">
                            <h1 class="updatetitle">UPDATE Gadgets</h1>
                            <select class="id" name="g_id" id="g_id" onchange="this.form.submit()">
                                <option value="">Gadget ID</option>
                                <?php
                                $stmt = $conn->prepare("SELECT g_id FROM product");
                                $stmt->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($result as $row) {
                                    $selected = ($row['g_id'] == $g_id) ? "selected" : "";
                                    echo "<option value='" . $row['g_id'] . "' " . $selected . ">" . $row['g_id'] . "</option>";
                                }
                                ?>
                            </select>
                            <div class="select-container">
                                <select name="type" id="type">
                                    <option value="select">select</option>
                                    <option value="laptop">laptop</option>
                                    <option value="phone">phone</option>
                                    <option value="accessories">Accessories</option>
                                </select>
                                <select name="category" id="category">
                                    <option value="select">select</option>
                                    <option value="bestbuy">best buy</option>
                                    <option value="deals">deals</option>
                                </select>
                                <select name="pricerange" id="pricerange">
                                    <option value="1000-10000">1000-10000</option>
                                    <option value="10000-50000">10000-50000</option>
                                    <option value="50000-100000">50000-100000</option>
                                    <option value="100000-150000">100000-150000</option>
                                    <option value="150000-200000">150000-200000</option>
                                </select>
                            </div>
                            <input type="text" class="gname" name="gname" id="gname" placeholder="Gadget Name"
                                value="<?php echo $gname ?>" required>
                            <input type="file" class="image" name="gimage" id="gimage" placeholder="Gadget Image URL"
                                value="<?php echo $gimage ?>" required>
                            <textarea name="gdis" id="gdis" cols="60" rows="7" placeholder="Gadget Description"
                                required><?php echo $gdis ?></textarea>
                            <div class="box-content">
                                <div class="con">
                                    <input type="file" class="image" name="imageone" id="imageone"
                                        placeholder="Gadget Image URL" value="<?php echo $imageone ?>" required><br>
                                    <input type="file" class="image" name="imagetwo" id="imagetwo"
                                        placeholder="Gadget Image URL" value="<?php echo $imagetwo ?>">
                                </div>
                                <div class="con">
                                    <input type="text" class="link" name="glink" id="glink" placeholder="Gadget Link"
                                        value="<?php echo $glink ?>" required><br>
                                    <input type="number" class="price" name="gprice" id="gprice"
                                        placeholder="Gadget Price" value="<?php echo $gprice ?>" required>
                                </div>
                            </div>
                            <textarea name="gspecification" id="gspecification" cols="60" rows="7"
                                placeholder="Gadget Specification" required><?php echo $gspecification ?></textarea>
                            <center>
                                <input type="submit" class="submit" name="update-submit" id="update-submit"
                                    value="Update">
                            </center>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </main>
</body>

</html>