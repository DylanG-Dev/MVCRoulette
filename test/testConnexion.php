<?php
include_once(__DIR__ .'/../model/DAO/connexionMySQL.php');

class testConnexion {
    private $connectBDD;
    public function __construct() {
        $this->connectBDD = new connexionMySQL();
    }

    public function testDatabaseConnection() {
        $bdd = $this->connectBDD->getBdd();

        if ($bdd instanceof PDO) {
            echo "Connexion à la base de donnée réussis.\n";
        } else {
            echo "Connexion à la base de donnée raté.\n";
        }
    }
}
$test = new testConnexion();
$test->testDatabaseConnection();