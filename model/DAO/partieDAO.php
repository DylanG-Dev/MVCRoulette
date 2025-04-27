<?php
require_once('connexionMySQL.php');
include(__DIR__ . '/../DTO/partie.php');
class partieDAO extends connexionMySQL {
    public function __construct() {
        parent::__construct();
    }
    public function ajoutePartie($id_joueur, $date, $mise, $gain) {
        $bdd = $this->getBdd();
        if ($bdd) {
            $query = $bdd->prepare('INSERT INTO roulette_partie (joueur, date, mise, gain) VALUES (:t_id, :t_date, :t_mise, :t_gain);');
            $query->execute(array('t_id' => $id_joueur, 't_date' => $date, 't_mise' => $mise, 't_gain' => $gain));
        }
    }
}