<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coachs</title>
</head>
<body>
<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sportify";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $specialite = $_POST["specialite"];

    // Requête pour sélectionner les coachs avec la spécialité choisie
    $sql = "SELECT id, nom, prenom, photo, salle, telephone, email FROM Coachs WHERE specialite = '$specialite'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Coachs avec la spécialité $specialite :</h2>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>";
            echo "<strong>Nom:</strong> " . $row["nom"] . " " . $row["prenom"] . "<br>";
            echo "<strong>Photo:</strong> <img src='" . $row["photo"] . "' alt='Photo du coach' width='100'><br>";
            echo "<strong>Coordonnées:</strong><br>";
            echo "Bureau: " . $row["salle"] . "<br>";
            echo "Téléphone: " . $row["telephone"] . "<br>";
            echo "Courriel: " . $row["email"] . "<br>";
            
            // Boutons
            echo "<button onclick=\"prendreRdv('".$row["nom"]."','".$row["prenom"]."')\">Prendre un RDV</button>";
            echo "<button onclick=\"communiquerCoach('".$row["email"]."')\">Communiquer avec le coach</button>";
            echo "<button onclick=\"voirCv(" . $row["id"] . ")\">Voir le CV</button>";

            
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucun coach trouvé avec la spécialité $specialite";
    }
}

$conn->close();
?>
<script>
        // Fonction pour voir le CV
        function voirCv(coachId) {
            // Redirection vers la page voir_cv.php avec l'ID du coach
            window.location.href = 'voir_cv.php?id=' + coachId;
        }
    </script>
</body>
</html>


