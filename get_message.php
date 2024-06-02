<?php
$servername = "localhost";
$username = "root"; // Assurez-vous de changer cela en fonction de vos paramètres
$password = "root";
$dbname = "sportify";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM messages ORDER BY timestamp ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p><strong>" . ($row['sender_id'] == 6 ? 'Coach' : 'User') . ":</strong> " . $row['message'] . " <em>(" . $row['timestamp'] . ")</em></p>";
    }
} else {
    echo "Aucun message";
}

$conn->close();
?>
