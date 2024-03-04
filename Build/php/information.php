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
      <main class="mx-10">
         <article class="flex items-center justify-center px-10 gap-6 mt-[-10px]">
            <section>
               <div>
                  <div class="h-auto w-full rounded-xl">
                     <img src="../img/sergio-de-paula-c_GmwfHBDzk-unsplash.jpg" alt="" class="w-full h-auto md:h-48 lg:h-64 xl:h-80 2xl:h-96 rounded-xl" />
                  </div>
               </div>
            </section>
            <section class="pr-10">
               <div>
                  <div>
                     <h2 class="text-start font-semibold text-4xl">iphone 14 pro max</h2>
                     <div class="flex items-center justify-between py-5">
                        <div>rating</div>
                        <div class="text-3xl text-purple-400">$400</div>
                     </div>
                     <div class="py-5 w-3/4">
                        <p>
                           Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ad recusandae itaque facere, quae, facilis animi saepe id aut inventore ipsum reiciendis odit porro veritatis
                           deserunt suscipit iure, error sed.
                        </p>
                     </div>
                     <div class="flex items-center px-4 gap-5">
                        <div>5</div>
                        <button class="bg-purple-500 text-white p-3 rounded-xl hover:bg-purple-300">Add To cart</button>
                     </div>
                  </div>
               </div>
            </section>
         </article>
         <hr />
         <article class="px-10 my-10">
            <section class="w-1/3 shadow-md rounded-xl">
               <div>
                  <ul class="flex items-center gap-4 p-2">
                     <li class="p-2 hover:bg-purple-500 rounded-md hover:text-white bg-slate-400"><a href="#discription">Discription</a></li>
                     <li class="p-2 hover:bg-purple-500 rounded-md hover:text-white bg-slate-400"><a href="#specification">Specification</a></li>
                     <li class="p-2 hover:bg-purple-500 rounded-md hover:text-white bg-slate-400"><a href="#review">Review</a></li>
                  </ul>
               </div>
            </section>
            <section id="discription"></section>
            <section id="specification"></section>
            <section id="review"></section>
         </article>
      </main>
   </body>
</html>
