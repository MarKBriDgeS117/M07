<?php
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && ($_SERVER['REQUEST_TIME'] - $_SESSION['LAST_ACTIVITY']) > 60) session_unset();
include_once "funcions.php";
if (!isset($_SESSION['Usuari'])) header("Location: index.php?error=nohasiniciatsesio", true, 303);
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Benvingut</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="container noheight" id="container">
        <div class="welcome-container">
            </form>
            <form method="post" id="refrescar">
                <input type="hidden" id="input" name="refrescar" value="refrescar"></input>
            </form>
            <h1>Benvingut!</h1>
            <div>Hola <?php if (isset($_SESSION['Usuari'])) echo $_SESSION['Usuari']; ?>, les teves darreres connexions són:
                <?php if (isset($_SESSION['Correu'])) {
                    $Connexions = llegeix("connexions.json");
                    echo "<br/>";
                    foreach ($Connexions as $key => $connexio) {
                        if ($connexio['user'] == $_SESSION['Correu'] && ($connexio['status'] == 'signin_success' || $connexio['status'] == "signup_success")) {
                            echo ($connexio['ip'] . " | " . $connexio['time'] . " | " . $connexio['status']);
                            echo "<br/>";
                        }
                    }
                }
                ?>
            </div>
            <form action="process.php" method="post">
                <button type="submit">Tanca la sessió</button>
            </form>
        </div>
    </div>
</body>

</html>