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

// Pārbaudīt vai 'id' ir norādīts
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    if(isset($_POST['id'])) {
        $id = $_POST['id'];

        // Delete item from the database WHERE the ID matches
        $sql = "DELETE FROM items WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            // Item deleted successfully
            header("Location: index.php"); // Redirect back to the list
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "No item specified for deletion.";
    }
} else {
    echo "Invalid request for deletion.";
}
?>
