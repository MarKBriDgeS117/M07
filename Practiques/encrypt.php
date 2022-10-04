<?php

$sp = "kfhxivrozziuortghrvxrrkcrozxlwflrh";
$mr = " hv ovxozwozv vj o vfrfjvivfj h vmzvlo e hrxvhlmov oz ozx.vw z xve hv loqvn il hv lmnlg izxvwrhrvml ,hv b lh mv,rhhv mf w zrxvlrh.m";

encriptar($mr);
echo "\n";
encriptar($sp);

  function encriptar($frase){
    $variable = str_split($frase, 3);

    foreach ($variable as $value) {
    $Reorder = strrev($value) ;
    Reciprcalstring($Reorder);
     }
  }

  function Reciprcalstring($word)
{
    $ch;
    for ($i = 0; $i < strlen($word); $i++)
    {
        $ch = $word[$i];
        if(!ctype_alpha($ch)) echo ($ch); 
        else if (check_lowercase_string($ch))$ch = chr(122 - ord($ch) + 97);
        else if (check_uppercase_string($ch))$ch = chr(90 - ord($ch) + 65);
        if(ctype_alpha($ch)) echo ($ch);
    }
}
function check_lowercase_string($string)
{
    return ($string === strtolower($string));
}
 
function check_uppercase_string($string)
{
    return ($string === strtoupper($string));
}
 
?>