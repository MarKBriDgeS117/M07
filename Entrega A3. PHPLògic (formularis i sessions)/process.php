<?php

session_start();


$rebo_dades = ($_SERVER['REQUEST_METHOD'] == 'POST');

$dades_ok =   $rebo_dades &&

    isset($_REQUEST['resultat']);

if ($rebo_dades) {
    if ($dades_ok && !$_REQUEST['resultat'] == "") {
        $paraulaEntrada = $_REQUEST['resultat'];
        header("Location: index.php", true, 302);
        CompravarParaula($paraulaEntrada);
        die();
    } else {
        header("Location: index.php", true, 303);
        die();
    }
}
/**
 * Funció que comprova la paraula que ha entrat l'usuari sigui correcta en cas contrari retorna l'error corresponent.
 * 
 * @param string $paraulaEntrada És la paraula que entra l'usuari.
 * 
 */
function CompravarParaula($paraulaEntrada)
{
    if (!isset($_SESSION['Paraules'])) {
        $_SESSION["Paraules"]= [];
    }
    
    if (in_array($paraulaEntrada,  explode(' ', implode($_SESSION['Solucions'])))) {
        
        if (!in_array($paraulaEntrada, $_SESSION['Paraules'])) {
            $_SESSION["Paraules"][] =  $paraulaEntrada;
        }else {
            header("Location: index.php?error=jahies&paraula=$paraulaEntrada", true, 303);
            die();
        }
        
    }else if (!preg_match('/' . $_SESSION['Lletres'][3] . '/', ($paraulaEntrada))  ) {
        header("Location: index.php?error=faltalalletradelmig", true, 303);
            die();
    }else {
        header("Location: index.php?error=Noesunafuncio", true, 303);
            die();
    }
}

?>