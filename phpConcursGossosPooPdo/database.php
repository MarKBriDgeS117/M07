<?php
include_once "classes/ClasseBaseDades.php";
include_once "classes/ClasseFase.php";
include_once "classes/ClasseGos.php";
include_once "classes/ClasseUsuari.php";

/**
 * Funcio que esborra tots les registres de la taula votssessio.
 */
function esborrarVotsSessio()
{
    $pdo = BaseDades::conectarse();
    $query = $pdo->prepare("delete from votssessio");
    $query->execute(array());
    unset($pdo);
    unset($query);
}
/**
 * Funcio que esborra tots les registres de la taula votssessio per la fase.
 * 
 * @param string $faseId Es l'string on hi ha el numero de la fase.
 */
function esborrarVotsSessioFase(string $faseId)
{
    $pdo = BaseDades::conectarse();
    $query = $pdo->prepare("delete from votssessio where faseId = ?");
    $query->execute(array($faseId));
    unset($pdo);
    unset($query);
}
/**
 * Funció que serveix per esborrar els registres de la taula votssessio.
 * @param int $fase Es l'id de la fase .
 */
function esborrarVotsSessioDesdeFase(int $faseId)
{
    $pdo = BaseDades::conectarse();
    $query = $pdo->prepare("delete from votssessio where faseId > ?");
    $query->execute(array($faseId));
    unset($pdo);
    unset($query);
}

/**
 * Funcio que afegeix un registra a la taula votssessio.
 * 
 * @param string $SessioId Es l'string on hi ha l'id de la sessió.
 * @param string $SessioId Es l'string on hi ha el numero de la fase.
 */
function afegirVotSessio(string $SessioId, string $FaseId)
{
    if (!llegeixVotsSessio($SessioId, $FaseId)) {
        $pdo = BaseDades::conectarse();
        $sql = "insert into votssessio values (?,?)";
        $query = $pdo->prepare($sql);
        $query->execute(array($SessioId, $FaseId));
        unset($pdo);
        unset($query);
    }
}
/**
 * Funcio que fa una cunsulta a la taula votsessio per buscar l'id de la sessió a la fase corresponent.
 * 
 * @param string $SessioId Es l'string on hi ha l'id de la sessió.
 * @param string $SessioId Es l'string on hi ha el numero de la fase.
 * @return bool $row Retorna true si trova la sessio en cas contrari false.
 */
function llegeixVotsSessio(string $SessioId, string $FaseId): bool
{
    $pdo = BaseDades::conectarse();
    $query = $pdo->prepare("select `sessioId`,`FaseId` FROM votssessio where sessioId = ? and FaseId= ?");
    $query->execute(array($SessioId, $FaseId));
    $row = $query->fetch();
    unset($pdo);
    unset($query);
    if ($row != null) {
        return true;
    } else {
        return false;
    }
}
