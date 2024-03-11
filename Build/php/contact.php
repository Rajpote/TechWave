<?php
session_start();
include 'dbconn.php';
require_once 'rating.php';
if (!isset($_SESSION['uname'])) {
    header('location: home.php');
    exit(); // Ensure that the script stops here if the user is not logged in.
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
    <main class="px-10">
        <article id="About" class=" mx-10 my-4 space-y-4 md:space-x-4">
            <div>
                <h3 class="text-2xl">TechWave</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sunt voluptates, laboriosam, sequi et
                    tempore at sint possimus, optio inventore voluptas facilis. Debitis praesentium ullam laborum. Animi
                    aliquam tempore porro id! Lorem ipsum, dolor sit amet consectetur adipisicing elit. Amet inventore
                    laudantium distinctio blanditiis aperiam ratione enim quod voluptates beatae veritatis cupiditate
                    perspiciatis totam sint ut natus, quidem quo tempora dolore!</p>
            </div>
        </article>
        <article class="flex flex-col md:flex-row items-center justify-center mx-10 my-4 space-y-4 md:space-x-4">
            <section class="md:w-1/2">
                <div class="bg-slate-300 p-4 rounded-xl overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1766.7113700226994!2d85.3377137!3d27.6733263!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19e8d9058ce3%3A0x5f9f01647e956594!2z4KSG4KSI4KSf4KWAIOCkpOCkpeCkviDgpK7gpY3gpK_gpL7gpKjgpYfgpJzgpK7gpYfgpKjgpY3gpJ8g4KSs4KWN4KSy4KSV!5e0!3m2!1sne!2snp!4v1709289647231!5m2!1sne!2snp"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </section>
            <section class="md:w-1/2">
                <div class="bg-slate-300 p-5 rounded-xl">
                    <form action="" class="flex flex-col gap-4">
                        <div class="flex flex-col">
                            <label for="name" class="text-slate-700 font-semibold">Name:</label>
                            <input type="text" name="name" id="name"
                                class="px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-black">
                        </div>
                        <div class="flex flex-col">
                            <label for="email" class="text-slate-700 font-semibold">Email</label>
                            <input type="email" name="email" id="email"
                                class="px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-black">
                        </div>
                        <textarea name="message" id="message" placeholder="Enter your message" rows="5"
                            class="px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-black my-4"></textarea>
                        <button type="submit"
                            class="bg-black text-white rounded-md py-2 hover:bg-gray-800 transition duration-300 ease-in-out">Submit</button>
                    </form>
                </div>
            </section>
        </article>

    </main>
    <footer class="bg-yellow-200 px-20 mt-10">
        <a href="home.php" class="italic text-yellow-400 px-4 rounded-2xl">
            <img src="../techwave-logo-zip-file/png/logo-no-background.png" alt="" class="w-auto h-12">
        </a>
        <div class="flex justify-between text-slate-800 gap-4 px-10 py-4 ">
            <ul class="flex flex-col gap-2">
                <li>ph: 9800000000</li>
                <li><a href="mailto:rrajpote666@gmail.com"
                        class="text-slate-800 hover:text-blue-500">rrajpote666@gmail.com</a></li>
                <li>sjfnnfn</li>
            </ul>
            <ul class="flex flex-col gap-2">
                <li><a href="#" class="text-slate-800 hover:text-blue-500">About Us</a></li>
                <li><a href="#" class="text-slate-800 hover:text-blue-500">Term & Condition</a></li>
                <li><a href="#" class="text-slate-800 hover:text-blue-500">Support</a></li>
            </ul>
            <ul class="flex gap-3 justify-center items-center">
                <li>
                    <a href="#" class="text-slate-800 hover:text-blue-500"><i
                            class="fab fa-facebook-square text-2xl"></i></a>
                </li>
                <li>
                    <a href="#" class="text-slate-800 hover:text-red-500"><i class="fab fa-youtube text-2xl"></i></a>
                </li>
                <li>
                    <a href="#" class="text-slate-800 hover:text-purple-500"><i
                            class="fab fa-instagram-square text-2xl"></i></a>
                </li>
            </ul>
        </div>
    </footer>

    <script src="../javsscript/user.js"></script>

</body>

</html>