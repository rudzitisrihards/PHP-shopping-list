<?php
// datubāzes pieslēguma info
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = ""; // default password for XAMPP is empty
$dbname = "shopping_list";

// izveidot konekciju ar datubāzi
$conn = new mysqli($servername, $username, $password, $dbname);

// pārbaudīt konekciju ar datubāzi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $newItem = $_POST['new_item'];

    // ievietot datubāzē jaunu itemu
    $sql = "INSERT INTO items (item_name) VALUES ('$newItem')";

    if ($conn->query($sql) === TRUE) {
        // ja items ir veiksmīgi ievietots, refreshojam lapu
        header("Location: index.php");
        exit();
    } else { // ja items nav veiksmīgi ievietots, parādam erroru
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>PHP shopping List</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>PHP shopping List</h1>

    <!-- Forma, lai pieliktu itemus -->
    <form method="post" action="">
        <input type="text" name="new_item" placeholder="Enter new item">
        <button type="submit" name="add">Add</button>
    </form>

    <!-- Liste, kas rāda esošos itemus -->
    <ul>
        <?php
        // Fetch esošos itemus no datubāzes
        $sql = "SELECT * FROM items";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row["item_name"] . "
                    <form method='post' action='delete.php'>
                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                        <button type='submit' name='delete'>Delete</button>
                    </form>
                    <form method='get' action='edit.php'>
                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                        <button type='submit' name='edit'>Edit</button>
                    </form>
                </li>";
            }
        } else {
            echo "<li>No items in the list</li>";
        }
        ?>
    </ul>
</body>

</html>


