<?php
require_once('../model/DAO.php');

class TestDAO extends DAO {
    private DAO $dao;

    public function __construct() {
        $this->dao = new DAO();
    }

    public function testDatabaseConnection() {
        // Access the private $bdd via the getter method
        $bdd = $this->dao->getBdd();

        // Now you can perform assertions or checks on the $bdd object
        if ($bdd instanceof PDO) {
            echo "Success: Database connection established.\n";
        } else {
            echo "Failure: Database connection not established.\n";
        }
    }

    public function testConnecteUtilisateurSuccess() {
        // Simulate a correct login
        $utilisateur = 'login';
        $motdepasse = 'password';  // This should be the password you set in the database

        echo "Testing login with correct credentials...\n";
        $result = $this->dao->connecteUtilisateur($utilisateur, $motdepasse);
        if ($result === '') {
            echo "Success: User logged in.\n";
        } else {
            echo "Failure: $result\n";
        }

        // Now, if you want to interact with the PDO object directly
        $bdd = $this->dao->getBdd(); // Access the private $bdd through the getter
        // You can now interact with the $bdd object, for example:
        $stmt = $bdd->prepare("SELECT * FROM roulette_joueur");
        $stmt->execute();
        $data = $stmt->fetchAll();
        var_dump($data); // Display the data to verify
    }

    public function testConnecteUtilisateurFailure() {
        // Simulate an incorrect login
        $utilisateur = 'incorrectUser';
        $motdepasse = 'wrongPassword';

        echo "Testing login with incorrect credentials...\n";
        $result = $this->dao->connecteUtilisateur($utilisateur, $motdepasse);
        if ($result === 'Utilisateur inconnu ') {
            echo "Success: Correct error message returned.\n";
        } else {
            echo "Failure: Unexpected result.\n";
        }
    }

    public function testAjouteUtilisateur() {
        // Add a new user
        $nom = 'newUser';
        $motdepasse = 'newPassword';

        echo "Testing user creation...\n";
        $this->dao->ajouteUtilisateur($nom, $motdepasse);

        // Check if the user was added by querying the database
        $sql = "SELECT * FROM roulette_joueur WHERE nom = :nom";
        $stmt = $this->dao->getBdd()->prepare($sql);
        $stmt->execute(['nom' => $nom]);
        $data = $stmt->fetch();

        if (!empty($data) && $data['nom'] === $nom) {
            echo "Success: User added.\n";
        } else {
            echo "Failure: User not found.\n";
        }
    }

    public function testAjoutePartie() {
        // Assume you have a valid player ID for this test
        $id_joueur = 1;
        $date = '2025-04-19';
        $mise = 100;
        $gain = 50;

        echo "Testing game record insertion...\n";
        $this->dao->ajoutePartie($id_joueur, $date, $mise, $gain);

        // Check if the game record was inserted correctly
        $sql = "SELECT * FROM roulette_partie WHERE joueur = :joueur AND date = :date";
        $stmt = $this->dao->getBdd()->prepare($sql);
        $stmt->execute(['joueur' => $id_joueur, 'date' => $date]);
        $data = $stmt->fetch();

        if (!empty($data) && $data['mise'] == $mise && $data['gain'] == $gain) {
            echo "Success: Game record inserted.\n";
        } else {
            echo "Failure: Game record not found or incorrect.\n";
        }
    }

    public function testMajUtilisateur() {
        // Assume you have a valid player ID and an initial amount
        $id_joueur = 1;
        $argent = 1000;

        echo "Testing updating user balance...\n";
        $this->dao->majUtilisateur($id_joueur, $argent);

        // Check if the user's amount was updated in the database
        $sql = "SELECT argent FROM roulette_joueur WHERE identifiant = :id_joueur";
        $stmt = $this->dao->getBdd()->prepare($sql);
        $stmt->execute(['id_joueur' => $id_joueur]);
        $data = $stmt->fetch();

        if (!empty($data) && $data['argent'] == $argent) {
            echo "Success: User balance updated.\n";
        } else {
            echo "Failure: User balance not updated.\n";
        }
    }
}

// Create the test instance and run the tests
$test = new TestDAO();
$test->testDatabaseConnection();  // Fixed this line
$test->testConnecteUtilisateurSuccess();
$test->testConnecteUtilisateurFailure();
$test->testAjouteUtilisateur();
$test->testAjoutePartie();
$test->testMajUtilisateur();