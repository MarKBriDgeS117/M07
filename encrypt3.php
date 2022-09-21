

<?php
    
    $Text = "¿lalalalalalal!!··$%&/((()))=====?¿";

    echo "Frase:  ".$Text."    ";

    Echo "Encryptat:  ".$encrypt= encrypt($Text)."    ";
    
    Echo "Desencryptat: ".decrypt($encrypt);
    
    function encrypt($frase){
        $result = "";

        $ip = getIp();

        $nova = bin2hex(base64_encode($frase));

        $array = str_split($nova);

        $base = str_split('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

        foreach ( $array as $value)
        {
             $key = array_search($value, $base);

             if ($key  + $ip > 61 ) {

                $array[$value] =  $base[$key  +$ip - 61];
             }else {

                $array[$value] =  $base[ $key +$ip];
             }
             $result = $result . $array[$value];
             
        }
         
        
        return ($result);
    }
    
    function decrypt($frase){
        $result = "";
        $array = str_split($frase);
        $ip = getIp();
        $base = str_split('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

        foreach ( $array as $value)
        {
            
             $key = array_search($value, $base);

             if ($key  - $ip < 0 ) {

                 $array[$value] =  0;
             }else {

                $array[$value] =  $base[ $key - $ip];
             }
             $result = $result . $array[$value];
             
        }
        
       
        return base64_decode(base64_decode(base64_encode(pack('H*',$result))));
        

    }

    function getIp(){

        $ipaddress = getenv("REMOTE_ADDR") ;

        if($ipaddress == "::1"){

         $ipaddress =  "127.0.0.1";

        }

        $int = (int) filter_var($ipaddress, FILTER_SANITIZE_NUMBER_INT);

        $arrayip = str_split($int);

        $adeu = array_sum($arrayip);

        return   $adeu;
    }
    
   
?>

