<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Util
{

    static function Is_date ($str)
    {
    	//函数将任何英文文本的日期时间描述解析为 Unix 时间戳
        $stamp = strtotime($str);
        //检测$stamp是否是数字 或数字字符串
        if (! is_numeric($stamp)) {
            return FALSE;
        }
        $month = date('m', $stamp);
        $day = date('d', $stamp);
        $year = date('Y', $stamp);
        //验证日期（ture or false）
        return checkdate($month, $day, $year);
    }

    static function decrypt ($input)
    {
        $len = strlen($input);
        $tmp = '';
        for ($i = 0; $i < $len; $i = $i + 2)
            $tmp = $tmp . chr(hexdec($input[$i] . $input[$i + 1]));
        $input = $tmp;
        $size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);
        $key = 'Hb3z5EUM';
        $td = mcrypt_module_open('des', '', 'cbc', '');
        mcrypt_generic_init($td, $key, $key);
        $data = mdecrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        // for($i=1;$i<20;$i++)
        // var_dump(ord($data[strlen($data)-$i]));
        
        // return $data;
        $pad = ord($data[strlen($data) - 1]);
        // echo "pad is ".$pad;
        return substr($data, 0, strlen($data) - $pad);
        /*
         * $hex="";
         * for($i=0;$i<strlen($data);$i++)
         * {
         * $val = dechex(ord($data[$i]));
         * if(strlen($val) == 1)
         * {
         * $hex .= "0".$val;
         * }else{
         * $hex .= $val;
         * }
         * }
         * return strtoupper($hex);
         */
    }

    static function encrypt ($input)
    {
        $size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);
        $input = Util::pkcs5_pad($input, $size);
        $key = 'Hb3z5EUM';
        $td = mcrypt_module_open('des', '', 'cbc', '');
        mcrypt_generic_init($td, $key, $key);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $hex = "";
        for ($i = 0; $i < strlen($data); $i ++) {
            $val = dechex(ord($data[$i]));
            if (strlen($val) == 1) {
                $hex .= "0" . $val;
            } else {
                $hex .= $val;
            }
        }
        return strtoupper($hex);
    }

    static function pkcs5_pad ($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public static function Build_Page_Base ($url)
    {
        $q = array();
        parse_str($_SERVER["QUERY_STRING"], $q);
        if (isset($q["per_page"])) {
            unset($q["per_page"]);
        }
        $url = site_url($url);
        if (! empty($q)) {
            $url .= "?" . http_build_query($q);
        } else {
            $url .= "?1=1";
        }
        return $url;
    }

    public static function ExtractOrderId ($orderNo)
    {
        $tstr = substr($orderNo, strlen($orderNo) - 6);
        return intval($tstr, 10);
    }

    public static function ExtractUserId ($id)
    {
        if (strncasecmp("SEDU", $id, 4) == 0) {
            return intval(substr($id, strlen($id) - 4));
        }
        return 0;
    }

    public function GetUserId ($id)
    {
        return "SEDU" . str_pad($id, 8, "0", STR_PAD_LEFT);
    }

    public static function cutArticle ($data, $cut = 0, $str = "....")
    {
        $data = strip_tags($data); // 去除html标记
        $pattern = "/&[a-zA-Z]+;/"; // 去除特殊符号
        $data = preg_replace($pattern, '', $data);
        if (! is_numeric($cut))
            return $data;
        if ($cut > 0)
            $data = mb_strimwidth($data, 0, $cut, $str);
        return $data;
    }

    public static function DisplayIdCard ($data, $headerLength, $tailLength)
    {
        $length = strlen($data);
        if ($length == 0)
            return "";
        return substr($data, 0, $headerLength) . ($length == 15 ? '******' : '*********') . substr($data, $length - $tailLength, $tailLength);
    }

    public static function quick_sort ($array, $direction = 'desc')
    {
        if (count($array) <= 1)
            return $array;
        $key = $array[0];
        $rightArray = array();
        $leftArray = array();
        for ($i = 1; $i < count($array); $i ++) {
            if ($direction == 'desc') {
                if (strtotime($array[$i]->added_datetime) <= strtotime($key->added_datetime)) {
                    $rightArray[] = $array[$i];
                } else {
                    $leftArray[] = $array[$i];
                }
            } else {
                if (strtotime($array[$i]->added_datetime) >= strtotime($key->added_datetime)) {
                    $rightArray[] = $array[$i];
                } else {
                    $leftArray[] = $array[$i];
                }
            }
        }
        $leftArray = Util::quick_sort($leftArray, $direction);
        $rightArray = Util::quick_sort($rightArray, $direction);
        return array_merge($leftArray, array($key), $rightArray);
    }

    public static function get_day ($month, $year)
    {
    	//月份的天数
        return cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }
}
?>
