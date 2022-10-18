<?php
session_start();

date_default_timezone_set('Europe/Madrid');

if (!isset($_SESSION['Data'])) {
    posarData();
} else {
    $dataAbans = $_SESSION['Data'];
    posarData();
    if (!isset($_SESSION['Paraules']) || $dataAbans != $_SESSION['Data']) $_SESSION['Paraules'] = array();
}
srand($_SESSION['Data']);

if (isset($_GET['neteja'])) $_SESSION['Paraules'] = array();

if (!isset($_SESSION["Lletres"]) || $dataAbans != $_SESSION['Data']) CrearLletres();


/**
 * Funció que verifica que la data té un format correcte.
 * 
 * @param string $formatData És el format en el qual volem la data.
 * @param string $dataEntrant És la data que volem verificar el format.
 * @return bool  Retorna si la data t'he un format correcte.
 * 
 */
function verificarData(string $formatData, string $dataEntrant): bool
{
    $data = date_create_from_format($formatData, $dataEntrant);
    return $data && ($data->format($formatData) === $dataEntrant);
}
/**
 * Funció que agafa la data per paràmetres en cas que sigui vàlida 
 * guarda la data a la sessió en cas contrari posa la d'avui.
 */
function posarData()
{
    if (isset($_GET['data']) && !empty($_SESSION['Data'])) {
        $comprovarData = verificarData('Ymd', $_GET['data']);
        if ($comprovarData == true) $_SESSION['Data'] = $_GET['data'];
    } elseif (empty($_SESSION['Data'])) $_SESSION['Data'] = date('Ymd');
}


/**
 * Funció que genera l'hexàgon comprovant que tinguin un mínim de 10 respostes possibles, 
 * guarda les lletres i les solucions a la Sessió.
 */
function CrearLletres()
{
    $numeroSolucions = 0;
    $arrayFuncions = CrearArray(get_defined_functions()['internal']);
    sort($arrayFuncions);
    while ($numeroSolucions < 10) {
        $numeroSolucions = 0;
        $arraySolucions = [];
        $lletraMig = randLetter();
        $lletres = randLetter() . randLetter() . randLetter() . $lletraMig . randLetter() . randLetter() . randLetter();

        foreach ($arrayFuncions as $key => $funcio) {
            if (preg_match('/^[' . $lletres . ']+$/', ($funcio)) && preg_match('/' . $lletraMig . '/', ($funcio))) {
                array_push($arraySolucions, $funcio . " ");
                $numeroSolucions++;
            }
        }
        if ($numeroSolucions >= 9) {
            $_SESSION["Solucions"] = $arraySolucions;
            $_SESSION["Lletres"] = str_split($lletres);
        }
    }
}
/**
 * Funció que recorre tot l'array de funcions i comprova que tinguin menos de 7 caràcters diferents i que no tingui números. 
 * Les funcions que compleixen els requisits les guarda en un nou array. 
 *
 * @param array $arrayFuncions És l'array que conte totes les funcions.
 * @return array $arrayFuncionsNou Retorna l'array nou que hem creat.
 *  
 */
function CrearArray(array $arrayFuncions): array
{
    $arrayFuncionsNou = [];
    foreach ($arrayFuncions as $key => $funcio) {

        if (count(array_unique(str_split($funcio))) <= 7 && preg_match('/^([^0-9]*)$/', ($funcio))) {

            array_push($arrayFuncionsNou, $funcio);
        }
    }
    return $arrayFuncionsNou;
}
/**
 * Funció que genera una lletra aleatòria entra la a fins a la z mes la barra baixa.
 *
 * @return string $rand_letter Retorna una lletra de la a fins a la z mes la barra baixa.
 *  
 */
