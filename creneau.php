<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Créneaux</title>
</head>
<body>
    <h1>Gestion des Créneaux pour les Coachs</h1>

    <?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "sportify";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }

    // Récupérer la liste des coachs
    $sql = "SELECT id, nom, prenom FROM Coachs";
    $result = $conn->query($sql);
    ?>

    <form action="manage_creneaux.php" method="post">
        <h2>Ajouter un Créneau</h2>
        <label for="coach_id">Sélectionner le Coach :</label>
        <select id="coach_id" name="coach_id" required>
            <option value="">Sélectionner un coach</option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $row['prenom'] . ' ' . $row['nom'] . '</option>';
                }
            }
            ?>
        </select><br><br>

        <label for="jour">Jour :</label>
        <select id="jour" name="jour" required>
            <option value="lundi">Lundi</option>
            <option value="mardi">Mardi</option>
            <option value="mercredi">Mercredi</option>
            <option value="jeudi">Jeudi</option>
            <option value="vendredi">Vendredi</option>
            <option value="samedi">Samedi</option>
            <option value="dimanche">Dimanche</option>
        </select><br><br>

        <label for="heure_debut">Heure de Début :</label>
        <input type="time" id="heure_debut" name="heure_debut" required><br><br>

        <input type="hidden" name="action" value="add">
        <button type="submit">Ajouter Créneau</button>
    </form>

    <form action="manage_creneaux.php" method="post">
        <h2>Supprimer un Créneau</h2>
        <label for="creneau_id">ID du Créneau :</label>
        <input type="number" id="creneau_id" name="creneau_id" required><br><br>

        <input type="hidden" name="action" value="delete">
        <button type="submit">Supprimer Créneau</button>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
