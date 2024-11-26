<?php

$keyContent = "Hola mundo esta es la llave privada";
$cerContent = "Certificado simulado con datos de Eugenia Fuentes";


$password = "contraseña123";


$method = "AES-256-CBC";
$key = hash("sha256", $password, true); 
$iv = substr($key, 0, 16); 


$encryptedKey = openssl_encrypt($keyContent, $method, $key, 0, $iv);
$encryptedCer = openssl_encrypt($cerContent, $method, $key, 0, $iv);

file_put_contents("archivo.key.txt", $encryptedKey);
file_put_contents("archivo.cer.txt", $encryptedCer);

echo "Archivos cifrados generados correctamente.";

