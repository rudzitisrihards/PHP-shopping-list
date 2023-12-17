<?php
// datubāzes pieslēguma info
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping_list";

// izveidot konekciju ar datubāzi
$conn = new mysqli($servername, $username, $password, $dbname);

// pārbaudīt konekciju ar datubāzi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $id = $_GET['id'];
    $editedItem = $_POST['edited_item'];

    // Updeitot itemu datubāzē
    $sql = "UPDATE items SET item_name = '$editedItem' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Ja items ir updeitots sekmīgi, iet atpakaļ uz index
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Dabūt itema datus no datubāzes, lai aizpildītu input laukus
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Dabūt itemu datus
        $sql = "SELECT * FROM items WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $itemName = $row['item_name'];
        } else {
            echo "No item found.";
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
</head>
<body>
    <h1>Edit Item</h1>
    <form method="post" action="">
        <input type="text" name="edited_item" value="<?php echo $itemName; ?>">
        <button type="submit" name="edit">Save Changes</button>
    </form>
</body>
</html>
