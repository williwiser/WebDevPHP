// Check if the 'loggedout' flag is in the URL
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has("deletedacc")) {
  // Show an alert if the user has logged out
  alert("Account deleted successfully.");

  // Optionally, remove the 'loggedout' flag from the URL after showing the alert
  window.history.replaceState({}, document.title, window.location.pathname);
}

if (urlParams.has("accSuccessful")) {
  // Show an alert if the user has logged out
  alert("Account created successfully!");

  // Optionally, remove the 'loggedout' flag from the URL after showing the alert
  window.history.replaceState({}, document.title, window.location.pathname);
}

// Function to generate recipe cards
async function loadRecipes() {
  const recipeContainer = document.getElementById("recipe-cards");

  try {
    // Fetch recipes from the server
    const response = await fetch("get_recipes.php");
    const recipes = await response.json();

    // Clear container before adding recipes (just in case)
    recipeContainer.innerHTML = "";

    recipes.forEach((recipe) => {
      const recipeCard = document.createElement("div");
      recipeCard.classList.add("recipe-card");

      // Add inner HTML
      recipeCard.innerHTML = `
        <img src="${recipe.image}" alt="${recipe.title}">
        <h2>${recipe.title}</h2>
        <div class="rating">Rating: ${recipe.rating} <span>&#9733;</span></div>
        <p>${recipe.description}</p>
      `;

      // Add event listener to each recipe card
      recipeCard.addEventListener("click", () => {
        console.log(`Recipe ID: ${recipe.recipe_id}`); // Debug line to confirm recipe_id is correct
        window.location.href = `recipe-detail.php?recipe_id=${recipe.recipe_id}`;
      });

      // Append to the container
      recipeContainer.appendChild(recipeCard);
    });

    // Check how many recipe cards were added
    console.log(`Total recipe cards added: ${recipes.length}`);
  } catch (error) {
    console.error("Error loading recipes:", error);
    recipeContainer.innerHTML = "<p>Failed to load recipes.</p>";
  }
}

// Load recipes on page load
window.onload = loadRecipes;

// globals
const scrollerContainer = document.querySelector(".slide-container-inner");
const userReviews = document.getElementById("user-reviews");
const latestRecipes = document.getElementById("latest-recipes-list");

//------------------------------------Latest Recipes Code_______________________________//
// latest recipes, these are temporary placeholder objects
let chocolateCake = {
  name: "Chocolate Cake",
  description: "Tasty Chocolate Cake",
  thumbnail: "img/choc_cake.jpg",
  link: "cake.html",
};

let pastaAlfredo = {
  name: "Pasta Alfredo",
  description: "Italian Pasta Alfredo",
  thumbnail: "img/pasta.jpg",
  link: "pasta.html",
};

let beefStew = {
  name: "Beef Stew",
  description: "Delicious Beef Stew",
  thumbnail: "img/stew.jpg",
  link: "beef.html",
};

let latestRecipesList = [chocolateCake, pastaAlfredo, beefStew]; // store these recipe objects in a list
latestRecipesList.forEach((recipe) => {
  addLatestRecipe(recipe); // render each recipe object in latest recipes section
});

//------------------------------------User Reviews Code_______________________________//
// user reviews, these are temporary placeholder objects
let charmie = {
  name: "Tahalia",
  body: `"This site has an amazing variety of recipes from different
          cuisines. I love how easy it is to follow the steps, and the
          user reviews help me choose the best ones. It's now my go-to
          for weeknight dinners!"`,
};

let gordon = {
  name: "Gordon",
  body: `"I'm new to cooking, but the clear instructions and helpful
          tips on this site have made the process so much easier. The
          community is also super supportive when I need advice!"`,
};

let kaizer = {
  name: "Kaizer",
  body: `"I’m always finding new meal ideas here. The filters make it
          easy to search by dietary preferences, and the photos really
          help visualize what the final dish should look like. I've
          discovered so many favorites!"`,
};

let userReviewsList = [charmie, gordon, kaizer]; // store all obejcts in a list
userReviewsList.forEach((review) => {
  addFeaturedReview(review); // render each review in the carousel
});

