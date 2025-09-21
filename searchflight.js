document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.querySelector('form');
    const fromInput = document.querySelector('input[name="from"]');
    const toInput = document.querySelector('input[name="to"]');
    const dateInput = document.querySelector('input[name="date"]');
    const userCardsContainer = document.querySelector('[data-user-cards-container]');
    const userTemplate = document.querySelector('[data-user-template]');

    let flightsData = [];

    // Fetch flight data from JSON file
    fetch('flights.json')
        .then(res => res.json())
        .then(data => {
            flightsData = data.flights;
        })
        .catch(err => {
            console.error("Error loading flight data:", err);
        });

    // Handle search form submit
    searchForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const fromValue = fromInput.value.trim().toLowerCase();
        const toValue = toInput.value.trim().toLowerCase();

        // Clear previous cards
        userCardsContainer.innerHTML = '';

        if (!fromValue || !toValue) {
            alert("Please enter all fields: departure, arrival, and date.");
            return;
        }

        const matchedFlights = flightsData.filter(flight => {
            const dep = flight.departure.toLowerCase();
            const arr = flight.arrival.toLowerCase();
            return dep.includes(fromValue) && arr.includes(toValue);
        });

        if (matchedFlights.length === 0) {
            userCardsContainer.innerHTML = "<p>No matching flights found.</p>";
            return;
        }

        matchedFlights.forEach(flight => {
            const card = userTemplate.content.cloneNode(true).children[0];
            card.querySelector('[data-header]').textContent = flight.flight_number + ' - ' + flight.airline;
            card.querySelector('[data-body]').textContent = flight.departure;
            card.querySelector('[data-arrival]').textContent = flight.arrival;
            card.querySelector('[data-duration]').textContent = flight.duration;

            userCardsContainer.appendChild(card);
        });
    });
});
