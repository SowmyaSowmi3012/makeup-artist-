// Function to toggle the menu open and closed
function toggleMenu() {
  const menu = document.getElementById('nav_links');
  const burger = document.getElementById('burger');
  const closeButton = document.getElementById('closeMenu');
  
  menu.classList.toggle('show'); // Show or hide the menu
  burger.classList.toggle('active'); // Toggle burger icon animation
  
  // Toggle close button visibility based on menu state
  if (menu.classList.contains('show')) {
      closeButton.style.display = 'block'; // Show close button
  } else {
      closeButton.style.display = 'none'; // Hide close button
  }
}

// Function to close the menu when the close button is clicked
function closeMenu() {
  const menu = document.getElementById('nav_links');
  const burger = document.getElementById('burger');
  const closeButton = document.getElementById('closeMenu');

  menu.classList.remove('show'); // Hide the menu
  burger.classList.remove('active'); // Reset burger icon
  closeButton.style.display = 'none'; // Hide the close button
}

var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 5000); // Change image every 2 seconds
}

const img = document.querySelectorAll(".img-box");
const win = document.querySelector(".window");
const fullImg = document.querySelector(".full-img");

img.forEach((imgs) => {
  imgs.addEventListener("click", () => {
    const val = imgs.getAttribute("data-value");
    win.classList.add("open");
    fullImg.src = `img/${val}.jpg`;
  });
});

window.addEventListener("click", (e) => {
  if (e.target.classList.contains("window")) {
    win.classList.remove("open");
  }
});
document.getElementById("contactForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const formData = {
        action: "contact",
        name: event.target.name.value,
        email: event.target.email.value,
        message: event.target.message.value
    };

    fetch("http://localhost/makeup_artist/api.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        // Clear form if successful
        if (data.status === "success") {
            event.target.reset();
        }
    })
    .catch(error => console.error("Error:", error));
});

