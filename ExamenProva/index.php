<?php
if(!isset($_COOKIE["user"])) {
    setcookie('user', '1');
    $val = 1;
} else {
    
    $val = $_COOKIE["user"] + 1;
    setcookie('user',  $val);
   
}

//incloure altres fitxers
include_once "funcions.php"; 

//retrieving
$var = llegeix_de_disc();

//afegir dades darrera connexió
$ip_remota = $_SERVER["REMOTE_ADDR"];
$navegador = $_SERVER["HTTP_USER_AGENT"];
$txt = "Connexió $val des de $ip_remota using $navegador";
$var[] = $txt;

//mostrar totes les connexions al navegador
foreach ($var as $key => $value) {
    print_r($value);
}
//storing
//todo: invocar la funció que persisteix a disc amb els paràmetres que calgui.
persisteix_a_disc($var);

?>