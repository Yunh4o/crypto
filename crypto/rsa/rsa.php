<?php
    header("content-type:text/html;charset=utf-8");

    function encode($pt,$p,$q)
    {
        $n = $p * $q;
        // var_dump(yz($p,$q));
        $e = E($p,$q);
        echo "E:".$e."<br><br>";
        $ct = pow($pt,$e) % $n;
        echo  "CT:\t".$ct;
    }
    
    function decode($ct,$p,$q)
    {
        $n = $p * $q;
        $e = E($p,$q);
        $d = D($e,$p,$q);
        // echo $ct;
        // echo $d;
        // echo $n ;
        $xy = pow($ct,$d);
        $pt = $xy % $n;
        // $pt = $xy % $n;
        // $pt = intval(fmod(floatval($xy),floatval($n)));

        // $sh = $xy / $n ;
        // $pt = $xy - $sh * $n;

        return $pt;
    }
    
    
    function E($p,$q)
    {
        $yz = ($p-1) * ($q-1);
        $yzlist = array();
        for ($i=2; $i < $yz; $i++) { 
            if ($yz % $i == 0) {
                array_push($yzlist,$i);
            } 
        }
        $e = 2;
        while (in_array($e,$yzlist)) {
            $e++;
        }
        return $e;
    }

    function D($e,$p,$q)
    {
        $d = 1;
        while (!(($d * $e) % (($p-1) * ($q - 1)) == 1)) {
            $d++;
        }
        return $d;
    }

    if (isset($_POST["submit"]) && $_POST["submit"] == "encode") {
        echo "PT:\t";
        echo $_POST["PT"];
        echo "<br><br>";
        echo "P:\t";                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
        echo $_POST["P"];
        echo "<br><br>";
        echo "Q:\t";                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
        echo $_POST["Q"];
        echo "<br><br>";
        echo  encode($_POST["PT"],$_POST["P"],$_POST["Q"]);
    } elseif (isset($_POST["submit"]) && $_POST["submit"] == "decode"){
        echo "CT:\t";
        echo $_POST["CT"];
        echo "<br><br>";
        echo "D:\t";
        echo D(E($_POST["P"],$_POST["Q"]),$_POST["P"],$_POST["Q"]);
        echo "<br><br>";
        echo "PT:";;
        echo decode($_POST["CT"],$_POST["P"],$_POST["Q"]);
    }

?>