<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 2017/2/21
 * Time: 10:39
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 登录权限等
 */
class Author
{

    /**
     * @param $type 过滤权限的类型
     * 1: role 如'admin','noc';
     * 2: city 如
     * 3: role & city 如['role'=>[1,2,3],'city'=>['xinjiang','tulufan']]
     * 4: check 如 1:'check_first' 2:'check_final'
     * @param null $roleApply
     * @param null $roleAllow
     * 对应type的权限允许范围 可以是数组或字符串
     * @return bool
     * 权限过滤
     */
    function allowRole($type, $roleAllow = null, $roleApply = null)
    {

        //1: role
        if ($type == 1) {
            $role = $_SESSION['XJTELEDH_USERROLE'];
            if (is_null($roleAllow)) {
                return true;
            }
            if (is_array($roleAllow) && in_array($roleApply, $roleAllow)) {
                return true;
            }
            if (is_string($roleAllow) && $role == $roleAllow) {
                return true;
            }
            return false;
        }

        //2: city
        if ($type == 2) {
            $city = $_SESSION['XJTELEDH_USERROLE'];
        }

        //3:role + city
        if ($type == 3) {

        }

        //4:check 审核工艺 / 调试设备
        if ($type == 4) {
            //$check = $_SESSION['XJTELEDH_CHECK'];
            if (is_array($roleAllow) && in_array($roleApply, $roleAllow)) {
                return true;
            }
            if (is_numeric($roleAllow) && ($roleApply == $roleAllow)) {
                return true;
            }
            return false;
        }

        //4:check 安排督导
        if ($type == 5) {
            if (is_array($roleAllow) && in_array($roleApply, $roleAllow)) {
                return true;
            }
            if (is_numeric($roleAllow) && ($roleApply == $roleAllow)) {
                return true;
            }
            return false;
        }
       return false;
    }

}