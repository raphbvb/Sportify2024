<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sportify";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT); // Hasher le mot de passe
    $type = "client"; // Définir automatiquement le type comme "client"
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $pays = $_POST['pays'];
    $telephone = $_POST['telephone'];
    $carte_etudiant = $_POST['carte_etudiant'];

    // Concaténer l'adresse complète
    $adresse_complete = $adresse . ', ' . $ville . ', ' . $code_postal . ', ' . $pays;

    // Requête SQL pour insérer les données
    $sql = "INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe, type, adresse, carte_etudiant, telephone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssssssss", $nom, $prenom, $email, $mot_de_passe, $type, $adresse_complete, $carte_etudiant, $telephone);

    if ($stmt->execute() === TRUE) {
        header("Location: accueil.html");
        exit();
    } else {
        echo "Erreur: " . $stmt->error;
    }
    $stmt->close();
}
?>
