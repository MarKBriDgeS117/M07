<?php session_start();
if (!isset($_SESSION['Usuari'])) header("Location: login.php?error=nohasiniciatsesio", true, 303);
include_once "database.php";
include_once "funcions.php";
posarData();
$Fases = Fase::llegeixFases();
$gossos = Gos::llegeixGossos();
$Fase = Fase::faseConcurs($_SESSION['Data']);
començament($Fase);
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN - Concurs Internacional de Gossos d'Atura</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper medium">
        <header>ADMINISTRADOR - Concurs Internacional de Gossos d'Atura</header>
        <div class="admin">
            <div class="admin-row">
                <div class="gossos">
                    <?php
                    if ($Fase != null) {
                        echo ' <h1> Resultat fase ' . $Fase->getNum() . ' </h1>';
                        $Gosos = Gos::llegeixGossosFase($Fase->getNum());
                        $TotalVots = array_sum(array_column($Gosos, 'vots'));
                        foreach ($Gosos as $key => $value) {
                            if ($value->getVots() > 0) {
                                echo ' <img class="dog ' . $value->getEliminat() . '" alt="' . $value->getNom() . '" title="' . $value->getNom() . ' ' . $percent = round($value->getVots() / $TotalVots * 100) . '%" src="' . $value->getImatge() . '">';
                            } else {
                                echo ' <img class="dog ' . $value->getEliminat() . '" alt="' . $value->getNom() . '" title="' . $value->getNom() . ' ' . 0 . '%" src="' . $value->getImatge() . '">';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="admin-row">
                <h1> Nou usuari: </h1>
                <form action="process.php" method="post">
                    <input type="hidden" name="method" value="signup" />
                    <input type="text" name="email" placeholder="Nom">
                    <input type="password" name="password" placeholder="Contrassenya">
                    <input type="submit" value="Crea usuari">
                </form>
            </div>
            <div class="container-notifications">
                <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    switch ($error) {
                        case "Jaestasregistrat":
                            echo '<p class="hide message">Ja estas registrat.</p>';
                            break;
                        case "nohasemplenatelscamps":
                            echo '<p class="hide message">No has emplenat tots els camps.</p>';
                            break;
                    }
                }
                ?>
            </div>
            <div class="admin-row">
                <h1> Fases: </h1>
                <?php
                foreach ($Fases  as $key => $value) {
                    echo '<form class="fase-row" action="process.php" method="post">';
                    echo '<input type="hidden" name="ModificarData" value="ModificarData" />';
                    echo '<input type="hidden" name = "Fase" value=' . $value->getNum() . ' style="width: 3em">';
                    echo 'Fase <input type="text" value=' . $value->getNum() . ' disabled style="width: 3em">';
                    echo 'del <input type="date" name = "DataInici" value=' . $value->getDataInici() . ' placeholder="Inici">';
                    echo 'al <input type="date" name = "DataFinal"value=' . $value->getDataFinal() . ' placeholder="Fi">';
                    echo '<input type="submit" value="Modifica">';
                    echo '</form>';
                }

                ?>
            </div>
            <div class="container-notifications">
                <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    switch ($error) {
                        case "nopotspossarunafasesobreunalaltre":
                            echo '<p class="hide message">No pots posar una fase sobre una altre.</p>';
                            break;
                        case "nohasemplenatunadata":
                            echo '<p class="hide message">No has posat una data.</p>';
                            break;
                    }
                }
                ?>
            </div>
            <div class="admin-row">
                <h1> Concursants: </h1>
                <?php
                foreach ($gossos  as $key => $value) {
                    echo '<form action="process.php" method="post">';
                    echo '<input type="hidden" name="ModificarGos" value="ModificarGos" />';
                    echo '<input type="hidden" name="IdGos" placeholder="Id" value=' . $value->getId() . '>';
                    echo '<input type="text" name="NomGos" placeholder="Nom" value=' . $value->getNom() . '>';
                    echo '<input type="text" name="ImatgeGos" placeholder="Imatge" value=' . $value->getImatge() . '>';
                    echo '<input type="text" name="AmoGos" placeholder="Amo" value=' . $value->getAmo() . '>';
                    echo '<input type="text" name="RaçaGos" placeholder="Raça" value=' . $value->getRaza() . '>';
                    echo '<input type="submit" value="Modifica">';
                    echo '</form>';
                }
                ?>
                <br>
                <div class="container-notifications">
                    <?php
                    if (isset($_GET['error'])) {
                        $error = $_GET['error'];
                        switch ($error) {
                            case "nohasemplenatelscampsmodificargos":
                                echo '<p class="hide message">No has emplenat tots els camps.</p>';
                                break;
                        }
                    }
                    ?>
                </div>
                <br>
                <div class="margin">
                    <form action="process.php" method="post">
                        <input type="hidden" name="AfegirGos" value="AfegirGos" />
                        <?php echo '<input type="hidden" name="numGossos" value=' . count($gossos) . ' />';       ?>
                        <input type="text" name="NomGos" placeholder="Nom">
                        <input type="text" name="ImatgeGos" placeholder="Imatge">
                        <input type="text" name="AmoGos" placeholder="Amo">
                        <input type="text" name="RaçaGos" placeholder="Raça">
                        <input type="submit" value="Afegir">
                    </form>
                </div>
                <div class="container-notifications">
                    <?php
                    if (isset($_GET['error'])) {
                        $error = $_GET['error'];
                        switch ($error) {
                            case "nohasemplenatelscampsafegirgos":
                                echo '<p class="hide message">No has emplenat tots els camps.</p>';
                                break;
                            case "jahihaelmaximdegossos":
                                echo '<p class="hide message">Ja hi ha el màxim de Gossos Inscrits.</p>';
                                break;
                        }
                    }
                    ?>
                </div>
                <div class="admin-row">
                    <h1> Altres operacions: </h1>
                    <form action="process.php" method="post">
                        Esborra els vots de la fase
                        <input type="number" name="BorrarVotsFase" placeholder="Fase" value="">
                        <input type="submit" value="Esborra">
                    </form>
                    <form action="process.php" method="post">
                        Esborra tots els vots
                        <input type="submit" name="BorrarVots" value="Esborra">
                    </form>
                </div>
            </div>
        </div>

</body>

</html>