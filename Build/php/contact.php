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
    <header class="bg-white-400 py-3 px-20 mb-10 flex items-center justify-between sticky top-0 z-10 bg-slate-200">
        <div class="italic text-yellow-400 bg-black py-2 px-3 rounded-2xl">TechWave</div>
        <nav class="">
            <ul class="flex items-center text-black gap-5">
                <li><a href="home.php
                " class="hover:text-yellow-500">Home</a></li>
                <li><a href="product.php
                " class="hover:text-yellow-500">Product</a></li>
                <li><a href="contact.php
                " class="hover:text-yellow-500">Contact</a></li>
            </ul>
        </nav>
        <div>
            <form action="search.php" method="post" class="flex items-center relative">
                <input type="text" name="search"
                    class=" search-bar px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="Search . . . " id="search" />
                <button type="submit"
                    class=" flex-shrink-0 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 border border-gray-300 rounded-lg transition duration-150 ease-in-out absolute top-0 right-0">
                    <i id="search-icon" class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>
        <div class="flex items-center justify-center gap-6">
            <div>
                <a href="" class="hover:text-blue-800 py-1"><i class="fa-solid fa-cart-shopping"></i></a>
            </div>
            <div>
                <button id="popup-button"><i
                        class="text-center fa-solid fa-user rounded-full border-2 border-blue-500 h-auto w-8 hover:border-black"></i></button>
                <div id="overlay" class="hidden fixed top-10 left-0 w-full h-full bg-transparent z-10"></div>
                <div id="popup-container"
                    class="hidden fixed top-16 right-0 translate-[-50%, -50%] bg-white p-4 shadow-2xl z-10 h-auto w-auto">
                    <div class="relative">
                        <button id="close-popup"
                            class="text-3xl hover:text-red-600 absolute top-[-28px] right-0">&times;</button>
                        <div id="username" class="container mt-6">
                            <?php echo $_SESSION['uname'] ?>

                            <div class="update-user">
                                <a href="update_user.php?id=<?php echo $uid; ?>">update</a>
                            </div>
                            <div class="logout">
                                <a href="logout.php">logout</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <button class="hidden sm:text-slate-900"></button>
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
    <footer class="bg-yellow-200 px-10 mt-10">
        <div class="italic text-yellow-400 bg-black py-2 px-3 mx-10 rounded-2xl w-[6%]">TechWave</div>
        <div
            class="flex items-start justify-between text-slate-800 bg-yellow-200 gap-2 px-14 py-4 mt-4 relative bottom-0">
            <ul>
                <li>ph:9800000000</li>
                <li><a href="">rrajpote666@gmail.com</a></li>
                <li>sjfnnfn</li>
            </ul>
            <ul>
                <li><a href="">About Us</a></li>
                <li><a href="">Term & Condition</a></li>
                <li><a href="">Support</a></li>
            </ul>
            <ul class="flex gap-3 justify-center items-center">
                <li>
                    <a href=""><i class="fa-brands fa-square-facebook text-2xl hover:text-blue-500"></i></a>
                </li>
                <li>
                    <a href=""><i class="fa-brands fa-youtube text-2xl hover:text-red-500"></i></a>
                </li>
                <li>
                    <a href=""><i class="fa-brands fa-square-instagram text-2xl hover:text-purple-500"></i></a>
                </li>
            </ul>
        </div>
    </footer>
    <script src="../javsscript/user.js"></script>

</body>

</html>