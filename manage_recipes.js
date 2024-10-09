async function searchRecipes() {
    const searchQuery = document.getElementById("search-bar").value;
    const searchResults = document.getElementById("search-results");

    try {
        const response = await fetch(`search_recipes.php?query=${encodeURIComponent(searchQuery)}`);
        const recipes = await response.json();

        searchResults.innerHTML = "";
        if (recipes.length > 0) {
            recipes.forEach((recipe) => {
                const recipeCard = document.createElement("div");
                recipeCard.classList.add("recipe-card");

                // Set the rating or default to "N/A"
                const rating = recipe.rating ? recipe.rating : "N/A";

                // Add inner HTML for the recipe card
                recipeCard.innerHTML = `
                    <img src="${recipe.image}" alt="${recipe.title}" class="recipe-image">
                    <h2 class="recipe-title">${recipe.title}</h2>
                    <div class="rating">Rating: ${rating} <span>&#9733;</span></div>
                    <p class="recipe-description">${recipe.description}</p>
                `;

                // Add click event to navigate to the recipe detail page
                recipeCard.addEventListener("click", () => {
                    window.location.href = `recipe-detail.php?recipe_id=${recipe.recipe_id}`;
                });

                // Append the card to the search results
                searchResults.appendChild(recipeCard);
            });
        } else {
            searchResults.innerHTML = "<p>No recipes found.</p>";
        }

    } catch (error) {
        console.error("Error searching recipes:", error);
        searchResults.innerHTML = "<p>Failed to load search results.</p>";
    }
}
