<?php

$array = array(1, 2, 3, 4, 5);

print_r(factorialArray($array));

function factorialArray(array $array){

    foreach ($array as  $valor) {
        if (!is_numeric($valor)) {
            return false;
        }
    }
    
    $arrayFactorials = array_map('factorial', $array);

    return $arrayFactorials;
}

function factorial(int $numero) { 

    if ($numero < 2) { 
        return 1; 
    } else { 
        return ($numero * factorial($numero-1)); 
    } 
}
?>