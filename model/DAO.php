<?php
session_start();
include('joueur.php');

class DAO {
    private ?pdo $bdd;
    public function __construct() {
        $this->bdd = null;
        try {
            $this->bdd = new PDO('mysql:host=localhost;dbname=roulette_cybersecu;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur connexion BDD : ' .$e->getMessage());
        }
        return $this->bdd;
    }

    public function getBdd(): ?PDO {
        return $this->bdd;
    }

    public function connecteUtilisateur($utilisateur, $motdepasse) {
        $res = '';
        if ($this->bdd) {
            $sql = 'SELECT * FROM roulette_joueur WHERE nom = ? AND motdepasse = ?';
            $result = $this->bdd->prepare($sql);
            $result->execute( [$utilisateur, $motdepasse] );


            $data = $result->fetch();
            if($data) {
                $_SESSION['joueur_id'] = intval($data['identifiant']);
                $_SESSION['joueur_nom'] = $data['nom'];
                $_SESSION['joueur_argent'] = intval($data['argent']);
            } else {
                $res = "Utilisateur ou mot de passe incorrect";
            }
        }
        return $res;
    }

        public function ajouteUtilisateur($nom, $motdepasse) {
        if ($this->bdd) {
            // Hash the password before saving it
            $hashedPassword = password_hash($motdepasse, PASSWORD_DEFAULT);

            $query = $this->bdd->prepare('INSERT INTO roulette_joueur (nom, motdepasse, argent) VALUES (:t_nom, :t_mdp, 500);');
            $query->execute(array(
                't_nom' => $nom,
                //'t_mdp' => password_hash($motdepasse, PASSWORD_DEFAULT)
                't_mdp' => $motdepasse
            ));
        }
    }

    public function ajoutePartie($id_joueur, $date, $mise, $gain) {
        if ($this->bdd) {
            $query = $this->bdd->prepare('INSERT INTO roulette_partie (joueur, date, mise, gain) VALUES (:t_id, :t_date, :t_mise, :t_gain);');
            $query->execute(array('t_id' => $id_joueur, 't_date' => $date, 't_mise' => $mise, 't_gain' => $gain));
        }
    }

    public function majUtilisateur($id_joueur, $argent) {
        if ($this->bdd) {
            $query = $this->bdd->prepare('UPDATE roulette_joueur SET argent = :t_argent WHERE identifiant = :t_id;');
            $query->execute(array('t_argent' => $argent, 't_id' => $id_joueur));
        }
    }
}
?>