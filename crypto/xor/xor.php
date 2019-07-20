<?php
header("content-type:text/html;charset=utf-8");

function encode($plaintext,$key)
{
        $text = "";
        $keylen = strlen($key);
        $plaintext = str_split($plaintext);
        for ($i=0; $i < count($plaintext); $i++) { 
            // $k = $i % $keylen;
            // $text .= $plaintext[$i] ^ $key[$k];
            if ($plaintext[$i] == $key[$i]) {
                $text .= "0"; 
            } else {
                $text .= "1";
            }
        }
        // $text = str_split($text);
        // var_dump($text);
        // for ($i=0; $i < count($text); $i++) { 
        //     echo $text[$i];
        // }
        return $text;
}

function fileEncode()
{
    $str = file_get_contents('xor.txt');//将整个文件内容读入到一个字符串中 
    $str_encoding = mb_convert_encoding($str, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');//转换字符集（编码） 
    $arr = explode("\r\n", $str_encoding);//转换成数组 
    //去除值中的空格 
    foreach ($arr as &$row) { $row = trim($row); } unset($row); 
    //得到后的数组 
    // var_dump($arr);
    $array = $arr;
    $comma_separated = implode("", $array);
    $key = $_POST["fileEncodeKey"];
    $cipher = encode($comma_separated,$key);
    echo $cipher;
    $myfile = fopen("ciphertext.txt","w") or die("Unable to open file!");
    fwrite($myfile,$cipher);
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
    echo encode($_POST["plaintext"],$_POST["encodeKey"]);
    echo "<br><br>";
    
} elseif (isset($_POST["submit"]) && $_POST["submit"] == "fileEncode") {
    fileEncode();
    echo "加密成功！";
}



?>