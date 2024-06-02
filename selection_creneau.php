<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisissez vos créneaux</title>
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
            cursor: pointer;
        }
        .occupied {
            background-color: red;
            color: white;
        }
        .empty {
            background-color: white;
        }
        .selected {
            background-color: blue;
            color: white;
        }
    </style>
</head>
<body>
<?php
// Vérifier si l'ID du coach est passé dans l'URL
if (isset($_GET['coach_id'])) {
    $coach_id = $_GET['coach_id'];

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
        // Récupérer les créneaux sélectionnés
        $selected_creneaux = json_decode($_POST['creneaux'], true);
        $user_id = 6; // Remplacez par la logique pour obtenir l'ID de l'utilisateur connecté

        if (!empty($selected_creneaux)) {
            foreach ($selected_creneaux as $creneau_id) {
                // Mettre à jour le statut du créneau dans la base de données
                $update_sql = "UPDATE creneau SET statut_creneau = 1 WHERE id = $creneau_id";
                if ($conn->query($update_sql) === TRUE) {
                    // Insérer la réservation dans la table des réservations
                    $insert_sql = "INSERT INTO reservations (utilisateur_id, creneau_id, coach_id) VALUES ($user_id, $creneau_id, $coach_id)";
                    if ($conn->query($insert_sql) !== TRUE) {
                        echo "Error: " . $insert_sql . "<br>" . $conn->error;
                    }
                } else {
                    echo "Error: " . $update_sql . "<br>" . $conn->error;
                }
            }
            echo "<p>Réservation réussie!</p>";
        } else {
            echo "<p>Aucun créneau sélectionné.</p>";
        }
    }

    // Jours de la semaine
    $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi'];

    // Requête pour obtenir les créneaux du coach
    $sql = "SELECT jour, heure_debut, statut_creneau, id FROM creneau WHERE coach_id = $coach_id AND jour IN ('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi') ORDER BY FIELD(jour, 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi'), heure_debut";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        // Création d'un tableau associatif pour stocker les créneaux par jour
        $creneaux_par_jour = array();
        foreach ($jours as $jour) {
            $creneaux_par_jour[$jour] = array();
        }

        // Stockage des créneaux dans le tableau associatif
        while ($row = $result->fetch_assoc()) {
            array_push($creneaux_par_jour[$row['jour']], $row);
        }

        // Affichage du tableau des créneaux
        echo "<h2>Choisissez vos créneaux :</h2>";
        echo "<form method='POST' action=''>";
        echo "<table>";
        echo "<tr><th>Heure</th><th>Lundi</th><th>Mardi</th><th>Mercredi</th><th>Jeudi</th><th>Vendredi</th></tr>";
        // Heures de 8h à 20h
        for ($h = 8; $h < 21; $h++) {
            $heure_debut = sprintf("%02d:00:00", $h);
            echo "<tr><td>$heure_debut</td>";
            foreach ($jours as $jour) {
                $creneau = null;
                foreach ($creneaux_par_jour[$jour] as $c) {
                    if ($c['heure_debut'] === $heure_debut) {
                        $creneau = $c;
                        break;
                    }
                }
                if ($creneau) {
                    $statut = $creneau['statut_creneau'] == 0 ? 'Libre' : ($creneau['statut_creneau'] == 1 ? 'Réservé' : 'Occupé');
                    $class = $creneau['statut_creneau'] == 0 ? 'free creneau' : 'occupied';
                    echo "<td class='$class' data-creneau-id='".$creneau['id']."'>" . $statut . "</td>";
                } else {
                    echo "<td class='empty'></td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "<input type='hidden' name='creneaux' id='creneauxInput'>";
        echo "<button type='submit'>Valider</button>";
        echo "</form>";
    } else {
        echo "Aucun créneau trouvé pour ce coach.";
    }

    $conn->close();
} else {
    echo "ID du coach non spécifié.";
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const creneaux = document.querySelectorAll('.creneau.free');
    const creneauxInput = document.getElementById('creneauxInput');
    const selectedCreneaux = [];

    creneaux.forEach(creneau => {
        creneau.addEventListener('click', function() {
            const creneauId = creneau.getAttribute('data-creneau-id');
            if (!creneau.classList.contains('selected')) {
                creneau.classList.add('selected');
                selectedCreneaux.push(creneauId);
            } else {
                creneau.classList.remove('selected');
                const index = selectedCreneaux.indexOf(creneauId);
                if (index > -1) {
                    selectedCreneaux.splice(index, 1);
                }
            }
            creneauxInput.value = JSON.stringify(selectedCreneaux);
        });
    });
});
</script>

</body>
</html>
