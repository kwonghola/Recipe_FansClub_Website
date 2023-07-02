<?php
include('db_connect.php');

session_start();

// When form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset( $_POST['comment'])&& isset( $_POST['rating'])) {
    $recipe_id = $_POST['recipe_id'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
    $user_id = $_SESSION["user_id"]; // Assuming you store user_id in session when logged in

    // Insert comment
    $comment_query = "INSERT INTO Comment (user_id, recipe_id, content, score) VALUES (?, ?, ?, ?)";
    $comment_stmt = $conn->prepare($comment_query);
    $comment_stmt->bind_param("iisi", $user_id, $recipe_id, $comment, $rating);
    $comment_stmt->execute();



}


$recipe_id = $_POST['recipe_id'];
$recipe_query = "SELECT * FROM Recipe WHERE recipe_id = ?";
$recipe_stmt = $conn->prepare($recipe_query);
$recipe_stmt->bind_param("i", $recipe_id);
$recipe_stmt->execute();
$recipe_result = $recipe_stmt->get_result();
$recipe = $recipe_result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $recipe['recipe_name']; ?> - Recipe Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <ul>
        <li><a href="welcome.php">Home</a></li>
        <li><a href="upload_recipe.html">Upload Recipe</a> </li>
        <li><a href="view_recipe.php">View Recipes</a></li> 
        <li><a href="logout.php">Logout</a></li>
    </ul>
    <h1><?php echo $recipe['recipe_name']; ?></h1>
    <p><?php echo $recipe['recipe_desc']; ?></p>

    <form action="comment.php" method="post">
        <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
        <label for="comment">Comment:</label>
        <textarea name="comment" required></textarea>
        <label for="rating">Rating:</label>
        <select name="rating" required>
            <option value="1">1 Star</option>
            <option value="2">2 Stars</option>
            <option value="3">3 Stars</option>
            <option value="4">4 Stars</option>
            <option value="5">5 Stars</option>
        </select>
        <button type="submit">Submit Comment</button>
    </form>

    <h2>Comments</h2>
<table>
    <tr>
        <th>User</th>
        <th>Comment</th>
        <th>Rating</th>
    </tr>
    <?php
    $comments_query = "SELECT Comment.content, User_info.user_name, Comment.score FROM Comment 
                       INNER JOIN User_info ON Comment.user_id = User_info.user_id 
                       WHERE Comment.recipe_id = ?";
    $comments_stmt = $conn->prepare($comments_query);
    $comments_stmt->bind_param("i", $recipe_id);
    $comments_stmt->execute();
    $comments_result = $comments_stmt->get_result();
    while ($comment = $comments_result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $comment['user_name'] . '</td>';
        echo '<td>' . $comment['content'] . '</td>';
        echo '<td>' . $comment['score'] . '</td>';
        echo '</tr>';
    }
    ?>
</table>

</body>
</html>
