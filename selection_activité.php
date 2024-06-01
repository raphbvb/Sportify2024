
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection de Coach</title>
</head>
<body>
    <h2>Choisissez une spécialité de coach :</h2>
    <form method="post" action="afficher_coachs.php">
        <label for="specialite">Spécialité :</label>
        <select name="specialite" id="specialite">
            <option value="Musculation">Musculation</option>
            <option value="Fitness">Fitness</option>
            <option value="Biking">Biking</option>
            <option value="Cardio-Training">Cardio-Training</option>
            <option value="Cours Collectifs">Cours Collectifs</option>
            <option value="Basketball">Basketball</option>
            <option value="Football">Football</option>
            <option value="Rugby">Rugby</option>
            <option value="Tennis">Tennis</option>
            <option value="Natation">Natation</option>
            <option value="Plongeon">Plongeon</option>
        </select>
        <input type="submit" value="Afficher les coachs">
    </form>

    <!-- Conteneur pour afficher les résultats -->
    <div id="results"></div>

    <!-- Scripts JavaScript -->
    <script>
        // Gestionnaire d'événements pour afficher les résultats lorsque le formulaire est soumis
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêcher le formulaire de soumettre de manière traditionnelle

            var specialite = document.getElementById('specialite').value;

            // Envoi de la requête AJAX à afficher_coachs.php
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('results').innerHTML = this.responseText;
                }
            };
            xhr.open('POST', 'afficher_coachs.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('specialite=' + specialite);
        });

        // Fonction pour voir le CV
        function voirCv(coachId) {
            // Redirection vers la page PHP avec l'ID du coach
            window.location.href = 'cv_coach.php?id=' + coachId;
        }
    </script>
</body>
</html>
