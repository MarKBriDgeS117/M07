<!DOCTYPE html>
<html>
<body>

<h2>HTML Forms</h2>

<form name="form" action="" method="get">
  <input type="text" name="subject" id="subject" value="Car Loan">
</form>

</body>
</html>


<?php
function collatz_sequence($x)
{
    $num_seq = [$x];
    if ($x < 1)
    {
       return [];
    }
    while ($x > 1)
      {
       if ($x % 2 == 0)
       {
         $x = $x / 2;
       }
       else
       {
         $x = 3 * $x + 1;
       }
    # Added line
     array_push($num_seq, $x);
      }
    return $num_seq;
}
print_r(collatz_sequence(9999));
print_r(collatz_sequence(19));
?>