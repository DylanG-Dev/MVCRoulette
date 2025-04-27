<?php
include_once(__DIR__ . '/../model/DAO/joueurDAO.php');

class testJoueur {
    private $joueurDAO;
    private $connectBDD;

    public function __construct() {
        $this->connectBDD = new ConnexionMySQL();
        $this->joueurDAO = new JoueurDAO($this->connectBDD);
    }
    public function testConnecteUtilisateurRate() {
        $utilisateur = 'incorrectUtilisateur';
        $motdepasse = 'motDePasseNonExistant';

        echo "Test de connexion avec des identifiants non existants dans la base de données\n";
        $result = $this->joueurDAO->connecteUtilisateur($utilisateur, $motdepasse);
        if ($result === 'Utilisateur ou mot de passe incorrect') {
            echo "Test réussis, connexion échouée.\n";
        } else {
            echo "Test raté, il y a une erreur\n";
        }
    }

    public function testAjouteUtilisateur() {
        $nom = 'test';
        $motdepasse = 'test';

        echo "Test de la création d'un utilisateur\n";
        $this->joueurDAO->ajouteUtilisateur($nom, $motdepasse);

        $sql = "SELECT * FROM roulette_joueur WHERE nom = :nom";
        $stmt = $this->connectBDD->getBdd()->prepare($sql);
        $stmt->execute(['nom' => $nom]);
        $data = $stmt->fetch();

        if (!empty($data) && $data['nom'] === $nom) {
            echo "Test réussi, utilisateur ajouté\n";
        } else {
            echo "Test raté, utilisateur non ajouté\n";
        }
    }
    public function testConnecteUtilisateurReussis() {
        $utilisateur = 'test';
        $motdepasse = 'test';

        echo "Test de connexion avec des identifiants existants dans la base de données\n";
        $result = $this->joueurDAO->connecteUtilisateur($utilisateur, $motdepasse);
        if ($result === '') {
            echo "Test réussi, utilisateur connecté.\n";
        } else {
            echo "Test raté, échec de la connexion de l'utilisateur\n";
        }
    }

    public function testMajUtilisateur() {
        $id_joueur = 1;
        $argent = 99;

        echo "Test de mise à jour de l'argent d'un utilisateur\n";
        $this->joueurDAO->majUtilisateur($id_joueur, $argent);

        // Check if the user's amount was updated in the database
        $sql = "SELECT argent FROM roulette_joueur WHERE identifiant = :id_joueur";
        $stmt = $this->connectBDD->getBdd()->prepare($sql);
        $stmt->execute(['id_joueur' => $id_joueur]);
        $data = $stmt->fetch();

        if (!empty($data) && $data['argent'] == $argent) {
            echo "Test réussis, l'argent de l'utilisateur a été mis à jour\n";
        } else {
            echo "Test raté, l'argent de l'utilisateur n'a pas été mis à jour\n";
        }
    }
}

$test = new TestJoueur();
$test->testConnecteUtilisateurRate();
echo "\n";
$test->testAjouteUtilisateur();
echo "\n";
$test->testConnecteUtilisateurReussis();
echo "\n";
$test->testMajUtilisateur();