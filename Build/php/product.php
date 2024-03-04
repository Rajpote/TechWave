<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Document</title>
      <link rel="stylesheet" href="../css/output.css" />
      <link rel="stylesheet" href="../css/style.css" />
      <link
         rel="stylesheet"
         href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
         integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
         crossorigin="anonymous"
         referrerpolicy="no-referrer"
      />
   </head>
   <body>
      <header class="bg-white-400 px-20 py-3 flex items-center justify-between sticky top-0 z-10 bg-slate-200">
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
               <i class="text-center fa-solid fa-user rounded-full border-2 border-blue-500 h-auto w-8 hover:border-black"></i>
            </div>
         </div>
         <button class="hidden sm:text-slate-900"></button>
      </header>
      <main class="bg-slate-300 w-full">
         <article class="bg-slate-300 w-full px-16 flex items-center justify-center">
            <article class="w-4/5">
               <section>
                  <div class="bg-purple-300 p-5 flex flex-wrap gap-5">
                     <div class="w-1/5 bg-slate-100 p-3 hover:bg-white">
                        <img src="../img/vojtech-bruzek-J82GxqnwKSs-unsplash.jpg" alt="" />
                        <div>
                           <h3 class="text-slate-700 font-semibold mx-4 mt-2">iphone 14 pro max</h3>
                           <p class="mx-4 text-purple-500"><span>&#36;760</span></p>
                        </div>
                     </div>
                  </div>
               </section>
            </article>
            <article class="bg-slate-600 w-1/5">filyer</article>
         </article>
         <div class="text-center text-white bg-black py-5 px-4">
            <!-- Pagination text -->
            <p>Pagination: Page 1 of 5</p>

            <!-- Pagination links/buttons -->
            <div class="flex justify-center gap-2 mt-3">
               <!-- Example of pagination links -->
               <a href="#" class="text-white px-3 py-1 bg-blue-500 hover:bg-blue-600 rounded-md">1</a>
               <a href="#" class="text-white px-3 py-1 bg-blue-500 hover:bg-blue-600 rounded-md">2</a>
               <a href="#" class="text-white px-3 py-1 bg-blue-500 hover:bg-blue-600 rounded-md">3</a>
               <!-- Add more links/buttons as needed -->
            </div>
         </div>
      </main>

      <footer class="bg-yellow-200 px-10 w-full">
         <div class="italic text-yellow-400 bg-black py-2 px-3 mx-10 rounded-2xl w-[6%]">TechWave</div>
         <div class="flex items-start justify-between text-slate-800 bg-yellow-200 gap-2 px-14 py-4 mt-4 relative bottom-0">
            <ul>
               <li>ph:9800000000</li>
               <li><a href="">rrajpote666@gmail.com</a></li>
               <li>sjfnnfn</li>
            </ul>
            <ul>
               <li><a href="contact.php">About Us</a></li>
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
   </body>
</html>
