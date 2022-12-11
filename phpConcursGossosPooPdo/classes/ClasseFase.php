<?php
include_once "classes/ClasseBaseDades.php";
class Fase
{
    private $num;
    private string $dataInici;
    private string $dataFinal;
    private $superada;


    //CONSTRUCTOR: s'executa quan es crea l'objecte
    public function __construct($num, $dataInici, $dataFinal, $superada)
    {
        $this->num = $num;
        $this->dataInici = $dataInici;
        $this->dataFinal = $dataFinal;
        $this->superada = $superada;
    }

    //MÈTODES

    public function getNum()
    {
        return $this->num;
    }
    public function getDataInici()
    {
        return $this->dataInici;
    }
    public function getDataFinal()
    {
        return $this->dataFinal;
    }
    public function getSuperada()
    {
        return $this->superada;
    }
    /**
     * Funció que serveix per llegir una fase
     * 
     * @param int $fase Es l'id de la fase .
     * @return Fase  Retorna la fase.
     * 
     */
    static function llegeixFase(int $fase)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("select `num`,`dataInici`,`dataFinal`,`superada` FROM fase where num = ?");
        $query->execute(array($fase));
        $row = $query->fetch();
        $Fase = new fase($row['num'], $row['dataInici'], $row['dataFinal'], $row['superada']);
        unset($pdo);
        unset($query);
        return $Fase;
    }
    /**
     * Funció que serveix per llegir en quina fase estem.
     * 
     * @param string $data Es la data que estem.
     * @return Fase  Retorna la fase.
     * 
     */
    static function faseConcurs(string $data)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("select `num`,`dataInici`,`dataFinal`,`superada` FROM fase where dataInici <= ? and dataFinal >= ? ");
        $query->execute(array($data, $data));
        $row = $query->fetch();
        if ($row != null) {
            $Fase = new fase($row['num'], $row['dataInici'], $row['dataFinal'], $row['superada']);
        } else {
            return null;
        }
        unset($pdo);
        unset($query);
        return $Fase;
    }
    /**
     * Funció que serveix per llegir totes les fases.
     * 
     * @return array  Retorna un array amb totes les fases.
     */
    static function llegeixFases()
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("select `num`,`dataInici`,`dataFinal`,`superada` FROM fase ");
        $query->execute();
        $row = $query->fetch();
        $Fases = [];
        while ($row) {
            $Fase = new fase($row['num'], $row['dataInici'], $row['dataFinal'], $row['superada']);
            $Fases[] = $Fase;
            $row = $query->fetch();
        }
        unset($pdo);
        unset($query);
        return $Fases;
    }
    /**
     * Funció que serveix per llegir totes les fases que hem superat.
     * 
     * @param string  $data Es la data que estem.
     * @return array  Retorna un array amb totes les fases.
     */
    static function llegeixFasesSuperades(string $data)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("select `num`,`dataInici`,`dataFinal`,`superada` FROM fase where dataFinal < ? ");
        $query->execute(array($data));
        $row = $query->fetch();
        $Fases = [];
        while ($row) {
            $Fases[] = new fase($row['num'], $row['dataInici'], $row['dataFinal'], $row['superada']);
            $row = $query->fetch();
        }
        unset($pdo);
        unset($query);
        return $Fases;
    }

    /**
     * Funció que serveix per llegir totes les fases que hem superat.
     * 
     * @param int $fase Es l'id de la fase que volem actualitzar.
     * @param string $DataInicial Es la data inicial de la fase.
     * @param string $DataFinal Es la data final de la fase.
     */
    static function actualitzarFase(int $fase, string $DataInicial, string $DataFinal)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("update fase set dataInici = ? , dataFinal = ? where num = ?");
        $query->execute(array($DataInicial, $DataFinal, $fase));
        unset($pdo);
        unset($query);
    }
    /**
     * Funció que serveix per actualitzar una fase superada.
     * 
     * @param int $fase Es l'id de la fase que volem actualitzar.
     * @param string $superada Es l'string que volem posar.
     */
    static function actualitzarFaseSuperda(int $fase, string $superada)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("update fase set superada = ? where num = ?");
        $query->execute(array($superada, $fase));
        unset($pdo);
        unset($query);
    }
     /**
     * Funció que serveix per actualitzar les fases superades desde una dada.
     * 
     * @param string $data Es desde la data que volem actualitzar.
     * @param string $superada Es l'string que volem posar.
     */
    static function actualitzarFasesSuperdas(string $data, string $superada)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("update fase set superada = ? where dataFinal > ?");
        $query->execute(array($superada, $data));
        unset($pdo);
        unset($query);
    }

    /**
     * Funció que serveix per comprovar que una data no estigui dins d'una fase d'un cuncurs.
     * 
     * @param string $data Es la data que volem comprovar.
     * @param string $fase Es per no comprovar la fase actual.
     * @return Fase  Retorna la fase.
     */
    static function comprovarFaseConcurs(string $data, string $fase)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("select `num`,`dataInici`,`dataFinal` FROM fase where dataInici <= ? and dataFinal >= ? and num != ?");
        $query->execute(array($data, $data, $fase));
        $row = $query->fetch();
        unset($pdo);
        unset($query);
        if ($row == null) {
            return true;
        } else {
            return null;
        }
    }

}
