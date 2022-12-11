<?php
include_once "classes/ClasseBaseDades.php";
class gos
{

    public $id;
    public $nom;
    public $imatge;
    public $amo;
    public $raza;
    public $vots;
    public $eliminat;

    //CONSTRUCTOR: s'executa quan es crea l'objecte
    public function __construct($id, $nom, $imatge, $amo, $raza, $vots, $eliminat)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->imatge = $imatge;
        $this->amo = $amo;
        $this->raza = $raza;
        $this->vots = $vots;
        $this->eliminat = $eliminat;
    }

    //MÈTODES
    public function getId()
    {
        return $this->id;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getImatge()
    {
        return $this->imatge;
    }
    public function getAmo()
    {
        return $this->amo;
    }
    public function getRaza()
    {
        return $this->raza;
    }
    public function getVots()
    {
        return $this->vots;
    }
    public function getEliminat()
    {
        return $this->eliminat;
    }
    public function setEliminat($eliminat)
    {
        $this->eliminat = $eliminat;
    }
    public function setVots($vots)
    {
        $this->vots = $vots;
    }

    /**
     * Funció que serveix per llegir un gos de la taula gos.
     * 
     * @param int $id Es l'id del gos .
     * @param int $vots És el numero de vots..
     * @param string $eliminat Es si està eliminat o no.
     * @return Gos  Retorna el gos.
     * 
     */
    static function llegeixGos(int $id, int $vots, string $eliminat)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("select `id`,`nom`,`imatge`,`raza`,`amo`FROM gos where id = ? ");
        $query->execute(array($id));
        $row = $query->fetch();
        $Gos = new gos($row['id'], $row['nom'], $row['imatge'], $row['amo'], $row['raza'], $vots, $eliminat);
        unset($pdo);
        unset($query);
        return $Gos;
    }
    /**
     * Funció que serveix per llegir tots el gossos de la taula gos.
     * 
     * @return array  Retorna un array amb els gossos.
     * 
     */
    static function llegeixGossos()
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("select `id`,`nom`,`imatge`,`raza`,`amo` FROM gos");
        $query->execute();
        $row = $query->fetch();
        $Gossos = [];
        while ($row) {
            $Gossos[] = new gos($row['id'], $row['nom'], $row['imatge'], $row['amo'], $row['raza'], 0, "");
            $row = $query->fetch();
        }
        unset($pdo);
        unset($query);
        return $Gossos;
    }
    /**
     * Funció que serveix per afegir un gos a la taula gos.
     * 
     * @param string $NomGos Es el nom del gos .
     * @param string $ImatgeGos És l'imatge del gos.
     * @param string $AmoGos És l'amo del gos.
     * @param string $RaçaGos És l'ha raça del gos.
     * 
     */
    static function afegirGos(string $NomGos, string $ImatgeGos, string $AmoGos, string $RaçaGos)
    {
        $pdo = BaseDades::conectarse();
        $sql = "insert into gos values (DEFAULT,?,?,?,?)";
        $query = $pdo->prepare($sql);
        $query->execute(array($NomGos, $ImatgeGos, $AmoGos, $RaçaGos));
        unset($pdo);
        unset($query);
    }
    /**
     * Funció que serveix per modificar un gos de la taula gos.
     * 
     * @param string $NomGos Es el nom del gos .
     * @param string $ImatgeGos És l'imatge del gos.
     * @param string $AmoGos És l'amo del gos.
     * @param string $AmoGos És l'ha raça del gos.
     * @param int $AmoGos És l'id del gos.
     * 
     */
    static function modificarGos(string $NomGos, string $ImatgeGos, string $AmoGos, string $RaçaGos, int $Id)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("update gos set nom = ? , imatge = ? , amo = ? , raza = ? where id = ?");
        $query->execute(array($NomGos, $ImatgeGos, $AmoGos, $RaçaGos, $Id));
        unset($pdo);
        unset($query);
    }
    /**
     * Funció que serveix per afegir un gos a la taula fase vot.
     * 
     * @param int $FaseId Es l'id de la fase.
     * @param int $GosId Es l'id del gos.
     */
    static function afegirGossosFaseVot(int $FaseId, int $GosId)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("select `GosId`,`vots`FROM fasevots where faseId = ? and GosId = ?");
        $query->execute(array($FaseId, $GosId));
        $row = $query->fetch();
        if ($row == null) {
            $sql = "insert into fasevots values (?,?,?,?)";
            $query = $pdo->prepare($sql);
            $query->execute(array($FaseId, $GosId, 0, ""));
        }
        unset($pdo);
        unset($query);
    }

    /**
     * Funció que serveix per llegir tots el gossos d'una fase.
     * 
     * @param int $id Es l'id de la fase.
     * @return array  Retorna un array amb els gossos.
     */
    static function llegeixGossosFase(int $id)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("select `GosId`,`vots` ,`eliminat` FROM fasevots where faseId = ?");
        $query->execute(array($id));
        $row = $query->fetch();
        $Gossos = [];
        while ($row) {
            $Gossos[] = Gos::llegeixGos($row['GosId'], $row['vots'], $row['eliminat']);
            $row = $query->fetch();
        }
        unset($pdo);
        unset($query);
        return $Gossos;
    }

    /**
     * Funció que serveix per posar tots el vots a 0 d'una fase.
     * 
     * @param int $fase Es l'id de la fase.
     */
    static function esborrarVotsFase($fase)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("update fasevots set vots = 0 where faseId = ?");
        $query->execute(array($fase));
        unset($pdo);
        unset($query);
    }

    /**
     * Funció que serveix per afegir un vot a un gos.
     * 
     * @param int $fase Es l'id de la fase .
     * @param int $id És l'id del gos.
     * @return Gos  Retorna el gos.
     * 
     */
    static function vota($fase, $id)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("select `GosId`,`vots`FROM fasevots where GosId = ?");
        $query->execute(array($id));
        $row = $query->fetch();
        if ($row == null) {
            $query = $pdo->prepare("insert into fasevots (faseId,GosId,vots) values (?,?,?)");
            $query->execute(array($id, $fase, 1));
        } else {
            $query = $pdo->prepare("update fasevots set vots = ? where GosId = ? and faseId = ?");
            $query->execute(array($row['vots'] + 1, $id, $fase));
        }
        $gos = Gos::llegeixGos($id, 0, "");
        unset($pdo);
        unset($query);
        return $gos;
    }
    /**
     * Funció que serveix per actualizar un vot a un gos.
     * 
     * @param int $fase Es l'id de la fase .
     * @param int $gosVotAntic És l'id del gos antic.
     * @param int $gosVotNou És l'id del gos nou.
     * @return Gos  Retorna el gos.
     * 
     */
    static function actualitzarVot(int $fase, int $gosVotAntic, int $gosVotNou)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("select `GosId`,`vots`FROM fasevots where GosId = ? and faseId = ?");
        $query->execute(array($gosVotAntic,$fase));
        $row = $query->fetch();
        $query = $pdo->prepare("update fasevots set vots = ? where GosId = ? and faseId = ?");
        $query->execute(array($row['vots'] - 1, $gosVotAntic, $fase));
        $query = $pdo->prepare("select `GosId`,`vots`FROM fasevots where GosId = ?");
        $query->execute(array($gosVotNou));
        $row = $query->fetch();
        $query = $pdo->prepare("update fasevots set vots = ? where GosId = ? and faseId = ?");
        $query->execute(array($row['vots'] + 1, $gosVotNou, $fase));
        $gos = Gos::llegeixGos($gosVotNou, 0, "");
        unset($pdo);
        unset($query);
        return $gos;
    }
    /**
     * Funció que serveix per posar tots el vots a 0 de totes les fases.
     */
    static function esborrarVots()
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("update fasevots set vots = 0");
        $query->execute();
        unset($pdo);
        unset($query);
    }
    /**
     * Funció que serveix per esborrar tot desde una fase.
     * @param int $fase Es l'id de la fase .
     */
    static function esborrarVotsDesdeFase(int $faseId)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("delete from fasevots where faseId > ?");
        $query->execute(array($faseId));
        unset($pdo);
        unset($query);
    }

    /**
     * Funció que serveix per sumar el vots d'un gos.
     * @param int $GosId Es l'id del gos .
     * @return mixed  Retorna els vots.
     */
    static function sumarVots(int $GosId)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("SELECT GosId ,SUM(vots) AS vots FROM fasevots where  GosId = ?");
        $query->execute(array($GosId));
        $row = $query->fetch();
        unset($pdo);
        unset($query);
        return $row;
    }

    /**
     * Funció que serveix per eliminar un gos .
     * @param int $GosId Es l'id del gos.
     * @param int $fase Es l'id de la fase.
     */
    static function posarEliminat(int $GosId, int $fase)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("update fasevots set eliminat = 'eliminat'  where GosId = ? and faseId = ?");
        $query->execute(array($GosId, $fase));
        unset($pdo);
        unset($query);
    }
    /**
     * Funció que serveix per treure l'eliminat de tots els gossos d'una fase.
     * @param int $fase Es l'id de la fase.
     */
    static function eliminarEliminat(int $fase)
    {
        $pdo = BaseDades::conectarse();
        $query = $pdo->prepare("update fasevots set eliminat = ''  where  faseId = ?");
        $query->execute(array($fase));
        unset($pdo);
        unset($query);
    }
}
