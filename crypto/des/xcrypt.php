<?php
class Xcrypt{  
  
  private $mcrypt;  
  private $key;  
  private $mode;  
  private $blocksize;  
   
  public function __construct($key){  
    $this->mcrypt = MCRYPT_DES;  
    $this->key = $key;  
    $this->mode = MCRYPT_MODE_ECB;  
  }  
 
  public function encrypt($str){  
    $str = $this->_pkcs5Pad($str);  
    $result = mcrypt_encrypt($this->mcrypt, $this->key, $str, $this->mode);  
    $ret = base64_encode($result);  
    return $ret;  
  }  
  
  public function decrypt($str){    
    $ret = false;  
 
    $str = base64_decode($str);    
  
    if ($str !== false){  
        $ret = mcrypt_decrypt($this->mcrypt, $this->key, $str, $this->mode);   
        if ($this->mcrypt == MCRYPT_DES) 
            $ret = $this->_pkcs5Unpad($ret);  
    }  
  
    return $ret;   
  }   
  
  function fileEncode()
  {
      $str = file_get_contents('des.txt');//将整个文件内容读入到一个字符串中 
      $str_encoding = mb_convert_encoding($str, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');//转换字符集（编码） 
      $arr = explode("\r\n", $str_encoding);//转换成数组 
      //去除值中的空格 
      foreach ($arr as &$row) { $row = trim($row); } unset($row); 
      //得到后的数组 
      // var_dump($arr);
      $array = $arr;
      $comma_separated = implode("", $array);
      $cipher = $this->encrypt($comma_separated);
      echo $cipher;
      $myfile = fopen("ciphertext.txt","w") or die("Unable to open file!");
      fwrite($myfile,$cipher);
      fclose($myfile);
  }


  private function _pkcs5Pad($text){  
    $this->blocksize = mcrypt_get_block_size($this->mcrypt, $this->mode);   
    $pad = $this->blocksize - (strlen($text) % $this->blocksize);  
    return $text . str_repeat(chr($pad), $pad);  
  }  
  
  private function _pkcs5Unpad($text){  
    $pad = ord($text{strlen($text) - 1});  
    if ($pad > strlen($text)) return false;  
    if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;  
    $ret = substr($text, 0, -1 * $pad);  
    return $ret;  
  }   
  
}  

?>