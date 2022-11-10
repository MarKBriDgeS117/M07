<?php

/**
 * Crea una connexió a la base de dades.
 *
 * @return $pdo Retorna la connexió. 
 */
function Conectarse()
{
    try {
        $hostname = "localhost";
        $dbname = "dwes-mpont-autpdo";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
        return $pdo;
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }
}

/**
 * Fa una cunsulta a la base de dades sobre un Usuari.
 * 
 * @param string $Usuari Es l'string on hi ha el correu de l'usuari per fer la consulta.
 * @return mixed $row Retorna les dades de l'usuari, en cas contrari retorna null. 
 */
function llegeix(string $CorreuUsuari)
{
    $pdo = Conectarse();
    $query = $pdo->prepare("select `email`,`password`,`name` FROM users where email = '$CorreuUsuari' ");
    $value = $query->execute();
    if (!$value) {
        return null;
    } else {
        $row = $query->fetch();
        unset($pdo);
        unset($query);
        //if($row == false){
        //    $row = [];
        //}
        return $row;
    }
}
/**
 * Fa una insert a la base de dades d'un Usuari.
 *
 * @param array $Usuari Es l'array on estan guardades les dades de l'usuari que volem inserir.
 */
function insereixUsuari(array $Usuari)
{
    $pdo = Conectarse();
    $sql = "select count(*) as n from users where email = ?";
    $query = $pdo->prepare($sql);
    $query->execute(array($Usuari['email']));
    $e = $query->errorInfo();
    if ($e[0] != '00000') {
        echo "\nPDO::errorInfo():\n";
        die("Error accedint a dades: " . $e[2]);
    }
    $resultat = $query->fetch();
    $es_ok = ($resultat['n'] == 0);
    if ($es_ok) {
        $sql = "insert into users values (?,md5(?),?)";
        $query = $pdo->prepare($sql);
        $query->execute(array($Usuari['email'], $Usuari['password'], $Usuari['name']));
        $e = $query->errorInfo();
        if ($e[0] != '00000') {
            echo "\nPDO::errorInfo():\n";
            die("Error accedint a dades: " . $e[2]);
        }
    }
}

/**
 * Fa una insert a la base de dades d'una connexió.
 *
 * @param array $Connexió Es l'array on estan guardades les dades de la connexió que volem inserir.
 */
function insereixConnexio(array $Connexió)
{
    $pdo = Conectarse();
    $sql = "insert into connexions values (?,?,?,?)";
    $query = $pdo->prepare($sql);
    $query->execute(array($Connexió['ip'], $Connexió['user'], $Connexió['time'], $Connexió['status']));
    $e = $query->errorInfo();
    if ($e[0] != '00000') {
        echo "\nPDO::errorInfo():\n";
        die("Error accedint a dades: " . $e[2]);
    }
}

/**
 * Fa una cunsulta a la base de dades sobre les connexions d'un Usuari. 
 *
 * @param string $CorreuUsuari Es l'string on hi ha el correu de l'usuari per fer la consulta.
 * @return mixed $row Retorna les connexions de l'usuari. 
 */
function llegeixConnexions(string $CorreuUsuari): array
{
    $pdo = Conectarse();
    $query = $pdo->prepare("select `ip`,`user`,`time`,`status` FROM connexions where user = '$CorreuUsuari' AND status IN ('signin_success','signup_success')");
    $query->execute();
    $row = $query->fetchAll();
    unset($pdo);
    unset($query);
    return $row;
}
