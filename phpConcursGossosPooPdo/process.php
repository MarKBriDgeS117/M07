<?php session_start();

include_once "database.php";

$rebo_dades = ($_SERVER['REQUEST_METHOD'] == 'POST');

if ($rebo_dades) {
    if (isset($_POST['poll'])) votaProcess();
    elseif ($_POST['method'] == "signin") iniciarSessio();
    elseif ($_POST['method'] == "signup") registrarUsuari();
    elseif (isset($_POST['ModificarData'])) modificarDataProcess();
    elseif (isset($_POST['BorrarVotsFase'])) borrarVotsFaseProcess();
    elseif (isset($_POST['BorrarVots'])) borrarVotsProcess();
    elseif (isset($_POST['AfegirGos'])) afegirGosProcess();
    elseif (isset($_POST['ModificarGos'])) modificarGosProcess();
} else header("Location: index.php", true, 303);


/**
 * Funció iniciarSesio serveix per verificar si l'usuari que ha iniciat la sessió està registrat o si l'ha contrasenya 
 * es correcta. En cas que estigui registrat et portarà a hola.php. En cas contrari et portarà a index.php amb l'error 
 * corresponent.
 *
 */
function iniciarSessio()
{
    $Usuari = Usuari::llegeixUsuari($_POST['email']);
    if ($Usuari != null) {
        if ($Usuari->getPassword() == md5($_POST['password'])) {
            $_SESSION['Usuari'] = $_POST['email'];
            header("Location: admin.php", true, 302);
        } else header("Location: login.php?error=passwordIncorrecta", true, 303);
    } else header("Location: login.php?error=noestasregistrat", true, 303);
}

/**
 * Funcio per registrar un usuari. Si es registra correctament et portarà a hola.php. 
 * En cas contrari et portarà a index.php amb l'error corresponent.
 *
 */
function registrarUsuari()
{
    $Usuari = Usuari::llegeixUsuari($_POST['email']);
    if ($Usuari != null) {
        header("Location: admin.php?error=Jaestasregistrat", true, 303);
    } else {
        if ($_POST['email'] != "" && $_POST['password'] != "") {
            $Usuari =  array('email' => $_POST['email'], 'password' => $_POST['password']);
            Usuari::insereixUsuari($Usuari);
            $_SESSION['Usuari'] = $_POST['email'];
            header("Location: admin.php", true, 302);
        } else  header("Location: admin.php?error=nohasemplenatelscamps", true, 303);
    }
}

/**
 * Funcio que serveix per votar. Si no has votat afegiex un vot al gos corresponent en cas contrari
 * resta un vot al gos que havies votat ateriorment i posa el vot al nou.
 *
 */
function votaProcess()
{
    if (isset($_SESSION['VotId']) && llegeixVotsSessio(session_id(), $_POST['FaseVot'])) {
        $Gos = Gos::actualitzarVot($_POST['FaseVot'], $_SESSION['VotId'], $_POST['poll']);
        $_SESSION['VotId'] = $Gos->getId();
        $_SESSION['VotNom'] = $Gos->getNom();
        header("Location: index.php", true, 302);
    } else {
        $Gos = Gos::vota($_POST['FaseVot'], $_POST['poll']);
        $_SESSION['VotId'] = $Gos->getId();
        $_SESSION['VotNom'] = $Gos->getNom();
        afegirVotSessio(session_id(), $_POST['FaseVot']);
        header("Location: index.php", true, 302);
    }
}

/**
 * Funcio que serveix per modificar la data d'una fase. Comprova que hagis posat una date 
 * i que no l'hagis posat sobre d'una altre. Si està tot bè la modifica.
 *
 */
function modificarDataProcess()
{
    if (($_POST['Fase']) != "" && ($_POST['DataInici']) != "" && ($_POST['DataFinal']) != "") {
        if (Fase::comprovarFaseConcurs($_POST['DataInici'], $_POST['Fase']) && Fase::comprovarFaseConcurs($_POST['DataFinal'], $_POST['Fase'])) {
            Fase::actualitzarFase($_POST['Fase'], $_POST['DataInici'], $_POST['DataFinal']);
            header("Location: admin.php", true, 302);
        } else header("Location: admin.php?error=nopotspossarunafasesobreunalaltre", true, 303);
    } else header("Location: admin.php?error=nohasemplenatunadata", true, 303);
}

/**
 * Funcio que serveix per borrar tots els d'una fase
 *
 */
function borrarVotsFaseProcess()
{
    Gos::esborrarVotsFase($_POST['BorrarVotsFase']);
    esborrarVotsSessioFase($_POST['Fase']);
    header("Location: admin.php", true, 302);
}

/**
 * Funcio que serveix per borrar tots els vots de totes les fases.
 *
 */
function borrarVotsProcess()
{
    Gos::esborrarVots();
    esborrarVotsSessio();
    header("Location: admin.php", true, 302);
}

/**
 * Funcio que serveix per afegir un gos. Comprova que s'emplenin tots el camps
 * Tambè comprova que no s'afegeixim més de 9 gossos.
 *
 */
function afegirGosProcess()
{
    if ($_POST['numGossos'] < 9) {
        if (($_POST['NomGos']) != "" && ($_POST['ImatgeGos']) != "" && ($_POST['AmoGos']) != "" && ($_POST['RaçaGos']) != "") {
            Gos::afegirGos($_POST['NomGos'], $_POST['ImatgeGos'], $_POST['AmoGos'], $_POST['RaçaGos']);
            header("Location: admin.php", true, 302);
        } else header("Location: admin.php?error=nohasemplenatelscampsafegirgos", true, 303);
    }else header("Location: admin.php?error=jahihaelmaximdegossos", true, 303);
}

/**
 * Funcio que serveix per modificar un gos. Comprova que s'emplenin tots el camps.
 *
 */
function modificarGosProcess()
{
    if (($_POST['NomGos']) != "" && ($_POST['ImatgeGos']) != "" && ($_POST['AmoGos']) != "" && ($_POST['RaçaGos']) != "") {
        Gos::modificarGos($_POST['NomGos'], $_POST['ImatgeGos'], $_POST['AmoGos'], $_POST['RaçaGos'], $_POST['IdGos']);
        header("Location: admin.php", true, 302);
    } else header("Location: admin.php?error=nohasemplenatelscampsmodificargos", true, 303);
}
