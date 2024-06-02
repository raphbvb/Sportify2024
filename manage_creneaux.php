<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sportify";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        $coach_id = $_POST['coach_id'];
        $jour = $_POST['jour'];
        $heure_debut = $_POST['heure_debut'];
        $statut_creneau = 0;  // Statut par défaut à 0

        $sql = "INSERT INTO creneau (coach_id, jour, heure_debut, statut_creneau) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $coach_id, $jour, $heure_debut, $statut_creneau);

        if ($stmt->execute()) {
            echo "Nouveau créneau ajouté avec succès.";
        } else {
            echo "Erreur: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($action == 'delete') {
        $creneau_id = $_POST['creneau_id'];

        $sql = "DELETE FROM creneau WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $creneau_id);

        if ($stmt->execute()) {
            echo "Créneau supprimé avec succès.";
        } else {
            echo "Erreur: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
