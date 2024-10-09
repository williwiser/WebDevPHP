async function searchRecipes() {
    const searchQuery = document.getElementById("search-bar").value;
    const searchResults = document.getElementById("search-results");

    try {
        const response = await fetch(`search_recipes.php?query=${searchQuery}`);
        const recipes = await response.json();

        searchResults.innerHTML = "";
        recipes.forEach((recipe) => {
            const recipeItem = document.createElement("div");
            recipeItem.innerHTML = `<p>${recipe.title}</p>`;
            recipeItem.onclick = () => {
                window.location.href = `modify_recipe.php?recipe_id=${recipe.recipe_id}`;
            };
            searchResults.appendChild(recipeItem);
        });

    } catch (error) {
        console.error("Error searching recipes:", error);
        searchResults.innerHTML = "<p>Failed to load search results.</p>";
    }
}
