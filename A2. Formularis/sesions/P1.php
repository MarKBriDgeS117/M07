<?php
  // Start the session
  session_start();
?>
<!DOCTYPE html>
<html>
  <body>
  <h2>P1.php</h2>
  <?php
    // Set session variables
    $_SESSION["laMevaVariableDeSessio"] = "oculus reparum";
    echo "Session variables are set.";
   ?>
  </body>
</html>