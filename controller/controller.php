<?php
require_once('model/DAO/joueurDAO.php');
require_once('model/DAO/partieDAO.php');
$joueurDAO = new joueurDAO();
$partieDAO = new partieDAO();

$title = '';
$message_erreur = '';
$message_info = '';
$gagne = false;

if(isset($_POST['btnJouer'])) {
    if($_POST['mise'] < 0) {
        $message_erreur = 'La mise doit être positive';
        $title = 'Jeu de la roulette';
        include('view/header.php');
        include('view/roulette.php');
        include('view/footer.php');
    } else if ($_POST['mise'] == 0) {
        $message_erreur = 'Il faut miser de l\'argent ...';
        $title = 'Jeu de la roulette';
        include('view/header.php');
        include('view/roulette.php');
        include('view/footer.php');
    } else if($_POST['mise'] > $_SESSION['joueur_argent']) {
        $message_erreur = 'On ne mise pas plus que ce qu\'on a ...';
        $title = 'Jeu de la roulette';
        include('view/header.php');
        include('view/roulette.php');
        include('view/footer.php');
    } else if($_POST['numero'] == 0 && !isset($_POST['parite'])) {
        $message_erreur = 'Il faut miser sur quelque chose!';
        $title = 'Jeu de la roulette';
        include('view/header.php');
        include('view/roulette.php');
        include('view/footer.php');
    } else if ($_POST['numero'] == "" && !isset($_POST['parite'])){
        $message_erreur = 'Il faut miser sur quelque chose!';
        $title = 'Jeu de la roulette';
        include('view/header.php');
        include('view/roulette.php');
        include('view/footer.php');
    } else {
        $_SESSION['joueur_argent'] -= $_POST['mise'];
        $gain = 0;
        $numero = rand(1, 36);

        $miseJoueur = intval($_POST['mise']);
        $numeroJoueur = intval($_POST['numero']);
        $message_info = "La bille s'est arrêtée sur le $numero! ";
        if($_POST['numero']!= "") {
            $message_info .= "Vous avez misé sur le ".$numeroJoueur."!";
            if($numeroJoueur == $numero) {
                $message_resultat = "Jackpot! Vous gagnez ". $miseJoueur*35 ."€ !";
                $gagne = true;
                $gain = $miseJoueur*35;
                $_SESSION['joueur_argent'] += $gain;
            } else {
                $message_resultat = "Raté!";
            }
        } else {
            $message_info .= "Vous avez misé sur le fait que le résultat soit ".$_POST['parite'];
            $parite = $numero%2 == 0 ? 'pair' : 'impair';
            if($parite == $_POST['parite']) {
                $message_resultat = "Bien joué! Vous gagnez ". $miseJoueur*2 ."€ !";
                $gagne = true;
                $gain = $miseJoueur*2;
                $_SESSION['joueur_argent'] += $gain;
            } else {
                $message_resultat = "C'est perdu, dommage!";
            }
        }
        $joueurDAO->majUtilisateur($_SESSION['joueur_id'], $_SESSION['joueur_argent']);
        $partieDAO->ajoutePartie($_SESSION['joueur_id'], date('Y-m-d h:i:s'), $_POST['mise'], $gain);
        $title = 'Jeu de la roulette';
        include('view/header.php');
        include('view/roulette.php');
        include('view/footer.php');
    }
} else if(isset($_POST["btnConnexion"])) {
    // Vérifie que les champs existent et ne sont pas vides
    if(isset($_POST['nom']) && $_POST['nom'] != '' && isset($_POST['motdepasse']) && $_POST['motdepasse'] != '') {
        $result = $joueurDAO->connecteUtilisateur($_POST['nom'], $_POST['motdepasse']);
        if($result == "Utilisateur ou mot de passe incorrect") {
            $message_erreur = 'Utilisateur ou mot de passe incorrect';
            $title = 'Connexion';
            include('view/header.php');
            include('view/connexion.php');
            include('view/footer.php');
        } else {
            // Si pas d'erreur, renvoie l'utilisateur vers le jeu de la roulette
            $title = 'Jeu de la roulette';
            include('view/header.php');
            include('view/roulette.php');
            include('view/footer.php');
        }
    } else {
        $message_erreur = 'Il faut remplir les champs!';
        $title = 'Connexion';
        include('view/header.php');
        include('view/connexion.php');
        include('view/footer.php');
    }
} else if(isset($_POST["btnSignup"])) {
    if(isset($_POST['nom']) && $_POST['nom'] != '' && isset($_POST['motdepasse']) && $_POST['motdepasse'] != '') {

        // Appelle des fonctions de BDD_Manager.php pour ajouter l'utilisateur en BDD puis le connecter
        $joueurDAO->ajouteUtilisateur($_POST['nom'], $_POST['motdepasse']);
        $joueurDAO->connecteUtilisateur($_POST['nom'], $_POST['motdepasse']);

        // Renvoie l'utilisateur vers le jeu de la roulette
        $title = 'Jeu de la roulette';
        include('view/header.php');
        include('view/roulette.php');
        include('view/footer.php');
    } else {
        $title = 'Page d\'inscription';
        $message_erreur = 'Il faut remplir les champs!';
        include('view/header.php');
        include('view/inscription.php');
        include('view/footer.php');
    }
} else if (isset($_GET["inscription"])) {
    $title = 'Page d\'inscription';
    include('view/header.php');
    include('view/inscription.php');
    include('view/footer.php');
} else if(isset($_GET["logOut"])) {
    unset($_SESSION['joueur_id']);
    unset($_SESSION['joueur_nom']);
    unset($_SESSION['joueur_argent']);
    $title = 'Connexion';
    include('view/header.php');
    include('view/connexion.php');
    include('view/footer.php');
} else {
    $title = 'Connexion';
    include('view/header.php');
    include('view/connexion.php');
    include('view/footer.php');
}


/*
Ajouter une page de statistiques
Ajouter une page de commentaires (livre d'or)

	- créer les DTO Joueur et Partie
	- créer les DAO Joueur et Partie
	- tester le tout dans l'index
*/