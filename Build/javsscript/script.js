const swiper = new Swiper(".swiper", {
   // Optional parameters
   //    direction: "horigental",
   // loop: true,
   speed: 1000,
   autoplay: {
      delay: 3500,
      waitForTransition: true,
      disableOnInteraction: false,
   },
   // If we need pagination
   pagination: {
      el: ".swiper-pagination",
      clickable: true,
   },

   // Navigation arrows
   navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
   },

   // And if we need scrollbar
   // scrollbar: {
   //    el: ".swiper-scrollbar",
   // },
});
