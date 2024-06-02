<?php
// Configuration de la base de données
$host = 'localhost';
$db = 'sportify';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Configuration des options PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Connexion à la base de données
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Fonction de recherche
function searchCoaches($pdo, $criteria, $value) {
    $sql = "SELECT * FROM Coachs WHERE $criteria LIKE :value";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['value' => "%$value%"]);
    return $stmt->fetchAll();
}

// Exemple d'utilisation de la fonction de recherche
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $criteria = $_POST['criteria'];  // 'nom', 'specialite', ou 'salle'
    $value = $_POST['value'];
    $results = searchCoaches($pdo, $criteria, $value);

    // Affichage des résultats
    foreach ($results as $coach) {
        echo "Nom: " . $coach['nom'] . " " . $coach['prenom'] . "<br>";
        echo "Spécialité: " . $coach['specialite'] . "<br>";
        echo "Salle: " . $coach['salle'] . "<br>";
        echo "Email: " . $coach['email'] . "<br>";
        echo "Téléphone: " . $coach['telephone'] . "<br><br>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recherche de Coachs</title>
</head>
<body>
    <h1>Recherche de Coachs</h1>
    <form method="post">
        <label for="criteria">Critère:</label>
        <select name="criteria" id="criteria">
            <option value="nom">Nom</option>
            <option value="specialite">Spécialité</option>
            <option value="salle">Salle</option>
        </select>
        <br>
        <label for="value">Valeur:</label>
        <input type="text" id="value" name="value" required>
        <br>
        <input type="submit" value="Rechercher">
    </form>
</body>
</html>
