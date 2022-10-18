<!DOCTYPE html>
<html>
<body>

<h2>P1.php</h2>


</body>
</html>
<?php
$cookie_name = "user";
$cookie_value = "100";
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
?>
