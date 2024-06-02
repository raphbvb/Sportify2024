<?php
// Récupérer les données du formulaire
$cardType = $_POST['cardType'];
$cardNumber = $_POST['cardNumber'];
$cardName = $_POST['cardName'];
$expirationDate = $_POST['expirationDate'];
$securityCode = $_POST['securityCode'];

// Vérifier si les données sont présentes et valides
if ($cardType && $cardNumber && $cardName && $expirationDate && $securityCode) {
    // Traitement de la transaction (simulation)
    // Vous pouvez implémenter la logique de validation avec une base de données, une API de paiement, etc.
    // Pour l'exemple, simplement afficher les données
    echo "Type de carte : $cardType<br>";
    echo "Numéro de carte : $cardNumber<br>";
    echo "Nom affiché dans la carte : $cardName<br>";
    echo "Date d'expiration : $expirationDate<br>";
    echo "Code de sécurité : $securityCode<br>";
    echo "Paiement validé.";
} else {
    // Si des données sont manquantes, afficher un message d'erreur
    echo "Erreur : Veuillez remplir tous les champs.";
}
?>
