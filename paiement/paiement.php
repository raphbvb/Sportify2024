<?php
session_start();
require 'vendor/autoload.php';

// Configuration de Stripe
\Stripe\Stripe::setApiKey('sk_test_your_secret_key');

$payment_intent = \Stripe\PaymentIntent::create([
    'amount' => 5000, // Montant en centimes (50.00€)
    'currency' => 'eur',
    'metadata' => ['integration_check' => 'accept_a_payment'],
]);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de Paiement - Sportify</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #28a745; color: white; border: none; cursor: pointer; }
    </style>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <div class="container">
        <h1>Paiement</h1>
        <form id="payment-form">
            <div class="form-group">
                <label for="cardholder-name">Nom du titulaire de la carte</label>
                <input id="cardholder-name" type="text">
            </div>
            <div class="form-group">
                <label for="card-number">Numéro de la carte de crédit</label>
                <input id="card-number" type="text" maxlength="16">
            </div>
            <div class="form-group">
                <label for="card-expiry">Date d'expiration (MM/AA)</label>
                <input id="card-expiry" type="text" maxlength="5" placeholder="MM/AA">
            </div>
            <div class="form-group">
                <label for="card-cvv">Cryptogramme visuel (CVV)</label>
                <input id="card-cvv" type="text" maxlength="4">
            </div>
            <button id="card-button" type="button" data-secret="<?= $payment_intent->client_secret ?>">
                Payer
            </button>
        </form>
        <div id="payment-result"></div>
    </div>

    <script>
        var stripe = Stripe('pk_test_your_public_key');
        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        var cardholderName = document.getElementById('cardholder-name');
        var cardNumber = document.getElementById('card-number');
        var cardExpiry = document.getElementById('card-expiry');
        var cardCvv = document.getElementById('card-cvv');
        var cardButton = document.getElementById('card-button');
        var clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async function() {
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: { 
                            name: cardholderName.value,
                            number: cardNumber.value,
                            exp_month: cardExpiry.value.split('/')[0],
                            exp_year: cardExpiry.value.split('/')[1],
                            cvc: cardCvv.value
                        }
                    }
                }
            );

            if (error) {
                // Afficher les erreurs
                document.getElementById('payment-result').textContent = error.message;
            } else {
                // Le paiement a été traité avec succès
                document.getElementById('payment-result').textContent = 'Paiement réussi !';
            }
        });
    </script>
</body>
</html>
