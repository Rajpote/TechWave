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
        <article class="mx-20 flex flex-col">
            <div>
                <h2>shopping Cart</h2>
            </div>
            <section class="flex items-center justify-between bg-slate-200 rounded-md p-4">
                <div class="h-full w-1/3 bg-white p-1 rounded-md ">
                    <img src="../img/vojtech-bruzek-J82GxqnwKSs-unsplash.jpg" alt="" class="h-auto w-full">
                </div>
                <div class="flex items-center justify-between gap-5">
                    <div>
                        <h2>iphone 14</h2>
                    </div>
                    <div class="flex items-center justify-evenly gap-3"><button class="rounded-full bg-slate-400 p-1">
                            < </button>
                                <p>3</p> <button class="rounded-full bg-slate-400 p-1"> > </button>
                    </div>
                </div>
                <div>
                    <h2>$123</h2>
                </div>
            </section>
            <div class="flex justify-end px-3">
                <div class=" order-1">
                    <div class="">$123</div>
                    <button class="bg-blue-500">checkout</button>
                </div>
            </div>
        </article>
    </main>
</body>

</html>