<?php
session_start();

include_once "funcions.php";

$rebo_dades = ($_SERVER['REQUEST_METHOD'] == 'POST');

$dades_ok = $rebo_dades && isset($_POST['method']);

if ($rebo_dades) {
    if ($dades_ok && !$_POST['method'] == "") {
        $Usuaris = llegeix($_POST['email']);
        if ($_POST['method'] == "signup") registrarUsuari($Usuaris);
        elseif ($_POST['method'] == "signin") iniciarSessio($Usuaris);
    } else {
        registrarStatus("logoff",$_SESSION['Correu']);
        header("Location: index.php", true, 303);
        session_unset();
    }
} else header("Location: index.php", true, 303);

/**
 * Funció iniciarSesio serveix per verificar si l'usuari que ha iniciat la sessió està registrat o si l'ha contrasenya 
 * es correcta. En cas que estigui registrat et portarà a hola.php. En cas contrari et portarà a index.php amb l'error 
 * corresponent.
 *
 * @param mixed $Usuaris Es les dades de l'usuari en un array o si no el troba es null.
 */
function iniciarSessio(mixed $Usuaris)
{
    if ($Usuaris != null) {
        if ($Usuaris['password'] == md5($_POST['password'])) {
            guardarDadesSesio($Usuaris["name"],$_POST['email'],$_SERVER['REQUEST_TIME']);
            registrarStatus("signin_success",$_SESSION['Correu']);
            header("Location: hola.php", true, 302);
        } else {
            registrarStatus("signin_password_error",$_POST['email']);
            header("Location: index.php?error=passwordIncorrecta", true, 303);
        }
    } else {
        registrarStatus("signin_email_error",$_POST['email']);
        header("Location: index.php?error=noestasregistrat", true, 303);
    }
}

/**
 * Funcio per registrar un usuari. Si es registra correctament et portarà a hola.php. 
 * En cas contrari et portarà a index.php amb l'error corresponent.
 *
 * @param mixed $Usuaris Es les dades de l'usuari en un array o si no el troba es null.
 */
function registrarUsuari(mixed $Usuaris)
{
    if ($Usuaris != null) {
        header("Location: index.php?error=Jaestasregistrat", true, 303);
    } else {
        if ($_POST['email'] != "" && $_POST['password'] != "" && $_POST['Nom'] != "") {
            $Usuari =  array('email' => $_POST['email'], 'password' => $_POST['password'], 'name' => $_POST['Nom']);
            insereixUsuari($Usuari);
            guardarDadesSesio($_POST['Nom'],$_POST['email'],$_SERVER['REQUEST_TIME']);
            registrarStatus("signup_success",$_SESSION['Correu']);
            header("Location: hola.php", true, 302);
        } else  header("Location: index.php?error=nohasemplenatelscamps", true, 303);
    }
}

/**
 * Funcio per guardar les variables a la Sessió.
 *
 * @param string $Nom Es el nom de l'usuari.
 * @param string $Mail Es el mail de l'usuari.
 * @param string $time Es l'hora a la que l'usuari ha iniciat sesió.
 */
function guardarDadesSesio(string $Nom , string $Mail , int $time)
{
    $_SESSION['Usuari'] = $Nom;
    $_SESSION['Correu'] = $Mail;
    $_SESSION['LAST_ACTIVITY'] = $time;
}

/**
 * Funcio que guarda la IP de la connexió entrant, el moment d'accés (data, hora, minuts, segons) i 
 * l'estat de l'accés (correcte, contrasenya-incorrecte, usuari-incorrecte, nou-usuari, creació-fallida)
 * en el fitxer de connexions.
 *
 * @param string $status Es l'estat que guardarem al fitxer de connexions.
 * @param string $usuari Es l'usuari que guardarem al fitxer de connexions.
 */
function registrarStatus(string $status, string $usuari)
{
    date_default_timezone_set('Europe/Madrid');
    $Conexions = array('ip' => $_SERVER['REMOTE_ADDR'], 'user' => $usuari, 'time' => date('Y-m-d h:i:s', time()), 'status' => $status);
    insereixConnexio($Conexions);
}
