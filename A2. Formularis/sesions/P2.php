<?php
  // Start the session
  session_start();
?>
<!DOCTYPE html>
<html>
  <body>
  <h2>P2.php</h2>
  <?php
    // Set session variables
    echo "El valor de la sesió es ". $_SESSION["laMevaVariableDeSessio"];
   ?>
  </body>
</html>