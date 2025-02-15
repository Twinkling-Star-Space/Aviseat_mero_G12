const userCardTemplate = document.querySelector("[data-user-template]");
const userCardContainer = document.querySelector("[data-user-cards-container]");
const searchInput = document.querySelector("[data-search]");

let users = [];

searchInput.addEventListener("input", (e) => {
  const value = e.target.value;
  users.forEach(user => {
    const isVisible = user.departure.toLowerCase().includes(value) || user.arrival.toLowerCase().includes(value)
    user.element.classList.toggle("hide", !isVisible)
  })
});

fetch("http://localhost:3000/flights")
  .then(res => res.json())
  .then(data => {
    users = data.map(user => {
      const card = userCardTemplate.content.cloneNode(true).children[0]; // Fixed typo
      const header = card.querySelector("[data-header]");
      const body = card.querySelector("[data-body]");
      const part1 = card.querySelector("[data-arrival]");
      const part2 = card.querySelector("[data-duration]");

      header.textContent = user.airline;
      body.textContent = user.departure;
      part1.textContent = user.arrival;
      part2.textContent = user.duration;

      userCardContainer.append(card);
      return { airline: user.airline, arrival: user.arrival, departure:user.departure, element:card}
    });
  })
  .catch(error => console.error("Error fetching data:", error)); // Added error handling


  // adding image to the card list using api call 