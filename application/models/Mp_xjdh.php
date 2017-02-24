<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class MP_Xjdh extends CI_Model
{

    function __construct ()
    {
        parent::__construct();
    }

    function Get_Top_Alarm_By_DataId($data_id, $smd_device_no)
    {
    	$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('alert.data_id', $data_id);
    	$dbObj->where('alert.status','unresolved');
    	$dbObj->select_min("alert.level");
    	$row =  $dbObj->get('alert')->row();
    	$devLevel = 0;
    	if($row->level == NULL)
    		$devLevel = 0;
    	else
    		$devLevel = $row->level;
    	//smd device
    	$dbObj->where('alert.data_id', $smd_device_no);
    	$dbObj->where('alert.status','unresolved');
    	$dbObj->select_min("alert.level");
    	$row =  $dbObj->get('alert')->row();
    	$smdLevel = 0;
    	if($row->level == NULL)
    		$smdLevel = 0;
    	else
    		$smdLevel = $row->level;
    	if($devLevel == 0)
    	{
    		return $smdLevel;
    	}else if($smdLevel == 0)
    	{
    		return $devLevel;
    	}else{
    		return $devLevel < $smdLevel ? $devLevel : $smdLevel;
    	}
    }
    function Get_Top_Alarm_By_Station($stationId)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('device', 'device.data_id=alert.data_id');
    	$dbObj->join('room', 'room.id=device.room_id');
    	$dbObj->join('substation', 'substation.id=room.substation_id');
        $dbObj->where('substation.id', $stationId);
    	$dbObj->where('alert.status','unresolved');
    	$dbObj->select_min("alert.level");
    	$row = $dbObj->get('alert')->row();
    	if($row->level == NULL)
    		return 0;
    	else
    		return $row->level;
    }
    function Get_AiDi_Signal_History_By_Date($data_id,$date)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('device','device_history.smd_device_no=device.smd_device_no');
    	$dbObj->where('device.data_id',$data_id);
    	$dbObj->where('device_history.save_datetime >= ', $date.' 00:00:00');
    	$dbObj->where('device_history.save_datetime <= ', $date.' 23:59:59');
    	return $dbObj->get('device_history')->row();
    }
    function Get_Bma24_History_By_Date($data_id, $date)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('data_id', $data_id);
	$dbObj->where('voltage >', 0);
    	$dbObj->where('update_datetime >= ', $date.' 00:00:00');
    	$dbObj->where('update_datetime <= ', $date.' 23:59:59');
    	$row = $dbObj->get('device_bma24_history')->row();
	echo $dbObj->last_query();
	return $row;
    }
    function Get_Bma32_History_By_Date($data_id, $date)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('data_id', $data_id);
    	$dbObj->where('update_datetime >= ', $date.' 00:00:00');
    	$dbObj->where('update_datetime <= ', $date.' 23:59:59');
    	return $dbObj->get('device_bma32_history')->row();
    }
    
    //lsh adding by 2015.11.20
    function Get_Imem12_History_By_Date($data_id, $date)
    {
    	$dbObj = $this->load->database('default',TRUE);
    	$dbObj->where('data_id',$data_id);
    	$dbObj->where('update_datetime >= ',$date.'00:00:00');
    	$dbObj->where('update_datetime <= ',$date.'23:59:59');
    	return $dbObj->get('device_imem12_history')->row();
    }
    function Get_PsmaDc_History_By_Date($data_id, $date)
    {
    	$dbObj = $this->load->database('default',TRUE);
    	$dbObj->where('data_id',$data_id);
    	$dbObj->where('update_datetime >= ',$date.'00:00:00');
    	$dbObj->where('update_datetime <= ',$date.'23:59:59');
    	return $dbObj->get('device_psma_history')->row();
    }
    function Get_PsmaRc_History_By_Date($data_id, $date)
    {
    	$dbObj = $this->load->database('default',TRUE);
    	$dbObj->where('data_id',$data_id);
    	$dbObj->where('update_datetime >= ',$date.'00:00:00');
    	$dbObj->where('update_datetime <= ',$date.'23:59:59');
    	return $dbObj->get('device_psma_history')->row();
    }
    function Get_M810gDc_History_By_Date($data_id,$date)
    {
    	$dbObj = $this->load->database('default',TRUE);
    	$dbObj->where('data_id',$data_id);
    	$dbObj->where('update_datetime >= ',$date.'00:00:00');
    	$dbObj->where('update_datetime <= ',$date.'23:59:59');
    	return $dbObj->get('device_m810g_history')->row();
    }
    function Get_M810gRc_History_By_Date($data_id,$date)
    {
    	$dbObj = $this->load->database('default',TRUE);
    	$dbObj->where('data_id',$data_id);
    	$dbObj->where('update_datetime >= ',$date.'00:00:00');
    	$dbObj->where('update_datetime <= ',$date.'23:59:59');
    	return $dbObj->get('device_m810g_history')->row();
    }
    
    function Get_LatestUpdateInfo ()
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->order_by('update_datetime', 'desc');
        return $dbObj->get('app_update')->row();
    }

    function Get_AppUpdateList ()
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->order_by('update_datetime', 'desc');
        return $dbObj->get('app_update')->result();
    }

    function Save_AppUpdate ($version_code, $version_name, $download_url, $update_log)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->set('version_code', $version_code);
        $dbObj->set('version_name', $version_name);
        $dbObj->set('download_url', $download_url);
        $dbObj->set('update_log', $update_log);
        $dbObj->set('update_datetime', 'now()', FALSE);
        return $dbObj->insert('app_update');
    }

    function RT_Set_Device_Threshold ($data_id, $threshold_setting)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('data_id', $data_id);
        $dbObj->set('threshold_setting', $threshold_setting);
        $dbObj->update('device');
        return true;
    }
    
    function RT_Set_editPrTempAlarmJS($gdevice, $settingStr){
    	$dbObj = $this->load->database('default', TRUE);
    	  foreach ($gdevice as $arridObj){
    	  	$dbObj->where('id', $arridObj);
    	  	$dbObj->set('threshold_setting', $settingStr);
    	  	$dbObj->update('device');
    	  }
    	  return true;
    }
    
    function Batch_Set_Device_Threshold ($idArr, $threshold_setting)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where_in('id', $idArr);
        $dbObj->set('threshold_setting', $threshold_setting);
        $dbObj->update('device');
        return true;
    }

    function Save_Device_Pi_Setting ($type, $piGlobal, $piScript, $nameArr, $labelArr, $alertNameArr, $alertLabelArr, $signalNameArr, $signalIdArr, $alertLevelArr, 
            $alertMsgArr)
    {
        $dbObj = $this->load->database('default', TRUE);
        $piObj = $dbObj->get_where('device_pi_setting', array('type' => $type))->row();
        
        $dbObj->set('type', $type);
        $dbObj->set('global', $piGlobal);
        $dbObj->set('script', $piScript);
        $varArr = array();
        if(is_array($nameArr))
        {
	        foreach ($nameArr as $index => $name) {
	            $name = trim($nameArr[$index]);
	            $label = trim($labelArr[$index]);
	            if (! empty($name) && ! empty($label)) {
	                $varClass = new stdClass();
	                $varClass->name = $name;
	                $varClass->label = $label;
	                array_push($varArr, $varClass);
	            }
	        }	        
        }
        $dbObj->set("vars", json_encode($varArr));
        
        $alertArr = array();
        if(is_array($alertNameArr))
        {
	        foreach ($alertNameArr as $index => $alertName) {
	            $alertName = trim($alertName);
	            $alertlabel = trim($alertLabelArr[$index]);
	            $alertLevel = $alertLevelArr[$index];
	            $alertMsg = $alertMsgArr[$index];
	            $signalName = $signalNameArr[$index];
	            $signalId = $signalIdArr[$index];
	            
	            if (! empty($alertName) && ! empty($alertlabel) && ! empty($alertLevel) && ! empty($alertMsg)) {
	                $varClass = new stdClass();
	                $varClass->name = $alertName;
	                $varClass->label = $alertlabel;
	                $varClass->level = $alertLevel;
	                $varClass->signal_name = $signalName;
	                $varClass->signal_id = $signalId;
	                $varClass->msg = $alertMsg;
	                array_push($alertArr, $varClass);
	            }
	        }
        }
        $dbObj->set("alert", json_encode($alertArr));
        if (count($piObj)) {
            $dbObj->update('device_pi_setting');
            return $id;
        } else {
            $dbObj->insert('device_pi_setting');
        }
    }

    function Get_Device_Pi_Setting ($mode)
    {
        $dbObj = $this->load->database('default', TRUE);
        return $dbObj->get_where("device_pi_setting", array("type" => $mode))->row();
    }

    
    function Get_Device_Count ($cityCode = false, $countyCode = false, $substationId = false, $roomId = false, $smd_device_no = false, $devModel = false, 
    		$devgroup = false, $active = 'all', $devName = false, $dataId = false, $Identifier = false, $keyWord = false, $selCity = false, $gCounty = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->join('room', 'room.id=device.room_id','left');
        $dbObj->join('substation', 'substation.id=room.substation_id','left');
        $dbObj->join('smd_device', 'smd_device.device_no=device.smd_device_no','left');
  
        if ($cityCode)
            $dbObj->where('substation.city_code', $cityCode);
        if ($countyCode)
            $dbObj->where('substation.county_code', $countyCode);
        if ($substationId)
            $dbObj->where('substation.id', $substationId);
        if ($roomId)
            $dbObj->where('room.id', $roomId);
        if ($smd_device_no)
            $dbObj->where('smd_device.device_no', $smd_device_no);
        if ($devModel)
            $dbObj->where_in('device.model', $devModel);
        if ($devgroup)
        	$dbObj->like('device.dev_group', $devgroup);
        if ($active == 'active' || $active == 'deactive')
            $dbObj->where('device.active', $active == 'active');
        if (strlen($devName))
            $dbObj->like('device.name', $devName);
        if ($dataId)
        	$dbObj->where('device.data_id', $dataId);
        if($selCity)
        	$dbObj->where('city_code',$selCity);
        if ($substationId == null && $Identifier == 'DoorXJL'){
        	$arr = array(); 	
        foreach (json_decode($_SESSION['SUBLIST']) as $subId){
        	array_push($arr, $subId->id);
           }
           if($arr)
          $dbObj->where_in('substation.id', $arr);
        }
	    if ($keyWord){
	    	foreach($gCounty as $key => $val){
	    		foreach($val as $k => $v){
	    			if($v == $keyWord){
	    				$keyWord = $k;
	    			}
	    		}
	    	}
	        $dbObj->group_start();
	        $dbObj->like('substation.name', $keyWord); 
	        $dbObj->or_like('room.name', $keyWord);
	        $dbObj->or_like('smd_device.name', $keyWord);
	        $dbObj->or_like('substation.county_code', $keyWord);
	        $dbObj->or_like('Stationcode', $keyWord);
	        $dbObj->group_end();	
	        } 
        return $dbObj->count_all_results("device");
    }
    function Get_Device_List ($cityCode = false, $countyCode = false,$substationId = false, $roomId = false, $smd_device_no = false, $devModel = false, $devgroup = false, $active = null, 
    		$devName = false, $offset = 0, $size = 20, $dataId = false, $Identifier = false, $keyWord = false, $selCity = false, $gCounty = false)
    {
    	
    	$dbObj = $this->load->database('default', TRUE);
        $dbObj->join('room', 'room.id=device.room_id','left');
        $dbObj->join('substation', 'substation.id=room.substation_id','left');
        $dbObj->join('smd_device', 'smd_device.device_no=device.smd_device_no','left');
     
        if ($cityCode)
            $dbObj->where('substation.city_code', $cityCode);
        if ($countyCode)
            $dbObj->where('substation.county_code', $countyCode);
        if ($substationId)
            $dbObj->where('substation.id', $substationId);
        if ($roomId)
            $dbObj->where('room.id', $roomId);
        if ($smd_device_no)
            $dbObj->where('smd_device.device_no', $smd_device_no);
        if ($devModel)
            $dbObj->where_in('device.model', $devModel);
        if ($devgroup)
        	$dbObj->like('device.dev_group', $devgroup);
        if ($active == 'active' || $active == 'deactive')
            $dbObj->where('device.active', $active == 'active');
        if (strlen($devName))
        	$dbObj->like('device.name', $devName);  
        if ($dataId)
        	$dbObj->where('device.data_id', $dataId);  
        if($selCity)
        	$dbObj->where('city_code',$selCity);
        if ($keyWord){
        	foreach($gCounty as $key => $val){
        		foreach($val as $k => $v){
        			if($v == $keyWord){
        				$keyWord = $k;
        			}
        		}
        	}
        	$dbObj->group_start();
        	$dbObj->like('substation.name', $keyWord); 
        	$dbObj->or_like('room.name', $keyWord);
            $dbObj->or_like('smd_device.name', $keyWord);
            $dbObj->or_like('substation.county_code', $keyWord);
            $dbObj->or_like('Stationcode', $keyWord);
            $dbObj->group_end();
        }
        
        
        $dbObj->select('device.*,room.name as room_name,room.id as roomId,substation.city_code,substation.county_code,substation.Stationcode,smd_device.name as smd_device_name,smd_device.ip,substation.name as suname');
	if($size != -1){
            $ret = $dbObj->get('device', $size, $offset)->result();
            //echo $dbObj->last_query();
            return $ret;
	}else{
	    return $dbObj->get('device')->result();
	}
        
    }

    function Get_SMD_Device_Count ($cityCode = false, $countyCode = false, $substationId = false, $ip = '', $name = '', $active = array(), $selCity = false, $keyWord = false, $gCounty = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->join('room', 'room.id=smd_device.room_id');
        $dbObj->join('substation', 'substation.id=room.substation_id');
        if ($cityCode)
            $dbObj->where('substation.city_code', $cityCode);
        if ($countyCode)
            $dbObj->where('substation.county_code', $countyCode);
        if ($substationId)
            $dbObj->where('substation.id', $substationId);
        if (strlen($ip))
            $dbObj->like('smd_device.ip', $ip);
        if (strlen($name))
            $dbObj->like('smd_device.name', $name);
        if ($active)
        	$dbObj->where_in('smd_device.active', $active);
        if ($selCity)
        	$dbObj->where('city_code',$selCity);
        if ($keyWord){
        	foreach($gCounty as $key => $val){
        		foreach($val as $k => $v){
        			if($v == $keyWord){
        				$keyWord = $k;
        			}
        		}
        	}
        	$dbObj->group_start();
        	$dbObj->like('substation.name', $keyWord);
        	$dbObj->or_like('room.name', $keyWord);
        	$dbObj->or_like('smd_device.name', $keyWord);
        	$dbObj->or_like('substation.county_code', $keyWord);
        	$dbObj->or_like('Stationcode', $keyWord);
        	$dbObj->group_end();
        }
        return $dbObj->count_all_results("smd_device");
    }

    function Get_SMD_Device_List ($cityCode = false, $countyCode = false, $substationId = false, $ip = '', $name = '', $active = array('0','1'), $offset = 0, $size = 20, $selCity = false, $keyWord = false, $gCounty = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        //$dbObj->join('device', 'device.room_id=smd_device.room_id');
        $dbObj->join('room', 'room.id=smd_device.room_id');
        $dbObj->join('substation', 'substation.id=room.substation_id');
        if ($cityCode)
            $dbObj->where('substation.city_code', $cityCode);
        if ($countyCode)
            $dbObj->where('substation.county_code', $countyCode);
        if ($substationId)
            $dbObj->where('substation.id', $substationId);
        if (strlen($ip))
            $dbObj->like('smd_device.ip', $ip);
        if (strlen($name))
            $dbObj->like('smd_device.name', $name);
        if ($active)
        	$dbObj->where_in('smd_device.active', $active);
        if ($selCity)
        	$dbObj->where('city_code',$selCity);
        if ($keyWord){
        	foreach($gCounty as $key => $val){
        		foreach($val as $k => $v){
        			if($v == $keyWord){
        				$keyWord = $k;
        			}
        		}
        	}
        	$dbObj->group_start();
        	$dbObj->like('substation.name', $keyWord);
        	$dbObj->or_like('room.name', $keyWord);
        	$dbObj->or_like('smd_device.name', $keyWord);
        	$dbObj->or_like('substation.county_code', $keyWord);
        	$dbObj->or_like('Stationcode', $keyWord);
        	$dbObj->group_end();
        }
        
        $dbObj->select('smd_device.*,room.name as room_name,room.code as room_code,substation.name as substation_name,substation.city_code,substation.county_code,substation.Stationcode');
        $result = $dbObj->get('smd_device', $size, $offset)->result();
        // echo $dbObj->last_query();
        return $result;
    }
	function Get_WsAlarmCount($cityCode = false, $stationId = false, $status='', $level=0, $startDatetime = false, $endDatetime = false)
	{
		$dbObj = $this->load->database('default', TRUE);
		if ($level)
			$dbObj->where('level', $level);
		if($cityCode)
			$dbObj->where('substation.city_code', $cityCode);
		if($stationId)
            		if (is_array($stationId))
                		$dbObj->where_in('substation.id', $stationId);
		        else
				$dbObj->where('substation.id', $stationId);
		if ($startDatetime)
			if(strlen($startDatetime) > 10)
				$dbObj->where('added_datetime >', $startDatetime);
			else
				$dbObj->where('added_datetime >', $startDatetime . ' 00:00:00');
		if ($endDatetime)
			if(strlen($endDatetime) > 10)
				$dbObj->where('added_datetime <', $endDatetime);
			else
				$dbObj->where('added_datetime <', $endDatetime . ' 23:59:59');
		$dbObj->join('room', 'room.id=alert_realtime.room_id');
		$dbObj->join('substation', 'substation.id=room.substation_id');
		if($status == "unresolved")
		{
			$dbObj->where('status','unresolved');
		}else{
			$dbObj->where('restore_id =',0);
		}
		$count = $dbObj->count_all_results('alert_realtime');
		log_message("debug","sql_count ".$dbObj->last_query());
		return $count;
	}
	function Get_WsAlarmList($cityCode = false, $stationId = false,$status='',$level=0, $startDatetime = false, $endDatetime = false, $offset=0, $pageSize=20)
	{
		$dbObj = $this->load->database('default', TRUE);
		if($cityCode)
			$dbObj->where('substation.city_code', $cityCode);
		if($stationId)
            if (is_array($stationId))
                $dbObj->where_in('substation.id', $stationId);
		    else
				$dbObj->where('substation.id', $stationId);
		if ($startDatetime)
			if(strlen($startDatetime) > 10)
				$dbObj->where('added_datetime >', $startDatetime);
			else
				$dbObj->where('added_datetime >', $startDatetime . ' 00:00:00');
		if ($endDatetime)
			if(strlen($endDatetime) > 10)
				$dbObj->where('added_datetime <', $endDatetime);
			else
				$dbObj->where('added_datetime <', $endDatetime . ' 23:59:59');
		//$dbObj->join('alert_view', 'alert.data_id=alert_view.data_id');
		$dbObj->join('room', 'room.id=alert_realtime.room_id');
		$dbObj->join('substation', 'substation.id=room.substation_id');
		if($status == "unresolved")
		{
			$dbObj->where('status','unresolved');
		}else{
			$dbObj->where('restore_id =',0);
		}
		$dbObj->order_by('added_datetime', 'desc');
        $dbObj->select(
                'alert_realtime.dev_model,alert_realtime.dev_name,room.name as room_name,room.location as room_location,room.code as room_code,substation.city_code,substation.county_code,substation.name as substation_name');
        //$dbObj->cache_on();
        if($pageSize == -1 || $offset == -1)
		{
	        $results = $dbObj->get('alert_realtime')->result();
	     	//log_message("debug","sql_count................ ".$dbObj->last_query());
	        return $results;
		}else{
	        $results = $dbObj->get('alert_realtime', $pageSize, $offset)->result();
	     	//log_message("debug","sql_count................ ".$dbObj->last_query());
	        return $results;
		}
    }
    
    function importexcel($dev_type,$var_name,$var_label,$setting)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->set('dev_type', $dev_type);
    	$dbObj->set('var_name', $var_name);
    	$dbObj->set('setting', $setting);
    	$dbObj->set('var_label', $var_label);
    	return $dbObj->insert('device_threshold');
    }
    
    function Get_AlarmCount ($cityCode, $countyCode, $substationId, $roomId, $devModelArray, 
    		                $level, $statusArr, $startDatetime, $endDatetime, $word, $selSignalName, $userLevel, $substationIdArray)
    {
        $dbObj = $this->load->database('default', TRUE);
        if (!empty($cityCode)) {
            $dbObj->where('substation.city_code', $cityCode);
        }
        if (!empty($countyCode)) {
            $dbObj->where('substation.county_code', $countyCode);
        }
        if ($substationId) {
            $dbObj->where('substation.id', $substationId);
        }
        if( $roomId) {
            $dbObj->where('alert_realtime.room_id', $roomId);
        }
        if(count($devModelArray)){
            $dbObj->where_in("dev_model", $devModelArray);
        }
        if ($level){
            $dbObj->where('level', $level);
        }
        if(count($statusArr))
        {
            $dbObj->group_start();
            if(in_array('unresolved', $statusArr)){
                $dbObj->or_where('alert_realtime.status', 'unresolved');
            }
            if(in_array('solved', $statusArr)){
                $dbObj->or_group_start();
                $dbObj->where('alert_realtime.status', 'solved');
                $dbObj->where('confirm_datetime','0000-00-00 00:00:00');
                $dbObj->group_end();
            }
            if(in_array('confirmed', $statusArr))
            {
                $dbObj->or_group_start();
                $dbObj->where('alert_realtime.status', 'solved');
                $dbObj->where('confirm_datetime <>','0000-00-00 00:00:00');
                $dbObj->group_end();
            }
            $dbObj->group_end();
        }
        if (!empty($startDatetime)) {
            $dbObj->where('added_datetime >', $startDatetime);
        }
        if (!empty($endDatetime)){
            $dbObj->where('added_datetime <', $endDatetime . ' 23:59:59');
        }
        if($selSignalName) {
            $dbObj->where('alert_realtime.signal_name', $selSignalName);
        }
        if($userLevel == 3)
        {
            $dbObj->where_in('substation.id', $substationIdArray);
        }
        $dbObj->join('room', 'room.id=alert_realtime.room_id');
        $dbObj->join('substation', 'substation.id=room.substation_id');
	    if (strlen($word)) {
        	$dbObj->group_start();
            $dbObj->like('alert_realtime.dev_name', $word);
            $dbObj->or_like('alert_realtime.signal_name', $word);
            $dbObj->or_like('alert_realtime.signal_id', $word);
            $dbObj->or_like('substation.name', $word);
            $dbObj->or_like('room.name', $word);
            $dbObj->or_like('Stationcode', $word);
            $dbObj->group_end();              
        }
        $count = $dbObj->count_all_results('alert_realtime');
		//log_message("debug","sql_count ".$dbObj->last_query());
        return $count;
    }
    
    function Get_AlarmList ($cityCode, $countyCode, $substationId, $roomId, $devModelArray, 
    		                $level, $statusArr, $startDatetime, $endDatetime, $word, $selSignalName, $userLevel, $substationIdArray, $offset = 0, $limit = 20, $lastId = -1)
    {
        $dbObj = $this->load->database('default', TRUE);
        if (!empty($cityCode)) {
            $dbObj->where('substation.city_code', $cityCode);
        }
        if (!empty($countyCode)) {
            $dbObj->where('substation.county_code', $countyCode);
        }
        if ($substationId) {
            $dbObj->where('substation.id', $substationId);
        }
        if( $roomId) {
            $dbObj->where('alert_realtime.room_id', $roomId);
        }
        if(count($devModelArray)){
            $dbObj->where_in("dev_model", $devModelArray);
        }
        if ($level){
            $dbObj->where('level', $level);
        }
        if(count($statusArr))
        {
            $dbObj->group_start();
            if(in_array('unresolved', $statusArr)){
                $dbObj->or_where('alert_realtime.status', 'unresolved');
            }
            if(in_array('solved', $statusArr)){
                $dbObj->or_group_start();
                $dbObj->where('alert_realtime.status', 'solved');
                $dbObj->where('confirm_datetime','0000-00-00 00:00:00');
                $dbObj->group_end();
            }
            if(in_array('confirmed', $statusArr))
            {
                $dbObj->or_group_start();
                $dbObj->where('alert_realtime.status', 'solved');
                $dbObj->where('confirm_datetime <>','0000-00-00 00:00:00');
                $dbObj->group_end();
            }
            $dbObj->group_end();
        }
        if (!empty($startDatetime)) {
            $dbObj->where('added_datetime >', $startDatetime);
        }
        if (!empty($endDatetime)){
            $dbObj->where('added_datetime <', $endDatetime . ' 23:59:59');
        }
        if($selSignalName) {
            $dbObj->where('alert_realtime.signal_name', $selSignalName);
        }
        if($userLevel == 3)
        {
            $dbObj->where_in('substation.id', $substationIdArray);
        }
        $dbObj->join('room', 'room.id=alert_realtime.room_id');
        $dbObj->join('substation', 'substation.id=room.substation_id');
	    if (strlen($word)) {
        	$dbObj->group_start();
            $dbObj->like('alert_realtime.dev_name', $word);
            $dbObj->or_like('alert_realtime.signal_name', $word);
            $dbObj->or_like('alert_realtime.signal_id', $word);
            $dbObj->or_like('substation.name', $word);
            $dbObj->or_like('room.name', $word);
            $dbObj->or_like('Stationcode', $word);
            $dbObj->group_end();              
        }
        if($lastId != -1) {
            $dbObj->where('alert_realtime.id >', $lastId);
        }
        $dbObj->order_by('alert_realtime.id', 'desc');
        $dbObj->select(
                'alert_realtime.*,room.name as room_name,room.location as room_location,room.code as room_code,substation.city_code,substation.county_code,substation.name as substation_name, substation.city, substation.county');
        if($limit == -1 || $offset == -1)
        {
            $results = $dbObj->get('alert_realtime', 20, 0)->result();
            //echo $dbObj->last_query();
            return $results;
        }else{
            $results = $dbObj->get('alert_realtime', $limit, $offset)->result();
            //echo $dbObj->last_query();
            return $results;
        }
    }
    

    function Get_takeAlarmCount ($cityCode = false, $countyCode = false, $substationId = false, $roomId = false, $devModel = false,
    		$level = false, $startDatetime = false, $endDatetime = false, $word = '', $lastId = false,$status = false,$getsignalName = false)
    {
    	// $this->benchmark->mark('count_start');
    	$dbObj = $this->load->database('default', TRUE);
//     	if ($lastId > 0)
//     		$dbObj->where('pre_alert.id < ', $lastId);
    	if ($level)
    		$dbObj->where('level', $level);
//     	if ($startDatetime)
//     		if(strlen($startDatetime) > 10)
//     		$dbObj->where('added_datetime >', $startDatetime);
//     	else
//     		$dbObj->where('added_datetime >', $startDatetime . ' 00:00:00');
//     	if ($endDatetime)
//     		if(strlen($endDatetime) > 10)
//     		$dbObj->where('added_datetime <', $endDatetime);
//     	else
//     		$dbObj->where('added_datetime <', $endDatetime . ' 23:59:59');
        $dbObj->join('device', 'pre_alert.data_id=device.data_id');
        $dbObj->join('room', 'room.id=device.room_id');
        $dbObj->join('substation', 'substation.id=room.substation_id');
//         if (strlen($word)) {
//         	$dbObj->or_like('pre_alert.signal_name', $word);
//         	$dbObj->or_like('pre_alert.signal_id', $word);
//         }
        if($getsignalName)
        	$dbObj->where('pre_alert.signal_name', $getsignalName);
        if ($cityCode) {
            if (is_array($cityCode))
                $dbObj->where_in('substation.city_code', $cityCode);
            else
                $dbObj->where('substation.city_code', $cityCode);
        }
        if ($countyCode) {
            if (is_array($countyCode))
                $dbObj->where_in('substation.county_code', $countyCode);
            else
                $dbObj->where('substation.county_code', $countyCode);
        }
        if ($substationId) {
            if (is_array($substationId))
                $dbObj->where_in('substation.id', $substationId);
            else
                $dbObj->where('substation.id', $substationId);
        }
        if($devModel){
        	$dbObj->where_in("model", $devModel);
        }
        if ($roomId)
        	$dbObj->where('device.room_id', $roomId);

        $dbObj->where('pre_alert.status', 'unresolved');
    	$count = $dbObj->count_all_results('pre_alert');
    	log_message("debug","sql_count ".$dbObj->last_query());
    	return $count;
    }
    

    function Get_takeAlarmList ($cityCode = false, $countyCode = false, $substationId = false, $roomId = false, $devModel = false, $level = false,  $startDatetime = false,
    		$endDatetime = false, $word = '', $offset = 0, $limit = 20, $lastId = false,$status = false,$getsignalName = false)
    {
    	 $dbObj = $this->load->database('default', TRUE);
         if ($level)
             $dbObj->where('pre_alert.level', $level);
//  	    if(strlen($startDatetime) > 10)	    	
//              	$dbObj->where('added_datetime >', $startDatetime);
//  	    else
//              	$dbObj->where('added_datetime >', $startDatetime . '00:00:00');
//  	    if(strlen($endDatetime) > 10)
//              	$dbObj->where('added_datetime <', $endDatetime);
//  	    else
//              	$dbObj->where('added_datetime <', $endDatetime . '23:59:59');
        $dbObj->join('device', 'pre_alert.data_id=device.data_id','left');
        $dbObj->join('room', 'room.id=device.room_id');
        $dbObj->join('substation', 'substation.id=room.substation_id');

        
        if($getsignalName)
        	$dbObj->where('pre_alert.signal_name', $getsignalName);
        
        if ($cityCode) {
            if (is_array($cityCode))
                $dbObj->where_in('substation.city_code', $cityCode);
            else
                $dbObj->where('substation.city_code', $cityCode);
        }
        if ($countyCode) {
            if (is_array($countyCode))
                $dbObj->where_in('substation.county_code', $countyCode);
            else
                $dbObj->where('substation.county_code', $countyCode);
        }
        if ($substationId) {
            if (is_array($substationId))
                $dbObj->where_in('substation.id', $substationId);
            else
                $dbObj->where('substation.id', $substationId);
        }
        if($devModel){
        	$dbObj->where_in("model", $devModel);
        }
        if ($roomId)
        	$dbObj->where('device.room_id', $roomId);
         $dbObj->where('pre_alert.status', 'unresolved');
         $dbObj->order_by('pre_alert.id', 'desc');
         $dbObj->select(
                'pre_alert.*,room.name as room_name,room.location as room_location,room.id as room_id,room.code as room_code,device.name as dev_name,device.model,substation.city_code,substation.county_code,substation.name as substation_name');
        //$dbObj->cache_on();
        if($limit == -1 || $offset == -1)
        {
        	$results = $dbObj->get('pre_alert', 20, 0)->result();
        	//echo $dbObj->last_query();
        	return $results;
        }else{
	        $results = $dbObj->get('pre_alert', $limit, $offset)->result();
	        //echo $dbObj->last_query();
	        return $results;
    	}
    }
    function Get_AlertDetail ($alert_id, $data_id)
    {
        $dbObj = $this->load->database('default', TRUE);
        // data_id < 10000 smd_device.device_no,> 10000 device.data_id
        $dbObj->where('alert_realtime.id', $alert_id);
        $dbObj->join('room', 'smd_device.room_id=room.id');
        $dbObj->join('substation', 'substation.id=room.substation_id');
        $dbObj->select(
                'alert_realtime.id,alert_realtime.data_id,alert_realtime.level,alert_realtime.subject,alert_realtime.added_datetime,
        		alert_realtime.status,alert_realtime.restore_datetime,
                alert_realtime.dev_model,alert_realtime.dev_name,room.name as room_name,room.location as room_location,room.code as room_code,
                substation.city_code,substation.county_code,substation.name as substation_name');
        return $dbObj->get('alert_realtime')->row();
    }
    
    function Get_Substations_By_IdList ($idArr = false)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where_in("id", $idArr);
    	return $dbObj->get('substation')->result();
    }
    
    function Get_Substation_By_County($county)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where("county", $county);
    	return $dbObj->get('substation')->result();
    }

    function Get_Substations ($cityCode = false, $countyCode = false, $substations = false,$substation = false,$subId = false)
    {
        $dbObj = $this->load->database('default', TRUE);

//         if ($substation != 'all') {
//         	$dbObj->where_in('county', $substation);
//         }
        if ($cityCode) {
            if (is_array($cityCode))
                $dbObj->where_in('city_code', $cityCode);
            else
                $dbObj->where('city_code', $cityCode);
        }
        if ($countyCode) {
            if (is_array($countyCode))
                $dbObj->where_in('county_code', $countyCode);
            else
                $dbObj->where('county_code', $countyCode);
        }
        if ($substations != 'all') {
        	$dbObj->like('name', $substations);
        }
        if ($subId) {
        	$dbObj->where_in('id', $subId);
        }
        if ($keyWord){
        	$dbObj->group_start();
        	$dbObj->like('substation.name', $keyWord);
        	//$dbObj->or_like('substation.county', $keyWord);
        	$dbObj->or_like('substation.type', $keyWord);
        	$dbObj->group_end();
        }
        $dbObj->order_by('city_code', 'asc');
        $dbObj->order_by('county_code', 'asc');
        $dbObj->order_by('name', 'asc');
        return $dbObj->get('substation')->result();
    }

    function Get_SubstationRoom ($city = false,$substation = false)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('room','room.substation_id = substation.id');

    			$dbObj->where('city', $city);
    			$dbObj->where('county', $substation);    	
    			
       $dbObj->select('room.id as roomId,room.name as roomName,room.code as roomCode,room.lng as roomLng,room.lat as roomLat,substation.*');
    	return $dbObj->get('substation')->result();
    }
    
    function Get_Substation ($substation_id = false,$name = false,$county = false,$city = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        if($city)
        	$dbObj->where('city', $city);
        if($county)
        	$dbObj->where('county', $county);
        if($substation_id)
        	$dbObj->where('id', $substation_id);
        if($name)
        	$dbObj->where('name', $name);
        return $dbObj->get('substation')->row();
    }
    
    function Get_Substation_Lnglat_List ()
    {
    	$dbObj = $this->load->database('default', TRUE);
    	return $dbObj->get('substation')->result();
    }
    
    function Get_Substation_Lnglat_Count ()
    {
    	$dbObj = $this->load->database('default', TRUE);
    	return $dbObj->count_all_results("substation");;
    }
    
    function Up_Imgsubstation($id = false,$img = false,$newGrouping = false,$explain = false){
    	$dbObj = $this->load->database('default', TRUE);
    	if(!$newGrouping){
    		$newGrouping="没有分组";
    	}
    	foreach ($img as $arrimg){
    	$dbObj->set('substation_id', $id);
    	$dbObj->set('newGrouping', $newGrouping);
    	$dbObj->set('stationImage', $arrimg);
    	$dbObj->set('explain', $explain);
        $result = $dbObj->insert('stationimage');
    	}
    	return $result;
    }
    function Up_Stationimage($id = false,$img = false,$newGrouping = false,$explain = false){
    	$dbObj = $this->load->database('default', TRUE);
    	    $dbObj->where('id', $id);
    		$dbObj->set('newGrouping', $newGrouping);
    		if($img)
    		$dbObj->set('stationImage', $img);
    		$dbObj->set('explain', $explain);
    		$result = $dbObj->update('stationimage');
    	    return $result;
    }
    function Up_Group($selCitys = false){
    	$dbObj = $this->load->database('default', TRUE);
          if($selCitys)
          $dbObj->set('newGrouping', $selCitys);
          $dbObj->update('stationimage');
    	  return $result;
    }
    function Save_Substation($id, $settings)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id', $id);
    	$dbObj->set('settings', $settings);
    	$dbObj->update('substation');
    }
    function Saves_Substation($citycode,$cityname,$countycode,$gCountyname, $txtName, $type, $Stationcode, $Lnglat, $gCountycode)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->set('city', $cityname);
    	$dbObj->set('city_code', $citycode);
    	$dbObj->set('county', $gCountyname);
    	$dbObj->set('county_code', $countycode);
    	$dbObj->set('name', $txtName);
    	$dbObj->set('type', $type);
    	$dbObj->set('Stationcode', $citycode.$gCountycode.$Stationcode);
    	if($Lnglat){
    		$Lnglat = explode(",",$Lnglat);
    		$dbObj->set('lng', $Lnglat[0]);
    		$dbObj->set('lat', $Lnglat[1]);
    	}else{
    		$dbObj->set('lng', "0");
    		$dbObj->set('lat', "0");
    	}
    	$dbObj->set('UploadTime', 'now()', false);
    	$dbObj->insert('substation');
    }
     function Update_substation($id,$citycode,$cityname,$countycode,$gCountyname, $txtName, $type, $Stationcode, $Lnglat, $gCountycode)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id', $id);
    	$dbObj->set('city', $cityname);
    	if($citycode)
    	$dbObj->set('city_code', $citycode);
    	$dbObj->set('county', $gCountyname);
    	if($countycode)
    	$dbObj->set('county_code', $countycode);
    	$dbObj->set('name', $txtName);
    	$dbObj->set('type', $type);
    	$dbObj->set('Stationcode', $citycode.$gCountycode.$Stationcode);
    	if($Lnglat){
    		$Lnglat = explode(",",$Lnglat);
    		$dbObj->set('lng', $Lnglat[0]);
    		$dbObj->set('lat', $Lnglat[1]);
    	}else{
    		$dbObj->set('lng', "0");
    		$dbObj->set('lat', "0");
    	}
    	$dbObj->update('substation');
    }
    function Delete_substation($id){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id', $id);
    	$dbObj->delete('substation');
    	return $dbObj;
    }
    function Gets_Substation ($cityCode = false, $countyCode = false, $txtName = false, $offset = false,$size = false, $selCity = false, $keyWord = false, $gCounty = false)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('city_code !=', '');
    	$dbObj->where('county_code !=', '');
    	if($cityCode)
    		$dbObj->where_in('city_code', $cityCode);
    	if($countyCode)
    		$dbObj->where('county_code', $countyCode);
    	if($txtName)
    		$dbObj->like('name',$txtName);  
    	if($selCity)
    		$dbObj->where('city_code',$selCity);
    	if ($keyWord){
    		foreach($gCounty as $key => $val){
    			foreach($val as $k => $v){
    				if($v == $keyWord){
    					$keyWord = $k;
    				}
    			}
    		}
    		$dbObj->group_start();
    		$dbObj->like('substation.name', $keyWord);
    		$dbObj->or_like('substation.county_code', $keyWord);
    		$dbObj->or_like('substation.Stationcode', $keyWord);
    		$dbObj->group_end();
    	}
    	if ($size == 0)
    		return $dbObj->get('substation')->result();
    	else
    		return $dbObj->get('substation',$size,$offset)->result();  
    		
    }
    function Gets_SubstationForMaster($cityCodeArr = false,$SubstationArr = false){
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('city_code !=', '');
        $dbObj->where('county_code !=', '');
        $dbObj->select('Stationcode,name');
        if($cityCodeArr != false && count($cityCodeArr)){
            $dbObj->where_in('city_code', $cityCodeArr);
         }
        if($SubstationArr != false && count($SubstationArr)){
            $dbObj->where_in('id', $SubstationArr);
         }
        if($cityCodeArr != false || $SubstationArr != false || $_SESSION['XJTELEDH_USERROLE'] == 'admin' ){
            return $dbObj->get('substation')->result();
        }  
        return null;
    }
    function Get_SubstationCount ($cityCode = false, $countyCode = false, $txtName = false, $selCity = false, $keyWord = false, $gCounty = false)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('city_code !=', '');
    	$dbObj->where('county_code !=', '');
    	if ($cityCode){
    		$dbObj->where('substation.city_code', $cityCode);
    	}
    	if ($countyCode){
    		$dbObj->where('substation.county_code', $countyCode);
    	}
    	if ($txtName){
    		$dbObj->like('substation.name',$txtName);}
    	if ($selCity){
    		$dbObj->where('city_code',$selCity);
    	}
    	if ($keyWord){
    		foreach($gCounty as $key => $val){
    			foreach($val as $k => $v){
    				if($v == $keyWord){
    					$keyWord = $k;
    				}
    			}
    		}
    		$dbObj->group_start();
    		$dbObj->like('substation.name', $keyWord);
    		$dbObj->or_like('substation.county_code', $keyWord);
    		$dbObj->or_like('substation.Stationcode', $keyWord);
    		$dbObj->group_end();
    	}
    	return $dbObj->count_all_results("substation");
    }
    
    
    
    function Get_Rooms ($countyCode = false, $substation_id = false, $offset = 0, $size = 0)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('substation', 'substation.id=room.substation_id');
    	if ($countyCode) {
    		if (is_array($countyCode))
    			$dbObj->where_in('substation.county_code', $countyCode);
    		else
    			$dbObj->where('substation.county_code', $countyCode);
    	}
    	if ($substation_id) {
    		$dbObj->where('substation.id', $substation_id);
    	}
    	$dbObj->select('room.*,substation.city_code,substation.county_code,substation.Stationcode,substation.name as substation_name');
    	$dbObj->order_by('city_code', 'asc');
    	$dbObj->order_by('county_code', 'asc');
    	$dbObj->order_by('room.name', 'asc');
    	if ($size == 0)
    		return $dbObj->get('room')->result();
    	else
    		return $dbObj->get('room', $size, $offset)->result();
    }
    
    
    
    function Get_Room_List ($cityCode = false, $countyCode = false, $substationId = false, $offset = 0, $size = 0, $selCity = false, $keyWord = false, $gCounty = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->join('substation', 'substation.id=room.substation_id');      
        if ($substationId){
        	$dbObj->where('substation.id', $substationId);
        }  
	    if ($cityCode){
	        $dbObj->where('substation.city_code', $cityCode);
	    }
	    if ($countyCode){
	        $dbObj->where('substation.county_code', $countyCode);
	    }  
	    if($selCity){
	    	$dbObj->where('city_code',$selCity);
	    }
	    if ($keyWord){
	    	foreach($gCounty as $key => $val){
	    		foreach($val as $k => $v){
	    			if($v == $keyWord){
	    				$keyWord = $k;
	    			}
	    		}
	    	}
	    	$dbObj->group_start();
	    	$dbObj->like('substation.name', $keyWord);
	    	$dbObj->or_like('room.name', $keyWord);
	    	$dbObj->or_like('substation.county_code', $keyWord);
	    	$dbObj->or_like('Stationcode', $keyWord);
	    	
	    	$dbObj->group_end();
	    }
        $dbObj->select('room.*,substation.city_code,substation.county_code,substation.name as substation_name');
        $dbObj->order_by('city_code', 'asc');
        $dbObj->order_by('county_code', 'asc');
        $dbObj->order_by('room.name', 'asc');
        if ($size == 0)
            return $dbObj->get('room')->result();
        else
            return $dbObj->get('room', $size, $offset)->result();
    }
    
    
