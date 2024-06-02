<?php
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_dbname";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$name = $_POST['name'];
$email = $_POST['email'];
$sport = $_POST['sport'];
$coach_id = $_POST['coach'];
$creneau_id = $_POST['creneau'];

$sqlClient = "SELECT id FROM Utilisateurs WHERE email = '$email'";
$resultClient = $conn->query($sqlClient);

if ($resultClient->num_rows > 0) {
    $row = $resultClient->fetch_assoc();
    $client_id = $row['id'];
} else {
    echo json_encode(['success' => false, 'message' => 'Client not found']);
    exit();
}

$sqlCreneau = "SELECT jour, heure_debut FROM creneau WHERE id = $creneau_id";
$resultCreneau = $conn->query($sqlCreneau);
$rowCreneau = $resultCreneau->fetch_assoc();

$date = $rowCreneau['jour'];
$heure = $rowCreneau['heure_debut'];

$sql = "INSERT INTO Reservation (coach_id, client_id, date, heure, statut) VALUES ('$coach_id', '$client_id', '$date', '$heure', 'confirmé')";

if ($conn->query($sql) === TRUE) {
    $updateCreneau = "UPDATE creneau SET statut_creneau = 1 WHERE id = $creneau_id";
    $conn->query($updateCreneau);
    echo json_encode(['success' => true, 'message' => 'Appointment booked successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
}

$conn->close();
?>
