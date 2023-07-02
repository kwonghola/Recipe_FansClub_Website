
CREATE TABLE User_info (
  user_id INT NOT NULL AUTO_INCREMENT,
  user_name VARCHAR(50) NOT NULL,
  user_pw VARCHAR(255) NOT NULL,
  user_email VARCHAR(50) NOT NULL,
  f_name VARCHAR(50) NOT NULL,
  l_name VARCHAR(50) NOT NULL,
  date_joined TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_login DATETIME DEFAULT CURRENT_TIMESTAMP,
  is_admin BOOLEAN NOT NULL default 0,
  PRIMARY KEY (user_id)
);

CREATE TABLE Recipe (
  recipe_id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  recipe_name VARCHAR(50) NOT NULL,
  cuisine_type VARCHAR(50) NOT NULL,
  diff_level VARCHAR(50) NOT NULL,
  duration INT NOT NULL,
  Ingredient_1 VARCHAR(50) NOT NULL,
  Ingredient_2 VARCHAR(50),
  Ingredient_3 VARCHAR(50),
  recipe_desc  VARCHAR(255),
  PRIMARY KEY (recipe_id),
  FOREIGN KEY (user_id) REFERENCES User_info(user_id)
);

CREATE TABLE Comment (
  cm_id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  recipe_id INT NOT NULL,
  content TEXT NOT NULL,
  date_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  score INT NOT NULL,
  PRIMARY KEY (cm_id),
  FOREIGN KEY (user_id) REFERENCES User_info(user_id),
  FOREIGN KEY (recipe_id) REFERENCES Recipe(recipe_id)
);

