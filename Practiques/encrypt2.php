<?php
  

$simple_string = "Welcome to To My House";
  

echo "Original String: " . $simple_string . "\n";
  

$ciphering = "BF-CBC";
  

$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
  

$encryption_iv = random_bytes($iv_length);
  

$encryption_key = openssl_digest(php_uname(), 'MD5', TRUE);
  

$encryption = openssl_encrypt($simple_string, $ciphering,
        $encryption_key, $options, $encryption_iv);
  

echo "Encrypted String: " . $encryption . "\n";
  

$decryption_iv = random_bytes($iv_length);
  

$decryption_key = openssl_digest(php_uname(), 'MD5', TRUE);
  

$decryption = openssl_decrypt ($encryption, $ciphering,
            $decryption_key, $options, $encryption_iv);
  

echo "Decrypted String: " . $decryption;
  
?>