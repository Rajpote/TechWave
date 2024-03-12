<?php
session_start();
include 'dbconn.php';


if (!isset($_SESSION['aname'])) {
    header('location: admin_login.php');
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    $type = $_POST['type'];
    $category = $_POST['category'];
    $gname = $_POST['gname'];
    $gdis = $_POST['gdis'];
    $gspecification = $_POST['gspecification'];
    $gimage = $_POST['gimage'];
    $imageone = $_POST['imageone'];
    $imagetwo = $_POST['imagetwo'];
    $gprice = $_POST['gprice'];

    // Check if the gadget already exists
    $sql = "SELECT * FROM product WHERE gname = ? AND gspecification = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$gname, $gspecification]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo '<script> alert("Gadget already exists."); </script>';
    } else {
        if (
            empty($type) || empty($category) || empty($gname) || empty($gdis) || empty($gspecification) || empty($gimage) || empty($imageone) || empty($imagetwo) || empty($gprice)
        ) {
            echo '<script> alert("Please fill all the fields."); window.location.href = "manage_product.php"; </script>';
        } else {
            $sql = "INSERT INTO product (type, category, gname,  gdis, gspecification, gimage, imageone, imagetwo, gprice) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                $type,
                $category,
                $gname,
                $gdis,
                $gspecification,
                $gimage,
                $imageone,
                $imagetwo,
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
$category = isset($value['category']) ? $value['category'] : '';
$gprice = isset($value['gprice']) ? $value['gprice'] : '';

if (isset($_POST['update-submit'])) {
    $g_id = $_POST['g_id'];
    $gname = $_POST['gname'];
    $category = $_POST['category'];
    $gprice = $_POST['gprice'];

    if (empty($_POST['g_id'] || $_POST['gname']) || empty($_POST['category']) || empty($_POST['gprice'])) {
        echo '<script> alert("Please fill all the fields."); window.location.href = "manage_product.php"; </script>';
    } else {
        $sql = "UPDATE product SET g_id=:g_id, gname=:gname, category=:category, gprice=:gprice WHERE g_id=:g_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":g_id", $g_id);
        $stmt->bindParam(":gname", $gname);
        $stmt->bindParam(":category", $category);
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
    <main class="flex items-center justify-start h-full px-5 w-4/5 ml-auto">
        <div id="add-update" class="flex item-center justify-between">
            <div class=" bg-white rounded shadow-md p-6" id="gadget-details">
                <form action="" method="POST" class="gadget-form">
                    <div class="input-container">
                        <div class="add">
                            <h1 class="addtitle text-2xl font-bold mb-4">ADD GADGET</h1>
                            <div class="select-container mb-2">
                                <select name="type" id="type" class="border border-gray-300 rounded px-3 py-2 w-full">
                                    <option value="select">select</option>
                                    <option value="Apple">Apple</option>
                                    <option value="Samsung">Samsung</option>
                                    <option value="Xiaomi">Xiaomi</option>
                                    <option value="Realme">Realme</option>
                                    <option value="Oneplus">Oneplus</option>
                                </select>

                                <select name="category" id="category"
                                    class="border border-gray-300 rounded px-3 py-2 w-full">
                                    <option value="select">select</option>
                                    <option value="bestbuy">best buy</option>
                                    <option value="deals">deals</option>
                                    <option value="article">article</option> <!-- Corrected typo -->
                                </select>
                            </div>
                            <input type="text" class="abbreviation border border-gray-300 rounded px-3 py-2 mb-2 w-full"
                                name="gname" id="gname" placeholder="Gadget Name" required>
                            <input type="file" class="image border border-gray-300 rounded px-3 py-2 mb-2 w-full"
                                name="gimage" id="gimage" placeholder="Gadget Image URL" required>

                            <div class="box-content">
                                <div class="con">
                                    <input type="file"
                                        class="image border border-gray-300 rounded px-3 py-2 mb-2 w-full"
                                        name="imageone" id="imageone" placeholder="Gadget Image URL" required>
                                    <input type="file"
                                        class="image border border-gray-300 rounded px-3 py-2 mb-2 w-full"
                                        name="imagetwo" id="imagetwo" placeholder="Gadget Image URL">
                                </div>
                                <div class="con">
                                    <input type="number"
                                        class="price border border-gray-300 rounded px-3 py-2 mb-2 w-full" name="gprice"
                                        id="gprice" placeholder="Gadget Price" required>
                                </div>
                            </div>
                            <textarea name="gspecification" id="gspecification" cols="60" rows="7"
                                placeholder="Gadget Specification"
                                class="border border-gray-300 rounded px-3 py-2 mb-2 w-full" required></textarea>
                            <textarea name="gdis" id="gdis" cols="60" rows="7" placeholder="Gadget Description"
                                class="border border-gray-300 rounded px-3 py-2 mb-2 w-full"></textarea>
                            <center>
                                <input type="submit"
                                    class="submit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                    name="submit" id="submit" value="Add">
                            </center>
                        </div>
                    </div>
                </form>
            </div>
            <div class="gadget-details bg-white rounded shadow-md p-6" id="gadget-update">
                <form action="" method="POST" class="manage-gadget-form">
                    <div class="input-container">
                        <div class="updatebox">
                            <h1 class="updatetitle text-2xl font-bold mb-4">UPDATE Gadgets</h1>
                            <select class="id border border-gray-300 rounded px-3 py-2 mb-2 w-full" name="g_id"
                                id="g_id" onchange="this.form.submit()">
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
                                <select name="category" id="category"
                                    class="border border-gray-300 rounded px-3 py-2 mb-2 w-full">
                                    <option value="select">select</option>
                                    <option value="bestbuy">best buy</option>
                                    <option value="deals">deals</option>
                                    <option value="article">article</option>
                                </select>
                            </div>
                            <div class="box-content">
                                <div class="con">
                                    <input type="text"
                                        class="price border border-gray-300 rounded px-3 py-2 mb-2 w-full" name="gname"
                                        id="gname" placeholder="Gadget name" value="<?php echo $gname ?>" required>
                                    <input type="number"
                                        class="price border border-gray-300 rounded px-3 py-2 mb-2 w-full" name="gprice"
                                        id="gprice" placeholder="Gadget Price" value="<?php echo $gprice ?>" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <input type="submit"
                                    class="submit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                    name="update-submit" id="update-submit" value="Update">
                            </div>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </main>
</body>

</html>