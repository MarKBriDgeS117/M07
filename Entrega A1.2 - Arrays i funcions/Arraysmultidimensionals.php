<?php
$array = array(1, 2, 3, 4, 5);

print_r(factorialArray($array));

$arrayMatriu = creaMatriu(3);

echo mostrarMatriu($arrayMatriu);

echo mostrarMatriu(transposarMatriu($arrayMatriu));

/**
 *  funció  que li passes un array de nombres i retorna un altre array amb el factorial de cada nombre. 
 *
 * @param array $arrayNombres És el array de nombres que volem convertir a factorial.
 * @return array $arrayFactorials Retorna l'array amb la matriu creada  
 */ 
function factorialArray(array $arrayNombres){
    
    if (!is_array($arrayNombres)) {
        return false;
    }else{
    foreach ($arrayNombres as  $valor) {
        if (!is_numeric($valor)) {
            return false;
        }
    }
    
    $arrayFactorials = array_map('factorial', $arrayNombres);

    return $arrayFactorials;
}
}

/**
 * funció la cual li passem un nombre i fa el factorial.
 *
 * @param integer $numero És el nombre que volem convertir a factorial.
 * @return integer $arrayMatriu Retrona el factorial del numero.
 */ 
function factorial(int $numero) { 

    if ($numero < 2) { 
        return 1; 
    } else { 
        return ($numero * factorial($numero-1)); 
    } 
}


/**
 * funció creaMatriu que genera una matriu quadrada.
 *
 * @param integer $n És el nombre de files i de columnes el qual utilitzarem per crear la matriu.
 * @return array $arrayMatriu Retorna l'array amb la matriu creada  
 */ 
function creaMatriu(int $n)
{

    for ($Columnes = 0; $Columnes <= $n; $Columnes++) {

        for ($Files = 0; $Files <= $n; $Files++) {

            if ($Columnes == $Files) {

                $arrayMatriu[$Columnes][$Files] = '*';

            } elseif ($Columnes > $Files) {

                $arrayMatriu[$Columnes][$Files] = rand(10, 20);

            } else {

                $arrayMatriu[$Columnes][$Files] = $Columnes + $Files;
            }
        }
    }

    return $arrayMatriu;
}



/**
 * funció que retorna la matriu en forma de taula HTML. 
 *
 * @param array $arrayMatriu És la matriu que volem mostrar en forma de taula HTML.
 * @return string $arrayMatriu Retorna l'string amb la matriu en forma de taula HTML. 
 */ 
function mostrarMatriu(array $arrayMatriu)
{
    $taulaMatriuHtml = '<table>';

    foreach ($arrayMatriu as $Columnes) {

        $taulaMatriuHtml =  $taulaMatriuHtml . '<tr>';

        foreach ($Columnes as $Files) {

            $taulaMatriuHtml = $taulaMatriuHtml . '<td>' .  $Files . '</td>';

        }

        $taulaMatriuHtml = $taulaMatriuHtml . '</tr>';
    }

    $taulaMatriuHtml = $taulaMatriuHtml . '</table>';

    return $taulaMatriuHtml;
}
/**
 * funció que rep una matriu i retorna una altra matriu amb el valor de les files per les columnes intercanviats.
 *
 * @param array $arrayMatriu És la matriu que volem intercanviar el valor de les files per les columnes.
 * @return array $arrayMatriuTransposat Retorna la matriu amb el valor de les files per les columnes intercanviats.
 */ 
function transposarMatriu(array $arrayMatriu)
{

    foreach ($arrayMatriu as $Columnes => $ArrayColumnes) {

        foreach ($ArrayColumnes as $Files => $value) {

            $arrayMatriuTransposat[$Files][$Columnes] = $arrayMatriu[$Columnes][$Files];
        }
    }

    return $arrayMatriuTransposat;
}
