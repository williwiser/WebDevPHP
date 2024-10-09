document.addEventListener("DOMContentLoaded", () => {
    // Load the top 20 recipes when the page loads
    loadRecipes();

    // Add an event listener to the search bar
    const searchBar = document.getElementById("search-bar");
    searchBar.addEventListener("input", () => {
        const searchQuery = searchBar.value.trim();
        if (searchQuery === '') {
            // If search bar is empty, reload the top 20 recipes
            loadRecipes();
        } else {
            searchRecipes(searchQuery);
        }
    });
});

// Function to load the top 20 recipes
async function loadRecipes() {
    try {
        const response = await fetch('get_recipes.php');
        const recipes = await response.json();
        displayRecipes(recipes);
    } catch (error) {
        console.error("Error loading recipes:", error);
    }
}

// Function to search and filter recipes
async function searchRecipes(query) {
    try {
        const response = await fetch(`search_recipes.php?query=${encodeURIComponent(query)}`);
        const recipes = await response.json();
        displayRecipes(recipes);
    } catch (error) {
        console.error("Error searching recipes:", error);
    }
}

// Function to display recipes
function displayRecipes(recipes) {
    const searchResults = document.getElementById("search-results");
    searchResults.innerHTML = "";

    if (recipes.length > 0) {
        recipes.forEach((recipe) => {
            const recipeCard = document.createElement("div");
            recipeCard.classList.add("recipe-card");
            recipeCard.setAttribute('id', `recipe-card-${recipe.recipe_id}`);

            const rating = recipe.rating ? recipe.rating : "N/A";

            recipeCard.innerHTML = `
                <img src="${recipe.image}" alt="${recipe.title}" class="recipe-image">
                <h2 class="recipe-title">${recipe.title}</h2>
                <div class="rating">Rating: ${rating} <span>&#9733;</span></div>
                <p class="recipe-description">${recipe.description}</p>
                <button class="delete-btn" data-id="${recipe.recipe_id}">Delete</button>
            `;

            recipeCard.querySelector(".delete-btn").addEventListener("click", (e) => {
                e.stopPropagation(); // Prevent event bubbling to recipe card click
                const recipeId = e.target.getAttribute("data-id");
                showModal(recipeId);
            });

            recipeCard.addEventListener("click", () => {
                window.location.href = `recipe-detail.php?recipe_id=${recipe.recipe_id}`;
            });

            searchResults.appendChild(recipeCard);
        });
    } else {
        searchResults.innerHTML = "<p>No recipes found.</p>";
    }
}

// Show the confirmation modal for deletion
function showModal(recipeId) {
    const modal = document.getElementById("confirmModal");
    modal.style.display = "flex";

    document.getElementById("confirmYes").onclick = async () => {
        await deleteRecipe(recipeId);
        modal.style.display = "none";
    };

    document.getElementById("confirmNo").onclick = () => {
        modal.style.display = "none";
    };
}

// Function to delete a recipe
async function deleteRecipe(recipeId) {
    try {
        const response = await fetch(`delete_recipe.php`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: recipeId })
        });

        if (response.ok) {
            const text = await response.text();
            alert(text);
            // Remove the recipe card from the DOM
            document.getElementById(`recipe-card-${recipeId}`).remove();
        } else {
            const errorText = await response.text();
            alert(`Error: ${errorText}`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again later.');
    }
}
