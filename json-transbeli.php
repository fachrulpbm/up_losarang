<?php
    // deklarasi array transbeli
    $transbeli = array();
    // variable yang berisi array transbeli dengan format JSON 
    $json = json_encode($transbeli, JSON_PRETTY_PRINT);
    // export variable json menjadi file transbeli.json
    file_put_contents('transbeli.json', $json);
?>