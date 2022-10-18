<?php
  // Start the session
  session_start();
?>
<!DOCTYPE html>
<html>
  <body>
  <h2>P3.php</h2>
  <?php
    session_destroy();
    echo "La sesio s'ha borrat";
   ?>
  </body>
</html>

