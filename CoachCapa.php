<?php
session_start();
// Vérifiez si l'utilisateur est un coach
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'coach') {
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

// Fonction pour obtenir les consultations du coach
function getConsultations($pdo, $coach_id) {
    $sql = "SELECT c.date_heure, c.informations, u.nom, u.prenom, u.email 
            FROM Consultations c 
            JOIN Utilisateurs u ON c.client_id = u.id 
            WHERE c.coach_id = :coach_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['coach_id' => $coach_id]);
    return $stmt->fetchAll();
}

$coach_id = $_SESSION['user_id'];
$consultations = getConsultations($pdo, $coach_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page Coach - Sportify</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <h1>Page Coach - Vos Consultations</h1>
    
    <!-- Menu "Votre Compte" -->
    <h2>Votre Compte</h2>
    <p>Nom et Prénom: <?php echo htmlspecialchars($_SESSION['nom'] . ' ' . $_SESSION['prenom']); ?></p>
    <p>Courriel: <?php echo htmlspecialchars($_SESSION['email']); ?></p>

    <!-- Liste des consultations -->
    <h2>Vos Consultations</h2>
    <table>
        <thead>
            <tr>
                <th>Date et Heure</th>
                <th>Informations du Client</th>
                <th>Nom du Client</th>
                <th>Prénom du Client</th>
                <th>Email du Client</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultations as $consultation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($consultation['date_heure']); ?></td>
                    <td><?php echo htmlspecialchars($consultation['informations']); ?></td>
                    <td><?php echo htmlspecialchars($consultation['nom']); ?></td>
                    <td><?php echo htmlspecialchars($consultation['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($consultation['email']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Section de chat et communication -->
    <h2>Communication avec les Clients</h2>
    <!-- Remplacez par votre propre implémentation de chat -->
    <p>Pour communiquer avec vos clients, veuillez utiliser l'outil de chat intégré ou d'autres moyens de communication disponibles.</p>

</body>
</html>
