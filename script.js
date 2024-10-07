// This will be replaced with php, where all recipes will be loaded from a database
const recipes = [
  {
    title: "Beef Stew",
    image: "img/stew.jpg",
    rating: 4.5,
    description: "Classic beef stew with vegetables.",
    instructions: [
      "Brown the beef in a pot.",
      "Add chopped vegetables and broth.",
      "Simmer for 1-2 hours until tender.",
    ],
    ingredients: [
      "1 lb beef",
      "3 carrots, chopped",
      "2 potatoes, diced",
      "1 onion, chopped",
      "2 cups beef broth",
      "Salt and pepper to taste",
    ],
  },
  {
    title: "Spaghetti Carbonara",
    image: "img/sphageti.jpg",
    rating: 4.7,
    description: "Rich spaghetti with creamy carbonara sauce.",
    instructions: [
      "Cook spaghetti according to package instructions.",
      "Fry pancetta until crispy.",
      "Mix with eggs, cheese, and pepper.",
      "Toss with cooked spaghetti and serve.",
    ],
    ingredients: [
      "200g spaghetti",
      "100g pancetta",
      "2 large eggs",
      "50g Parmesan cheese",
      "Black pepper to taste",
      "Salt to taste",
    ],
  },
  {
    title: "Chicken Curry",
    image: "img/chicken_curry.jpg",
    rating: 4.8,
    description: "Spicy and flavorful chicken curry.",
    instructions: [
      "Sauté onions and garlic until softened.",
      "Add curry powder and diced chicken, cook until browned.",
      "Stir in coconut milk and simmer until chicken is cooked.",
    ],
    ingredients: [
      "500g chicken breast, diced",
      "1 onion, chopped",
      "2 garlic cloves, minced",
      "1 tbsp curry powder",
      "1 can coconut milk",
      "Salt to taste",
    ],
  },
  {
    title: "Vegetable Stir-fry",
    image: "img/vegstir.jpg",
    rating: 4.6,
    description: "Quick and healthy vegetable stir-fry with soy sauce.",
    instructions: [
      "Heat sesame oil in a wok.",
      "Stir-fry sliced vegetables until tender-crisp.",
      "Add soy sauce and seasoning, stir for 2 minutes.",
      "Serve hot with rice.",
    ],
    ingredients: [
      "1 bell pepper, sliced",
      "1 zucchini, sliced",
      "1 carrot, julienned",
      "2 tbsp soy sauce",
      "1 tbsp sesame oil",
      "Salt and pepper to taste",
    ],
  },
  {
    title: "Chocolate Cake",
    image: "img/choc_cake.jpg",
    rating: 4.9,
    description: "Moist and rich chocolate cake with frosting.",
    instructions: [
      "Preheat the oven to 350°F (175°C).",
      "Mix flour, sugar, cocoa powder, and baking soda.",
      "Add milk, oil, and eggs, and mix well.",
      "Bake for 30-35 minutes. Let cool before frosting.",
    ],
    ingredients: [
      "1 1/2 cups flour",
      "1 cup sugar",
      "1/2 cup cocoa powder",
      "1 tsp baking soda",
      "1 cup milk",
      "1/2 cup vegetable oil",
      "2 large eggs",
    ],
  },
  {
    title: "Caesar Salad",
    image: "img/caeser.jpg",
    rating: 4.4,
    description:
      "Crisp romaine lettuce with creamy Caesar dressing and croutons.",
    instructions: [
      "Wash and chop romaine lettuce.",
      "Toss lettuce with Caesar dressing.",
      "Top with croutons and Parmesan cheese.",
      "Serve chilled with a sprinkle of black pepper.",
    ],
    ingredients: [
      "1 head romaine lettuce",
      "1/2 cup Caesar dressing",
      "1/4 cup grated Parmesan cheese",
      "1 cup croutons",
      "Black pepper to taste",
    ],
  },
];

// Function to generate recipe cards
function loadRecipes() {
  const recipeContainer = document.getElementById("recipe-cards");

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

    //lets add an eventlistener to each recipe card
    recipeCard.addEventListener("click", () => {
      localStorage.setItem("selectedRecipe", JSON.stringify(recipe)); //Save recipe data to localStorage
      window.location.href = "recipe-detail.html";
    }); //  function within event listener

    // Append to the container
    recipeContainer.appendChild(recipeCard);
  });

  // Check how many recipe cards were added
  console.log(
    `Total recipe cards added: ${
      document.querySelectorAll(".recipe-card").length
    }`
  );
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