function randLetter(): string
{
    $int = rand(0, 26);
    $a_z = "abcdefghijklmnopqrstuvwxyz_";
    $rand_letter = $a_z[$int];
    return $rand_letter;
}
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <title>PHPògic</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Juga al PHPògic.">
    <link href="//fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body data-joc="2022-10-07">
    <form action="process.php" method="post">
        <div class="main">
            <h1>
                <a href=""><img src="logo.png" height="54" class="logo" alt="PHPlògic"></a>
                <br>
                <?php
                if (isset($_GET['sol']) && isset($_SESSION['Lletres'])) {
                    $Solucions = implode($_SESSION['Solucions']);
                    echo "Solucions:" . $Solucions;
                }
                ?>
            </h1>
            <div class="container-notifications">
            <?php
                if(isset($_GET['error'])) {
                    
                    $error = $_GET['error'];
                
                    switch ($error) {
                        case "jahies":
                            echo '<p class="hide" id="message">'. $_GET['paraula'].'</p>';
                            break;
                        case "Noesunafuncio":
                            echo '<p class="hide" id="message">La paraula no és una funció de PHP.</p>';
                            break;                        
                        case "faltalalletradelmig":
                            echo '<p class="hide" id="message">Falta la lletra del mig.</p>';
                            break;
                    }
                }
            ?>
            </div>
            <div class="cursor-container">
                <p id="input-word"><span id="test-word"></span><span id="cursor">|</span></p>
                <input type="hidden" id="input" name="resultat"> </input>
            </div>
            <div class="container-hexgrid">
                <ul id="hex-grid">
                    <?php
                    foreach ($_SESSION["Lletres"]  as $key => $value) {
                        echo "<li class='hex'>";
                        if ($key == 3) echo '<div class="hex-in"><a class="hex-link" id="center-letter" data-lletra="' . $value . '"><p>' . $value . '</p></a></div>';
                        else echo '<div class="hex-in"><a class="hex-link" data-lletra="' . $value . '"><p>' . $value . '</p></a></div>';
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>

            <div class="button-container">
                <button id="delete-button" type="button" title="Suprimeix l'última lletra" onclick="suprimeix()"> Suprimeix</button>
                <button id="shuffle-button" type="button" class="icon" aria-label="Barreja les lletres" title="Barreja les lletres">
                    <svg width="16" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M370.72 133.28C339.458 104.008 298.888 87.962 255.848 88c-77.458.068-144.328 53.178-162.791 126.85-1.344 5.363-6.122 9.15-11.651 9.15H24.103c-7.498 0-13.194-6.807-11.807-14.176C33.933 94.924 134.813 8 256 8c66.448 0 126.791 26.136 171.315 68.685L463.03 40.97C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.749zM32 296h134.059c21.382 0 32.09 25.851 16.971 40.971l-41.75 41.75c31.262 29.273 71.835 45.319 114.876 45.28 77.418-.07 144.315-53.144 162.787-126.849 1.344-5.363 6.122-9.15 11.651-9.15h57.304c7.498 0 13.194 6.807 11.807 14.176C478.067 417.076 377.187 504 256 504c-66.448 0-126.791-26.136-171.315-68.685L48.97 471.03C33.851 486.149 8 475.441 8 454.059V320c0-13.255 10.745-24 24-24z"></path>
                    </svg>
                </button>
                <button id="submit-button" type="submit" title="Introdueix la paraula">Introdueix</button>
            </div>
    </form>
    <div class="container">
        <form name="calc" class="calculator" action="" method="post">

        </form>
    </div>
    <div class="scoreboard">
        <div>Has trobat
            <span id="letters-found">
                <?php
                if (isset($_SESSION['Paraules'])) echo count($_SESSION['Paraules']);
                else echo "0";
                ?>
            </span>
            <span id="found-suffix">
                <?php
                if (isset($_SESSION['Paraules']) && count($_SESSION['Paraules']) == 1) echo "funció";
                else echo "funcions";
                ?>
            </span>
            <span id="discovered-text">.
                <b>
                    <?php if (isset($_SESSION['Paraules'])) echo implode(" ", $_SESSION['Paraules']); ?>
                </b>
            </span>
        </div>
        <div id="score"></div>
        <div id="level"></div>
    </div>
    </div>
    <script>
        function amagaError() {
            if (document.getElementById("message"))
                document.getElementById("message").style.opacity = "0"
        }

        function afegeixLletra(lletra) {
            document.getElementById("test-word").innerHTML += lletra
            document.getElementById("input").value += lletra
        }

        function suprimeix() {
            document.getElementById("test-word").innerHTML = document.getElementById("test-word").innerHTML.slice(0, -1)
            document.getElementById("input").value = document.getElementById("input").value.slice(0, -1)
        }
        window.onload = () => {
            // Afegeix funcionalitat al click de les lletres
            Array.from(document.getElementsByClassName("hex-link")).forEach((el) => {
                el.onclick = () => {
                    afegeixLletra(el.getAttribute("data-lletra"))
                }
            })
            setTimeout(amagaError, 2000)
            //Anima el cursor
            let estat_cursor = true;
            setInterval(() => {
                document.getElementById("cursor").style.opacity = estat_cursor ? "1" : "0"
                estat_cursor = !estat_cursor
            }, 500)
        }
    </script>
</body>

</html>