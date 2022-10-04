<!DOCTYPE html>
<html lang="ca">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Calculadora</title>
</head>

<body>
    <div class="container">
        <form name="calc" class="calculator" action="" method="post">
            <input type="text" class="value" readonly value="<?php echo mostrarOperacio() ?>" name="resultat" />
            <span class="num petit"><input type="submit" value="(" name="tecla"></span>
            <span class="num petit"><input type="submit" value=")" name="tecla"></span>
            <span class="num petit"><input type="submit" value="SIN" name="tecla"></span>
            <span class="num petit"><input type="submit" value="COS" name="tecla"></span>
            <span class="num clear"><input type="submit" value="C" name="tecla"></span>
            <span class="num"><input type="submit" value="/" name="tecla"></span>
            <span class="num"><input type="submit" value="*" name="tecla"></span>
            <span class="num"><input type="submit" value="7" name="tecla"></span>
            <span class="num"><input type="submit" value="8" name="tecla"></span>
            <span class="num"><input type="submit" value="9" name="tecla"></span>
            <span class="num"><input type="submit" value="-" name="tecla"></span>
            <span class="num"><input type="submit" value="4" name="tecla"></span>
            <span class="num"><input type="submit" value="5" name="tecla"></span>
            <span class="num"><input type="submit" value="6" name="tecla"></span>
            <span class="num plus"><input type="submit" value="+" name="tecla"></span>
            <span class="num"><input type="submit" value="1" name="tecla"> </span>
            <span class="num"><input type="submit" value="2" name="tecla"></span>
            <span class="num"><input type="submit" value="3" name="tecla"></span>
            <span class="num"><input type="submit" value="0" name="tecla"></span>
            <span class="num"><input type="submit" value="00" name="tecla"></span>
            <span class="num"><input type="submit" value="." name="tecla"></span>
            <span class="num equal"><input type="submit" value="=" name="tecla"></span>
        </form>
    </div>
</body>


<?php
/**
 * Funció que s'encarrega de mostrar per pantalla els valors seleccionats i el resultat . 
 *
 * @return mixed $operacio Retorna un string amb el valor que mostrarem.
 */
function mostrarOperacio()
{
    $operacio = implode($_POST);

    if (isset($_POST["resultat"]) && ($_POST["resultat"] == "ERROR" || $_POST["resultat"] == "INF")) {

        $operacio = str_replace("ERROR", "", $operacio);

        $operacio = str_replace("INF", "", $operacio);
    } else {

        $operacio = recorreOperacio($operacio);
    }
    switch (end($_POST)) {

        case '=':
            array_pop($_POST);
            $operacio = calcularOperacio(implode($_POST));
            break;

        case 'C':
            $operacio = '';
            break;
    }
    return $operacio;
}
/**
 * Funció que calcula l'operació i controla els errors.
 *
 * @param string $operacio És l'string que volem calcular.
 * @return mixed $resultat Retorna el resultat calculat en cas contrari retorna l'error que pertoqui.  
 */
function calcularOperacio(string $operacio)
{

    try {
        if (preg_match('/^[SINCO0-9()+.\-*\\/]+$/', $operacio)) {

            $resultat = eval("return (" . $operacio . ");");

            if (is_float($resultat)) {

                $resultat = truncarNumero($resultat);
            }
        } else {
            $resultat = "ERROR";
        }
    } catch (DivisionByZeroError $exepcio) {

        $resultat = "INF";
    } catch (Throwable $exepcio) {

        $resultat = "ERROR";
    }

    return $resultat;
}
/**
 * Funció que li passes un nombre i el retorna amb 4 decimals si en té.
 *
 * @param float $numero És el número que volem tornar amb quatre decimals.
 * @return float $numero Retorna el número amb quatre decimals.  
 */
function truncarNumero(float $numero): float
{
    $format = sprintf('%%.%df', 4 + 1);
    $numero = substr(sprintf($format, $numero), 0, -1);
    return (float) $numero;
}
/**
 * Funció que recorre tot l'array comprovant que no es pugui introduir dos símbols iguals seguits. 
 *
 * @param string $operacio És l'string que volem comprovar que no hi hagin dos símbols iguals seguit.
 * @return string implode($arrayOperacio) Retorna la cadena esborrant l'últim símbol igual seguit.
 *  
 */
function recorreOperacio(string $operacio)
{
    $arrayOperacio = str_split($operacio);

    for ($i = 0; $i < count($arrayOperacio) - 1; $i++) {

        if ($arrayOperacio[$i] == $arrayOperacio[$i + 1] && !is_numeric($arrayOperacio[$i]) && !preg_match('/[a-zA-Z]/', $arrayOperacio[$i]) && $arrayOperacio[$i] != '(' && $arrayOperacio[$i] != ')') {

            array_pop($arrayOperacio);

            return implode($arrayOperacio);
        }
    }

    return implode($arrayOperacio);
}
?>