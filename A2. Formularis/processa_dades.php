<?php
    
  // Blucle extern ( els paràmetres rebuts del formulari )
  foreach ( $_REQUEST as $clau => $valor ) {
      echo "Clau : $clau <br/>";
      $es_array = ( gettype ( $valor ) == " array " );
      if ( $es_array ) {
  
        echo "Valor(s): ";
        // Bucle intern ( un dels paràmetres és un array i cal recorre'l )
        foreach ( $valor as $v ) {
             echo "$v, ";
        }
      }else {
        echo "Valor : $valor ";
      }
      echo "<br/>" ;
      echo "<br/>" ;
    }
    
   
?>