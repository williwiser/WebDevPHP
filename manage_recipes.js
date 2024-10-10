document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-bar");
    const searchResults = document.getElementById("search-results");
    const modifyModal = document.getElementById("modifyModal");
    const deleteModal = document.getElementById("confirmModal");

    // Ensure modals are hidden by default
    modifyModal.style.display = "none";
    deleteModal.style.display = "none";

    function loadRecipes(query = "") {
        fetch(`get_recipes.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(recipes => {
                console.log("Fetched recipes:", recipes);
                searchResults.innerHTML = "";
                recipes.forEach(recipe => {
                    const recipeCard = document.createElement("div");
                    recipeCard.classList.add("recipe-card");
                    recipeCard.innerHTML = `
                        <img src="${recipe.image}" alt="${recipe.title}" class="recipe-image">
                        <h2>${recipe.title}</h2>
                        <p>${recipe.description}</p>
                        <button class="modify-btn" data-id="${recipe.recipe_id}">Modify</button>
                        <button class="delete-btn" data-id="${recipe.recipe_id}">Delete</button>
                    `;
                    searchResults.appendChild(recipeCard);
                });
            })
            .catch(error => console.error("Error fetching recipes:", error));
    }

    searchInput.addEventListener("input", function () {
        console.log("Search query:", searchInput.value);
        loadRecipes(searchInput.value);
    });

    loadRecipes();

    // Event listener for opening the modify modal when a 'Modify' button is clicked
    searchResults.addEventListener("click", function (event) {
        if (event.target.classList.contains("modify-btn")) {
            const recipeId = event.target.getAttribute("data-id");
            fetch(`get_recipe_details.php?id=${recipeId}`)
                .then(response => response.json())
                .then(recipe => {
                    if (recipe) {
                        document.getElementById("modify-recipe-id").value = recipeId;
                        document.getElementById("modify-title").value = recipe.title;
                        document.getElementById("modify-description").value = recipe.description;
                        document.getElementById("modify-ingredients").value = recipe.ingredients.join("\n");
                        document.getElementById("modify-instructions").value = recipe.instructions.join("\n");

                        const currentImageElement = document.getElementById("modify-current-image");
                        if (currentImageElement) {
                            const imageSrc = recipe.image ? recipe.image : "path/to/placeholder-image.jpg";
                            currentImageElement.src = imageSrc;
                        }

                        modifyModal.style.display = "flex";
                    } else {
                        alert("Error loading recipe details. Please try again later.");
                    }
                })
                .catch(error => {
                    console.error("Error fetching recipe details:", error);
                    alert("Error loading recipe details. Please try again later.");
                });
        }
    });

    // Event listener for opening the delete modal when a 'Delete' button is clicked
    searchResults.addEventListener("click", function (event) {
        if (event.target.classList.contains("delete-btn")) {
            const recipeId = event.target.getAttribute("data-id");
            document.getElementById("confirmYes").setAttribute("data-id", recipeId);
            deleteModal.style.display = "flex";
        }
    });

    // Close the modify modal when 'Cancel' is clicked
    document.getElementById("modify-cancel").addEventListener("click", function () {
        modifyModal.style.display = "none";
    });

    // Close the delete modal when 'No' is clicked
    document.getElementById("confirmNo").addEventListener("click", function () {
        deleteModal.style.display = "none";
    });

    // Handle the delete action when 'Yes' is clicked in the delete modal
    document.getElementById("confirmYes").addEventListener("click", function () {
        const recipeId = this.getAttribute("data-id");
        fetch(`delete_recipe.php?id=${recipeId}`, {
            method: "DELETE",
        })
            .then(response => response.text())
            .then(message => {
                alert(message);
                deleteModal.style.display = "none";
                loadRecipes(searchInput.value);
            })
            .catch(error => console.error("Error deleting recipe:", error));
    });

    // Save changes in the modify modal when 'Save' is clicked
    document.getElementById("modify-save").addEventListener("click", function () {
        const recipeId = document.getElementById("modify-recipe-id").value;
        const title = document.getElementById("modify-title").value;
        const description = document.getElementById("modify-description").value;
        const ingredients = document.getElementById("modify-ingredients").value;
        const instructions = document.getElementById("modify-instructions").value;
        const imageInput = document.getElementById("modify-image").files[0];

        if (!title || !description || !ingredients || !instructions) {
            alert("Please fill in all required fields.");
            return;
        }

        const formData = new FormData();
        formData.append("id", recipeId);
        formData.append("title", title);
        formData.append("description", description);
        formData.append("ingredients", ingredients);
        formData.append("instructions", instructions);

        if (imageInput) {
            formData.append("image", imageInput);
        } else {
            const currentImageSrc = document.getElementById("modify-current-image").src;
            formData.append("currentImage", currentImageSrc);
        }

        fetch(`process_modify_recipe.php`, {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert("Recipe modified successfully!");
                    modifyModal.style.display = "none";
                    loadRecipes(searchInput.value);
                } else {
                    alert(result.error);
                }
            })
            .catch(error => console.error("Error modifying recipe:", error));
    });
});
