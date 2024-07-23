
<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = htmlspecialchars($_POST['name']);
    $comment = htmlspecialchars($_POST['comment']);

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE comments SET name=?, comment=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $comment, $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Comment updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    $id = $_GET['id'];

    // Fetch the comment to be edited
    $sql = "SELECT name, comment FROM comments WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name, $comment);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment</title>
</head>
<body>
    <h1>Edit Comment</h1>
    <form action="edit_comment.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br><br>
        <label for="comment">Comment:</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50" required><?php echo $comment; ?></textarea><br><br>
        <input type="submit" value="Update Comment">
    </form>
</body>
</html>

<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error