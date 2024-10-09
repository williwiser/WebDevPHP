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

                // Set the rating or default to "0"
                const rating = recipe.rating ? recipe.rating : "0";

                recipeCard.innerHTML = `
                    <img src="${recipe.image}" alt="${recipe.title}" class="recipe-image">
                    <h2 class="recipe-title">${recipe.title}</h2>
                    <div class="rating">Rating: ${rating} <span>&#9733;</span></div>
                    <p class="recipe-description">${recipe.description}</p>
                `;

                recipeCard.addEventListener("click", () => {
                    window.location.href = `recipe-detail.php?recipe_id=${recipe.recipe_id}`;
                });

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