//     function Get_RoomCount ($countyCode = false, $substation_id = false)
//     {
//     	$dbObj = $this->load->database('default', TRUE);
//     	$dbObj->join('substation', 'substation.id=room.substation_id');
//     	if ($countyCode) {
//     		if (is_array($countyCode))
//     			$dbObj->where_in('substation.county_code', $countyCode);
//     		else
//     			$dbObj->where('substation.county_code', $countyCode);
//     	}
//     	if ($substation_id) {
//     		$dbObj->where('substation.id', $substation_id);
//     	}
//     	return $dbObj->count_all_results('room');
//     }
    
    
    function Get_RoomCount ($cityCode = false, $countyCode = false, $substationId = false, $selCity = false, $keyWord = false, $gCounty = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->join('substation', 'substation.id=room.substation_id');
        if ($substationId){
        	$dbObj->where('substation.id', $substationId);
        }  
	    if ($cityCode){
	        $dbObj->where('substation.city_code', $cityCode);
	    }
	    if ($countyCode){
	        $dbObj->where('substation.county_code', $countyCode);
	    }
	    if ($selCity){
	    	$dbObj->where('city_code',$selCity);
	    }
	    if ($keyWord){
	    	foreach($gCounty as $key => $val){
	    		foreach($val as $k => $v){
	    			if($v == $keyWord){
	    				$keyWord = $k;
	    			}
	    		}
	    	}
	    	$dbObj->group_start();
	    	$dbObj->like('substation.name', $keyWord);
	    	$dbObj->or_like('room.name', $keyWord);
	    	$dbObj->or_like('substation.county_code', $keyWord);
	    	$dbObj->or_like('Stationcode', $keyWord);
	    	$dbObj->group_end();
	    }
        return $dbObj->count_all_results('room');
    }
    function Get_records(){
    	$dbObj = $this->load->database('default', TRUE);
    	return $dbObj->count_all_results("rkerecord");
    }
        
