<?php

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
        $comprovarData = verificarData('Y.m.d', $_GET['data']);
        if ($comprovarData == true) $_SESSION['Data'] = $_GET['data'];
    } elseif (empty($_SESSION['Data'])) $_SESSION['Data'] = date('Y.m.d');
}

/**
 * Funció que s'executa a l'inici de l'aplicació que serveix per comprovar si hi ha una fase activa.
 * S'hi n'hi ha una crida a actualizar concurs, a inicialitzar vots i retorna els gossos de la fase.
 * En cas contrari llegeix les fases que s'han superat i t'agafa l'ultima i crida a inicialitza el vots si ja 
 * s'ha ha passat l'ultima fase calcula l'eliminat i retorna null.
 * 
 * @param mixed $Fase És la fase del concurs.
 * @return mixed  Retorna els gossos si la fase no es null i s'hi ho es retorna null.
 */
function començament(mixed $Fase)
{
    if ($Fase != null) {
        actulitzarConcurs($_SESSION['Data'], $Fase);
        inicialitzarVots($Fase->getNum());
        return Gos::llegeixGossosFase($Fase->getNum());
    } else {
        $fases = Fase::llegeixFasesSuperades($_SESSION['Data']);
        $Fase = end($fases);
        if ($Fase != null) {
            inicialitzarVots($Fase->getNum());
            if (Fase::llegeixFase(8)->getDataFinal() < $_SESSION['Data'] && Fase::llegeixFase(8)->getSuperada() != "superada") {
                calcularEliminat(8);
                Fase::actualitzarFaseSuperda(8, "superada");
            }
        }
        return null;
    }
}

/**
 * Funció que s'encarrega d'inicialitzar el gossos a les diferents fases.
 * 
 * @param int $Fase És el numero de fase del concurs en el que estem.
 */
function inicialitzarVots(int $fase)
{
    for ($i = 1; $i < $fase + 1; $i++) {
        $faseSuperda = Fase::llegeixFase($i);
        if ($faseSuperda->getSuperada() != "superada") {
            if ($i == 1) {
                $Gossos = Gos::llegeixGossos();
                eliminarCanviarFase($Gossos, $fase, $faseSuperda, $i);
            } else {
                $Gossos = Gos::llegeixGossosFase($i - 1);
                eliminarCanviarFase($Gossos, $fase, $faseSuperda, $i);
            }
        }
    }
}

/**
 * Funció que afegeix el gossos a la taula fase vots si no estant eliminats. I s'hi la fase
 * es diferent de l'actual crida a caluclar l'eliminat.
 * 
 * @param array $Gossos Són el gossos que volem afegir.
 * @param int $fase És el numero fase en la que ens trobem.
 * @param Fase $faseSuperda És la fase que hem superat.
 * @param int $i És l'index del bucle per calcular l'eliminat.
 * 
 */
function eliminarCanviarFase(array $Gossos, int $fase, Fase $faseSuperda, int $i)
{
    foreach ($Gossos as $key => $value) if ($value->getEliminat() == "") Gos::afegirGossosFaseVot($i, $value->getId());
    if ($fase != $i) {
        calcularEliminat($i);
        Fase::actualitzarFaseSuperda($faseSuperda->getNum(), "superada");
    }
}

/**
 * Funció que serveix per calcular l'eliminat.
 * 
 * @param int $fase Es el numero de la fase.
 */
function calcularEliminat(int $fase)
{
    $Gossos = Gos::llegeixGossosFase($fase);
    $GossosVotsIguals = calcularGosMenysVots($Gossos);
    if (count($GossosVotsIguals) > 1) {
        foreach ($GossosVotsIguals as $key => $value) $value->setVots(Gos::sumarVots($value->id)['vots']);
        $GossosVotsIguals = calcularGosMenysVots($GossosVotsIguals);
        if (count($GossosVotsIguals) > 1) Gos::posarEliminat($GossosVotsIguals[rand(0, count($GossosVotsIguals) - 1)]->getId(), $fase);
        else Gos::posarEliminat($GossosVotsIguals[0]->getId(), $fase);
    } else Gos::posarEliminat($GossosVotsIguals[0]->getId(), $fase);
}

/**
 * Funció de actualitzar el concurs segons la data i la fase que estem.
 * 
 * @param mixed $fase Es la data que estem.
 * @param Fase $fase Es la fase que estem.
 */
function actulitzarConcurs(mixed $data, Fase $fase)
{
    Fase::actualitzarFasesSuperdas($data, "");
    Gos::esborrarVotsDesdeFase($fase->getNum());
    Gos::eliminarEliminat($fase->getNum());
}

/**
 * Funció que serveix per calcular quins són els gossos que tenen menys vots.
 * 
 * @param array $Gossos Es el gossos dels quals volem saber quin t'he menys vots.
 * @return array $row Retorna el gossos que tenen menys vots.
 */
function calcularGosMenysVots(array $Gossos):array
{
    $GossosShift = $Gossos;
    $object = array_reduce($GossosShift, function ($a, $b) {
        return $a->vots < $b->vots ? $a : $b;
    }, array_shift($GossosShift));
    foreach ($Gossos as $key => $value) if ($value->getVots() == $object->vots) $GossosVotsIguals[] = $value;
    return  $GossosVotsIguals;
}
