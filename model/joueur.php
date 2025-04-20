<?php

class joueur {
    private int $id;
    private string $nom;
    private string $motdepasse;
    private int $argent;

    public function __construct(int $i, string $n, string $m, string $a) {
        $this->id = $i;
        $this->nom = $n;
        $this->motdepasse = $m;
        $this->argent = $a;
    }

    public function __set($attr, $value) {
        switch($attr) {
            case 'id':
                $this->id = $value;
                break;
            case 'username':
                $this->nom = $value;
                break;
            case 'content':
                $this->motdepasse = $value;
                break;
            case 'posted_at':
                $this->argent = $value;
                break;
            default:
                echo 'ERROR';
                break;
        }
    }

    public function __get($attr) {
        switch($attr) {
            case 'id':
                return id;
                break;
            case 'username':
                return nom;
                break;
            case 'content':
                return motdepasse;
                break;
            case 'posted_at':
                return argent;
                break;
            default:
                echo 'ERROR';
                break;
        }
    }

}