<?php session_start();
include_once "database.php";
include_once "funcions.php";
posarData();
$Fase = Fase::faseConcurs($_SESSION['Data']);
$Gossos =  començament($Fase);
if ($Fase != null) {
    if (!llegeixVotsSessio(session_id(), $Fase->getNum())) {
        unset($_SESSION['VotId']);
        unset($_SESSION['VotNom']);
    }
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votació popular Concurs Internacional de Gossos d'Atura 2023</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">
        <?php
        if ($Fase != null) {
            echo "<header>Votació popular del Concurs Internacional de Gossos d'Atura 2023- FASE <span>" . $Fase->getNum() . "</span></header>";
            echo "<p class='info'> Podeu votar fins el dia " . $Fase->getDataFinal() . "</p>";
        } else {
            echo "<header>Votació popular del Concurs Internacional de Gossos d'Atura 2023 <span></span></header>";
            echo "<p class='info'> No hi ha cap fase activa </p>";
        }
        ?>

        <?php
        if (isset($_SESSION['VotNom'])) {;
            echo '<p class="warning"> Ja has votat al gos ' . $_SESSION['VotNom'] . ' Es modificarà la teva resposta</p>';
        }
        ?>

        <div class="poll-area">
            <form action="process.php" method="post" id="form">
                <?php
                if ($Gossos != null) {
                    foreach ($Gossos  as $key => $value) {
                        echo '<label for="opt-' . $key . '" class="opt-' . $key . '">';
                        echo '<div class="row">';
                        echo '<div class="column">';
                        echo '<div class="right">';
                        echo '<input type="hidden" name="FaseVot" value=' . $Fase->getNum() . ' />';
                        echo '<input type="radio" value="' . $value->getId() . '" name="poll" id="opt-' . $key . '" onclick="onlyOne(this)">';
                        echo '<span class="text">' . $value->getNom() . '</span>';
                        echo '</div>';
                        echo '<img class="dog" alt="Musclo" src="' . $value->getImatge() . '">';
                        echo '</div>';
                        echo '</div>';
                        echo '</label>';
                    }
                }
                ?>
            </form>
        </div>
        <p> Mostra els <a href="resultats.php">resultats</a> de les fases anteriors.</p>
    </div>
    <script>
        function onlyOne(checkbox) {
            var checkboxes = document.getElementsByName('poll');
            let form = document.getElementById("form");
            form.submit();
            checkboxes.forEach((item) => {
                if (item !== checkbox) item.checked = false
            })
        }
    </script>
</body>

</html>