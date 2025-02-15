
//showing airline name on the top of the internal architeruter of plane 
fetch("http://localhost:3000/flights")
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json(); 
})
.then(data => {
    
    const airlineName = data[0].airline;
    
    document.getElementById('header').textContent = airlineName;
})
.catch(error => {
    console.error('Error fetching or processing data:', error);
    // Display an error message in the HTML element
    document.getElementById('header').textContent = 'Failed to load airline name.';
});




// srolling bottom data on clicking 
  // Get the button element
/*  const scrollButton = document.getElementById('scroll-button');
  const targetElement = document.getElementById('airname');
  scrollButton.addEventListener('click', () => {
      
      window.scrollTo({
          top:  targetElement.offsetTop,
          behavior: 'smooth'
      });
  });*/
   
   const flightCards = document.querySelectorAll('.card');
   flightCards.forEach(card => {
       card.addEventListener('click', () => {
           // Get the target section ID from the data-target attribute
           const targetId = card.getAttribute('data-target');
           const targetElement = document.getElementById(targetId);

           if (targetElement) {
               // Scroll to the target element smoothly
               targetElement.scrollIntoView({ behavior: 'smooth' });
           } else {
               console.error('Target element not found:', targetId);
           }
       });
   });

   