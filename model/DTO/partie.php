<?php

class partie {
    private int $identifiant;
    private string $joueur;
    private DateTime $date;
    private int $mise;
    private int $gain;

    public function __construct(int $i, string $j, int $m, int $g) {
        $this->identifiant = $i;
        $this->joueur = $j;
        $this->date = new DateTime();;
        $this->mise = $m;
        $this->gain = $g;
    }

    public function __set($attr, $value) {
        switch ($attr) {
            case 'identifiant':
                $this->identifiant = $value;
                break;
            case 'joueur':
                $this->joueur = $value;
                break;
            case 'date':
                $this->date = $value instanceof DateTime ? $value : new DateTime($value);
                break;
            case 'mise':
                $this->mise = $value;
                break;
            case 'gain':
                $this->gain = $value;
                break;
            default:
                echo 'ERROR: Invalid property';
                break;
        }
    }

    public function __get($attr) {
        switch ($attr) {
            case 'identifiant':
                return $this->identifiant;
            case 'joueur':
                return $this->joueur;
            case 'date':
                return $this->date;
            case 'mise':
                return $this->mise;
            case 'gain':
                return $this->gain;
            default:
                echo 'ERROR: Invalid property';
                return null;
        }
    }
}