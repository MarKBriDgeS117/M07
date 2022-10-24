<?php
session_start();


$rebo_dades = ($_SERVER['REQUEST_METHOD'] == 'POST');

$dades_ok =   $rebo_dades &&

    isset($_POST['method']);

if ($rebo_dades) {
    if ($dades_ok && !$_POST['method'] == "") {


        if ($_POST['method'] == "signup") {

            $dades = array('email' => $_POST['email'], 'password' => $_POST['password'], 'name' => $_POST['Nom']);

            $dades2 = array($_POST['email'], $dades);

            $tots = llegeix("users.json");

            foreach ($tots as $key => $value) {
                if (in_array($_POST['email'], $value)) {
                    header("Location: index.php?error=Jaestasregistrat", true, 303);
                    die();
                }
                
            }
            array_push($tots, $dades2);
                
                escriu($tots, "users.json");
                $_SESSION['Usuari'] = $_POST['Nom'];
                header("Location: hola.php", true, 302);
                die();
        } elseif ($_POST['method'] == "signin") {
            $tots = llegeix("users.json");

            foreach ($tots as $key => $value) {

                if (in_array($_POST['email'], $value)) {

                    $key = array_search($_POST['email'], $value);
                    $var = ($tots[$key][1]);

                    if ($var["password"] == $_POST['password']) {
                        $_SESSION['Usuari'] = $var["name"];
                        header("Location: hola.php", true, 302);
                        die();
                    } else {
                        header("Location: index.php?error=passwordIncorrecta", true, 303);
                        die();
                    }
                }
            }
            header("Location: index.php?error=noestasregistrat", true, 303);
            die();
        }
        //header("Location: index.php", true, 302);
        //CompravarParaula($paraulaEntrada);
        //die();
    } else {
        header("Location: index.php", true, 303);
        die();
    }
} else {
    header("Location: index.php", true, 303);
    die();
}
/**
 * Llegeix les dades del fitxer. Si el document no existeix torna un array buit.
 *
 * @param string $file
 * @return array
 */
function llegeix(string $file): array
{
    $var = [];
    if (file_exists($file)) {
        $var = json_decode(file_get_contents($file), true);
    }
    return $var;
}

/**
 * Guarda les dades a un fitxer
 *
 * @param array $dades
 * @param string $file
 */
function escriu(array $dades, string $file): void
{
    file_put_contents($file, json_encode($dades, JSON_PRETTY_PRINT));
}