//         //if ($countyCode) {
//           //  if (is_array($countyCode))
//            //     $dbObj->where_in('substation.county_code', $countyCode);
//             //else
//                // $dbObj->where('substation.county_code', $countyCode);
//         //}
//         //if ($substation_id) {
//           //  $dbObj->where('substation.id', $substation_id);
//         //}
//         //return $dbObj->count_all_results('room');
//     }

    function Save_Room($substation_id, $name, $addr, $code, $lng, $lat)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->set('substation_id', $substation_id);
    	$dbObj->set('name', $name);
    	$dbObj->set('location', $addr);
    	$dbObj->set('code', $code);
    	$dbObj->set('lng', $lng);
    	$dbObj->set('lat', $lat);
    	$dbObj->insert('room');
    }
    
    function Update_Room($id, $substation_id, $name, $addr, $code, $lng, $lat)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id',$id);
    	$dbObj->set('substation_id', $substation_id);
    	$dbObj->set('name', $name);
    	$dbObj->set('location', $addr);
    	$dbObj->set('code', $code);
    	$dbObj->set('lng', $lng);
    	$dbObj->set('lat', $lat);
    	$dbObj->update('room');
    }
    
    function Get_Room_ById($id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	return $dbObj->get_where("room", array("id"=>$id))->row();
    }
    function Get_Room ($roomCode)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->join('substation', 'substation.id=room.substation_id');
        $dbObj->where('code', $roomCode);
        $dbObj->select('room.*,substation.city,substation.city_code,substation.county,substation.name as substation_name,substation.id as substation_id');
        return $dbObj->get('room')->row();
    }

    function Get_Device_Threshold_List ($cityCode=false, $countyCode=false, $substationId=false)
    {
        $dbObj = $this->load->database('default', TRUE);          
        if($cityCode){
            $dbObj->where('city_code', $cityCode);
        }
        if($countyCode){
     	  $dbObj->where('county_code', $countyCode);
        }  
        if($substationId){
           $dbObj->where('substation_id', $substationId);
        }
        $ret = $dbObj->get('device_threshold')->result();
        //echo $dbObj->last_query();
        return $ret;
    }
    
    
//     function Get_Device_Threshold ($dev_type,$var_label,$var_name)
//     {
//     	$dbObj = $this->load->database('default', TRUE);
//     	$dbObj->where('dev_type', $dev_type);
//     	$dbObj->where('var_label',$var_label);
//     	$dbObj->where('var_name',$var_name);
//     	return $dbObj->get('device_threshold')->result();	
//     }
    
    function Get_DeviceThresholdByDevType ($dev_type = false, $var_name = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        $ret = $dbObj->get_where("device_threshold", array("dev_type" => $dev_type, 'var_name'=>$var_name))->result();
        return $ret;
    }

    function Set_Device_Var ($id, $setting)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $id);
        $dbObj->set('setting', $setting);
        $dbObj->update('device_threshold');
        return 0;
    }
    
    function Get_Device_Var ($id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $id);   
        return $dbObj->get('device_threshold')->row();
    }
    
    function Get_Device_Type($dev_type, $var_name, $substation_id, $city_code, $county_code)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('dev_type', $dev_type);
        $dbObj->where('var_name', $var_name);
        if($substation_id)
        {
            $dbObj->where('substation_id', $substation_id);
        }
        if(!empty($city_code))
        {
            $dbObj->where('city_code', $city_code);
        }
        if(!empty($county_code))
        {
            $dbObj->where('county_code', $county_code);
        }
        return $dbObj->get('device_threshold')->result();
    }
    
    function Del_Device_Var ($id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $id);
        $dbObj->delete('device_threshold');
    }

    function Save_Device_Var ($id, $dev_type, $var_label, $var_name,$var_prid,$substation_id,$var_selCity)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->set('dev_type', $dev_type);
        $dbObj->set('var_label', $var_label);
        $dbObj->set('var_name', $var_name);
        $dbObj->set('substation_id', $substation_id);
        $dbObj->set('city_code', $var_selCity);
        $dbObj->set('county_code', $var_selCity);
        if ($id) {
            $dbObj->where('id', $id);
            $dbObj->update('device_threshold');
        } else {
            $dbObj->insert('device_threshold');
        }
    }

    function Get_Alert_By_Data_Signal_Id($data_id, $signal_id, $level)
    {
    	$dbObj = $this->load->database('default', TRUE);
	    if($data_id)
    		$dbObj->where('alert.data_id', $data_id);
	    if($signal_id)
    	    $dbObj->where('signal_id',$signal_id);
	    if($level)
	    	$dbObj->where('level',$level);
    	$dbObj->where('status','unresolved');
    	$dbObj->select('alert.data_id,alert.id');
    	$ret = $dbObj->get('alert')->result();
	    return $ret;
    }
    function Get_Alert_By_Data_Signal_Ids($data_id,$id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if(strlen($data_id) < 6){
    		$dbObj->join('smd_device','smd_device.device_no=alert.data_id','left');
    		$dbObj->join('room','room.id=smd_device.room_id','left');
    		$dbObj->join('substation','substation.id=room.substation_id','left');
    	}
    	else if(strlen($data_id) > 6){
	    	$dbObj->join('device','alert.data_id=device.data_id','left');
	    	$dbObj->join('room','room.id=device.room_id','left');
	    	$dbObj->join('substation','substation.id=room.substation_id','left');
    	}
    	if($data_id)
    		$dbObj->where('alert.data_id', $data_id);
    	$dbObj->where('status','unresolved');
    	$dbObj->where('alert.id',$id);
    	
    	$dbObj->select('substation.city_code,substation.county_code,substation.name as sub_name,alert.*,room.name as room_name');
    	
    	$ret = $dbObj->get('alert')->result();
    	return $ret;
    	
    }
    function Fix_Alert_By_Data_Signal_IdS($alertId,$devId,$signalId,$level){

    	$count = 0;
    	$dbObj = $this->load->database('default', TRUE);
    	if($devId)
    		$dbObj->where_in('id', $alertId);
    	$dbObj->where('status','unresolved');
    	$alertList = $dbObj->get('alert')->result();
    	foreach($alertList as $alertObj)
    	{
    		$dbObj->where('id', $alertObj->id);
    		$dbObj->set('status','solved');
    		$dbObj->set('restore_datetime','now()',false);
    		$dbObj->update('alert');
			//add new record
			$dbObj->set('data_id', $alertObj->data_id);
			$dbObj->set('level', $alertObj->level);
			$dbObj->set('signal_id', $alertObj->signal_id);
			$dbObj->set('signal_name', $alertObj->signal_name);
			$dbObj->set('subject', $alertObj->subject);
			$dbObj->set('added_datetime', $alertObj->added_datetime);
			$dbObj->set('status', 'solved');
			$dbObj->set('restore_datetime', 'now()', false);
			$dbObj->set('restore_id', $alertObj->id);
			$dbObj->insert('alert');
			
			
			$count++;
    	}
    	if($devId)
    		$dbObj->where_in('data_id', $devId);
    	$dbObj->where_in('signal_id', $signalId);
    	$dbObj->where_in('level', $level);
    	$dbObj->set('status', 'solved');
    	$dbObj->set('restore_datetime', 'now()', false);
    	$dbObj->update('alert_realtime');
    	return $count;
    	 
    }
    
    function Fix_Alert_By_Data_Signal_Id($data_id, $signal_id, $level)
    {
    	$count = 0;
    	$dbObj = $this->load->database('default', TRUE);
    	if($data_id)
    		$dbObj->where_in('data_id', $data_id);
    	$dbObj->where_in('signal_id',$signal_id);
    	if($level)
    		$dbObj->where_in('level', $level);
    	$dbObj->where('status','unresolved');
    	$alertList = $dbObj->get('alert')->result();
    	foreach($alertList as $alertObj)
    	{
    		$dbObj->where('id', $alertObj->id);
    		$dbObj->set('status','solved');
    		$dbObj->set('restore_datetime','now()',false);
    		$dbObj->update('alert');
			//add new record
			$dbObj->set('data_id', $alertObj->data_id);
			$dbObj->set('level', $alertObj->level);
			$dbObj->set('signal_id', $alertObj->signal_id);
			$dbObj->set('signal_name', $alertObj->signal_name);
			$dbObj->set('subject', $alertObj->subject);
			$dbObj->set('added_datetime', $alertObj->added_datetime);
			$dbObj->set('status', 'solved');
			$dbObj->set('restore_datetime', 'now()', false);
			$dbObj->set('restore_id', $alertObj->id);
			$dbObj->insert('alert');
			
			
			$count++;
    	}
    	if($data_id)
    		$dbObj->where('data_id', $data_id);
    	$dbObj->where('signal_id', $signal_id);
    	$dbObj->set('status', 'solved');
    	$dbObj->set('restore_datetime', 'now()', false);
    	$dbObj->update('alert_realtime');
    	return $count;
    }
    
    function Get_SMD_Device_By_no ($device_no)
    {
        $dbObj = $this->load->database('default', TRUE);
        return $dbObj->get_where('smd_device', array('device_no' => $device_no))->row();
    }

    function Get_Device_By_SMD_no ($data_id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('smd_device_no', $data_id);
        $dbObj->order_by("dev_type","asc");
        $dbObj->order_by("port","asc");
        return $dbObj->get('device')->result();
    }
    
    function Get_Devices_By_Model($cityCode, $countyCode, $substationId, $models)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if($cityCode)
    		$dbObj->where("substation.city_code", $cityCode);
    	if($countyCode)
    		$dbObj->where('substation.county_code', $countyCode);
    	if($substationId)
    		$dbObj->where('substation.id',$substationId);
    	$dbObj->where_in('model',$models);
    	$dbObj->where('device.active',1);
    	$dbObj->join('room', 'device.room_id = room.id');
    	$dbObj->join('substation', 'substation.id=room.substation_id');
    	$dbObj->join('smd_device', 'device.smd_device_no=smd_device.device_no');
    	$dbObj->select('smd_device.ip,device.*,room.name as room_name,substation.city_code,substation.county_code,substation.name as substation_name');
    	return $dbObj->get('device')->result();
    }
    function Get_All_Devices ($model = '',$active=false, $cityCode=false, $countyCode=false, $substationId=false, $roomId=false, $dataId=false, $devName=false, $keyWord=false, $offset = 0, $size = 20, $selCity = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        if ($model)
        $dbObj->where('model', $model);
        $dbObj->join('room', 'device.room_id = room.id');
        $dbObj->join('substation', 'substation.id=room.substation_id');
        $dbObj->join('smd_device', 'device.smd_device_no=smd_device.device_no');
        if ($active == 'active' || $active == 'deactive')
            $dbObj->where('device.active', $active == 'active');  
        if ($cityCode)
        	$dbObj->where('substation.city_code', $cityCode);
        if ($countyCode)
        	$dbObj->where('substation.county_code', $countyCode);
        if ($substationId)
            $dbObj->where('substation.id', $substationId);
        if ($roomId)
        	$dbObj->where('room.id', $roomId);
        if ($dataId)
        	$dbObj->like('device.data_id', $dataId);     
        if ($devName)
        	$dbObj->like('device.name', $devName);
        if ($selCity)
        	$dbObj->where('city_code',$selCity);
        if ($keyWord){
        	$dbObj->group_start();
        	$dbObj->like('substation.name', $keyWord);
        	$dbObj->or_like('room.name', $keyWord);
        	$dbObj->or_like('smd_device.ip', $keyWord);
        	$dbObj->or_like('Stationcode', $keyWord);
        	$dbObj->group_end();
        }       
        $dbObj->select('smd_device.*,device.*,room.name as room_name,substation.city_code,substation.county_code,substation.Stationcode,substation.name as suname,smd_device.active as smd_device_active');
        return $dbObj->get('device', $size, $offset)->result();
    }
    
    function Get_Devices_Count($model = '', $active=false, $cityCode=false, $countyCode=false, $substationId=false, $roomId=false, $dataId=false, $devName=false, $keyWord=false, $selCity = false)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if ($model)
    		$dbObj->where('model', $model);
    	$dbObj->join('room', 'device.room_id = room.id');
    	$dbObj->join('substation', 'substation.id=room.substation_id');
    	$dbObj->join('smd_device', 'device.smd_device_no=smd_device.device_no');
    	if ($active == 'active' || $active == 'deactive')
    		$dbObj->where('device.active', $active == 'active');
    	if ($cityCode)
    		$dbObj->where('substation.city_code', $cityCode);
    	if ($countyCode)
    		$dbObj->where('substation.county_code', $countyCode);
    	if ($substationId)
    		$dbObj->where('substation.id', $substationId);
    	if ($roomId)
    		$dbObj->where('room.id', $roomId);
    	if ($dataId)
    		$dbObj->like('device.data_id', $dataId);
    	if ($devName)
    		$dbObj->like('device.name', $devName);
    	if ($selCity)
    		$dbObj->where('city_code',$selCity);
    	if ($keyWord){
    		$dbObj->group_start();
    		$dbObj->like('substation.name', $keyWord);
    		$dbObj->or_like('room.name', $keyWord);
    		$dbObj->or_like('smd_device.ip', $keyWord);
    		$dbObj->or_like('Stationcode', $keyWord);
    		$dbObj->group_end();
    	}
    	
    	return  $dbObj->count_all_results("device");
    	
    }
    
    
    function Get_DevGroup($roomId, $modelArray)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('room_id',$roomId);
    	$dbObj->where_in('model',$modelArray);
    	$dbObj->where('dev_group <>',"");
    	$dbObj->select('dev_group');
    	$dbObj->distinct('dev_group');    	
    	return $dbObj->get('device')->result();
    }
    function Get_vcamera($roomId)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('room_id',$roomId);
    	$model = 'vcamera';
    	$dbObj->where('model',$model);
    	$dbObj->select('data_id');
    	return $dbObj->get('device')->result();
    }
    
    function Get_spsList($dev_group)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('dev_group', $dev_group);
    	$dbObj->select('data_id,name,model');
    	return $dbObj->get('device')->result();
    }
	function Get_SwitchingPowerSupply($group)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('dev_group', $group);
		$dbObj->select('device.data_id,device.name,device.model');
		return $dbObj->get('device')->result();
	}
	function Get_Room_Device_Count($room_id, $model)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->where('device.room_id', $room_id);
	    $dbObj->where('active', true);
        $dbObj->where('model', $model);
        return $dbObj->count_all_results("device");
	}
	function Get_Room_Devices($room_id, $model)
	{
		$dbObj = $this->load->database('default', TRUE);
		//first we need to filter out smd_device
		if(is_array($model) && in_array("smd_device", $model))
		{
			$dbObj->where('smd_device.room_id', $room_id);
			$dbObj->where('active', true);
			$dbObj->select("smd_device.*");
			$ret = $dbObj->get('smd_device')->result();
			//echo $dbObj->last_query();
			return $ret;
		}else{
			$dbObj->where('device.room_id', $room_id);
			$dbObj->where('active', true);
			if (is_array($model))
				$dbObj->where_in('model', $model);
			else
				$dbObj->where('model', $model);
			$dbObj->order_by('dev_group','ASC');
			$dbObj->order_by('name', 'ASC');
			$dbObj->select('device.*');
			$ret = $dbObj->get('device')->result();
		    //echo $dbObj->last_query();
			return $ret;
		}
	}
	
    function Get_Room_Devs($room_id, $model)
    {
        $dbObj = $this->load->database('default', TRUE);
        //first we need to filter out smd_device
        if(is_array($model) && in_array("smd_device", $model))
        {
            $dbObj->join('room', 'room.id=smd_device.room_id');
            $dbObj->join('substation', 'substation.id=room.substation_id','left');
            $dbObj->where('smd_device.room_id', $room_id);
            $dbObj->where('active', true);
            $dbObj->select("smd_device.*,substation.city_code");
            $ret = $dbObj->get('smd_device')->result();
            //echo $dbObj->last_query();
            return $ret;
        }else{
            $dbObj->join('room', 'room.id=device.room_id');
            $dbObj->join('substation', 'substation.id=room.substation_id','left');
            $dbObj->where('device.room_id', $room_id);
            $dbObj->where('active', true);
            if (is_array($model))
                $dbObj->where_in('model', $model);
            else
                $dbObj->where('model', $model);
            $dbObj->order_by('dev_group','ASC');
            $dbObj->order_by('name', 'ASC');
            $dbObj->select('device.*,substation.city_code');
            $ret = $dbObj->get('device')->result();
            //echo $dbObj->last_query();
            return $ret;
            }
        }
	
	function Get_Room_Dev($room_id)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('device.room_id', $room_id);
		$dbObj->where('active', true);
		$dbObj->order_by('dev_group','ASC');
		$dbObj->order_by('name', 'ASC');
		$dbObj->select('device.*');
		$ret = $dbObj->get('device')->result();
		//echo $dbObj->last_query();
		return $ret;
	}
    function Get_RoomDevices ($roomCode = false, $devType = false, $model = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        //first we need to filter out smd_device
        if(is_array($model) && in_array("smd_device", $model))
        {
        	$dbObj->join('room', 'room.id=smd_device.room_id');
        	if ($roomCode)
        		$dbObj->where('room.code', $roomCode);
        	return $dbObj->get('smd_device')->result();
        }else{
	        $dbObj->join('room', 'room.id=device.room_id');
	        if ($roomCode)
	            $dbObj->where('room.code', $roomCode);
	//      if ($devType)
	//             $dbObj->where('dev_type', $devType);
	        $dbObj->where('active', true);
	        if ($model) {
	            if (is_array($model))
	                $dbObj->where_in('model', $model);
	           else
	                $dbObj->where('model', $model);
	        }
	        if($dev_group)
	        	$dbObj->where('dev_group', $dev_group);
	        $dbObj->order_by('dev_group','ASC');
	        $dbObj->order_by('name', 'ASC');
	        $dbObj->select('device.data_id,device.name,device.model,device.extra_para,device.dev_group');
	        $ret = $dbObj->get('device')->result();
	        //echo $dbObj->last_query();
	        return $ret;
        }
    }
 
