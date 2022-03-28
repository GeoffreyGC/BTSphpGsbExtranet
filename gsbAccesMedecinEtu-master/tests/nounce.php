<?php

$file='../css/Oui-Oui-Nounce.txt';
$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
file_put_contents($file, $nonce,FILE_APPEND | LOCK_EX);
echo $nonce;