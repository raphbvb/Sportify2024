<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Messagerie</title>
</head>
<body>
    <h1>Messagerie</h1>
    <form action="message.php" method="POST">
        <input type="hidden" name="sender_id" value="6"> <!-- ID du coach -->
        <input type="hidden" name="receiver_id" value="1"> <!-- ID de l'utilisateur -->
        <textarea name="message" placeholder="Entrez votre message ici..."></textarea>
        <button type="submit">Envoyer</button>
    </form>
    <div id="messages">
        <?php include 'get_message.php'; ?>
    </div>
</body>
</html>
