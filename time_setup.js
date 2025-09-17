// Clone template into page (you can repeat this if you want multiple cards)
const template = document.querySelector("[data-user-template]");
const container = document.getElementById("card-container");

// Example: create 3 flight cards
for (let i = 0; i < 10; i++) {
  const clone = template.content.cloneNode(true);
  container.appendChild(clone);
}

// Elements
const popupCard = document.getElementById("popupCard");
const popupOverlay = document.getElementById("popupOverlay");
const closePopup = document.getElementById("closePopup");

// Get ALL flight cards
const flightCards = document.querySelectorAll(".card");

// Loop through all cards and add event listener
flightCards.forEach(card => {
  card.addEventListener("click", () => {
    popupCard.style.display = "block";
    popupOverlay.style.display = "block";
  });
});

// Close popup
closePopup.addEventListener("click", () => {
  popupCard.style.display = "none";
  popupOverlay.style.display = "none";
});

popupOverlay.addEventListener("click", () => {
  popupCard.style.display = "none";
  popupOverlay.style.display = "none";
});