//lsh added
    function Get_AegList($roomCode)
    {
    	return $this->Get_RoomDevices($roomCode, 0, array('aeg-ms10se','aeg-ms10m'));
    }
    
    function Get_smd_device($room_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('room_id', $room_id);
    	$dbObj->select('device_no');
    	return $dbObj->get('smd_device')->row();
    }
    
    function Get_Device ($data_id = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('device.data_id', $data_id);
        $dbObj->join('room', 'device.room_id = room.id', 'left');
        $dbObj->join('substation', 'substation.id=room.substation_id','left');
        $dbObj->join('smd_device', 'device.smd_device_no=smd_device.device_no','left');
        $dbObj->select(
                'device.*,room.name as room_name,substation.id as substation_id,substation.name as substation_name,substation.city_code,substation.county_code');
        return $dbObj->get('device')->row();
    }
    function Get_Device_ById ($id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	return $dbObj->get_where('device.id', $id);
    }
    function Get_Devices ($data_id = array())
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where_in('data_id', $data_id);
        $dbObj->select('device.data_id,device.name,device.model');
        return $dbObj->get('device')->result();
    }

    function Get_SwitchingPowerSupplyList ($roomCode)
    {
        return $this->Get_Room_Devices($roomCode,  array('psma-ac','psma-rc','psma-dc','m810g-rc','m810g-dc','m810g-ac','smu06c-rc','smu06c-dc','smu06c-ac','zxdu-rc','zxdu-dc','zxdu-ac'));
    }
    function Get_zxdu ($roomCode)
    {    	
    	return $this->Get_Room_Devices($roomCode, array('zxdu-rc','zxdu-dc','zxdu-ac'));
    }
    function Get_FreshAirList ($roomCode)
    {
        return $this->Get_Room_Devices($roomCode,  'fresh_air');
    }

    function Get_LiebertUPSList ($roomCode)
    {
        return $this->Get_Room_Devices($roomCode, 'liebert-ups');
    }
    
    function Get_LiebertPEXList($roomCode)
    {
    	return $this->Get_Room_Devices($roomCode,'liebert-pex');
    }
    
    function Get_airConditionList($roomCode)
    {
    	return $this->Get_Room_Devices($roomCode,'ug40');
    }

    function Get_Access4000xList($roomCode)
    {
    	return $this->Get_Room_Devices($roomCode, "access4000x");
    }
    function Get_RoomDevRtData ($dataId = array())
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where_in('data_id', $dataId);
        $dbObj->where('active', true);
        $dbObj->select('device.value,device.data_id,device.model');
        return $dbObj->get('device')->result();
    }

    function Get_RoomImem12List ($roomCode)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->join('device', 'device.data_id=device_imem12_ext.data_id');
        $dbObj->where('device.room_id', $roomCode);
        $dbObj->where('device.model', 'imem_12');
        $dbObj->where('device.active', '1');
        $dbObj->select('device_imem12_ext.*');
        return $dbObj->get('device_imem12_ext')->result();
    }
    
    function Get_Imem12List ($cityCode = false, $countyCode = false, $substationId = false, $roomCode = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('device.model', 'imem_12');
        $dbObj->join('room', 'room.id=device.room_id');
        $dbObj->join('substation', 'substation.id=room.substation_id');
        if ($roomCode)
            $dbObj->where('room.code', $roomCode);
        if ($cityCode)
            $dbObj->where('substation.city_code', $cityCode);
        if ($countyCode)
            $dbObj->where('substation.county_code', $countyCode);
        if ($substationId)
            $dbObj->where('substation.id', $substationId);
        $dbObj->select('device.*,room.name as room_name,substation.city_code,substation.county_code,substation.name as substation_name');
        return $dbObj->get('device')->result();
    }

    function Count_Imem12History ($data_id, $startDatetime, $endDatetime)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('data_id', $data_id);
        $dbObj->where('update_datetime > ', $startDatetime . ' 00:00:00');
        $dbObj->where('update_datetime < ', $endDatetime . ' 23:59:59');
        $dbObj->select_max('w1', 'w1max');
        $dbObj->select_min('w1', 'w1min');
        $dbObj->select_max('w2', 'w2max');
        $dbObj->select_min('w2', 'w2min');
        $dbObj->select_max('w3', 'w3max');
        $dbObj->select_min('w3', 'w3min');
        $dbObj->select_max('w4', 'w4max');
        $dbObj->select_min('w4', 'w4min');
        return $dbObj->get('device_imem12_data')->row();
    }

    function Get_Imem12RtData ($dataId = array())
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where_in('data_id', $dataId);
        return $dbObj->get('device_imem12_data_realtime')->result();
    }

    function Get_Imem12Obj ($id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('device_imem12_ext.id', $id);
        $dbObj->join('device', 'device.data_id=device_imem12_ext.data_id');
        $dbObj->join('room', 'room.id=device.room_id');
        $dbObj->join('substation', 'substation.id=room.substation_id');
        $dbObj->select(
                'device_imem12_ext.id,device_imem12_ext.name,device.name as dev_name,device.extra_para as device_ip,room.name as room_name,room.location as room_location,substation.city_code,substation.county_code');
        return $dbObj->get('device_imem12_ext')->row();
    }

    function Get_RoomDevObj ($data_id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('device.data_id', $data_id);
        $dbObj->join('room', 'room.id=device.room_id');
        $dbObj->join('substation', 'substation.id=room.substation_id');
        $dbObj->join('smd_device', 'smd_device.device_no=device.smd_device_no');
        $dbObj->select(
                'device.name as dev_name,device.model,device.port,device.extra_para,room.name as room_name,room.location as room_location,substation.city_code,substation.county_code,smd_device.name as smd_device_name,smd_device.ip as smd_device_ip');
        return $dbObj->get('device')->row();
    }
    
    
    function Device_extra_para ($data_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('device.data_id', $data_id);
    	$dbObj->select('extra_para');
    	return $dbObj->get('device')->row();	
    }
    

    function Search_Rooms ($q = array(), $offset = 0, $size = 0)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->join('substation', 'substation.id=room.substation_id');
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->join('substation', 'substation.id=room.substation_id');
        foreach ($q as $key => $val) {
            
            if ($val) {
                $dbObj->like('substation.city', $val);
                $dbObj->or_like('substation.county', $val);
                $dbObj->or_like('substation.name', $val);
                $dbObj->or_like('room.name', $val);
            }
        }
        $dbObj->select('room.*,substation.city_code,substation.county_code,substation.name as substation_name');
        $dbObj->order_by('city_code', 'asc');
        $dbObj->order_by('county_code', 'asc');
        $dbObj->order_by('room.name', 'asc');
        if ($size == 0)
            return $dbObj->get('room')->result();
        else
            return $dbObj->get('room', $size, $offset)->result();
    }

    function Search_RoomsCount ($q = array())
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->join('substation', 'substation.id=room.substation_id');
        foreach ($q as $key => $val) {
            
            if ($val) {
                $dbObj->like('substation.city', $val);
                $dbObj->or_like('substation.county', $val);
                $dbObj->or_like('substation.name', $val);
                $dbObj->or_like('room.name', $val);
            }
        }
        return $dbObj->count_all_results('room');
    }

    function Add_MapData ($code, $name, $path)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->set('code', $code);
        $dbObj->set('name', $name);
        $dbObj->set('path', $path);
        return $dbObj->insert('map_data');
    }

    function Get_MapData ($parentCode = 0, $code = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('parent_code', $parentCode);
        if ($code)
            $dbObj->where('code', $code);
        
        return $dbObj->get('map_data')->result();
    }

    function Get_CountySMDDevice ($countyCode = false, $substation_id = false, $offset = 0, $size = 0)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->join('room', 'room.id=smd_device.room_id');
        $dbObj->join('substation', 'room.substation_id=substation.id');
        if ($countyCode)
            $dbObj->where('substation.county_code', $countyCode);
        if ($substation_id)
            $dbObj->where('substation.id', $substation_id);
        $dbObj->select(
                'smd_device.*,room.name as room_name,substation.id as substation_id,substation.name as substation_name,substation.city_code,substation.county,substation.county_code');
        if ($size == 0)
            return $dbObj->get('smd_device')->result();
        else
            return $dbObj->get('smd_device', $size, $offset)->result();
    }
    
    function Add_Device ($smd_device_no, $room_id, $imem_id, $name, $data_id, $dev_type, $model, $devGroup, $port, $extra_para, $active, $manufacturer, $productionDate, 
            $deviceModel, $ratedPower, $distributionEquipment, $memo,$devicebrand,$manufacturers,$version)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->trans_start();
        //这个地方要先判断data_id重复的问题
        $devObj = $dbObj->get_where("device", array("data_id"=>$data_id))->row();
        if(count($devObj))
        {
            $dbObj->trans_complete();
            return false;            
        }
        $dbObj->set('smd_device_no', $smd_device_no);
        $dbObj->set('room_id', $room_id);
        $dbObj->set('imem_id', intval($imem_id));
        $dbObj->set('name', $name);
        $dbObj->set('data_id', $data_id);
        $dbObj->set('dev_type', $dev_type);
        $dbObj->set('model', $model);
        $dbObj->set('dev_group', $devGroup);
        $dbObj->set('port', $port);
        $dbObj->set('extra_para', $extra_para);
        $dbObj->set('active', $active);
        $dbObj->set('save_datetime', 'now()', FALSE);
        $dbObj->set('save_interval', 0);
        $dbObj->set('manufacturer', $manufacturer);
        if($productionDate)
            $dbObj->set('production_date', $productionDate);
        $dbObj->set('device_model', $deviceModel);
        $dbObj->set('brand', $devicebrand); 
        $dbObj->set('manufacturers', $manufacturers);
        $dbObj->set('version', $version);
        $dbObj->set('rated_power', doubleval($ratedPower));
