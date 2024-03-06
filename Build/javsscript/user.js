// Function to open the pop-up container
function openPopup() {
   document.getElementById("popup-container").style.display = "block";
   document.getElementById("overlay").style.display = "block";
}

// Function to close the pop-up container
function closePopup() {
   document.getElementById("popup-container").style.display = "none";
   document.getElementById("overlay").style.display = "none";
}

// Event listener to open the pop-up container when the button is clicked
document.getElementById("popup-button").addEventListener("click", openPopup);

// Event listener to close the pop-up container when the close button is clicked
document.getElementById("close-popup").addEventListener("click", closePopup);

function incrementItem(button) {
   var quantityElement = button.previousElementSibling;
   var quantity = parseInt(quantityElement.textContent);
   quantity++;
   quantityElement.textContent = quantity;
}

function decrementItem(button) {
   var quantityElement = button.nextElementSibling;
   var quantity = parseInt(quantityElement.textContent);
   if (quantity > 1) {
      quantity--;
      quantityElement.textContent = quantity;
   }
}
