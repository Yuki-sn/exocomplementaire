<?php

// Inclusion des dépendances ( pour avoir accès à la fonction dump() )
require '../vendor/autoload.php';

/*
Exercice : Créer une fonction getNextYear() qui retourne l'année (sur 4 chiffres) qu'il sera l'année prochaine par rapport à la date actuelle.
*/

// Fonction à créer ici
//-------------------------------------------------------------------------

function getNextYear(){

    $currentTimestamp = time();

    $futurDateTimestamp = $currentTimestamp + (365 * 24 * 60 * 60);

    $nextYear = date('Y-m-d H:i:s', $futurDateTimestamp);
    return $nextYear;
}



//-------------------------------------------------------------------------


// Doit afficher "2021" (si vous faites cet exercice en 2020 évidemment !)
dump( getNextYear() );