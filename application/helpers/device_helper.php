<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Device
{

    public static function getRoomDeviceList ($roomId, $model, $userObj)
    {
        $CI = & get_instance();
        $devList = array();
        if (! $model || $model == 'temperature' || $model == 'humid' || $model == 'smoke' || $model == 'water') {
            $htList = $CI->mp_xjdh->Get_Room_Devices($roomId, array('temperature','humid','smoke','water'));
            if (count($htList)) {
                $devObj = new stdClass();
                $devObj->type = 'ad';
                $devObj->name = '机房环境';
                $devObj->devList = $htList;
                array_push($devList, $devObj);
            }
        }
        
        if (! $model || $model == 'battery_24' || $model == 'battery_32' || $model == 'battery24_voltage') {
            $bat24List = $CI->mp_xjdh->Get_Room_Devices($roomId, array('battery_24'));
            $bat32List = $CI->mp_xjdh->Get_Room_Devices($roomId, array('battery_32'));
            $bat24Listvoltage = $CI->mp_xjdh->Get_Room_Devices($roomId, array('battery24_voltage'));
            if (count($bat24List) || count($bat32List) || count($bat24Listvoltage)) {
                $devObj = new stdClass();
                $devObj->type = 'bat';
                $devObj->name = '电池组';
                $devObj->devList = array_merge($bat24List, $bat32List,$bat24Listvoltage);
                array_push($devList, $devObj);
            }
        }
        
        if (! $model || $model == 'vpdu' || $model == 'aeg-ms10se' || $model == 'aeg-ms10m') {
        	$pduList = $CI->mp_xjdh->Get_Room_Devices($roomId,  array('vpdu','aeg-ms10se','aeg-ms10m'));
        	if (count($pduList)) {
                $devObj = new stdClass();
                $devObj->type = 'pdu';
                $devObj->name = '低压配电';
                $devObj->devList = $pduList;
                array_push($devList, $devObj);
        	}
        }
        
        if (! $model || $model == 'imem_12') {
            $imem12List = $CI->mp_xjdh->Get_Room_Devices($roomId,'imem_12');
            $power_302aList = $CI->mp_xjdh->Get_Room_Devices($roomId,'power_302a');
            if (count($imem12List) || count($power_302aList)) {
                $devObj = new stdClass();
                $devObj->type = 'powermeterapp';
                $devObj->name = '智能电表';
                $devObj->devList = array_merge($imem12List, $power_302aList);
                array_push($devList, $devObj);
            }
        }
        
        if(!$model || $model == 'aeg'){
        	$aegMS10SEList=$CI->mp_xjdh->Get_Room_Devices($roomId,  array('aeg-ms10se','aeg-ms10m'));
        	if (count($aegMS10SEList)){
        		$devObj = new stdClass();
        		$devObj->type ='aeg';
        		$devObj->name ='AEG低压设备';
        		$devObj->devList = $aegMS10SEList;
        		array_push($devList, $devObj);
        	}
        }
        
        if (! $model || $model == 'fresh_air') {
            $freshAirList = $CI->mp_xjdh->Get_FreshAirList($roomId);
            if (count($freshAirList)) {
                $devObj = new stdClass();
                $devObj->type = 'fresh-air';
                $devObj->name = '新风';
                $devObj->devList = $freshAirList;
                array_push($devList, $devObj);
            }
        }
        if (! $model || stripos($model, "psma") !== false || stripos($model, "m810g") !== false ||stripos($model, "smu06c") !== false || $model == 'sps') {
            $spsList = $CI->mp_xjdh->Get_SwitchingPowerSupplyList($roomId);
            if (count($spsList)) {
                $devObj = new stdClass();
                $devObj->type = 'sps';
                $devObj->name = '开关电源';
                $devObj->devList = $spsList;
                array_push($devList, $devObj);
            }
        }
        if (! $model || $model == 'liebert-ups') {
            $liebertUPSList = $CI->mp_xjdh->Get_LiebertUPSList($roomId);
            if (count($liebertUPSList)) {
                $devObj = new stdClass();
                $devObj->type = 'liebert-ups';
                $devObj->name = 'UPS电源';
                $devObj->devList = $liebertUPSList;
                array_push($devList, $devObj);
            }
        }
        
        if(!$model || $model == 'liebert-pex'){
        	$liebertPEXList = $CI->mp_xjdh->Get_LiebertPEXList($roomId);
        	if(count($liebertPEXList)){
        		$devObj = new stdClass();
        		$devObj->type = 'liebert-pex';
        		$devObj->name = 'PEX空调';
        		$devObj->devList = $liebertPEXList;
        		array_push($devList, $devObj);
        	}
        }
        
        if (! $model || $model == 'motor_battery') {
            $motorBatList = $CI->mp_xjdh->Get_Room_Devices($roomId, 'motor_battery');
            if (count($motorBatList)) {
                $devObj = new stdClass();
                $devObj->type = 'motor_battery';
                $devObj->name = '油机启动电池';
                $devObj->devList = $motorBatList;
                array_push($devList, $devObj);
            }
        }
        /*if(empty($mode) || $model == "door")
        {
            $dataList = $CI->mp_xjdh->Get_Room_Devices($roomId, "DoorXJL");
            if (count($dataList)) {
                $devObj = new stdClass();
                $devObj->type = 'door';
                $devObj->name = '门禁系统';
                foreach($dataList as $dataObj)
                {
                    $canOpen = false;
                    if($userObj->user_role == 'admin')
                    {
                        $canOpen = true;
                    }else if(in_array($userObj->user_role, array("city_admin","operator")))
                    {
                        if($dataObj->city_code == $userObj->city_code)
                            $canOpen = true;
                    }else{
                        $duObj = $this->mp_xjdh->Get_DoorUser($dataObj->data_id, $userObj->id);
                        if(count($duObj) && $duObj->remote_control)
                            $canOpen = true;
                    }
                    $dataObj->can_open = $canOpen ? 1 : 0;
                }
                $devObj->devList = $dataList;
                array_push($devList, $devObj);
            }
        }*/
        return $devList;
    }
}
