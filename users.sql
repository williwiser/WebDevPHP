CREATE TABLE users (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

SELECT * FROM users;

ALTER TABLE users ADD COLUMN user_type ENUM('normal','editor') NOT NULL DEFAULT 'normal';

CREATE TABLE Newsletter(
	email varchar(255) NOT NULL,
    frequency varchar(255) NOT NULL,
    PRIMARY KEY (email)
);

SELECT * FROM Newsletter;

CREATE TABLE recipes (
	recipe_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(225) NOT NULL,
    image VARCHAR(255),
    rating FLOAT,
    description TEXT
);

CREATE TABLE ingredients (
    ingredient_id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT,
    ingredient VARCHAR(255),
    FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
);

CREATE TABLE instructions (
    instruction_id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT,
    step_number INT,
    instruction TEXT,
    FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
);

INSERT INTO recipes (title, image, rating, description)
VALUES
('Beef Stew', 'img/stew.jpg', 4.5, 'Classic beef stew with vegetables.'),
('Spaghetti Carbonara', 'img/sphageti.jpg', 4.7, 'Rich spaghetti with creamy carbonara sauce.');

INSERT INTO ingredients (recipe_id, ingredient)
VALUES
(1, '1 lb beef'),
(1, '3 carrots, chopped'),
(1, '2 potatoes, diced'),
(1, '1 onion, chopped'),
(1, '2 cups beef broth'),
(1, 'Salt and pepper to taste'),
(2, '200g spaghetti'),
(2, '100g pancetta'),
(2, '2 large eggs'),
(2, '50g Parmesan cheese'),
(2, 'Black pepper to taste'),
(2, 'Salt to taste');

INSERT INTO instructions (recipe_id, step_number, instruction)
VALUES
(1, 1, 'Brown the beef in a pot.'),
(1, 2, 'Add chopped vegetables and broth.'),
(1, 3, 'Simmer for 1-2 hours until tender.'),
(2, 1, 'Cook spaghetti according to package instructions.'),
(2, 2, 'Fry pancetta until crispy.'),
(2, 3, 'Mix with eggs, cheese, and pepper.'),
(2, 4, 'Toss with cooked spaghetti and serve.');

SELECT * FROM recipes;
SELECT * FROM ingredients ;
SELECT * FROM instructions;

SELECT * FROM ingredients WHERE recipe_id = 2;  -- Replace with appropriate recipe_id
SELECT * FROM instructions WHERE recipe_id = 2; -- Replace with appropriate recipe_id

