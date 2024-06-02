document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('paymentForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche l'envoi du formulaire par défaut

        // Valider les champs de saisie
        var cardType = document.getElementById('cardType').value;
        var cardNumber = document.getElementById('cardNumber').value;
        var cardName = document.getElementById('cardName').value;
        var expirationDate = document.getElementById('expirationDate').value;
        var securityCode = document.getElementById('securityCode').value;

        // Effectuer une validation basique des champs (par exemple, longueur)
        if (cardType && cardNumber.length === 16 && cardName && expirationDate && securityCode.length === 3) {
            // Si tous les champs sont valides, soumettre le formulaire
            this.submit();
        } else {
            // Sinon, afficher un message d'erreur
            alert('Veuillez remplir correctement tous les champs.');
        }
    });
});
