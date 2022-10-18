<!DOCTYPE html>
<html>
<body>

<h2>P3.php</h2>


</body>
</html>
<?php

if(isset($_COOKIE["user"])) {
    
    setcookie('user', '101', time()+3600, '/');

    echo "El valor de la cooki ha cambiat a ".$_COOKIE["user"];
} else {
    echo "La cookie no ha arribat";
}
?>
