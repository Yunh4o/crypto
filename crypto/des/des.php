<?php
header("content-type:text/html;charset=utf-8");
include "xcrypt.php";
// function des_encrypt($str, $key) {
//   $block = mcrypt_get_block_size('des', 'ecb');
//   $pad = $block - (strlen($str) % $block);
//   $str .= str_repeat(chr($pad), $pad);
  
//   return mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);
// }

// function des_decrypt($str, $key) {
//     $str = mcrypt_decrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);
//     $len = strlen($str);
//     $block = mcrypt_get_block_size('des', 'ecb');
//     $pad = ord($str[$len - 1]);

//     return substr($str, 0, $len - $pad);

// }
// $ciphertext = des_encrypt($plaintext,$key);
// $ciphertext_base64 = base64_encode($ciphertext);
// echo $ciphertext_base64;
// echo "<br><br>";
// $plaintext = des_decrypt($ciphertext,$key);
// echo $plaintext;

function put($plaintext)
{
    
    $key = '12345678';
    
    $m = new Xcrypt($key);
    $b = $m->encrypt($plaintext);
    $c = $m->decrypt($b);

    echo 'ciphertext:<br>';
    var_dump($b);
    echo 'plaintext:<br>';
    var_dump($c);
}



if (isset($_POST["submit"]) && $_POST["submit"] == "encode") {

    put($_POST["plaintext"]);

} elseif (isset($_POST["submit"]) && $_POST["submit"] == "fileEncode") {
    $f = new Xcrypt('12345678');
    $f->fileEncode();
    echo "加密成功！";
}



?>