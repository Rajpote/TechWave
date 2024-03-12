<?php
session_start();

// Include the file containing the database connection code
include 'dbconn.php';

if (!isset($_SESSION['aname'])) {
    header('location: admin_login.php');
}

// Check if the form is submitted for updating feedback status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback_id']) && isset($_POST['status'])) {
    // Sanitize input data to prevent SQL injection
    $feedback_id = htmlspecialchars($_POST['feedback_id']);
    $status = htmlspecialchars($_POST['status']);

    // Update the status of the feedback in the database
    $updateQuery = "UPDATE feedback SET status = :status WHERE feedback_id = :feedback_id";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':feedback_id', $feedback_id);
    $stmt->execute();

    exit; // End the script after updating the status
}

// Fetch and display user feedback
$query = "SELECT * FROM feedback";
$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = count($data);
$count = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback</title>
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
    <main class=" min-h-screen py-8 px-4 ml-auto w-4/5">
        <div class="max-w-5xl mx-auto">
            <div class="data">
                <h1 class="text-3xl font-bold mb-4">User Feedback</h1>
                <?php if ($total > 0): ?>
                    <table class="w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2">S.N.</th>
                                <th class="px-4 py-2">User Name</th>
                                <th class="px-4 py-2">Feedback</th>
                                <th class="px-4 py-2">Rating</th>
                                <th class="px-4 py-2">Gadget ID</th>
                                <th class="px-4 py-2">Operation</th>
                                <th class="px-4 py-2">Update Status</th>
                                <th class="px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $result): ?>
                                <tr>
                                    <td class="px-4 py-2">
                                        <?php echo $count++; ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?php echo $result['uname']; ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?php echo $result['feedback']; ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?php echo $result['rating']; ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?php echo $result['g_id']; ?>
                                    </td>
                                    <td class="px-4 py-2"><a href='delete/review.php?id=<?php echo $result['feedback_id']; ?>'
                                            class="text-blue-500 hover:text-blue-700">Delete</a></td>
                                    <td class="px-4 py-2">
                                        <select class='form-select w-full max-w-xs' name='status'
                                            onchange='updateStatus(this, "<?php echo $result['feedback_id']; ?>")'>
                                            <option value='' disabled selected>Update</option>
                                            <option value='Approved'>Approve</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-2" id='status-<?php echo $result['feedback_id']; ?>'>
                                        <?php echo $result['status']; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-gray-500">No feedback available.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>


    <script>
        function updateStatus(selectElement, feedback_id) {
            var status = selectElement.value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', true);
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
</body>

</html>