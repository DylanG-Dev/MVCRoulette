<?php
include_once(__DIR__ . '/../model/DAO/partieDAO.php');
class testPartie {
    private $connectBDD;
    private $partieDAO;
    public function __construct() {
        $this->connectBDD = new ConnexionMySQL();
        $this->partieDAO = new PartieDAO($this->connectBDD);
    }
    public function testAjoutePartie() {
        $id_joueur = 1;
        $date = '2022-06-19';
        $mise = 100;
        $gain = 50;

        echo "Test d'ajout de partie\n";
        $this->partieDAO->ajoutePartie($id_joueur, $date, $mise, $gain);
        $sql = "SELECT * FROM roulette_partie WHERE joueur = :joueur AND date = :date";
        $stmt = $this->connectBDD->getBdd()->prepare($sql);
        $stmt->execute(['joueur' => $id_joueur, 'date' => $date]);
        $data = $stmt->fetch();

        if (!empty($data) && $data['mise'] == $mise && $data['gain'] == $gain) {
            echo "Ajout de la partie réussis.\n";
        } else {
            echo "Ajout de la partie raté.\n";
        }
    }
}
$test = new testPartie();
$test->testAjoutePartie();