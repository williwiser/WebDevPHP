// Load recipe from storage
const recipe = JSON.parse(localStorage.getItem('selectedRecipe')); // Retrieve saved recipe

if (recipe) {
    // Update the page content with recipe details
    document.getElementById('recipe-title').textContent = recipe.title;
    document.getElementById('recipe-detail').src = recipe.image;
    document.getElementById('recipe-discription').textContent = recipe.description;

    // Clear previous list content if any
    const ingredientsList = document.getElementById('recipe-ingredients');
    ingredientsList.innerHTML = '';  // Clear the list
    recipe.ingredients.forEach(ingredient => {
        const li = document.createElement('li');
        li.textContent = ingredient;
        ingredientsList.appendChild(li);
    });

    // Clear previous instruction list content if any
    const instructionsList = document.getElementById('recipe-instructions');
    instructionsList.innerHTML = '';  // Clear the list
    recipe.instructions.forEach(instruction => {
        const li = document.createElement('li');
        li.textContent = instruction;
        instructionsList.appendChild(li);
    });

} else {
    document.getElementById("recipe-title").textContent = 'No recipe found';
}
