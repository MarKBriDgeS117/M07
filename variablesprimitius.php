<?php
$i = 12;
$tipus_de_i = gettype( $i );
$tipus_de_gettype = gettype( $tipus_de_i );
echo "La variable \$i 
      conté el valor $i 
	  i és del tipus $tipus_de_i i el tipus de gettype es  $tipus_de_gettype";
?>