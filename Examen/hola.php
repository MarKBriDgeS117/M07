<?php 
session_start();

if (!isset($_SESSION['Usuari'])) {
    header("Location: index.php?error=lasesiohacaducat", true, 303);
    die();

}else {
    if (isset($_POST["refrescar"])) {
        $_SESSION['Usuari']= null;
        header("Location: process.php?error=satancatlasesio", true, 303);
        die();
    }
}
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
        <div>Hola  <?php if (isset($_SESSION['Usuari'])) echo $_SESSION['Usuari'] ; ?>, les teves darreres connexions són:</div>
        <form action="#">
            <button type="submit" form="refrescar">Tanca la sessió</button>
        </form>
    </div>
</div>
</body>
</html>