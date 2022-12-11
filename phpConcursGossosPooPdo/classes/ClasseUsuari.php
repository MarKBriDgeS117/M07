<?php
include_once "classes/ClasseBaseDades.php";
class Usuari {
    
    private $usuari;
    private $password;

    //CONSTRUCTOR: s'executa quan es crea l'objecte
    public function __construct($usuari, $password)
    {
        $this->usuari = $usuari;
        $this->password = $password;
    }
    
    //MÈTODES
    public function getUsuari()
    {
        return $this->usuari;
    }
    public function getPassword()
    {
        return $this->password;
    }

    /**
 * Fa una cunsulta a la base de dades sobre un Usuari.
 * 
 * @param string $Usuari Es l'string on hi ha el correu de l'usuari per fer la consulta.
 * @return mixed $row Retorna les dades de l'usuari, en cas contrari retorna null. 
 */
static function llegeixUsuari(string $CorreuUsuari)
{
    $pdo = BaseDades::conectarse();
    $query = $pdo->prepare("select `email`,`password` FROM users where email = '$CorreuUsuari' ");
    $value = $query->execute();
    if ($value != null) {
        return null;
    } else {
        $row = $query->fetch();
        $Usuari = new Usuari($row['email'], $row['password']);
        unset($pdo);
        unset($query);
        return $Usuari;
    }
}
/**
 * Fa una insert a la base de dades d'un Usuari.
 *
 * @param array $Usuari Es l'array on estan guardades les dades de l'usuari que volem inserir.
 */
static function insereixUsuari(array $Usuari)
{
    $pdo = BaseDades::conectarse();
    $sql = "select count(*) as n from users where email = ?";
    $query = $pdo->prepare($sql);
    $query->execute(array($Usuari['email']));
    $e = $query->errorInfo();
    if ($e[0] != '00000') {
        echo "\nPDO::errorInfo():\n";
        header("Location: index.php?error=BaseDeDadesIncorrecta", true, 303);
        die("Error accedint a dades: " . $e[2]);
    }
    $resultat = $query->fetch();
    $es_ok = ($resultat['n'] == 0);
    if ($es_ok) {
        $sql = "insert into users values (?,md5(?))";
        $query = $pdo->prepare($sql);
        $query->execute(array($Usuari['email'], $Usuari['password']));
        $e = $query->errorInfo();
        if ($e[0] != '00000') {
            echo "\nPDO::errorInfo():\n";
            header("Location: index.php?error=BaseDeDadesIncorrecta", true, 303);
            die("Error accedint a dades: " . $e[2]);
        }
    }
}
}
