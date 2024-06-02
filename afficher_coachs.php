<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coachs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        .free {
            background-color: green;
            color: white;
        }
        .occupied {
            background-color: red;
            color: white;
        }
        .empty {
            background-color: white;
        }
    </style>
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
            echo "<button onclick=\"window.location.href='selection_creneau.php?coach_id=".$row["id"]."'\">Prendre un RDV</button>";
            echo "<button onclick=\"communiquerCoach('".$row["id"]."')\">Communiquer avec le coach</button>";
            echo "<button onclick=\"voirCv(" . $row["id"] . ")\">Voir le CV</button>";

            // Affichage du tableau des créneaux
            echo "<h3>Créneaux de disponibilité pour " . $row["prenom"] . " " . $row["nom"] . ":</h3>";
            echo "<table>";
            echo "<tr><th>Heure</th><th>Lundi</th><th>Mardi</th><th>Mercredi</th><th>Jeudi</th><th>Vendredi</th></tr>";

            // Heures de 8h à 20h
            for ($h = 8; $h < 21; $h++) {
                $heure_debut = sprintf("%02d:00:00", $h);
                echo "<tr><td>$heure_debut</td>";
                $jours = ["lundi", "mardi", "mercredi", "jeudi", "vendredi"];
                foreach ($jours as $jour) {
                    $sql_creneau = "SELECT statut_creneau FROM creneau WHERE coach_id = " . $row['id'] . " AND jour = '$jour' AND heure_debut = '$heure_debut'";
                    $result_creneau = $conn->query($sql_creneau);

                    if ($result_creneau->num_rows > 0) {
                        $row_creneau = $result_creneau->fetch_assoc();
                        $statut = $row_creneau['statut_creneau'];
                        $class = $statut == 0 ? 'free' : 'occupied';
                        echo "<td class='$class'>" . ($statut == 0 ? "Libre" : "Occupé") . "</td>";
                    } else {
                        echo "<td class='empty'></td>";
                    }
                }
                echo "</tr>";
            }

            echo "</table>";
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
