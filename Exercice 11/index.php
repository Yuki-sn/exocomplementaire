<?php

// Inclusion des dépendances ( pour avoir accès à la fonction dump() )
require '../vendor/autoload.php';

/*
Exercice : Créer une fonction getGoogleLogo() qui téléchargera le logo à l'adresse suivante : " https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png " et le rangera dans un sous dossier "logos/" sous le nom "logo_google.png" (dossier qui devra être créé par la fonction si ce dernier n'existe pas).
*/

// Fonction à créer ici
//-------------------------------------------------------------------------
function getGoogleLogo(){
    $logo = 'logo';

    if (is_dir($logo)) {
        echo 'Le répertoire existe déjà!';  
    }
    else {mkdir($logo);
        echo 'Le répertoire '.$logo.' vient d\'être créé!';     

        $url = 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png';     

        $ch = curl_init($url);     

        $dir = 'logo/';     

        $file_name = basename($url);     

        $save_file_loc = $dir . $file_name;     
    
        $fp = fopen($save_file_loc, 'wb');     

        curl_setopt($ch, CURLOPT_FILE, $fp); 
        curl_setopt($ch, CURLOPT_HEADER, 0);     

        curl_exec($ch);     

        curl_close($ch);     

        fclose($fp); 
    }
};
//-------------------------------------------------------------------------


// Ne doit rien afficher à l'écran, par contre doit avoir créé le sous dossier "logos" s'il n'existe pas déjà, avec un fichier "logo_google.png" à l'intérieure
getGoogleLogo();