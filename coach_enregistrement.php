<?php
// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sportify";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$specialite = $_POST['specialite'];
$salle = $_POST['salle'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$photo = "";

// Gestion de l'upload de la photo
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $photo = basename($_FILES['photo']['name']);
    $target_dir = "image coachs/";
    $target_file = $target_dir . $photo;
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
}

// Gestion de l'upload du CV
if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
    $cv_temp = $_FILES['cv']['tmp_name'];
    $cv_content = file_get_contents($cv_temp);
    $cv_base64 = base64_encode($cv_content);
}

// Création du contenu XML
$xml_content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml_content .= "<cv>\n";
$xml_content .= "<content><![CDATA[$cv_base64]]></content>\n"; // Utilisation de CDATA pour le contenu encodé
$xml_content .= "</cv>";

// Générer un nom de fichier unique pour le CV
$cv_filename = uniqid('cv_') . '.xml';

// Chemin du répertoire pour stocker les fichiers XML
$xml_directory = 'cv_coachs/';

// Chemin complet du fichier XML
$xml_filepath = $xml_directory . $cv_filename;

// Enregistrer le contenu XML dans le fichier
file_put_contents($xml_filepath, $xml_content);

// Préparer et exécuter la requête d'insertion
$sql = "INSERT INTO Coachs (nom, prenom, specialite, salle, email, telephone, cv, photo) 
        VALUES ('$nom', '$prenom', '$specialite', '$salle', '$email', '$telephone', '$cv_filename', '$target_file')";

if ($conn->query($sql) === TRUE) {
    echo "Nouveau coach enregistré avec succès. ID: " . $conn->insert_id;
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

// Fermer la connexion
$conn->close();
?>
