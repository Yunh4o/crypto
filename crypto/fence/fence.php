<?php
    header("content-type:text/html;charset=utf-8");
    function encode($plaintext)
    {
        $plaintext = str_split($plaintext);
        $plain1 = array();
        $plain2 = array();
        for ($i=0; $i < count($plaintext); $i++) { 
            if ($i % 2 == 0) {
                array_push($plain1,$plaintext[$i]);
            }else{
                array_push($plain2,$plaintext[$i]);
            }
        }

        // for ($i=0; $i < count($plain1); $i++) { 
        //     echo $plain1[$i];
        // }
        // for ($i=0; $i < count($plain2); $i++) { 
        //     echo $plain2[$i];
        // }
        $plaintext = implode("",$plain1).implode("",$plain2);
        return $plaintext;

    }

    function fileEncode()
    {
        $str = file_get_contents('fence.txt');//将整个文件内容读入到一个字符串中 
        $str_encoding = mb_convert_encoding($str, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');//转换字符集（编码） 
        $arr = explode("\r\n", $str_encoding);//转换成数组 
        //去除值中的空格 
        foreach ($arr as &$row) { $row = trim($row); } unset($row); 
        //得到后的数组 
        // var_dump($arr);
        $array = $arr;
        $comma_separated = implode("", $array);
        $cipher = encode($comma_separated);
        echo $cipher;
        $myfile = fopen("ciphertext.txt","w") or die("Unable to open file!");
        fwrite($myfile,$cipher);
        fclose($myfile);
    }

    function decode($ciphertext)
    {
        $ciphertext = str_split($ciphertext);
        $plain1 = array();
        $plain2 = array();
        for ($i=0; $i < count($ciphertext) / 2; $i++) { 
            array_push($plain1,$ciphertext[$i]);
        }
        for ($i=count($ciphertext) / 2 + 1; $i < count($ciphertext); $i++) { 
            array_push($plain2,$ciphertext[$i]);
        }
        $plain = "";
        if (count($plain1) == count($plain2)) {
            for ($i=0; $i < ount($plain1); $i++) { 
                // echo $plain1[$i];
                // echo $plain2[$i];
                $plain = $plain.$plain1[$i].$plain2[$i];
            }
        }else{
            for ($i=0; $i < count($plain2); $i++) { 
                // echo $plain1[$i];
                // echo $plain2[$i];
                $plain = $plain.$plain1[$i].$plain2[$i];
            }
            // echo $plain1[count($plain1)-1];
            $plain = $plain.$plain1[count($plain1)-1];
        }
        return $plain;
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
        $plaintext = decode($comma_separated);
        echo $plaintext;
        $myfile = fopen("fence.txt","w") or die("Unable to open file!");
        fwrite($myfile,$plaintext);
        fclose($myfile);
    }

    if (isset($_POST["submit"]) && $_POST["submit"] == "encode") {
        echo "明文:\t";
        echo $_POST["plaintext"];
        echo "<br><br>";
        echo "密文:<br>";
        echo encode($_POST["plaintext"]);
    } elseif (isset($_POST["submit"]) && $_POST["submit"] == "decode"){
        echo "密文:\t";
        echo $_POST["ciphertext"];
        echo "<br><br>";
        echo "明文:<br>";
        echo decode($_POST["ciphertext"]);
    } elseif (isset($_POST["submit"]) && $_POST["submit"] == "fileEncode") {
        fileEncode();
        echo "加密成功！";
    } elseif (isset($_POST["submit"]) && $_POST["submit"] == "fileDecode") {
        fileDecode();
        echo "解密成功！";
    }
?>
