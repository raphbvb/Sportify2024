<?php
session_start();
// Vérifiez si l'utilisateur est un administrateur
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'administrateur') {
    header('Location: login.php');
    exit();
}

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

// Fonction pour ajouter un coach
function addCoach($pdo, $data) {
    $sql = "INSERT INTO Coachs (utilisateur_id, nom, prenom, specialite, salle, email, telephone, cv, photo, video) 
            VALUES (:utilisateur_id, :nom, :prenom, :specialite, :salle, :email, :telephone, :cv, :photo, :video)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

// Fonction pour retirer un coach
function removeCoach($pdo, $id) {
    $sql = "DELETE FROM Coachs WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}

// Fonction pour obtenir tous les coachs
function getAllCoaches($pdo) {
    $sql = "SELECT * FROM Coachs";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

// Gestion des actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_coach'])) {
        $data = [
            'utilisateur_id' => $_POST['utilisateur_id'],
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'specialite' => $_POST['specialite'],
            'salle' => $_POST['salle'],
            'email' => $_POST['email'],
            'telephone' => $_POST['telephone'],
            'cv' => $_POST['cv'],
            'photo' => $_POST['photo'],
            'video' => $_POST['video']
        ];
        addCoach($pdo, $data);
    } elseif (isset($_POST['remove_coach'])) {
        $id = $_POST['id'];
        removeCoach($pdo, $id);
    }
}

$coaches = getAllCoaches($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page Administrateur - Sportify</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <h1>Page Administrateur - Gestion des Coachs</h1>
    
    <!-- Menu "Votre Compte" -->
    <h2>Votre Compte</h2>
    <p>Nom et Prénom: <?php echo htmlspecialchars($_SESSION['nom'] . ' ' . $_SESSION['prenom']); ?></p>
    <p>Courriel: <?php echo htmlspecialchars($_SESSION['email']); ?></p>

    <!-- Formulaire pour ajouter un coach -->
    <h2>Ajouter un Coach</h2>
    <form method="post">
        <input type="hidden" name="add_coach" value="1">
        <label for="utilisateur_id">Utilisateur ID:</label>
        <input type="number" id="utilisateur_id" name="utilisateur_id" required><br>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required><br>
        <label for="specialite">Spécialité:</label>
        <input type="text" id="specialite" name="specialite" required><br>
        <label for="salle">Salle:</label>
        <input type="text" id="salle" name="salle" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="telephone">Téléphone:</label>
        <input type="text" id="telephone" name="telephone" required><br>
        <label for="cv">CV (fichier):</label>
        <input type="text" id="cv" name="cv" required><br>
        <label for="photo">Photo (fichier):</label>
        <input type="text" id="photo" name="photo" required><br>
        <label for="video">Vidéo (fichier):</label>
        <input type="text" id="video" name="video"><br>
        <input type="submit" value="Ajouter">
    </form>

    <!-- Formulaire pour retirer un coach -->
    <h2>Retirer un Coach</h2>
    <form method="post">
        <input type="hidden" name="remove_coach" value="1">
        <label for="id">ID du Coach:</label>
        <input type="number" id="id" name="id" required><br>
        <input type="submit" value="Retirer">
    </form>

    <!-- Liste de tous les coachs -->
    <h2>Liste des Coachs</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Spécialité</th>
                <th>Salle</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>CV</th>
                <th>Photo</th>
                <th>Vidéo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($coaches as $coach): ?>
                <tr>
                    <td><?php echo htmlspecialchars($coach['id']); ?></td>
                    <td><?php echo htmlspecialchars($coach['nom']); ?></td>
                    <td><?php echo htmlspecialchars($coach['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($coach['specialite']); ?></td>
                    <td><?php echo htmlspecialchars($coach['salle']); ?></td>
                    <td><?php echo htmlspecialchars($coach['email']); ?></td>
                    <td><?php echo htmlspecialchars($coach['telephone']); ?></td>
                    <td><?php echo htmlspecialchars($coach['cv']); ?></td>
                    <td><?php echo htmlspecialchars($coach['photo']); ?></td>
                    <td><?php echo htmlspecialchars($coach['video']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
