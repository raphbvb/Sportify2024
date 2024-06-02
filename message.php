<?php
$servername = "localhost";
$username = "root"; // Assurez-vous de changer cela en fonction de vos paramètres
$password = "root";
$dbname = "sportify";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$message = $_POST['message'];

$sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "Message envoyé avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("Location: messagerie.php");
exit();
?>
