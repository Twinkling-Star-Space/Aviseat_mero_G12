const userCardTemplate = document.querySelector("[data-user-template]");
const userCardContainer = document.querySelector("[data-user-cards-container]");
const searchInput = document.querySelector("[data-search]");

let users = [];

searchInput.addEventListener("input", (e) => {
  const value = e.target.value;
  users.forEach(user => {
    const isVisible = user.name.toLowerCase().includes(value) || user.email.toLowerCase().includes(value)
    user.element.classList.toggle("hide", !isVisible)
  })
});

fetch("https://jsonplaceholder.typicode.com/users")
  .then(res => res.json())
  .then(data => {
    users = data.map(user => {
      const card = userCardTemplate.content.cloneNode(true).children[0]; // Fixed typo
      const header = card.querySelector("[data-header]");
      const body = card.querySelector("[data-body]");

      header.textContent = user.name;
      body.textContent = user.email;

      userCardContainer.append(card);
      return { name: user.name, email: user.email, element:card}
    });
  })
  .catch(error => console.error("Error fetching data:", error)); // Added error handling


  // adding image to the card list using api call 