//         if($model == 'temperature' || $model == 'humid' || $model == 'smoke' || $model == 'water' || $model == 'camera')
//         {
//         	if($model == 'temperature' || $model == 'humid' || $model == 'smoke' || $model == 'water')
//         	{
//         		$virtual_model = 'venv';
//         		$virtual_name = '机房环境';
//         	}
//         	elseif($model == 'camera')
//         	{
//         		$virtual_model = 'vcamera';
//         		$virtual_name = '监控设备';
//         	}
//         	$dbObj->where('room_id',$room_id);
//         	$dbObj->where('model',$virtual_model);
//         	$dbObj->select('data_id');
//         	$group_id = $dbObj->get('device')->row();
//         	if($group_id)
//         	{
//         		$dbObj->set('dev_group', $group_id->data_id);
//         	}
//         	else{
//         		$venv_data_id = $data_id + 1;
//         		$dbObj->set('smd_device_no', $smd_device_no);
//         		$dbObj->set('room_id', $room_id);
//         		$dbObj->set('name',$virtual_name);
//         		$dbObj->set('data_id', $venv_data_id);
//         		$dbObj->set('model', $virtual_model);
//         		$dbObj->set('active', '1');
//         		$dbObj->set('save_datetime', 'now()', FALSE);
//         		$ret = $dbObj->insert('device');
//         	}
//         	if($ret)
//         	{
//         		if($virtual_model = 'venv')
//         		{
//         			$dev_model =  array('temperature','humid','smoke','water');
//         			$dbObj->where_in('model',$dev_model);
//         			$dbObj->set('dev_group', $venv_data_id);
//         			$dbObj->update('device');
//         		}
//         		if($virtual_model = 'vcamera')
//         		{
//         			$dbObj->where('model',$model);
//         			$dbObj->set('dev_group', $venv_data_id);
//         			$dbObj->update('device');
//         		}
//         	}
//         }
        $dbObj->set('distribution_equipment', $distributionEquipment);
        $dbObj->set('threshold_setting','');
        $dbObj->set('rank',0);
        $dbObj->set('memo', $memo);
        $dbObj->insert('device'); 
        $dbObj->trans_complete();
        return true;
    }

    function Update_Device ($data_id, $smd_device_no, $room_id, $imeme_id, $name, $new_data_id, $dev_type, $model, $devGroup, $port, $extra_para, $active, $manufacturer, $productionDate, 
            $deviceModel, $ratedPower, $distributionEquipment, $memo, $devicebrand, $manufacturers,$version)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('data_id', $data_id);
        $dbObj->set('smd_device_no', $smd_device_no);
        $dbObj->set('room_id', $room_id);
        $dbObj->set('imem_id', $imeme_id);
        $dbObj->set('name', $name);
        $dbObj->set('data_id', $new_data_id);
        $dbObj->set('dev_type', $dev_type);
        $dbObj->set('model', $model);
        $dbObj->set('dev_group', $devGroup);
        $dbObj->set('port', $port);
        $dbObj->set('extra_para', $extra_para);
        $dbObj->set('active', $active);
        $dbObj->set('manufacturer', $manufacturer);
        $dbObj->set('production_date', $productionDate);
        $dbObj->set('device_model', $deviceModel);
        $dbObj->set('brand', $devicebrand);
        $dbObj->set('rated_power', $ratedPower);
        $dbObj->set('manufacturers', $manufacturers);
        $dbObj->set('version', $version);
        if ($distributionEquipment)
            $dbObj->set('distribution_equipment', $distributionEquipment);
        $dbObj->set('memo', $memo);
        return $dbObj->update('device');
    }

    function Update_DeviceObj ($deviceObj)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $deviceObj->id);
    	$teleDbObj = clone($dbObj);
        return $dbObj->update('device', $deviceObj);
    }

    function Delete_Device ($id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('data_id', $id);
        $new_obj = clone ($dbObj);
        return $dbObj->delete('device');
    }

    function Toggle_DeviceStatus ($id, $active)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $id);
        $dbObj->set('active', $active);
        return $dbObj->update('device');
    }

    function Delete_SmdDevice ($smd_dev_no)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('device_no', $smd_dev_no);
        return $dbObj->delete('smd_device');
    }

    function Toggle_SmdDeviceStatus ($smd_dev_no, $active)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('device_no', $smd_dev_no);
        $dbObj->set('active', $active);
        return $dbObj->update('smd_device');
    }

    function Get_SMDDevice_By_LscStation($lscId, $stationId)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('room','smd_device.room_id=room.id');
    	$dbObj->join('substation','room.substation_id=substation.id');
    	$dbObj->where('substation.city_code',$lscId);
    	$dbObj->where('substation.county_code', $stationId);
	$dbObj->where('smd_device.active',1);
    	return $dbObj->get('smd_device')->result();
    }
    function Get_SmdDevice ($smd_device_no)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('device_no', $smd_device_no);
        $dbObj->join('room', 'smd_device.room_id = room.id');
        $dbObj->join('substation', 'substation.id=room.substation_id');
        $dbObj->select(
                'smd_device.*,room.name as room_name,room.id,substation.id as substation_id,substation.name as substation_name
        ,substation.city_code,substation.county_code');
        return $dbObj->get('smd_device')->row();
    }
    function Get_SMDDevices ($substation_id = false){
    	$dbObj = $this->load->database('default', TRUE);
    	if($substation_id != false){
    		$dbObj->where('substation_id', $substation_id);
    	}
    	return $dbObj->get('smd_device')->result();
    }
    function Update_SmdDevice ($device_no, $room_id, $station,$name, $ip, $active)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('device_no', $device_no);
        $dbObj->set('room_id', $room_id);
        $dbObj->set('substation_id', $station);
        $dbObj->set('name', $name);
        $dbObj->set('ip', $ip);
        $dbObj->set('active', $active);
        return $dbObj->update('smd_device');
    }

    function Add_SmdDevice ($new_device_no, $room_id,$station, $name, $ip, $active)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->set('device_no', $new_device_no);
        $dbObj->set('room_id', $room_id);
        $dbObj->set('substation_id', $station);
        $dbObj->set('name', $name);
        $dbObj->set('ip', $ip);
        $dbObj->set('active', $active);
        return $dbObj->insert('smd_device');
    }
    
    function Get_smdMaxId ()
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->select_max('device_no', 'smdmax');
    	return $dbObj->get('smd_device')->row();
    }
    
    function Batch_Alert($arrayid){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where_in('id', $arrayid);
    	$dbObj->set('confirm_datetime','now()', FALSE);
    	return $dbObj->update('alert_realtime');
    }
    function Block_Alert ($alert_id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $alert_id);
        $dbObj->set('status', 'resolved');
        $dbObj->set('restore_datetime', 'now()', FALSE);
		$dbObj->update('alert');
		$dbObj->where('id', $alert_id);
        $dbObj->set('status', 'resolved');
        $dbObj->set('restore_datetime', 'now()', FALSE);
        return $dbObj->update('alert_realtime');
    }
   function Restore_Alert ($alert_id)
   {
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->where('id', $alert_id);
        $dbObj->set('confirm_datetime', 'now()', FALSE);
        return $dbObj->update('alert_realtime');
   }
   function Take_PreAlert($alert_id){
	   	$dbObj = $this->load->database('default', TRUE);   	
	   	$dbObj->where('id', $alert_id);
	   	$preObj=$dbObj->get('pre_alert')->row();

	   	$dbObj->set("data_id",$preObj->data_id);
	   	$dbObj->set("level",$preObj->level);
	   	$dbObj->set("signal_id",$preObj->signal_id);
	   	$dbObj->set("signal_name",$preObj->signal_name);
	   	$dbObj->set("subject",$preObj->subject);
	   	$dbObj->set("added_datetime",$preObj->added_datetime);
	   	$dbObj->set("status",$preObj->status);   	
	   	$dbObj->set("restore_datetime",$preObj->restore_datetime);
	   	$dbObj->set("restore_id",$preObj->restore_id);
	   	$dbObj->insert('alert');

	   	$dbObj->set("data_id",$preObj->data_id);
	   	$dbObj->set("signal_id",$preObj->signal_id);
	   	$dbObj->set("added_datetime",$preObj->added_datetime);	   	 
	   	$dbObj->insert('alert_whitelist');

	   	if($preObj->data_id < 10000)
	   	{
	   		//smd device
	   		$smdObj = $this->Get_SMD_Device_By_no($preObj->data_id);
	   		var_dump($preObj->data_id).die;
	   		if(count($smdObj) == 0)
	   			return;
	   		$dbObj->set('dev_name',$smdObj->name);
	   		$dbObj->set('room_id', $smdObj->room_id);
	   		$dbObj->set('dev_model', 'smd_device');
	   	}else{ 		
	   		$devObj = $this->Get_Device($preObj->data_id);
	   		if(count($devObj) == 0)
	   			return;
	   		$dbObj->set('dev_name',$devObj->name);
	   		$dbObj->set('room_id', $devObj->room_id);
	   		$dbObj->set('dev_model', $devObj->model);	   		
	   	}

	   	$dbObj->set('data_id', $preObj->data_id);
	   	$dbObj->set('level', $preObj->level);
	   	$dbObj->set('signal_id', $preObj->signal_id);
	   	$dbObj->set('signal_name', $preObj->signal_name);
	   	$dbObj->set('subject', $preObj->subject);
	   	$dbObj->set('status', 'unresolved');
	   	$dbObj->set('added_datetime', 'now()', FALSE);
	   	$dbObj->set('restore_datetime', '00-00-00 00:00:00');
	   	
	   	$dbObj->set('restore_id', $preObj->restore_id);
	   	$dbObj->insert("alert_realtime");
	   	
	   	$dbObj->where('id', $alert_id);
	   	return $dbObj->delete('pre_alert');
   }
    function Get_CityList ($substationList = false,$cityCode = false)
    {
        $dbObj = $this->load->database('default', TRUE);
        if (count($substationList)) {
            $dbObj->where_in('id', $substationList);
        }
        if ($cityCode) {
        	$dbObj->where('city_code', $cityCode);
        }
        return $dbObj->get('substation')->result();
    }
   function Get_CityListArrKey($substationList = false){
       $dbObj = $this->load->database('default', TRUE);
        $dbObj->select('city_code');
        $dbObj->group_by('city_code');
        if (count($substationList)) {
           $dbObj->where_in('id', $substationList);
           return $dbObj->get('substation')->result_array();
         }
     }

    function Get_CountyCount($cityCode = false, $substationList = array(), $searchKey='')
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if ($cityCode)
    		$dbObj->where('city_code', $cityCode);
        if (count($substationList)) {
            $dbObj->where_in('id', $substationList);
    	}
    	if($searchKey)
    		$dbObj->like('name', $searchKey);
    	$ret = $dbObj->count_all_results("substation");
	log_message('debug','sql '.$dbObj->last_query());
	return $ret;
    }
    function Get_CountyList ($cityCode = false, $substationList = array(), $searchKey='',$offset = 0, $size = -1)
    {
        $dbObj = $this->load->database('default', TRUE);
        if ($cityCode)
            $dbObj->where('city_code', $cityCode);
        if (count($substationList)) {
            $dbObj->where_in('id', $substationList);
        }
        if($searchKey)
        	$dbObj->like('name', $searchKey);
        //$dbObj->group_by('county_code');
        $dbObj->select('*');
        
        if($size == -1)
        	return $dbObj->get('substation')->result();
        else
        	return $dbObj->get('substation', $size, $offset)->result();
    }
    
    //常用局站
    public function Get_UserStation_Count($user_id, $searchKey)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('substation','user_station.substation_id=substation.id');
    	$dbObj->where('user_id', $user_id);
    	if($searchKey)
    		$dbObj->like('substation.name',$searchKey);
    	return $dbObj->count_all_results("user_station");
    }
    public function Get_UserStation_List($user_id, $searchKey, $offset=0, $pageSize=20)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('substation','user_station.substation_id=substation.id');
    	$dbObj->where('user_id', $user_id);
    	if($searchKey)
    		$dbObj->like('substation.name',$searchKey);
    	return $dbObj->get('user_station',$offset,$pageSize)->result();
    }
	public function Has_UserStation($user_id, $substation_id)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where("user_id", $user_id);
		$dbObj->where("substation_id",$substation_id);
		return $dbObj->count_all_results('user_station') > 0;
	}
	public function Add_UserStation($user_id, $substation_id)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->set("user_id", $user_id);
		$dbObj->set("substation_id",$substation_id);
		$dbObj->insert('user_station');
	}
	public function Del_UserStation($user_id, $substation_id)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where("user_id", $user_id);
		$dbObj->where("substation_id",$substation_id);
		return $dbObj->delete('user_station');
	}
    public function Save_Feedback ($content, $user_id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->set('user_id', $user_id);
        $dbObj->set('content', $content);
        $dbObj->set('added_datetime', 'now()', FALSE);
        return $dbObj->insert('app_feedback');
    }

    function Reply_Feedback ($feedbackId, $reply)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $feedbackId);
        $dbObj->set('reply', $reply);
        $dbObj->set('reply_datetime', 'now()', FALSE);
        return $dbObj->update('app_feedback');
    }

    public function Get_FeedbackList ($user_id = false, $status = 'replied', $offset = 0, $size = 0)
    {
        $dbObj = $this->load->database('default', TRUE);
        if ($user_id)
            $dbObj->where('user_id', $user_id);
        if ($status == 'replied') {
            $dbObj->where('reply !=', '');
        } elseif ($status == 'unreplied') {
            $dbObj->where('reply', '');
        }
        $dbObj->join('user', 'user.id=app_feedback.user_id');
        $dbObj->select('app_feedback.*,user.full_name');
        $dbObj->order_by('app_feedback.added_datetime', 'desc');
        if ($size == 0)
            return $dbObj->get('app_feedback')->result();
        else
            return $dbObj->get('app_feedback', $size, $offset)->result();
    }

    public function Get_Feedback ($id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('app_feedback.id', $id);
        $dbObj->join('user', 'user.id=app_feedback.user_id');
        $dbObj->select('app_feedback.*,user.full_name');
        return $dbObj->get('app_feedback')->row();
    }

    function Get_FeedbackCount ($status)
    {
        $dbObj = $this->load->database('default', TRUE);
        if ($status == 'replied') {
            $dbObj->where('reply !=', '');
        } elseif ($status == 'unreplied') {
            $dbObj->where('reply', '');
        }
        return $dbObj->count_all_results('app_feedback');
    }

    function Delete_Reply ($feedbackId)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $feedbackId);
        $dbObj->set('reply', '');
        $dbObj->set('reply_datetime', '00:00:00 00:00:00');
        return $dbObj->update('app_feedback');
    }

    function Delete_Feedback ($feedbackId)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $feedbackId);
        return $dbObj->delete('app_feedback');
    }

    function Save_Alarm ($data_id, $level, $signal_name, $signal_id, $subject)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->set('data_id', $data_id);
        $dbObj->set('level', $level);
        $dbObj->set('signal_id', $signal_id);
        $dbObj->set('signal_name', $signal_name);
        $dbObj->set('subject', $subject);
        $dbObj->set('status', 'unresolved');
        $dbObj->set('added_datetime', 'now()', FALSE);
        $dbObj->set('confirm_datetime', '00-00-00 00:00:00');
        $dbObj->set('restore_datetime', '00-00-00 00:00:00');
        $newAlertId = $dbObj->insert('alert');
	if($data_id < 10000)
	{
       		//smd device
                $smdObj = $this->Get_SMD_Device_By_no($data_id);
                if(count($smdObj) == 0)
                	return;
                $dbObj->set('dev_name',$smdObj->name);
                $dbObj->set('room_id', $smdObj->room_id);
                $dbObj->set('dev_model', 'smd_device');
	}else{
       		$devObj = $this->Get_Device($data_id);
                if(count($devObj) == 0)
                	return;
                $dbObj->set('dev_name',$devObj->name);
                $dbObj->set('room_id', $devObj->room_id);
                $dbObj->set('dev_model', $devObj->model);
	}

	$dbObj->set('data_id', $data_id);
        $dbObj->set('level', $level);
        $dbObj->set('signal_id', $signal_id);
        $dbObj->set('signal_name', $signal_name);
        $dbObj->set('subject', $subject);
        $dbObj->set('status', 'unresolved');
        $dbObj->set('added_datetime', 'now()', FALSE);
        $dbObj->set('restore_datetime', '00-00-00 00:00:00');
	$dbObj->set('restore_id', $newAlertId);
	$dbObj->insert("alert_realtime");

    }

    function Save_RoomPi ($room_id, $pi_setting)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $room_id);
        $dbObj->set('pi_setting', $pi_setting);
        return $dbObj->update('room');
    }

    function Get_AlarmCountGroupByLevel ($cityCode = false, $countyCode = false, $substationId = false, $roomId = false, $devModel = false, $status = array(), $startDatetime = false, 
            $endDatetime = false, $word = '', $lastId = -1)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->join('device', 'alert_realtime.data_id=device.data_id');
        if ($lastId > 0)
            $dbObj->where('alert_realtime.id < ', $lastId);
        
        if ($startDatetime)
            $dbObj->where('added_datetime >', $startDatetime . ' 00:00:00');
        if ($endDatetime)
            $dbObj->where('added_datetime <', $endDatetime . ' 23:59:59');
        $dbObj->join('room', 'room.id=alert_realtime.room_id');
        $dbObj->join('substation', 'substation.id=room.substation_id');
        if (strlen($word))
            $dbObj->like('alert_realtime.dev_name', $word);
        if ($devModel) {
            if (is_array($devModel)) {
                $dbObj->where_in('alert_realtime.dev_model', $devModel);
            } else
                $dbObj->where('alert_realtime.dev_model', $devModel);
        }
        if ($roomId)
            $dbObj->where('alert_realtime.room_id', $roomId);
        if ($cityCode) {
            if (is_array($cityCode))
                $dbObj->where_in('substation.city_code', $cityCode);
            else
                $dbObj->where('substation.city_code', $cityCode);
        }
        if ($countyCode) {
            if (is_array($countyCode))
                $dbObj->where_in('substation.county_code', $countyCode);
            else
                $dbObj->where('substation.county_code', $countyCode);
        }
        if ($substationId) {
            if (is_array($substationId))
                $dbObj->where_in('substation.id', $substationId);
            else
                $dbObj->where('substation.id', $substationId);
        }
        
        if (count($status)) {
            $dbObj->where_in('alert_realtime.status', $status);
        }
        
        if (!empty($startDatetime)) {
        	$dbObj->where('added_datetime >', $startDatetime);
        }
        if (!empty($endDatetime)){
        	$dbObj->where('added_datetime <', $endDatetime . ' 23:59:59');
        }
        
        $dbObj->group_by('alert_realtime.level');
        $dbObj->order_by('alert_realtime.level', 'asc');
        $dbObj->select('alert_realtime.level,count(*) as count');
        $ret = $dbObj->get('alert_realtime')->result();
	//echo $dbObj->last_query();
	return $ret;
    }
    function Get_AlarmCountGroup ($cityCode = false, $countyCode = false, $status = array(), $startDatetime = false, $endDatetime = false)

    {
    	$dbObj = $this->load->database('default', TRUE);
    	if ($startDatetime)
    		$dbObj->where('added_datetime>', $startDatetime.'00:00:00');
//     	if ($endDatetime)
//     		$dbObj->where('added_datetime<', $endDatetime);
    	$dbObj->join('room', 'room.id=alert_realtime.room_id');
    	$dbObj->join('substation', 'substation.id=room.substation_id');
    	if ($cityCode) {
    		if (is_array($cityCode))
    			$dbObj->where_in('substation.city_code', $cityCode);
    		else
    			$dbObj->where('substation.city_code', $cityCode);
    	}
    	if ($countyCode) {
    		if (is_array($countyCode))
    			$dbObj->where_in('substation.county_code', $countyCode);
    		else
    			$dbObj->where('substation.county_code', $countyCode);
    	}
    	if (count($status)) {
    		$dbObj->where_in('alert_realtime.status', $status);
    	}

    	$dbObj->group_by('alert_realtime.level');
    	$dbObj->order_by('alert_realtime.level', 'asc');
    	$dbObj->select('alert_realtime.level,count(*) as count');
    	$ret = $dbObj->get('alert_realtime')->result();
    	//echo $dbObj->last_query();
    	return $ret;
    }

    function Delete_DeviceDynamicConfig ($dc_id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $dc_id);
        $dbObj->delete('device_dynamic_config');
    }

    function Get_DeviceDynamicConfig ($data_id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('data_id', $data_id);
        return $dbObj->get('device_dynamic_config')->result();
    }
    
    function Get_NetworkSubstationConfig($substation_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('substation_id', $substation_id);
    	return $dbObj->get('network_substation_config')->result();
    }
    
    function Get_PerforSubstationConfig($substation_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('substation_id', $substation_id);
    	return $dbObj->get('perfor_substation_config')->result();
    }
    
    function Get_NetworkSubstationConf($substation_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('substation_id', $substation_id);
    	return $dbObj->get('network_substation_config')->row();
    }
    function Get_PerforSubstationConf($substation_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('substation_id', $substation_id);
    	return $dbObj->get('perfor_substation_config')->row();
    }

    function Save_DeviceDynamicConfig ($dc_id, $data_id, $dc_name, $dc_script, $dc_config = null)
    {
        $dbObj = $this->load->database('default', TRUE);
        if ($dc_name)
            $dbObj->set('dc_name', $dc_name);
        if ($dc_script)
            $dbObj->set('dc_script', $dc_script);
        if ($dc_config != null) {
            $dbObj->set('dc_config', $dc_config);
        }
        if ($dc_id) {
            $dbObj->where('id', $dc_id);
            return $dbObj->update('device_dynamic_config');
        } else {
            $dbObj->set('data_id', $data_id);
            // $dbObj->set('data_id', '');
            return $dbObj->insert('device_dynamic_config');
        }
    }

    function Get_record($offset = 0, $size = 0){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->order_by('rkerecord.rke_time', 'desc');
    	if ($size == 0)
    		return $dbObj->get('rkerecord')->result();
    	else
    		return $dbObj->get('rkerecord', $size, $offset)->result();
    }
    function insert_record($method,$s,$result){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->set('method', $method);
    	$rke_username=$_SESSION['XJTELEDH_USERNAME'];
    	$rke_userID=$_SESSION['XJTELEDH_USERID'];
    	$dbObj->set('user_id', $rke_userID);
    	$dbObj->set('rke_username', $rke_username);
    	//$dbObj->set('rke_result', $result);
    	$dbObj->set('rke_time', $s);      	
    	$dbObj->insert('rkerecord');   	
    	return $dbObj->insert_id();
    }
    function up_record($userid,$result){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('rke_id',$userid);
    	$dbObj->set('rke_result',$result);
    	$dbObj->update('rkerecord');
    	return $dbObj;
    }
    function userlist($roomid,$offset = 0, $size = 0){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('user_privilege', 'user_privilege.user_id=user.id');
    	$dbObj->select('user.*,user_privilege.*');
    		return $dbObj->get('user')->result();
    }
    function userlists($roomid){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('substation', 'substation.id=user.substation_id');
    	$dbObj->join('user_privilege', 'user_privilege.user_id=user.id');
    	$dbObj->where('substation.name', $roomid);
    	//$dbObj->where_in('dev_privilege',"access");
    	$dbObj->select('user.*,user_privilege.dev_privilege');
    	return $dbObj->count_all_results("user");
    	
    }
    function rkedown($roomid){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('substation', 'substation.id=user.substation_id');
    	$dbObj->where('substation.name', $roomid);
    	return $dbObj->get('user')->result();
    }
    function Get_device2($access,$areaPrivilegeArr){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('room', 'room.id=device.room_id');
    	$dbObj->where_in('room.substation_id', $areaPrivilegeArr);
    	$dbObj->where('device.model', $access);
        $dbObj->select('device.data_id');
    	return $dbObj->get('device')->result();
    }
    function Get_user2($userId){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('user.id', $userId);
    	$dbObj->select('user.accessid');
    	return $dbObj->get('user')->row();
    }
    function Get_user_privilege($userId){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('user_privilege.user_id', $userId);
    	$dbObj->select('user_privilege.area_privilege');
    	return $dbObj->get('user_privilege')->result();
    }
    function deleteroom($roomid){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id', $roomid);
    	 $dbObj->delete('room');
    	 return $dbObj;
    }
    function Get_room_device()
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$query = $dbObj->query("select * from device where device.room_id not in (select room.id from room) or device.room_id=''");
    	return $query->result();
    }
    function Get_sdevice_device()
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$query = $dbObj->query("select * from device where device.smd_device_no not in (select smd_device.device_no from smd_device) or device.smd_device_no=''");
    	return $query->result();
    }
    function Get_room_smd_device()
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$query = $dbObj->query("select * from smd_device where smd_device.room_id not in (select room.id from room) or smd_device.room_id=''");
    	return $query->result();
    }
    function Get_alertWhitelist(){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->select('alert_whitelist.data_id');
    	return $dbObj->get('alert_whitelist')->result_array();
    }
    function Insert_white($dataid){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('data_id', $dataid);
    	$deviceObj = $dbObj->get('device')->row();
    	
    	$dbObj->where('data_id', $dataid);
    	$alertWhitelistObj = $dbObj->get('alert_whitelist')->row();
    	if($alertWhitelistObj){
    		$dbObj->where('data_id', $dataid);
    		$dbObj->delete('alert_whitelist');
    		return 1;
    	}else{
    		$dbObj->set('data_id',$deviceObj->data_id);
    		$dbObj->set('added_datetime',$deviceObj->save_datetime);
    		$dbObj->insert('alert_whitelist');
    		return 2;
    	}
    }
    function Get_dataid_list($cityCode = 0, $countyCode = 0, $substationId = 0, $roomId = 0, $smd_device_no = 0)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('room', 'room.id = device.room_id');
    	$dbObj->join('substation', 'substation.id = room.substation_id');
    	$dbObj->join('smd_device', 'smd_device.device_no = device.smd_device_no');
    	if ($cityCode)
    		$dbObj->where('substation.city_code', $cityCode);
    	if ($countyCode)
    		$dbObj->where('substation.county_code', $countyCode);
    	if ($substationId)
    		$dbObj->where('substation.id', $substationId);
    	if ($roomId)
    		$dbObj->where('room.id', $roomId);
    	if ($smd_device_no)
    		$dbObj->where('smd_device.device_no', $smd_device_no);
    	if (count($devModel))
    		$dbObj->where_in('device.model', $devModel);
    	$dbObj->where('smd_device_no', $smd_device_no);
    	$dbObj->select('device.*,room.name as room_name,substation.*,smd_device.name as smd_device_name');
	    return $dbObj->get('device')->result();
    }
    function Get_Max_data_id($smd_device_no)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('smd_device_no', $smd_device_no);
    	$dbObj->select_max('data_id');
    	return $dbObj->get('device')->row();
    }
    function Get_All_data_id(){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->select('data_id');
    	return $dbObj->get('device')->result();
    }
    function add_camera_devgroup($room_id,$data_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('room_id', $room_id);
    	$dbObj->where('model', 'camera');
    	$dbObj->set('dev_group',$data_id);
    	return $dbObj->update('device');
    }
    function Get_vcamera_dataid($room_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('room_id', $room_id);
    	$dbObj->where('model', 'vcamera');
    	$dbObj->select('data_id');
    	return $dbObj->get('device')->result();
    }
    function write_camera_devgroup($new_data_id,$dev_group)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('data_id', $new_data_id);
    	$dbObj->set('dev_group',$dev_group);
    	return $dbObj->update('device');
    }
	function Get_station($stationName = false,$selCity = false,$selCounty = false,$cityCode = false, $offset = 0, $size = 0){
		$dbObj = $this->load->database('default', TRUE);
// 		$dbObj->where('lng !=', "0");
// 		$dbObj->where('lat !=', "0");
       // var_dump($selCity).die;
		if($selCity)
			$dbObj->like('city_code', $selCity);
		if($selCounty)
			$dbObj->like('county_code', $selCounty);
		if($stationName)
			$dbObj->like('name', $stationName);
		if($cityCode)
			$dbObj->where('city_code',$cityCode);
		$dbObj->select('substation.id,substation.name,substation.lng,substation.lat,substation.UploadTime');
		if ($size == 0)
			return $dbObj->get('substation')->result();
		else
			return $dbObj->get('substation', $size, $offset)->result();
	}
	function Get_station_count($stationName = false,$selCity = false,$selCounty = false, $cityCode = false){
		$dbObj = $this->load->database('default', TRUE);
		// 		$dbObj->where('lng !=', "0");
		// 		$dbObj->where('lat !=', "0");
		if($selCity)
			$dbObj->like('city_code', $selCity);
		if($selCounty)
			$dbObj->like('county_code', $selCounty);
		if($stationName)
			$dbObj->like('name', $stationName);
		if($cityCode)
			$dbObj->where('city_code',$cityCode);
		$dbObj->select('substation.id,substation.name,substation.lng,substation.lat,substation.UploadTime');
		return $dbObj->count_all_results("substation");
	}
	function Get_Group($substation_id){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('substation_id', $substation_id);
		$dbObj->distinct('newGrouping');
		$dbObj->select('newGrouping');
		return $dbObj->get('stationimage')->result();
	}
	function Get_stationimg($id = false,$GroupingName = false){
		$dbObj = $this->load->database('default', TRUE);
		if($id)
		$dbObj->where('substation_id', $id);
		if($GroupingName)
		$dbObj->where('newGrouping', $GroupingName);
		return $dbObj->get('stationimage')->result();
	}
	function Get_stationimgs(){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->select('stationImage');
		return $dbObj->get('stationimage')->result_array();
	}
	function Get_Stationimage($id = false){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('id', $id);
		return $dbObj->get('stationimage')->row();
	}
	function Get_SubstationGatherCount($id){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('id', "$id");
		$dbObj->select('substation.stationImage');
		return $dbObj->get('substation')->result();
	}
	function add_enviroment_devgroup($room_id,$data_id,$device_model)
	{
		$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('room_id', $room_id);
    	$dbObj->where_in('model', $device_model);
    	$dbObj->set('dev_group',$data_id);
    	return $dbObj->update('device');
	}
	function Get_venv_dataid($room_id)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('room_id', $room_id);
		$dbObj->where('model', 'venv');
		$dbObj->select('data_id');
		return $dbObj->get('device')->row();
	}
	function write_enviroment_devgroup($new_data_id,$dev_group)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('data_id', $new_data_id);
		$dbObj->set('dev_group',$dev_group);
		return $dbObj->update('device');
	}
	function Get_venv($room_id)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('room_id', $room_id);
		$dbObj->where('model', 'venv');
		$dbObj->select('data_id');
		return $dbObj->get('device')->row();
	}
	function Get_city_code($roomid)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->join('room', 'substation.id=room.substation_id');
		$dbObj->where('room.id', $roomid);
		$dbObj->select('substation.city_code');
		return $dbObj->get('substation')->row();
	}
	function Add_venv($smd_device_no, $room_id, $name, $data_id,$active)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->set('smd_device_no',$smd_device_no);
		$dbObj->set('room_id',$room_id);
		$dbObj->set('name',$name);
		$dbObj->set('data_id',$data_id);
		$dbObj->set('model','venv');
		$dbObj->set('save_datetime', 'now()', FALSE);
		$dbObj->set('active', $active);
		$dbObj->set('memo','');
		$dbObj->set('threshold_setting','');
		$new_obj = clone ($dbObj);
		return $dbObj->insert('device');
	}
	function Get_vcam($room_id)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('room_id', $room_id);
		$dbObj->where('model', 'vcamera');
		$dbObj->select('data_id');
		return $dbObj->get('device')->row();
	}
	function Add_vcam($smd_device_no, $room_id, $name, $data_id,$active)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->set('smd_device_no',$smd_device_no);
		$dbObj->set('room_id',$room_id);
		$dbObj->set('name',$name);
		$dbObj->set('data_id',$data_id);
		$dbObj->set('model','vcamera');
		$dbObj->set('save_datetime', 'now()', FALSE);
		$dbObj->set('active', $active);
		$dbObj->set('memo','');
		$dbObj->set('threshold_setting','');
		$new_obj = clone ($dbObj);
		return $dbObj->insert('device');
	}
	function Search_Substation_Count($name, $city_code='', $substationIdList = array())
	{
	    $dbObj = $this->load->database('default', TRUE);
	    if(!empty($city_code))
	        $dbObj->where('city_code', $city_code);
	    if(!empty($name))
	    {
	        $dbObj->group_start();
	        $dbObj->like('name', $name);
	        $dbObj->or_like('Stationcode', $name);
	        $dbObj->group_end();
	    }
	    if(count($substationIdList))
	    {
	        $dbObj->where_in('id', $substationIdList);
	    }
	    return $dbObj->count_all_results("substation");
	}
	
	function Search_Substation($name, $city_code='', $substationIdList = array(), $size=0, $offset=0, $gCounty = false)
	{
		$dbObj = $this->load->database('default', TRUE);
		if(!empty($city_code))
			$dbObj->where('city_code', $city_code);
		if(!empty($name))
		{
			foreach($gCounty as $key => $val){
				foreach($val as $k => $v){
					if($v == $name){
						$name = $k;
					}
				}
			}
    		$dbObj->group_start();
    		$dbObj->like('name', $name);
    		$dbObj->or_like('Stationcode', $name);
    		$dbObj->group_end();
		}
		if(count($substationIdList))
		{
		    $dbObj->where_in('id', $substationIdList);
		}
		$dbObj->select('*');
		$dbObj->order_by("type asc","convert(name using gbk) asc");
		if($size == 0)
		{
            return $dbObj->get('substation')->result();
		}else{
		    return $dbObj->get('substation', $size, $offset)->result();
		}
	}
	function Get_County_code($county)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('county', $county);
		$dbObj->select('county_code');
		return $dbObj->get('substation')->row();
	}
	function Get_room_name($room_id)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('id', $room_id);
		$dbObj->select('name');
		return $dbObj->get('room')->row();
	}
	function Insert_lonLat($stationName,$longitude,$latitude,$stationImage,$newGrouping){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->set('name',$stationName);
		$dbObj->set('lng',$longitude);
		$dbObj->set('lat',$latitude);
		$dbObj->set('UploadTime', 'now()', FALSE);
		$dbObj->insert("substation");
	    $id = $dbObj->insert_id();
	    for($i=0;$i<count($stationImage);$i++){
	    $dbObj->set('substation_id',$id);
	    $dbObj->set('stationImage',$stationImage[$i]);
	    if($newGrouping)
	    $dbObj->set('newGrouping',$newGrouping);
	    $dbObj->insert('stationimage');
	    }
	    return  $dbObj;
	}
	function Delete_Img($imgName){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('id',$imgName);
		return $dbObj->delete('stationimage');
	}
	function Delete_ImgApi($id){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('substation_id',$id);
		return $dbObj->delete('stationimage');
	}
	function Get_stationimGnewGrouping($id = false){
		$dbObj = $this->load->database('default', TRUE);
		if($id)
			$dbObj->where("substation_id",$id);
		$dbObj->distinct('newGrouping');
		$dbObj->select('newGrouping');
		return $dbObj->get('stationimage')->result();
	}
	function get_Img($imgName = false){
		$dbObj = $this->load->database('default', TRUE);
		if($imgName)
		$dbObj->where('id',$imgName);
		return $dbObj->get('stationimage')->row();
	}
	function get_Imgs($id = false){
		$dbObj = $this->load->database('default', TRUE);
		if($id)
			$dbObj->where('substation_id',$id);
		return $dbObj->get('stationimage')->result();
	}
	function get_roompr(){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->join('device','device.room_id=room.id');
		$dbObj->where('device.model','temperature');
		$dbObj->select('room.*,device.id as devId,device.name as devName');
		return $dbObj->get('room')->result();
	}
