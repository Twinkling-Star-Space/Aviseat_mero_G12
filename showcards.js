
document.addEventListener("DOMContentLoaded", () => {
  const userCardContainer = document.querySelector("[data-user-cards-container]");
  const userTemplate = document.querySelector("[data-user-template]");

  // Fetch JSON file
  fetch("flights.json")
    .then(response => {
      if (!response.ok) {
        throw new Error("Network response was not ok " + response.statusText);
      }
      return response.json();
    })
    .then(data => {
      const flights = data.flights;

      flights.forEach(flight => {
        const card = userTemplate.content.cloneNode(true).children[0];
        
        // Fill card with JSON data
        const header = card.querySelector("[data-header]");
        const body = card.querySelector("[data-body]");
        const arrival = card.querySelector("[data-arrival]");
        const duration = card.querySelector("[data-duration]");

        header.textContent = `${flight.flight_number}`;
        body.textContent = `${flight.departure}`;
        arrival.textContent = `${flight.arrival}`;
        duration.textContent = flight.duration;

        // Append card to container
        userCardContainer.append(card);
      });
    })
    .catch(error => {
      console.error("Error fetching flight data:", error);
    });
});
