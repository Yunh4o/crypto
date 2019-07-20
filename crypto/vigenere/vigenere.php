<?php
    header("content-type:text/html;charset=utf-8");
    function encode($plaintext,$key)
    {
        
        $plaintext = strtoupper($plaintext);
        $key = strtoupper($key);
        $key = str_split($key);
        $plaintext = str_split($plaintext);
    
        $ciphertext = array();
        for ($i=0; $i < count($plaintext); $i++) { 
            $ciphertext[$i] = chr(((ord($plaintext[$i]) - 65) + (ord($key[$i % count($key)]) - 65)) % 26 + 65);
        }

        for ($i=0; $i < count($ciphertext); $i++) { 
            echo $ciphertext[$i];
        }

        return implode("",$ciphertext); 
    }
    function decode($ciphertext,$key)
    {
    
        $ciphertext = strtoupper($ciphertext);
        $key = strtoupper($key);
        $key = str_split($key);
        $ciphertext = str_split($ciphertext);
    
        $plaintext = array();
        for ($i=0; $i < count($ciphertext); $i++) { 
            $plaintext[$i] = chr(((ord($ciphertext[$i])  + 26)  - (ord($key[$i % count($key)]) )) % 26 + 65 );
        }

        for ($i=0; $i < count($plaintext); $i++) { 
            echo $plaintext[$i];
        }
        return implode("",$plaintext);

    }

    function fileEncode()
    {
        $str = file_get_contents('vigenere.txt');//将整个文件内容读入到一个字符串中 
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
        
        $myfile = fopen("ciphertext.txt","w") or die("Unable to open file!");
        fwrite($myfile,$cipher);
        // $myfile = fopen("test.txt","w");
        // fwrite($myfile, "test");
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
        $plaintext = decode($comma_separated,$key);
        echo $plaintext;
        $myfile = fopen("vigenere.txt","w") or die("Unable to open file!");
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
        encode($_POST["plaintext"],$_POST["encodeKey"]);
    } elseif (isset($_POST["submit"]) && $_POST["submit"] == "decode"){
        echo "密文:\t";
        echo $_POST["ciphertext"];
        echo "<br><br>";
        echo "秘钥:\t";
        echo $_POST["decodeKey"];
        echo "<br><br>";
        echo "明文:<br>";;
        decode($_POST["ciphertext"],$_POST["decodeKey"]);
    } elseif (isset($_POST["submit"]) && $_POST["submit"] == "fileEncode") {
        fileEncode();
        echo "加密成功！";
    } elseif (isset($_POST["submit"]) && $_POST["submit"] == "fileDecode") {
        fileDecode();
        echo "解密成功！";
    }
?>