//	function get_roomprId($id = false){
//		$dbObj = $this->load->database('default', TRUE);
//		$dbObj->where('id',$id);
//		return $dbObj->get('room')->result();
//	}
	function Get_devicepr(){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->join('room','room.id=device.room_id','left');
		$dbObj->where('device.model','temperature');
		$dbObj->select('room.*,device.id as devId,device.name as devName');
		return $dbObj->get('device')->result();
	}
	function Get_deviceDataId(){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->join('room','room.id=device.room_id','left');
		$dbObj->where('device.model','power_302a');
		$dbObj->select('room.*,device.id as devId,device.name as devName,device.data_id as dataId');
		return $dbObj->get('device')->result();
	}
	function get_vdevice()
	{
		$dbObj = $this->load->database('default', TRUE);
		$name = array("机房环境","监控设备");
		$dbObj->where_in('name',$name);
		return $dbObj->get('device')->result();
	}
	function set_vdevice_name($data_id,$name)
	{
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where_in('data_id',$data_id);
		$dbObj->set('name',$name);
		return $dbObj->update('device');
	}
	function get_user_by_substation_id($substation_id)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->where('substation_id', $substation_id);
	    return $dbObj->get('user')->result();
	}
	
	function Add_Door_Operate($data_id, $operator_id, $user_id, $action)
	{
	    $assignerObj = User::GetUserById($operator_id);
	    $userObj = User::GetUserById($user_id);
        
	    $msg = "";
	    switch ($action)
	    {
	        case "assign":
	            $msg = $assignerObj->full_name."授权".$userObj->full_name."门禁权限";
	            break;
	        case "revoke":
	            $msg = $assignerObj->full_name."移除".$userObj->full_name."门禁权限";
	            break;
	        default:
	            $msg = $assignerObj->full_name."对".$userObj->full_name."进行未知操作".$action;
	            break;
	    }
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->set('data_id', $data_id);
	    $dbObj->set('operator_id', $operator_id);
	    $dbObj->set('user_id', $user_id);
	    $dbObj->set('desc', $msg);
	    $dbObj->set('added_datetime', 'now()', false);
	    $dbObj->insert('door_operate');
	}
	
	function Get_Door_Operate_Count($data_id=false,$user_id=false, $operator_name=false,$operator_mobile=false,$full_name=false, $mobile=false, $card='', $time_rangeArr='', $selCity = false, $gCounty=false)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    if($data_id)
	       $dbObj->where('door_operate.data_id', $data_id);
	    if($user_id)
	        $dbObj->where('user_id', $user_id);
	    if(!empty($operator_name))
	    {
	    	$dbObj->like('b.full_name', $operator_name);
	    }
	    if(!empty($operator_mobile))
	    {
	    	$dbObj->like('b.mobile', $operator_mobile);
	    }
	    if(!empty($full_name))
	    {
	    	$dbObj->like('a.full_name', $full_name);
	    }
	    if(!empty($mobile))
	    {
	    	$dbObj->like('a.mobile', $mobile);
	    }
	    if(count($time_rangeArr) == 2)
	    {
	    	$dbObj->where('door_record.added_datetime >=',$time_rangeArr[0]." 00:00:00");
	    	$dbObj->where('door_record.added_datetime <=',$time_rangeArr[1]." 23:59:59");
	    }
	    $dbObj->order_by('door_operate.id', 'desc');
	    $dbObj->join("user a", "door_operate.user_id=a.id");
	    $dbObj->join("user b", "door_operate.operator_id=b.id");
	    $dbObj->join('device', 'door_operate.data_id=device.data_id');
	    $dbObj->join('room', 'room.id=device.room_id');
	    $dbObj->join('substation', 'substation.id=room.substation_id');
	    return $dbObj->count_all_results("door_operate");
	}
	
	function Get_Door_Operate_List( $data_id=false,$user_id=false,$operator_name=false,$operator_mobile=false,$full_name=false, $mobile=false, $card='', $time_rangeArr='',$size=20, $offset=0, $selCity = false, $gCounty)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    if($data_id)
	       $dbObj->where('door_operate.data_id', $data_id);
	    if($user_id)
	        $dbObj->where('user_id', $user_id);
	     
	    if(!empty($operator_name))
	    {
	    	$dbObj->like('b.full_name', $operator_name);
	    }
	    if(!empty($operator_mobile))
	    {
	    	$dbObj->like('b.mobile', $operator_mobile);
	    }
	    if(!empty($full_name))
	    {
	    	$dbObj->like('a.full_name', $full_name);
	    }
	    if(!empty($mobile))
	    {
	    	$dbObj->like('a.mobile', $mobile);
	    }
	    if(count($time_rangeArr) == 2)
	    {
	    	$dbObj->where('door_record.added_datetime >=',$time_rangeArr[0]." 00:00:00");
	    	$dbObj->where('door_record.added_datetime <=',$time_rangeArr[1]." 23:59:59");
	    }
	    $dbObj->order_by('door_operate.id', 'desc');
	    $dbObj->join("user a", "door_operate.user_id=a.id");
	    $dbObj->join("user b", "door_operate.operator_id=b.id");
	    $dbObj->join('device', 'door_operate.data_id=device.data_id');
	    $dbObj->join('room', 'room.id=device.room_id');
	    $dbObj->join('substation', 'substation.id=room.substation_id');
	    $dbObj->select("device.name,room.name as room_name,substation.city_code,substation.county_code,substation.name as substation_name,a.full_name,a.mobile,b.full_name as operator_name, b.mobile as operator_mobile,door_operate.desc, door_operate.added_datetime");
	    return $dbObj->get('door_operate', $size, $offset)->result();
	}
	
	function Get_Door_Record_Count( $data_id = false,$user_id = false, $cityCode=false, $countyCode=false, $substationId=false, $roomId=false, $username='', $mobile='', $card='', $time_rangeArr='',$selCity = false ,$gCounty=false)
	{
	     $dbObj = $this->load->database('default', TRUE);
	if($data_id)
	       $dbObj->where('door_record.data_id', $data_id);
	    if($user_id)
	        $dbObj->where('user_id', $user_id);
	    if(!empty($username))
	    {
	        $dbObj->like('user.full_name', $username);
	    }
	    if(!empty($cityCode))
	    {
	    	$dbObj->where('substation.city_code', $cityCode);
	    }
	    if(!empty($countyCode))
	    {
	    	$dbObj->where('substation.county_code', $countyCode);
	    }
	    if(!empty($substationId))
	    {
	    	$dbObj->where('substation.id', $substationId);
	    }
	    if(!empty($roomId))
	    {
	    	$dbObj->where('room.id', $roomId);
	    }
	    if(!empty($mobile))
	    {
	        $dbObj->like('user.mobile', $mobile);
	    }
	    if(!empty($card))
	    {
	        $dbObj->where('card_no', $card);
	    }
	    if ($selCity){
	    	$dbObj->where('substation.city_code',$selCity);
	    }
	    if(count($time_rangeArr) == 2)
	    {
	        $dbObj->where('door_record.added_datetime >=',$time_rangeArr[0]." 00:00:00");
	        $dbObj->where('door_record.added_datetime <=',$time_rangeArr[1]." 23:59:59");
	    }
	    $dbObj->order_by('door_record.id', 'desc');
	    $dbObj->join("user", "door_record.user_id=user.id",'left');
	    $dbObj->join('device', 'door_record.data_id=device.data_id');
	    $dbObj->join('room', 'room.id=device.room_id','left');
	    $dbObj->join('substation', 'substation.id=room.substation_id','left');
	    return $dbObj->count_all_results("door_record");
	}
	function Get_Operate_Door_List($user_id = false , $substationId = false, $roomId = false, $subName = false ,$cityCode = false, $countyCode = false, $time_rangeArr='',$size=20, $offset=0, $selCity= false )
	{
		$dbObj = $this->load->database('default', TRUE);

		if($user_id)
			$dbObj->where('door_operate.user_id', $user_id);
		if(!empty($cityCode))
		{
			$dbObj->where('substation.city_code', $cityCode);
		}
		if(!empty($countyCode))
		{
			$dbObj->where('substation.county_code', $countyCode);
		}
		if(!empty($substationId))
		{
			$dbObj->where('substation.id', $substationId);
		}
		if(!empty($roomId))
		{
			$dbObj->where('room.id', $roomId);
		}
		if(!empty($subName))
		{
			$dbObj->where('device.name', $subName);
		}		
		if(count($time_rangeArr) == 2)
		{
			$dbObj->where('door_record.added_datetime >=',$time_rangeArr[0]." 00:00:00");
			$dbObj->where('door_record.added_datetime <=',$time_rangeArr[1]." 23:59:59");
		}
		if ($selCity){
			$dbObj->where('substation.city_code',$selCity);
		}
		$dbObj->order_by('door_operate.id', 'desc');
		$dbObj->join("user a", "door_operate.user_id=a.id");
		$dbObj->join("user b", "door_operate.operator_id=b.id");
		$dbObj->join('device', 'door_operate.data_id=device.data_id');
		$dbObj->join('room', 'room.id=device.room_id');
		$dbObj->join('substation', 'substation.id=room.substation_id');
		$dbObj->select("device.name,room.name as room_name,substation.city_code,substation.county_code,substation.name as substation_name,a.full_name,a.mobile,b.full_name as operator_name, b.mobile as operator_mobile,door_operate.desc, door_operate.added_datetime");
		return $dbObj->get('door_operate', $size, $offset)->result();
	}
	function Get_Operate_Door_Count($user_id=false,$substationId = false, $roomId = false, $subName =false ,$cityCode =false, $countyCode =false, $time_rangeArr='', $selCity = false, $gCounty)
	{
		$dbObj = $this->load->database('default', TRUE);
		
		
	    if($user_id)
			$dbObj->where('door_operate.user_id', $user_id);
		if(!empty($cityCode))
		{
			$dbObj->where('substation.city_code', $cityCode);
		}
		if(!empty($countyCode))
		{
			$dbObj->where('substation.county_code', $countyCode);
		}
		if(!empty($substationId))
		{
			$dbObj->where('substation.id', $substationId);
		}
		if(!empty($roomId))
		{
			$dbObj->where('room.id', $roomId);
		}
		if(!empty($subName))
		{
			$dbObj->where('device.name', $subName);
		}
		
		if(count($time_rangeArr) == 2)
		{
			$dbObj->where('door_record.added_datetime >=',$time_rangeArr[0]." 00:00:00");
			$dbObj->where('door_record.added_datetime <=',$time_rangeArr[1]." 23:59:59");
		}
		if ($selCity){
			$dbObj->where('substation.city_code',$selCity);
		}
		$dbObj->order_by('door_operate.id', 'desc');
		$dbObj->join("user a", "door_operate.user_id=a.id");
		$dbObj->join("user b", "door_operate.operator_id=b.id");
		$dbObj->join('device', 'door_operate.data_id=device.data_id');
		$dbObj->join('room', 'room.id=device.room_id');
		$dbObj->join('substation', 'substation.id=room.substation_id');
		return $dbObj->count_all_results("door_operate");
	}
	function Get_Door_Record_List($data_id=false,$user_id=false, $cityCode=false, $countyCode=false, $substationId=false, $roomId=false, $username='', $mobile='', $card='', $time_rangeArr='',  $size=20, $offset=0 ,$selCity= false)
	{
	    $dbObj = $this->load->database('default', TRUE);
	     if($data_id)
	       $dbObj->where('door_record.data_id', $data_id);
	    if($user_id)
	        $dbObj->where('user_id', $user_id);
	    if(!empty($cityCode))
	    {
	    	$dbObj->where('substation.city_code', $cityCode);
	    }
	    if(!empty($countyCode))
	    {
	    	$dbObj->where('substation.county_code', $countyCode);
	    }
	    if(!empty($substationId))
	    {
	    	$dbObj->where('substation.id', $substationId);
	    }
	    if(!empty($roomId))
	    {
	    	$dbObj->where('room.id', $roomId);
	    }
	    if(!empty($username))
	    {
	        $dbObj->like('user.full_name', $username);
	    }
	    if(!empty($mobile))
	    {
	        $dbObj->like('user.mobile', $mobile);
	    }
	    if(!empty($card))
	    {
	        $dbObj->where('card_no', $card);
	    }
	    if ($selCity){
	    	$dbObj->where('substation.city_code',$selCity);
	    }
	    if(count($time_rangeArr) == 2)
	    {
	        $dbObj->where('door_record.added_datetime >=',$time_rangeArr[0]." 00:00:00");
	        $dbObj->where('door_record.added_datetime <=',$time_rangeArr[1]." 23:59:59");
	    }
	    $dbObj->order_by('door_record.id', 'desc');
	    $dbObj->join("user", "door_record.user_id=user.id",'left');
	    $dbObj->join('device', 'door_record.data_id=device.data_id');
	    $dbObj->join('room', 'room.id=device.room_id','left');
	    $dbObj->join('substation', 'substation.id=room.substation_id','left');
	    $dbObj->select("device.name,room.name as room_name,substation.city_code,substation.county_code,substation.Stationcode,substation.name as substation_name,user.full_name,user.mobile,door_record.*");
	    $ret = $dbObj->get('door_record', $size, $offset)->result();
	    //echo $dbObj->last_query();
	    return $ret;
	}
	
	function Reset_UserDoor($user_id)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->where('user_id',$user_id);
	    $dbObj->where('status','已下发');
	    $dbObj->set('status','待下发');
	    $dbObj->update('door_user');
	}
	function Reset_DoorUser($data_id)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->where('data_id',$data_id);
	    $dbObj->where('status','已下发');
	    $dbObj->set('status','待下发');
	    $dbObj->update('door_user');
	}
	function Get_DoorUser($data_id, $user_id)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->where('data_id',$data_id);
	    $dbObj->where('user_id', $user_id);
	    $dbObj->where('status <>','待删除');
	    return $dbObj->get('door_user')->row();
	}
	function Door_Add_User($data_id, $user_id, $assigner_id, $expire_date, $card_control, $remote_control)
	{	    
	    $this->Add_Door_Operate($data_id, $assigner_id, $user_id, "assign");
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->where('data_id',$data_id);
	    $dbObj->where('user_id', $user_id);
	    $row = $dbObj->get("door_user")->row();
	    

	    $dbObj->set('assigner_id', $assigner_id);
	    $dbObj->set('status','待下发');
	    $dbObj->set('added_datetime', 'now()', false);
	    if(!empty($expire_date))
	    {
	        $dbObj->set("expire_date", $expire_date);
	    }else{
	        $dbObj->set('expire_date', '2050-12-31');
	    }
	    if($card_control == "true")
	    {
	        $dbObj->set('card_control', 1);
	    }else{
	        $dbObj->set('card_control', 0);
	    }
	    if($remote_control == "true")
	    {
	        $dbObj->set('remote_control', 1);
	    }else{
	        $dbObj->set('remote_control', 0);
	    }	    
	    if(count($row))
	    {
	        $dbObj->where('id', $row->id);	        
	        $dbObj->update('door_user');
	    }else{
    	    $dbObj->set('data_id', $data_id);
    	    $dbObj->set('user_id', $user_id);
    	    $dbObj->insert('door_user');
	    }
	}
	function User_Remove_DoorArr($user_id, $operator_id, $dataIdArr)
	{
	    foreach($dataIdArr as $data_id)
	    {
	        $this->Add_Door_Operate($data_id, $operator_id, $user_id, "revoke");
	    }
	     
	    $dbObj = $this->load->database('default', TRUE);
	    $userObj = User::GetUserById($user_id);
	    $dbObj->where_in('data_id', $dataIdArr);
	    $dbObj->where('user_id', $user_id);
	    if(empty($userObj->accessid))
	    {
	        
	        //delete directly
	        $dbObj->delete('door_user');
	    }else{
	        $delDbObj = clone($dbObj);
    	    $dbObj->where('card_control',1);    	    
    	    $dbObj->set('status','待删除');
    	    $dbObj->update('door_user');
    	    $delDbObj->where('card_control', 0);
    	    $delDbObj->delete('door_user');
    	    echo $delDbObj->last_query();die("hello");
	    }
	}
	
	function Door_Remove_UserArr($data_id, $operator_id, $doorUserIdArr)
	{
	    foreach($doorUserIdArr as $user_id)
	    {
	        $this->Add_Door_Operate($data_id, $operator_id, $user_id, "revoke");
	    }	    
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->where('data_id', $data_id);
	    $dbObj->where_in('user_id', $doorUserIdArr);
	    $delDbObj = clone($dbObj);
	    $dbObj->where('card_control',1);
	    $dbObj->set('status','待删除');
	    $dbObj->update('door_user');
	    $delDbObj->where('card_control', 0);
	    $delDbObj->delete('door_user');
	    //全查一遍,移除待删除但是没卡号的
	    $dbObj->join('user','door_user.user_id=user.id');
	    $dbObj->where('user.accessid','');
	    $dbObj->where('door_user.status','待删除');
	    $dbObj->select('door_user.id');
	    $duList = $dbObj->get('door_user')->result();
	    $idArr = array();
	    foreach($duList as $duObj)
	    {
	        array_push($idArr, $duObj->id);
	    }
	    if(count($idArr))
	    {
	       $dbObj->where_in("id", $idArr);
	       $dbObj->delete('door_user');
	    }
	}
	function Get_Door_User_Count($cityCode = false, $countyCode = false, $substationId = false, $username=false,$full_name=false, $mobile=false, $accessid=false, $assigner_name=false, $data_id, $selCity=false)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    
        $dbObj->where('door_user.data_id', $data_id);
	    $dbObj->join("user a", "door_user.user_id=a.id");
	    $dbObj->join("user b", "door_user.assigner_id=b.id",'left'); 
	    $dbObj->join('substation', 'a.substation_id=substation.id', 'left');
	    $dbObj->join('device', 'door_user.data_id=device.data_id');
	    $dbObj->join('smd_device', 'smd_device.device_no=device.smd_device_no');  
	    if ($cityCode)
	    	$dbObj->where('substation.city_code', $cityCode);
	    if ($countyCode)
	    	$dbObj->where('substation.county_code', $countyCode);
	    if ($substationId)
	    	$dbObj->where('substation.id', $substationId);
	    if ($selCity)
	    	$dbObj->where('substation.city_code',$selCity);
	    if ($username)
	    	$dbObj->like('a.username', $username);
	    if ($full_name)
	    	$dbObj->like('a.full_name', $full_name);
	    if ($mobile)
	    	$dbObj->like('a.mobile', $mobile);
	    if ($accessid)
	    	$dbObj->like('a.accessid',$accessid);
	    if ($assigner_name)
	    	$dbObj->like('b.full_name',$assigner_name);
	    return $dbObj->count_all_results('door_user');
	}
	
	function Get_Door_User_List($cityCode = false, $countyCode = false,$substationId = false,$username=false,$full_name=false, $mobile=false, $accessid=false, $assigner_name=false, $data_id, $size = 20, $offset=0, $selCity=false)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->where('door_user.data_id', $data_id);
	    $dbObj->join("user a", "door_user.user_id=a.id");
	    $dbObj->join("user b", "door_user.assigner_id=b.id",'left'); 
	    $dbObj->join('substation', 'a.substation_id=substation.id', 'left');
	    
	    $dbObj->join('device', 'door_user.data_id=device.data_id');
	    $dbObj->join('smd_device', 'smd_device.device_no=device.smd_device_no');
	    if ($cityCode)
	    	$dbObj->where('substation.city_code', $cityCode);
	    if ($countyCode)
	    	$dbObj->where('substation.county_code', $countyCode);
	    if ($substationId)
	    	$dbObj->where('substation.id', $substationId);
	    if ($selCity)
	    	$dbObj->where('substation.city_code',$selCity);
	    if ($username)
	    	$dbObj->like('a.username', $username);
	    if ($full_name)	    	
	        $dbObj->like('a.full_name', $full_name);	     
	    if ($mobile)
	    	$dbObj->like('a.mobile', $mobile);
	    if ($accessid)
	    	$dbObj->like('a.accessid',$accessid);
	    if ($assigner_name)
	    	$dbObj->like('b.full_name',$assigner_name);
	    if ($size == 0){
	    	$dbObj->select("door_user.delete_check_count,door_user.user_id,door_user.card_control,door_user.remote_control,a.username, a.full_name,a.mobile,a.accessid,substation.city_code,substation.county_code,substation.Stationcode,substation.name as statioin_name,b.full_name as assigner_name, door_user.added_datetime, door_user.status, door_user.down_datetime,door_user.expire_date,device.active as device_active,smd_device.active as smd_device_active");	    	
	    	return $dbObj->get('door_user',$size, $offset)->result();
	    }else{
	    	$dbObj->select("door_user.delete_check_count,door_user.user_id,door_user.card_control,door_user.remote_control,a.username, a.full_name,a.mobile,a.accessid,substation.city_code,substation.county_code,substation.Stationcode,substation.name as statioin_name,b.full_name as assigner_name, door_user.added_datetime, door_user.status, door_user.down_datetime,door_user.expire_date,device.active as device_active,smd_device.active as smd_device_active");	    	
	    	return $dbObj->get('door_user', $size, $offset)->result();
	    }
	    
	}
	
	function Get_User_Door_Count ($user_id, $cityCode = false, $countyCode = false,$substationId = false, $roomId = false, $smd_device_no = false, $devModel = array(), $active = 'all', $devName = '',$dataId = false, $selCity = false, $keyWord = false, $gCounty = false)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->join('room', 'room.id=device.room_id');
	    $dbObj->join('substation', 'substation.id=room.substation_id');
	    $dbObj->join('smd_device', 'smd_device.device_no=device.smd_device_no');
	    if ($cityCode)
	        $dbObj->where('substation.city_code', $cityCode);
	    if ($countyCode)
	        $dbObj->where('substation.county_code', $countyCode);
	    if ($substationId)
	        $dbObj->where('substation.id', $substationId);
	    if ($roomId)
	        $dbObj->where('room.id', $roomId);
	    if ($smd_device_no)
	        $dbObj->where('smd_device.device_no', $smd_device_no);
	    if (count($devModel))
	        $dbObj->where_in('device.model', $devModel);
	    if ($active == 'active' || $active == 'deactive')
	        $dbObj->where('device.active', $active == 'active');
	    if (strlen($devName))
	        $dbObj->like('device.name', $devName);
	    if ($dataId)
	        $dbObj->where('device.data_id', $dataId);
	    $dbObj->join('door_user','device.data_id=door_user.data_id');
	    if ($user_id)
	    $dbObj->where('door_user.user_id', $user_id);
	    if ($selCity){
	    	$dbObj->where('substation.city_code',$selCity);
	    }
	    if ($keyWord){
	    	foreach($gCounty as $key => $val){
	    		foreach($val as $k => $v){
	    			if($v == $keyWord){
	    				$keyWord = $k;
	    			}
	    		}
	    	}
	    	$dbObj->group_start();
	    	$dbObj->like('substation.name', $keyWord);
	    	$dbObj->or_like('room.name', $keyWord);
	    	$dbObj->or_like('device.name', $keyWord);
	    	$dbObj->or_like('substation.county_code', $keyWord);
	    	$dbObj->or_like('Stationcode', $keyWord);
	    	$dbObj->group_end();
	    }
	    return $dbObj->count_all_results("device");
	}
	function Get_User_Door_List ($user_id, $cityCode = false, $countyCode = false,$substationId = false, $roomId = false, $smd_device_no = false, $devModel = array(), $active = null, $devName = '', $offset = 0,
	        $size = 20, $dataId = false, $selCity = false, $keyWord = false, $gCounty = false)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->join('room', 'room.id=device.room_id');
	    $dbObj->join('substation', 'substation.id=room.substation_id');
	    $dbObj->join('smd_device', 'smd_device.device_no=device.smd_device_no');
	    if ($cityCode)
	        $dbObj->where('substation.city_code', $cityCode);
	    if ($countyCode)
	        $dbObj->where('substation.county_code', $countyCode);
	    if ($substationId)
	        $dbObj->where('substation.id', $substationId);
	    if ($roomId)
	        $dbObj->where('room.id', $roomId);
	    if ($smd_device_no)
	        $dbObj->where('smd_device.device_no', $smd_device_no);
	    if (count($devModel))
	        $dbObj->where_in('device.model', $devModel);
	    if ($active == 'active' || $active == 'deactive')
	        $dbObj->where('device.active', $active == 'active');
	    if (strlen($devName))
	        $dbObj->like('device.name', $devName);
	    if ($dataId)
	        $dbObj->where('device.data_id', $dataId);
	    $dbObj->join('door_user','device.data_id=door_user.data_id');
	    if ($user_id)
	        $dbObj->where('door_user.user_id', $user_id);
	    if ($selCity){
	    	$dbObj->where('substation.city_code',$selCity);
	    }
	    if ($keyWord){
	    	foreach($gCounty as $key => $val){
	    		foreach($val as $k => $v){
	    			if($v == $keyWord){
	    				$keyWord = $k;
	    			}
	    		}
	    	}
	    	$dbObj->group_start();
	    	$dbObj->like('substation.name', $keyWord);
	    	$dbObj->or_like('room.name', $keyWord);
	    	$dbObj->or_like('device.name', $keyWord);
	    	$dbObj->or_like('substation.county_code', $keyWord);
	    	$dbObj->or_like('Stationcode', $keyWord);
	    	$dbObj->group_end();
	    }
	    $dbObj->select('door_user.card_control, door_user.remote_control,door_user.status,device.*,room.id as roomId,room.name as room_name,substation.city_code,substation.county_code,substation.Stationcode,smd_device.name as smd_device_name,smd_device.active as smd_device_active,smd_device.ip,substation.name as suname');
	    if($size != -1){
	        $ret = $dbObj->get('device', $size, $offset)->result();
	        return $ret;
	    }else{
	        $ret = $dbObj->get('device')->result();
	        return $ret;
	    }
	    
	}
	
	function Get_Device_By_RoomId($room_id, $model)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->where('room_id', $room_id);
	    $dbObj->where_in("model", $model);
	    return $dbObj->get('device')->result();
	}
	function up_door_record($userid = false,$openMessage = false,$accessid = false,$action = false,$dataId = false){
		$dbObj = $this->load->database('default', TRUE);
		if($dataId)
			$dbObj->set('data_id',$dataId);
		if($userid)
			$dbObj->set('user_id',$userid);
		$dbObj->set('card_no','');
		if($action)
			$dbObj->set('action',$action);
		if($openMessage)
		$dbObj->set('desc',$openMessage);
		$dbObj->set('added_datetime','now()',false);
		return $dbObj->insert('door_record');
	}
	function Get_door_record($userId){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('user_id',$userId);
		$dbObj->where('desc !=','');
		return $dbObj->get('door_record')->row();
	}
	function Count_Img($id){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('substation_id',$id);
		$dbObj->group_by('substation_id');
		return $dbObj->count_all_results("stationimage");
	}
	function Get_Spdev_List()
	{
	    $dbObj = $this->load->database('default', TRUE);
	    return $dbObj->get('spdev_protocol')->result();
	}
	function Get_SevName($roomid = false){
		$dbObj = $this->load->database('default', TRUE);
		$dbObj->where('room_id',$roomid);
		$dbObj->select('name');
		return $dbObj->get('device')->result();
	}	
	function spdevManage($name = false, $baud_rate = false, $cmd = false, $reply = false, $offset = 0, $size = 0){
        $dbObj = $this->load->database('default', TRUE);   
        if ($name)
        	$dbObj->like('name', $name); 
        if ($baud_rate)
        	$dbObj->like('baud_rate', $baud_rate);
        if ($cmd)
        	$dbObj->like('cmd', $cmd);
        if ($reply)
        	$dbObj->like('reply', $reply);
        if ($size == 0){
        	$ret = $dbObj->get('spdev_protocol')->result();
        	return $ret;
        }else{
            $ret = $dbObj->get('spdev_protocol', $size, $offset)->result();
	        return $ret;
            }    	
    }
    function Get_Spdev_Count($name = false, $baud_rate = false, $cmd = false, $reply = false){
        $dbObj = $this->load->database('default', TRUE);       
        if ($name)
        	$dbObj->like('name', $name);
        if ($baud_rate)
        	$dbObj->like('baud_rate', $baud_rate);
        if ($cmd)
        	$dbObj->like('cmd', $cmd);
        if ($reply)
        	$dbObj->like('reply', $reply);    
        return $dbObj->count_all_results("spdev_protocol");
    }

	function DeleteManage($Manageid = false){
	    $dbObj = $this->load->database('default', TRUE);	
		$dbObj->where('id',$Manageid);
		return $dbObj->delete('spdev_protocol');
	}

	function Get_Power302aEC_DataId($cityCode, $countyCode, $substationId, $roomId, $ecType)
	{
	    $dbObj = $this->load->database('default', TRUE);
	    //First, Find all data_id
	    if(!empty($roomId))
	    {
	        $dbObj->where('room_id', $roomId);
	    }else if(!empty($substationId))
	    {
	        $dbObj->join('room','device.room_id=room.id');
	        $dbObj->where('room.substation_id', $substationId);
	    }else if(!empty($countyCode))
	    {
	        $dbObj->join('room','device.room_id=room.id');
	        $dbObj->join("substation", "room.substation_id=substation.id");
	        $dbObj->where('substation.county_code', $countyCode);
	    }else if(!empty($cityCode))
	    {
	        $dbObj->join('room','device.room_id=room.id');
	        $dbObj->join("substation", "room.substation_id=substation.id");
	        $dbObj->where('substation.city_code', $cityCode);
	    }
	    $dbObj->where('model','power_302a');
	    if($ecType == "0")
	    {
	        $dbObj->like("device.name","市电进入");
	    }else if($ecType == "1")
	    {
	        $dbObj->like("device.name","开关电源");
	    }else if($ecType == "2")
	    {
	        $dbObj->like("device.name","空调");
	    }
	    $dbObj->select("data_id");
	    $devList = $dbObj->get('device')->result();
	    $dataIdArr = array();
	    foreach($devList as $devObj)
	    {
	        array_push($dataIdArr, intval($devObj->data_id));
	    }
	    return $dataIdArr;
	}
	
	
	function Get_Power302aEC_List($dataIdArr,$ecGroup,$startDate ,$endDate){
	    $operation = array();
	    $operation[] = array('$match' => array("data_id"=>array('$in'=>$dataIdArr), "Date"=>array('$gte'=>$startDate, '$lte'=>$endDate)));
	    switch($ecGroup)
	    {
	        case "0":{
	            //时	            
	            $operation[] = [ '$group' => [ '_id' => [ "Date"=>'$Date', "Time"=>'$Time'] , 
	                                             'epa_sum' => ['$sum'=>'$epa'],
	                                             'epb_sum' => ['$sum'=>'$epb'],
	                                             'epc_sum' => ['$sum'=>'$epc'],
	                                             'ept_sum' => ['$sum'=>'$ept']
	                                           ]];
	            $operation[] = [ '$sort' => [ '_id.Date' => 1, '_id.Time' =>1] ];	            
	            break;
            }
	        case "1":
	            //日
	            $operation[] = [ '$group' => [ '_id' => [ "Date"=>'$Date'] ,
	            'epa_sum' => ['$sum'=>'$epa'],
	            'epb_sum' => ['$sum'=>'$epb'],
	            'epc_sum' => ['$sum'=>'$epc'],
	            'ept_sum' => ['$sum'=>'$ept']
	            ]];
	            $operation[] = [ '$sort' => [ '_id.Date' => 1] ];
	            break;
	        case "2":
	            //月
	            $operation[] = [ '$group' => [ '_id' => [ 'year' => [ '$substr'=> ['$Date', 0, 4] ],
                                    	            'month' => [ '$substr'=> ['$Date',5,2] ]],
                                    	            'epa_sum' => ['$sum'=>'$epa'],
                                    	            'epb_sum' => ['$sum'=>'$epb'],
                                    	            'epc_sum' => ['$sum'=>'$epc'],
                                    	            'ept_sum' => ['$sum'=>'$ept']
	            ]];
	            $operation[] = [ '$sort' => [ '_id.year' => 1, '_id.month'=>1] ];
	            break;
	        case "3":
	            //年
	            $operation[] = [ '$group' => [ '_id' => [ 'year' => [ '$substr'=> ['$Date', 0, 4] ]],
	            'epa_sum' => ['$sum'=>'$epa'],
	            'epb_sum' => ['$sum'=>'$epb'],
	            'epc_sum' => ['$sum'=>'$epc'],
	            'ept_sum' => ['$sum'=>'$ept']
	            ]];
	            $operation[] = [ '$sort' => [ '_id.year' => 1] ];
	            break;
	        case "4":
	            $operation[] = [ '$group' => [ '_id' => "NULL",
	            'ept_sum' => ['$sum'=>'$ept']
	            ]];
	            break;
	    }
	    $docs = $this->mongo_db->aggregate("power302a_hourly_ec",$operation);
	    return $docs;
	}
	
	
	function Get_Power302a_List($dataId = false,$startTime = false,$endTime = false,$offset = 0, $size = 20){
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where("data_id",intval($dataId));
		return $this->mongo_db->select(array("data_id","pa","pb","pc","pt","uaRms","ubRms","ucRms","iaRms","ibRms","icRms","itRms","freq","eqa","eqb","eqc","eqt","Date","Time"))->offset($offset)->limit($size)->get("power302a");
	}

	function Get_Power302a_Count($dataId,$startTime = false,$endTime = false){
	    
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where('data_id',intval($dataId));
		return $this->mongo_db->count('power302a');
	}
    
	function Get_battery24_List($dataId = false,$startTime = false,$endTime = false,$offset = 0, $size = 20){
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where("data_id",intval($dataId));
		return $this->mongo_db->select(array("Date","Time","data_id","battery_voltage","voltage","current","temperature"))->offset($offset)->limit($size)->get("battery24");
	}
	
	function Get_battery32_List($dataId = false,$startTime = false,$endTime = false,$offset = 0, $size = 20){
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where("data_id",intval($dataId));
		return $this->mongo_db->select(array("Date","Time","data_id","battery_voltage","voltage","current","temperature"))->offset($offset)->limit($size)->get("battery32");
	}
	
	function Get_humid_List($dataId = false,$startTime = false,$endTime = false,$offset = 0, $size = 20){
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where("data_id",intval($dataId));
		return $this->mongo_db->select(array("Date","Time","data_id","value"))->offset($offset)->limit($size)->get("HumidSensor");
	}
	
	function Get_temperature_List($dataId = false,$startTime = false,$endTime = false,$offset = 0, $size = 20){
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where("data_id",intval($dataId));
		return $this->mongo_db->select(array("Date","Time","data_id","value"))->offset($offset)->limit($size)->get("TemperatureSensor");
	}
	
	function Get_water_List($dataId = false,$startTime = false,$endTime = false,$offset = 0, $size = 20){
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where("data_id",intval($dataId));
		return $this->mongo_db->select(array("Date","Time","data_id","value"))->offset($offset)->limit($size)->get("WaterSensor");
	}
	
	function Get_fresh_air_List($dataId = false,$startTime = false,$endTime = false,$offset = 0, $size = 20){
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where("data_id",intval($dataId));
		return $this->mongo_db->select(array("Date","Time","data_id","temperature1","temperature2","temperature3","temperature4","temperature5","humidity1","humidity2","humidity3","humidity4"
				,"humidity5","wind_temperature","wind_humidity","outside_temperature","outside_humidity","humidifier_current","average_temperature","average_humidity","reserve_60_42_1"
				,"reserve_60_42_2","highest_temperature","runstate_alert","runstate_fan","runstate_r1","runstate_r2","runstate_r3","runstate_r4","runstate_drain","runstate_fill","runstate_pump"
				,"runstate_ac","alert","setting_temperature","setting_humidity","high_temperature_alert","low_temperature_alert","high_humidity_alert","low_humidity_alert"))->offset($offset)->limit($size)->get("fresh_air");
	}
	
	function Get_battery24_Count($dataId,$startTime = false,$endTime = false){
		 
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where('data_id',intval($dataId));
		return $this->mongo_db->count('battery24');
	}
	
	function Get_battery32_Count($dataId,$startTime = false,$endTime = false){
			
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where('data_id',intval($dataId));
		return $this->mongo_db->count('battery32');
	}
	
	function Get_humid_Count($dataId,$startTime = false,$endTime = false){
			
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where('data_id',intval($dataId));
		return $this->mongo_db->count('HumidSensor');
	}
	
	function Get_temperature_Count($dataId,$startTime = false,$endTime = false){
			
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where('data_id',intval($dataId));
		return $this->mongo_db->count('TemperatureSensor');
	}
	
	function Get_water_Count($dataId,$startTime = false,$endTime = false){
			
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where('data_id',intval($dataId));
		return $this->mongo_db->count('WaterSensor');
	}
	
	function Get_fresh_air_Count($dataId,$startTime = false,$endTime = false){
			
		if(!empty($startTime)){
			$this->mongo_db->where_gt('Date', $startTime);
		}
		if(!empty($endTime)){
			$this->mongo_db->where_lt('Date', $endTime);
		}
		$this->mongo_db->where('data_id',intval($dataId));
		return $this->mongo_db->count('fresh_air');
	}
	
	function Get_powermeter_history_LY(){
		$dbObj = $this->load->database('default', TRUE);
		$old = date('Y-m-d',time());
		$arr = explode("-",$old);	
		$new = date("Y-m-d", mktime(0,0,0,$arr[1],$arr[2],$arr[0]-1));
			$dbObj->where('update_datetime', $new . ' 00:01:00');	
			return $dbObj->get('device_power302a_history')->result();
	}

	function Get_powermeter_history_TY(){
		$dbObj = $this->load->database('default', TRUE);
		$old = date('Y-m-d',time());
		$dbObj->where('update_datetime', $old . ' 00:01:00');
		return $dbObj->get('device_power302a_history')->result();
	}
    function Update_spdevs($id, $name, $baud_rate, $cmd, $reply){
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->where('id',$id);
	    $dbObj->set('name',$name);
	    $dbObj->set('baud_rate',$baud_rate);
	    $dbObj->set('cmd',$cmd);
	    $dbObj->set('reply',$reply);
	    return $dbObj->update('spdev_protocol');
    }
     function Save_spdevs($name, $baud_rate, $cmd, $reply){
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->set('name', $name);
	    $dbObj->set('baud_rate',$baud_rate);
	    $dbObj->set('cmd', $cmd);
	    $dbObj->set('reply', $reply);
	    return $dbObj->insert('spdev_protocol');
    }
    function Get_spdev_protocol ($substation_id){
	    $dbObj = $this->load->database('default', TRUE);
	    $dbObj->where('id', $substation_id);
	    return $dbObj->get('spdev_protocol')->row();
    } 
    function Change_Status ($device_id, $status)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('user_id', $device_id);
    	$dbObj->set('status', $status);
    	return $dbObj->update('door_user');   
    	
    }
    function Get_NetWork ($type = false, $property = false, $element = false, $name = false, $substation_id = false, $array)
    {
    	 $dbObj = $this->load->database('default', TRUE); 
    	 $dbObj->join('substation_network', 'power_network.id=substation_network.network_id','left');
    	 if ($type)
    	 	$dbObj->where('type', $type);
    	 if ($property)
    	 	$dbObj->where('property', $property);
    	 if ($element)
    	 	$dbObj->where('element', $element);
    	 if ($name)
    	 	$dbObj->like('name', $name);
    	 if ($array)
    	 	$dbObj->where('network_id', $array);
    	 if ($substation_id)
    	 	$dbObj->where('substation_id', $substation_id);
    	 $dbObj->select('substation_network.*,power_network.id as network_id,power_network.*');
    	 return $ret = $dbObj->get('power_network')->row(); 
    }
    function Get_NetWork_List ($type = false, $property = false, $element = false, $name = false, $offset = 0, $size = 0)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if ($type)
    		$dbObj->where('type', $type);
    	if ($property)
    		$dbObj->where('property', $property);
    	if ($element)
    		$dbObj->where('element', $element);
    	if ($name)
    		$dbObj->like('name', $name);
    	$dbObj->select('*');
    	if ($size == 0){
    	    return $ret = $dbObj->get('power_network')->result();
    	}else{
    		return $ret = $dbObj->get('power_network', $size, $offset)->result();	
    	}
    	
    }
    
    function Get_NetWork_Not_Where ($type = false, $substation_id = false, $array)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if ($type)
    		$dbObj->where('type', $type);
    	if ($array)
    		$dbObj->where_not_in('power_network.id', $array);
    	$dbObj->select('power_network.id as network_id,power_network.*');
    	return $ret = $dbObj->get('power_network')->result();
    }

    function Get_Perfor_Not_Where ($substation_id = false, $array)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if ($array)
    		$dbObj->where_not_in('performance_manage.id', $array);
    	$dbObj->select('performance_manage.id as perfor_id,performance_manage.*');
    	return $ret = $dbObj->get('performance_manage')->result();
    }
    
    function Get_PerFor ($substation_id,$array)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('substation_perfor', 'performance_manage.id=substation_perfor.perfor_id','left');
    	if ($array)
    		$dbObj->where('perfor_id', $array);
    	if ($substation_id)
    		$dbObj->where('substation_id', $substation_id);
    	$dbObj->select('substation_perfor.*,performance_manage.id as perfor_id,performance_manage.*');
    	return $ret = $dbObj->get('performance_manage')->row();
    }
    function Get_NetWorkCount($type = false, $property = false, $element = false, $name = false)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('substation_network', 'power_network.id=substation_network.network_id','left');
    	if ($type)
    	 	$dbObj->where('type', $type);
    	if ($property)
    		$dbObj->where('property', $property);
    	if ($element)
    	 	$dbObj->where('element', $element);
    	if ($name)
    	 	$dbObj->like('name', $name);
    	return $dbObj->count_all_results("power_network");
    }
    function DeleteNetwork($id){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id',$id);
    	return $dbObj->delete('power_network');
    }  
    function Update_network($id, $type, $property, $element, $name, $meaning, $requirements, $reference, $remarks, $config){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id',$id);
    	$dbObj->set('type',$type);
    	$dbObj->set('property',$property);
    	$dbObj->set('element',$element);
    	$dbObj->set('name',$name);
    	$dbObj->set('meaning',$meaning);
    	$dbObj->set('requirements',$requirements);
    	$dbObj->set('reference',$reference);
    	$dbObj->set('remarks',$remarks);
    	$dbObj->set('config',$config);
    	return $dbObj->update('power_network');
    }
    function Save_network($type, $property, $element, $name, $meaning, $requirements, $reference, $remarks, $config){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->set('type',$type);
    	$dbObj->set('property',$property);
    	$dbObj->set('element',$element);
    	$dbObj->set('name',$name);
    	$dbObj->set('meaning',$meaning);
    	$dbObj->set('requirements',$requirements);
    	$dbObj->set('reference',$reference);
    	$dbObj->set('remarks',$remarks);
    	$dbObj->set('config',$config);
    	return $dbObj->insert('power_network');
    }
    function Get_network_protocol ($substation_id){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id', $substation_id);
    	return $dbObj->get('power_network')->row();
    }
    function Get_Network_By_Id($id){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id', $id);
    	$dbObj->select('config');
    	return  $dbObj->get('power_network')->row();
    }
    function Get_substation_network($id, $substation_id){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('network_id', $id);
    	$dbObj->where('substation_id', $substation_id);
    	$dbObj->select('*');
    	return  $dbObj->get('substation_network')->row();
    }
    
    function Network_Id($substation_id){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('substation_id', $substation_id);
    	$dbObj->select('*');
    	return  $dbObj->get('substation_network')->result();
    }
    
    function Perfor_Id($substation_id){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('substation_id', $substation_id);
    	$dbObj->select('*');
    	return  $dbObj->get('substation_perfor')->result();
    }
    
    function Save_Substation_NetWork ($id, $substation_id, $settings, $pi_setting, $substation_network_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if($substation_id == 0){
    		return false;
    	}
    	if($substation_network_id){
    		$dbObj->where('substation_id', $substation_id);
    		$dbObj->where('network_id', $id);
    		$dbObj->set('pi_setting', $settings);
    	    return $dbObj->update('substation_network');
    	}else{
    		$dbObj->set('substation_id', $substation_id);
    		$dbObj->set('network_id', $id);
    		$dbObj->set('pi_setting', $settings);
    		return $dbObj->insert('substation_network');
    	}
    } 
    function Save_Substation_PerFor ($id, $substation_id, $settings, $pi_setting, $substation_perfor_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if($substation_id == 0){
    		return false;
    	}
    	if($substation_perfor_id){
    		$dbObj->where('substation_id', $substation_id);
    		$dbObj->where('perfor_id', $id);
    		$dbObj->set('pi_setting', $settings);
    		return $dbObj->update('substation_perfor');
    	}else{
    		$dbObj->set('substation_id', $substation_id);
    		$dbObj->set('perfor_id', $id);
    		$dbObj->set('pi_setting', $settings);
    		return $dbObj->insert('substation_perfor');
    	}
    }
    function Get_Performance ($device_type = false,$quota = false,$output_device = false,$acquisition_methods = false, $offset = false,$size = false)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if ($device_type)
    		$dbObj->like('device_type', $device_type);
    	if ($quota)
    		$dbObj->like('quota', $quota);
    	if ($output_device)
    		$dbObj->like('output_device', $output_device);
    	if ($acquisition_methods)
    		$dbObj->like('acquisition_methods', $acquisition_methods);  
    	if ($size == 0)
    		return $dbObj->get('performance_manage')->result();
    	else
    		return $dbObj->get('performance_manage',$size,$offset)->result();
    	
    }
    function Get_PerformanceCount($device_type = false,$quota = false,$output_device = false,$acquisition_methods = false)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if ($device_type)
    		$dbObj->like('device_type', $device_type);
    	if ($quota)
    		$dbObj->like('quota', $quota);
    	if ($output_device)
    		$dbObj->like('output_device', $output_device);
    	if ($acquisition_methods)
    		$dbObj->like('acquisition_methods', $acquisition_methods);  	
    	return $dbObj->count_all_results("performance_manage"); 	
    }
    
    function Get_perfor_protocol ($id){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id', $id);
    	return $dbObj->get('performance_manage')->row();
    }
    function Update_perfor($id, $major, $device_type, $quota, $cycle, $night, $day, $output_device, $acquisition_methods, $type, $responsible, $set_basis, $output_mode, $remarks, $config){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id',$id);
    	$dbObj->set('major',$major);
    	$dbObj->set('device_type',$device_type);
    	$dbObj->set('quota',$quota);
    	$dbObj->set('cycle',$cycle);
    	$dbObj->set('night',$night);
    	$dbObj->set('day',$day);
    	$dbObj->set('output_device',$output_device);
    	$dbObj->set('acquisition_methods',$acquisition_methods);
    	$dbObj->set('type',$type);
    	$dbObj->set('responsible',$responsible);
    	$dbObj->set('set_basis',$set_basis);
    	$dbObj->set('output_mode',$output_mode);
    	$dbObj->set('remarks',$remarks);
    	$dbObj->set('config',$config);
    	return $dbObj->update('performance_manage');
    }
    function Save_perfor($major, $device_type, $quota, $cycle, $night, $day, $output_device, $acquisition_methods, $type, $responsible, $set_basis, $output_mode, $remarks, $config){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->set('major',$major);
    	$dbObj->set('device_type',$device_type);
    	$dbObj->set('quota',$quota);
    	$dbObj->set('cycle',$cycle);
    	$dbObj->set('night',$night);
    	$dbObj->set('day',$day);
    	$dbObj->set('output_device',$output_device);
    	$dbObj->set('acquisition_methods',$acquisition_methods);
    	$dbObj->set('type',$type);
    	$dbObj->set('responsible',$responsible);
    	$dbObj->set('set_basis',$set_basis);
    	$dbObj->set('output_mode',$output_mode);
    	$dbObj->set('remarks',$remarks);
    	$dbObj->set('config',$config);
    	return $dbObj->insert('performance_manage');
    }
    function DeletePerfor($id){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id',$id);
    	return $dbObj->delete('performance_manage');
    }
    function Get_Perfor_By_Id($id){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id', $id);
    	$dbObj->select('config');
    	return  $dbObj->get('performance_manage')->row();
    }
    function Save_PerforPi ($id, $settings)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('id', $id);
    	$dbObj->set('settings', $settings);
    	return $dbObj->update('performance_manage');
    }
    function Get_NetworkList ($id = false)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if($id)
    		$dbObj->where('id', $id);
    	return $dbObj->get('power_network')->row();
    }
    function Get_PerforList ($id = false)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if($id)
    		$dbObj->where('id', $id);
    	return $dbObj->get('performance_manage')->row();
    }
    function Save_NetWorkValue ($id, $substation_id, $value, $state)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('network_id', $id);
    	$dbObj->where('substation_id', $substation_id);
    	$dbObj->set('value', $value);
    	$dbObj->set('state', $state);
    	return $dbObj->update('substation_network');
    }
    function Save_PerForValue ($id, $substation_id, $value)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('perfor_id', $id);
    	$dbObj->where('substation_id', $substation_id);
    	$dbObj->set('value', $value);
    	return $dbObj->update('substation_perfor');
    }
    function Get_NetWork_Value ($substation_id, $network_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	
    	$ret = array();
    	foreach($network_id as $key=>$val){
    		$dbObj->where('substation_id', $substation_id);
    		$dbObj->where('network_id', $val);
    		$dbObj->select('value');
    		$value = $dbObj->get('substation_network')->result();
    		array_push($ret,$value);
    	}
    	return $ret;
    }
    function Get_PerFor_Value ($substation_id, $perfor_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	 
    	$ret = array();
    	foreach($perfor_id as $key=>$val){
    		$dbObj->where('substation_id', $substation_id);
    		$dbObj->where('perfor_id', $val);
    		$dbObj->select('value');
    		$value = $dbObj->get('substation_perfor')->result();
    		array_push($ret,$value);
    	}
    	return $ret;
    }
    function Get_substation_perfor($id, $substation_id){
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('perfor_id', $id);
    	$dbObj->where('substation_id', $substation_id);
    	$dbObj->select('*');
    	return  $dbObj->get('substation_perfor')->row();
    }
    
    function Set_Door_User_Times($data_id, $user_id, $times)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('data_id', $data_id);
        $dbObj->where('user_id', $user_id);
        $dbObj->set('delete_check_count', $times);
        $dbObj->update('door_user');
    }
    function Get_SignalName()
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->select('signal_name');
    	$dbObj->distinct('signal_name');
    	return $dbObj->get('alert')->result();
    }
    function Get_NetworKSubstationSetting($substation_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('substation_network', 'power_network.id=substation_network.network_id','left');
    	$dbObj->where('substation_id', $substation_id);
    	$dbObj->select('substation_network.id, power_network.name, substation_network.value, power_network.requirements, power_network.property');
    	return  $dbObj->get('power_network')->result();
    }
    
    function Get_PerforSubstationSetting($substation_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->join('substation_perfor', 'performance_manage.id=substation_perfor.perfor_id','left');
    	$dbObj->where('substation_id', $substation_id);
    	$dbObj->select('substation_perfor.id, performance_manage.device_type, substation_perfor.value, performance_manage.quota,performance_manage.day,performance_manage.night');
    	return  $dbObj->get('performance_manage')->result();
    }
    
    function Save_NetworKSubstationConfig ($substation_id, $nk_script, $nk_value, $is_subid)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if ($nk_script)
    		$dbObj->set('nk_script', $nk_script);
    	if ($nk_value)
    		$dbObj->set('nk_value', $nk_value);
    	if ($substation_id != $is_subid){
    		$dbObj->set('substation_id', $substation_id);
    		return $dbObj->insert('network_substation_config');
    	}else{
    		$dbObj->where('substation_id', $substation_id);
    		return $dbObj->update('network_substation_config');
    	}	
    }
    
    function Save_PerforSubstationConfig ($substation_id, $nk_script, $nk_value, $is_subid)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if ($nk_script)
    		$dbObj->set('nk_script', $nk_script);
    	if ($nk_value)
    		$dbObj->set('nk_value', $nk_value);
    	if ($substation_id != $is_subid){
    		$dbObj->set('substation_id', $substation_id);
    		return $dbObj->insert('perfor_substation_config');
    	}else{
    		$dbObj->where('substation_id', $substation_id);
    		return $dbObj->update('perfor_substation_config');
    	}
    }
    
    function Delete_NetworkConfig ($substation_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('substation_id', $substation_id);
    	$dbObj->delete('network_substation_config');
    }
    function Delete_PerforConfig ($substation_id)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('substation_id', $substation_id);
    	$dbObj->delete('perfor_substation_config');
    }
    function Get_Door_Report_List($cityCode=false, $countyCode=false, $substationId=false, $roomId=false, $keyWord=false, $startDatetime = false, $endDatetime = false,  $size=0, $offset=0)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->order_by('door_record.id', 'desc');
    	$dbObj->join("user", "door_record.user_id=user.id",'left');
    	$dbObj->join('device', 'door_record.data_id=device.data_id');
    	$dbObj->join('room', 'room.id=device.room_id','left');
    	$dbObj->join('substation', 'substation.id=room.substation_id','left');
    	
    	if ($cityCode)
    		$dbObj->where('substation.city_code', $cityCode);
    	if ($countyCode)
    		$dbObj->where('substation.county_code', $countyCode);
    	if ($substationId)
    		$dbObj->where('substation.id', $substationId);
    	if ($roomId)
    		$dbObj->where('room.id', $roomId);
    	if($startDatetime){
    	    $dbObj->where('door_record.added_datetime >=',$startDatetime." 00:00:00");
    	}
    	if($endDatetime){
    		$dbObj->where('door_record.added_datetime <=',$endDatetime." 23:59:59");
    	}
    	if ($keyWord){
    		foreach($gCounty as $key => $val){
    			foreach($val as $k => $v){
    				if($v == $keyWord){
    					$keyWord = $k;
    				}
    			}
    		}
    		$dbObj->group_start();
    		$dbObj->like('substation.name', $keyWord);
    		$dbObj->or_like('room.name', $keyWord);
    		$dbObj->or_like('substation.county_code', $keyWord);
    		$dbObj->or_like('Stationcode', $keyWord);
    		$dbObj->or_like('user.full_name', $keyWord);
    		$dbObj->or_like('door_record.card_no', $keyWord);
    		$dbObj->or_like('user.mobile', $keyWord);
    		$dbObj->group_end();
    	}
    	
    	$dbObj->select("device.name,room.name as room_name,substation.city_code,substation.county_code,substation.Stationcode,substation.name as substation_name,user.full_name,user.mobile,door_record.*");
    	$ret = $dbObj->get('door_record', $size, $offset)->result();
    	return $ret;	
    }
    
    function Get_Door_Report_Count($cityCode=false, $countyCode=false, $substationId=false, $roomId=false, $keyWord=false, $startDatetime = false, $endDatetime = false)
    {
        $dbObj = $this->load->database('default', TRUE);
    	$dbObj->order_by('door_record.id', 'desc');
    	$dbObj->join("user", "door_record.user_id=user.id",'left');
    	$dbObj->join('device', 'door_record.data_id=device.data_id');
    	$dbObj->join('room', 'room.id=device.room_id','left');
    	$dbObj->join('substation', 'substation.id=room.substation_id','left');
    	
    	if ($cityCode)
    		$dbObj->where('substation.city_code', $cityCode);
    	if ($countyCode)
    		$dbObj->where('substation.county_code', $countyCode);
    	if ($substationId)
    		$dbObj->where('substation.id', $substationId);
    	if ($roomId)
    		$dbObj->where('room.id', $roomId);
    	if($startDatetime){
    	    $dbObj->where('door_record.added_datetime >=',$startDatetime." 00:00:00");
    	}
    	if($endDatetime){
    		$dbObj->where('door_record.added_datetime <=',$endDatetime." 23:59:59");
    	}
    	if ($keyWord){
    		foreach($gCounty as $key => $val){
    			foreach($val as $k => $v){
    				if($v == $keyWord){
    					$keyWord = $k;
    				}
    			}
    		}
    		$dbObj->group_start();
    		$dbObj->like('substation.name', $keyWord);
    		$dbObj->or_like('room.name', $keyWord);
    		$dbObj->or_like('substation.county_code', $keyWord);
    		$dbObj->or_like('Stationcode', $keyWord);
    		$dbObj->or_like('user.full_name', $keyWord);
    		$dbObj->or_like('door_record.card_no', $keyWord);
    		$dbObj->or_like('user.mobile', $keyWord);
    		$dbObj->group_end();
    	}
    	return $dbObj->count_all_results("door_record");
    }

    function check_mobile($mobile)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	if($mobile)
    		$dbObj->where('mobile',$mobile);
    	$dbObj->select('user.mobile,user.user_role');
    	return $dbObj->get('user')->row();
    }
    function add_door_user_on_user($name, $mobile, $card_number)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('full_name',$name);
    	$row = $dbObj->get("user")->row();
    	
    	if(count($row))
    	{   
    		$dbObj->where('full_name',$name);
    		$dbObj->set('user.mobile',$mobile);
    		$dbObj->set('accessid',$card_number);
    		$dbObj->set('user_role','door_user');
    		$dbObj->update('user');
    	}else{
    		$dbObj->set('full_name',$name);
    		$dbObj->set('mobile',$mobile);
    		$dbObj->set('accessid',$card_number);
    		$dbObj->set('user_role','door_user');
    		$dbObj->insert('user');
    	}
    }
    function add_door_user($door_id = false, $start_datetime = false, $end_datetime = false, $user_id = false)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('door_user.data_id',$door_id);
    	$dbObj->where('door_user.user_id',$user_id);
    	$row = $dbObj->get("door_user")->row();
    	if(count($row))
    	{
    		$dbObj->where('data_id',$door_id);
    		$dbObj->set('user_id',$user_id);
    		if($start_datetime)
    			$dbObj->set('down_datetime',$start_datetime);
    		if($end_datetime)
    			$dbObj->set('expire_date',$end_datetime);
    		return $dbObj->update('door_user');
    	}else{
    		$dbObj->set('data_id',$door_id);
    		$dbObj->set('user_id',$user_id);
    		if($start_datetime)
    			$dbObj->set('down_datetime',$start_datetime);
    		if($end_datetime)
    			$dbObj->set('expire_date',$end_datetime);
    		return $dbObj->insert('door_user');
    	}
    }
    function get_user_id_by_name($name)
    {
    	$dbObj = $this->load->database('default', TRUE);
    	$dbObj->where('full_name',$name);
    	$dbObj->select('id');
    	return $dbObj->get('user')->row();
    }
    
    
    
}

