<?php
session_start();
require_once('connexionMySQL.php');
include(__DIR__ . '/../DTO/joueur.php');
class joueurDAO extends connexionMySQL {
    public function __construct() {
        parent::__construct();
    }
    public function connecteUtilisateur($utilisateur, $motdepasse) {
        $res = '';
        $bdd = $this->getBdd();
        if ($bdd) {
            $sql = 'SELECT * FROM roulette_joueur WHERE nom = ?';
            $result = $bdd->prepare($sql);
            $result->execute([$utilisateur]);

            $data = $result->fetch();
            if ($data) {
                if (password_verify($motdepasse, $data['motdepasse'])) {
                    $_SESSION['joueur_id'] = intval($data['identifiant']);
                    $_SESSION['joueur_nom'] = $data['nom'];
                    $_SESSION['joueur_argent'] = intval($data['argent']);
                } else {
                    $res = "Utilisateur ou mot de passe incorrect";
                }
            } else {
                $res = "Utilisateur ou mot de passe incorrect";
            }
        }
        return $res;
    }

    public function ajouteUtilisateur($nom, $motdepasse) {
        $bdd = $this->getBdd();
        if ($bdd) {
            $hashedPassword = password_hash($motdepasse, PASSWORD_DEFAULT);

            $query = $bdd->prepare('INSERT INTO roulette_joueur (nom, motdepasse, argent) VALUES (:t_nom, :t_mdp, 500);');
            $query->execute(array(
                't_nom' => $nom,
                't_mdp' => $hashedPassword
            ));
        }
    }

    public function majUtilisateur($id_joueur, $argent) {
        $bdd = $this->getBdd();
        if ($bdd) {
            $query = $bdd->prepare('UPDATE roulette_joueur SET argent = :t_argent WHERE identifiant = :t_id;');
            $query->execute(array('t_argent' => $argent, 't_id' => $id_joueur));
        }
    }
}