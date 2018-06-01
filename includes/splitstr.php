<?php

function splitStr($str) {

// si le string est composé de plus de 15 caractère et secable avec des espaces
if (strlen($str) > 15 && sizeof(explode(" ", $str)) > 1) {

    $string = explode(" ", $str); // séparation de $str avec des espaces 
    $final = array(); // tableau final
    $result = "["; // resultat en string model JSON

    for ($key = 0; $key < sizeof($string); $key++) {
    
        // si ce mot et le mot d'apres reunis font moins de 15 caractere de long
        if ((strlen($string[$key]) + strlen($string[$key + 1])) < 15) {
    
            $final[] = $string[$key] . " " . $string[$key + 1];
            $key++;
            continue;
            
        // sinon, si le mot fait plus de 15 caractere
        } elseif (strlen($string[$key]) > 15) {
    
            // on le coupe
            $final[] = substr($string[$key], 0, 14) . "-";
            $string[$key] = substr($string[$key], 14);
            $key--;
            continue;

        }

        // on ajoute le mot au tableau final
        $final[] = $string[$key];
    
    }


    // creation du resulat
    foreach ($final as $key => $value) {
    
        if ($key != 0) $result .= ",";
        $result .= "\"" . $value . "\"";
    
    }
    
    return $result . "]";

// sinon, si le mot n'est pas secable avec des espace, on le coupe en plein milieu
} elseif (strlen($str) > 15) {

    // on retourne le resultat
    return "[\"" . substr($str, 0, 14) . "-\",\"" . substr($str, 14) . "\"]";

}

// sinon le string fait moins de 15 caractère on peu le retourner
return "\"" . $str . "\"";

}