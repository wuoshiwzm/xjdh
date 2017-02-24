<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 2017/2/22
 * Time: 15:01
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Ltest{
    function test($data)
    {
        var_dump($data);
        die;
    }
}