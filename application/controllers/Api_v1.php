<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
require 'application/controllers/Api.php';

class Api_v1 extends Api
{
    function get_room_dev_list ($room_id,$model='')
    {
        $jsonRet = array();
        
        $devList = array();
        foreach(Constants::$devConfigList as $devConfig)
        {
            $dataList = $this->mp_xjdh->Get_Room_Devs($room_id, $devConfig[0]);
            if(count($dataList))
            {
                $devObj = new stdClass();
                $devObj->type = $devConfig[2];
                $devObj->name = $devConfig[1];
                if($devConfig[2] == "enviroment")
                {
                    $devObj->type = "ad";
                }else if($devConfig[2] == "smd_device")
                {
                    foreach($dataList as $dataObj)
                    {
                        $dataObj->data_id = $dataObj->device_no;
                    }
                }else if($devConfig[2] == "door")
                {
                    foreach($dataList as $dataObj)
                    {
                        $canOpen = false;
                        if($this->user->user_role == 'admin')
                        {
                            $canOpen = true;
                        }else if(in_array($this->user->user_role, array("city_admin","operator")))
                        {
                        	$userPrivilegeObj = User::Get_UserPrivilege($this->user->id);
                        	$areaPrivilegeArray = json_decode($userPrivilegeObj->area_privilege);
                        	if($dataObj->city_code == $this->user->city_code && in_array($dataObj->substation_id,$areaPrivilegeArray))
                        		$canOpen = true;                       	
//                             if($dataObj->city_code == $this->user->city_code)
//                                 $canOpen = true;
                        }else{
                            $duObj = $this->mp_xjdh->Get_DoorUser($dataObj->data_id, $this->user->id);
                            if(count($duObj) && $duObj->remote_control)
                                $canOpen = true;
                        }
                        $dataObj->can_open = $canOpen ? 1 : 0;
                    }
                }
                $devObj->devList = $dataList;
                array_push($devList, $devObj);        
            }
        }
        
        $jsonRet['ret'] = 0;
        $jsonRet['data'] = json_encode($devList);
        echo json_encode($jsonRet);
        return;
    }
}


