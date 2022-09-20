

<?php
 
 

    function getIp(){
        $ipaddress = getenv("REMOTE_ADDR") ;
        if($ipaddress == "::1"){
         return  "127.0.0.1";
        }
        return  $ipaddress;
    }
    $encrypt= encrypt("?Hola?");
    //echo $encrypt;
    decrypt($encrypt);
    
    function encrypt($frase){
        $nova = hexdec(bin2hex(base64_encode($frase)));
        //echo $nova = $nova ;
        $int_value = (int) getIp();
        return dechex(hexdec(bin2hex(base64_encode($frase))));
        
    }
    
    function decrypt($frase){
        
        
        $nova =  hexdec($frase);
        $nova = $nova ;
        $int_value = (int) getIp();
        
        echo base64_decode(base64_decode(base64_encode(pack('H*',dechex($nova)))));

    }
   
    
?>

