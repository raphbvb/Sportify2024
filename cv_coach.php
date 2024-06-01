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

// Récupérer l'ID du coach
$coach_id = $_GET['id'];

// Afficher l'ID du coach
echo "ID du coach : " . $coach_id . "<br>";

// Récupérer le chemin du fichier XML du CV à partir de la base de données
$sql = "SELECT cv FROM Coachs WHERE id = '$coach_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cv_filename = $row['cv'];

    // Chemin complet du fichier XML
    $xml_filepath = 'cv_coachs/' . $cv_filename;

    // Lire le fichier XML
    if (file_exists($xml_filepath)) {
        $xml_content = file_get_contents($xml_filepath);

        // Charger le contenu XML
        $xml = simplexml_load_string($xml_content);
        $cv_base64 = (string) $xml->content;

        // Décoder le contenu base64
        $cv_pdf = base64_decode($cv_base64);

        // Définir les en-têtes pour afficher le fichier PDF dans le navigateur
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="cv.pdf"');
        echo $cv_pdf;
    } else {
        echo "Le fichier XML du CV n'existe pas.";
    }
} else {
    echo "Aucun CV trouvé pour cet ID de coach.";
}

// Fermer la connexion
$conn->close();
?>
