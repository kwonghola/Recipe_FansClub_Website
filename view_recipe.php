<?php
require_once 'db_connect.php';
session_start();

$cuisine_type = $_POST['cuisine_type'] ?? '';
$recipe_diff = $_POST['recipe_diff'] ?? '';
$recipe_time = $_POST['recipe_time'] ?? '';

// Define base query
$query = "SELECT * FROM Recipe WHERE 1=1 ";

$params = array();
$types = "";

// Append to query and add parameters based on filters
if (!empty($cuisine_type)) {
    $query .= "AND cuisine_type = ? ";
    $params[] = &$cuisine_type;
    $types .= "s";
}
if (!empty($recipe_diff)) {
    $query .= "AND diff_level = ? ";
    $params[] = &$recipe_diff;
    $types .= "s";
}
if (!empty($recipe_time)) {
    $query .= "AND duration <= ? ";
    $params[] = &$recipe_time;
    $types .= "i";
}

// Prepare the statement
$stmt = $conn->prepare($query);

// Only bind parameters if there are parameters to bind
if (!empty($params)) {
    // Dynamic binding of parameters
    call_user_func_array(array($stmt, 'bind_param'), array_merge(array($types), $params));
}

$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Recipes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>View Recipes</h1>
        <ul>
            <li><a href="welcome.php">Home</a></li>
            <li><a href="upload_recipe.html">Upload Recipe</a></li> 
            <li><a href="view_recipe.php">View Recipes</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <select name="cuisine_type">
                <option value="">All Cuisines</option>
                <option value="japanese">Japanese </option>
                <option value="chinese">Chinese</option>
                <option value="indian">Indian</option>
                <option value="korean">Korean</option>
                <option value="taiwan">Taiwan</option>
            </select>

            <select name="recipe_diff">
                <option value="">All Difficulties</option>
                <option value="Low">Low</option>
                <option value="Middle">Middle</option>
                <option value="Hard">Hard</option>
                <option value="Chef">Chef</option>
            </select>

            <select name="recipe_time">
                <option value="">All Durations</option>
                <option value="20">Less than 20 mins</option>
                <option value="30">20-30 mins</option>
                <option value="40">30-40</option>
                <option value="50">50-60</option>
                <option value="60">More than 1 hour</option>
            </select>

            <input type="submit" value="Filter">
        </form>
        
        <table>
            <thead>
                <tr>
                    <th>Recipe Name</th>
                    <th>Cuisine Type</th>
                    <th>Difficulty</th>
                    <th>Duration</th>
                    <th>Ingredients</th>
                    <th>Description</th>
                    <th>Comment</th>
                    <th>remove(admin)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['recipe_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['cuisine_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['diff_level']); ?></td>
                        <td><?php echo htmlspecialchars($row['duration']); ?> mins</td>
                        <td>
                            <?php 
                            $ingredients = array();
                            for ($i = 1; $i <= 3; $i++) {
                                if (!empty($row['Ingredient_'.$i])) {
                                    $ingredients[] = htmlspecialchars($row['Ingredient_'.$i]);
                                }
                            }
                            echo implode(', ', $ingredients);
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['recipe_desc']); ?></td>
                        <td>
                            <form action="comment.php" method="post">
                                <input type="hidden" name="recipe_id" value="<?php echo $row['recipe_id']; ?>">
                                <button type="submit">Comment</button>
                            </form>
                        </td>
                        <td>
                            <?php
                            if ($_SESSION['is_admin']) {
                                echo '<form action="delete_recipe.php" method="post">';
                                echo '<input type="hidden" name="recipe_id" value="' . $row['recipe_id'] . '">';
                                echo '<button type="submit">Remove</button>';
                                echo '</form>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>
</html>