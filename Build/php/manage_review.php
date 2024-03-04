<?php
// session_start();
include 'dbconn.php';

// if (!isset($_SESSION['adminname'])) {
//     header('location: home.php');
// }

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
        <div class="data">
            <h1>user feedback</h1>
            <?php
            $query = "SELECT * FROM feedback";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $total = count($data);
            $count = 1;
            if ($total != 0) {
                ?>
                <table border="1">
                    <tr>
                        <th>S.N.</th>
                        <th>User Name</th>
                        <th>Feedback</th>
                        <th>Rating</th>
                        <th>Gadget id</th>
                        <th>Operation</th>
                        <th>Update Status</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    foreach ($data as $result) {
                        echo "
                        <tr>
                           <td>" . $count++ . "</td>
                           <td>" . $result['uname'] . "</td>
                           <td>" . $result['feedback'] . "</td>
                           <td>" . $result['rating'] . "</td>
                           <td>" . $result['g_id'] . "</td>
                           <td><a href='delete/review.php?id=" . $result['feedback_id'] . "'><input type='submit' value='delete' class='delete' name='delete-user'></a>
                           </td>

                        
                        <td>
                        <select class='form-select' name='status' onchange='updateStatus(this, " . $result['feedback_id'] . ")'>
                            <option value='' disabled selected>Update</option>
                            <option value='Approved'>Approve</option>
                        </select>
                    </td>
                    <td id='status-" . $result['feedback_id'] . "'>" . $result['status'] . "</td>
                    </tr>
                     ";
                    }
                    ?>
                </table>
                <?php
            }
            ?>
        </div>
    </main>

    <script>
        function updateStatus(selectElement, feedback_id) {
            var status = selectElement.value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'updatestatus.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var statusCell = document.getElementById('status-' + feedback_id);
                    statusCell.textContent = status;
                }
            };

            var data = 'feedback_id=' + encodeURIComponent(feedback_id) + '&status=' + encodeURIComponent(status);
            xhr.send(data);
        }
    </script>
    </main>
</body>

</html>