const carouselContent = Array.from(scrollerContainer.children);

carouselContent.forEach((item) => {
  const duplicatedItem = item.cloneNode(true); // duplicate first element and append it to the list
  scrollerContainer.appendChild(duplicatedItem); // recycle the elemcnts to make infinite scroll effect
  scrollerContainer.style.animation = "scroll 75s linear infinite"; // animate the carousel of reviews
});

function addFeaturedReview(review) {
  // this method renders new reviews on the carousel
  userReviews.innerHTML += `<article class = 'user-review'>
        <img src='img/avatar-icon.png'>
        <hgroup>
          <p class="review-bd">${review.body}</p>
          <h3 class="review-author">- ${review.name}</h3>
        </hgroup>
      </article>`;
}

function addLatestRecipe(recipe) {
  // this method renders latest recipes in recipe section
  latestRecipes.innerHTML += `<li class="card latest-recipe">
          <a href="${recipe.link}">
            <img src="${recipe.thumbnail}" />
            <article>
              <h3>${recipe.name}</h3>
              <p>${recipe.description}</p>
            </article>
        </a>
      </li>`;
}

//Task 6 and task 7
// ----------- ADDED: Adjust column layout dynamically based on window size ----------- //
function adjustColumnLayout() {
  const recipeContainer = document.getElementById("recipe-cards");
  const width = window.innerWidth;

  if (width < 600) {
    recipeContainer.style.columnCount = 1;
  } else if (width < 1000) {
    recipeContainer.style.columnCount = 2;
  } else {
    recipeContainer.style.columnCount = 3;
  }
}

// Call adjustColumnLayout on load and resize
window.addEventListener("resize", adjustColumnLayout);
window.addEventListener("load", adjustColumnLayout);

// ---------------- Added Event Listeners for HTML DOM Events ---------------- //

function highlightOnHover(event) {
  event.target.style.backgroundColor = "lightyellow";
}

function removeHighlight(event) {
  event.target.style.backgroundColor = "";
}

function toggleSidebar() {
  const sidebar = document.querySelector(".sidebar");
  sidebar.classList.toggle("active");
}

function logScrollPosition() {
  console.log("Scroll Position: ", window.scrollY);
}

function preventContextMenu(event) {
  event.preventDefault();
  alert("Right-click is disabled!");
}

function onRecipeDoubleClick() {
  alert("Recipe double-clicked for details!");
}

function detectKeydown(event) {
  console.log("Key pressed: ", event.key);
}

function changeBackgroundColor() {
  document.body.style.backgroundColor = "lightblue";
}

function resetBackgroundColor() {
  document.body.style.backgroundColor = "";
}

// function onFormSubmit(event) {
//   event.preventDefault();
//   //alert("Form submitted!");
// }

// ----------- Attach Event Listeners to Elements ----------- //

// Add hover effects for recipe cards
document.querySelectorAll(".recipe-card").forEach((card) => {
  card.addEventListener("mouseenter", highlightOnHover);
  card.addEventListener("mouseleave", removeHighlight);
});

// Sidebar toggle
document
  .querySelector(".toggle-button")
  .addEventListener("click", toggleSidebar);

// Log scroll position
window.addEventListener("scroll", logScrollPosition);

// Disable right-click on the page
window.addEventListener("contextmenu", preventContextMenu);

// Double-click to show recipe details
document.querySelectorAll(".recipe-card").forEach((card) => {
  card.addEventListener("dblclick", onRecipeDoubleClick);
});

// Detect keypresses on the page
window.addEventListener("keydown", detectKeydown);

// Form submit example (if there is a form)
const formElement = document.querySelector("form");
if (formElement) {
  formElement.addEventListener("submit", onFormSubmit);
}

function searchRecipeDatabase() {
  const searchQuery = document.getElementById("searchRecipeTab").value;

  // AJAX request to PHP file
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "search.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (this.status === 200) {
      document.getElementById("results").innerHTML = this.responseText;
    }
  };

  xhr.send("query=" + encodeURIComponent(searchQuery));
}
