<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: compte.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportify - Consultation sportive en ligne</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var $items = $('#carrousel li'); 
            var max = $items.length; 
            var i = 0; // compteur 

            $items.hide(); 
            $items.slice(i, i + 1).show(); 

            //si on clique sur « next » ou « > »
            $('.next').click(function () { 
                i += 1; // on incrémente le compteur 
                if (i >= max) {
                    i = 0; 
                } 
                $items.hide();
                $items.slice(i, i + 1).show(); 
            }); 

            //si on clique sur « prev » ou « < »
            $('.prev').click(function () { 
                i -= 1; // on décrémente le compteur 
                if (i < 0) {
                    i = max - 1; // retourne au dernier groupe d'éléments si i est négatif
                }
                $items.hide();
                $items.slice(i, i + 1).show(); 
            });

            function slideItems() {
                setTimeout(function() {
                    i += 1;
                    if (i >= max) {
                        i = 0;
                    }
                    $items.hide();
                    $items.slice(i, i + 1).show();
                    slideItems();
                }, 4000);
            }

            slideItems();
        });
    </script>  
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>Sportify: Consultation Sportive</h1>
            <img src="images globales\sportify.png" alt="Logo Sportify">
        </header>
        <nav class="navigation">
            <button id="accueil-button">Accueil</button>
            <button id="browse-button">Tout Parcourir</button>
            <div id="browse-dropdown" class="dropdown-content">
                <a href="selection_activité.php">Activités sportives</a>
                <a href="selection_activité.php">Les Sports de compétition</a>
                <a href="salle-de-sport-omnes.html">Salle de sport Omnes</a>
            </div>
            <button id="search-button">Recherche</button>
            <button id="appointment-button">Rendez-vous</button>
            <button id="account-button">Votre Compte</button>
            <div id="account-dropdown" class="dropdown-content">
                <a href="inscription.html">S'inscrire</a>
                <a href="connexion.html">Se connecter</a>
                <a href="deconnexion.php">Se déconnecter</a>
            </div>
        </nav>
        <section class="section" id="main-section">
            <!-- Carrousel des scores -->
            <div id="carrousel">
                <ul> 
                    <li>
                        <img src="img carroussel score\logo-borussia-dortmund-4096.png" alt="Logo Équipe 1 dortmund">
                        <span>BVB 09</span>
                        <span>2 - 2</span>
                        <span>Bayern</span>
                        <img src="img carroussel score\fc-bayern-munchen-emblem.png" alt="Logo Équipe 2 Bayern">
                    </li>  
                    <li>
                        <img src="img carroussel score\logo__pxbve6.png" alt="Logo Équipe 3 lyonhand">
                        <span>Lyon Handball</span>
                        <span>15 - 10</span>
                        <span>PSG Handball</span>
                        <img src="img carroussel score\OIP.jpeg" alt="Logo Équipe 4 psghand">
                    </li> 
                    <li>
                        <img src="img carroussel score\Los_Angeles_Lakers_logo.svg.png" alt="Logo Équipe 5 lakers">
                        <span>Lakers</span>
                        <span>82 - 102</span>
                        <span>Celtics</span>
                        <img src="img carroussel score\Boston-Celtics-Logo-1996-present.png" alt="Logo Équipe 6 Celtics">
                    </li> 
                    <li>
                        <img src="img carroussel score\real-madrid-c.f.-logo-vector-400x400.png" alt="Logo Équipe 7 real">
                        <span>Real Madrid</span>
                        <span>0 - 0</span>
                        <span>Barca</span>
                        <img src="img carroussel score\sticker-logo-club-football-fc-barcelone-autocollant-foot-747_800x800.png" alt="Logo Équipe 8 barca">
                    </li>
                    <li>
                        <img src="logo9.png" alt="Logo Équipe 9">
                        <span>Surnom Équipe 9</span>
                        <span>3 - 1</span>
                        <span>Surnom Équipe 10</span>
                        <img src="logo10.png" alt="Logo Équipe 10">
                    </li> 
                    <li>
                        <img src="logo11.png" alt="Logo Équipe 11">
                        <span>Surnom Équipe 11</span>
                        <span>7 - 8</span>
                        <span>Surnom Équipe 12</span>
                        <img src="logo12.png" alt="Logo Équipe 12">
                    </li> 
                    <li>
                        <img src="logo13.png" alt="Logo Équipe 13">
                        <span>Surnom Équipe 13</span>
                        <span>2 - 2</span>
                        <span>Surnom Équipe 14</span>
                        <img src="logo14.png" alt="Logo Équipe 14">
                    </li> 
                    <li>
                        <img src="logo15.png" alt="Logo Équipe 15">
                        <span>Surnom Équipe 15</span>
                        <span>6 - 9</span>
                        <span>Surnom Équipe 16</span>
                        <img src="logo16.png" alt="Logo Équipe 16">
                    </li>
                </ul>
                <div class="prev">&lt;</div>
                <div class="next">&gt;</div>
            </div>
        </section>
        <section class="section" id="search-section" style="display: none;">
            <input type="text" id="search-input" placeholder="Recherchez...">
            <button id="search-submit">Rechercher</button>
        </section>
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-section about">
                    <h2>À propos</h2>
                    <p>Sportify est une plateforme de consultation sportive qui connecte les passionnés de sport avec les meilleurs professionnels.</p>
                </div>
                <div class="footer-section links">
                    <h2>Liens Utiles</h2>
                    <ul>
                        <li><a href="#">Politique de Confidentialité</a></li>
                        <li><a href="#">Mentions Légales</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; 2024 Sportify | Tous droits réservés
            </div>
        </footer>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchButton = document.getElementById('search-button');
            const mainSection = document.getElementById('main-section');
            const searchSection = document.getElementById('search-section');
            const browseButton = document.getElementById('browse-button');
            const browseDropdown = document.getElementById('browse-dropdown');
            const accountButton = document.getElementById('account-button');
            const accountDropdown = document.getElementById('account-dropdown');

            searchButton.addEventListener('click', function () {
                if (searchSection.style.display === 'none' || searchSection.style.display === '') {
                    mainSection.style.display = 'none';
                    searchSection.style.display = 'flex';
                } else {
                    mainSection.style.display = 'block';
                    searchSection.style.display = 'none';
                }
            });

            browseButton.addEventListener('click', function () {
                if (browseDropdown.style.display === 'none' || browseDropdown.style.display === '') {
                    browseDropdown.style.display = 'block';
                } else {
                    browseDropdown.style.display = 'none';
                }
            });

            accountButton.addEventListener('click', function () {
                if (accountDropdown.style.display === 'none' || accountDropdown.style.display === '') {
                    accountDropdown.style.display = 'block';
                } else {
                    accountDropdown.style.display = 'none';
                }
            });

            // Close the dropdown if the user clicks outside of it
            window.addEventListener('click', function(event) {
                if (!event.target.matches('#browse-button') && !event.target.matches('#account-button')) {
                    if (browseDropdown.style.display === 'block') {
                        browseDropdown.style.display = 'none';
                    }
                    if (accountDropdown.style.display === 'block') {
                        accountDropdown.style.display = 'none';
                    }
                }
            });
        });
    </script>
</body>
</html>
