<?php
header("content-type:text/html;charset=utf-8");



function encryption($plaintext,$key)
{
    
    $ciphertext = "";
    for ($i = 0; $i < strlen($plaintext); $i++) {
        $c = ord($plaintext[$i]);

        $c += $key %  26;

        if ($plaintext[$i] >= 'a' && $plaintext[$i] <= 'z') {
            if (chr($c) < 'a')
                $c += 26;
            if (chr($c) > 'z')
                $c -= 26;
        } else if ($plaintext[$i] >= 'A' && $plaintext[$i] <= 'Z') {
            if (chr($c) < 'A')
                $c += 26;
            if (chr($c) > 'Z')
                $c -= 26;
        }
        $ciphertext .= chr($c);
    }
    // for ($i=0; $i < strlen($ciphertext); $i++) { 
    //     echo $ciphertext[$i];
    // }
    return $ciphertext;
}
function decryption($ciphertext,$key)
{
    ;
    $plaintext = "";
    for ($i = 0; $i < strlen($ciphertext); $i++) {
        $c = ord($ciphertext[$i]);

        $c -= $key %  26;

        if ($ciphertext[$i] >= 'a' && $ciphertext[$i] <= 'z') {
            if (chr($c) < 'a')
                $c += 26;
            if (chr($c) > 'z')
                $c -= 26;
        } else if ($ciphertext[$i] >= 'A' && $ciphertext[$i] <= 'Z') {
            if (chr($c) < 'A')
                $c += 26;
            if (chr($c) > 'Z')
                $c -= 26;
        }
        $plaintext .= chr($c);
    }
    // for ($i=0; $i < strlen($plaintext); $i++) { 
    //     echo $plaintext[$i];
    // }
    return $plaintext;
}

function fileEncode()
{
    $str = file_get_contents('caesar.txt');//将整个文件内容读入到一个字符串中 
    $str_encoding = mb_convert_encoding($str, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');//转换字符集（编码） 
    $arr = explode("\r\n", $str_encoding);//转换成数组 
    //去除值中的空格 
    foreach ($arr as &$row) { $row = trim($row); } unset($row); 
    //得到后的数组 
    // var_dump($arr);
    $array = $arr;
    $comma_separated = implode("", $array);
    $key = $_POST["fileEncodeKey"];
    $cipher = encryption($comma_separated,$key);
    echo $cipher;
    $myfile = fopen("ciphertext.txt","w") or die("Unable to open file!");
    fwrite($myfile,$cipher);
    fclose($myfile);
}

function fileDecode()
{   
    $str = file_get_contents('ciphertext.txt');
    $str_encoding = mb_convert_encoding($str, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
    $arr = explode("\r\n", $str_encoding);
    //去除值中的空格 
    foreach ($arr as &$row) { $row = trim($row); } unset($row); 
    
    $array = $arr;
    $comma_separated = implode("", $array);
    $key = $_POST["fileDecodeKey"];
    $plaintext = decryption($comma_separated,$key);
    echo $plaintext;
    $myfile = fopen("caesar.txt","w") or die("Unable to open file!");
    fwrite($myfile,$plaintext);
    fclose($myfile);
}


if (isset($_POST["submit"]) && $_POST["submit"] == "encode") {
    echo "明文:\t";
    echo $_POST["plaintext"];
    echo "<br><br>";
    echo "秘钥:\t";
    echo $_POST["encodeKey"];
    echo "<br><br>";
    echo "密文:<br>";
    echo encryption($_POST["plaintext"],$_POST["encodeKey"]);
} elseif (isset($_POST["submit"]) && $_POST["submit"] == "decode"){
    echo "密文:\t";
    echo $_POST["ciphertext"];
    echo "<br><br>";
    echo "秘钥:\t";
    echo $_POST["decodeKey"];
    echo "<br><br>";
    echo "明文:<br>";;
    echo decryption($_POST["ciphertext"],$_POST["decodeKey"]);
}  elseif (isset($_POST["submit"]) && $_POST["submit"] == "fileEncode") {
    fileEncode();
    echo "加密成功！";
} elseif (isset($_POST["submit"]) && $_POST["submit"] == "fileDecode") {
    fileDecode();
    echo "解密成功！";
}

?>