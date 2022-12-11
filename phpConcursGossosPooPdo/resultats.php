<?php session_start();
include_once "database.php";
include_once "funcions.php";
posarData();
$Fases = Fase::llegeixFasesSuperades($_SESSION['Data']);
$Fase = Fase::FaseConcurs($_SESSION['Data']);
Començament($Fase);
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultat votació popular Concurs Internacional de Gossos d'Atura</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper large">
        <header>Resultat de la votació popular del Concurs Internacional de Gossos d'Atura 2023</header>
        <div class="results">
            <?php
            foreach ($Fases  as $key => $value) {
                echo ' <h1> Resultat fase ' . $value->getNum() . ' </h1>';
                $Gosos = Gos::llegeixGossosFase($value->getNum());
                $TotalVots = array_sum(array_column($Gosos, 'vots'));
                
                foreach ($Gosos as $key => $value) {
                    if ($value->getVots() > 0) {
                        echo ' <img class="dog '.$value->getEliminat().'" alt="' . $value->getNom() . '" title="' . $value->getNom() . ' ' . $percent = round($value->getVots()/$TotalVots*100) . '%" src="' . $value->getImatge() . '">';
                    }else{
                        echo ' <img class="dog '.$value->getEliminat().'" alt="' . $value->getNom() . '" title="' . $value->getNom() . ' ' . 0 . '%" src="' . $value->getImatge() . '">';
                    }
                    
                }
            }
            ?>

        </div>

    </div>

</body>

</html>