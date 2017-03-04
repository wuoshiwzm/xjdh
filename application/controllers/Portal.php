<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

//require_once 'phpexcel/PHPExcel.php';
//include 'PHPExcel/Writer/Excel2007.php';

const DEFAULT_PAGE_SIZE = 20;

class Portal extends CI_Controller
{

    var $userObj = null;

    //var $excelStyleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    public function __construct ()
    {
        //继承父类构造函数
        parent::__construct();    
        if (! User::IsAuthenticated()) {
            if(uri_string() == "portal/get_video_url")
                return;
            if (uri_string() == 'portal/refreshData' && $this->isOauthPass()) {
                return;
            }
            redirect('/login');
        } else {        
            $this->userObj = User::GetCurrentUser();
            User::Set_UserWebOnline($this->userObj->id);
        }        
    }
    
    
    
        function isOauthPass ()
        {
            $request = new League\OAuth2\Server\Util\Request();
            //包含"application/config/database.php"
            require "application/config/database.php";
            $conn_str = 'mysql://' . $db['default']['username'] . ":" . $db['default']['password'] . '@' . $db['default']['hostname'] . '/' .
                $db['default']['database'];
            $db = new League\OAuth2\Server\Storage\PDO\Db($conn_str);
    
            $this->server = new League\OAuth2\Server\Resource(new League\OAuth2\Server\Storage\PDO\Session($db));
            //可能抛出异常
            try {
                $this->server->isValid();
                $this->user = User::GetUserById($this->server->getOwnerId());
                return true;
            }
            //处理异常
            catch (League\OAuth2\Server\Exception\InvalidAccessTokenException $e) {
                return false;
            }
        }
    
        public function initUserPrivilege ()
        {
            $userObj = User::GetCurrentUser();
            if(!isset($_SESSION['XJTELEDH_AREA_PRIVILEGE']))
            {
                $privaligeObj = User::Get_UserPrivilege($_SESSION['XJTELEDH_USERID']);
                if ($privaligeObj != NULL) {
                    $_SESSION['XJTELEDH_AREA_PRIVILEGE'] = $privaligeObj->area_privilege;
                    $_SESSION['XJTELEDH_DEV_PRIVILEGE'] = $privaligeObj->dev_privilege;
                } else {
                    $_SESSION['XJTELEDH_AREA_PRIVILEGE'] = json_encode(array());
                    $_SESSION['XJTELEDH_DEV_PRIVILEGE'] = json_encode(array());
                }
                if ($_SESSION['XJTELEDH_USERROLE'] == 'admin' || $_SESSION['XJTELEDH_USERROLE'] == 'city_admin') {
                    $_SESSION['XJTELEDH_DEV_PRIVILEGE'] = json_encode(array_keys(Defines::$gDevModel));
                }
    
                $cityList = array();
                $countyList = array();
                //true 返回数组  false 返回对象
                $areaPrivilegeArr = json_decode($_SESSION['XJTELEDH_AREA_PRIVILEGE'], TRUE);
                if ($_SESSION['XJTELEDH_USERROLE'] == 'admin') {
                    $cityList = Defines::$gCity;
                    $countyList = Defines::$gCounty;
                } elseif ($_SESSION['XJTELEDH_USERROLE'] == 'noc' || $_SESSION['XJTELEDH_USERROLE'] == 'member' || $_SESSION['XJTELEDH_USERROLE'] == 'operator') {
                    $cities = $this->mp_xjdh->Get_CityList($areaPrivilegeArr);
                    foreach ($cities as $cityObj) {
                        $cityList[$cityObj->city_code] = $cityObj->city;
                        $counties = $this->mp_xjdh->Get_CountyList($cityObj->city_code, $areaPrivilegeArr);
                        $countyList[$cityObj->city_code] = array();
                        foreach ($counties as $countyObj) {
                            $countyList[$cityObj->city_code][$countyObj->county_code] = $countyObj->county;
                        }
                    }
                } elseif ($_SESSION['XJTELEDH_USERROLE'] == 'city_admin') {
                    foreach (Defines::$gCity as $cityKey => $cityVal){
                        if($cityKey == $privaligeObj->city_code){
                            $cityList = array($cityKey=>$cityVal);
                        }
                    }
                    $countyList = Defines::$gCounty;
                }
                $_SESSION['CITYLIST'] = json_encode($cityList);
                $_SESSION['COUNTYLIST'] = json_encode($countyList);
                $_SESSION['SUBLIST'] = json_encode($cities);
            }
        }

    function show_data($dataId)
    {
    	//获取实例
    	$ci = &get_instance();
    	//加载驱动器
    	$ci->load->driver('cache');
    	//连接
    	$memData = $this->cache->get($dataId);
    	//$data=unpack("c", $memData);
    	var_dump($memData);
    }
    
    public function fix_alert_history()
    {
    	$dbObj = $this->load->database('default', true);
        $offset = 0;
        do{
	        $dbObj->where('status','unresolved');
	        $dbObj->or_where(" ( status='solved' and restore_id<>0 ) ", NULL, FALSE);
	        $alertList = $dbObj->get('alert',1000,$offset)->result();
	        if(count($alertList) == 0)
	                break;
	        foreach($alertList as $alert)
	        {
	    		$dbObj->set('data_id', $alert->data_id);
	    		if($alert->data_id < 10000)
	    		{
	    			//smd device
	    			$smdObj = $this->mp_xjdh->Get_SMD_Device_By_no($alert->data_id);
	    			if(count($smdObj) == 0)
	    				continue;
	    			$dbObj->set('dev_name',$smdObj->name);
	    			$dbObj->set('room_id', $smdObj->room_id);
	    			$dbObj->set('dev_model', 'smd_device');
	    		}else{
	    			$devObj = $this->mp_xjdh->Get_Device($alert->data_id);
	    			if(count($devObj) == 0)
	    				continue;
	    			$dbObj->set('dev_name',$devObj->name);
	    			$dbObj->set('room_id', $devObj->room_id);
	    			$dbObj->set('dev_model', $devObj->model);
	    		}
	    		$dbObj->set('level', $alert->level);
	    		$dbObj->set('signal_id', $alert->signal_id);
	    		$dbObj->set('signal_name', $alert->signal_name);
	    		$dbObj->set('subject', $alert->subject);
	    		$dbObj->set('added_datetime', $alert->added_datetime);
	    		$dbObj->set('status', $alert->status);
	    		$dbObj->set('restore_datetime', $alert->restore_datetime);
	    		$dbObj->set('restore_id', $alert->restore_id);
	    		$dbObj->insert('alert_realtime');
	    	}
	    	$offset += 1000;
		echo "1000 done\n";
        }while(true);
    }
    
    public function tc ($dataId=0)
    {
        $smd_device_no = 708;
        $city = 999;
        $ret =  $this->mp_xjdh->Get_Max_data_id($smd_device_no);
        if(!$ret->data_id){
            $head = $city << 22;
            //var_dump("aa").die;
            $var = sprintf('%u', $head);
            $mid = $smd_device_no << 10;
            $i = 1;
            $ret = $head + $mid+$i;
        }else{
            $ret = $ret->data_id + 1;
        }
        var_dump($ret);
        die();
        
        
    	//var_dump($this->mp_xjdh->Get_SMDDevice_By_LscStation(992,9920));
    	//die;
    	//加载驱动器
        $this->load->driver('cache');
        //创建新对象
        $m810gDcObj = new stdClass();
        $m810gDcObj->data_id = $dataId;
        $memData = $this->cache->get($dataId);
        //memdata长度
        echo strlen($memData);
        //substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 11 * 4, 83) 从4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 11 * 4开始返回83个
        //以字符格式解数据
        $v = unpack('c*', substr($memData, 4 + 4 * 2 + 4 + 4 * 4 + 4 + 9 * 4 + 4 + 11 * 4, 83));
        print_r($v);
    }

 

    public function index ()
    {
        $data = array();
        $data['actTab'] = 'index';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '首页';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        if ($_SESSION['XJTELEDH_USERROLE'] == 'admin' || $_SESSION['XJTELEDH_USERROLE'] == 'noc') {
            $data['parentcode'] = 0;
        } elseif ($_SESSION['XJTELEDH_USERROLE'] == 'city_admin') {
            $cityList = json_decode($_SESSION['XJTELEDH_AREA_PRIVILEGE'], TRUE);
            $data['parentcode'] = $cityList[0];
        } else {
            $cityList = array_keys(json_decode($_SESSION['CITYLIST'], TRUE));
            $data['parentcode'] = $cityList[0];
        }
        
        $scriptExtra = '<script src="/public/highmaps/js/highcharts.js"></script>';
        $scriptExtra .= '<script src="/public/highmaps/js/modules/map.js"></script>';
        $scriptExtra .= '<script src="/public/highmaps/js/modules/data.js"></script>';
        $scriptExtra .= '<script src="/public/portal/js/index.js"></script>';
        $content = $this->load->view("portal/index", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '首页', $data);
    }
    
    function door_manage()
    {
    	if(!in_array($this->userObj->user_role, array("admin","city_admin","operator")))
    		redirect("/");
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'door';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '门禁管理';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '门禁权限管理';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data['gCounty'] = $gCounty = Defines::$gCounty;
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        $data['substationList'] = $this->mp_xjdh->Get_Substations();
        $data['roomId'] = $roomId = $this->input->get('selRoom');
        $data['roomList'] = $this->mp_xjdh->Get_Rooms();
        $data['subName'] = $subName = $this->input->get('txtName');
        $data['dataId'] = $dataId = $this->input->get('txtDataId');
        $data['keyWord'] = $keyWord = trim($this->input->get('keyWord'));
        $data['active'] = $active = $this->input->get('selActive');
        $data['offset'] = $offset = intval($this->input->get('per_page'));

        $city_code = "";
        if($this->userObj->user_role != "admin"){
        	$city_code = $this->userObj->city_code;
        }
        
        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        		
        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '门禁权限管理');
        	$xls->addRow(array("分公司","区域","局站","机房","采集单元","设备名","数据ID","是否激活"));
        	$data['devList'] = $devList = $this->mp_xjdh->Get_Device_List($cityCode, $countyCode, $substationId, $roomId, false, array("DoorXJL"/*"EMSProtocol"*/), "",$active, $subName,
                false, false,$dataId,'DoorXJL',$keyWord,$city_code); 
        	foreach($data['devList'] as $devObj)
        	{
        		if($devObj->active == '1'){$devObj->active = '已激活';}
        		if($devObj->active == '0'){$devObj->active = '未激活';}
        		$xls->addRow(array(
                        Defines::$gCity[$devObj->city_code], Defines::$gCounty[$devObj->city_code][$devObj->county_code],$devObj->suname, $devObj->room_name,$devObj->name,$devObj->roomId,$devObj->data_id,$devObj->active
        		));
        	}
        		
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="门禁权限管理.xls"');
        	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        	header('Expires:0');
        	header('Pragma:public');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('门禁权限管理');
        	return;
        }

        
        $data['count'] = $count = $this->mp_xjdh->Get_Device_Count($cityCode, $countyCode, $substationId, $roomId, false, array("DoorXJL"/*"EMSProtocol"*/),"", $active, $subName,$dataId,'DoorXJL',$keyWord,$city_code, $gCounty);
        $data['devList'] = $devList = $this->mp_xjdh->Get_Device_List($cityCode, $countyCode, $substationId, $roomId, false, array("DoorXJL"/*"EMSProtocol"*/), "",$active, $subName,
                $offset, DEFAULT_PAGE_SIZE, $dataId,'DoorXJL', $keyWord, $city_code, $gCounty); 
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/door_manage"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        $content = $this->load->view("portal/door_manage", $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/portal/js/door_manage.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '门禁权限管理', $data);
    }
    
    
    function _get_city_node($cityKey, $cityVal)
    {
        $cityNode = array();
        $cityUserNumber = 0;
        if (key_exists($cityKey, Defines::$gCounty)) {
            $cityNode['children'] = array();
    
            foreach (Defines::$gCounty[$cityKey] as $countyKey => $countyVal) {
                $countyNode = array();
                $countyUserNumber = 0;
                $substationList = $this->mp_xjdh->Get_Substations(false, $countyKey);
                if (count($substationList)) {
                    $countyNode['children'] = array();
                    foreach ($substationList as $substationObj) {
                        $substationNode = array();
                        $substationNode['children'] = array();
                        $userList = $this->mp_xjdh->get_user_by_substation_id($substationObj->id);
                        foreach($userList as $user)
                        {
                            $userNode = array();
                            $userNode["id"] = $user->id;
                            $userNode["text"] = $user->full_name."($user->username)";
                            array_push($substationNode['children'], $userNode);
                        }
                        $countyUserNumber += count($substationNode['children']);
                        $substationNode['text'] = $substationObj->name."(".count($substationNode['children']).")";
                        array_push($countyNode['children'], $substationNode);
                    }
                }
                $cityUserNumber += $countyUserNumber;
                $countyNode['text'] = $countyVal."(".$countyUserNumber.")";
                array_push($cityNode['children'], $countyNode);
            }
        }
        $cityNode['text'] = $cityVal."(".$cityUserNumber.")";
        return $cityNode;   
    }
       
    function get_user_tree()
    {
        header('Content-type: application/json');
        if(!in_array($this->userObj->user_role, array("admin","city_admin","operator")))
        {
            echo json_encode(array('text' => '无权限显示数据',  'children'=>false));
            return;
        }
    	$areaTreeData = array();
    	//只有admin可以管理全区的，city_admin和operator只能看到所在分公司的
    	if($this->userObj->user_role == "admin")
        {
            //未设置区域人员
            $cityNode = array();
            
            $cityNode['children'] = array();
            $userList = $this->mp_xjdh->get_user_by_substation_id(0);
            
            foreach($userList as $user)
            {
                $userNode = array();
                $userNode["id"] = $user->id;
                $userNode["text"] = $user->full_name."($user->username $user->mobile)";
                array_push($cityNode['children'], $userNode);
            }
            $cityNode['text'] = "未设置区域(".count($cityNode['children']).")";
            array_push($areaTreeData, $cityNode);
            foreach(Defines::$gCity as $cityKey=>$cityVal){
                array_push($areaTreeData, $this->_get_city_node($cityKey, $cityVal));
            }
        }else
        {
            array_push($areaTreeData, $this->_get_city_node($this->userObj->city_code, Defines::$gCity[$this->userObj->city_code]));
        }
        echo json_encode(array('text' => '全网','children' => $areaTreeData));
    }
    
    function revoke_user_door()
    {
        $user = User::GetCurrentUser();
        $dataIdArr = $this->input->post('dataIdArr');
        $user_id = $this->input->post('user_id');
        $this->mp_xjdh->User_Remove_DoorArr($user_id, $user->id, $dataIdArr);
        header('Content-type: application/json');
        echo json_encode(array("ret"=>0));
    }
    
    function door_set_check_time()
    {
        $data_id = $this->input->post('data_id');
        $user_id = $this->input->post('user_id');
        $times = $this->input->post('times');
        $this->mp_xjdh->Set_Door_User_Times($data_id, $user_id, $times);
        header('Content-type: application/json');
        echo json_encode(array("ret"=>0));
        
    }
    function revoke_door_user()
    {
        $user = User::GetCurrentUser();
        $data_id = $this->input->post('data_id');
        $dooruserIdArr = $this->input->post('user_id');
        $this->mp_xjdh->Door_Remove_UserArr($data_id, $user->id, $dooruserIdArr);
        header('Content-type: application/json');
        echo json_encode(array("ret"=>0));
    }
    
    function user_add_door()
    {
        $user = User::GetCurrentUser();
        $user_id = $this->input->post('user_id');
        $dataIdArr = $this->input->post('dataIdArr');
        $expireDate = $this->input->post('expire_date');
        $cardControl = $this->input->post('card_control');
        $remoteControl = $this->input->post('remote_control');
        foreach($dataIdArr as $dataId)
        {
            $data_id = intval($dataId);
            if($data_id)
                 $this->mp_xjdh->Door_Add_User($dataId, $user_id, $user->id, $expireDate, $cardControl, $remoteControl);
        }
        header('Content-type: application/json');
        echo json_encode(array("ret"=>0));
    }
    function door_add_user()
    {
        $user = User::GetCurrentUser();
        $data_id = $this->input->post('data_id');
        $userArr = $this->input->post('userArr');
        $expireDate = $this->input->post('expire_date');
        $cardControl = $this->input->post('card_control');
        $remoteControl = $this->input->post('remote_control');
        foreach($userArr as $userId)
        {
            $user_id = intval($userId);
            if($user_id)
                $this->mp_xjdh->Door_Add_User($data_id, $user_id, $user->id, $expireDate, $cardControl, $remoteControl);
        }
        header('Content-type: application/json');
        echo json_encode(array("ret"=>0));
    }
    
    function _get_dev_tree($model,$userId)
    {
    	$treeList = array();
    	$userObj = user::GetUserById($userId);
    	if($userObj->user_role == 'admin'){
    			$treeList = Defines::$gCity;
    	}else{
    	    foreach (Defines::$gCity as $cityKey => $cityVal){
    	        if($cityKey == $userObj->city_code){
    	            $treeList = array($cityKey=>$cityVal);
    	            break;
    	        }
    	    }
    	}
        $areaTreeData = array();
        foreach ($treeList as $cityKey => $cityVal) {
            $cityNode = array();
            $cityDevNumber = 0;
            if (key_exists($cityKey, Defines::$gCounty)) {
                $cityNode['children'] = array();
                foreach (Defines::$gCounty[$cityKey] as $countyKey => $countyVal) {
                    $countyNode = array();
                    $countyDevNumber = 0;
                    $substationList = $this->mp_xjdh->Get_Substations(false, $countyKey,false,false,json_decode($privaligeList->area_privilege));
                    if (count($substationList)) {
                        $countyNode['children'] = array();
                        foreach ($substationList as $substationObj) {
                            $substationNode = array();
                            $stationDevCount = 0;
                            $substationNode['children'] = array();
                            $roomList = $this->mp_xjdh->Get_Room_List(false, false, $substationObj->id);
                            foreach($roomList as $roomObj)
                            {
                                $roomNode = array();
                                $roomNode['children'] = array();
                                $DevList = $this->mp_xjdh->Get_Device_By_RoomId($roomObj->id, $model);
                                foreach($DevList as $Dev)
                                {
                                    $devNode = array();
                                    $devNode['id'] = $Dev->data_id;
                                    $devNode['text'] = $Dev->name;
                                    array_push($roomNode['children'], $devNode);
                                }
                                $stationDevCount += count($roomNode['children']);
                                $roomNode["text"] = $roomObj->name."(".count($roomNode['children']).")";
                                array_push($substationNode['children'], $roomNode);
                            }
                            $countyDevNumber += $stationDevCount;
                            $substationNode['text'] = $substationObj->name."(".$stationDevCount.")";
                            array_push($countyNode['children'], $substationNode);
                        }
                    }
                    $cityDevNumber += $countyDevNumber;
                    $countyNode['text'] = $countyVal."(".$countyDevNumber.")";
                    array_push($cityNode['children'], $countyNode);
                }
            }
            $cityNode['text'] = $cityVal."(".$cityDevNumber.")";
            array_push($areaTreeData, $cityNode);
       }
        header('Content-type: application/json');
        echo json_encode(array('text' => '全网','children' => $areaTreeData));
    }
    function get_door_tree()
    {
    	$userId = $this->input->get('userId');
        return $this->_get_dev_tree(array("DoorXJL"),$userId);
    }
    
    function get_powermeter_tree()
    {
        return $this->_get_dev_tree(array('power_302a'));
    }
    
    function powermeter_ec_compare()
    {
        //能耗对比分析查询
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'performance';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '能耗分析模型';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '能耗对比分析查询';
        $bcObj->url = '/portal/powermeter_ec_compare';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
    
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode= $this->input->get('selCounty');
        $data['substationId'] = $substationId= $this->input->get('selSubstation');
        $data['roomId'] = $roomId = $this->input->get('selRoom');
        $data['ecType'] = $ecType = $this->input->get('ecType');
        $data['ecGroup'] = $ecGroup = $this->input->get('ecGroup');
        $data['dateRange'] = $dateRange = $this->input->get('dateRange');
    
    
        $dateRangeArr = explode('至', $dateRange);
    
        if(count($dateRangeArr) == 2 && count($ecType))
        {
            $labelArray = array();
            $dataArray = array();
            $this->load->library("mongo_db");
            foreach($cityCode as $i=>$city)
            {
                $labelValue = "";
                if(!empty($city))
                {
                    $labelValue = Defines::$gCity[$city];
                }
                if(!empty($countyCode[$i]))
                {
                    $labelValue .= "-".Defines::$gCounty[$city][$countyCode[$i]];
                }
                if(!empty($substationId[$i]))
                {
                    $substationObj = $this->mp_xjdh->Get_Substation($substationId[$i]);
                    $labelValue .= "-".$substationObj->name;
                }
                if(!empty($roomId[$i]))
                {
                    $roomObj = $this->mp_xjdh->Get_Room_ById($roomId[$i]);
                    $labelValue .= "-".$roomObj->name;
                }
                $labelArray[] = $labelValue;
                $dataIdArr = $this->mp_xjdh->Get_Power302aEC_DataId($city, $countyCode[$i], $substationId[$i], $roomId[$i], $ecType);
                if(count($dataIdArr))
                {
                    $powerDataList = $this->mp_xjdh->Get_Power302aEC_List($dataIdArr, $ecGroup ,$dateRangeArr[0],$dateRangeArr[1]);
    
                    foreach($powerDataList as $powerDataObj){
                        $key = "";
                        if(isset($powerDataObj->_id["Date"])){
                            $key = $powerDataObj->_id["Date"];
                        }else if(isset($powerDataObj->_id["year"])){
                            $key = $powerDataObj->_id["year"];
                            if(isset($powerDataObj->_id["month"])){
                                $key .= "-".$powerDataObj->_id["month"];
                            }
                        }
                        if(!isset($dataArray[$key]))
                        {
                            $dataArray[$key] = array();
                        }
                        $dataArray[$key][$labelValue] = $powerDataObj->ept_sum;
                    }
                }            
            }
            $data['labelArray'] = $labelArray;
            $data['dataArray'] = $dataArray;
        }
    
    
        $substationList = $this->mp_xjdh->Get_Substations(false, false);
        $deviceLists = $this->mp_xjdh->Get_deviceDataId();
        $roomList = $this->mp_xjdh->get_roompr();
        $data['substationList'] = $substationList;
        $data['deviceList'] = $deviceLists;
        $data['roomList'] = $roomList;
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.selection.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/excanvas.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.pie.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.categories.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.stack.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.tooltip.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.resize.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/powermeter_ec_compare.js"></script>';
    
        $content = $this->load->view("portal/powermeter_ec_compare", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '能耗对比分析查询', $data);
    }
    
    function powermeter_ec_link_relative_ratio()
    {
        //能耗同、环比查询
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'performance';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '能耗分析模型';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '能耗同、环比查询';
        $bcObj->url = '/portal/powermeter_ec_link_relative_ratio';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
    
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        $data['roomId'] = $roomId = $this->input->get('selRoom');
        $data['ecType'] = $ecType = $this->input->get('ecType[]');
        $data['ecGroup'] = $ecGroup = $this->input->get('ecGroup');
        $data['dateRange'] = $dateRange = $this->input->get('dateRange');
        
        
        $dateRangeArr = explode('至', $dateRange);
        
        if(count($dateRangeArr) == 2 && count($ecType))
        {
            $labelArray = array();
            
            $dataArray = array();
            
            $this->load->library("mongo_db");
            foreach($ecType as $type)
            {
                $labelArray[] = Defines::$gECType[$type];
                $dataIdArr = $this->mp_xjdh->Get_Power302aEC_DataId($cityCode, $countyCode, $substationId, $roomId, $type);
                if(count($dataIdArr))
                {
                    $powerDataList = $this->mp_xjdh->Get_Power302aEC_List($dataIdArr, $ecGroup ,$dateRangeArr[0],$dateRangeArr[1]);
                    
                    foreach($powerDataList as $powerDataObj){
                        $key = "";
                        if(isset($powerDataObj->_id["Date"])){
                            $key = $powerDataObj->_id["Date"];
                        }else if(isset($powerDataObj->_id["year"])){
                            $key = $powerDataObj->_id["year"];
                            if(isset($powerDataObj->_id["month"])){
                                $key .= "-".$powerDataObj->_id["month"];
                            }
                        }
                        if(!isset($dataArray[$key]))
                        {
                            $dataArray[$key] = array();
                        }
                        $dataArray[$key][$type] = $powerDataObj->ept_sum;
                    }
                }
            }
            $data['labelArray'] = $labelArray;
            $data['dataArray'] = $dataArray;
        }
    
    
        $substationList = $this->mp_xjdh->Get_Substations(false, false);
        $deviceLists = $this->mp_xjdh->Get_deviceDataId();
        $roomList = $this->mp_xjdh->get_roompr();
        $data['substationList'] = $substationList;
        $data['deviceList'] = $deviceLists;
        $data['roomList'] = $roomList;
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.selection.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/excanvas.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.pie.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.categories.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.stack.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.tooltip.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.resize.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/powermeter_ec_link_relative_ratio.js"></script>';
    
        $content = $this->load->view("portal/powermeter_ec_link_relative_ratio", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '能耗同、环比查询', $data);
    }
    
    //同比，year basis 按年度比较
    function powermeter_ec_year_basis()
    {
        //能耗历史数据
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'performance';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '能耗分析模型';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '能耗同比（趋势）查询';
        $bcObj->url = '/portal/powermeter_ec_year_basis';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        $data['roomId'] = $roomId = $this->input->get('selRoom');
        $data['ecType'] = $ecType = $this->input->get('ecType');
        $data['startYear'] = $startYear = $this->input->get('startYear');
        $data['endYear'] = $endYear = $this->input->get('endYear');
        
        if($startYear && $endYear)
        {
            $this->load->library("mongo_db");
            $dataIdArr = $this->mp_xjdh->Get_Power302aEC_DataId($cityCode, $countyCode, $substationId, $roomId, $ecType);
            if(count($dataIdArr))
            {
                $powerDataList = $this->mp_xjdh->Get_Power302aEC_List($dataIdArr, 3/*year*/,$startYear."-01-01",$endYear."-12-31");
                $yearArray = array();
                for($i=intval($startYear);$i<=intval($endYear);$i++)
                {
                    $yearArray[$i] = 0;
                }
                foreach($powerDataList as $powerDataObj){
                    $yearArray[intval($powerDataObj->_id["year"])] = $powerDataObj->ept_sum;
                }
                $data['yearArray'] = $yearArray;
            }
            $export = $this->input->get('export');
            if($export == "exporttoexcel")
            {
                require 'resources/php-excel.class.php';
                $record_offset = 0;
                $PAGE_SIZE=2000;
                $xls = new Excel_XML('UTF-8', false, '能耗分析模型');
                $xls->addRow(array("日期","合相功率","合相电流","合相电能"));
                foreach($data['powerDataList'] as $powerDataObj)
                {
                    $xls->addRow(array(
                            $powerDataObj->update_datetime, $powerDataObj->pa.'/'.$powerDataObj->pb.'/'.$powerDataObj->pc.'/'.$powerDataObj->pt,
                            $powerDataObj->iaRms.'/'.$powerDataObj->ibRms.'/'.$powerDataObj->icRms.'/'.$powerDataObj->itRms,
                            $powerDataObj->epa.'/'.$powerDataObj->epb.'/'.$powerDataObj->epc.'/'.$powerDataObj->ept,
                    ));
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="能耗分析模型.xls"');
                header('Cache-Control: max-age=1');
                $xls->generateXML('能耗分析模型');
                return;
            }
        }
        
        
        $substationList = $this->mp_xjdh->Get_Substations(false, false);
        $deviceLists = $this->mp_xjdh->Get_deviceDataId();
        $roomList = $this->mp_xjdh->get_roompr();
        $data['substationList'] = $substationList;
        $data['deviceList'] = $deviceLists;
        $data['roomList'] = $roomList;
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.selection.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/excanvas.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.pie.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.categories.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.stack.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.tooltip.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.resize.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/powermeter_ec_year_basis.js"></script>';
        
        $content = $this->load->view("portal/powermeter_ec_year_basis", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '能耗同比（趋势）查询', $data);
    }
    //EC Structure 能耗结构图查询
    //这个地方有个问题，我们只有总能耗，主设备，空调，因此要加一个其他
    function powermeter_ec_struct()
    {
        //能耗历史数据
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'performance';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '能耗分析模型';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '能耗结构图查询';
        $bcObj->url = '/portal/powermeter_ec_struct';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        $data['roomId'] = $roomId = $this->input->get('selRoom');
        $data['ecType'] = $ecType = $this->input->get('ecType');
        $data['ecGroup'] = $ecGroup = $this->input->get('ecGroup');
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        $data['dateRange'] = $dateRange = $this->input->get('dateRange');
        //explode('分割付','字符串')把字符串分割为数组
        //在至处分割数组
        $dateRangeArr = explode('至', $dateRange);
        
        if(count($dateRangeArr) == 2 )
        {
            $this->load->library("mongo_db");
            $total = 0;
            $main = 0;
            $air = 0;
            $other = 0;
            //0 总
            $dataIdArr = $this->mp_xjdh->Get_Power302aEC_DataId($cityCode, $countyCode, $substationId, $roomId, 0);
            if(count($dataIdArr))
            {
                $powerDataList = $this->mp_xjdh->Get_Power302aEC_List($dataIdArr, 4,$dateRangeArr[0],$dateRangeArr[1]);
                $total = $powerDataList[0]->ept_sum;
            }
            //1 主设备
            $dataIdArr = $this->mp_xjdh->Get_Power302aEC_DataId($cityCode, $countyCode, $substationId, $roomId, 1);
            if(count($dataIdArr))
            {
                $powerDataList = $this->mp_xjdh->Get_Power302aEC_List($dataIdArr, 4,$dateRangeArr[0],$dateRangeArr[1]);
                $main = $powerDataList[0]->ept_sum;
            }
            //2 空调
            $dataIdArr = $this->mp_xjdh->Get_Power302aEC_DataId($cityCode, $countyCode, $substationId, $roomId, 2);
            if(count($dataIdArr))
            {
                $powerDataList = $this->mp_xjdh->Get_Power302aEC_List($dataIdArr, 4,$dateRangeArr[0],$dateRangeArr[1]);
                $air = $powerDataList[0]->ept_sum;
            }
            //3 其他
            $other = $total - $main - $air;
            $data['total'] = $total;
            $data['main'] = $main;
            $data['air'] = $air;
            $data['other'] = $other;
            $export = $this->input->get('export');
            if($export == "exporttoexcel")
            {
                require 'resources/php-excel.class.php';
                $record_offset = 0;
                $PAGE_SIZE=2000;
                $xls = new Excel_XML('UTF-8', false, '能耗分析模型');
                $xls->addRow(array("日期","合相功率","合相电流","合相电能"));
                foreach($data['powerDataList'] as $powerDataObj)
                {
                    $xls->addRow(array(
                            $powerDataObj->update_datetime, $powerDataObj->pa.'/'.$powerDataObj->pb.'/'.$powerDataObj->pc.'/'.$powerDataObj->pt,
                            $powerDataObj->iaRms.'/'.$powerDataObj->ibRms.'/'.$powerDataObj->icRms.'/'.$powerDataObj->itRms,
                            $powerDataObj->epa.'/'.$powerDataObj->epb.'/'.$powerDataObj->epc.'/'.$powerDataObj->ept,
                    ));
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="能耗分析模型.xls"');
                header('Cache-Control: max-age=1');
                $xls->generateXML('能耗分析模型');
                return;
            }
        }
        
        
        $substationList = $this->mp_xjdh->Get_Substations(false, false);
        $deviceLists = $this->mp_xjdh->Get_deviceDataId();
        $roomList = $this->mp_xjdh->get_roompr();
        $data['substationList'] = $substationList;
        $data['deviceList'] = $deviceLists;
        $data['roomList'] = $roomList;
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.selection.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/excanvas.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.pie.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.categories.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.stack.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.tooltip.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.flot.resize.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/powermeter_ec_structure.js"></script>';
        
        $content = $this->load->view("portal/powermeter_ec_struct", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '能耗结构图查询', $data);
    }
    
    //EC Energy Consumption 能耗
    function powermeter_ec_history()
    {
        //能耗历史数据
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'performance';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '能耗分析模型';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '能耗历史数据查询';
        $bcObj->url = '/portal/powermeter_ec_history';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        $data['roomId'] = $roomId = $this->input->get('selRoom');
        $data['ecType'] = $ecType = $this->input->get('ecType');
        $data['ecGroup'] = $ecGroup = $this->input->get('ecGroup');
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        $data['dateRange'] = $dateRange = $this->input->get('dateRange');
        //explode('分割付','字符串')把字符串分割为数组
        //在至处分割数组
        $dateRangeArr = explode('至', $dateRange);
        
        if(count($dateRangeArr) == 2 )
        {
            $this->load->library("mongo_db");
            $dataIdArr = $this->mp_xjdh->Get_Power302aEC_DataId($cityCode, $countyCode, $substationId, $roomId, $ecType);
            if(count($dataIdArr))
            {
                $data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_Power302aEC_List($dataIdArr, $ecGroup,$dateRangeArr[0],$dateRangeArr[1]);
                $data['count'] = count($powerDataList);
            }
            $export = $this->input->get('export');
            if($export == "exporttoexcel")
            {
                require 'resources/php-excel.class.php';
                $record_offset = 0;
                $PAGE_SIZE=2000;
                $xls = new Excel_XML('UTF-8', false, '能耗分析模型');
                $xls->addRow(array("日期","合相功率","合相电流","合相电能"));
                foreach($data['powerDataList'] as $powerDataObj)
                {
                    $xls->addRow(array(
                            $powerDataObj->update_datetime, $powerDataObj->pa.'/'.$powerDataObj->pb.'/'.$powerDataObj->pc.'/'.$powerDataObj->pt,
                            $powerDataObj->iaRms.'/'.$powerDataObj->ibRms.'/'.$powerDataObj->icRms.'/'.$powerDataObj->itRms,
                            $powerDataObj->epa.'/'.$powerDataObj->epb.'/'.$powerDataObj->epc.'/'.$powerDataObj->ept,
                    ));
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="能耗分析模型.xls"');
                header('Cache-Control: max-age=1');
                $xls->generateXML('能耗分析模型');
                return;
            }
        }
        
        
        $substationList = $this->mp_xjdh->Get_Substations(false, false);
        $deviceLists = $this->mp_xjdh->Get_deviceDataId();
        $roomList = $this->mp_xjdh->get_roompr();
        $data['substationList'] = $substationList;
        $data['deviceList'] = $deviceLists;
        $data['roomList'] = $roomList;
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/powermeter_ec_history"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        $scriptExtra = '<link rel="stylesheet" href="/public/js/jstree/themes/default/style.min.css"/>';
        
        $scriptExtra .= '<script type="text/javascript" src="/public/js/tiny_mce/tinymce.min.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/highcharts.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/modules/exporting.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jstree/jstree.min.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/powermeter_history.js"></script>';
        
        $content = $this->load->view("portal/powermeter_ec_history", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '能耗历史数据查询', $data);
        
    }
    //powermeter
    function get_pm_tree()
    {
        header('Content-Type: application/json');
        $id = $this->input->get('id');
        $nodeArray = array();
        if($id == "#")
        {
        	if( $_SESSION['XJTELEDH_USERROLE'] == 'city_admin'||$_SESSION['XJTELEDH_USERROLE'] == 'noc'){
               foreach (Defines::$gCity as $cityKey => $cityVal)
               {
                  $city_code = $this->userObj->city_code;
        		  if ($city_code == $cityKey ){
                  $node = array();
                  $node["id"] = "#".$cityKey;
                  $node["text"] = $cityVal;
                  $node["children"] = $this->mp_xjdh->Get_SubstationCount($cityKey) > 0;
                  $nodeArray[] = $node;
        		  }
               }
        	}else{
               foreach (Defines::$gCity as $cityKey => $cityVal)
               {
            	  $node = array();
            	  $node["id"] = "#".$cityKey;
            	  $node["text"] = $cityVal;
            	  $node["children"] = $this->mp_xjdh->Get_SubstationCount($cityKey) > 0;
            	  $nodeArray[] = $node;
               }
        	}       
        }else if(strlen($id) == 4 && substr($id, 0, 1) === '#' && substr($id, 1, 1) != '#')
        {
            $substationList = $this->mp_xjdh->Get_Substations(substr($id,1));
            foreach ($substationList as $substationObj){
                $node = array();
                $node["id"] = '##'.$substationObj->id;
                $node["text"] = $substationObj->name;
                $node["children"] = $this->mp_xjdh->Get_RoomCount(false, false, $substationObj->id) > 0;
                $nodeArray[] = $node;
            }
        }else if(strlen($id) > 2 && substr($id, 0, 1) === '#' && substr($id, 1,1) === '#')
        {
            $roomList = $this->mp_xjdh->Get_Room_List(false, false, substr($id, 2));
            foreach ($roomList as $roomObj)
            {
                $node = array();
                $node["id"] = $roomObj->id;
                $node["text"] = $roomObj->name;
                $node["children"] = $this->mp_xjdh->Get_Room_Device_Count($roomObj->id, "power_302a") > 0;
                $nodeArray[] = $node;
            }   
        }else{
            //返回room里的电表
            $dataList = $this->mp_xjdh->Get_Room_Devices($id, "power_302a");
            foreach ($dataList as $dataObj)
            {
                $node = array();
                $node["id"] = $dataObj->data_id;
                $node["text"] = $dataObj->name;
                $node["children"] = false;
                $nodeArray[] = $node;
            }
        }
        echo json_encode($nodeArray);
    }
    
    
    function get_device_history_tree()
    {
    	header('Content-Type: application/json');
    	$id = $this->input->get('id');
    	$nodeArray = array();
    	if($id == "#")
    	{
    		if( $_SESSION['XJTELEDH_USERROLE'] == 'city_admin'||$_SESSION['XJTELEDH_USERROLE'] == 'noc'){
    			foreach (Defines::$gCity as $cityKey => $cityVal)
    			{
    				$city_code = $this->userObj->city_code;
    				if ($city_code == $cityKey ){
    					$node = array();
    					$node["id"] = "#".$cityKey;
    					$node["text"] = $cityVal;
    					$node["children"] = $this->mp_xjdh->Get_SubstationCount($cityKey) > 0;
    					$nodeArray[] = $node;
    				}
    			}
    		}else{
    			foreach (Defines::$gCity as $cityKey => $cityVal)
    			{
    				$node = array();
    				$node["id"] = "#".$cityKey;
    				$node["text"] = $cityVal;
    				$node["children"] = $this->mp_xjdh->Get_SubstationCount($cityKey) > 0;
    				$nodeArray[] = $node;
    			}
    		}
    	}else if(strlen($id) == 4 && substr($id, 0, 1) === '#' && substr($id, 1, 1) != '#')
    	{
    		$substationList = $this->mp_xjdh->Get_Substations(substr($id,1));
    		foreach ($substationList as $substationObj){
    			$node = array();
    			$node["id"] = '##'.$substationObj->id;
    			$node["text"] = $substationObj->name;
    			$node["children"] = $this->mp_xjdh->Get_RoomCount(false, false, $substationObj->id) > 0;
    			$nodeArray[] = $node;
    		}
    	}else if(strlen($id) > 2 && substr($id, 0, 1) === '#' && substr($id, 1,1) === '#')
    	{
    		$roomList = $this->mp_xjdh->Get_Room_List(false, false, substr($id, 2));
    		foreach ($roomList as $roomObj)
    		{
    			$node = array();
    			$node["id"] = $roomObj->id;
    			$node["text"] = $roomObj->name;
    			$node["children"] = $this->mp_xjdh->Get_Room_Device_Count($roomObj->id, false) > 0;
    			$nodeArray[] = $node;
    		}
    	}else{
    		//返回room里的电表
    		$dataList = $this->mp_xjdh->Get_Room_Dev($id);
    		foreach ($dataList as $dataObj)
    		{
    			$node = array();
    			$node["id"] = $dataObj->data_id;
    			$node["text"] = $dataObj->name;
    			$node["children"] = false;
    			$nodeArray[] = $node;
    		}
    	}
    	echo json_encode($nodeArray);
    }
    
    function powermeter_history()
    {    	
        $data = array();
        $data['actTab'] = 'fluctuation';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '能耗分析模型';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '电表历史数据查询';
        $bcObj->url = '/portal/powermeter_history';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        $data['data_id'] = $data_id = $this->input->get("data_id");
        $data['dataObj'] = $this->mp_xjdh->Get_Device($data_id);
        $data['dateRange'] = $dateRange = $this->input->get('dateRange');
        //explode('分割付','字符串')把字符串分割为数组
        //在至处分割数组
        $dateRangeArr = explode('至', $dateRange);
        
        if(!empty($data_id) && count($dateRangeArr) == 2 )
        {
            $this->load->library("mongo_db");
            $data['count'] = $count = $this->mp_xjdh->Get_Power302a_Count($data_id,$dateRangeArr[0],$dateRangeArr[1]);
            $data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_Power302a_List($data_id,$dateRangeArr[0],$dateRangeArr[1],$offset,DEFAULT_PAGE_SIZE);
            $export = $this->input->get('export');
            if($export == "exporttoexcel")
            {
            	require 'resources/php-excel.class.php';
            	$record_offset = 0;
            	$PAGE_SIZE=2000;
            	$xls = new Excel_XML('UTF-8', false, '能耗分析模型');
            	$xls->addRow(array("日期","A相功率","B相功率","C相功率","合相功率","A相电压","B相电压","C相电压","A相电流","B相电流","C相电流",
            			    "合相电流","A相电能","B相电能","C相电能","合相电能"));
            	foreach($data['powerDataList'] as $powerDataObj)
            	{
            		$xls->addRow(array(
            				$powerDataObj->update_datetime, $powerDataObj->pa, $powerDataObj->pb, $powerDataObj->pc, $powerDataObj->pt,
            				$powerDataObj->uaRms,$powerDataObj->ubRms,$powerDataObj->ucRms,
            				$powerDataObj->iaRms, $powerDataObj->ibRms, $powerDataObj->icRms, $powerDataObj->itRms,
            				$powerDataObj->epa, $powerDataObj->epb, $powerDataObj->epc, $powerDataObj->ept
            				));
            	}
            	header('Content-Type: application/vnd.ms-excel');
            	header('Content-Disposition: attachment;filename="能耗分析模型.xls"');
            	header('Cache-Control: max-age=1');
            	$xls->generateXML('能耗分析模型');
            	return;
            }
        }
    	$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/powermeter_history"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        $scriptExtra = '<link rel="stylesheet" href="/public/js/jstree/themes/default/style.min.css"/>';
        
        $scriptExtra .= '<script type="text/javascript" src="/public/js/tiny_mce/tinymce.min.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/edit-device.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/highcharts.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/modules/exporting.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jstree/jstree.min.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';        
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/powermeter_history.js"></script>';
        
        $content = $this->load->view("portal/powermeter_history", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '电表历史数据查询', $data);
        
        
    }    
    
    function device_history()
    {
    	$data = array();
    	$data['actTab'] = 'charts';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '统计报表';
    	$bcObj->url = '#';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '设备历史数据查询';
    	$bcObj->url = '/portal/powermeter_history';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);

    	$data['offset'] = $offset = intval($this->input->get('per_page'));
    	$data['data_id'] = $data_id = $this->input->get("data_id");
    	$data['dataObj'] = $dataObj = $this->mp_xjdh->Get_Device($data_id);
    	$data['model'] = $model = $dataObj->model;
    	$data['dateRange'] = $dateRange = $this->input->get('dateRange');
    	$dateRangeArr = explode('至', $dateRange);
    	
    	if(!empty($data_id) && count($dateRangeArr) == 2 && $model=="power_302a")
    	{
    		$this->load->library("mongo_db");
    		$data['count'] = $count = $this->mp_xjdh->Get_Power302a_Count($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    		$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_Power302a_List($data_id,$dateRangeArr[0],$dateRangeArr[1],$offset,DEFAULT_PAGE_SIZE);
    		$export = $this->input->get('export');
    		if($export == "exporttoexcel")
    		{
    			require 'resources/php-excel.class.php';
    			$record_offset = 0;
    			$PAGE_SIZE=2000;
    			$xls = new Excel_XML('UTF-8', false, 'D类板载电表历史数据查询');
    			$xls->addRow(array("日期","A相功率","B相功率","C相功率","合相功率","A相电压","B相电压","C相电压","A相电流","B相电流","C相电流",
    					"合相电流","A相电能","B相电能","C相电能","合相电能"));
    			$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_Power302a_List($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    			foreach($data['powerDataList'] as $powerDataObj)
    			{
    				$xls->addRow(array(
    						$powerDataObj->Date."".$powerDataObj->Time, $powerDataObj->pa, $powerDataObj->pb, $powerDataObj->pc, $powerDataObj->pt,
    						$powerDataObj->uaRms,$powerDataObj->ubRms,$powerDataObj->ucRms,
    						$powerDataObj->iaRms, $powerDataObj->ibRms, $powerDataObj->icRms, $powerDataObj->itRms,
    						$powerDataObj->epa, $powerDataObj->epb, $powerDataObj->epc, $powerDataObj->ept
    				));
    			}
    			header('Content-Type: application/vnd.ms-excel');
    			header('Content-Disposition: attachment;filename="D类板载电表历史数据查询.xls"');
    			header('Cache-Control: max-age=1');
    			$xls->generateXML('D类板载电表历史数据查询');
    			return;
    		}
    	}
    	
    	if(!empty($data_id) && count($dateRangeArr) == 2 && $model=="battery_24")
    	{
    		$this->load->library("mongo_db");
    		$data['count'] = $count = $this->mp_xjdh->Get_battery24_Count($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    		$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_battery24_List($data_id,$dateRangeArr[0],$dateRangeArr[1],$offset,DEFAULT_PAGE_SIZE);
    		$export = $this->input->get('export');
    		if($export == "exporttoexcel")
    		{
    			require 'resources/php-excel.class.php';
    			$record_offset = 0;
    			$PAGE_SIZE=2000;
    			$xls = new Excel_XML('UTF-8', false, '交直流屏电源蓄电池组历史数据查询');
    			$xls->addRow(array("更新日期","数据ID","蓄电池总电压","电压","电流","温度"));
    			$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_battery24_List($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    			foreach($data['powerDataList'] as $powerDataObj)
    			{
    				$xls->addRow(array(
    						$powerDataObj->Date."".$powerDataObj->Time, $powerDataObj->data_id, $powerDataObj->battery_voltage,
    						$powerDataObj->voltage, $powerDataObj->current,$powerDataObj->temperature
    				));
    			}
    			header('Content-Type: application/vnd.ms-excel');
    			header('Content-Disposition: attachment;filename="交直流屏电源蓄电池组历史数据查询.xls"');
    			header('Cache-Control: max-age=1');
    			$xls->generateXML('交直流屏电源蓄电池组历史数据查询');
    			return;
    		}
    	}
    	
    	if(!empty($data_id) && count($dateRangeArr) == 2 && $model=="battery_32")
    	{
    		$this->load->library("mongo_db");
    		$data['count'] = $count = $this->mp_xjdh->Get_battery32_Count($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    		$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_battery32_List($data_id,$dateRangeArr[0],$dateRangeArr[1],$offset,DEFAULT_PAGE_SIZE);
    		$export = $this->input->get('export');
    		if($export == "exporttoexcel")
    		{
    			require 'resources/php-excel.class.php';
    			$record_offset = 0;
    			$PAGE_SIZE=2000;
    			$xls = new Excel_XML('UTF-8', false, 'UPS电源蓄电池组历史数据查询');
    			$xls->addRow(array("更新日期","数据ID","蓄电池总电压","电压","电流","温度"));
    			$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_battery32_List($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    			foreach($data['powerDataList'] as $powerDataObj)
    			{
    				$xls->addRow(array(
    						$powerDataObj->Date."".$powerDataObj->Time, $powerDataObj->data_id, $powerDataObj->battery_voltage,
    						$powerDataObj->voltage, $powerDataObj->current,$powerDataObj->temperature
    				));
    			}
    			header('Content-Type: application/vnd.ms-excel');
    			header('Content-Disposition: attachment;filename="UPS电源蓄电池组历史数据查询.xls"');
    			header('Cache-Control: max-age=1');
    			$xls->generateXML('UPS电源蓄电池组历史数据查询');
    			return;
    		}
    	}
    	
    	if(!empty($data_id) && count($dateRangeArr) == 2 && $model=="humid")
    	{
    		$this->load->library("mongo_db");
    		$data['count'] = $count = $this->mp_xjdh->Get_humid_Count($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    		$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_humid_List($data_id,$dateRangeArr[0],$dateRangeArr[1],$offset,DEFAULT_PAGE_SIZE);
    		$export = $this->input->get('export');
    		if($export == "exporttoexcel")
    		{
    			require 'resources/php-excel.class.php';
    			$record_offset = 0;
    			$PAGE_SIZE=2000;
    			$xls = new Excel_XML('UTF-8', false, '湿度历史数据查询');
    			$xls->addRow(array("更新日期","数据ID","数值"));
    			$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_humid_List($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    			foreach($data['powerDataList'] as $powerDataObj)
    			{
    				$xls->addRow(array(
    						$powerDataObj->Date."".$powerDataObj->Time, $powerDataObj->data_id, $powerDataObj->value
    				));
    			}
    			header('Content-Type: application/vnd.ms-excel');
    			header('Content-Disposition: attachment;filename="湿度历史数据查询.xls"');
    			header('Cache-Control: max-age=1');
    			$xls->generateXML('湿度历史数据查询');
    			return;
    		}
    	}
    	
    	if(!empty($data_id) && count($dateRangeArr) == 2 && $model=="temperature")
    	{
    		$this->load->library("mongo_db");
    		$data['count'] = $count = $this->mp_xjdh->Get_temperature_Count($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    		$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_temperature_List($data_id,$dateRangeArr[0],$dateRangeArr[1],$offset,DEFAULT_PAGE_SIZE);
    		$export = $this->input->get('export');
    		if($export == "exporttoexcel")
    		{
    			require 'resources/php-excel.class.php';
    			$record_offset = 0;
    			$PAGE_SIZE=2000;
    			$xls = new Excel_XML('UTF-8', false, '温度历史数据查询');
    			$xls->addRow(array("更新日期","数据ID","数值"));
    			$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_temperature_List($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    			foreach($data['powerDataList'] as $powerDataObj)
    			{
    				$xls->addRow(array(
    						$powerDataObj->Date."".$powerDataObj->Time, $powerDataObj->data_id, $powerDataObj->value
    				));
    			}
    			header('Content-Type: application/vnd.ms-excel');
    			header('Content-Disposition: attachment;filename="温度历史数据查询.xls"');
    			header('Cache-Control: max-age=1');
    			$xls->generateXML('温度历史数据查询');
    			return;
    		}
    	}
    	
    	if(!empty($data_id) && count($dateRangeArr) == 2 && $model=="water")
    	{
    		$this->load->library("mongo_db");
    		$data['count'] = $count = $this->mp_xjdh->Get_water_Count($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    		$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_water_List($data_id,$dateRangeArr[0],$dateRangeArr[1],$offset,DEFAULT_PAGE_SIZE);
    		$export = $this->input->get('export');
    		if($export == "exporttoexcel")
    		{
    			require 'resources/php-excel.class.php';
    			$record_offset = 0;
    			$PAGE_SIZE=2000;
    			$xls = new Excel_XML('UTF-8', false, '水浸历史数据查询');
    			$xls->addRow(array("更新日期","数据ID","数值"));
    			$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_water_List($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    			foreach($data['powerDataList'] as $powerDataObj)
    			{
    				$xls->addRow(array(
    						$powerDataObj->Date."".$powerDataObj->Time, $powerDataObj->data_id, $powerDataObj->value
    				));
    			}
    			header('Content-Type: application/vnd.ms-excel');
    			header('Content-Disposition: attachment;filename="水浸历史数据查询.xls"');
    			header('Cache-Control: max-age=1');
    			$xls->generateXML('水浸历史数据查询');
    			return;
    		}
    	}
    	
    	if(!empty($data_id) && count($dateRangeArr) == 2 && $model=="fresh_air")
    	{
    		$this->load->library("mongo_db");
    		$data['count'] = $count = $this->mp_xjdh->Get_fresh_air_Count($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    		$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_fresh_air_List($data_id,$dateRangeArr[0],$dateRangeArr[1],$offset,DEFAULT_PAGE_SIZE);
    		$export = $this->input->get('export');
    		if($export == "exporttoexcel")
    		{
    			require 'resources/php-excel.class.php';
    			$record_offset = 0;
    			$PAGE_SIZE=2000;
    			$xls = new Excel_XML('UTF-8', false, '新风系统历史数据查询');
    			$xls->addRow(array("更新日期","数据ID"));
    			$data['powerDataList'] = $powerDataList = $this->mp_xjdh->Get_fresh_air_List($data_id,$dateRangeArr[0],$dateRangeArr[1]);
    			foreach($data['powerDataList'] as $powerDataObj)
    			{
    				$xls->addRow(array(
    						$powerDataObj->Date."".$powerDataObj->Time, $powerDataObj->data_id, $powerDataObj->value
    				));
    			}
    			header('Content-Type: application/vnd.ms-excel');
    			header('Content-Disposition: attachment;filename="新风系统历史数据查询.xls"');
    			header('Cache-Control: max-age=1');
    			$xls->generateXML('新风系统历史数据查询');
    			return;
    		}
    	}
    	
    	$dateRangeArr = explode('至', $dateRange);
    	$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/device_history"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
    	$scriptExtra = '<link rel="stylesheet" href="/public/js/jstree/themes/default/style.min.css"/>';
    
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/tiny_mce/tinymce.min.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/edit-device.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/highcharts.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/modules/exporting.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/jstree/jstree.min.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
    	$scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/device_history.js"></script>';
    
    	$content = $this->load->view("portal/device_history", $data, TRUE);
    	$this->mp_master->Show_Portal($content, $scriptExtra, '设备历史数据查询', $data);
    
    }
 
    function door_user($data_id, $offset=0)
    {
        $devObj = $this->mp_xjdh->Get_Device($data_id);
        if(!count($devObj))
        {
            redirect("/portal/door_manage");
        }
        if($devObj->model != "DoorXJL")
        {
            redirect("/portal/door_manage");
        }
        $data = array();
        $data['actTab'] = 'door';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '门禁管理';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '门禁权限管理';
        $bcObj->url = '/portal/door_manage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '用户权限管理';
        $bcObj->url = '/portal/door_user/'.$data_id;
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data['devObj'] = $devObj;
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        //Door User
        
        $city_code = "";
        if($this->userObj->user_role != "admin"){
        	$city_code = $this->userObj->city_code;
        }
        $data['username'] = $username = trim($this->input->get('username'));        
        $data['full_name'] = $full_name = trim($this->input->get('full_name'));
        $data['mobile'] = $mobile = trim($this->input->get('mobile'));
        $data['accessid'] = $accessid = trim($this->input->get('accessid'));
        $data['assigner_name'] = $assigner_name = trim($this->input->get('assigner_name'));
        
        $data['gCounty'] = $gCounty = Defines::$gCounty;
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        
        $data['count'] = $count = $this->mp_xjdh->Get_Door_User_Count($cityCode, $countyCode, $substationId,$username,$full_name,$mobile,$accessid,$assigner_name,$data_id,$city_code);
        $data['userList'] = $this->mp_xjdh->Get_Door_User_List($cityCode, $countyCode, $substationId,$username,$full_name,$mobile,$accessid,$assigner_name,$data_id, DEFAULT_PAGE_SIZE, $offset,$city_code);
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/door_user/".$data_id), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        
        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '门禁列表');
        	$xls->addRow(array("用户名","名字","手机号","门禁卡号","所属分公司","所属区域","所属局站","授权用户名","授权时间","有效期","控制权限","下发状态","门禁状态","自动删除次数"));
        	while (true){
        	$data['userList'] = $userDataList = $this->mp_xjdh->Get_Door_User_List($cityCode, $countyCode, $substationId, $username, $full_name, $mobile, $accessid, $assigner_name, $data_id, $record_offset, $PAGE_SIZE, $city_code);
        	foreach($data['userList'] as $userObj)
        	{
        		if ($userObj->card_control) {$userObj->card_control = "刷卡开门";}
        		    else {$userObj->card_control = "无刷卡开门";}
        		if ($userObj->remote_control) {$userObj->remote_control = "远程开门";}
        		    else {$userObj->remote_control = "无远程开门";}
        		    
                if($userObj->smd_device_active == "1"){
        		   $userObj->smd_device_active = "采集板已激活";
              } if($userObj->smd_device_active == "0"){
        		   $userObj->smd_device_active = "采集板未激活";
              } if($userObj->device_active == "1"){
        		   $userObj->device_active = "设备已激活";
        	  } if($userObj->device_active == "0"){
        		   $userObj->device_active = "设备未激活";
        	  }  
        	    if($userObj->delete_check_count == 0){ 
        	  	   $userObj->delete_check_count = "未使用";}				      
        	  	   else{$userObj->delete_check_count;} 
        	  	     
        		$xls->addRow(array(
        				$userObj->username, $userObj->full_name, $userObj->mobile, $userObj->accessid, Defines::$gCity[$userObj->city_code], Defines::$gCounty[$userObj->city_code][$userObj->county_code],
        				$userObj->statioin_name, $userObj->assigner_name, $userObj->added_datetime, $userObj->expire_date, $userObj->card_control." ".$userObj->remote_control, $userObj->status,$userObj->smd_device_active." ".$userObj->device_active,
        				$userObj->delete_check_count));
        	}
        	if(count($userDataList) < 2000)
        		break;
        	$record_offset += 2000;
        	}
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="门禁列表.xls"');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('门禁列表');
        	return;
        }
        
        $content = $this->load->view("portal/door_user", $data, TRUE);
        $scriptExtra = '<link rel="stylesheet" href="/public/js/jstree/themes/default/style.min.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jstree/jstree.min.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/door_user.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '门禁权限管理', $data);
        
    }
    
    function door_operate($data_id, $offset=0)
    {
        $devObj = $this->mp_xjdh->Get_Device($data_id);
        if(!count($devObj))
        {
            redirect("/portal/door_manage");
        }
        if($devObj->model != "DoorXJL")
        {
            redirect("/portal/door_manage");
        }
        $data = array();
        $data['actTab'] = 'door';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '门禁管理';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '门禁权限管理';
        $bcObj->url = '/portal/door_manage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = "授权记录";
        $bcObj->url = '/portal/door_operate/'.$data_id;
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data['operator_name'] = $operator_name = trim($this->input->get('operator_name'));
        $data['operator_mobile'] = $operator_mobile = trim($this->input->get('operator_mobile'));
        $data['mobile'] = $mobile = trim($this->input->get('mobile'));
        $data['full_name'] = $full_name= trim($this->input->get('full_name'));
        $data['time_range'] = $time_range = $this->input->get('time_range');
        $time_rangeArr = explode('至', $time_range);
        
        $data['devObj'] = $devObj;
        $city_code = "";
        if($this->userObj->user_role != "admin"){
        	$city_code = $this->userObj->city_code;
        }
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        //Door User
        $data['count'] = $count = $this->mp_xjdh->Get_Door_Operate_Count($data_id, $user_id,$operator_name,$operator_mobile,$full_name,$mobile, $card, $time_rangeArr, $city_code);        
        $data['userList'] = $this->mp_xjdh->Get_Door_Operate_List($data_id,$user_id, $operator_name,$operator_mobile,$full_name,$mobile, $card, $time_rangeArr, DEFAULT_PAGE_SIZE, $offset, $city_code);

        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '授权记录');
        	$xls->addRow(array("操作人员","手机号","用户","用户手机号","操作","操作时间"));
        	while (true){
        		$data['doorList'] = $doorDataList = $this->mp_xjdh->Get_Door_Operate_List($data_id,$user_id, $operator_name,$operator_mobile,$full_name,$mobile, $card, $time_rangeArr, $record_offset, $PAGE_SIZE, $city_code);
            foreach($data['doorList'] as $doorObj)
        		{	
        				$xls->addRow(array(
        						$doorObj->operator_name, $doorObj->operator_mobile, $doorObj->full_name, $doorObj->mobile, $doorObj->desc, $doorObj->added_datetime));
        		}
        		if(count($doorDataList) < 2000)
        			break;
        		$record_offset += 2000;
        	}
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="授权记录.xls"');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('授权记录');
        	return;
        }
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/door_operate/".$data_id), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/door_record.js"></script>';
        
        $content = $this->load->view("portal/door_operate", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '门禁权限管理', $data);
    
    }
    function door_record($data_id, $offset = 0)
    {
        $devObj = $this->mp_xjdh->Get_Device($data_id);
        if(!count($devObj))
        {
            redirect("/portal/door_manage");
        }
        if($devObj->model != "DoorXJL")
        {
            redirect("/portal/door_manage");
        }
        $data = array();
        $data['actTab'] = 'door';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '门禁管理';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '门禁权限管理';
        $bcObj->url = '/portal/door_manage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = "开门记录";
        $bcObj->url = '/portal/door_record/'.$data_id;
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data['devObj'] = $devObj;
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        
        $username = $data['fullName'] = $this->input->get('fullName');
        $mobile = $data['mobile'] = $this->input->get('mobile');
        $card = $data['card'] = $this->input->get('card');
        $data['time_range'] = $time_range = $this->input->get('time_range');
        //explode('分割付','字符串')把字符串分割为数组
        //在至处分割数组
        $time_rangeArr = explode('至', $time_range);
        //Door User
        $data['count'] = $count = $this->mp_xjdh->Get_Door_Record_Count($data_id, false, false,false,false,false,$username, $mobile, $card, $time_rangeArr);
        $data['recordList'] = $this->mp_xjdh->Get_Door_Record_List($data_id, false, false,false,false,false, $username, $mobile, $card, $time_rangeArr, DEFAULT_PAGE_SIZE, $offset);
        
        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        
        	$record_offset = 0;
        	$PAGE_SIZE = 2000;
        	$xls = new Excel_XML('UTF-8', false, '开门记录');
        	$xls->addRow(array("用户","手机号","卡号","操作","描述","操作时间"));
        	while(true)
        	{
        		$data['recordList'] = $recordList = $this->mp_xjdh->Get_Door_Record_List($data_id, false, false,false,false,false, $username, $mobile, $card, $time_rangeArr, $record_offset, $PAGE_SIZE);
        		foreach($recordList as $recordObj)
        		{
        			$xls->addRow(array(
        					$recordObj->full_name, $recordObj->mobile, $recordObj->card_no, $recordObj->action, $recordObj->desc, $recordObj->added_datetime));
        		}
        		if(count($recordList) < 2000)
        			break;
        		$record_offset += 2000;
        	}
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="开门记录.xls"');
        	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        	header('Expires:0');
        	header('Pragma:public');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('开门记录');
        	return;
        }
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/door_record/".$data_id), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/door_record.js"></script>';
        
        $content = $this->load->view("portal/door_record", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '开门记录', $data);
    }
    
    function door_user_operate($user_id, $offset=0)
    {
        $data = array();
        $data["userObj"] = User::GetUserById($user_id);
        $data['actTab'] = 'door';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '门禁管理';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '用户门禁管理';
        $bcObj->url = '/portal/door_user_manage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = "授权记录";
        $bcObj->url = '/portal/door_user_operate/'.$user_id;
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data['gCounty'] = $gCounty = Defines::$gCounty;
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        $data['roomId'] = $roomId = $this->input->get('selRoom');
        $data['subName'] = $subName = $this->input->get('txtName');
        
       
        $data['time_range'] = $time_range = $this->input->get('time_range');
        //explode('分割付','字符串')把字符串分割为数组
        //在至处分割数组
        $time_rangeArr = explode('至', $time_range);
        $data['devObj'] = $devObj;
        $city_code = "";
        if($this->userObj->user_role != "admin"){
        	$city_code = $this->userObj->city_code;
        }
        
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        //Door User
        $data['count'] = $count = $this->mp_xjdh->Get_Operate_Door_Count($user_id, $substationId, $roomId, $subName ,$cityCode, $countyCode , $time_rangeArr,$city_code);
        $data['userList'] = $this->mp_xjdh->Get_Operate_Door_List($user_id, $substationId, $roomId, $subName ,$cityCode, $countyCode , $time_rangeArr,DEFAULT_PAGE_SIZE, $offset,$city_code);

        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        
        	$record_offset = 0;
        	$PAGE_SIZE = 2000;
        	$xls = new Excel_XML('UTF-8', false, '授权记录');
        	$xls->addRow(array("分公司","区域","局站","机房","门禁设备","操作人员","用户","操作","操作时间"));
        	while(true)
        	{
        		$data['operateList'] = $operateList = $this->mp_xjdh->Get_Operate_Door_List($user_id, $substationId, $roomId, $subName , $cityCode, $countyCode , $time_rangeArr, $record_offset, $PAGE_SIZE,$city_code);
        		foreach($operateList as $operateObj)
        		{       
        			$xls->addRow(array(
        					Defines::$gCity[$operateObj->city_code], Defines::$gCounty[$operateObj->city_code][$operateObj->county_code] ,$operateObj->substation_name, $operateObj->room_name,
        					$operateObj->name, $operateObj->operator_name, $operateObj->full_name, $operateObj->desc, $operateObj->added_datetime));
        		}
        		if(count($operateList) < 2000)
        			break;
        		$record_offset += 2000;
        	}
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="授权记录.xls"');
        	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        	header('Expires:0');
        	header('Pragma:public');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('授权记录');
        	return;
        }
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/door_user_operate/".$user_id), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
         $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/door_record.js"></script>';
        $content = $this->load->view("portal/door_user_operate", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '门禁权限管理', $data);
    
    }
    function door_user_record($user_id, $offset = 0)
    {
        $data = array();
        $data["userObj"] = User::GetUserById($user_id);
        $data['actTab'] = 'door';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '门禁管理';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '用户门禁管理';
        $bcObj->url = '/portal/door_user_manage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = "开门记录";
        $bcObj->url = '/portal/door_user_record/'.$user_id;
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data['devObj'] = $devObj;
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        //Door User
        $data['gCounty'] = $gCounty = Defines::$gCounty;
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        $data['roomId'] = $roomId = $this->input->get('selRoom');    

        $city_code = "";
        if($this->userObj->user_role != "admin"){
        	$city_code = $this->userObj->city_code;
        }
        
        $username = $data['fullName'] = $this->input->get('fullName');
        $mobile = $data['mobile'] = $this->input->get('mobile');
        $card = $data['card'] = $this->input->get('card');
        $data['time_range'] = $time_range = $this->input->get('time_range');
        //explode('分割付','字符串')把字符串分割为数组
        //在至处分割数组
        $time_rangeArr = explode('至', $time_range);
        $data['count'] = $count = $this->mp_xjdh->Get_Door_Record_Count(false,$user_id, $cityCode, $countyCode, $substationId, $roomId, $username, $mobile, $card, $time_rangeArr,$city_code);            
        $data['recordList'] = $this->mp_xjdh->Get_Door_Record_List(false,$user_id, $cityCode, $countyCode, $substationId, $roomId, $username, $mobile, $card, $time_rangeArr,DEFAULT_PAGE_SIZE, $offset,$city_code);

        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        	$record_offset = 0;
        	$PAGE_SIZE = 2000;
        	$xls = new Excel_XML('UTF-8',FALSE,'开门记录');
        	$xls->addRow(array("分公司","区域","局站","机房","门禁设备","姓名","手机号","卡号","操作","操作时间"));
        	while(true){
        		$data['recordList'] = $recordList = $this->mp_xjdh->Get_Door_Record_List(false,$user_id,$cityCde,$countyCode,$substationId,$roomId,$username,$mobile,$card,$time_rangeArr,$PAGE_SIZE,$record_offset,$city_code);
        	    foreach ($recordList as $recordObj){
        	 $xls->addRow(array(   	
        	 		Defines::$gCity[$recordObj->city_code],Defines::$gCounty[$recordObj->city_code][$recordObj->county_code],$recordObj->substation_name,$recordObj->room_name,$recordObj->name,$recordObj->full_name,$recordObj->mobile,
        	    	$recordObj->card_no,$recordObj->desc,$recordObj->added_datetime));
        	    }
        	    if(count($recordList)<2000)
        	    	break;
        	    $record_offset += 2000;
        	}
        	header('Content-Type:application/vnd.ms-excel');
        	header('Content-Disposition:attachment;filename="开门记录.xls"');
        	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        	header('Expirse:0');
        	header('Pragma:public');
        	header('Cache-Control:max-age=1');
        	$xls->generateXML('开门记录');
        	return;
        }
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/door_user_record/".$user_id), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/door_record.js"></script>';
        $content = $this->load->view("portal/door_user_record", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '开门记录', $data);
        
    }
    
    function door_user_manage()
    {
        $data = array();
        $data['actTab'] = 'door';
        $data['bcList'] = array();
         $bcObj = new Breadcrumb();
        $bcObj->title = '门禁管理';
        $bcObj->url = '/portal/door_manage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '用户门禁管理';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['username'] = $username= trim($this->input->get('username'));       
        $data['fullName'] = $fullName= trim($this->input->get('fullName'));
        $data['mobile'] = $mobile= trim($this->input->get('mobile'));
        $data['accessId'] = $accessId = trim($this->input->get('accessId'));
    
        $substationId = false;
        if($_SESSION['XJTELEDH_USERROLE'] == 'city_admin')
        {
            $substationId = $this->userObj->substation_id;
        }
        $city_code = "";
        if($this->userObj->user_role != "admin"){
        	$city_code = $this->userObj->city_code;
        }
        
        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        
        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '用户门禁管理用户列表');
        	$xls->addRow(array("用户名","姓名","手机号","门禁卡号","所属分公司","所属区域"));
        	$data['userList'] = User::Get_UserList($cityCode, $countyCode, $fullName, $gender, $email, $userRole, $mobile, false, false, $substationId,$selCity,$selCounty);
        	foreach ($data['userList'] as $userObj) {
        		if($userObj->substation_id)
        		{
        			$substationObj = $this->mp_xjdh->Get_Substation($userObj->substation_id);
        			if ($substationObj != null) {
        				$userObj->city = $substationObj->city;
        				$userObj->city_code = $substationObj->city_code;
        				$userObj->county = $substationObj->county;
        				$userObj->county_code = $substationObj->county_code;
        				$userObj->substation_name = $substationObj->name;
        			}
        		}
        	}
        	 
        	foreach($data['userList'] as $userObj)
        	{
        		$xls->addRow(array(
        				$userObj->username,$userObj->full_name,$userObj->mobile, $userObj->accessid,$userObj->city, $userObj->county
        		));
        	}
        
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="用户门禁管理用户列表.xls"');
        	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        	header('Expires:0');
        	header('Pragma:public');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('用户门禁管理用户列表');
        	return;
        }
        
        $data['count'] = $count = User::Get_UserCount($cityCode,$countyCode,$username,$fullName, false, false, false, $mobile,$accessId, $substationId,$city_code);       
        $data['userList'] = User::Get_UserList($cityCode,$countyCode, $username,$fullName, false, false, false, $mobile, $accessId, $offset, DEFAULT_PAGE_SIZE, $substationId,$city_code);
        foreach ($data['userList'] as $userObj) {
            if($userObj->substation_id)
            {
                $substationObj = $this->mp_xjdh->Get_Substation($userObj->substation_id);
                if ($substationObj != null) {
                    //$userObj->city = $substationObj->city;
                    $userObj->city_code = $substationObj->city_code;
                    //$userObj->county = $substationObj->county;
                    $userObj->county_code = $substationObj->county_code;
                    $userObj->substation_name = $substationObj->name;
                }
            }
        }
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/door_user_manage"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        $content = $this->load->view('portal/door_user_manage', $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/door-user-manage.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '用户门禁管理', $data);
    }
    
    public function door_user_list($user_id = 0)
    {
        $data = array();
        $data['userObj'] = $this->userObj;
        $data["userObj"] = User::GetUserById($user_id);
        $data['actTab'] = 'door';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '门禁管理';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '用户门禁管理';
        $bcObj->url = '/portal/door_user_manage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = "门禁管理";
        $bcObj->url = '/portal/door_user_record/'.$user_id;
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data['gCounty'] = $gCounty = Defines::$gCounty;
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        $data['substationList'] = $this->mp_xjdh->Get_Substations();
        $data['roomId'] = $roomId = $this->input->get('selRoom');
        $data['roomList'] = $this->mp_xjdh->Get_Rooms();
        $data['devName'] = $devName = trim($this->input->get('txtName'));
        $data['dataId'] = $dataId = $this->input->get('txtDataId');
        $data['keyWord'] = $keyWord = trim($this->input->get('keyWord'));
        $data['active'] = $active = $this->input->get('selActive');
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        
        $city_code = "";
        if($this->userObj->user_role != "admin"){
        	$city_code = $this->userObj->city_code;
        }
        
        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        	 
        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '管理员门禁列表');
        	$xls->addRow(array("分公司","区域","局站","机房","采集单元","设备名","数据ID","权限控制","","下发状态","门禁状态",""));
        	$data['devList'] = $devList = $this->mp_xjdh->Get_User_Door_List($user_id, $cityCode, $countyCode, $substationId, $roomId, false, array("DoorXJL"/*"EMSProtocol"*/), $active, $devName,
                false, false,$dataId,$city_code, $keyWord);
        	
        	foreach($data['devList'] as $devObj)
        	{   
        		if($devObj->card_control == 1){$devObj->card_control = '刷卡开门';}
        		if($devObj->card_control == 0){$devObj->card_control = '无刷卡开门';}
        		if($devObj->remote_control == 1){$devObj->remote_control ='远程开门';}
        		if($devObj->remote_control == 0){$devObj->remote_control ='远程开门';}
        		if($devObj->smd_device_active == 1){$devObj->smd_device_active = '采集板已激活';}
        		if($devObj->smd_device_active == 0){$devObj->smd_device_active = '采集板未激活';} 
        	    if($devObj->active == 1){$devObj->active = '设备已激活';}
        		if($devObj->active == 0){$devObj->active = "设备未激活";}
        		$xls->addRow(array(
        				Defines::$gCity[$devObj->city_code], Defines::$gCounty[$devObj->city_code][$devObj->county_code], $devObj->suname, $devObj->room_name, $devObj->smd_device_name, $devObj->name, $devObj->data_id, 
        				$devObj->card_control, $devObj->remote_control, $devObj->status, $devObj->smd_device_active,$devObj->active
        		));
        	}
        	 
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="管理员门禁列表.xls"');
        	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        	header('Expires:0');
        	header('Pragma:public');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('管理员门禁列表');
        	return;
        }
        
        $data['count'] = $count = $this->mp_xjdh->Get_User_Door_Count($user_id, $cityCode, $countyCode, $substationId, $roomId, false, array("DoorXJL"/*"EMSProtocol"*/), $active, $devName,$dataId,$city_code, $keyWord, $gCounty);
        $data['devList'] = $devList = $this->mp_xjdh->Get_User_Door_List($user_id, $cityCode, $countyCode, $substationId, $roomId, false, array("DoorXJL"/*"EMSProtocol"*/), $active, $devName,$offset, DEFAULT_PAGE_SIZE,$dataId,$city_code, $keyWord, $gCounty);
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/door_user_list/".$user_id), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        $data['user_id'] = $user_id;
        $content = $this->load->view("portal/door_user_list", $data, TRUE);
        $scriptExtra = '<link rel="stylesheet" href="/public/js/jstree/themes/default/style.min.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jstree/jstree.min.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/door_user_list.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '门禁用户管理', $data);
    }
    
    public function rt_log ($data_id = 0)
    {
        $data = array();
        $data['actTab'] = 'settings';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '实时状态监测';
        $bcObj->url = '/portal/data_monitor';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '实时日志';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        if ($data_id < 10000) {
            // this is a smd_device
            $data['type'] = 0;
            $data['smdDev'] = $this->mp_xjdh->Get_SMD_Device_By_no($data_id);
            $data['devList'] = $this->mp_xjdh->Get_Device_By_SMD_no($data_id);
        } else {
            $data['type'] = 1;
            $data['devObj'] = $this->mp_xjdh->Get_Device($data_id);
        }
        $content = $this->load->view("portal/rt_log", $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/JSMQ.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/rt_log.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '实时日志', $data);
    }

    public function data_monitor ($model='')
    {
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'settings';
        $data['bcList'] = array();
        
        $data['model'] = $model = $this->input->get('model');
               
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        $data['roomId'] = $roomId = $this->input->get('selRoom');       
        $data['devName'] = $devName = trim($this->input->get('txtName'));
        $data['dataId'] = $dataId = trim($this->input->get('txtDataId'));
        $data['selActive'] = $active = $this->input->get('selActive');
        $data['substationList'] = $this->mp_xjdh->Get_Substations();
        $data['roomList'] = $this->mp_xjdh->Get_Rooms();
        $data['keyWord'] = $keyWord = trim($this->input->get('keyWord'));

        $city_code = "";
        if($this->userObj->user_role != "admin"){
        	$city_code = $this->userObj->city_code;
        }
        
        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        
        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '实时状态监测');
        	$xls->addRow(array("分公司","区域","局站","机房","采集器IP","采集器编号","设备名","数据ID","设备类型","物理端口号","是否激活"));
        	$data['devList'] = $devList = $this->mp_xjdh->Get_All_Devices($model, $active, $cityCode, $countyCode, $substationId, $roomId, $dataId, $devName, $keyWord, false, false, $city_code);
        	foreach($data['devList'] as $devObj)
        	{
        		if($devObj->active == '1'){$devObj->active = '已激活';}
        		if($devObj->active == '0'){$devObj->active = '未激活';}
        		$xls->addRow(array(
        				Defines::$gCity[$devObj->city_code], Defines::$gCounty[$devObj->city_code][$devObj->county_code], $devObj->suname,$devObj->room_name,
        				$devObj->ip, $devObj->smd_device_no, $devObj->name, $devObj->data_id,
        				Defines::$gDevModel[$devObj->model], $devObj->port, $devObj->active
        		));
        	}
        
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="实时状态监测.xls"');
        	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        	header('Expires:0');
        	header('Pragma:public');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('实时状态监测');
        	return;
        }
        
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        $data['devList'] = $devList = $this->mp_xjdh->Get_All_Devices($model, $active, $cityCode, $countyCode, $substationId, $roomId, $dataId, $devName, $keyWord, $offset, DEFAULT_PAGE_SIZE, $city_code);
        $data['count'] = $count = $this->mp_xjdh->Get_Devices_Count($model, $active, $cityCode, $countyCode, $substationId, $roomId, $dataId, $devName, $keyWord, $city_code);
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/data_monitor"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        //var_dump($data['pagination']).die;
        $this->load->driver('cache');
        foreach ($devList as $devObj) {
            $memData = $this->cache->get($devObj->data_id);
            if ($memData != false) {
                $devObj->data_status = "正常";
                if (in_array($devObj->model, array('water','smoke'))) {
                    if (strlen($memData) == 1) {
                        $val = unpack('C', $memData);
                        $devObj->value = $val[1];
                    } else {
                        $devObj->value = 0;
                    }
                } else 
                    if (in_array($devObj->model, array('temperature','humid'))) {
                        if (strlen($memData) == 4) {
                            $val = unpack('f', $memData);
                            $devObj->value = number_format($val[1], 2);
                        } else {
                            $devObj->value = 0;
                        }
                    }
            } else {
                $devObj->data_status = "异常";
            }
        }
        $data['devList'] = $devList;
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '实时状态监测';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $scriptExtra = '';
        $content = $this->load->view("portal/data_monitor", $data, TRUE);    
        $scriptExtra = '<script type="text/javascript" src="/public/portal/js/viewdata.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '实时状态监测', $data);

    
    }

    public function rt_set_threshold ()
    {
        $data_id = $this->input->post('data_id');
        $field = $this->input->post('field');
        $setting = $this->input->post('setting');
        $devObj = $this->mp_xjdh->Get_Device($data_id);
        if (count($devObj) == 0) {
            echo json_encode(array("ret" => 1,"msg" => "设备对象未找到"));
            return;
        }
        $jsonRet = array();
        $jsonRet['ret'] = 0;
        $jsonValue = json_decode($devObj->threshold_setting);
        if (! is_object($jsonValue)) {
            $jsonValue = new stdClass();
        }
        $fieldSetting = "value";
        if (! empty($field)) {
            $fieldSetting = $field;
        }
        $jsonValue->$fieldSetting = json_decode($setting);
        $settingStr = json_encode($jsonValue);
        $ret = $this->mp_xjdh->RT_Set_Device_Threshold($data_id, $settingStr);
        if ($ret) {
            $this->load->helper("smdthrift");
            $apiObj = new SMDThrift();
            if (0 == $apiObj->DeviceThresholdFieldChange($data_id, $field)) {
                echo json_encode(array("ret" => 0));
            } else {
                echo json_encode(array("ret" => 1,"msg" => "后台服务器刷新配置失败"));
            }
            return;
        }
        echo json_encode(array("ret" => 1,"msg" => "设置失败"));
        return;
    }
    public function editPrTempAlarmJS ()
    {
    	$setting = $this->input->post('setting');
    	$gdevice = $this->input->post('gdevice');
    	foreach ($gdevice as $data_id){   		
    		$devObj = $this->mp_xjdh->Get_Device($data_id);
//     		    	if (count($devObj) == 0) {
//     		    		echo json_encode(array("ret" => 1,"msg" => "设备对象未找到"));
//     		    		return;
//     		    	}
//     		    	        $jsonRet = array();
//     		    	        $jsonRet['ret'] = 0;
//     		    	        $jsonValue = json_decode($devObj->threshold_setting);    		    	        
//     		    	        if (! is_object($jsonValue)) {
    		    	            $jsonValue = new stdClass();
//    		    	        }
     		    	                $fieldSetting = "value";
//     		    	                if (! empty($field)) {
//     		    	                    $fieldSetting = $field;
//     		    	                }
    		    	                $jsonValue->$fieldSetting = json_decode($setting);
    		    	                $settingStr = json_encode($jsonValue); 
    		    	                $ret = $this->mp_xjdh->RT_Set_Device_Threshold($data_id, $settingStr);
    		    	                $this->load->helper("smdthrift");
    		    	                $apiObj = new SMDThrift();
    		    	              $results = $apiObj->DeviceThresholdFieldChange($data_id, $fieldSetting);
    	}
    	if ($ret) {
    		if (0 == $results) {
    			echo json_encode(array("ret" => 0));
    		} else {
    			echo json_encode(array("ret" => 1,"msg" => "后台服务器刷新配置失败"));
    		}
    		return;
    	}
    	echo json_encode(array("ret" => 1,"msg" => "设置失败"));
    	return;
    }
    public function get_threshold ()
    {
    	$jsonRet = array();
        $data_id = $this->input->get("dataId");
        $field = $this->input->get('field');
        $devObj = $this->mp_xjdh->Get_Device($data_id);
        $subid = $this->input->get('subid');
        if (count($devObj) > 0) {
            $jsonRet['ret'] = 0;
            $jsonValue = json_decode($devObj->threshold_setting);
            $fieldSetting = "value";
            if (! empty($field)) {
                $fieldSetting = $field;
            }
            if (isset($jsonValue->$fieldSetting)) {
                $jsonRet["setting"] = $jsonValue->$fieldSetting;
            }
            $devThresholdList = $this->mp_xjdh->Get_DeviceThresholdByDevType($devObj->model,$field);
            $globalThresholdSetting = array();
            $globalThresholdSettings = array();
            $i = 1;
            foreach ($devThresholdList as $devThresholdObj) {
                $devThresholdSettings = json_decode($devThresholdObj->setting);
                if (count($devThresholdSettings) && $devThresholdObj->partid == 0)
                    $globalThresholdSetting = array_merge($globalThresholdSetting, $devThresholdSettings);
                if (count($devThresholdSettings) && $devThresholdObj->partid == $subid)
                	$globalThresholdSettings = array_merge($globalThresholdSettings, $devThresholdSettings);
            }
            if (count($globalThresholdSetting))
                $jsonRet['globalThresholdSetting'] = $globalThresholdSetting;
            if (count($globalThresholdSettings))
            	$jsonRet['globalThresholdSettings'] = $globalThresholdSettings;
            echo json_encode($jsonRet);
        } else {
            echo json_encode(array("ret" => 1,"msg" => "设备对象未找到"));
        }
    }

    public function get_dv_threshold ()
    {
        $oid = $this->input->get("oid");
        if (! $oid) {
            $jsonRet = array("ret" => 1,"msg" => "参数不正确");
            echo json_encode($jsonRet);
            return;
        }
        $devVar = $this->mp_xjdh->Get_Device_Var($oid);
        if(!count($devVar))
        {
            $jsonRet = array("ret" => 1,"msg" => "参数不正确");
            echo json_encode($jsonRet);
            return;
        }
        if($devVar->substation_id)
        {
            
        }
        if(!empty($devVar->county_code))
        {
            
        }
        echo json_encode(array("ret" => 0,"setting" => json_decode($devVar->setting)));
    }

    public function set_dv_threshold ()
    {
     	$oid = $this->input->post("oid");
        $setting = $this->input->post("setting");
        if (! $oid || ! $setting) {
            $jsonRet = array("ret" => 1,"msg" => "参数不正确");
            echo json_encode($jsonRet);
            return;
        }
        $ret = $this->mp_xjdh->Set_Device_Var($oid, $setting);
        $dvObj = $this->mp_xjdh->Get_Device_Var($oid);
        // We need to notify server to refresh
        $this->load->helper("smdthrift");
        $apiObj = new SMDThrift();
        if (0 == $apiObj->DeviceTypeThresholdChange($dvObj->dev_type)) {
            echo json_encode(array("ret" => 0));
        } else {
            echo json_encode(array("ret" => 1,"msg" => "后台服务器刷新配置失败"));
        }
    }

    public function del_device_var ()
    {
        $oid = $this->input->post("oid");
        if (! $oid) {
            $jsonRet = array("ret" => 1,"msg" => "参数不正确");
            echo json_encode($jsonRet);
            return;
        }
        $this->mp_xjdh->Del_Device_Var($oid);
        echo json_encode(array("ret" => 0));
    }

    public function save_device_var ()
    {
        $oid = $this->input->post("oid"); 
        $dev_type = $this->input->post('dev_type');
        $var_name = $this->input->post('var_name');
        $var_label = $this->input->post('var_label');
        $var_prid = $this->input->post('prid');
        $var_selSubstation = intval($this->input->post('selSubstation'));
        $var_selCity = $this->input->post('selCity');
        if (! $dev_type || ! $var_name || ! $var_label) {
            $jsonRet = array("ret" => 1,"msg" => "参数不正确");
            echo json_encode($jsonRet);
            return;
        }
        $this->mp_xjdh->Save_Device_Var($oid, $dev_type, $var_label, $var_name,$var_prid,$var_selSubstation,$var_selCity);
        // We need to notify server to refresh
        $this->load->helper("smdthrift");
        $apiObj = new SMDThrift();
        if (0 == $apiObj->DeviceTypeThresholdChange($dev_type)) {        	
            echo json_encode(array("ret" => 0));
        } else {
            echo json_encode(array("ret" => 1,"msg" => "后台服务器刷新配置失败"));
        }
    }

    public function fix_alert()
    {
    	$data = array();
    	$data['actTab'] = 'alarm';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '告警管理';
    	$bcObj->url = '#';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '修复告警状态';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);
    	
    	$data['dataId'] = $dataId = $this->input->post('txtDataId');
    	$data['signalId'] = $signalId = $this->input->post('txtSignalId');
    	$data['level'] = $level = $this->input->post('txtLevel');
    	$action = $this->input->post("action");   
    	if($action == "query" || $action == "fix")
    	{
    		if($data['signalId'])
    		{
		    	if($action == "query")
		    	{
    				$alertList = $this->mp_xjdh->Get_Alert_By_Data_Signal_Id($dataId, $signalId, $level);
    			    $datas = array();
    				foreach ($alertList as $alertListObj){
    					array_push($datas, $this->mp_xjdh->Get_Alert_By_Data_Signal_Ids($alertListObj->data_id,$alertListObj->id));
    				}
    				$data['alertList'] = $datas;
		    	}else if($action == "fix")
		    	{
		    		$data['count'] = $this->mp_xjdh->Fix_Alert_By_Data_Signal_Id($data['dataId'], $data['signalId'], $data['level']);
		    		$data['successMsg'] = "共成功重置告警".$data['count'].'条';
		    	}
    		}
    	}
    	$content = $this->load->view("portal/fix_alert", $data, TRUE);
    	$scriptExtra = '<script type="text/javascript" src="/public/portal/js/fix_alert.js"></script>';
    	$this->mp_master->Show_Portal($content, $scriptExtra, '修复告警状态', $data);
    }
    public function Fix_Alert_By_Data_Signal_Id(){
    	$data['Id'] = $this->input->post('alertId');
    	$data['devId'] = $this->input->post('devId');
    	$data['signalId'] = $this->input->post('signalId');
    	$data['level'] = $this->input->post('level');
    	echo $this->mp_xjdh->Fix_Alert_By_Data_Signal_IdS($data['Id'],$data['devId'],$data['signalId'],$data['level']);
    	return;
    }
 	public function device_threshold ($values = 0)
    {
        
       $data = array();
    	$data['userObj'] = $this->userObj;
    	$data['actTab'] = 'settings';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '系统配置';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '告警条件配置';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);
        
        $data['userObj'] = $this->userObj;
        $data['selCity'] = $selCity = $this->input->get('selCity');
        $data['selCounty'] = $selCounty = $this->input->get('selCounty');
        $data['selSubstation'] = $selSubstation = $this->input->get('selSubstation');
        $city_code = "";
        if($this->userObj->user_role != "admin"){
        	$city_code = $this->userObj->city_code;
        }
        $data['substation'] = $this->mp_xjdh->Gets_Substation($selCity, $selCounty);
        $data['dtList'] = $dtList = $this->mp_xjdh->Get_Device_Threshold_List($selCity, $selCounty, $selSubstation,$city_code);
        $substationArray = array();
        foreach($data['dtList'] as $dtObj)
        {
            if(empty($dtObj->city_code))
            {
                $dtObj->apply_area = "全网";
            }else{
                $dtObj->apply_area = Defines::$gCity[$dtObj->city_code];
                if(!empty($dtObj->county_code))
                {
                    $dtObj->apply_area .= "-".Defines::$gCounty[$dtObj->city_code][$dtObj->county_code];
                    if($dtObj->substation_id)
                    {
                        if(!array_key_exists($dtObj->substation_id, $substationArray))
                        {
                            $substationObj = $this->mp_xjdh->Get_Substation($dtObj->substation_id);
                            if(count($substationObj))
                            {
                                $substationArray[$dtObj->substation_id] = $substationObj->name;
                            }else{
                                $substationArray[$dtObj->substation_id] = "局站不存在(".$dtObj->substation_id.")";
                            }
                        }
                        $dtObj->apply_area .= "-".$substationArray[$dtObj->substation_id];
                    }
                }
            }
         }
        $export = $this->input->post('export');
        $import = $this->input->post('import');

        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        	 
        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '告警规则');
        	$xls->addRow(array("设备类型","数据变量标签","数据变量","告警规则"));
        	$data['dtList'] = $dtList = $this->mp_xjdh->Get_Device_Threshold_List($selCity, $selCounty, $selSubstation, $city_code);
        	foreach($data['dtList'] as $dtObj)
        	{
        		$xls->addRow(array(
        				$dtObj->dev_type, $dtObj->var_label, $dtObj->var_name, $dtObj->setting
        		));
        	}
        	 
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="告警规则.xls"');
        	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        	header('Expires:0');
        	header('Pragma:public');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('告警规则');
        	return;
        }
        
       if($import == "importtodb")
       {    
      	 	$config['upload_path'] = './uploads/';
      	 	$config['file_name'] = 'alarm';
      	 	$config['overwrite'] = true;
      	 	$config['allowed_types'] = 'xls|xlsx';
       		$this->load->library('upload', $config);	
       		$result = $this->upload->do_upload();
       		if($result)
       		{
       			$up = $this->upload->data();
       			$file_name = $up["file_name"];
       			require_once("phpexcel/PHPExcel.php");
       			$objPHPExcel = PHPExcel_IOFactory::load('./uploads/'.$file_name);
       			$sheet = $objPHPExcel->getSheet(0);
       			$maxRow = $sheet->getHighestRow();
       			if($sheet->getCell('A'.'1')->getValue() == "设备类型" && $sheet->getCell('B'.'1')->getValue() =="数据变量标签" && $sheet->getCell('C'.'1')->getValue() =="数据变量" && $sheet->getCell('D'.'1')->getValue() =="告警规则")
       			{
       				for($i=2;$i<=$maxRow;$i++)
       				{
       				$dev_type = $sheet->getCell('A'.$i)->getValue();
       				$var_name = $sheet->getCell('C'.$i)-> getValue();
       				$var_label = $sheet->getCell('B'.$i)-> getValue();
       				$setting = $sheet->getCell('D'.$i)-> getValue();
       				$into = $this->mp_xjdh->importexcel($dev_type,$var_name,$var_label,$setting);
       				}
       				unlink ('./uploads/'.$file_name);
       						$countalarm = $maxRow-1;
       						$data['msg'] = "共导入".$countalarm."条规则，请点击刷新页面查看。";
       						//header("Location: device_threshold");
       						//exit;
       			}else{
       				$data['errMsg'] = "请上传正确的文件，包括(设备类型、数据变量标签、数据变量、告警规则)。";
// 				redirect('/portal/device_threshold');
       						//     		echo $success;
       			}
       		}else{
       			$data['errMsg'] = "未选择文件或选择文件不是xls和xlsx格式表格，请重新导入。";
       		}
       }
       $content = $this->load->view("portal/device_threshold", $data, TRUE);
       $scriptExtra = '<script type="text/javascript" src="/public/portal/js/device_threshold.js?v=1"></script>';
       $this->mp_master->Show_Portal($content, $scriptExtra, '告警条件设置', $data);
    }
 
    public function func()
    {
    	require_once("phpexcel/PHPExcel.php");
    	if(file_exists('./uploads/alarm.xls'))
    	{
    		$filetype = 'xls';
    		$objPHPExcel = PHPExcel_IOFactory::load('./uploads/alarm.xls');
    	}
    	if(file_exists('./uploads/alarm.xlsx'))  
    	{
    		$filetype = 'xlsx';
    		$objPHPExcel = PHPExcel_IOFactory::load('./uploads/alarm.xlsx');
    	}	
//     	if($filetype == 'xls')
//    		{
//    			$objPHPExcel = PHPExcel_IOFactory::load('./uploads/alarm.xls');
//    		}
//    		if($filetype == 'xlsx')
//    		{
//     		$objPHPExcel = PHPExcel_IOFactory::load('./uploads/alarm.xlsx');
//     		echo json_encode($objPHPExcel);
//     	}
    	$sheet = $objPHPExcel->getSheet(0);
    	$maxRow = $sheet->getHighestRow();
    	if($sheet->getCell('A'.'1')->getValue() == "设备类型" && $sheet->getCell('B'.'1')->getValue() =="数据变量标签" && $sheet->getCell('C'.'1')->getValue() =="数据变量" && $sheet->getCell('D'.'1')->getValue() =="告警规则")
    	{
    		for($i=2;$i<=$maxRow;$i++)
    		{
    			$dev_type = $sheet->getCell('A'.$i)->getValue();
    			$var_name = $sheet->getCell('C'.$i)-> getValue();
    			$var_label = $sheet->getCell('B'.$i)-> getValue();
    			$setting = $sheet->getCell('D'.$i)-> getValue();
    			$into = $this->mp_xjdh->importexcel($dev_type,$var_name,$var_label,$setting);
    		}
    		if($filetype == 'xls')
    		{
    			unlink ('./uploads/alarm.xls');
    		}
    		if($filetype == 'xlsx')
    		{
    			unlink ('./uploads/alarm.xlsx');
    		}
    		$success = 'yes';
//     		echo $success;
    			//        				redirect('/portal/device_threshold');
       				//header("Location: device_threshold");
    			//exit;
    	}else{
    		$success = 'no';
//     		echo $success;
   		}
   		return;
    }
    
    public function get_station_settings()
    {
    	$id = $this->input->post('id');
    	$stationObj = $this->mp_xjdh->Get_Substation($id);
    	if(count($stationObj))
    	{
    		echo $stationObj->settings;
    	}
    	echo "";
    }
    
    public function save_station_settings()
    {
    	$id = $this->input->post("id");
    	$setting = array();
    	$setting["all_power"] = $this->input->post("all_power");
    	$setting["main_power"] = $this->input->post("main_power");
    	$setting["all_power_consumption"] = $this->input->post("all_power_consumption");
    	$setting["main_power_consumption"] = $this->input->post("main_power_consumption");
    	$this->mp_xjdh->Save_Substation($id,json_encode($setting));
    	$this->load->helper("smdthrift");
    	$apiObj = new SMDThrift();
    	if (0 == $apiObj->ReloadStationSetting()) {
    		echo json_encode(array("ret" => 0));
    	} else {
    		echo json_encode(array("ret" => 1));
    	}
    	
    }
    //PUE能效指标
    public function pue()
    {
    	$data = array();
    	$data['userObj'] = $this->userObj;
    	$data['actTab'] = 'pue';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '能耗分析模型';
    	$bcObj->url = '#';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = 'PUE能效指标';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);
    	//加载所有局站
    	$models = array();    
    	//get获取city county
    	$data['cityCode'] = $cityCode = $this->input->get('selCity');
    	$data['countyCode'] = $countyCode = $this->input->get('selCounty');
        //载入模型带入数据 局站列表
    	$data['stationList'] = $this->mp_xjdh->Get_Substations($cityCode, $countyCode);
    	//查询or导出
    	$action = $this->input->get("action");
    	if($action == "export")
    	{
    		
    		require 'resources/php-excel.class.php';
    		$record_offset = 0;
    		$PAGE_SIZE=2000;
    		$xls = new Excel_XML('UTF-8', false, '负载波动率');
    		$xls->addRow(array("序号","分公司","分局","局站","总耗电功率","主设备功率","瞬时PUE","总能耗","主设备能耗","年度PUE"));
    		$index = 1;
    		foreach($data['stationList'] as $stationObj)
    		{
    			$data = Realtime::Get_PueData($stationObj->id);
    			$xls->addRow(array($index, $stationObj->city, $stationObj->county,$stationObj->name,
    					$data[0]->all_power_compensate."WH", $data[0]->main_power_compensate."WH",$data[0]->pue,
    				    $data[0]->all_power_consumption_compensate."WH", $data[0]->all_power_consumption_compensate."WH", $data[0]->accumulated_pue));
    			$index++;
    		}
    		// Redirect output to a client’s web browser (Excel5)
    		header('Content-Type: application/vnd.ms-excel');
    		header('Content-Disposition: attachment;filename="PUE能效指标.xls"');
    		// If you're serving to IE 9, then the following may be needed
    		header('Cache-Control: max-age=1');
    		$xls->generateXML('PUE能效指标');
    		return;
    	}
    	$content = $this->load->view("portal/pue", $data, TRUE);
    	$scriptExtra = '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-pue.js"></script>';
    	$this->mp_master->Show_Portal($content, $scriptExtra, 'PUE能效指标', $data);
    }
    
    public function reset_fluctuation()
    {

    	$this->load->driver('cache');
    	//加载所有电源设备
    	$models = array();
    	array_push($models, "psma-ac");
    	array_push($models, "psma-dc");
    	array_push($models, "m810g-ac");
    	array_push($models, "m810g-dc");
    	array_push($models, "smu06c-ac");
    	array_push($models, "smu06c-dc");
    	$powerDevices = $this->mp_xjdh->Get_Devices_By_Model(false, false, false, $models);
    	foreach($powerDevices as $pdObj)
    	{
    		echo "reset ".$pdObj->data_id."<br/>";
    		$this->cache->delete($pdObj->data_id."_flunctuation");
    	}
    	
    }
    
    
    public function fluctuation()
    {
    	$data = array();
    	$data['userObj'] = $this->userObj;
    	$data['actTab'] = 'fluctuation';
        $data['bcList'] = array();
        //管理面板下选项
        $bcObj = new Breadcrumb();
        $bcObj->title = '能耗分析模型';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '负载波动率';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        //加载所有电源设备
        $models = array();
        /*array_push($models,"imem_12");
        array_push($models,"aeg-ms10m");
        array_push($models,"aeg-ms10se");
        array_push($models,"m810g-ac");
        array_push($models,"m810g-dc");
        array_push($models,"m810g-rc");*/
        array_push($models, "psma-ac");
        array_push($models, "psma-dc");
    	array_push($models, "m810g-ac");
    	array_push($models, "m810g-dc");
    	array_push($models, "smu06c-ac");
    	array_push($models, "smu06c-dc");
        //array_push($models, "psma-rc");
        
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        
        $data['powerDevices'] = $this->mp_xjdh->Get_Devices_By_Model($cityCode, $countyCode, $substationId, $models);
        $action = $this->input->get("action");
        //	导出报表
        if($action == "export")
        {
        	require 'resources/php-excel.class.php';
        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '负载波动率');
        	$xls->addRow(array("序号","分公司","分局","所属局站","设备名称","稳定负载","当前负载","当前电流","突变波动率","周期波动率"));
        	$index = 1;
        	foreach($data['powerDevices'] as $pdDev)
        	{
        		$data = Realtime::Get_FlunctuationData($pdDev->data_id);
        		$xls->addRow(array($index, Defines::$gCity[$pdDev->city_code], Defines::$gCounty[$pdDev->city_code][$pdDev->county_code],$pdDev->substation_name,$pdDev->name,
        				$data[0]->stable_load."W", $data[0]->stable_i."W",$data[0]->load."W", $data[0]->i."W",
        				$data[0]->sudden_flunctuation, $data[0]->period_flunctuation));
        		$index++;
        	}
        	// Redirect output to a client’s web browser (Excel5)
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="负载波动率.xls"');
        	// If you're serving to IE 9, then the following may be needed
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('负载波动率');
        	return;
        }
        $content = $this->load->view("portal/fluctuation", $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-flunctuation.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '负载波动率', $data);
    }
    public function device_pi_setting ($mode = 'battery24')
    {
        $data = array();
        $data['actTab'] = 'settings';
        $data['bcList'] = array();
        $data['mode'] = $mode;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // do save here
            $piGlobal = $this->input->post('piGlobal');
            $piScript = $this->input->post('piScript');
            // pi
            $nameArr = $this->input->post('piName[]');
            $labelArr = $this->input->post("piLabel[]");
            // alert
            $alertNameArr = $this->input->post('alertName[]');
            $alertLabelArr = $this->input->post('alertLabel[]');
            $alertLevelArr = $this->input->post('alertLevel[]');
            $signalNameArr = $this->input->post('signalName[]');
            $signalIdArr = $this->input->post('signalId[]');
            $alertMsgArr = $this->input->post('alertMsg[]');
            $this->mp_xjdh->Save_Device_Pi_Setting($mode, $piGlobal, $piScript, $nameArr, $labelArr, $alertNameArr, $alertLabelArr, $signalNameArr, $signalIdArr, 
                    $alertLevelArr, $alertMsgArr);
            $this->load->helper("smdthrift");
            $apiObj = new SMDThrift();
            if (0 == $apiObj->DeviceTypePiSettingChange($mode)) {
                $ret = 1;
            } else {
                $ret = 0;
            }
        }
        $piObj = $this->mp_xjdh->Get_Device_Pi_Setting($mode);
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '性能指标设置';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data["piObj"] = $piObj;
        if (count($piObj)) {
            $data['varList'] = json_decode($piObj->vars);
            $data['alertList'] = json_decode($piObj->alert);
        } else {
            $data['varList'] = array();
            $data['alertList'] = array();
        }
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/device_pi_setting.js"></script>';
        $content = $this->load->view("portal/device_pi_setting", $data, TRUE);
        
        $this->mp_master->Show_Portal($content, $scriptExtra, '性能分析条件设置', $data);
    }

    function _get_realtimedata_header($isActive=false, $url='', $name='')
    {
    	return '<li '. ($isActive ? "class='active'":"").'><a href="'.$url.'"><i class="icon-tasks"></i>'.$name.'</a></li>';
    }
    
     public function substation_list_county($countyCode)
     {
     	$data = array();
     	$data['actTab'] = 'rt_data';
     	$data['bcList'] = array();
     	$data['substationList'] = $this->mp_xjdh->Get_Substations(false,$countyCode);
     	$data['county'] = Defines::$gCity[$countyCode];
     	$bcObj = new Breadcrumb();
     	$bcObj->title = Defines::$gCity[$cityCode]."局站列表";
     	$bcObj->isLast = true;
     	 
     	array_push($data['bcList'], $bcObj);
     	$content = $this->load->view("portal/substation_list", $data, TRUE);
     	$this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
     }
    
    public function substation_list($cityCode='')
    {
        if(empty($cityCode) || !isset(Defines::$gCity[$cityCode]))
        {
            redirect("/portal");
        }    
    	$data = array();
    	$data['actTab'] = 'rt_data';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '实时数据管理';
    	$bcObj->url = '#';
    	array_push($data['bcList'], $bcObj);
    	
    	$data['gCounty'] = $gCounty = Defines::$gCounty;
    	$data['keyWord'] = $keyWord = $this->input->get('keyWord');
    	if(in_array($this->userObj->user_role, array("admin","noc"))){
    		$data['substationList'] = $this->mp_xjdh->Search_Substation($keyWord, $cityCode, $substationIdList, $size, $offset, $gCounty);
    	}else{
    	    if($cityCode != $this->userObj->city_code)
    	    {
    	        //没有权限
    	        redirect("/portal");
    	    }
    	    //在权限范围内，显示可以查看的局站
    	    if(in_array($this->userObj->user_role, array("city_admin")))
    	    {
    	        //显示分公司所有局站
    	        $data['substationList'] = $this->mp_xjdh->Search_Substation($keyWord, $cityCode, $substationIdList, $size, $offset, $gCounty);
    	    }else{
    	        //根据用户授权表，显示可以查看的局站
    	        $userPrivilegeObj = User::Get_UserPrivilege($this->userObj->id);
    	        if(count($userPrivilegeObj))
    	        {
    	            $substationIdArray = json_decode($userPrivilegeObj->area_privilege);
    	            $data['substationList'] = $substationList = $this->mp_xjdh->Search_Substation($keyWord, $cityCode, $substationIdArray, $size, $offset, $gCounty);
    	        }else{
    	            $data['substationList'] = $substationList = array();
    	        }
    	    }
    	   
		    $data['city'] = Defines::$gCity[$cityCode];
    	}
    	$bcObj = new Breadcrumb();
    	$bcObj->title = Defines::$gCity[$cityCode]."局站列表";
    	$bcObj->isLast = true;
    	
    	array_push($data['bcList'], $bcObj);
    	$content = $this->load->view("portal/substation_list", $data, TRUE);
    	$this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
    }
    
    function _Check_User_Privilege($substationObj)
    {
        if(in_array($this->userObj->user_role, array("admin","noc"))){
            return true;
        }else{
            if($this->userObj->user_role == "city_admin")
            {
                if($substationObj->city_code == $this->userObj->city_code)
                {
                    return true;
                }
            }else{
                $userPrivilegeObj = User::Get_UserPrivilege($this->userObj->id);
                if(count($userPrivilegeObj))
                {
                    $substationIdArray = json_decode($userPrivilegeObj->area_privilege);
                    if(in_array($substationObj->id, $substationIdArray))
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    public function room_list($substationId)
    {
        //这个地方先判断用户有没有权限
        
    	$data = array();
    	$data['actTab'] = 'rt_data';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '实时数据管理';
    	$bcObj->url = '#';
    	array_push($data['bcList'], $bcObj);
    	$data['roomList'] = $this->mp_xjdh->Get_Room_List(false, false , $substationId);
    	$data['substationObj'] = $substationObj = $this->mp_xjdh->Get_Substation($substationId);
    	if(!$this->_Check_User_Privilege($substationObj))
    	{
    	    redirect("/portal");
    	}
    	$bcObj = new Breadcrumb();
    	$bcObj->title = Defines::$gCity[$substationObj->city_code]."局站列表";
    	$bcObj->url = site_url("portal/substation_list/".$substationObj->city_code);
    	$bcObj->isLast = false;
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = $substationObj->name;
    	$bcObj->isLast = true;    	 
    	array_push($data['bcList'], $bcObj);
    	
    	$content = $this->load->view("portal/room_list", $data, TRUE);
    	$this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
    }
    
    private function _show_smd_device($dataObj)
    {
        $deviceList = $this->mp_xjdh->Get_Device_By_SMD_no($dataObj->device_no);
        $diList = array();
        $aiList = array();
        $spList = array();
        foreach($deviceList as $deviceObj)
        {
            switch($deviceObj->dev_type)
            {
                case 0:
                    array_push($diList, $deviceObj);
                    break;
                case 1:
                    array_push($aiList, $deviceObj);
                    break;
                case 2:
                    array_push($spList, $deviceObj);
                    break;
            }
        }
        return $this->load->view ("portal/DevicePage/smd_device", array("dataObj"=>$dataObj, "diList"=>$diList,"aiList"=>$aiList, "spList"=>$spList), TRUE);
    }
    
    public function reloadcamera($data_id = 0)
    {
    	$jsonRet = array();
    	$this->load->helper("smdthrift");
    	$apiObj = new SMDThrift();
	$ret = $apiObj->reloadCamera($data_id);
	var_dump($ret);
    }
    
    public function reload_camera_para()
    {
    	$jsonRet = array();
    	$data_id = $this->input->post("data_id");
    	$this->load->helper("smdthrift");
    	$apiObj = new SMDThrift();
    	$ret = $apiObj->reloadCamera($data_id);
    	if($ret == 0)
    	{
    		$jsonRet['ret'] = 0;
    	}else if($ret < 0)
    	{
    		$jsonRet['ret'] = 1;
    		if($ret == -1)
    		{
    			$jsonRet['msg'] .= "未找到设备";
    		}else if($ret == -2)
    		{
    			$jsonRet['msg'] .= "参数格式不正确";
    		}else if($ret == -3)
    		{
    			$jsonRet['msg'] .= "参数配置为空";
    		}else if($ret == -4)
    			{
    			$jsonRet['msg'] .= "参数未重置";
    		}else{
    			$jsonRet['msg'] .= "未知原因";
    		}
    	}
    	echo json_encode($jsonRet);
    }
    
    public function get_video_url()
    {
        $jsonRet = array();
        $data_id = $this->input->post("data_id");
        $this->load->helper("smdthrift");
        $apiObj = new SMDThrift();
        $ret = $apiObj->cameraDoMonitor($data_id);
        if($ret > 0)
        {
            $jsonRet['ret'] = 0;
            $jsonRet['url'] = "http://120.70.237.235:".$ret;
        }else if($ret < 0)
        {
            $jsonRet['ret'] = 1;
            $jsonRet['msg'] = "获取实时地址失败:";
            if($ret == -1)
            {
                $jsonRet['msg'] .= "未找到设备";
            }else if($ret == -2)
            {
                $jsonRet['msg'] .= "参数配置不正确";
            }else if($ret == -3)
            {
                $jsonRet['msg'] .= "播放地址不正确";
            }else{
                $jsonRet['msg'] .= "未知原因".$ret;
            }
        }
        echo json_encode($jsonRet);
    }
    public function realtimedata ($roomId, $model='', $active_data_id='')
    { 
    	$this->load->driver('cache');
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'rt_data';
        $data['active_data_id'] = $active_data_id;
        $data['bcList'] = array();
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        $data['model'] = $model;
        $data['roomObj'] = $roomObj = $this->mp_xjdh->Get_Room_ById($roomId);
        $data['substationObj'] = $substationObj = $this->mp_xjdh->Get_Substation($roomObj->substation_id);
        if(!$this->_Check_User_Privilege($substationObj))
        {
            redirect("/portal");
        }
        $bcObj = new Breadcrumb();
        $bcObj->title = Defines::$gCity[$substationObj->city_code];
        $bcObj->url = site_url("portal/substation_list/".$substationObj->city_code);
        $data['subid'] = $substationObj->id;
        $bcObj->isLast = false;
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $substationObj->name;
        $bcObj->url = site_url("portal/room_list/".$substationObj->id);
        $bcObj->isLast = false;
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $roomObj->name;
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        if(in_array($_SESSION['XJTELEDH_USERROLE'],array("operator"))){
        	$deviceContentHeader = "";
         $devConfigs = array(
            array(array('temperature','humid','smoke','water'), "机房环境","enviroment"),
            array(array('DoorXJL',"EmersonDoor"), "门禁系统", "door"),
            );
        	foreach($devConfigs as $devConfig)
        	{
        		$dataList = $this->mp_xjdh->Get_Room_Devices($roomId, $devConfig[0]);
        		if(count($dataList))
        		{
        			//we need to append an item to header
        			if(empty($model))
        			{
        				$data['model'] = $model = $devConfig[2];
        			}
        		
        			$deviceContentHeader .= $this->_get_realtimedata_header($devConfig[2] == $model,  site_url("portal/realtimedata/$roomId/$devConfig[2]"), $devConfig[1]);
        			if($devConfig[2] == $model)
        			{        				
        				//这里要分成两种，一种是集中显示的（如机房环境），一种是分列显示的,电池等
        				if($model == "enviroment")
        				{       			
        					$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-addi.js"></script>';
        					$data['deviceContentBody'] = $this->load->view('portal/DevicePage/enviroment', array("dataList"=>$dataList, "room_name"=>$roomObj->name), TRUE);
        				}else{
        					$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-' . $model . '.js"></script>';       					 
        	foreach($dataList as $dataObj){
        		switch($model)
        		{
        		    case "door":
			    	{     
			    			$devObj = $this->mp_xjdh->Get_Device($dataObj->data_id);
			    			if(count($devObj))
			    			{
			    				if($devObj->city_code == $this->userObj->city_code)
			    					$canOpen = true;
			    			}
			    		$tmpData = array();
			    		$tmpData['canOpen'] = $canOpen;
			    		$tmpData['desc'] = $this->mp_xjdh->Get_door_record($_SESSION['XJTELEDH_USERID']);
			    		$tmpData['dataObj'] = $dataObj;
			    		$dataObj->html = $this->load->view('portal/DevicePage/door', $tmpData, TRUE);	
			    		
			    	}
        	    }
        	}
        	$data["dataList"] = $dataList;
        	$data['deviceContentBody'] = $this->load->view("portal/device_data_ctrl", $data, TRUE);
        				}
        	}
        	}
        	}
        }
        //以后添加新显示都在这里添加配置,在单独的页面进行数据处理和显示
    	//array(modelList, "display name", "compound name") 
        
        //处理header和body的显示
        if(!in_array($this->userObj->user_role,array("operator"))){
            $deviceContentHeader = "";
        foreach(Constants::$devConfigList as $devConfig)
        {
        	$dataList = $this->mp_xjdh->Get_Room_Devices($roomId, $devConfig[0]);
        	if(count($dataList))
        	{
        		//we need to append an item to header
        		if(empty($model))
        		{
        			$data['model'] = $model = $devConfig[2];
        		}
        		
    			$deviceContentHeader .= $this->_get_realtimedata_header($devConfig[2] == $model,  site_url("portal/realtimedata/$roomId/$devConfig[2]"), $devConfig[1]);
        		
        		if($devConfig[2] == $model)
        		{
        			//这里要分成两种，一种是集中显示的（如机房环境），一种是分列显示的,电池等
        			if($model == "enviroment")
        			{
        			    $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-addi.js"></script>';
        				$data['deviceContentBody'] = $this->load->view('portal/DevicePage/enviroment', array("dataList"=>$dataList, "room_name"=>$roomObj->name, 'userObj'=>$this->userObj), TRUE);
        			}else{
				    if($model == "sps")
        			    {
        			        $data['groupList'] = $groupList = $this->mp_xjdh->Get_DevGroup($roomId, $devConfig[0]);
        			    }else if($model == 'camera')
        			    {
        			    	$data['groupList'] = $groupList = $this->mp_xjdh->Get_vcamera($roomId);
                                    }
                                    if(!in_array($model, array("ac")))
        			    {
        			        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-' . $model . '.js"></script>';
        			    }
        			    foreach($dataList as $dataObj)
            			{
            				//$devDcList = $this->mp_xjdh->Get_DeviceDynamicConfig($dataObj->data_id);
            				switch($model)
            				{
            					case "sps":
            						{            						    
            							if (in_array($dataObj->model, array('psma-ac','psma-dc','psma-rc')))
				                            $dataObj->html = $this->load->view('portal/DevicePage/psm-a', array('psmAObj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
				                        else if (in_array($dataObj->model, array('m810g-ac','m810g-dc','m810g-rc')))
				                            $dataObj->html = $this->load->view('portal/DevicePage/m810g', array('m810gObj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
									    else if (in_array($dataObj->model, array('zxdu-ac','zxdu-dc','zxdu-rc')))
				                             $dataObj->html = $this->load->view('portal/DevicePage/zxdu', array('zxduObj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
				               	        else if (in_array($dataObj->model, array('smu06c-ac','smu06c-dc','smu06c-rc')))
				                            	$dataObj->html = $this->load->view('portal/DevicePage/smu06c', array('smu06cObj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
									    else{
									        $dataObj->html = $this->load->view ("portal/DevicePage/".$dataObj->model, array("dataObj"=>$dataObj, 'userObj'=>$this->userObj), TRUE );
									    }
            							break;
            						}
            					case "liebert-ups":
            						{
            							
            							if($dataObj->model == "liebert-ups")
            							{
            								$dataObj->html = $this->load->view('portal/DevicePage/liebert-ups', array('liebertUpsObj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
            							}
            							break;
            						}
            					case "ac":
            						{
            							if($dataObj->model == "liebert-pex")
            							{
            								$dataObj->html = $this->load->view('portal/DevicePage/liebert-pex', array('liebertPexObj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
            								$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-' . $dataObj->model . '.js"></script>';
            							}else if($dataObj->model == "ug40")
            							{
            								$dataObj->html = $this->load->view('portal/DevicePage/ug40', array('ug40Obj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
            								$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-' . $dataObj->model . '.js"></script>';
            							}
            							else if($dataObj->model == "canatal")
            							{
            								$dataObj->html = $this->load->view('portal/DevicePage/canatal', array('canatal' => $dataObj, 'userObj'=>$this->userObj), TRUE);
            								$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-' . $dataObj->model . '.js"></script>';
            							}else if($dataObj->model == "datamate3000")
            							{
            							    $dataObj->html = $this->load->view('portal/DevicePage/datamate3000', array('dataObj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
            							    $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-' . $dataObj->model . '.js"></script>';
            							}
            							break;
            						}
            					
            					case "pdu":
            						{
            							if(in_array($dataObj->model, array('aeg-ms10se','aeg-ms10m')))
            							{
            								$dataObj->html = $this->load->view('portal/DevicePage/page-aeg', array('aegObj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
            							}else if($dataObj->model == "vpdu")
								        {
            								$dataObj->html = $this->load->view('portal/DevicePage/vpdu', array('dataObj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
								        }
            							break;
            						}
            					case "engine":
            						{
            						    $dataObj->html = $this->load->view('portal/DevicePage/'.$dataObj->model, array('dataObj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
            						    $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-' . $dataObj->model . '.js"></script>';
            							break;
            						}
            					case "smd_device":
            					    {
            					        $dataObj->html = $this->_show_smd_device($dataObj);
            					        break;
            					    }
            					case "powermeter":
            					    {
            					        if($dataObj->model == "imem_12")
            					        {
            					            $dataObj->html = $this->load->view('portal/DevicePage/imem12', array('dataObj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
            					        }else if($dataObj->model == "power_302a")
            					        {
            					            $dataObj->html = $this->load->view('portal/DevicePage/power_302a', array('dataObj' => $dataObj, 'userObj'=>$this->userObj), TRUE);
            					        }
            					        break;
            					    }
        					    case "door":
        					    	{           					    		      
        					    		$tmpData = array();
        					    		$canOpen = false;
        					    		if($this->userObj->user_role == 'admin')
        					    		{
        					    		    $canOpen = true;
        					    		}else if(in_array($this->userObj->user_role, array("city_admin","operator")))
        					    		{
        					    		    $devObj = $this->mp_xjdh->Get_Device($dataObj->data_id);
        					    		    if(count($devObj))
        					    		    {
        					    		        if($devObj->city_code == $this->userObj->city_code)
        					    		            $canOpen = true;
        					    		    }
        					    		}else{
        					    		    $duObj = $this->mp_xjdh->Get_DoorUser($dataObj->data_id, $this->userObj->id);
        					    		    if(count($duObj) && $duObj->remote_control)
        					    		        $canOpen = true;        					    		     
        					    		}
        					    		$tmpData['canOpen'] = $canOpen;//in_array($this->userObj->user_role, array("admin","city_admin")) && count($this->mp_xjdh->Get_DoorUser($dataObj->data_id, $this->userObj->id));
        					    		$tmpData['desc'] = $this->mp_xjdh->Get_door_record($_SESSION['XJTELEDH_USERID']);
        					    		$tmpData['dataObj'] = $dataObj;
        					    		$dataObj->html = $this->load->view('portal/DevicePage/door', $tmpData, TRUE);
        					    	}
            					case "battery":
            						{
            							$extraPara = $this->mp_xjdh->Device_extra_para($dataObj->data_id);
            						    $data['extraPara'] = $extraPara = json_decode($extraPara->extra_para,true);
            							if($extraPara ["connection"] == "44"){ 
            								$data['type'] = $type = "44"; //44代表蓄电池前4后4接法
            							}
                                        if($extraPara ["connection"] == "44i"){
            								$data['type'] = $type = "44i";//前4后4接法个例第一组与第二组之间空两节
            							}
            							if($extraPara ["connection"] == "11"){
            							    $data['type'] = $type = "11"; //11代表蓄电池11节接法
            							}
            				                $dataObj->html = $this->load->view ("portal/DevicePage/battery",$data, TRUE );
            						}
            					case "battery_32":
                                case "canatal":
            					case "camera":
            					case "freshair":
            					case "motor_battery":
            					default:
            						$dataObj->html = $this->load->view ("portal/DevicePage/$model", array("dataObj"=>$dataObj,'ExtraPara'=>$a->c, 'userObj'=>$this->userObj), TRUE );
            						break;
            				}	                				
            			}
            			$data["dataList"] = $dataList;
            			$data['deviceContentBody'] = $this->load->view("portal/device_data_ctrl", $data, TRUE);
        			}
        		}
        	}  	
        }
       }
        $data['deviceContentHeader'] = $deviceContentHeader;
        $data['model'] = $model;

        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data.js"></script>';
        $bcObj = new Breadcrumb();
        $bcObj->title = '实时数据管理';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $content = $this->load->view("portal/realtimedata", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
    }
    
    public function force_open_door()
    {
//         $jsonRet = array();
//         $jsonRet["ret"] = $ret;
//         $data_id = $this->input->post('data_id');
//         $this->load->helper("smdthrift");
//         $apiObj = new SMDThrift();
//         $ret = $apiObj->DoorControl($data_id,3/*OPENDOOR*/);
//         if($ret > 0)
//         {
//             $jsonRet["ret"] = $ret;
//         }else{
//             $jsonRet["ret"] = $ret;
//             $jsonRet["msg"] = "设备未就绪，请重试";
//         }
//         echo json_encode($jsonRet);

        $jsonRet = array();
        $jsonRet["ret"] = $ret;
        $data_id = $this->input->post('data_id');
        $openMessage = $this->input->post('openMessage');
        $action = $this->input->post('action');
        $accessid = $this->mp_xjdh->Get_user2($_SESSION['XJTELEDH_USERID']);
        $this->mp_xjdh->up_door_record($_SESSION['XJTELEDH_USERID'],$openMessage,$accessid,$action,$data_id);
        $this->load->helper("smdthrift");
        $apiObj = new SMDThrift();
        $ret = $apiObj->DoorControl($data_id,3/*OPENDOOR*/);
        if($ret > 0)
        {
        	$jsonRet["ret"] = $ret;
        }else{
        	$jsonRet["ret"] = $ret;
        	$jsonRet["msg"] = "设备未就绪，请重试";
        }
        echo json_encode($jsonRet);   
    }
    
    public function down_user_door()
    {
        $jsonRet = array();
        $jsonRet["ret"] = 0;
        $user_id = $this->input->post('user_id');
        $mode = $this->input->post('mode');
        //get all user doors
        //$doorList = $this->mp_xjdh->Get_User_Door_List($user_id, false, false, false, false, false, array("DoorXJL"/*"EMSProtocol"*/), "active", "",
         //       0, -1);
        if($mode == "clr_down")
        {
            $this->mp_xjdh->Reset_UserDoor($user_id);
        }
        //9:DOWN_LIST 10:DOWN_ALLLIST
        /*switch($mode)
        {
            case "down":
                $mode = 8;
                break;
            case "clr_down":
                $mode = 9;
                break;
            default:
                $mode = 8;
                break;
        }
        $this->load->helper("smdthrift");
        $apiObj = new SMDThrift();
        $iSuccess = 0;
        foreach($doorList as $doorObj)
        {
            $ret = $apiObj->DoorControl($doorObj->data_id,$mode);
            if($ret >= 0)
            {
                $iSuccess++;
            }
        }
        if($iSuccess == count($doorList))
        {
                $jsonRet["ret"] = 0;
        }else if($iSuccess == 0)
        {
            $jsonRet["ret"] = $ret;
            $jsonRet["msg"] = "所有设备离线，请重试";
        }else if($iSuccess)
        {
            $jsonRet["ret"] = $ret;
            $jsonRet["msg"] = "部分设备离线，请重试";
        }*/
        header('Content-type: application/json');
        echo json_encode($jsonRet);
    }
    
    public function down_doorlist()
    {
        $jsonRet = array();
        $jsonRet["ret"] = 0;
        $data_id = $this->input->post('data_id');
        $mode = $this->input->post('mode');
        if($mode == "clr_down")
        {
            //现在只支持这一种
            $this->mp_xjdh->Reset_DoorUser($data_id);
        }
        /*$this->load->helper("smdthrift");
        $apiObj = new SMDThrift();
        switch($mode)
        {
            case "down":
                $mode = 8;
                break;
            case "clr_down":
                $mode = 9;
                break;
            default:
                $mode = 8;
                break;
        }
        $ret = $apiObj->DoorControl($data_id,$mode);
        if($ret > 0)
        {
            $jsonRet["ret"] = 0;
        }else{
            $jsonRet["ret"] = $ret;
            $jsonRet["msg"] = "设备离线，请重试";
        }*/
        header('Content-type: application/json');
        echo json_encode($jsonRet);
    }
    public function open_door()
    {
        $jsonRet = array();
        $jsonRet["ret"] = $ret;
        $data_id = $this->input->post('data_id');
        $openMessage = $this->input->post('openMessage');
        $action = $this->input->post('action');
        $accessid = $this->mp_xjdh->Get_user2($_SESSION['XJTELEDH_USERID']);
        $this->mp_xjdh->up_door_record($_SESSION['XJTELEDH_USERID'],$openMessage,$accessid,$action,$data_id);
        $this->load->helper("smdthrift");
        $apiObj = new SMDThrift();
        for($j = 0; $j < 3; $j++)
        {
            $ret = $apiObj->DoorControl($data_id,1/*OPENDOOR*/);
            if($ret > 0)
            {
                $i =0 ;
                while($i++ <5)
                {
                    usleep(200000);
                    $ret = $apiObj->DoorControl($data_id,2/*OPENDOOR_STATUS*/);
                    if($ret == 1)
                    {
                        $jsonRet["ret"] = 0;
                        echo json_encode($jsonRet);
                        return;
                    }
                }
            }else{
                $jsonRet["ret"] = 1;
                $jsonRet["msg"] = "设备未就绪，请重试";
                break;
            }
        }
        if($j == 3)
        {
            $jsonRet["ret"] = 1;
            $jsonRet["msg"] = "开门失败，请重试";
        }
        echo json_encode($jsonRet);
    }
    
    public function record(){
    	$accessid=$this->input->post("accessid");
    	$data_id=$this->input->post("data_id");
        $method=$this->input->post("method");        
	    $accessidint=intval($accessid);	  
     	$this->load->helper("smdthrift");
     	$apiObj = new SMDThrift();
     	$ret = $apiObj->doorOperate($data_id,$accessidint,$method);     	
        var_dump($ret);
    }
	public function remoteForceOpenDoor(){
    	$data_id=$this->input->get("data_id");
     	$this->load->helper("smdthrift");
     	$apiObj = new SMDThrift();
     	$name = $apiObj->remoteForceOpenDoor($data_id);
    	$method=$this->input->get("method");
    	$s=$this->input->get("s");
    	if($method != "" && $method != false){
    		$this->mp_xjdh->insert_record($method,$s);
    		$data['offset'] = $offset = intval($this->input->get('per_page'));
    		$data['count']=$count= $this->mp_xjdh->Get_records();
    		$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/record"), $count, 6, 3, TRUE);
    		 
    		$data['record'] = $this->mp_xjdh->Get_record($offset,6);
    	echo json_encode($data);
    	}
    }
	public function isDoorOperateOk(){
		$data_id=$this->input->get("data_id");
        $mode=$this->input->get("mode");
     	$this->load->helper("smdthrift");
     	$apiObj = new SMDThrift();
     	$name = $apiObj->isDoorOperateOk($data_id,$mode);                             
           echo json_encode($name);
		return;
    }
    public function rkedown(){
    	$roomid=$this->input->get("roomid");  
    	$data_id=$this->input->get("data_id");
    	$count=$this->mp_xjdh->rkedown($roomid);
    	$userArr = array();
    	foreach($count as $cmObj)
    	{
    		array_push($userArr, $cmObj->accessid);
    	}
//     	 $currents=current($count);      	
//     	 $accessid=(int)$currents->accessid;
    	$this->load->helper("smdthrift");
    	$apiObj = new SMDThrift();
    	$name = $apiObj->isDoorOperateOk($accessid,$data_id);
    	echo json_encode($data);
    	return;
    }
    public function deleterkedown(){
    	$roomid=$this->input->get("roomid");
    	$data_id=$this->input->get("data_id");
    	$count=$this->mp_xjdh->rkedown($roomid);
    	$currents=current($count);
    	$accessid=(int)$currents->accessid;
    	$this->load->helper("smdthrift");
    	$apiObj = new SMDThrift();
    	$name = $apiObj->isDoorOperateOk($accessid,$data_id);
    	echo json_encode($data);
    	return;
    }
    public function userlist(){
    	$subid=$this->input->get("subid");
    	$subcode=$this->input->get("subcode");

    	$dataObj->html = $this->load->view('portal/DevicePage/door', $data, TRUE);
    	$data['deviceContentBody'] = $this->load->view("portal/device_data_ctrl", $data, TRUE);
    	echo json_encode($data);
    	return;
    }
    public function rtsps()
    {
    	$dev_group = $this->input->post('dev_group');
    	$data['switchingPowerSupplyList'] = $this->mp_xjdh->Get_spsList($dev_group);
    	if (count($data['switchingPowerSupplyList']))
    		array_push($modelArr, 'sps');
    	
    	
    	
    	echo json_encode($data);
    	return;
    }

    public function getcounty ()
    {
        $jsonRet = array();
        $cityCode = $this->input->get('citycode');
        if (array_key_exists($cityCode, Defines::$gCounty)) {
            $jsonRet['ret'] = 0;
            $jsonRet['countyList'] = array();
            foreach (Defines::$gCounty[$cityCode] as $key => $val) {
                $obj = new stdClass();
                $obj->key = $key;
                $obj->val = $val;
                array_push($jsonRet['countyList'], $obj);
            }
        } else {
            $jsonRet['ret'] = 1;
        }
        echo json_encode($jsonRet);
        return;
    }
        
    public function getversion ()
    {
    	$jsonRet = array();
    	$manufacturers = $this->input->get('manufacturers');
    	if (1) {
    		$jsonRet['ret'] = 0;
    		$jsonRet['versionList'] = array();
    		foreach (Defines::$gBrand[$manufacturers] as $key => $val) {
    			$obj = new stdClass();
    			$obj->key = $key;
    			$obj->val = $val;
    			array_push($jsonRet['versionList'], $obj);
    		}
    	} else {
    		$jsonRet['ret'] = 1;
    	}
    	echo json_encode($jsonRet);
    	return;
    }
    

    public function remotecontrol ()
    {
        $data = array();
        $data['actTab'] = 'remote_control';
        $scriptExtra = '';
        $content = $this->load->view("portal/index", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
    }

    public function _get_device_modelGroup()
    {
        $devModelGroup = array();
        foreach(Constants::$devConfigList as $devConfig)
        {
            foreach($devConfig[0] as $model)
            {
                $devModelGroup[$model] = $devConfig[2];
            }
        }
        $devModelGroup['venv'] = "enviroment";
        return $devModelGroup;
    }
    public function device_manage ()
    {
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'settings';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '设备配置';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $data['devModelGroup'] = $this->_get_device_modelGroup();

        $data['gCounty'] = $gCounty = Defines::$gCounty;
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        $data['substationList'] = $this->mp_xjdh->Get_Substations();
        $data['roomId'] = $roomId = $this->input->get('selRoom');
        $data['roomList'] = $this->mp_xjdh->Get_Rooms();
        $data['deviceNo'] = $deviceNo = $this->input->get('selSmdDev');
        $data['smdDevList'] = $this->mp_xjdh->Get_SMDDevices();
        $data['selModel'] = $model = $this->input->get('selModel');      
        $data['devgroup'] = $devgroup = $this->input->get('devgroup');
        $data['devName'] = $devName = trim($this->input->get('txtName'));
        $data['dataId'] = $dataId = trim($this->input->get('txtDataId'));
        $data['selActive'] = $active = $this->input->get('selActive');
        $data['keyWord'] = $keyWord = trim($this->input->get('keyWord'));
        
        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';

        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '设备配置');
        	$xls->addRow(array("分公司","区域","局站","机房","采集单元","设备名",
        			"数据ID", "设备类型","物理端口号","逻辑参数","是否激活"));
        	$data['devList'] = $devList = $this->mp_xjdh->Get_Device_List($cityCode, $countyCode, $substationId, $roomId, $deviceNo, $model, $devgroup, $active, $devName, false, false, $dataId);
        	foreach($data['devList'] as $devObj)
        	{
        		if($devObj->active == '1'){$devObj->active	= '已激活';}
        		if($devObj->active == '0'){$devObj->active = '未激活';}
        		$xls->addRow(array(
        				Defines::$gCity[$devObj->city_code], Defines::$gCounty[$devObj->city_code][$devObj->county_code], $devObj->suname, $devObj->room_name, $devObj->smd_device_name, $devObj->name,
        				$devObj->data_id, Defines::$gDevModel[$devObj->model], $devObj->port, $devObj->extra_para, $devObj->active		
        		));	
        	}
        	
        	header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="设备配置.xls"'); 
            header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
            header('Expires:0');
            header('Pragma:public');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('设备配置');
        	return;
        }
        $city_code = "";
        if($this->userObj->user_role != "admin"){
        	$city_code = $this->userObj->city_code;
        }       
       
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        $data['count'] = $count = $this->mp_xjdh->Get_Device_Count($cityCode, $countyCode, $substationId, $roomId, $deviceNo, $model, $devgroup, $active, $devName, $dataId, $Identifier, $keyWord, $city_code, $gCounty);   
        $data['devList'] = $devList = $this->mp_xjdh->Get_Device_List($cityCode, $countyCode, $substationId, $roomId, $deviceNo, $model, $devgroup, $active, $devName, 
                $offset, DEFAULT_PAGE_SIZE, $dataId , $Identifier, $keyWord, $city_code, $gCounty);
        $data['alertWhitelistObj'] = json_encode(array_values($this->mp_xjdh->Get_alertWhitelist()));   
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/device_manage"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/device_manage.js"></script>';
        $content = $this->load->view("portal/device_manage", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '设备配置', $data);
    }
    
    public function smd_device_manage ()
    {
    	$data = array();
    	$data['userObj'] = $this->userObj;
    	$data['actTab'] = 'settings';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '系统配置';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '采集单元配置';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);
    	
    	$data['gCounty'] = $gCounty = Defines::$gCounty;
    	$data['cityCode'] = $cityCode = $this->input->get('selCity');
    	$data['countyCode'] = $countyCode = $this->input->get('selCounty');
    	$data['substationId'] = $substationId = $this->input->get('selSubstation');
    	$data['devName'] = $devName = $this->input->get('txtName');
    	$data['ip'] = $ip = trim($this->input->get('txtIP'));
    	$data['active'] = $active = $this->input->get('selActive');
    	$data['keyWord'] = $keyWord =trim($this->input->get('keyWord'));
    	
    	$export = $this->input->get('export');
    	if($export == "exporttoexcel")
    	{
    		require 'resources/php-excel.class.php';
    		$record_offset = 0;
    		$PAGE_SIZE=2000;
    		$xls = new Excel_XML('UTF-8', false, '采集单元配置');
    		$xls->addRow(array("设备号","分公司","区域","局站","机房","设备名称","IP地址","是否激活"));
    		$data['devList'] = $devList = $this->mp_xjdh->Get_SMD_Device_List($cityCode, $countyCode, $substationId, $ip, $devName, $active = array('0','1'), false, false, $city_code, $keyWord);
    		foreach($data['devList'] as $devObj)
    		{
    			if($devObj->active=='1'){$devObj->active = "已激活";}
    			if($devObj->active=='0'){$devObj->active = "未激活";}
    			$xls->addRow(array(
    					$devObj->device_no, Defines::$gCity[$devObj->city_code], Defines::$gCounty[$devObj->city_code][$devObj->county_code], $devObj->substation_name, 
    					$devObj->room_name, $devObj->name, $devObj->ip, $devObj->active
    			));
    		}
    	
    		header('Content-Type: application/vnd.ms-excel');
    		header('Content-Disposition: attachment;filename="采集单元配置.xls"');
    		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    		header('Expires:0');
    		header('Pragma:public');
    		header('Cache-Control: max-age=1');
    		$xls->generateXML('采集单元配置');
    		return;
    	}
    	
    	$city_code = "";
    	if($this->userObj->user_role != "admin"){
    		$city_code = $this->userObj->city_code;
    	}
    	
    	$data['offset'] = $offset = intval($this->input->get('per_page'));
    	if($active)
    	{
    		if($active == 1)
    		{
    			$data['count'] = $count = $this->mp_xjdh->Get_SMD_Device_Count($cityCode, $countyCode, $substationId, $ip, $devName, array('0','1'), $city_code, $keyWord, $gCounty);
    			$data['devList'] = $devList = $this->mp_xjdh->Get_SMD_Device_List($cityCode, $countyCode, $substationId, $ip, $devName,  array('0','1'), $offset,
    					DEFAULT_PAGE_SIZE, $city_code, $keyWord, $gCounty);
    		}elseif($active == 2)
    		{
    			$data['count'] = $count = $this->mp_xjdh->Get_SMD_Device_Count($cityCode, $countyCode, $substationId, $ip, $devName, array('1'), $city_code, $keyWord, $gCounty);
    			$data['devList'] = $devList = $this->mp_xjdh->Get_SMD_Device_List($cityCode, $countyCode, $substationId, $ip, $devName,  array('1'), $offset,
    					DEFAULT_PAGE_SIZE, $city_code, $keyWord, $gCounty);
    		}elseif($active == 3)
    		{
    			$data['count'] = $count = $this->mp_xjdh->Get_SMD_Device_Count($cityCode, $countyCode, $substationId, $ip, $devName, array('0'), $city_code, $keyWord, $gCounty);
    			$data['devList'] = $devList = $this->mp_xjdh->Get_SMD_Device_List($cityCode, $countyCode, $substationId, $ip, $devName,  array('0'), $offset,
    					DEFAULT_PAGE_SIZE, $city_code, $keyWord, $gCounty);
    		}
    	}else
    	{
    		$data['count'] = $count = $this->mp_xjdh->Get_SMD_Device_Count($cityCode, $countyCode, $substationId, $ip, $devName, array('0','1'), $city_code, $keyWord, $gCounty);
    		$data['devList'] = $devList = $this->mp_xjdh->Get_SMD_Device_List($cityCode, $countyCode, $substationId, $ip, $devName,  array('0','1'), $offset,
    				DEFAULT_PAGE_SIZE, $city_code, $keyWord, $gCounty);
    	}
    	
    	//var_dump($data['devList']);die;
    	$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/smd_device_manage"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
    	$scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/smd_device_manage.js"></script>';
    	$content = $this->load->view("portal/smd_device_manage", $data, TRUE);
    	
    	$this->mp_master->Show_Portal($content, $scriptExtra, '采集单元配置', $data);
    }
    
    public function smd_device_status ()
    {
    	$data = array();
    	$data['userObj'] = $this->userObj;
    	$data['actTab'] = 'settings';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '系统配置';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '查看采集单元状态';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);
    	
    	$data['gCounty'] = $gCounty = Defines::$gCounty;
    	$data['cityCode'] = $cityCode = $this->input->get('selCity');
    	$data['countyCode'] = $countyCode = $this->input->get('selCounty');
    	$data['substationId'] = $substationId = $this->input->get('selSubstation');
    	$data['devName'] = $devName = trim($this->input->get('txtName'));
    	$data['ip'] = $ip = trim($this->input->get('txtIP'));
    	$data['active'] = $active = $this->input->get('selActive');
    	$data['keyWord'] = $keyWord = trim($this->input->get('keyWord'));
    	
    	$export = $this->input->get('export');
    	if($export == "exporttoexcel")
    	{
    		require 'resources/php-excel.class.php';
    		 
    		$record_offset = 0;
    		$PAGE_SIZE=2000;
    		$xls = new Excel_XML('UTF-8', false, '查看采集单元状态');
    		$xls->addRow(array("设备号","分公司","区域","局站","机房","设备名称","IP地址","是否激活"));
    		$data['devList'] = $devList = $this->mp_xjdh->Get_SMD_Device_List($cityCode, $countyCode, $substationId, $ip, $devName, $active = array('0','1'), false, false, $city_code, $keyWord);
    		foreach($data['devList'] as $devObj)
    		{
    			if($devObj->active=='1'){$devObj->active = "已激活";}
    			if($devObj->active=='0'){$devObj->active = "未激活";}
    			$xls->addRow(array(
    					$devObj->device_no, Defines::$gCity[$devObj->city_code], Defines::$gCounty[$devObj->city_code][$devObj->county_code], $devObj->substation_name,
    					$devObj->room_name, $devObj->name, $devObj->ip, $devObj->active
    			));
    		}
    		 
    		header('Content-Type: application/vnd.ms-excel');
    		header('Content-Disposition: attachment;filename="查看采集单元状态.xls"');
    		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    		header('Expires:0');
    		header('Pragma:public');
    		header('Cache-Control: max-age=1');
    		$xls->generateXML('查看采集单元状态');
    		return;
    	}
    	
    	
    	$city_code = "";
    	if($this->userObj->user_role != "admin"){
    		$city_code = $this->userObj->city_code;
    	}
    	$data['offset'] = $offset = intval($this->input->get('per_page'));
    	
    	//$cache=realtime::Get_smd_status();
    	if($active)
    	{
    		if($active == 1)
    		{
    			$data['count'] = $count = $this->mp_xjdh->Get_SMD_Device_Count($cityCode, $countyCode, $substationId, $ip, $devName, array('0','1'), $city_code, $keyWord, $gCounty);
    			$data['devList'] = $devList = $this->mp_xjdh->Get_SMD_Device_List($cityCode, $countyCode, $substationId, $ip, $devName,  array('0','1'), $offset,
    					DEFAULT_PAGE_SIZE, $city_code, $keyWord, $gCounty);
    		}elseif($active == 2)
    		{
    			$data['count'] = $count = $this->mp_xjdh->Get_SMD_Device_Count($cityCode, $countyCode, $substationId, $ip, $devName, array('1'), $city_code, $keyWord, $gCounty);
    			$data['devList'] = $devList = $this->mp_xjdh->Get_SMD_Device_List($cityCode, $countyCode, $substationId, $ip, $devName,  array('1'), $offset,
    					DEFAULT_PAGE_SIZE, $city_code, $keyWord, $gCounty);
    		}elseif($active == 3)
    		{
    			$data['count'] = $count = $this->mp_xjdh->Get_SMD_Device_Count($cityCode, $countyCode, $substationId, $ip, $devName, array('0'), $city_code, $keyWord, $gCounty);
    			$data['devList'] = $devList = $this->mp_xjdh->Get_SMD_Device_List($cityCode, $countyCode, $substationId, $ip, $devName,  array('0'), $offset,
    					DEFAULT_PAGE_SIZE, $city_code, $keyWord, $gCounty);
    		}
    	}else
    	{
    		$data['count'] = $count = $this->mp_xjdh->Get_SMD_Device_Count($cityCode, $countyCode, $substationId, $ip, $devName, array('0','1'), $city_code, $keyWord, $gCounty);
    		$data['devList'] = $devList = $this->mp_xjdh->Get_SMD_Device_List($cityCode, $countyCode, $substationId, $ip, $devName,  array('0','1'), $offset,
    				DEFAULT_PAGE_SIZE, $city_code, $keyWord, $gCounty);
    	}
    	 
    	//var_dump($data['devList']);die;
    	$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/smd_device_status"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
    	$scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/smd_device_status.js"></script>';
    	$content = $this->load->view("portal/smd_device_status", $data, TRUE);
    	 
    	$this->mp_master->Show_Portal($content, $scriptExtra, '查看采集单元状态', $data);
    }

    
    public function _get_device_category_name()
    {
        $devModelName = array();
        foreach(Constants::$devConfigList as $devConfig)
        {
            $devModelName[$devConfig[2]] = $devConfig[1];
        }
        return $devModelName;
    }
    
    public function _get_device_model_name()
    {
        $devModelGroup = array();
        foreach(Constants::$devConfigList as $devConfig)
        {
            foreach($devConfig[0] as $model)
            {
                $devModelGroup[$model] = $devConfig[1];
            }
        }
        $devModelGroup['venv'] = "机房环境";
        return $devModelGroup;
    }
    //警告管理
    public function alarm ()
    {
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['devModelGroup'] = $this->_get_device_modelGroup();        
        $data['devModelName'] = $this->_get_device_model_name();
        $data['devCategoryName'] = $this->_get_device_category_name();
        //面板下警告
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '告警管理';
        $bcObj->url = '/portal/alarm';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        switch ($level) {
            case 1:
                $bcObj->title = '一级告警';
                break;
            case 2:
                $bcObj->title = '二级告警';
                break;
            case 3:
                $bcObj->title = '三级告警';
                break;
            case 4:
                $bcObj->title = '四级告警';
                break;
            default:
                $bcObj->title = '所有告警';
                break;
        }
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $data['actTab'] = 'alarm';        
        
        //cityCode
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        //countyCode
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        //局站
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        //机房
        $data['roomId'] = $roomId = $this->input->get('selRoom');
        //警告级别
        $data['level'] = $level = $this->input->get('level');
        //设备类型
        $data['selDevModel'] = $selDevModel = trim($this->input->get('selDevModel'));
        
        $data['statusArr'] = $statusArr = $this->input->get('selStatus[]');
        if($statusArr == false)
        {
            $data['statusArr'] = $statusArr = array('unresolved','solved');
        }
        //信号名称
        $data['selSignalName'] = $selSignalName = $this->input->get('selSignalName');
        //关键字
        $data['word'] = $word = trim($this->input->get('word'));
        $signalNameList = array();
        foreach(Defines::$signalName as $key=>$codeName)
        {
            foreach($codeName as $code=>$name)
            {
		if(!in_array($name, $signalNameList))
                	$signalNameList[] = $name;
            }
        }
        $data['signalNameList'] = $signalNameList;
        
        $devModelArray = array();
        if(!empty($selDevModel))
        {
            foreach(Constants::$devConfigList as $devConfig)
            {
                if($devConfig[2] == $selDevModel)
                {
                    $devModelArray = $devConfig[0];
                }
            }            
        }
        $userLevel = 3;
        $substationIdArray = array();
        if($this->userObj->user_role == "admin")
        {
            $userLevel = 1;
        }else if($this->userObj->user_role == "city_admin")
        {
            $userLevel = 2;
            $cityCode = $this->userObj->city_code;
        }else{
            $cityCode = $this->userObj->city_code;
            $userPrivilegeObj = User::Get_UserPrivilege($this->userObj->id);
            if(count($userPrivilegeObj))
            {
                $substationIdArray = json_decode($userPrivilegeObj->area_privilege);
            }
        }
        //intval 转换成整形
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        //获取日期
        $data['reportDate'] = $reportDate = $this->input->get('reportDate');
        //explode('分割付','字符串')把字符串分割为数组
        //在至处分割数组
        $reportDateArr = explode('至', $reportDate);
        //两个日期  前后
        //--------------------------------------------------------------------------------------------------------------------------------------------------
        if (! (count($reportDateArr) == 2 && Util::Is_date($reportDateArr[0]) && Util::Is_date($reportDateArr[1]))) {
            $reportDateArr = array();
            //上个月
            $lastMonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d") - 1, date("Y")));
            array_push($reportDateArr, $lastMonth);
            //本月
            array_push($reportDateArr, date('Y-m-d'));
            //到目前一个月
            $data['reportDate'] = $lastMonth . '至' . date('Y-m-d');
        }
        
        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        
        	$record_offset = 0;
        	$PAGE_SIZE = 2000;
        	$xls = new Excel_XML('UTF-8', false, '告警列表');
        	$xls->addRow(array("分公司","区域","局站","机房","设备类型","设备名称","信号名称","信号ID","级别","描述","上报时间","恢复时间","确认时间","当前状态"));
        	while(true)
        	{
            	$alarmList = $this->mp_xjdh->Get_AlarmList($cityCode, $countyCode, $substationId, $roomId, $devModelArray, $level, 
                    															$statusArr, $reportDateArr[0], $reportDateArr[1], $word, $selSignalName, 
                                                                                $userLevel, $substationIdArray, $record_offset, $PAGE_SIZE);
            	foreach($alarmList as $alarmObj)
            	{
            		if ($alarmObj->status == 'unresolved') $alarmObj->status = '正在告警';
            		else if ($alarmObj->confirm_datetime != '0000-00-00 00:00:00') $alarmObj->status = '已确认';
            		else if ($alarmObj->status == 'solved') $alarmObj->status = '已恢复';
            		
            		$xls->addRow(array(
            				Defines::$gCity[$alarmObj->city_code], Defines::$gCounty[$alarmObj->city_code][$alarmObj->county_code],$alarmObj->substation_name,$alarmObj->room_name,
            				$data['devModelName'][$alarmObj->dev_model],$alarmObj->dev_name,$alarmObj->signal_name,$alarmObj->signal_id,
            				$alarmObj->level,$alarmObj->subject,$alarmObj->added_datetime,$alarmObj->restore_datetime,
            				$alarmObj->confirm_datetime,$alarmObj->status));
            	}
            	if(count($alarmList) < 2000)
            	    break;
            	$record_offset += 2000;
        	}
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="告警列表.xls"');
        	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        	header('Expires:0');
        	header('Pragma:public');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('告警列表');
        	return;
        }


       
        if ($countyCode)
            $data['substationList'] = $this->mp_xjdh->Get_Substations(false, $countyCode);
        if ($substationId)
            $data['roomList'] = $this->mp_xjdh->Get_Rooms(false, $substationId);

        $data['alarmCount'] = $this->mp_xjdh->Get_AlarmCount($cityCode, $countyCode, $substationId, $roomId, $devModelArray, $level, 
                															$statusArr, $reportDateArr[0], $reportDateArr[1], $word, $selSignalName, 
                                                                            $userLevel, $substationIdArray);        
       	$data['alarmList'] = $this->mp_xjdh->Get_AlarmList($cityCode, $countyCode, $substationId, $roomId, $devModelArray, $level, 
                															$statusArr, $reportDateArr[0], $reportDateArr[1], $word, $selSignalName, 
                                                                            $userLevel, $substationIdArray, $offset, DEFAULT_PAGE_SIZE);               
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/alarm"), $data['alarmCount'], DEFAULT_PAGE_SIZE, 3, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/alarm.js"></script>';
        $content = $this->load->view("portal/alarm", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
    }
    
    public function takealarm ()
    {
    	$data = array();
    	$data['userObj'] = $this->userObj;
    	$data['devModelGroup'] = $this->_get_device_modelGroup();
    	$data['devModelName'] = $this->_get_device_model_name();
    	$data['devCategoryName'] = $this->_get_device_category_name();
    	$data['actTab'] = 'alarm';
    	$data['selCounty'] = $selCounty = trim($this->input->get('selCounty'));
    	$data['selCity'] = $selCity = trim($this->input->get('selCity'));
    	//局站
    	$data['substationId'] = $substationId = trim($this->input->get('selSubstation'));
    	//机房
    	$data['roomId'] = $roomId = trim($this->input->get('selRoom'));
    	//警告级别
    	$data['level'] = $level = trim($this->input->get('level'));
    	//设备类型
        $data['selDevModel'] = $selDevModel = trim($this->input->get('selDevModel'));
    	$data['status'] = $status = $this->input->get('selStatus');
        
    	$data['getsignalName'] = $getsignalName = trim($this->input->get('selSignalName'));
    	//关键字
    	$data['word'] = $word = trim($this->input->get('word'));
    	//面板下警告
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '告警管理';
    	$bcObj->url = '/portal/alarm';
    	array_push($data['bcList'], $bcObj);
    	
    	$devModelArray = array();
    	if(!empty($selDevModel))
    	{
    		foreach(Constants::$devConfigList as $devConfig)
    		{
    			if($devConfig[2] == $selDevModel)
    			{
    				$devModelArray = $devConfig[0];
    			}
    		}
    	}
    	$bcObj = new Breadcrumb();
    	switch ($level) {
    		case 1:
    			$bcObj->title = '一级告警';
    			break;
    		case 2:
    			$bcObj->title = '二级告警';
    			break;
    		case 3:
    			$bcObj->title = '三级告警';
    			break;
    		case 4:
    			$bcObj->title = '四级告警';
    			break;
    		default:
    			$bcObj->title = '所有告警';
    			break;
    	}
    	$bcObj->title = '预告警';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);
    	
    	$signalNameList = array();
    	foreach(Defines::$signalName as $key=>$codeName)
    	{
    		foreach($codeName as $code=>$name)
    		{
    			if(!in_array($name, $signalNameList))
    				$signalNameList[] = $name;
    		}
    	}
    	$data['signalNameList'] = $signalNameList;
    	
    	$export = $this->input->get('export');
    	if($export == "exporttoexcel")
    	{
    		require 'resources/php-excel.class.php';
    	
    		$record_offset = 0;
    		$PAGE_SIZE=2000;
    		$xls = new Excel_XML('UTF-8', false, '告警列表');
    		$xls->addRow(array("分公司","区域","设备类型","设备名称","信号名称","信号ID","级别","描述","上报时间","当前状态","确认时间"));
    		$data['alarmList'] = $this->mp_xjdh->Get_takeAlarmList($selCity, $selCounty, $substationId, $roomId, $devModelArray, $level,
    			$reportDateArr[0], $reportDateArr[1], $word, false, false, $lastId,$status,$getsignalName);
    		foreach($data['alarmList'] as $alarmObj)
    		{
    			if (array_key_exists($alarmObj->dev_model, Defines::$gDevModel)) {
    				$alarmObj->dev_model = Defines::$gDevModel[$alarmObj->dev_model];} else {$alarmObj->dev_model = '其他类型设备';}
    			if ($alarmObj->status == 'unresolved')  $alarmObj->status = '未处理';
    			else if ($alarmObj->status == 'sloving')$alarmObj->status = '处理中';
    			else if ($alarmObj->status == 'sloved') $alarmObj->status = '已处理';
    			$xls->addRow(array(
    					Defines::$gCity[$alarmObj->city_code], Defines::$gCounty[$alarmObj->city_code][$alarmObj->county_code],$alarmObj->dev_model,$alarmObj->dev_name,$alarmObj->signal_name,$alarmObj->signal_id,
    					$alarmObj->level,$alarmObj->subject,$alarmObj->added_datetime,$alarmObj->status,$alarmObj->confirm_datetime
    			));
    		}
    	
    		header('Content-Type: application/vnd.ms-excel');
    		header('Content-Disposition: attachment;filename="告警列表.xls"');
    		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    		header('Expires:0');
    		header('Pragma:public');
    		header('Cache-Control: max-age=1');
    		$xls->generateXML('告警列表');
    		return;
    	}
    
    	//intval 转换成整形
    	$data['offset'] = $offset = intval($this->input->get('per_page'));
    	//获取日期
    	$data['reportdate'] = $reportDate = $this->input->get('reportdate');
    	//explode('分割付','字符串')把字符串分割为数组
    	//在至处分割数组
    	$reportDateArr = explode('至', $reportDate);
    	// util::is_date ------ util_helper.php/is_date
    	//两个日期  前后
    	//--------------------------------------------------------------------------------------------------------------------------------------------------
    	if (! (count($reportDateArr) == 2 && Util::Is_date($reportDateArr[0]) && Util::Is_date($reportDateArr[0]))) {
    		$reportDateArr = array();
    		//上个月
    		$lastMonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d") - 1, date("Y")));
    		array_push($reportDateArr, $lastMonth);
    		//本月
    		array_push($reportDateArr, date('Y-m-d'));
    		//到目前一个月
    		$data['reportdate'] = $lastMonth . '至' . date('Y-m-d');
    	}
    	$data['signalName'] = $this->mp_xjdh->Get_signalName();
    	if ($selCounty)
    		$data['substationList'] = $this->mp_xjdh->Get_Substations(false, $selCounty);
    	if ($substationId)
    		$data['roomList'] = $this->mp_xjdh->Get_Rooms(false, $substationId);
    	$data['alarmCount'] = $count = $this->mp_xjdh->Get_takeAlarmCount($selCity, $selCounty, $substationId, $roomId, $devModelArray, $level,
    		 $reportDateArr[0], $reportDateArr[1], $word, $lastId,$status ,$getsignalName);
    	$state= $this->input->get('state');
    	$data['alarmList'] = $this->mp_xjdh->Get_takeAlarmList($selCity, $selCounty, $substationId, $roomId, $devModelArray, $level,
    			$reportDateArr[0], $reportDateArr[1], $word, $offset, DEFAULT_PAGE_SIZE, $lastId,$status,$getsignalName);
    	//所有警告（警告数）
    	$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/takealarm"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
    	$scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
    	$scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/takealarm.js"></script>';	
    	$content = $this->load->view("portal/takealarm", $data, TRUE);
    	$this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
    }
    public function alarmsetting ()
    {
        $data = array();
        $data['actTab'] = 'alarm';
        $scriptExtra = '';
        $content = $this->load->view("portal/index", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
    }

    function export ()
    {
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'charts';
        $data['pageTitle'] = '报表导出';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '统计报表';
        $bcObj->url = '/portal/charts';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $data['pageTitle'];
        $bcObj->url = '#';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $data['cityCode'] = $cityCode = $this->input->get('selCity', 0);
        $data['countyCode'] = $countyCode = $this->input->get('selCounty', 0);
        $data['substationId'] = $substationId = $this->input->get('selSubstation', 0);
        
        $data['type'] = $type = $this->input->get('type', false);
        $data['timeType'] = $timeType = $this->input->get('time');
        $isExport = $this->input->get('isExport');
        
        $content = "";
        if ($type && $timeType) {
            $excel_template = 'excel_templates/alarm_' . $type . '-template.xls';
            require_once 'phpexcel/PHPExcel.php';
            include 'PHPExcel/Writer/Excel2007.php';
            
            $objPHPExcel = PHPExcel_IOFactory::createReader("Excel5")->load($excel_template);
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objActSheet = $objPHPExcel->getActiveSheet();
            
            $startDatetime = '';
            $endDatetime = '';
            $title = '';
            $a2Name = '';
            $date = $this->input->get('txtDate');
            if ($timeType == 'day') {
                $startDatetime = $endDatetime = $date;
                $dateStr = date('y年m月d日', strtotime($date));
                $title = '（' . $dateStr . '）';
                switch ($type) {
                    case 'device':
                        $title = '设备告警统计' . $title;
                        $objActSheet->mergeCells("A1:M1");
                        $a2Name = '告警设备名称';
                        break;
                    case 'env':
                        $title = '环境量告警统计' . $title;
                        $objActSheet->mergeCells("A1:H1");
                        $a2Name = '环境量名称';
                        break;
                    case 'level':
                        $title = '按告警级别统计' . $title;
                        $a2Name = '告警级别名称';
                        $objActSheet->mergeCells("A1:G1");
                        break;
                }
            } else {
                $startDatetime = $endDatetime = $date . '-01';
                //分割日期
                $dateArr = explode('-', $date);
                $title = '（' . $dateArr[0] . '年' . $dateArr[1] . '月）';
                //一月总天数
                $daysOfMonth = Util::get_day($dateArr[1], $dateArr[0]);
                //合并单元格
                $objActSheet->mergeCells("A1:" . $this->_get_col_letter($daysOfMonth + 2) . "1");
                switch ($type) {
                    case 'device':
                        $title = '设备月度告警统计' . $title;
                        $a2Name = '告警设备名称';
                        break;
                    case 'env':
                        $title = '环境量月度告警统计' . $title;
                        $a2Name = '环境量名称';
                        break;
                    case 'summary':
                        $title = '告警总量月度汇总表' . $title;
                        $a2Name = '告警类型\日期';
                        break;
                }
                
                for ($i = 1; $i <= $daysOfMonth; $i ++) {
                    $objActSheet->setCellValue($this->_get_col_letter($i + 1) . '2', $i);
                }
                $objActSheet->setCellValue($this->_get_col_letter($i + 1) . '2', '合计');
            }
            $row = 3;
            if ($substationId != 0) {
                $substationObj = $this->mp_xjdh->Get_Substation($substationId);
                $areaName = trim($substationObj->city) . '->' . trim($substationObj->county) . '->' . trim($substationObj->name) . '局站';
                $a2Name = '机房名称（分局）\\' . $a2Name;
                if ($type == 'summary' && $timeType = 'month') {
                    $this->_set_summary_sheet($objActSheet, false, false, $substationId, $date);
                } else {
                    $roomList = $this->mp_xjdh->Get_Rooms(0, $substationId);
                    foreach ($roomList as $roomObj) {
                        if ($type == 'device') {
                            $this->_set_dev_sheet($objActSheet, $roomObj->name, $row, false, false, $substation_id, $roomObj->id, Defines::$gDevModelKeys, 
                                    $timeType, $startDatetime, $endDatetime);
                        } elseif ($type == 'env') {
                            $this->_set_dev_sheet($objActSheet, $roomObj->name, $row, false, false, $substation_id, $roomObj->id, Defines::$gEnvModelKeys, 
                                    $timeType, $startDatetime, $endDatetime);
                        } elseif ($type == 'level') {
                            $this->_set_level_sheet($objActSheet, $roomObj->name, $row, false, false, $substation_id, $roomObj->id, $startDatetime, 
                                    $endDatetime);
                        }
                        $row ++;
                    }
                }
            } elseif ($countyCode != 0) {
                $a2Name = '县局（分局）\\' . $a2Name;
                foreach (Defines::$gCounty as $citykey => $countyList) {
                    if (array_key_exists($countyCode, $countyList)) {
                        $areaName = trim(Defines::$gCity[$citykey]) . '->' . trim($countyList[$countyCode]) . '县局';
                        break;
                    }
                }
                if ($type == 'summary' && $timeType = 'month') {
                    $this->_set_summary_sheet($objActSheet, false, $countyCode, false, $date);
                } else {
                    $substationList = $this->mp_xjdh->Get_Substations(0, $countyCode);
                    foreach ($substationList as $substationObj) {
                        if ($type == 'device') {
                            $this->_set_dev_sheet($objActSheet, $substationObj->name, $row, false, $countyCode, $substationObj->id, false, 
                                    Defines::$gDevModelKeys, $timeType, $startDatetime, $endDatetime);
                        } elseif ($type == 'env') {
                            $this->_set_dev_sheet($objActSheet, $substationObj->name, $row, false, $countyCode, $substationObj->id, false, 
                                    Defines::$gEnvModelKeys, $timeType, $startDatetime, $endDatetime);
                        } elseif ($type == 'level') {
                            $this->_set_level_sheet($objActSheet, $substationObj->name, $row, false, $countyCode, $substationObj->id, false, $startDatetime, 
                                    $endDatetime);
                        }
                        $row ++;
                    }
                }
            } elseif ($cityCode != 0) {
                $a2Name = '县局（分局）\\' . $a2Name;
                $areaName = trim(Defines::$gCity[$cityCode]) . '分公司';
                if ($type == 'summary' && $timeType = 'month') {
                    $this->_set_summary_sheet($objActSheet, $cityCode, false, false, $date);
                } else {
                    $countyList = $this->mp_xjdh->Get_CountyList($cityCode);
                    foreach ($countyList as $countyObj) {
                        if ($type == 'device') {
                            $this->_set_dev_sheet($objActSheet, $countyObj->county, $row, $cityCode, $countyObj->county_code, false, false, 
                                    Defines::$gDevModelKeys, $timeType, $startDatetime, $endDatetime);
                        } elseif ($type == 'env') {
                            $this->_set_dev_sheet($objActSheet, $countyObj->county, $row, $cityCode, $countyObj->county_code, false, false, 
                                    Defines::$gEnvModelKeys, $timeType, $startDatetime, $endDatetime);
                        } elseif ($type == 'level') {
                            $this->_set_level_sheet($objActSheet, $countyObj->county, $row, $cityCode, $countyObj->county_code, false, false, $startDatetime, 
                                    $endDatetime);
                        }
                        $row ++;
                    }
                }
            } else {
                $a2Name = '局站名称（分局）\\' . $a2Name;
                $areaName = '全区各本地网';
                if ($type == 'summary' && $timeType = 'month') {
                    $this->_set_summary_sheet($objActSheet, false, false, false, $date);
                } else {
                    $cityList = $this->mp_xjdh->Get_CityList();
                    foreach ($cityList as $cityObj) {
                        if ($type == 'device') {
                            $this->_set_dev_sheet($objActSheet, $cityObj->city, $row, $cityObj->city_code, false, false, false, Defines::$gDevModelKeys, 
                                    $timeType, $startDatetime, $endDatetime);
                        } elseif ($type == 'env') {
                            $this->_set_dev_sheet($objActSheet, $cityObj->city, $row, $cityObj->city_code, false, false, false, Defines::$gEnvModelKeys, 
                                    $timeType, $startDatetime, $endDatetime);
                        } elseif ($type == 'level') {
                            $this->_set_level_sheet($objActSheet, $cityObj->city, $row, $cityObj->city_code, false, false, false, $startDatetime, $endDatetime);
                        }
                        $row ++;
                    }
                }
            }
            $title = $areaName . $title;
            $objActSheet->setCellValue('A1', $title);
            $objActSheet->setCellValue('A2', $a2Name);
            if ($isExport) {
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename=' . $title . '.xls');
                header('Cache-Control: max-age=0');
                header('Cache-Control: max-age=1');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
                header('Cache-Control: cache, must-revalidate');
                header('Pragma: public');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
            } else {
                $highestRow = $row - 1;
                $highestColumn = $objActSheet->getHighestColumn();
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // 总列数
                echo '<!DOCTYPE HTML>
                <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <link href="/public/css/bootstrap.css" rel="stylesheet">
                </head>
                <body style="margin:10px;">
                        <p class="text-center">
                            <h3>' . $title . '</h3>
                            <a href="' . $_SERVER['REQUEST_URI'] . '&isExport=true" class="btn-primary btn">导出到Excel</a>
                            <button onclick="window.close()" class="btn-info btn">关闭</button>
                        </p>
                <table class = "table table-bordered responsive table-striped table-sortable">
                <tbody>';
                for ($row = 2; $row <= $highestRow; $row ++) {
                    echo '<tr>';
                    for ($col = 0; $col < $highestColumnIndex; $col ++) {
                        $value = $objActSheet->getCellByColumnAndRow($col, $row)->getValue();
                        echo '<td>' . $value . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</tbody>
                </table>
                </body>
                </html>';
                return;
            }
        } else {
            $content = $this->load->view("portal/export", $data, TRUE);
        }
        $scriptExtra = '<script type="text/javascript" src="/public/portal/js/export.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, $data['pageTitle'], $data);
    }

    public function charts ()
    {
    	$data = array();
    	$data['userObj'] = $this->userObj;
    	$data['actTab'] = 'charts';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '统计报表';
    	$bcObj->url = '/portal/charts';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '报表查询';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);
    	
        if ($_SESSION['XJTELEDH_USERROLE'] == 'admin') {
            $data['cityCode'] = $cityCode = trim($this->input->get('selCity'));
            $data['countyCode'] = $countyCode = trim($this->input->get('selCounty'));
        } elseif ($_SESSION['XJTELEDH_USERROLE'] == 'noc') {
            $data['cityCode'] = $cityCode = trim($this->input->get('selCity'));
            $data['countyCode'] = $countyCode = trim($this->input->get('selCounty'));
            if (! $cityCode) {
                $cityList = json_decode($_SESSION['CITYLIST'], TRUE);
                //创建包含citylist新数组
                $cityCode = array_keys($cityList);
                if (! $countyCode) {
                    $countyList = json_decode($_SESSION['COUNTYLIST'], TRUE);
                    $countyCode = array();
                    foreach ($countyList as $cityKey => $countyValList) {
                    	//合并shuzu
                        $countyCode = array_merge($countyCode, array_keys($countyValList));
                    }
                }
            }
        } elseif ($_SESSION['XJTELEDH_USERROLE'] == 'city_admin') {
            $areaPrivilegeArr = json_decode($_SESSION['XJTELEDH_AREA_PRIVILEGE'], TRUE);
            $data['cityCode'] = $cityCode = $areaPrivilegeArr[0];
            $data['countyCode'] = $countyCode = trim($this->input->get('selCounty'));
        } else {
            $cityList = json_decode($_SESSION['CITYLIST'], TRUE);
            $keyArr = array_keys($cityList);
            $data['cityCode'] = $cityCode = $keyArr[0];
            $data['countyCode'] = $countyCode = trim($this->input->get('selCounty'));
            if (! $countyCode) {
                $countyList = json_decode($_SESSION['COUNTYLIST'], TRUE);
                $countyCode = array();
                foreach ($countyList as $cityKey => $countyValList) {
                    $countyCode = array_merge($countyCode, array_keys($countyValList));
                }
            }
        }
        $data['selSubstation'] = $selSubstation = $this->input->get('selSubstation');
        $data['selRoom'] = $selRoom = $this->input->get('selRoom');
        $data['type'] = $type = $this->input->get('rdType');
        //$data['bcList'] = array();
        //$bcObj = new Breadcrumb();
        //$bcObj->title = '全网';
        //if ($cityCode == FALSE) {
        //   $bcObj->isLast = true;
        //} else {
         //   $bcObj->url = '/portal/charts';
       // }
        if ($countyCode)
            $data['substationList'] = $this->mp_xjdh->Get_Substations(false, $countyCode);
        if ($selSubstation)
            $data['roomList'] = $this->mp_xjdh->Get_Rooms(false, $selSubstation);
        $startDatetime = $this->input->get('datestart');
        $endDatetime = $this->input->get('dateend');
        $startDatetime = $startDatetime ? $startDatetime : date('Y-01-01');
        $endDatetime = $endDatetime ? $endDatetime : date('Y-m-d');
        $data['service'] = $this->input->get('service');
        $data['roomtype'] = $this->input->get('selRoomType');
        //array_push($data['bcList'], $bcObj);
        //检测citycode是否存在  defines_helper.php/$gcity  
        //static $gCity = array("991" => "乌鲁木齐","990" => "克拉玛依","992" => "奎屯","903" => "和田","995" => "吐鲁番","902" => "哈密","994" => "昌吉",
        //"909" => "博州","996" => "巴州", "997" => "阿克苏","908" => "克州","999" => "伊犁","901" => "塔城","906" => "阿勒泰","993" => "石河子","998" => "喀什");
        if (array_key_exists($cityCode, Defines::$gCity)) {
            $bcObj = new Breadcrumb();
            //面板标题
            $bcObj->title = Defines::$gCity[$cityCode];
            if (array_key_exists($cityCode, Defines::$gCounty)) {
                $data['countyList'] = Defines::$gCounty[$cityCode];
            }
            if (array_key_exists($cityCode, Defines::$gCounty) && strlen($cityCode) < strlen($countyCode) &&
                     substr($countyCode, 0, strlen($cityCode)) == $cityCode &&
                     array_key_exists(substr($countyCode, strlen($cityCode) - 1), Defines::$gCounty[$cityCode])) {
                $bcObj->url = '/portal/charts?selCity=' . $cityCode;
                array_push($data['bcList'], $bcObj);
                $bcObj = new Breadcrumb();
                $bcObj->title = Defines::$gCounty[$cityCode][substr($countyCode, strlen($cityCode) - 1)];
                $bcObj->isLast = true;
                array_push($data['bcList'], $bcObj);
            } else {
                $bcObj->isLast = true;
                array_push($data['bcList'], $bcObj);
            }
        }
        if ($type == 'alarm') {
            if ($selRoom) {
                $data['columnName'] = '设备类型';
                $modelList = array();
                foreach (Defines::$gDevModel as $key => $val) {
                    $modelObj = new stdClass();
                    $modelObj->name = $val;
                    $result = $this->mp_xjdh->Get_AlarmCountGroupByLevel($cityCode, $countyCode, $selSubstation, $selRoom, $val, array(), $startDatetime, 
                            $endDatetime);
                    foreach ($result as $rObj) {
                        $modelObj->{'level' . $rObj->level} = $rObj->count;
                    }
                    array_push($modelList, $modelObj);
                }
                $data['alarmList'] = $modelList;
            } elseif ($selSubstation) {
                $data['columnName'] = '机房';
                $roomList = $this->mp_xjdh->Get_Rooms(false, $selSubstation);
                foreach ($roomList as $roomObj) {
                    $result = $this->mp_xjdh->Get_AlarmCountGroupByLevel($cityCode, $countyCode, $selSubstation, $roomObj->id, false, array(), $startDatetime, 
                            $endDatetime);
                    foreach ($result as $rObj) {
                        $roomObj->{'level' . $rObj->level} = $rObj->count;
                    }
                }
                $data['alarmList'] = $roomList;
            } elseif ($countyCode && ! is_array($countyCode)) {
                $data['columnName'] = '局站';
                $substationList = $this->mp_xjdh->Get_Substations(false, $countyCode);
                foreach ($substationList as $substationObj) {
                    $result = $this->mp_xjdh->Get_AlarmCountGroupByLevel($cityCode, $countyCode, $substationObj->id, false, false, array(), $startDatetime, 
                            $endDatetime);
                    foreach ($result as $rObj) {
                        $substationObj->{'level' . $rObj->level} = $rObj->count;
                    }
                }
                $data['alarmList'] = $substationList;
            } elseif ($cityCode) {
                $data['columnName'] = '分局';
                $countyList = array();
                foreach (Defines::$gCounty[$cityCode] as $key => $val) {
                    $countyObj = new stdClass();
                    $countyObj->name = $val;
                    $result = $this->mp_xjdh->Get_AlarmCountGroupByLevel($cityCode, $key, false, false, false, array(), $startDatetime, $endDatetime);
                    foreach ($result as $rObj) {
                        $countyObj->{'level' . $rObj->level} = $rObj->count;
                    }
                    array_push($countyList, $countyObj);
                }
                $data['alarmList'] = $countyList;
            } else {
                $data['columnName'] = '分公司';
                $cityList = array();
                foreach (Defines::$gCity as $key => $val) {
                    $cityObj = new stdClass();
                    $cityObj->name = $val;
                    $result = $this->mp_xjdh->Get_AlarmCountGroupByLevel($key, false, false, false, false, array(), $startDatetime, $endDatetime);
                    foreach ($result as $rObj) {
                        $cityObj->{'level' . $rObj->level} = $rObj->count;
                    }
                    array_push($cityList, $cityObj);
                }
                $data['alarmList'] = $cityList;
            }
            
            foreach ($data['alarmList'] as $obj) {
                if (! isset($obj->level1))
                    $obj->level1 = 0;
                if (! isset($obj->level2))
                    $obj->level2 = 0;
                if (! isset($obj->level3))
                    $obj->level3 = 0;
                if (! isset($obj->level4))
                    $obj->level4 = 0;
            }
            $data['chartTitle'] = '告警';
        } elseif ($type == 'energy') {
            $data['chartTitle'] = '能耗';
            if ($selSubstation) {
                $data['columnName'] = '机房';
                $roomList = $this->mp_xjdh->Get_Rooms(false, $selSubstation);
                foreach ($roomList as $roomObj) {
                    $imemList = $this->mp_xjdh->Get_Imem12List($cityCode, $countyCode, $selSubstation, $roomObj->code);
                    $energy = 0;
                    foreach ($imemList as $imemObj) {
                        $wObj = $this->mp_xjdh->Count_Imem12History($imemObj->data_id, $startDatetime, $endDatetime);
                        $energy += (floatval($wObj->w1max) + floatval($wObj->w2max) + floatval($wObj->w3max) + floatval($wObj->w4max)) -
                                 (floatval($wObj->w1min) + floatval($wObj->w2min) + floatval($wObj->w3min) + floatval($wObj->w4min));
                    }
                    $roomObj->energy = number_format($energy, 2, '.', '');
                }
                $data['energyList'] = $roomList;
            } elseif ($countyCode && ! is_array($countyCode)) {
                $data['columnName'] = '局站';
                $substationList = $this->mp_xjdh->Get_Substations(false, $countyCode);
                foreach ($substationList as $substationObj) {
                    $imemList = $this->mp_xjdh->Get_Imem12List($cityCode, $countyCode, $substationObj->id);
                    $energy = 0;
                    foreach ($imemList as $imemObj) {
                        $wObj = $this->mp_xjdh->Count_Imem12History($imemObj->data_id, $startDatetime, $endDatetime);
                        $energy += (floatval($wObj->w1max) + floatval($wObj->w2max) + floatval($wObj->w3max) + floatval($wObj->w4max)) -
                                 (floatval($wObj->w1min) + floatval($wObj->w2min) + floatval($wObj->w3min) + floatval($wObj->w4min));
                    }
                    $substationObj->energy = number_format($energy, 2, '.', '');
                }
                $data['energyList'] = $substationList;
            } elseif ($cityCode) {
                $data['columnName'] = '分局';
                $countyList = array();
                foreach (Defines::$gCounty[$cityCode] as $key => $val) {
                    $countyObj = new stdClass();
                    $countyObj->name = $val;
                    $imemList = $this->mp_xjdh->Get_Imem12List($cityCode, $key);
                    $energy = 0;
                    foreach ($imemList as $imemObj) {
                        $wObj = $this->mp_xjdh->Count_Imem12History($imemObj->data_id, $startDatetime, $endDatetime);
                        $energy += (floatval($wObj->w1max) + floatval($wObj->w2max) + floatval($wObj->w3max) + floatval($wObj->w4max)) -
                                 (floatval($wObj->w1min) + floatval($wObj->w2min) + floatval($wObj->w3min) + floatval($wObj->w4min));
                    }
                    $countyObj->energy = number_format($energy, 2, '.', '');
                    array_push($countyList, $countyObj);
                }
                $data['energyList'] = $countyList;
            } else {
                $data['columnName'] = '分公司';
                $cityList = array();
                foreach (Defines::$gCity as $key => $val) {
                    $cityObj = new stdClass();
                    $cityObj->name = $val;
                    $imemList = $this->mp_xjdh->Get_Imem12List($key);
                    $energy = 0;
                    foreach ($imemList as $imemObj) {
                        $wObj = $this->mp_xjdh->Count_Imem12History($imemObj->data_id, $startDatetime, $endDatetime);
                        $energy += (floatval($wObj->w1max) + floatval($wObj->w2max) + floatval($wObj->w3max) + floatval($wObj->w4max)) -
                                 (floatval($wObj->w1min) + floatval($wObj->w2min) + floatval($wObj->w3min) + floatval($wObj->w4min));
                    }
                    $cityObj->energy = number_format($energy, 2, '.', '');
                    array_push($cityList, $cityObj);
                }
                $data['energyList'] = $cityList;
            }
        }
        $data['datestart'] = $startDatetime;
        $data['dateend'] = $endDatetime;
        
        $scriptExtra = '<script type="text/javascript" src="/public/js/highcharts/highcharts.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/charts.js"></script>';
        $content = $this->load->view("portal/charts", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
    }

    function refreshData ()
    {
        $jsonRet = array();
        $model = trim($this->input->get('model'));

        if($model == "door")
        {
            $doorArray = array();
            $CI = & get_instance();
            $CI->load->driver('cache');
            $dataId = $this->input->get('dataIdArr');
            $dataIdArr = explode(",", $dataId);
            foreach($dataIdArr as $dataId)
            {
                $device = new stdClass();
                $device->data_id = $dataId;
                $memData = $CI->cache->get($dataId); 
                $v = unpack('C*', substr($memData, 4, 2));
                $device->door1 = $v[1];
                $device->door2 = $v[2];
                array_push($doorArray,$device);
            }
            $jsonRet['doorList'] = $doorArray;
        }else if($model == "pdu")
    	{
    		$pduArray = array();
            $CI = & get_instance();
            $CI->load->driver('cache');
            $dataId = $this->input->get('dataIdArrVpdu');
            $dataIdArr = explode(",", $dataId);
    		foreach($dataIdArr as $dId)
            {
                    $device = new stdClass();
                    $device->data_id = $dId;
                    $memData = $CI->cache->get($dId."_dc");
                    $device->dynamic_config = $memData;
                    array_push($pduArray,$device);
            }
            $jsonRet['pduList'] = $pduArray;   
    
    	}else if($model == "smd_device")
    	{ 	
    		$deviceArray = array();
    		$CI = & get_instance();
    	    $CI->load->driver('cache');
            $dataId = $this->input->get('dataIdArr');
    		$dataIdArr = explode(",", $dataId);
    		foreach($dataIdArr as $dId)
    		{
    			$device = new stdClass();
    			$device->data_id = $dId;
    			$memData = $CI->cache->get($dId);
    			$device->status = ($memData != false);
    			array_push($deviceArray,$device);
    		}
    		$jsonRet['device'] = $deviceArray;
    	}else if($model == "pue")
        {
        	$dataId = $this->input->get('dataIdArr');
        	$jsonRet["value"] = Realtime::Get_PueData($dataId);
        }else if($model == "flunctuation")
        {
        	$dataId = $this->input->get('dataIdArr');
        	$jsonRet["value"] = Realtime::Get_FlunctuationData($dataId);
        }else if ($model == 'enviroment' || $model == 'ad' || $model == 'di') {
            $dataIdStr1 = $this->input->get('dataIdArr1');
            $jsonRet['aidiValue'] = Realtime::Get_AiDiRtData($dataIdStr1);
        } elseif ($model == 'powermeter') {
            $dataIdStr1 = $this->input->get('dataIdArr1');
            $jsonRet['imem12Value'] = Realtime::Get_Imem12RtData($dataIdStr1);
            $dataIdStr2 = $this->input->get('dataIdArr2');
            $jsonRet['power302aValue'] = Realtime::Get_Power302ARtData($dataIdStr2);
        }  elseif ($model == "engine"){
            $dataIdStr1 = $this->input->get('dataIdArr1');
            $jsonRet['mec10List'] = Realtime::Get_Mec10RtData($dataIdStr1);

        }  elseif ($model == 'battery' || $model == 'battery_32' || $model == 'bat') {
            $dataIdStr2 = $this->input->get('dataIdArr2');
            $dataIdStr3 = $this->input->get('dataIdArr3');
            $dataIdStr4 = $this->input->get('dataIdArr4');
            $batList = Realtime::Get_Battery4Voltage($dataIdStr2);
            $bat24List = Realtime::Get_BatRtData($dataIdStr3, 24);
            $bat32List = Realtime::Get_BatRtData($dataIdStr4, 32); 
            $jsonRet['batList'] = array_merge($batList, $bat24List, $bat32List);
            
        } elseif ($model == 'freshair') {
            $dataIdStr5 = $this->input->get('dataIdArr5');
            $jsonRet['freshAirList'] = Realtime::Get_FreshAirRtData($dataIdStr5);
        } elseif ($model == 'sps') {
            $dataIdStr6 = $this->input->get('dataIdArr6');
            $dataIdStr7 = $this->input->get('dataIdArr7');
            $dataIdStr8 = $this->input->get('dataIdArr8');
            $dataIdStr9 = $this->input->get('dataIdArr9');
            $dataIdStr10 = $this->input->get('dataIdArr10');
            $jsonRet['spsAcList'] = Realtime::Get_SwitchingPowerSupplyRtData($dataIdStr6);
            $jsonRet['spsRcList'] = Realtime::Get_SwitchingPowerSupplyRtData($dataIdStr7);
            $jsonRet['spsDcList'] = Realtime::Get_SwitchingPowerSupplyRtData($dataIdStr8);
            $jsonRet['dk04List'] = Realtime::Get_Dk04RtData($dataIdStr9);
            $jsonRet['psm06List'] = Realtime::Get_Psm06RtData($dataIdStr10);
        }elseif ($model == 'zxdu') {
        	$dataIdStr6 = $this->input->get('dataIdArr6');
        	$dataIdStr7 = $this->input->get('dataIdArr7');
        	$dataIdStr8 = $this->input->get('dataIdArr8');
        	$jsonRet['spsAcList'] = realtime::Get_zxduACcache($dataIdStr6);
        	$jsonRet['spsRcList'] = Realtime::Get_zxduRCcache($dataIdStr7);
        	$jsonRet['spsDcList'] = Realtime::Get_zxduDCcache($dataIdStr8);
        } 
        elseif ($model == 'liebert-ups') {
            $dataIdStr9 = $this->input->get('dataIdArr9');
            $jsonRet['libertUpsList'] = Realtime::Get_LiebertUpsRtData($dataIdStr9);  
        } elseif($model == 'ac'){//liebert-pex'){
        	$dataIdStr10 = $this->input->get('dataIdArr10');
        	$jsonRet['libertPexList'] = Realtime::Get_LiebertPexRtData($dataIdStr10);
        } elseif ($model == 'motor_battery') {
            $dataIdStr = $this->input->get('dataIdArr');
            $jsonRet['motorBatList'] = Realtime::Get_MotorBatRtData($dataIdStr);
        } elseif ($model == 'room') {
            $piKeyStr = $this->input->get('piKeyArr');
            $jsonRet['roomPiList'] = Realtime::Get_RoomPiData($piKeyStr);
        } elseif ($model == 'motor') {
            $dataIdStr1 = $this->input->get('dataIdArr1');
            $jsonRet['motorAccess4000xList'] = Realtime::Get_Access4000xRtData($dataIdStr1);
        } elseif ($model == 'aeg') {
            $dataIdStr1 = $this->input->get('dataIdArr1');
            $dataIdStr2 = $this->input->get('dataIdArr2');
            $jsonRet['aegMS10SEList'] = Realtime::Get_AegMS10SERtData($dataIdStr1);
            $jsonRet['aegMS10MList'] = Realtime::Get_AegMS10MRtData($dataIdStr2);
        } else if($model == "access4000x")
        {
        	$dataIdStr9 = $this->input->get('dataIdArr9');
        	$jsonRet['access4000xList'] = Realtime::Get_Access4000xRtData($dataIdStr9);
        } else if($model == "amf25")
        {
        	$dataIdStr9 = $this->input->get('dataIdArr9');
        	$jsonRet['amf25List'] = Realtime::Get_Amf25($dataIdStr9);
        }else if($model == "ug40")
        {
        	$dataIdStr9 = $this->input->get('dataIdArr9');
        	$jsonRet['ug40List'] = Realtime::Get_ug40RtData($dataIdStr9);
        }else if($model == "datamate3000")
        {
            $dataIdStr = $this->input->get('dataIdArr');
            $jsonRet['dataList'] = Realtime::Get_Datamate3000RtData($dataIdStr);
        }
        header('Content-type: application/json');
        echo json_encode($jsonRet);
        return;
    }
    
    function getchartsdata ()
    {
        $jsonRet = array();
        $chartObj = new stdClass();
        $cityCode = $this->input->get('citycode');
        $countyCode = $this->input->get('countycode');
        $startDatetime = $this->input->get('startdatetime');
        $endDatetime = $this->input->get('enddatetime');
        if (! $startDatetime) {
            $startDatetime = date('Y-m-1');
        }
        if (! $endDatetime) {
            $endDatetime = date('Y-m-d');
        }
        $chartObj->energy = array();
        $chartObj->alarm = array();
        if (! $cityCode) {
            $chartObj->title = '全网';
            $chartObj->categories = array_values(Defines::$gCity);
            foreach (Defines::$gCity as $key => $val) {
                $alarmCount = $this->mp_xjdh->Get_AlarmCount($key, false, false, false, false, false, array(), $startDatetime, $endDatetime);
                array_push($chartObj->alarm, $alarmCount);
            }
        } else 
            if (array_key_exists($cityCode, Defines::$gCity)) {
                if ($countyCode) {
                    $chartObj->title = Defines::$gCity[$cityCode] . '分公司 -- ' . Defines::$gCounty[$cityCode][$countyCode] . '分局';
                } else {
                    $chartObj->title = Defines::$gCity[$cityCode] . '本地网';
                    $chartObj->categories = array_values(Defines::$gCounty[$cityCode]);
                    if (array_key_exists($cityCode, Defines::$gCounty)) {
                        foreach (Defines::$gCounty[$cityCode] as $key => $val) {
                            $alarmCount = $this->mp_xjdh->Get_AlarmCount($cityCode, $key, false, false, false, false, array(), $startDatetime, $endDatetime);
                            array_push($chartObj->alarm, $alarmCount);
                        }
                    }
                }
            }
        $jsonRet['ret'] = 0;
        $jsonRet['data'] = $chartObj;
        echo json_encode($jsonRet);
        return;
    }

    function settings ()
    {
        $data = array();
        $data['actTab'] = 'settings';
        $scriptExtra = '';
        $content = $this->load->view("portal/index", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
    }

    function deviceInfo ()
    {
        $data = array();
        $data['actTab'] = 'settings';
        $data['bcList'] = array();
        $data_id = $this->input->get('data_id');
        $model = $this->input->get('model');
        if ($model == 'imem_12') {
            $imem_id = $this->input->get('imem_id');
        } else {}
        $scriptExtra = '';
        $content = $this->load->view("portal/index", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
    }

    function getdevdetail ()
    {
        $jsonRet = array();
        $data_id = $this->input->get('data_id');
        $model = $this->input->get('model');
        $data = array();
        $data['model'] = $model;
        if ($model == 'imem_12') {
            $id = $this->input->get('imem_id');
            $imemObj = $this->mp_xjdh->Get_Imem12Obj($id);
            if (count($imemObj)) {
                $jsonRet['ret'] = 0;
                $data['devObj'] = $imemObj;
                $jsonRet['html'] = $this->load->view('portal/dev-detail', $data, TRUE);
            }
        } elseif (in_array($model, 
                array('smoke','temperature','water','humid','battery_24','battery_32','motor_battery','psma-ac','psma-rc','psma-dc','liebert-ups','liebert-pex','aeg-ms10se','aeg-ms10m','fresh_air',
                        'm810g-ac','m810g-dc','m810g-rc','access4000x','ug40','power_302a','vpdu'))) {
            $devObj = $this->mp_xjdh->Get_RoomDevObj($data_id);
            if (count($devObj)) {
                $jsonRet['ret'] = 0;
                $data['devObj'] = $devObj;
                $jsonRet['html'] = $this->load->view('portal/dev-detail', $data, TRUE);
            }
        }
        if (! isset($jsonRet['ret'])) {
            $jsonRet['ret'] = 1;
        }
        echo json_encode($jsonRet);
        return;
    }

    function _get_array_code ($varArr)
    {
        //var_dump($varArr);
        if(!is_array($varArr))
        {
            return $varArr;
        }
        $tempArr = array();
        foreach ($varArr as $key => $value) {
            if (empty($value))
                continue;
            if (is_array($value)) {
                array_push($tempArr, '"' . $key . '"=>' . $this->_get_array_code($value));
            } else {
                array_push($tempArr, '"' . $key . '"=>"' . $value . '"');
            }
        }
        return "array(" . implode(",", $tempArr) . ")";
    }

    function basicdata ($categoryName = '')
    {
    	if(!in_array($this->userObj->user_role, array("admin","city_admin","operator")))
    		redirect("/");
    	//类别是否已经配置
        if (empty($categoryName)) {
            redirect("/");
        }
        //define_helper 没有设置
        if (! isset(Defines::$$categoryName)) {
            redirect("/");
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $keyArr = $this->input->post('txtKey');
            $valArr = $this->input->post('txtValue');
           // ------------------------------------------------------------------------------------------------------？？？？？？？？？？？？
            if (TRUE) {
                $ret = '';
                $content = "<?php\r\n" . "if (! defined('BASEPATH'))\r\n" . "exit('No direct script access allowed');\r\n" . "class Defines\r\n" . "{\r\n";
                
                $ref = new ReflectionClass(new Defines());
                foreach ($ref->getProperties() as $prop) {
                    $prop->setAccessible(true);
                    $name = $prop->getName();
                    $value = $prop->getValue();
                    if ($name == $categoryName) {
                        $tempArr = array();
                        for ($i = 0; $i < count($keyArr); $i ++) {
                            if (! empty($keyArr[$i]) && ! empty($valArr[$i])) {
                            	//查找 ， 在分局数组第一次出现的位置
                                if(in_array($categoryName, array("gCity","gDevModel")))
                                {
                                    array_push($tempArr, '"' . $keyArr[$i] . '"=>' . '"' . $valArr[$i].'"');
                                }else{
                                    $newValArr = explode(",", $valArr[$i]);
                                    //分局配置
                                    $keyValArr = array();
                                    foreach($newValArr as $newVal)
                                    {
                                        if(strpos($newVal, ' '))
                                        {
                                        	$keyVal = explode(" ", $newVal);
                                        	$keyValArr[$keyVal[0]] = $keyVal[1];
                                        }else{
                                        	array_push($keyValArr, $newVal);
                                       }
                                    }       
                                    array_push($tempArr, '"' . $keyArr[$i] . '"=>' . $this->_get_array_code($keyValArr));
                                 }
                                 
                                  
                            }
                        }
                        //在content后连接            implode将数组元素组合为字符串用，连接
                        $content .= "\tstatic $" . $categoryName . " = array(" . implode(",", $tempArr) . ");\r\n";
                    } else {
                        $content .= "\tstatic $" . $name . " = " . $this->_get_array_code($value) . ";\r\n";
                    }
                }
                $content .= "}";
                //保存   content写入----
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/application/helpers/' . 'defines_helper.php', $content);
                $data['msg'] = '保存/修改成功';
            } else {
                $data['errMsg'] = '验证出错：' . validation_errors();
            }
	    return redirect('/portal/basicdata/'.$categoryName);
        }
        //$this->load->helper('defines');
        $data['category'] = Defines::$$categoryName;
        switch ($categoryName) {
            case 'gUserAuth':
                $data['categoryKey'] = "权限名称配置";
                break;
            case 'gCity':
                $data['categoryKey'] = '分公司配置';
                break;
		    case 'gBrand':
				$data['categoryKey'] = '厂家品牌配置';
				break;
            case 'gCounty':
                $data['categoryKey'] = '区域配置';
                break;
            case 'gStation':
                $data['categoryKey'] = '局站配置';
                break;
            case 'signalName':
                $data['categoryKey'] = "信号名称配置";
                break;
            default:
                $data['categoryKey'] = $categoryName;
                break;
        }
        $data['actTab'] = 'settings';
        $data['pageTitle'] = $data['categoryKey'];
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $data['pageTitle'];
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
   
        $content = $this->load->view('portal/basicdata', $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/jquery.tagsinput.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/basicdata.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '数据字典', $data);
    }

    function data_dictionary ()
    {
        $data['categoryArr'] = array();
        $data['categoryArr']['gClassYear'] = "班级年度";
        $data['categoryArr']['gRegCategory'] = '注册分类';
        $data['categoryArr']['gEduType'] = '教育分类';
        $data['categoryArr']['gStudyType'] = '学习分类';
        $data['categoryArr']['gPayStatus'] = '付款状态';
        $data['categoryArr']['gPayMethod'] = '付款方式';
        $data['categoryArr']['gShippingCompany'] = '快递公司';
        $data['categoryArr']['gShippingStatus'] = '快递状态';
        $data['categoryArr']['gInvoiceDeliever'] = '邮寄方式';
        $data['categoryArr']['gInvoiceStatus'] = '是否开票';
        $data['categoryArr']['gInvoiceApplyStatus'] = '邮寄申请';
        $data['categoryArr']['gMajor'] = '注册细分类';
        $data['categoryArr']['gCompanyCareer'] = '职位';
        $data['categoryArr']['gRace'] = '民族分类';
        $data['categoryArr']['gIdType'] = '身份类型';
        $data['categoryArr']['gArticleType'] = '文章分类';
        $data['categoryArr']['gProvince'] = '省份';
        $data['categoryArr']['gProvinceCity'] = '城市';
        $data['categoryArr']['gDepartment'] = '部门';
        $data['categoryArr']['gUserAuth'] = '权限管理';
        
        $data['actLi'] = "data_dictionary";
        $data['pageTitle'] = "数据字典";
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统管理';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $data['pageTitle'];
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $content = $this->load->view('portal/data_dictionary', $data, TRUE);
        $scriptExtra = '';
        $this->mp_master->Show_Portal($content, $scriptExtra, '数据字典', $data);
    }

    function usermanage ()
    {

        $data = array();
        $data['userObj'] = $this->userObj;
        $data['gCity'] = Defines::$gCity;
        $data['gCounty'] = $gCounty = Defines::$gCounty;
        $data['actTab'] = 'users';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '人员管理';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '用户管理';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['offset'] = $offset = intval($this->input->get('per_page'));

        $data['userRole'] = $userRole=$this->input->get('userRole');
        $data['gender'] = $gender=$this->input->get('gender');
        $data['fullName'] = $fullName=trim($this->input->get('fullName'));
        $data['mobile'] = $mobile=trim($this->input->get('mobile'));
        $data['email'] = $email=$this->input->get('email');
        $data['accessId'] = $accessId = trim($this->input->get('accessId'));
 
        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '用户管理');
        	$xls->addRow(array("账户","名字","性别","手机号","邮箱","用户角色","门禁卡号","所属分公司","所属区域","激活状态","添加时间"));
        	 $data['userList'] = User::Get_UserList($cityCode, $countyCode, $fullName, $gender, $email, $userRole, $mobile, $accessId, $substationId, false, $selCounty);
        	foreach($data['userList'] as $userListObj)
        	{   
        		if($userListObj->gender == 'male'){$userListObj->gender = '男';}
        		if($userListObj->gender == 'female'){$userListObj->gender = '女';}
        		if($userListObj->is_active == '1'){$userListObj->is_active = '已激活';}
        		if($userListObj->is_active == '0'){$userListObj->is_active = '未激活';}
        		$xls->addRow(array(
        				$userListObj->username,$userListObj->full_name,$userListObj->gender,$userListObj->mobile,
        				$userListObj->email,Defines::$gUserRole[$userListObj->user_role],$userListObj->accessid,Defines::$gCity[$userListObj->city_code],
        				Defines::$gCounty[$userListObj->city_code][$userListObj->county_code],$userListObj->is_active,$userListObj->added_datetime
        		));
        	}
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="用户管理.xls"');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('用户管理');
        	return;
        }
        $data['count'] = $count = User::Get_UserCount($cityCode, $countyCode,$fullName, $gender, $email, $userRole, $mobile,$accessId, false,$this->userObj->city_code,false);
        $data['userList'] = User::Get_UserList($cityCode, $countyCode,$fullName, $gender, $email, $userRole, $mobile, $accessId, $offset, DEFAULT_PAGE_SIZE,false,$this->userObj->city_code,false);                                         
        $import = $this->input->post('import');
        if($import == 'importtodb'){
        $config['upload_path'] = './public/portal/Station_image/';
        $config['allowed_types'] = 'xls|xlsx';
        $config['file_name'] = 'user';
        $config['max_size'] = 500000;
        $this->load->library('upload', $config);
        
        if($this->upload->do_upload('userfile')){
        	$up = $this->upload->data();
        	$file_name = $up["file_name"];
        	require_once("phpexcel/PHPExcel.php");
        	$objPHPExcel = PHPExcel_IOFactory::load('./public/portal/Station_image/'.$file_name);
        	$sheet = $objPHPExcel->getSheet(0);
        	$maxRow = $sheet->getHighestRow();
        	if($sheet->getCell('A'.'1')->getValue() == "所属部门" && $sheet->getCell('B'.'1')->getValue() =="区域" && $sheet->getCell('C'.'1')->getValue() =="所属局站"){
        	if($sheet->getCell('D'.'1')->getValue() =="用户名字" && $sheet->getCell('E'.'1')->getValue() =="密码" && $sheet->getCell('F'.'1')->getValue() =="姓名" && $sheet->getCell('G'.'1')->getValue() =="性别" && $sheet->getCell('H'.'1')->getValue() =="用户角色" && $sheet->getCell('I'.'1')->getValue() =="手机号码" && $sheet->getCell('J'.'1')->getValue() =="邮箱" && $sheet->getCell('K'.'1')->getValue() =="激活状态-1为激活0为未激活" && $sheet->getCell('L'.'1')->getValue() =="门禁卡号-请输入数字最大10位")
        	{
        		for($i=2;$i<=$maxRow;$i++)
        		{
		        		$city = $sheet->getCell('A'.$i)->getValue();
		        		$county = $sheet->getCell('B'.$i)->getValue();
		        		$substation_id = $sheet->getCell('C'.$i)->getValue();
		        		$substation = $this->mp_xjdh->Get_Substation($city,$county,$substation_id);
		        		$username = $sheet->getCell('D'.$i)->getValue();
		        		if(User::Get_username_User($username)){
		        			$errMsg = $data['errMsg'] = '用户名重复'.',';
		        		}
		        		$passwd = $sheet->getCell('E'.$i)->getValue();
		        		$fullName = $sheet->getCell('F'.$i)->getValue();    		
		        		$gender = $sheet->getCell('G'.$i)->getValue();
		        		$userRole = $sheet->getCell('H'.$i)->getValue();
		        		$mobile = $sheet->getCell('I'.$i)->getValue();
		        		if(User::Get_mobile_User($mobile)){		        					        			
		        			$errMsg .= $data['errMsg'] = '手机号重复'.',';
		        		}
		        		$email = $sheet->getCell('J'.$i)->getValue();
		        		if(User::Get_email_User($email)){
		        			$errMsg .= $data['errMsg'] = '邮箱重复'.',';
		        		}	       		
		        		$isActive = $sheet->getCell('K'.$i)->getValue();
		        		$accessId = $sheet->getCell('L'.$i)->getValue();
		        		if(User::Get_accessId_User($accessId)){
		        			$errMsg .= $data['errMsg'] = '卡号重复';
		        		}
		        		if($errMsg == ''){
		        			$id	= User::CreateUsers($username, $passwd, $userRole, $fullName, $gender, $mobile, $email, $info == null ? '' : $info,
		        					$substation->id, $isActive == 'active' , $accessId,$substation->city_code,$substation->county_code);
		        		}else{
		        			$data['errMsg'] = $errMsg."请修改后重新导入";
		        		}	        				
        		}
        		if($id != 0){
        			unlink('./public/portal/Station_image/'.$file_name);
        			$count = $maxRow-1;
        			$data['msg'] = "共导入".$count."条信息，请点击刷新页面查看。";        			
        		}
        	}else{
        		$data['errMsg'] = "请上传正确的文件，包括(所属部门,区域,所属局站,用户名字,密码,姓名,性别,用户角色,手机号码,邮箱,激活状态,门禁卡号)。";
        	}
        	}else{
        		$data['errMsg'] = "请上传正确的文件，包括(所属部门,区域,所属局站,用户名字,密码,姓名,性别,用户角色,手机号码,邮箱,激活状态,门禁卡号)。";
        	}
        }else{
        		$data['errMsg'] = "请选择上传的文件，包括(所属部门,区域,所属局站,用户名字,密码,姓名,性别,用户角色,手机号码,邮箱,激活状态,门禁卡号)。";
        	}
        }
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/usermanage"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        $content = $this->load->view('portal/user_manage', $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/user-manage.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '人员管理', $data);
    }

    function authority ()
    {
        
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'users';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '人员管理';
        $bcObj->url = '/portal/usermanage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '监控权限管理';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
              
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        if(!$cityCode){
        	$privilegeObj = User::Get_UserPrivilege($_SESSION['XJTELEDH_USERID']);
        	$cityCode = $privilegeObj->city_code;
        }
        
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['fullName'] = $fullName = trim($this->input->get('fullName'));  
        $data['userRole'] = $userRole = $this->input->get('userRole');
        $data['count'] = $count = User::Get_UserCount($cityCode, $countyCode, $fullName, false, false, $userRole, false, false,$this->userObj->city_code, $selCounty);
        $data['userList'] = User::Get_UserList($cityCode, $countyCode, $fullName, false, false, $userRole, false, $offset, DEFAULT_PAGE_SIZE,false,$this->userObj->city_code,$selCounty);
        foreach ($data['userList'] as $userObj) {
            $privilegeObj = User::Get_UserPrivileges($userObj->id);
            if ($privilegeObj != null) {
                if ($userObj->user_role == 'admin') {
                    $userObj->area_privilege = '全网';
                    $userObj->dev_privilege = Defines::$gDevModel;
                }elseif ($userObj->user_role == 'member' || $userObj->user_role == 'noc' || $userObj->user_role == 'operator') {
                    $userObj->area_privilege = json_decode($privilegeObj->area_privilege);
                    $userObj->dev_privilege = json_decode($privilegeObj->dev_privilege);
                }
            } else {
                $userObj->area_privilege = array();
                $userObj->dev_privilege = array();
            }
        }
        $data['substationList'] = $this->mp_xjdh->Get_Substations();        
        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '监控权限管理');
        	$xls->addRow(array("名字","用户角色","所属分公司","所属区域","区域权限","设备权限"));
        	$data['userList'] = User::Get_UserList($cityCode, $countyCode, $fullName, $gender, $email, $userRole, $mobile, $substationId,$selCity,$selCounty);
        	$data['substationList'] = $substationList = $this->mp_xjdh->Get_Substations();

        	foreach($data['userList'] as $userObj)
        	{
        		if ($userObj->user_role == 'admin'){$countyAuthority = "所有区域";}
        		elseif ($userObj->user_role == 'city_admin'){$countyAuthority = Defines::$gCity[$userObj->city_code];}
        		elseif ($userObj->user_role == 'member' || $userObj->user_role == 'noc' || $userObj->user_role == 'operator') {
        			$i = 0;
        			foreach ($substationList as $substationObj) {
        				if (in_array($substationObj->id, $userObj->area_privilege) && $i<2) {
        					$countyAuthority = htmlentities($substationObj->city,ENT_COMPAT,"UTF-8") . ' -> ' . htmlentities($substationObj->county,ENT_COMPAT,"UTF-8") . ' -> ' . htmlentities($substationObj->name,ENT_COMPAT,"UTF-8");
        					$i++;
        				}elseif($i >= 2){
        					$countyAuthority = '...';
        				    break;}
        			}
        		}
        		if ($userObj->user_role == 'admin' || $userObj->user_role == 'city_admin') {$devAuthority = "所有设备";} 
        		else if ($userObj->user_role == 'member' || $userObj->user_role == 'noc' || $userObj->user_role == 'operator') {
        			$i = 0;
        			foreach (Defines::$gDevModel as $key => $val) {
        				if(in_array($key, $userObj->dev_privilege) && $i<2)
        				{
        					$devAuthority = $val;
        					$i++;
        				}elseif($i >= 2){
        					$devAuthority ='...';
        					break;}
        			}
        		}
        
        
        		$xls->addRow(array(
        				$userObj->full_name, Defines::$gUserRole[$userObj->user_role],Defines::$gCity[$userObj->city_code],Defines::$gCounty[$userObj->city_code][$userObj->county_code],$countyAuthority,$devAuthority
        		));
        	}
        
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="权限管理.xls"');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('权限管理');
        	return;
        }
        
        $data['count'] = $count = User::Get_UserCount($cityCode, $countyCode, $fullName, false, false, $userRole, false, false, false,$this->userObj->city_code, $selCounty);
        $data['userList'] = User::Get_UserList($cityCode, $countyCode, $fullName, false, false, $userRole, false, false, $offset, DEFAULT_PAGE_SIZE,false,$this->userObj->city_code,$selCounty);
        foreach ($data['userList'] as $userObj) {
            $privilegeObj = User::Get_UserPrivileges($userObj->id);
            if ($privilegeObj != null) {
                if ($userObj->user_role == 'admin') {
                    $userObj->area_privilege = '全网';
                    $userObj->dev_privilege = Defines::$gDevModel;
                }elseif ($userObj->user_role == 'member' || $userObj->user_role == 'noc' || $userObj->user_role == 'operator') {
                    $userObj->area_privilege = json_decode($privilegeObj->area_privilege);
                    $userObj->dev_privilege = json_decode($privilegeObj->dev_privilege);
                }
            } else {
                $userObj->area_privilege = array();
                $userObj->dev_privilege = array();
            }
        }
        $data['substationList'] = $this->mp_xjdh->Get_Substations();
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/authority"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        $content = $this->load->view('portal/authority', $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/authority.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '权限管理', $data);
    }
    function loginlogUser(){
        
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'users';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '人员管理';
        $bcObj->url = '/portal/usermanage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '登录日志';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $data['offset'] = intval($this->input->get('per_page'));
        $data['txtName'] = trim($userRole=$this->input->get('txtName',true));
        $data['userRole'] = $this->input->get('userRole',true);
        $data['userAgent'] = $this->input->get('userAgent',true);
        $data['selCity'] =  $this->input->get('selCity',true);
        $data['selCounty'] = $this->input->get('selCounty',true);
        $data['selSubstation'] = $this->input->get('selSubstation',true);
        $data['substationList'] = $this->mp_xjdh->Get_Substations();
        $data['datestart'] = $this->input->get('datestart',true);
        $data['dateend'] = $this->input->get('dateend',true);
        //$data['per_page'] = $this->input->get('per_page',true);
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        
        $city_code = "";
        if($this->userObj->user_role != "admin"){
        	$city_code = $this->userObj->city_code;
        }
        
        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        
        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '登录日志');
        	$xls->addRow(array("用户名","姓名","用户角色","终端","登录ip","登录时间"));
        	$data['logList'] = User::Get_UserLoginList($data['txtName'],$data['userRole'],$data['userAgent'],$data['selCity'],$data['selCounty'],$data['selSubstation'],$data['datestart'],$data['dateend'], $pagebeginnum);
        	foreach($data['logList'] as $logObj)
        	{
        		$xls->addRow(array(
        				$logObj->username, $logObj->full_name, Defines::$gUserRole[$logObj->user_role], $logObj->agent, $logObj->ip, $logObj->time
        		));
        	}
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="登录日志.xls"');
        	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        	header('Expires:0');
        	header('Pragma:public');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('登录日志');
        	return;
        }
        if($_SESSION['XJTELEDH_USERROLE'] == 'operator' || $_SESSION['XJTELEDH_USERROLE'] == 'city_admin')
        	$user = User::GetUserById($_SESSION['XJTELEDH_USERID']);
        
        $data['count'] = User::Get_UserLoginCount($data['txtName'],$data['userRole'],$data['userAgent'],$data['selCity'],$data['selCounty'],$data['selSubstation'],$data['datestart'],$data['dateend'],$city_code);
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/loginloguser/"), $data['count'], DEFAULT_PAGE_SIZE, 3, TRUE);
        $data['logList'] = User::Get_UserLoginList($data['txtName'],$data['userRole'],$data['userAgent'],$data['selCity'],$data['selCounty'],$data['selSubstation'],$data['datestart'],$data['dateend'], $offset,DEFAULT_PAGE_SIZE,$city_code);
        $content = $this->load->view('portal/user_login_log', $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/userloginlog.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '登录日志', $data);
    }
    
   
    function activeuser ()
    {
        $userId = $this->input->post('user_id');
        $userObj = User::GetUserById($userId);
        if ($userObj != null) {
            $userObj->is_active = true;
            if (User::UpdateUser($userObj)) {
                echo TRUE;
                return;
            }
        }
        echo false;
        return;
    }
   //添加编辑用户
    function edituser ($userId=0)
    {
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'users';
        $data['pageTitle'] = '编辑/添加用户';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '人员管理';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '用户管理';
        $bcObj->url = '/portal/usermanage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $data['pageTitle'];
        $bcObj->url = '#';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $this->load->library('session');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->load->library('form_validation');
            // $this->form_validation->set_rules('selSubstation', '所属局站', 'trim|required');
            $this->form_validation->set_rules('txtFullName', '姓名', 'trim|required');
            $this->form_validation->set_rules('selGender', '性别', 'trim|required');
            $this->form_validation->set_rules('selUserRole', '用户角色', 'trim|required');
            $this->form_validation->set_rules('txtMobile', '联系方式', 'trim|required');
            $this->form_validation->set_rules('txtEmail', '邮箱', 'trim');
            $this->form_validation->set_rules('selActive', '激活状态', 'trim|required');
            $this->form_validation->set_rules('accessid', '门禁卡号', 'trim');
           
            if (! $userId) {
                $this->form_validation->set_rules('txtUsername', '用户名', 'trim|required');
                $this->form_validation->set_rules('txtPasswd', '密码', 'trim|required');
            }
            $userId = $this->input->post('txtUserId');
            if ($this->form_validation->run() == TRUE) {
                $city_code = $this->input->post('selCity');
                $county_code = $this->input->post('selCounty');
                $substation_id = $this->input->post('selSubstation');
                $username = $this->input->post('txtUsername');
                $passwd = $this->input->post('txtPasswd');
                $fullName = $this->input->post('txtFullName');
                $gender = $this->input->post('selGender');
                $userRole = $this->input->post('selUserRole');
                $mobile = $this->input->post('txtMobile');
                $email = $this->input->post('txtEmail');
                $info = $this->input->post('txtInfo');
                $isActive = $this->input->post('selActive');
                $accessId = $this->input->post('accessid');
                if ($userId) {
                    if ($passwd)
                        $userObj->password = md5($passwd);                   
                    if (User::UpdateUserinfo($userId, $passwd, $userRole, $fullName, $gender, $mobile, $email, '', $city_code, $county_code, $substation_id, $isActive == 'active' , $accessId)) {
                        if ($userRole == 'city_admin') {
                            User::Update_UserPrivilege($userId, json_encode(array($this->input->post('citycode'))));
                        }
                        $returnUrl = $this->session->userdata('returnUrl');
                        $this->session->unset_userdata('returnUrl');
                        redirect($returnUrl);
                    } else {
                        $data['errorMsg'] = '更新用户失败';
                    }
                } else {
                    if (($userId = User::CreateUser($username, $passwd, $userRole, $fullName, $gender, $mobile, $email, $info == null ? '' : $info, 
                            $city_code, $county_code, $substation_id, $isActive == 'active' , $accessId)) != 0) {
                        if ($userRole == 'city_admin') {
                            User::Save_UserPrivilege($userId, json_encode(array($this->input->post('citycode'))), '');
                        } else {
                            User::Save_UserPrivilege($userId, '', '');
                        }                     
                        $data['successMsg'] = '创建用户成功&nbsp&nbsp&nbsp&nbsp<a href="/portal/usermanage">返回列表</a>&nbsp&nbsp&nbsp&nbsp<a href="/portal/edituser">继续创建用户</a>';
                    } else {
                        $data['successMsg'] = '创建用户失败';
                    }
                }
            } else {
                $data['errorMsg'] = '验证失败';
            }
        } else {
            $this->session->set_userdata('returnUrl', $_SERVER['HTTP_REFERER']);
            $userObj = User::GetUserById($userId);
            $data['userObj'] = $userObj;
            if(!empty($userObj->county_code))
            {
                $data['substationList'] = $this->mp_xjdh->Get_Substations(false, $userObj->county_code);
            }else{
                $data['substationList'] = array();
            }
        }
        $data['currentUser'] = $this->userObj;
        $content = $this->load->view('portal/edit-user', $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/edituser.js"></script>';
        
        $this->mp_master->Show_Portal($content, $scriptExtra, '编辑/新建用户', $data);
    }
    
    function deluser()
    {
    	//User:: DeleteUser($this->input->get('user_id'));
    	$userId = $this->input->post('user_id');

       	         $access="XJLProtocol";
       	         $area_privilege=$this->mp_xjdh->Get_user_privilege($userId);
       	         $getdevice=$this->mp_xjdh->Get_device2($access,$area_privilegeArr);
       	         $accessid=$this->mp_xjdh->Get_user2($userId);
       	         $delObj = User::DeleteUser($userId);
                   foreach ($getdevice as $data_id) {
       	        $this->load->helper("smdthrift");
       	        $apiObj = new SMDThrift();
       	        $method=4;    
       	        foreach ($accessid as $accessids) {
       	        	$accessidss=intval($accessids->accessid);
       	        }
       	        $name = $apiObj->doorOperate(intval($data_id->data_id),$accessidss,$method);
       	         }
    	
    	echo json_encode($delObj ? "cg" : "sb");
    }
    

    public function search_station()
    {
        $keyword = $this->input->get('keyword');
        $callback = $this->input->get('callback');
        if(empty($keyword))
        {
            echo $callback."([])";
        }else{
            if(in_array($this->userObj->user_role, array("admin","noc"))){
                $data['substationList'] = $substationList = $this->mp_xjdh->Search_Substation($keyword, '', array(), 15);
            }else{
                if($this->userObj->user_role == "city_admin")
                {
                    $data['substationList'] = $substationList = $this->mp_xjdh->Search_Substation($keyword,$this->userObj->city_code, array(), 15);
                }else{
                    $userPrivilegeObj = User::Get_UserPrivilege($this->userObj->id);                    
                    if(count($userPrivilegeObj))
                    {
                        $substationIdArray = json_decode($userPrivilegeObj->area_privilege);
                        $data['substationList'] = $substationList = $this->mp_xjdh->Search_Substation($keyword,$this->userObj->city_code, $substationIdArray);
                    }else{
                        $data['substationList'] = $substationList = array();
                    }
                }
            }
            $substationArray = array();
            foreach($substationList as $substation)
            {
                array_push($substationArray, $substation->name);
            }
            echo $callback."(". json_encode($substationArray).")";
        }
    
    }
    //实时数据管理 	查找
    function search ()
    {
        $data = array();
        $data['actTab'] = 'rt_data';
        $data['keyword'] = $keyword = trim($this->input->get('q'));
        $data['bcList'] = array();
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        $bcObj = new Breadcrumb();
        $bcObj->title = '局站搜索';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        if(in_array($this->userObj->user_role, array("admin","noc"))){
            $data['substationList'] = $substationList = $this->mp_xjdh->Search_Substation($keyword);
        }else{
            if($this->userObj->user_role == "city_admin")
            { 
                $data['substationList'] = $substationList = $this->mp_xjdh->Search_Substation($keyword,$this->userObj->city_code);
            }else{
                $userPrivilegeObj = User::Get_UserPrivilege($this->userObj->id);
                if(count($userPrivilegeObj))
                {                    
                    $substationIdArray = json_decode($userPrivilegeObj->area_privilege);
                    $data['substationList'] = $substationList = $this->mp_xjdh->Search_Substation($keyword,$this->userObj->city_code, $substationIdArray);
                }else{
                    $data['substationList'] = $substationList = array();
                }
            }
        }
        if(count($substationList) == 1){
        	$url = site_url("portal/room_list/".$substationList[0]->id);
            redirect($url);
        }else{
        	$content = $this->load->view("portal/search", $data, TRUE);
        }
        $this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
    }

    function checkaccount ()
    {
        $userName = $this->input->post('txtUsername');
        if (User::GetUserByName($userName) == null) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    
    function checkname ()
    {
    	$userName = $this->input->post('txtUsername');
    	if (preg_match("/^[a-zA-Z0-9]+/", $userName)){
    		echo 'true';
    	} else {
    		echo 'false';
    	}
    }
    
    
    function checkphone ()
    {
        $phone = $this->input->post('txtMobile');
        $username = $this->input->post('username');
        $userObj = User::GetUserByPhone($phone);
        if (count($userObj)) {
            if ($username != false && $userObj->username == $username)
                echo "true";
            else
                echo 'false';
        } else
            echo "true";
    }

    function checkemail ()
    {
        $email = $this->input->post('txtEmail');
        $username = $this->input->post('username');
        $userObj = User::GetUserByEmail($email);
        if (count($userObj)) {
            if ($username != false && $userObj->username == $username)
                echo "true";
            else
                echo 'false';
        } else
            echo "true";
    }
    
    function checkaccessid ()
    {
    	$accessid = $this->input->post('accessid');
    	$username = $this->input->post('username');
    	$userObj = User::GetUserByAccessid($accessid);
    	if (count($userObj)) {
    		if ($username != false && $userObj->username == $username)
    			echo "true";
    		else
    			echo 'false';
    	} else
    		echo "true";
    }
    

    function getMapStatistics ()
    {
        $jsonRet = array();
        $startDatetime = date('Y-m-1');
        $endDatetime = date('Y-m-d');
        $mapData = array();
        if(in_array($this->userObj->user_role, array("admin","noc"))){
    		$mapList = $this->mp_xjdh->Get_MapData(0);
    		$jsonRet['title'] = '新疆电信各分公司区域图';
    	}else{
    	    if(empty($this->userObj->city_code))
    	    {
    	       $mapList = array();
    	    }else{
    	       $jsonRet['title'] = '新疆电信' . Defines::$gCity[$this->userObj->city_code] . '分公司区域图';
    	       $mapList = $this->mp_xjdh->Get_MapData($this->userObj->city_code);
    	    }
    	}
        if (count($mapList) == 0) {
            /*$mapList = $this->mp_xjdh->Get_MapData(0, $parentCode);
            foreach ($mapList as $obj) {
                if (strlen($obj->path) == 0)
                    continue;
                $mapObj = array();
                $mapObj['code'] = 0; // $obj->code;
                $mapObj['name'] = $obj->name;
                $mapObj['path'] = $obj->path;
                $mapObj['color'] = $obj->color;
                $energy = 0;
                $imemList = array();
                $alarmCount = $this->mp_xjdh->Get_AlarmCount($parentCode, false, false, false, false, false, array(), $startDatetime, $endDatetime);
                $mapObj['alarm'] = $alarmCount;
                $imemList = $this->mp_xjdh->Get_Imem12List($parentCode, false);
                foreach ($imemList as $imemObj) {
                    $wObj = $this->mp_xjdh->Count_Imem12History($imemObj->data_id, $startDatetime, $endDatetime);
                    $energy += (floatval($wObj->w1max) + floatval($wObj->w2max) + floatval($wObj->w3max) + floatval($wObj->w4max)) -
                             (floatval($wObj->w1min) + floatval($wObj->w2min) + floatval($wObj->w3min) + floatval($wObj->w4min));
                }
                $mapObj['energy'] = number_format($energy, 2);
                array_push($mapData, $mapObj);
            }*/
        } else {
            foreach ($mapList as $obj) {
                if (strlen($obj->path) == 0)
                    continue;
                $mapObj = array();
                $mapObj['code'] = $obj->code;
                $mapObj['name'] = $obj->name;
                $mapObj['path'] = $obj->path;
                $mapObj['color'] = $obj->color;
                $energy = 0;
                $imemList = array();
                if ($parentCode == 0) {
                    $alarmCount = $this->mp_xjdh->Get_AlarmCount($obj->code, false, false, false, false, false, array(), $startDatetime, $endDatetime);
                    $mapObj['alarm'] = $alarmCount;
                    $imemList = $this->mp_xjdh->Get_Imem12List($obj->code);
                } else {
                    
                    $alarmCount = $this->mp_xjdh->Get_AlarmCount($parentCode, $obj->code, false, false, false, false, array(), $startDatetime, $endDatetime);
                    $mapObj['alarm'] = $alarmCount;
                    $imemList = $this->mp_xjdh->Get_Imem12List($parentCode, $obj->code);
                }
                foreach ($imemList as $imemObj) {
                    $wObj = $this->mp_xjdh->Count_Imem12History($imemObj->data_id, $startDatetime, $endDatetime);
                    $energy += (floatval($wObj->w1max) + floatval($wObj->w2max) + floatval($wObj->w3max) + floatval($wObj->w4max)) -
                             (floatval($wObj->w1min) + floatval($wObj->w2min) + floatval($wObj->w3min) + floatval($wObj->w4min));
                }
                $mapObj['energy'] = number_format($energy, 2);
                array_push($mapData, $mapObj);
            }
        }
        $jsonRet['mapData'] = $mapData;
        header('Content-type: application/json');
        echo json_encode($jsonRet);
        return;
    }
    
    
    
    
    function getSubstationMap ()
    {
    	$jsonRet = array();
    	$startDatetime = date('Y-m-1');
    	$endDatetime = date('Y-m-d');
    	$mapData = array();
    	if(in_array($this->userObj->user_role, array("admin","noc"))){
    		$mapList = $this->mp_xjdh->Get_MapData(0);
    		$jsonRet['title'] = '新疆电信各分公司区域图';
    	}else{
    		if(empty($this->userObj->city_code))
    		{
    			$mapList = array();
    		}else{
    			$jsonRet['title'] = '新疆电信' . Defines::$gCity[$this->userObj->city_code] . '分公司区域图';
    			$mapList = $this->mp_xjdh->Get_MapData($this->userObj->city_code);
    		}
    	}
    	if (count($mapList) == 0) {
    	} else {
    		foreach ($mapList as $obj) {
    			if (strlen($obj->path) == 0)
    				continue;
    			$mapObj = array();
    			$mapObj['code'] = $obj->code;
    			$mapObj['name'] = $obj->name;
    			$mapObj['path'] = $obj->path;
    			$mapObj['color'] = $obj->color;
    			$energy = 0;
    			$imemList = array();
    			if ($parentCode == 0) {
    				$alarmCount = $this->mp_xjdh->Get_AlarmCount($obj->code, false, false, false, false, false, array(), $startDatetime, $endDatetime);
    				$mapObj['alarm'] = $alarmCount;
    				$imemList = $this->mp_xjdh->Get_Imem12List($obj->code);
    			} else {
    
    				$alarmCount = $this->mp_xjdh->Get_AlarmCount($parentCode, $obj->code, false, false, false, false, array(), $startDatetime, $endDatetime);
    				$mapObj['alarm'] = $alarmCount;
    				$imemList = $this->mp_xjdh->Get_Imem12List($parentCode, $obj->code);
    			}
    			foreach ($imemList as $imemObj) {
    				$wObj = $this->mp_xjdh->Count_Imem12History($imemObj->data_id, $startDatetime, $endDatetime);
    				$energy += (floatval($wObj->w1max) + floatval($wObj->w2max) + floatval($wObj->w3max) + floatval($wObj->w4max)) -
    				(floatval($wObj->w1min) + floatval($wObj->w2min) + floatval($wObj->w3min) + floatval($wObj->w4min));
    			}
    			$mapObj['energy'] = number_format($energy, 2);
    			array_push($mapData, $mapObj);
    		}
    	}
    	$jsonRet['mapData'] = $mapData;
    	header('Content-type: application/json');
    	echo json_encode($jsonRet);
    	return;
    }
    
    
    

    function getAlarmChartsData ()
    {
        $jsonRet = array();
        $cityCode = $this->input->get('citycode');
        $countyCode = $this->input->get('countycode');
        $jsonRet['alarmList'] = array();
        $result = $this->mp_xjdh->Get_AlarmCountGroupByLevel($cityCode, $countyCode, false, false, false, array(), date('Y-m-1'), date('Y-m-d'));
        
        for ($i = 1; $i <= 4; $i ++) {
            $count = 0;
            foreach ($result as $rObj) {
                if ($rObj->level == $i) {
                    $count = $rObj->count;
                    break;
                }
            }
            array_push($jsonRet['alarmList'], intval($count));
        }
        $jsonRet['categories'] = array('一级','二级','三级','四级');
        header('Content-type: application/json');
        echo json_encode($jsonRet);
        return;
    }

    function edit_device ($data_id=0)
    {
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'settings';
        $data['pageTitle'] = '编辑/添加设备';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '设备配置';
        $bcObj->url = '/portal/device_manage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $data['pageTitle'];
        $bcObj->url = '#';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $this->load->library('session');
        if($data_id)
        {
            $data['data_id'] = $data_id;
            $devObj = $this->mp_xjdh->Get_Device($data_id);
            if(!count($devObj))
                redirect("/portal/device_manage");
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('selRoom', '机房', 'trim|required');
            $this->form_validation->set_rules('selSmdDev', '采集板ID', 'trim|required');
            $this->form_validation->set_rules('selModel', '设备型号', 'trim|required');
            $this->form_validation->set_rules('selPort', '端口号', 'trim|required');
            $this->form_validation->set_rules('selActive', '激活状态', 'trim|required');
            $this->form_validation->set_rules('txtName', '设备名', 'trim|required');
            if (! $data_id) {
                $this->form_validation->set_rules('txtDataId', '数据ID', 'trim|required');
            }
            //$data_id = $this->input->post('txtDataId');
            if ($this->form_validation->run() == TRUE) {
                $imem_id = $this->input->post('txtImemId');
                $room_id = $this->input->post('selRoom');
                $smd_device_no = $this->input->post('selSmdDev');
                $name = $this->input->post('txtName');
               	$new_data_id = $this->input->post('txtDataId');
                $model = $this->input->post('selModel');
                $devGroup = $this->input->post('devgroup');
                
                $manufacturers = $this->input->post('manufacturers');
                $version = $this->input->post('version');
                        
                $port = $this->input->post('selPort');
                $extra_para = $this->input->post('txtExtraParam');
                $active = $this->input->post('selActive');
                $txtManufacturer = $this->input->post('txtManufacturer');
                $txtProductionDate = $this->input->post('txtProductionDate');
                $txtDeviceModel = $this->input->post('txtDeviceModel');
                $devicebrand = $this->input->post('devicebrand');
                $txtRatedPower = $this->input->post('txtRatedPower');
                $txtMemo = $this->input->post('txtMemo');
                $extra_paras = json_decode($extra_para,true);
                foreach ($extra_paras as $key =>$val)
                {
                	$n = 1;
                	if($key == amount)
                	{
                		break;
                	}
                	else
                	{
                		$n = 0;
                	}
                }
                if($n == 0)
                {
                	if($model == 'battery_24')
                	{
                		$extra_paras['amount'] = 24;
                	}
                	elseif($model == 'battery_32')
                	{
                		$extra_paras['amount'] = 32;
                	}                	
                }
                $extra_para =  json_encode($extra_paras);
                //var_dump($model);die;
                $txtManufacturer=1;
                $this->load->library('upload');
                $config['upload_path'] = './attachments';
                $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx|zip|rar|gz|gzip|tar|tgz|bz2';
                $config['max_size'] = 30000;
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);
                $distribution_equipment = false;
                if (isset($_FILES['fDistributionEquipment'])) {
                    $bRet = $this->upload->do_upload('fDistributionEquipment');
                    if ($bRet) {
                        $fileData = $this->upload->data();
                        $distribution_equipment = json_encode(array('file_name' => $fileData["file_name"],'orig_name' => $fileData['orig_name']));
                    }
                }
               	//var_dump($devGroup).die;
                $dev_type = '';
                if (in_array($model, array('smoke','water'))) {
                    $dev_type = 0;
                } elseif (in_array($model, array('temperature','humid','battery24_voltage'))) {
                    $dev_type = 1;
                } elseif ($model == 'imem_12') {
                    $dev_type = 3;
                } elseif ($model == 'camare'){
                	$dev_type = 10;
                } elseif ($model == "power_302a")
                {
                    $dev_type = 5;
                } elseif ($model == 'vpdu'){
                	$dev_type = 6;
                }else {
                    $dev_type = 2;
                }
                if ($data_id) {
                    if ($this->mp_xjdh->Update_Device($data_id, $smd_device_no, $room_id, $imem_id, $name, $new_data_id, $dev_type, $model, $devGroup,$port, $extra_para, 
                            $active == 'active', $txtManufacturer, $txtProductionDate, $txtDeviceModel, $txtRatedPower, $distribution_equipment, $txtMemo, $devicebrand,$manufacturers,$version)) {
                            $returnUrl = $this->session->userdata('returnUrl');
                        $this->session->unset_userdata('returnUrl');
                        redirect($returnUrl);
                    } else {
                        $data['errorMsg'] = '更新设备信息失败！！';
                    }
                }else {
                    if ($this->mp_xjdh->Add_Device($smd_device_no, $room_id, $imem_id, $name, $new_data_id, $dev_type, $model, $devGroup, $port, $extra_para, 
                            $active == 'active', $txtManufacturer, $txtProductionDate, $txtDeviceModel, $txtRatedPower, $distribution_equipment, $txtMemo, $devicebrand,$manufacturers,$version)) {
                    	if($model == 'temperature' || $model == 'humid' || $model == 'smoke' || $model == 'water' || $model == 'camera')
                    	{
                    		$roomInfo = $this->mp_xjdh->Get_room_name($room_id);
                    		$room_name = $roomInfo->name;
                    		if($model == 'temperature' || $model == 'humid' || $model == 'smoke' || $model == 'water')
                    		{
                    			$dev_group = $this->mp_xjdh->Get_venv_dataid($room_id);
                    			if($dev_group)
                    			{
                    				$this->mp_xjdh->write_enviroment_devgroup($new_data_id,$dev_group->data_id);
                    			}else{
                    				$venv_data_id = $new_data_id + 1;
                    				$venv_device = $this->mp_xjdh->Add_venv($smd_device_no, $room_id, $room_name.'机房环境', $venv_data_id,'1');
                    				if($venv_device)
                    				{
                    					$device_model = array('temperature','humid','smoke','water');
                    					$this->mp_xjdh-> add_enviroment_devgroup($room_id,$venv_data_id,$device_model);
                    				}
                    			}
                    		}
                    		if($model == 'camera')
                    		{
                    			$dev_group = $this->mp_xjdh->Get_vcamera_dataid($room_id);
                    			if($dev_group)
                    			{
                    				$this->mp_xjdh->write_camera_devgroup($new_data_id,$dev_group->data_id);
                    			}else{
                    				$vcam_data_id = $new_data_id + 1;
                    				$vcam_device = $this->mp_xjdh->Add_vcam($smd_device_no, $room_id, $room_name.'监控设备', $vcam_data_id,'1');
                    				if($vcam_device)
                    				{
                    					$this->mp_xjdh-> add_camera_devgroup($room_id,$vcam_data_id);
                    				}
                    			}
                    		}
                    	}
                        $data['successMsg'] = '添加设备成功。<a href="/portal/device_manage">返回</a>';
                    } else {
                        $data['successMsg'] = '添加设备失败！重复数据ID，请检查后重试';
                    }
                }
            } else {
                $data['errorMsg'] = '验证失败，请检查，重新提交！！';
            }
        } else {
            if ($data_id) {
                $this->session->set_userdata('returnUrl', $_SERVER['HTTP_REFERER']);
        	$devObj = $this->mp_xjdh->Get_Device($data_id);
        	if(count($devObj))
        	{
        		$data['devObj'] = $devObj;
        		$data['substationList'] = $this->mp_xjdh->Get_Substations(false, $devObj->county_code);
        		$data['roomList'] = $this->mp_xjdh->Get_Rooms(false, $devObj->substation_id);
        		$data['smdDevList'] = $this->mp_xjdh->Get_CountySMDDevice(false, $devObj->substation_id);
        	}
	    }
        }

        $content = $this->load->view('portal/edit-device', $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>
                <link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>
                <script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/tiny_mce/tinymce.min.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/edit-device.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '编辑/添加设备', $data);
    }

    function getSubstation ()
    {
        $jsonRet = array();
        $countyCode = $this->input->get('countycode');
        if ($countyCode) {
            $jsonRet['substationList'] = $this->mp_xjdh->Get_Substations(false, $countyCode);
        } else {
            $jsonRet['substationList'] = array();
        }
        echo json_encode($jsonRet);
        return;
    }

    function getroom ()
    {
        $jsonRet = array();
        $substation_id = $this->input->get('substation_id');
        if ($substation_id) {
            $jsonRet['roomList'] = $this->mp_xjdh->Get_Rooms(false, $substation_id);
            //$jsonRet['smdDevList'] = $this->mp_xjdh->Get_CountySMDDevice(false, $substation_id);          
        } else {
            $jsonRet['roomList'] = array();
           // $jsonRet['smdDevList'] = array();
        }
        echo json_encode($jsonRet);
        return;
    }
    function getSmdDev (){
    	$jsonRet = array();
    	$substation_id = $this->input->get('selsubstation_id');
    	if ($substation_id) {
    		$jsonRet['smdDevList'] = $this->mp_xjdh->Get_SMDDevices($substation_id);
    	} else {
    		$jsonRet['smdDevList'] = array();
    	}
    	echo json_encode($jsonRet);
    	return;
    }
    function toggleDeviceStatus ()
    {
        $active = $this->input->post('active');
        $device_id = $this->input->post('device_id');
        echo $this->mp_xjdh->Toggle_DeviceStatus($device_id, $active);
        return;
    }

    function toggleSmdDeviceStatus ()
    {
        $active = $this->input->post('active');
        $smd_dev_no = $this->input->post('smd_device_no');
        echo $this->mp_xjdh->Toggle_SmdDeviceStatus($smd_dev_no, $active);
        return;
    }

    function deleteDevice ()
    {
        $device_id = $this->input->post('device_id');
        echo $this->mp_xjdh->Delete_Device($device_id);
        return;
    }

    function deleteSmdDevice ()
    {
        $smd_device_no = $this->input->post('smd_device_no');
        echo $this->mp_xjdh->Delete_SmdDevice($smd_device_no);
        return;
    }

    function edit_smd_device ($smd_device_no = 0)
    {
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['city_code'] = $city_code = $this->input->get('city_code');
        $data['county_code'] = $county_code = $this->input->get('county_code');
        $data['substation'] = $substation = $this->input->get('substation');
        $data['actTab'] = 'settings';
        $data['pageTitle'] = '编辑/添加采集单元';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '查看采集单元状态';
        $bcObj->url = '/portal/smd_device_status';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $data['pageTitle'];
        $bcObj->url = '#';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $smdMaxId=$this->mp_xjdh->Get_smdMaxId();
        $data['smdNo']=$smdNo=intval($smdMaxId->smdmax)+1;
        $this->load->library('session');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('selRoom', '机房', 'trim|required');
            $this->form_validation->set_rules('txtIP', '设备IP地址', 'trim|required|valid_ip');
            $this->form_validation->set_rules('selActive', '激活状态', 'trim|required');
            $this->form_validation->set_rules('txtName', '设备名', 'trim|required');
            //if (! $smd_device_no) {           	
               // $this->form_validation->set_rules('txtDevNo', '采集板ID', 'trim|required|integer');
          //  }
            if ($this->form_validation->run() == TRUE) {
                $room_id = $this->input->post('selRoom');
               // $new_device_no = $this->input->post('txtDevNo');
               $station = $this->input->post('selSubstation');
                $name = $this->input->post('txtName');
                $ip = $this->input->post('txtIP');
                $active = $this->input->post('selActive');
                if ($smd_device_no) {
                	$result = $this->mp_xjdh->Update_SmdDevice($smd_device_no, $room_id,$station, $name, $ip,$active == 'active');
                	if($result){
                		$data['successMsg'] = '修改成功<a href="/portal/smd_device_manage">返回列表</a>';
                	}
//                     if ($this->mp_xjdh->Update_SmdDevice($smd_device_no, $room_id,$station, $name, $ip,$active == 'active')) {                    
//                         $returnUrl = $this->session->userdata('returnUrl');
//                         $this->session->unset_userdata('returnUrl');
//                         redirect($returnUrl);
//                     } 
                    else {
                        $data['errorMsg'] = '更新设备信息失败！！';
                    }
                } else {
                    if ($this->mp_xjdh->Add_SmdDevice($smdNo, $room_id,$station, $name, $ip, $active == 'active')) {
                        $data['successMsg'] = '添加设备成功。<a href="/portal/smd_device_manage">返回</a>';
                    } else {
                        $data['errorMsg'] = '添加设备失败！！';
                    }
                }
            } else {
                $data['errorMsg'] = '验证失败，请检查，重新提交！！';
            }
        }
        if ($smd_device_no) {
            $data['smdDevObj'] = $smdDevObj = $this->mp_xjdh->Get_SmdDevice($smd_device_no);

            if (count($smdDevObj)) {
                $data['substationList'] = $this->mp_xjdh->Get_Substations(false, $smdDevObj->county_code);
                $data['roomList'] = $this->mp_xjdh->Get_Rooms(false, $smdDevObj->substation_id);
            }
            if(count($county_code) && count($substation))
            {
                $data['substationList'] = $this->mp_xjdh->Get_Substations(false, $county_code);
                $data['roomList'] = $this->mp_xjdh->Get_Rooms(false, $substation);
            }
        }
        
        $content = $this->load->view('portal/edit-smd-device', $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/edit-smd-device.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '编辑/添加设备', $data);
    }

    function checkdevice ()
    {
        $data_id = $this->input->post('txtDataId');
        $pre_data_id = $this->input->post('pre_data_id');
        if($data_id != $pre_data_id)
        {
        	echo count($this->mp_xjdh->Get_Device($data_id)) > 0 ? 'false' : 'true';
        }
        else
        {
        	echo 'true';
        }
        return;
    }

    function checkSmdDevce ()
    {
        $devNo = $this->input->post('txtDevNo');
        echo count($this->mp_xjdh->Get_SmdDevice($devNo)) > 0 ? 'false' : 'true';
        return;
    }
    function restore_alert ()
	{
		$alert_id = $this->input->post('alert_id');
		echo $this->mp_xjdh->Restore_Alert($alert_id);
	}
    function block_alert ()
    {
        $alert_id = $this->input->post('alert_id');
        echo $this->mp_xjdh->Block_Alert($alert_id);
    }
    function take_alert(){    	
	    $alert_id = $this->input->post('alert_id');	    	    
	    echo $this->mp_xjdh->Take_PreAlert($alert_id);
    }
    function getRtAlarmCount ()
    {
    	$reportDate[0] = date('Y-m-d h:i:s',time());    
    	$reportDate[1] = date('Y-m-d ',strtotime("$reportDate[0] - 30 day"));   
        if ($_SESSION['XJTELEDH_USERROLE'] == 'admin'||$_SESSION['XJTELEDH_USERROLE'] == 'noc') {
            $cityCode = false;
            $countyCode = false;
        } elseif ($_SESSION['XJTELEDH_USERROLE'] == 'city_admin') {
        	$cityCode = $this->userObj->city_code;
            $countyCode = $this->userObj->county_code;
            var_dump($cityCode);
        } 
        $jsonRet = array();
        $result = $this->mp_xjdh->Get_AlarmCountGroup($cityCode, $countyCode, 'unresolved', $reportDate[1], $reportDate[0]);
        for ($i = 1; $i <= 4; $i ++) {
            $count = 0;
            foreach ($result as $rObj) {
                if ($rObj->level == $i) {
                    $count = $rObj->count;
                    break;
                }
            }
            $jsonRet['level' . $i] = $count;
            $total += $count;
        }
        $jsonRet['totalCount'] = $total;
        header('Content-type: application/json');
        echo json_encode($jsonRet);
        return;
    }

    function editprivilege ()
    {
        if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin','city_admin','operator'))) {
            $this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
            return;
        }
        $data = array();
        $data['actTab'] = 'users';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '人员管理';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '权限管理';
        $bcObj->url = '/portal/authority';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '编辑用户权限';
        $bcObj->url = '###';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $user_id = $this->input->get('user_id');
        $userObj = User::GetUserById($user_id);
      
        $privilegeObj = User::Get_UserPrivileges($user_id);
        $area_privilege = array();
        $dev_privilege = array();
        $area_privilege = json_decode($privilegeObj->area_privilege);
        $dev_privilege = json_decode($privilegeObj->dev_privilege);
        $areaTreeData = array();
        $citykeys = array();
      
        if($userObj->user_role == 'admin'||$userObj->user_role == 'noc'){
        $citykeys = array_keys(Defines::$gCity);
        }else{
             $cities = User::Get_UserList($userObj->city_code);
             foreach ($cities as $cityObj) {
        	   array_push($citykeys, $cityObj->city_code);
        	}
        }
        foreach (Defines::$gCity as $cityKey => $cityVal) {
        	if (! in_array($cityKey, $citykeys))
        		continue;
        	  $cityNode = array();
        	  $cityNode['text'] = $cityVal;
        	  if (key_exists($cityKey, Defines::$gCounty)) {
        		  $cityNode['children'] = array();
        		  foreach (Defines::$gCounty[$cityKey] as $countyKey => $countyVal) {
        			$countyNode = array();
        			$countyNode['text'] = $countyVal;
        			$substationList = $this->mp_xjdh->Get_Substations(false, $countyKey);
        			 if (count($substationList)) {
        			    $countyNode['children'] = array();
        			    foreach ($substationList as $substationObj) {
        			       $substationNode = array();
        			       $substationNode['id'] = $substationObj->id;
        			       $substationNode['text'] = $substationObj->name;
        			       if (in_array($substationObj->id, $area_privilege))
        				       $substationNode['state'] = array('selected' => true);
        				       array_push($countyNode['children'], $substationNode);
        				 }
        			}
        			array_push($cityNode['children'], $countyNode);
        		  }
        		}
        		array_push($areaTreeData, $cityNode);
           }     
       
        $data['areaTreeData'] = array('text' => '全网','children' => $areaTreeData);
        $devTreeData = array();
        
        foreach(Constants::$devConfigList as $key => $devConfig)
        {
        	$devModelNode = array();
        	$devModelNode['id'] = $devConfig[0];
        	$devModelNode['text'] = $devConfig[1];
        	foreach($devConfig[0] as $val){
        	    if (in_array($val, $dev_privilege))
        		$devModelNode['state'] = array('selected' => true);
        	}
        	array_push($devTreeData, $devModelNode);
        }
          
        $data['devTreeData'] = array('text' => '全部','children' => $devTreeData);
        $content = $this->load->view('portal/edit-privilege', $data, TRUE);
        $scriptExtra = '<link rel="stylesheet" href="/public/js/jstree/themes/default/style.min.css"/>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/jstree/jstree.min.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/edit-privilege.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '编辑用户权限', $data);
    }   
   
//     function master_accordion(){
//        $areaTreeData = array();
//     	if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){
//     	   $cityList = Defines::$gCity;
//     	}else if ($_SESSION['XJTELEDH_USERROLE'] == 'noc' || $_SESSION['XJTELEDH_USERROLE'] == 'member' || $_SESSION['XJTELEDH_USERROLE'] == 'operator'){
//     	    $cityList = array();
//     	    $allcityList = Defines::$gCity;
//     	    $privaligeObj = User::Get_UserPrivilege($_SESSION['XJTELEDH_USERID']);
//     	    $areaPrivilegeArrKey = $this->mp_xjdh->Get_CityListArrKey(json_decode($privaligeObj->area_privilege));
//            if($areaPrivilegeArrKey != null && count($areaPrivilegeArrKey))
//     	    foreach($areaPrivilegeArrKey as $cityeachKey){
//     	        $cityList[$cityeachKey["city_code"]] = $allcityList[$cityeachKey["city_code"]];
//     	    }
//     	}else if($_SESSION['XJTELEDH_USERROLE'] == 'city_admin'){
//     	    $allcityList = Defines::$gCity;
//     	    $privaligeObj = User::Get_UserPrivilege($_SESSION['XJTELEDH_USERID']);
//     	    $cityList[$privaligeObj->city_code]=$allcityList[$privaligeObj->city_code];
//     	}else{
//     	    $cityList = array();
//     	}
//        foreach ($cityList as $citykey => $cityval){
//     		$cityNode = array();
//     		$cityNode['text'] = $cityval;
//     		$cityNode['href'] = $citykey;
    		
//            array_push($areaTreeData, $cityNode);
// 	   }
//         echo json_encode($areaTreeData);
//     	return;
//     }
    
    
    
    function master_accordion(){
    	$areaTreeData = array();
    	$city_code = $this->userObj->city_code;
    	if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){
    		$cityList = Defines::$gCity;
    		foreach ($cityList as $citykey => $cityval){
    			$cityNode = array();
    			$cityNode['text'] = $cityval;
    			$cityNode['href'] = $citykey;
    			array_push($areaTreeData, $cityNode);
    		}
    		echo json_encode($areaTreeData);
    		return;
    	}else{
    		$cityList = Defines::$gCity;
    		foreach ($cityList as $citykey => $cityval){
    			$city_code = $this->userObj->city_code;
    			if ($city_code==$citykey){
    				$cityNode = array();
    				$cityNode['text'] = $cityval;
    				$cityNode['href'] = $citykey;
    				array_push($areaTreeData, $cityNode);}
    		}
    		echo json_encode($areaTreeData);
    		return;
    	}
    }
    
   	
    function editPrTempAlarm(){
    	if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin','city_admin'))) {
    		$this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
    		return;
    	}
    	$data = array();
    	$data['userObj'] = $this->userObj;
    	$data['actTab'] = 'settings';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '系统配置';
    	$bcObj->url = '#';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '温度告警设置';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);
    	
    	$areaTreeData = array();
    	$substationList = $this->mp_xjdh->Get_Substations(false, false);
    	$deviceLists = $this->mp_xjdh->Get_devicepr();
    	$roomList = $this->mp_xjdh->get_roompr();
    	$data['substationList'] = $substationList;
    	$data['deviceList'] = $deviceLists;
    	$data['roomList'] = $roomList;
    	$data['areaTreeData'] = array('text' => '全网','children' => $areaTreeData);
    	
    	$content = $this->load->view('portal/editPrTempAlarm', $data, TRUE);
    	$scriptExtra = '<link rel="stylesheet" href="/public/js/jstree/themes/default/style.min.css"/>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/jstree/jstree.min.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/edit-privilegeAlarm.js"></script>';
    	$this->mp_master->Show_Portal($content, $scriptExtra, '编辑限权', $data);
    }
    function changeUserPrivilege ()
    {
    	
//         $userId = $this->input->post('user_id');
//         $areaPrivilegeStr = $this->input->post('area_privilege');
//         $areaPrivilegeArr = explode(',', $areaPrivilegeStr);
//         $devPrivilegeStr = $this->input->post('dev_privilege');      
//         $devPrivilegeArr = explode(',', $devPrivilegeStr);       
// //        if(in_array("XJLProtocol",$devPrivilegeArr)){       
// //        	        $access="XJLProtocol";
// //        	        $getdevice=$this->mp_xjdh->Get_device2($access,$areaPrivilegeArr);        	       
// //        	        $accessid=$this->mp_xjdh->Get_user2($userId);
// //                 $method=3;                            
// //        	        foreach ($getdevice as $data_id) {
// //        	        $this->load->helper("smdthrift");
// //        	        $apiObj = new SMDThrift();       
// //        	        $accessidInt=intval($accessid->accessid);     	        
// //        	        $name = $apiObj->doorOperate(intval($data_id->data_id),$accessidInt,$method);
// //        	         }
// //        }

//         foreach ($devPrivilegeArr as $key => $val) {
//             if (! key_exists($val, Defines::$gDevModel)) {
//                 unset($devPrivilegeArr[$key]);
//             }
//         }
//         echo User::Update_UserPrivilege($userId, json_encode(explode(',', $areaPrivilegeStr)), json_encode(array_values($devPrivilegeArr)));
//         return;
        $userId = $this->input->post('user_id');
        $areaPrivilegeStr = $this->input->post('area_privilege');
        $areaPrivilegeArr = explode(',', $areaPrivilegeStr);
        $devPrivilegeStr = $this->input->post('dev_privilege'); 
        $devPrivilegeArr = explode(',', $devPrivilegeStr);
        echo User::Update_UserPrivilege($userId, json_encode(explode(',', $areaPrivilegeStr)), json_encode(array_values($devPrivilegeArr)));
        return;    
    }
    

    function logout ()
    {
        unset($_SESSION['XJTELEDH_AREA_PRIVILEGE']);
        unset($_SESSION['XJTELEDH_DEV_PRIVILEGE']);
        User::LogOutUser();
        redirect('/');
    }

    function error_page ($error_code, $error_title, $error_msg, $errSuggestionList)
    {
        $data = array();
        $data['error_code'] = $error_code;
        $data['error_title'] = $error_title;
        $data['error_msg'] = $error_msg;
        $data['errSuggestionList'] = $errSuggestionList;
        $content = $this->load->view('portal/error_page', $data, TRUE);
        $this->mp_master->Show_Portal($content, "", '错误页面', $data);
    }

    function onlineUser ()
    {
        $data = array();
        $data['actTab'] = 'users';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '人员管理';
        $bcObj->url = '/portal/usermanage';        
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '在线用户';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $data['userList'] = User::Get_AllOnlineUser();
        $content = $this->load->view('portal/online_user', $data, TRUE);
        $scriptExtra = '';
        $this->mp_master->Show_Portal($content, $scriptExtra, '在线用户', $data);
    }

    public function _get_col_letter ($num)
    {
        $comp = 0;
        $pre = '';
        $letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        if ($num > 26) {
            $comp = floor($num / 26);
            return $this->_get_col_letter($comp) . $letters[($num - $comp * 26) - 1];
        } else
            return $letters[$num - 1];
    }

    public function _set_summary_sheet (&$objActSheet, $city_code, $county_code, $substation_id, $date)
    {
        $dateArr = explode('-', $date);
        $daysOfMonth = Util::get_day($dateArr[1], $dateArr[0]);
        $devModelKeys = array();
        foreach (Defines::$gDevModelKeys as $model) {
            if (is_array($model))
                $devModelKeys = array_merge($devModelKeys, $model);
            elseif (is_string($model))
                array_push($devModelKeys, $model);
        }
        $sum1 = 0;
        $sum2 = 0;
        for ($i = 1; $i <= $daysOfMonth; $i ++) {
            $startDatetime = $date . '-' . $i;
            $count1 = $this->mp_xjdh->Get_AlarmCount($city_code, $county_code, $substation_id, false, $devModelKeys, false, array(), $startDatetime, $startDatetime);
            $sum1 += $count1;
            $objActSheet->setCellValue($this->_get_col_letter($i + 1) . 3, $count1);
            $count2 = $this->mp_xjdh->Get_AlarmCount($county_code, $county_code, $substation_id, false, Defines::$gEnvModelKeys, false, array(), $startDatetime, 
                    $startDatetime);
            $objActSheet->setCellValue($this->_get_col_letter($i + 1) . 4, $count2);
            $sum2 += $count2;
        }
        $objActSheet->setCellValue($this->_get_col_letter($i + 1) . 3, $sum1);
        $objActSheet->setCellValue($this->_get_col_letter($i + 1) . 4, $sum2);
        
        $objActSheet->getStyle('A1:' . $this->_get_col_letter($i + 1) . 4)
            ->applyFromArray($this->excelStyleArray);
    }

    public function _set_dev_sheet (&$objActSheet, $areaName, $row, $city_code, $county_code, $substation_id, $room_id, $modelKeys, $timeType, $startDatetime, 
            $endDatetime)
    {
        $sum = 0;
        $objActSheet->setCellValue('A' . $row, $areaName);
        $columnIndex = 2;
        if ($timeType == 'day') {
            foreach ($modelKeys as $model) {
                $count = $this->mp_xjdh->Get_AlarmCount($city_code, $county_code, $substation_id, $room_id, $model, false, array(), $startDatetime, $endDatetime);
                $sum += $count;
                $objActSheet->setCellValue($this->_get_col_letter($columnIndex) . $row, $count);
                $columnIndex++;
            }
        } else {
            $dateArr = explode('-', $startDatetime);
            $daysOfMonth = Util::get_day($dateArr[1], $dateArr[0]);
            $devModelKeys = array();
            foreach ($modelKeys as $model) {
                if (is_array($model))
                    $devModelKeys = array_merge($devModelKeys, $model);
                elseif (is_string($model))
                    array_push($devModelKeys, $model);
            }
            for ($i = 1; $i <= $daysOfMonth; $i ++) {
                $startDatetime = $dateArr[0] . '-' . $dateArr[1] . '-' . $i;
                $count = $this->mp_xjdh->Get_AlarmCount($city_code, $county_code, $substation_id, $room_id, $devModelKeys, false, array(), $startDatetime, 
                        $startDatetime);
                $sum += $count;
                $objActSheet->setCellValue($this->_get_col_letter($i + 1) . $row, $count);
            }
            $columnIndex = $i + 1;
        }
        $objActSheet->setCellValue($this->_get_col_letter($columnIndex) . $row, $sum);
        $objActSheet->getStyle('A1:' . $this->_get_col_letter($columnIndex) . $row)
            ->applyFromArray($this->excelStyleArray);
    }

    public function _set_level_sheet (&$objActSheet, $areaName, $row, $city_code, $county_code, $substation_id, $room_id, $startDatetime, $endDatetime)
    {
        $sum = 0;
        $objActSheet->setCellValue('A' . $row, $areaName);
        $columnIndex = 2;
        $result = $this->mp_xjdh->Get_AlarmCountGroupByLevel($city_code, $county_code, $substation_id, $room_id, false, array(), $startDatetime, $endDatetime);
        for ($i = 1; $i <= 4; $i ++) {
            $count = 0;
            foreach ($result as $rObj) {
                if ($rObj->level == $i) {
                    $count = $rObj->count;
                    break;
                }
            }
            $sum += $count;
            $objActSheet->setCellValue($this->_get_col_letter($columnIndex) . $row, $count);
            $columnIndex ++;
        }
        $objActSheet->setCellValue($this->_get_col_letter($columnIndex) . $row, $sum);
        $objActSheet->getStyle('A1:' . $this->_get_col_letter($columnIndex + 1) . $row)
            ->applyFromArray($this->excelStyleArray);
    }

    public function feedback ($status = 'unreplied')
    {
        if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin'))) {
            $this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
            return;
        }
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'users';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '人员管理';
        $bcObj->url = '/portal/usermanage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '意见反馈';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $data['status'] = $status;
        $count = $this->mp_xjdh->Get_FeedbackCount($status);
        $data['feedbackList'] = $this->mp_xjdh->Get_FeedbackList(false, $status, $offset, DEFAULT_PAGE_SIZE);
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/feedback/" . $status), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        $content = $this->load->view('portal/app_feedback', $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/js/tiny_mce/tinymce.min.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/feedback.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '用户反馈', $data);
    }

    function reply ()
    {
        $jsonRet = array();
        $feedbackId = $this->input->post('feedback_id');
        $reply = $this->input->post('reply');
        $jsonRet['ret'] = $this->mp_xjdh->Reply_Feedback($feedbackId, $reply);
        header('Content-type: application/json');
        echo json_encode($jsonRet);
    }

    function delete_reply ()
    {
        $jsonRet = array();
        $feedbackId = $this->input->post('feedback_id');
        $jsonRet['ret'] = $this->mp_xjdh->Delete_Reply($feedbackId);
        header('Content-type: application/json');
        echo json_encode($jsonRet);
    }

    function delete_feedback ()
    {
        $jsonRet = array();
        $feedbackId = $this->input->post('feedback_id');
        $jsonRet['ret'] = $this->mp_xjdh->Delete_Feedback($feedbackId);
        header('Content-type: application/json');
        echo json_encode($jsonRet);
    }

    function getDeviceByModel ()
    {
        $model = $this->input->get('model');
        $cityCode = $this->input->get('cityCode');
        $countyCode = $this->input->get('countyCode');
        $substationId = $this->input->get('substationId');
        $roomId = $this->input->get('roomId');
        $devList = $this->mp_xjdh->Get_Device_List($cityCode, $countyCode, $substationId, $roomId, false, $model, false, 'active', '', 0, 0);
        header('Content-type: application/json');
        echo json_encode($devList);
    }

    function sendalarm ()
    {
        if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin'))) {
            $this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
            return;
        }
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'alarm';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '告警管理';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '手动下发告警';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        $content = $this->load->view('portal/send_alarm', $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/portal/js/send_alarm.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '用户反馈', $data);
    }

    function addAlarmManualy ()
    {
        $data_id = $this->input->post('data_id');
        $level = $this->input->post('level');
        $signal_name = $this->input->post('signal_name');
        $signal_id = $this->input->post('signal_id');
        $subject = $this->input->post('subject');
        $ret = $this->mp_xjdh->Save_Alarm($data_id, $level, $signal_name, $signal_id, $subject);
        header('Content-type: application/json');
        echo json_encode($ret ? 'true' : 'false');
    }

    function appUpdate ()
    {
        if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin'))) {
            $this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
            return;
        }
        $data = array();
        $data['actTab'] = 'alarm';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = 'App管理';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '更新日志';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txtVersionName', '版本名称', 'trim|required');
            $this->form_validation->set_rules('txtVersionCode', '版本号', 'trim|required');
            $this->form_validation->set_rules('txtUpdateLog', '更新日志', 'trim|required');
            $ret = false;
            if ($this->form_validation->run()) {
                $version_name = $this->input->post('txtVersionName');
                $version_code = $this->input->post('txtVersionCode');
                $update_log = $this->input->post('txtUpdateLog');
                $fileName = 'xjdh-v' . $version_name . '.apk';
                $download_url = "http://" . $_SERVER['SERVER_NAME'] . '/app_download/' . $fileName;
                $this->load->library('upload');
                $config['upload_path'] = './app_download';
                $config['allowed_types'] = '*';
                $config['max_size'] = 30000;
                $config['file_name'] = $fileName;
                $this->upload->initialize($config);
                if (isset($_FILES['fUpload'])) {
                    $bRet = $this->upload->do_upload('fUpload');
                    if ($bRet) {
                        $ret = $this->mp_xjdh->Save_AppUpdate($version_code, $version_name, $download_url, $update_log);
                    }
                }
            }
            $data['ret'] = $ret;
        }
        $data['updateList'] = $this->mp_xjdh->Get_AppUpdateList();
        $content = $this->load->view('portal/app_update', $data, TRUE);
        $scriptExtra = '<script src="/public/js/bootstrap-fileupload.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, 'App更新日志', $data);
    }
    
    function SubstationformatCode (){
    	$selSubstation = $this->input->get('SubstationId');
    	$Substationcode=$this->mp_xjdh->Get_Substation($selSubstation);
    	$Substationformat=$Substationcode->Stationcode;
    	$stt=1;
    	$stt++;
    	$SubstationformatCode = vsprintf("%s%03u",array($Substationformat,$stt));
    	echo json_encode($SubstationformatCode);
    	return;
    }
    
    function editroom ($id=0)
    {
    	$data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'settings';
        $data['pageTitle'] = '编辑/添加机房信息';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '机房管理';
        $bcObj->url = '/portal/manageRoom';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $data['pageTitle'];
        $bcObj->url = '#';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    		$this->load->library('form_validation');
    		// $this->form_validation->set_rules('selSubstation', '所属局站', 'trim|required');
    		$this->form_validation->set_rules('txtName', '机房名', 'trim|required');
    	//	$this->form_validation->set_rules('txtCode', '机房编码', 'trim|required');

    		if ($this->form_validation->run() == TRUE) {
    			$substation_id = $this->input->post('selSubstation');
    			$txtCode = $this->input->post('txtCode');
    			$selSubstation = $this->input->post('selSubstation');		  			 
    			if ($id) {
    				$this->mp_xjdh->Update_Room($id, $substation_id, set_value("txtName"));
    			} else {
    				$this->mp_xjdh->Save_Room($substation_id, set_value("txtName"));
    			}  			
    			$data['successMsg'] = "保存成功";
    		} else {
    			$data['errorMsg'] = '验证失败';
    		}
    	}
    	$roomObj = $this->mp_xjdh->Get_Room_ById($id);
    	if(count($roomObj))
    	{
    		
    		$substationObj = $this->mp_xjdh->Get_Substation($roomObj->substation_id);
    		if (count($substationObj)) {
    			$roomObj->city_code = $substationObj->city_code;
    			$roomObj->county_code = $substationObj->county_code;
    		} else {
    			$roomObj->city_code = 0;
    			$roomObj->county_code = 0;
    		}    	
    		$data['roomObj'] = $roomObj;
//    		$data['substationList'] = $this->mp_xjdh->Get_Substations(false, $roomObj->county_code);
    		
    	}else{
    		$data['roomObj'] = null;
    	}
    	$data['substationList'] = $this->mp_xjdh->Gets_Substation();
     	$content = $this->load->view('portal/editroom', $data, TRUE);
    	$scriptExtra = '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/editroom.js"></script>';
    
    	$this->mp_master->Show_Portal($content, $scriptExtra, '编辑/新建机房', $data);
    }
    
    
//     public function manageRoom ()
//     {
//     	if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin'))) {
//     		$this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
//     		return;
//     	}
//     	$data = array();
//     	$data['actTab'] = 'settings';
//     	$data['bcList'] = array();
//     	$bcObj = new Breadcrumb();
//     	$bcObj->title = '系统配置';
//     	array_push($data['bcList'], $bcObj);
//     	$bcObj = new Breadcrumb();
//     	$bcObj->title = '机房管理';
//     	$bcObj->isLast = true;
//     	array_push($data['bcList'], $bcObj);
//     	$data['roomCode'] = $roomCode = $this->input->get('roomCode');
//     	$data['offset'] = $offset = intval($this->input->get('per_page'));
//     	if ($roomCode != false) {
//     		$data['count'] = 1;
//     		$roomObj = $this->mp_xjdh->Get_Room($roomCode);
//     		$data['roomList'] = array();
//     		array_push($data['roomList'], $roomObj);
//     		$data['pagination'] = '';
//     	} else {
//     		$data['count'] = $count = $this->mp_xjdh->Get_RoomCount(false, false);
//     		$data['roomList'] = $this->mp_xjdh->Get_Rooms(false, false, $offset, DEFAULT_PAGE_SIZE);
//     		$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/manageRoom"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
//     	}
//     	$content = $this->load->view('portal/manage_room', $data, TRUE);
//     	$scriptExtra = '<script src="/public/portal/js/room_manage.js"></script>';
//     	$this->mp_master->Show_Portal($content, $scriptExtra, '机房管理', $data);
//     }
    public function deleteroom (){
    	$roomid = $this->input->get('roomid');
    	$ret=$this->mp_xjdh->deleteroom($roomid);
    	echo json_encode($ret ? 'true' : 'false');
    	return;
    }
    public function manageRoom ()
    {
//         if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin'))) {
//             $this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
//             return;
//         }
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'settings';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '机房管理';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
        $data['gCounty'] = $gCounty = Defines::$gCounty;
        $data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['substationId'] = $substationId = $this->input->get('selSubstation');
        $data['keyWord'] = $keyWord = trim($this->input->get('keyWord'));
        //$data['substationList'] = $this->mp_xjdh->Get_Substations();    
        $city_code = "";
        if($this->userObj->user_role != "admin"){
        	$city_code = $this->userObj->city_code;
        }
        $export = $this->input->get('export');
        if($export == "exporttoexcel")
        {
        	require 'resources/php-excel.class.php';
        	$record_offset = 0;
        	$PAGE_SIZE=2000;
        	$xls = new Excel_XML('UTF-8', false, '机房管理');
        	$xls->addRow(array("分公司","区域","局站","机房","机房编码","地理位置","性能指标"));
        	$data['roomList'] = $roomList = $this->mp_xjdh->Get_Room_List($cityCode, $countyCode, $substationId, $offset = 0, $size = 0, $selCity, $keyWord);
        	foreach($data['roomList'] as $roomObj)
        	{
        		$xls->addRow(array(
        				Defines::$gCity[$roomObj->city_code], Defines::$gCounty[$roomObj->city_code][$roomObj->county_code], $roomObj->substation_name, $roomObj->name, $roomObj->code, $roomObj->location, $roomObj->pi_setting
        		));
        	}
        	 
        	header('Content-Type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment;filename="机房管理.xls"');
        	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        	header('Expires:0');
        	header('Pragma:public');
        	header('Cache-Control: max-age=1');
        	$xls->generateXML('机房管理');
        	return;
        }

        //转换成整形
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        
//         $data['count'] = $count = $this->mp_xjdh->Get_RoomCount($cityCode, $countyCode, $substationId, $roomId, $roomType);
//         $data['roomList'] = $this->mp_xjdh->Get_Rooms(false, false, $offset, DEFAULT_PAGE_SIZE);
        $data['count'] = $count = $this->mp_xjdh->Get_RoomCount($cityCode, $countyCode, $substationId, $city_code, $keyWord, $gCounty);
        $data['roomList'] = $roomList = $this->mp_xjdh->Get_Room_List($cityCode, $countyCode, $substationId, $offset, DEFAULT_PAGE_SIZE, $city_code, $keyWord, $gCounty);
        $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/manageRoom"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);

        $content = $this->load->view('portal/manage_room', $data, TRUE);
        $scriptExtra = '<script src="/public/portal/js/room_manage.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '机房管理', $data);
    }
    public function substation(){
//     	if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin'))) {
//     		$this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
//     		return;
//     	}
    	$data = array();
    	$data['userObj'] = $this->userObj;
    	$data['actTab'] = 'settings';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '系统配置';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '局站配置';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);
    	
    	$data['gCounty'] = $gCounty = Defines::$gCounty;
    	$data['cityCode'] = $cityCode = $this->input->get('selCity');
    	$data['countyCode'] = $countyCode = $this->input->get('selCounty');
    	$data['txtName'] = $txtName = trim($this->input->get('txtName'));
    	$data['keyWord'] = $keyWord = trim($this->input->get('keyWord'));
    	//转换成整形
    		
    	$export = $this->input->get('export');
    	if($export == "exporttoexcel")
    	{
    		require 'resources/php-excel.class.php';
    		$record_offset = 0;
    		$PAGE_SIZE=2000;
    		$xls = new Excel_XML('UTF-8', false, '局站管理');
    		$xls->addRow(array("分公司","区域","局站名","地理位置","经纬度"));
    		$data['substation'] = $this->mp_xjdh->Gets_Substation($cityCode, $countyCode, $txtName);
    		
    		
    		foreach($data['substation'] as $substationObj)
    		{
    			$xls->addRow(array(
    					$substationObj->city, $substationObj->county, $substationObj->name,$substationObj->location,$substationObj->lng.",".$substationObj->lat
    			));
    		}
    	
    		header('Content-Type: application/vnd.ms-excel');
    		header('Content-Disposition: attachment;filename="局站管理.xls"');
    		header('Cache-Control: max-age=1');
    		$xls->generateXML('局站管理');
    		return;
    	}
    	$city_code = "";
    	if($this->userObj->user_role != "admin"){
    		$city_code = $this->userObj->city_code;
    	}
    		
    	$data['offset'] = $offset = intval($this->input->get('per_page'));
    	$data['substation'] = $substationList = $this->mp_xjdh->Gets_Substation($cityCode, $countyCode, $txtName, $offset, DEFAULT_PAGE_SIZE,$city_code,$keyWord,$gCounty);
    	$data['count'] = $count = $this->mp_xjdh->Get_SubstationCount($cityCode, $countyCode, $txtName,$city_code,$keyWord,$gCounty);   	
    	$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/substation"),$count,DEFAULT_PAGE_SIZE,3,TRUE);
    	$content = $this->load->view('portal/substation', $data, TRUE);
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/substation.js"></script>';
    	$this->mp_master->Show_Portal($content, $scriptExtra, '局站管理', $data);
    }
    
    function editsubstation ($id=0, $layer=0)
    {
    	$data = array();
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'settings';
        $data['pageTitle'] = '编辑/添加局站信息';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '局站配置';
        $bcObj->url = '/portal/substation';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $data['pageTitle'];
        $bcObj->url = '#';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    		$this->load->library('form_validation');
    		$this->form_validation->set_rules('selCity', '所属分公司', 'trim|required');
    		$this->form_validation->set_rules('selCounty', '所属区域', 'trim|required');
    		$this->form_validation->set_rules('txtName', '局站名', 'trim|required');
    		$this->form_validation->set_rules('selType', '局站类型', 'trim|required');
    		$this->form_validation->set_rules('Sublocation', '局站位置', 'trim|required');    		
    		$this->form_validation->set_rules('Stationcode', '局站编码', 'trim|required');
    		if ($this->form_validation->run() == TRUE) { 
    			$cityCode = $this->input->post('selCity');
    			$countyCode = $this->input->post('selCounty');
    			$txtName = $this->input->post('txtName');
    			$selType = $this->input->post('selType');
    			$data['Lnglat'] = $Lnglat = $this->input->post('txtLnglat');
    			$Stationcode = $this->input->post('Stationcode');
    			$Sublocation = $this->input->post('Sublocation');
    			if(strlen($Stationcode)==1){
    				$Stationcodes =$Stationcode."0000";
    			}else if(strlen($Stationcode)==2){    				
    				$Stationcodes =$Stationcode."000";
    			}else if(strlen($Stationcode)==3){
    				$Stationcodes =$Stationcode."00";
    			}else if(strlen($Stationcode)==4){
    				$Stationcodes =$Stationcode."0";
    			}else if(strlen($Stationcode)==5){
    				$Stationcodes =$Stationcode;
    			}
    			foreach (Defines::$gCity as $key=> $val){
    				if($key==$cityCode){
    					$cityname=$val;
    				}
    			}
    			foreach (Defines::$gCounty as $key=> $val){
    				foreach ($val as $keys=> $vals){
	    				if($keys == $countyCode){
	    					$gCountyname=$vals;
	    				}
    				}    				
    			}
    			foreach (Defines::$gCountyCode as $key=> $val){
    				foreach ($val as $keys=> $vals){
    					if($keys == $countyCode){
    						$gCountycode=$vals;
    					}
    				}
    			}
    			if ($id) {   			
    			$this->mp_xjdh->Update_substation($id,$cityCode,$cityname,$countyCode,$gCountyname, $txtName,$selType, $Stationcodes, $Lnglat, $gCountycode, $Sublocation);
    			} else {  
    				$this->mp_xjdh->Saves_Substation($cityCode,$cityname,$countyCode,$gCountyname, $txtName, $selType, $Stationcodes, $Lnglat, $gCountycode, $Sublocation);
    			}
    			$data['successMsg'] = "保存成功";
    		}
    	} 

    	if($id){
        	$data['substation']=$this->mp_xjdh->Get_Substation($id);
    	    $data["lng"] = $lng = $data['substation']->lng;
    	    $data["lat"] = $lat = $data['substation']->lat;
    	} else{
    		$data["lng"] = $lng = "0";
    		$data["lat"] = $lat = "0";
    	}
    	$data["layer"] = $layer;$data["id"] = $id;
    	
    	$content = $this->load->view('portal/editsubstation', $data, TRUE);
    	$scriptExtra .= '<link rel="stylesheet" href="/public/css/fancybox.css"/>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/editsubstation.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/substation.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/jquery.fancybox-1.3.1.pack.js"></script>';
    	
    	$scriptExtra .= '<link rel="stylesheet" href="http://cache.amap.com/lbs/static/main.css?v=1.0"/>';
    	$scriptExtra .= '<script src="http://webapi.amap.com/maps?v=1.3&key=641ca6419da7b27414bdfaa899e5fd6e&plugin=AMap.PlaceSearch,AMap.AdvancedInfoWindow"></script>';
    	$scriptExtra .= '<script src="http://webapi.amap.com/js/marker.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="http://webapi.amap.com/demos/js/liteToolbar.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/substationmap.js"></script>';
    	
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/jqthumb.js"></script>';
    	$this->mp_master->Show_Portal($content, $scriptExtra, '编辑/新建局站', $data);
    }
    
    
    function showsubstation ($layer=0)
    {
    	$data = array();
        $data['actTab'] = 'settings';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '局站配置';
        $bcObj->url = '/portal/substation';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '局站位置';
        $bcObj->url = '###';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);

    	$lng = array(); $lat = array();$name = array();
    	$data['count'] = $count = $this->mp_xjdh->Get_Substation_Lnglat_Count();
    	$data['substation'] = $substation = $this->mp_xjdh->Get_Substation_Lnglat_List();
    	foreach($substation as $key=>$val){
    		array_push($lng,$val->lng);
    		array_push($lat,$val->lat);
    		array_push($name,$val->name);
    	}
     	$data["lng"] = $lng; $data["lat"] = $lat;
    	$data["name"] = $name;  $data["layer"] = $layer;	
    	
    	$content = $this->load->view('portal/showsubstation', $data, TRUE);
    	$scriptExtra .= '<link rel="stylesheet" href="/public/css/fancybox.css"/>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/editsubstation.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/substation.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/jquery.fancybox-1.3.1.pack.js"></script>';
    	 
    	$scriptExtra .= '<link rel="stylesheet" href="http://cache.amap.com/lbs/static/main.css?v=1.0"/>';
    	$scriptExtra .= '<script src="http://webapi.amap.com/maps?v=1.3&key=641ca6419da7b27414bdfaa899e5fd6e&plugin=AMap.PlaceSearch,AMap.AdvancedInfoWindow"></script>';
    	$scriptExtra .= '<script src="http://webapi.amap.com/js/marker.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="http://webapi.amap.com/demos/js/liteToolbar.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/showsubstation.js"></script>';
    	 
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/jqthumb.js"></script>';
    	$this->mp_master->Show_Portal($content, $scriptExtra, '编辑/新建局站', $data);
    }
    
    
    
    function editsubstationGather ($id = 0, $layer=0)
    {
    	$data = array();
    	$data['userObj'] = $this->userObj;
    	$data['actTab'] = 'settings';
    	$data['pageTitle'] = '添加图片';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '系统配置';
    	$bcObj->url = '#';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '局站采集';
    	$bcObj->url = '/portal/station_image_manage';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = $data['pageTitle'];
    	$bcObj->url = '#';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    		$data['txtName1'] = $txtName1 = $this->input->post('txtName1');
    		$data['explain'] = $explain = $this->input->post('explain');
    		if($id){			
    		    	$File_Path="./public/portal/Station_image/";
    	            for($i=0;$i<count($_FILES[ufile][name]);$i++){
    	            $_FILES[ufile][name][$i]=time().$_FILES[ufile][name][$i];  
    	            //$_FILES[ufile][name][$i]=time().substr(strrchr($_FILES[ufile][name][$i], '.'), 0);
    	             }
    	             $fileName=$_FILES[ufile][name];
    	             $filet=$_FILES[ufile][tmp_name];
    	             $filet[size]>"5000000";
    	           $result = $this->mp_xjdh->Up_Imgsubstation($id,$fileName,$txtName1,$explain);
    	           if($result == true){
    	            for($i=0;$i<count($fileName);$i++){
    	            	move_uploaded_file($filet[$i],$File_Path.$fileName[$i]);
    	             }
    	             if($result){
    	             	//$a=system ("ffmpeg -i ./public/portal/Station_image/1477363873.flv -f image2 -ss 2 -t 0.001 -s 300x200 ./public/portal/Station_image/2222.jpg ");
    	             	$data['successMsg'] = '操作成功。<a href="/portal/station_image_manage">返回</a>';
    	             	
    	             }else{
    	             	$data['successMsg'] = '操作失败！';
    	             }           
    	             
    	           }
    		         //$this->mp_xjdh->up_imgsubstation($id,$filename,$txtname1); 
    		   }
    	}
    	$data['stationimg'] = $this->mp_xjdh->Get_stationimgs();
    	$data['stationimGnewGrouping'] =$stationimGnewGrouping = $this->mp_xjdh->Get_stationimGnewGrouping($id);
    	$content = $this->load->view('portal/editsubstationGather', $data, TRUE);
    	$scriptExtra .= '<link rel="stylesheet" href="/public/css/fancybox.css"/>';
//     	$scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
//     	$scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/editsubstation.js"></script>';
//     	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/Copy of stationGather.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/substation.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/jquery.fancybox-1.3.1.pack.js"></script>';
//     	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/jqthumb.js"></script>';
    	$this->mp_master->Show_Portal($content, $scriptExtra, '编辑/新建局站', $data);
    }
    function DeleteImgFile(){   	
    	$this->load->helper('file');
    	$array=array();
    	$stationimg = $this->input->get('stationimg');
    	foreach ($stationimg as $stationimgObj){
    		array_push($array, $stationimgObj['stationImage']);
    	}
    	$controllers = get_filenames('./public/portal/Station_image/');
    	foreach ($controllers as $controllersObj){
    		if(!in_array($controllersObj,$array)){
    			$ret = unlink('./public/portal/Station_image/'.$controllersObj);
    		}
    	}
    	echo json_encode($ret ? 1 : 0);
    	return;
    }
    function updat_Stationimage($id = 0){
    	$data = array();
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '编辑图片';
    	$bcObj->url = '/portal/station_image_manage';
    	array_push($data['bcList'], $bcObj);
    	$data['value'] = $this->mp_xjdh->Get_Stationimage($id);
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    		$data['txtName1'] = $txtName1 = $this->input->post('txtName1');
    		$data['explain'] = $explain = $this->input->post('explain');
    		if($id){   			
    			if($_FILES[ufile][name] != ''){  				
    			$config['upload_path'] = './public/portal/Station_image/';
    			$config['allowed_types'] = 'gif|jpg|png|flv';
    			$config['file_name'] = time();
    			$config['max_size'] = 500000; 
    			$config['encrypt_name'] = true;
    			$this->load->library('upload', $config);
    			$this->upload->do_upload('ufile'); 
    			$fileName =	$this->upload->data('file_name');
    			if($this->upload->display_errors() == ''){
    				unlink('./public/portal/Station_image/'.$data['value']->stationImage);
    			}
    			}
    			$result = $this->mp_xjdh->Up_Stationimage($id,$fileName,$txtName1,$explain);
    				if($result){
    				$data['successMsg'] = '操作成功。<a href="/portal/station_image_manage">返回</a>';
    				}else{
    					$data['successMsg'] = '操作失败！';
    				}
    		}
    	}
    	$content = $this->load->view('portal/editStationimage', $data, TRUE);
    	$this->mp_master->Show_Portal($content, $scriptExtra, '编辑图片', $data);
    }
    function Delete_substation($id = 0){
         
    	$substationid=$this->input->get('substationid');
    	$ret=$this->mp_xjdh->Delete_substation($substationid);
    		echo json_encode($ret ? 'true' : 'false');
    		return;
    }
    function updat_esubstation($id){
    	$substationid=$this->input->get('substationid');
    	$data['ret']=$this->mp_xjdh->Delete_substation($substationid);
    	echo json_encode();
    	return;
    }
    function saveRoomPi()
    {
        $room_id = $this->input->post('room_id');
        $pi_setting = $this->input->post('pi_setting');
        $ret = $this->mp_xjdh->Save_RoomPi($room_id, $pi_setting);
        header('Content-type: application/json');
        echo json_encode($ret ? 'true' : 'false');
    }

    function dynamicSetting ($data_id)
    {
        if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin'))) {
            $this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
            return;
        }
        $data = array();
        $data['actTab'] = 'settings';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '机房管理';
        $bcObj->url = '/portal/manageRoom';        
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '机房性能动态配置';
        $bcObj->isLast = true;
        
        array_push($data['bcList'], $bcObj);
        $data['devDcList'] = $this->mp_xjdh->Get_DeviceDynamicConfig($data_id);
        $data['devObj'] = $devObj = $this->mp_xjdh->Get_Device($data_id);
        $data['devList'] = $this->mp_xjdh->Get_Device_List(false, false, $devObj->substation_id, false, false, false, false, 'active', '', 0, 0);
        $content = $this->load->view('portal/dynamic_setting', $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/insertsome.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/dynamic_setting.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '机房性能动态配置', $data);
    }

    function Get_SignalNameId()
    {
        $model = $this->input->get('model');
        $signalList = array();
        if(isset(Defines::$signalName[$model]))
        {             	   
            foreach(Defines::$signalName[$model] as $key=>$val)
            {
                $signalObj = new stdClass();
                $signalObj->key = $key;
                $signalObj->name = $val;
                array_push($signalList, $signalObj);
            }   
        }
        header('Content-type: application/json');
        echo json_encode($signalList);
        return;
        
    }
    function getDeviceSignal ()
    {
        $model = $this->input->get('model');
        $signalList = array();
        foreach (Defines::$gDeviceSignal[$model] as $key => $val) {
            $signalObj = new stdClass();
            $signalObj->key = $key;
            $signalObj->name = $val;
            array_push($signalList, $signalObj);
        }
        header('Content-type: application/json');
        echo json_encode($signalList);
    }

    function deleteDynamicConfig ()
    {
        $dc_id = $this->input->post('dc_id');
        $this->mp_xjdh->Delete_DeviceDynamicConfig($dc_id);
        $this->load->helper("smdthrift");
        $apiObj = new SMDThrift();
        $devObj = $this->mp_xjdh->Get_Device($data_id);
        if (0 == $apiObj->RefreshVDevice($devObj->smd_device_no)) {
            $ret = 1;
        } else {
            $ret = 0;
        }
        header('Content-type: application/json');
        echo json_encode('true');
    }

    function batch_end_alarm ()
    {    	
    	$alarmListId = $this->input->post('alarmListId'); 
    	//$arrayid=explode(",",$alarmListId);
    	//echo $this->mp_xjdh->Batch_Alert($arrayid);
    	echo $this->mp_xjdh->Batch_Alert($alarmListId);
    }
    
    function saveDynamicConfig ()
    {
        $dc_id = $this->input->post('dc_id');
        $data_id = $this->input->post('data_id');
        $dc_name = $this->input->post('dc_name');
        $dc_script = $this->input->post('dc_script');
        $ret = $this->mp_xjdh->Save_DeviceDynamicConfig($dc_id, $data_id, $dc_name, $dc_script, null);
        if ($ret) {
            $this->load->helper("smdthrift");
            $apiObj = new SMDThrift();
            $devObj = $this->mp_xjdh->Get_Device($data_id);
            if (0 == $apiObj->RefreshVDevice($devObj->smd_device_no)) {
                $ret = 1;
            } else {
                $ret = 0;
            }
        }
        header('Content-type: application/json');
        echo json_encode($ret ? 'true' : 'false');
    }

    function saveDynamicConfigRule ()
    {
        $dc_id = $this->input->post('dc_id');
        $data_id = $this->input->post('data_id');
        $dc_config = $this->input->post('dc_config');
        $ret = $this->mp_xjdh->Save_DeviceDynamicConfig($dc_id, false, false, false, $dc_config);
        if ($ret) {
            $this->load->helper("smdthrift");
            $apiObj = new SMDThrift();
            if (0 == $apiObj->DeviceDynamicSettingChange($data_id)) {
                $ret = 1;
            } else {
                $ret = 0;
            }
        }
        header('Content-type: application/json');
        echo json_encode($ret ? 'true' : 'false');
    }
    public function test_thrift()
    {
    	$data_id = $this->input->post('id');
    	$this->load->helper("smdthrift");
    	$apiObj = new SMDThrift(); 
    	$name = $apiObj->DeviceCatchPicture($data_id);
    	if ($name!= -1 && $name!= -2) {    
    		echo $name;    
    	} else {
        		echo json_encode(0);    
    	}  
    	return;  
    }
    
    public function test_bool()
    {
    	$data_id = $this->input->post('id');
    	$this->load->helper("smdthrift");
    	$apiObj = new SMDThrift();
		$state = $apiObj->IsCatPicOk($data_id);
    	if ($state == 1) {
    		echo json_encode(1);
    	}else {
    		echo json_encode(0);
    	}
		return;
    }
    public function cameraOperate()    
    {    
    	$preTime = $this->input->post('time');    
    	$data_id = $this->input->post('data_id');    
    	$mode = $this->input->post('mode');    
    	$this->load->helper("smdthrift");    
    	$apiObj = new SMDThrift();    
    	$back = $apiObj->cameraOperate($preTime,$data_id,$mode);    
    	if ($back != -1 && $back != -2) {    
    		echo $back;    
    	} else {    
    		echo json_encode(0);    
    	}    
    	return;
    }
    
    public function isCameraOpOk()    
    {    
    	$data_id = $this->input->post('data_id');    
    	$mode = $this->input->post('mode');    
    	$this->load->helper("smdthrift");    
    	$apiObj = new SMDThrift();    
    	$back = $apiObj->isCameraOpOk($data_id,$mode);    
    	if ($back != -1 && $back != -2) {    
    		echo $back;    
    	}else {    
    		echo json_encode(0);    
    	}    
    	return;    
    }

    public function Get_cache(){    	
    	$dataid=$this->input->get("data_id");   	
    	 $cache=realtime::Get_ACCESScache($dataid);
    	 var_dump($cache).die;
    }
    public function Get_zxdu_cache(){
    	
    	$dataid=$this->input->get("data_id");
    	$zxduname=$this->input->get("zxduname");
    	if($zxduname=="zxdu-dc"){
    		$data['spsDcList']=realtime::Get_zxduDCcache($dataid);
    	}else if($zxduname=="zxdu-rc"){
    		$data['spsRcList']=realtime::Get_zxduRCcache($dataid);
    	}else if($zxduname=="zxdu-ac"){    	
    		$data['spsAcList']=realtime::Get_zxduACcache($dataid);
    	}    	
    	 echo json_encode($data);
        return;
    }
    public function insert_white(){
    	$dataId = $this->input->post("data_id");
    	$data["result"] = $this->mp_xjdh->Insert_White($dataId);  
    	echo json_encode($data);
    	return;
    }
    public function GetRoomDevice(){
    	
    	if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin'))) {
    		$this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
    		return;
    	}
    	$data = array();
    	$data['actTab'] = 'settings';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '系统配置';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '数据库一致性检查';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);
    	$data['devModelGroup'] = $this->_get_device_modelGroup();
    	$data['RoomDeviceObj'] = $devObj = $this->mp_xjdh->Get_room_device();
    	$data['SmdDeviceObj'] = $devObj = $this->mp_xjdh->Get_sdevice_device();
    	$data['RoomSmdDeviceObj'] = $devObj=$this->mp_xjdh->Get_room_smd_device();
    	$content = $this->load->view('portal/discord', $data, TRUE);
    	$scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/device_manage.js"></script>';
    	$this->mp_master->Show_Portal($content, $scriptExtra, '局站管理', $data);
    }
    public function GetDataID(){
    	 
    	if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin'))) {
    		$this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
    		return;
    	}
    	$data = array();
    	$data['actTab'] = 'settings';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '系统配置';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '数据ID检查';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);
    	$data['cityCode'] = $cityCode = $this->input->get('selCity');
    	$data['countyCode'] = $countyCode = $this->input->get('selCounty');
    	$data['substationId'] = $substationId = $this->input->get('selSubstation');
    	$data['roomId'] = $roomId = $this->input->get('selRoom');
    	$data['deviceNo'] = $deviceNo = $this->input->get('selSmdDev');
    	$data['deviceidList'] = $devObj = $this->mp_xjdh->Get_dataid_list($cityCode, $countyCode, $substationId, $roomId, $deviceNo);
    	foreach ($data['deviceidList'] as $v)
    	{
    		$number = $v->rank;
    		$head = $cityCode << 22;
    		$head = sprintf('%u', $head);
    		$mid = $deviceNo << 10;
    		$dataid = $head + $mid + $number;
    		$v->new_data_id = $dataid;
    	}
    	$content = $this->load->view('portal/get_data_id', $data, TRUE);
    	
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
//     	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/device_manage.js"></script>';
    	$this->mp_master->Show_Portal($content, $scriptExtra, '局站管理', $data);
    }
    
    public function count_device()
    {
    	$smd_device_no = $this->input->post('smdid');
    	$count = $this->mp_xjdh->count_device($smd_device_no);
    	$count = $count + 1;
    	echo $count;
    	return;
    }
    public function Get_Max_data_id()
    {
    	$data = array();
    	$smd_device_no = $this->input->post('smdid');
    	$city = $this->input->post('city');
    	$ret =  $this->mp_xjdh->Get_Max_data_id($smd_device_no);
    	if(!$ret->data_id){
    		$head = $city << 22;
                //var_dump("aa").die;
    		$var = sprintf('%u', $head);
    		$mid = $smd_device_no << 10;
    		$i = 1;
    		$ret = $var+$mid+$i;
    	}else{
    		$ret = $ret->data_id + 1;
    	}
        do{
            $devObj = $this->mp_xjdh->Get_Device($ret);
            if(count($devObj) == 0)
                break;
            $ret++;
        }while(true);
    	$data['dataId'] = array('max_data_id' => $ret);
    	echo json_encode($data);
    	return;
    }
    public function station_thumb($fileName)
    {
    	$fileName = urldecode($fileName);
    	$this->load->library("ImageResize",array("filename"=>"./public/portal/Station_image/".$fileName));
    	$this->imageresize->resizeToWidth(200)->output();
    }
    public function station_image_manage(){  
//     	if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin'))) {
//     		$this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
//     		return;
//     	}

//     	ini_set('display_errors','on');
//     	error_reporting(E_ALL);
    	$data = array();
    	$data['userObj'] = $this->userObj;
    	$data['actTab'] = 'settings';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '系统配置';
    	$bcObj->url = '/portal/station_image_manage';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '局站采集';
    	$bcObj->isLast = true;
    	array_push($data['bcList'], $bcObj);

    	$data['idimg'] = $id = $this->input->get('substationid');
    	$data['txtName'] = $txtName = trim($this->input->get('txtName'));
    	$data['selCity'] = $selCity = $this->input->get('selCity');
    	$data['selCounty'] = $selCounty = $this->input->get('selCounty');
    	$city_code = "";
    	if($this->userObj->user_role != "admin"){
    		$city_code = $this->userObj->city_code;
    	}
    	$data['offset'] = $offset = intval($this->input->get('per_page'));
//      $data['count'] = $count = $this->mp_xjdh->Get_SubstationGatherCount();
//     	if($selCity)
//     	$dbObj->where('city_code',$selCity);
    	$data['substationGather'] = $substationGather= $this->mp_xjdh->Get_station($txtName, $selCity, $selCounty, $city_code,$offset, 20);
    	$counts = $this->mp_xjdh->Get_station_count($txtName, $selCity, $selCounty, $city_code);
    	$substationList = array();
    	$this->load->library('image_lib');
    	foreach ($substationGather as $substationGatherObj){
    		$count = $this->mp_xjdh->Count_Img($substationGatherObj->id);
    		$img = $this->mp_xjdh->get_Imgs($substationGatherObj->id);
    		$arrimg = array();
    		$i = 0;
             foreach ($img as $stationImageObj){
             	$i = $i+1;
             	if($i<4){
             	    array_push($arrimg,$stationImageObj->stationImage);
             	}
             }
    		$array = array(
    				'id' => $substationGatherObj->id,
    				'sys_id' => $substationGatherObj->sys_id,
    				'city' => $substationGatherObj->city,
    				'city_code' => $substationGatherObj->city_code,
    				'county' => $substationGatherObj->county,
    				'county_code' => $substationGatherObj->county_code,
    				'name' => $substationGatherObj->name,
    				'type' => $substationGatherObj->type,
    				'lng' => $substationGatherObj->lng,
    				'lat' => $substationGatherObj->lat,
    				'settings' => $substationGatherObj->settings,
    				'Stationcode' => $substationGatherObj->Stationcode,
    				'stationImage' => $substationGatherObj->stationImage,
    				'UploadTime' => $substationGatherObj->UploadTime,
    				'count' => $count,
    				'img' => $arrimg
    				);
    		array_push($substationList, $array);
    	}
    	$data['substationList'] = $substationList;
    	$data['count'] = $counts;
    	if($id){
    	$data['substationGatherimg'] =$substationGatherimg = $this->mp_xjdh->Get_stationimg($id);
    	$data['stationimGnewGrouping'] =$stationimGnewGrouping = $this->mp_xjdh->Get_stationimGnewGrouping($id);
    	}
    	$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/station_image_manage"),$counts,20,3,TRUE);
    	$content = $this->load->view('portal/station_image_manage', $data, TRUE);
     	//$scriptExtra .= '<link rel="stylesheet" href="/public/css/fancybox.css"/>';
    	$scriptExtra .= '<link rel="stylesheet" href="/public/css/easydialog.css"/>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/station_image_manage.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/easydialog.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/substation.js"></script>';
    	
    	$scriptExtra .= '<link rel="stylesheet" href="/public/css/minimalist.css"/>';
    	$scriptExtra .= '<link rel="stylesheet" href="/public/css/jquery.fancybox.css"/>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/flowplayer.min.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/flowplayer.hlsjs.min.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.fancybox.js"></script>';
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/player.js"></script>';
    	
    	$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/jqthumb.js"></script>';
    	$this->mp_master->Show_Portal($content, $scriptExtra, '局站采集管理', $data);
    }
    public function ajaxStationGather(){
    	$id =$this->input->get('id');
    	$data['stationImage']=$this->mp_xjdh->Get_SubstationGatherCount($id);
    	echo json_encode($data);
    	return;
    }
    public function virtual_device_manage()
    {
    	if (! in_array($_SESSION['XJTELEDH_USERROLE'], array('admin'))) {
    		$this->error_page('404', '错误信息', '找不到您所要的页面！！！', array());
    		return;
    	}
    	$data = array();
    	$data['actTab'] = 'settings';
    	$data['bcList'] = array();
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '系统配置';
    	array_push($data['bcList'], $bcObj);
    	$bcObj = new Breadcrumb();
    	$bcObj->title = '虚拟设备检查';
    	array_push($data['bcList'], $bcObj);
    	$bcObj->isLast = true;
    	$data['roomList'] = $roomList =  $this->mp_xjdh->Get_Rooms();
    	$data['i'] = 0;
    	$data['j'] = 0;
    	$data['k'] = 0;
    	$data['x'] = 0;
    	$data['y'] = 0;
    	$data['z'] = 0;
    	$data['errorMsg'] = '处理失败';
    	$data['successMsg'] = '处理成功';
    	$data['fine'] = '无需处理';
    	foreach ($roomList as $roomObj)
    	{
    		$room_id = $roomObj->id;
    		$venv_device = $this->mp_xjdh->Get_venv($room_id);
    		if(!$venv_device)
    		{
    			$smd_device =  $this->mp_xjdh->Get_smd_device($room_id);
    			if($smd_device)
    			{
    				$smd_device_no = $smd_device->device_no;
    				$count = $this->mp_xjdh-> Get_Max_data_id($smd_device_no);
    				if($count->data_id == 0)
    				{
    					$city =  $this->mp_xjdh->Get_city_code($room_id);
    					$city_code = $city->city_code;
    					$head= $city_code << 22;
    					$head = (float) sprintf('%u', $head);
    					$mid = $smd_device->device_no << 10;
    					$data_id = $head + $mid + 1;
    				}
    				else{
    					$data_id = $count->data_id + 1;
    				}   				
    				$name = '机房环境';
    				$add = $this->mp_xjdh->Add_venv($smd_device_no, $room_id, $name, $data_id,$active == 'active');
    				if($add)
    				{
    					$device_model = array('temperature','humid','smoke','water');
    					$write_group = $this->mp_xjdh->add_enviroment_devgroup($room_id,$data_id,$device_model);
    					if($write_group)
    					{
    						$data['i']++;
    					}else{
    						$data['j'] ++;
    					}
    				}
    			}
    		}
    		else{
    			$data['k']++;
    		}
    		$vcam_device = $this->mp_xjdh->Get_vcam($room_id);
    		if(!$vcam_device)
    		{
    			$smd_device =  $this->mp_xjdh->Get_smd_device($room_id);
    			if($smd_device)
    			{
    				$smd_device_no = $smd_device->device_no;
    				$count = $this->mp_xjdh-> Get_Max_data_id($smd_device_no);
    				if($count->data_id == 0)
    				{
    					$city =  $this->mp_xjdh->Get_city_code($room_id);
    					$city_code = $city->city_code;
    					$head= $city_code << 22;
    					$head = (float) sprintf('%u', $head);
    					$mid = $smd_device->device_no << 10;
    					$data_id = $head + $mid + 1;
    				}
    				else{
    					$data_id = $count->data_id + 1;
    				} 
    				$name = '监控设备';
    				$add = $this->mp_xjdh->Add_vcam($smd_device_no, $room_id, $name, $data_id,$active == 'active');
    				if($add)
    				{
    					$write_group = $this->mp_xjdh->add_camera_devgroup($room_id,$data_id);
    					if($write_group)
    					{
    						$data['x']++;
    					}else{
    						$data['y'] ++;
    					}
    				}
    			}
    		}
    		else{
    			$data['z']++;
    		}
    	}
    	$content = $this->load->view('portal/virtual_device_manage', $data, TRUE);
    	$this->mp_master->Show_Portal($content, $scriptExtra, '虚拟设备检查', $data);
    }
   function DeleteImg(){   	 
   	  $imgName = $this->input->get('imgName');
   	  $imgNameResult = $this->mp_xjdh->get_Img($imgName);
   	  unlink('./public/portal/Station_image/'.$imgNameResult->stationImage);
   	  echo $this->mp_xjdh->Delete_Img($imgName);
   	  return;
   }
   function xunishebei()
   {
   		$data['vdevice'] = $this->mp_xjdh->get_vdevice();
   		foreach ($data['vdevice'] as $vObj)
   		{
   			$data['room'] = $this->mp_xjdh->Get_room_name($vObj->room_id);
   			$name = $data['room']->name . $vObj->name;
   			$ret = $this->mp_xjdh->set_vdevice_name($vObj->data_id,$name);
   		}
   		$data['vdevice_tele'] = $this->mp_xjdh->get_vdevice_tele();
   		foreach ($data['vdevice_tele'] as $vObj)
   		{
   			$data['room'] = $this->mp_xjdh->Get_room_name($vObj->room_id);
   			$name = $data['room']->name . $vObj->name;
   			$ret = $this->mp_xjdh->set_vdevice_name_tele($vObj->data_id,$name);
   		}
   }

   function part_user_auth(){
       /*if(!User::IsUserHasPermission($this->userObj->id, "权限管理")) {
           redirect("admin");
       }*/
       $data = array();
       $data['actTab'] = "users";
        
       $data['userName'] = $userName = trim($this->input->get('userName'));
       $data['fullName'] = $fullName = trim($this->input->get('txtFullName'));
       $data['idNumber'] = $idNumber = $this->input->get('txtIDNumber');
       $data['offset'] = $offset = $this->input->get('per_page');
       $city_code = "";
       if($this->userObj->user_role != "admin"){
       	$city_code = $this->userObj->city_code;
       }
       
       $data['actLi'] = 'part_user_auth';
       $data['pageTitle'] = "模块权限管理";
       $data['bcList'] = array();
       $bcObj = new Breadcrumb();
       $bcObj->title = '人员管理';
       $bcObj->url = '/portal/usermanage';        
       array_push($data['bcList'], $bcObj);
       $bcObj = new Breadcrumb();
       $bcObj->title = $data['pageTitle'];
       $bcObj->isLast = true;
       array_push($data['bcList'], $bcObj);
       $dateStart = $dateEnd = false;
       if ($txtDateRange) {
           $dateArr = explode(' -', $txtDateRange);
           $dateStart = $dateArr[0];
           $dateEnd = $dateArr[1];
       }
       $data['count'] = $count = User::Get_PartUserCount($userName, $fullName, $idNumber, $city_code);  
       $data['userList'] = User::Get_PartUserList($userName, $fullName, $idNumber, $offset, DEFAULT_PAGE_SIZE, $city_code);
       $data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/part_user_auth"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
       $content = $this->load->view('portal/part_user_auth', $data, TRUE);
       $scriptExtra = '<script type="text/javascript" src="/public/admin/j/part-user-auth.js"></script>';
       $this->mp_master->Show_Portal($content, $scriptExtra, '权限管理', $data);
   }

   function Get_Sev_Name(){
   	$roomid = $this->input->get('roomid');
   	$data['denName'] = $this->mp_xjdh->Get_SevName($roomid);
   	echo json_encode($data);
   	return;
   }
   function Query_master(){
   	$data = array();
   	if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){
   	    $substation = $this->mp_xjdh->Gets_SubstationForMaster();
   	}else if($_SESSION['XJTELEDH_USERROLE'] == 'noc' || $_SESSION['XJTELEDH_USERROLE'] == 'member' || $_SESSION['XJTELEDH_USERROLE'] == 'operator'){
   	    $privaligeObj = User::Get_UserPrivilege($_SESSION['XJTELEDH_USERID']);
   	    $substation = $this->mp_xjdh->Gets_SubstationForMaster(false,json_decode($privaligeObj->area_privilege));
   	}else if($_SESSION['XJTELEDH_USERROLE'] == 'city_admin'){
   	    $allcityList = Defines::$gCity;
   	    $privaligeObj = User::Get_UserPrivilege($_SESSION['XJTELEDH_USERID']);
   	    $substation = $this->mp_xjdh->Gets_SubstationForMaster(array($privaligeObj->city_code));
   	}
   foreach ($substation as $substationObj){
   		$arr = array(
   				'label' => $substationObj->Stationcode.$substationObj->name,
   				'desc' => $substationObj->name
   				);
   		array_push($data, $arr);
   	}
   	echo json_encode($data);
   	return;
   }
   function edit_user_auth($uid=0){
       //初始化页面
       //处理post
       //处理有uid
       //处理验证，成功则修改数据库，否则显示失败
   
       //处理没有uid，错误请求
       //处理非post
       //有uid，则显示当前数据；否则非法请求
       $data = array();
       $data['gUserAuth'] = Defines::$gUserAuth;
   
       if($_SERVER['REQUEST_METHOD'] == "POST"){
           $this->load->library('form_validation');
           if(TRUE){
               if($uid){
                   $userObj = User::GetUserById($uid);
                   if(!$userObj){
                       redirect('/portal/part_user_auth');
                   }
                   //更新权限表
                   //foreach($keyArr as $index => $key){
                   // 					$value = $valArr[$index];
                       //Do save Majors
   
                       $mIdArray = array();
                       for($mi=1;$mi<20;$mi++)
                       {
                       $pKey = $this->input->post('cbFirstAuth'.$mi);
                       $pValue = $this->input->post('cbSecondAuth'.$mi);
                           if($pKey){
                               if($pValue){
                               foreach($pValue as $v){
                               $mId = User::UpdateAuth($uid,$pKey,$v);
                               array_push($mIdArray, $mId);
                   }
       }
       }
       }
   
					if(count($mIdArray)){
						User::Clear_Auth($uid,$mIdArray);
       }
       $data['msg'] = "保存权限成功";
       }
       }
   
       }
        $data['userObj'] = $this->userObj;
        $data['actTab'] = 'users';
        $data['pageTitle'] = '编辑模块权限管理';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '人员管理';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '权限管理';
        $bcObj->url = '/portal/part_user_auth';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $data['pageTitle'];
        $bcObj->url = '#';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
   
       if ($uid){
           $data['authArr'] = array();
           $data['userObj'] = $userObj = User::GetUserById($uid);//var_dump($userObj->id);
           $data['authList'] = User::GetAuthListAll($userObj->id);
           // 			$data['authListAll'] = User::GetAuthListAll($userObj->id);
           foreach($data['authList'] as $authObj){
				array_push($data['authArr'],$authObj->first_auth);
				array_push($data['authArr'],$authObj->second_auth);
			}
		}
   
		$content = $this->load->view('portal/edit_user_auth', $data, TRUE);
   		$scriptExtra = '<script type="text/javascript" src="/public/portal/js/edit-user-auth.js"></script>';
   		$this->mp_master->Show_Portal($content, $scriptExtra, '修改用户权限', $data);
   	}
   	
   	function spdev_manages(){ 	
   		$data = array();
   		$data['actTab'] = 'settings';
   		$data['bcList'] = array();
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '系统配置';
   		array_push($data['bcList'], $bcObj);
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '协议管理';
   		$bcObj->isLast = true;  		
   		array_push($data['bcList'], $bcObj);	
   		$data['name'] = $name = trim($this->input->get('name'));
        $data['baud_rate'] = $baud_rate = $this->input->get('baud_rate');
   		$data['cmd'] = $cmd = trim($this->input->get('cmd'));
   		$data['reply'] = $reply = trim($this->input->get('reply'));
   		$data['offset'] = $offset = intval($this->input->get('per_page'));

   		$export = $this->input->get('export');
   		if($export == "exporttoexcel")
   		{
   			require 'resources/php-excel.class.php';
   			 
   			$record_offset = 0;
   			$PAGE_SIZE=2000;
   			$xls = new Excel_XML('UTF-8', false, '协议管理');
   			$xls->addRow(array("智能设备型号","波特率","发送命令","接受回复"));
   			$data['spedvlist'] = $spedvlist = $this->mp_xjdh->spdevManage($name,$baud_rate,$cmd,$reply);
   			foreach($data['spedvlist'] as $spedvObj)
   			{
   				$xls->addRow(array(
   						$spedvObj->name, $spedvObj->baud_rate, $spedvObj->cmd, $spedvObj->reply
   				));
   			}
   			 
   			header('Content-Type: application/vnd.ms-excel');
   			header('Content-Disposition: attachment;filename="协议管理.xls"');
   			header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
   			header('Expires:0');
   			header('Pragma:public');
   			header('Cache-Control: max-age=1');
   			$xls->generateXML('协议管理');
   			return;
   		}
   		$data['spedvlist'] = $this->mp_xjdh->spdevManage($name,$baud_rate,$cmd,$reply,$offset,DEFAULT_PAGE_SIZE);  		
   		$data['count'] = $count = $this->mp_xjdh->Get_Spdev_Count($name,$baud_rate,$cmd,$reply);
   		$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/spdev_manages"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);   		
   		$content = $this->load->view('portal/spedv_Manage', $data, TRUE);   		
   		$scriptExtra = '<script type="text/javascript" src="/public/portal/js/spedv_manages.js"></script>';
   		$this->mp_master->Show_Portal($content, $scriptExtra, '协议管理', $data);    		
   	}
 	
   	function edit_spedv ($id=0){
   		$data = array();
   		$data['userObj'] = $this->userObj;
   		$data['actTab'] = 'settings';
   		$data['pageTitle'] = '插入/修改数据信息';
   		$data['bcList'] = array();
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '系统配置';
   		$bcObj->url = '#';
   		array_push($data['bcList'], $bcObj);
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '协议管理';
   		$bcObj->url = '/portal/spdev_manages';
   		array_push($data['bcList'], $bcObj);
   		$bcObj = new Breadcrumb();
   		$bcObj->title = $data['pageTitle'];
   		$bcObj->url = '#';
   		$bcObj->isLast = true;
   		array_push($data['bcList'], $bcObj);
   		
   		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
   			$this->load->library('form_validation');
   			$this->form_validation->set_rules('name', 'name', 'trim|required');
   			$this->form_validation->set_rules('baud_rate', 'baud_rate', 'trim|required');
   			$this->form_validation->set_rules('cmd', 'cmd', 'trim|required');
   			$this->form_validation->set_rules('reply', 'reply', 'trim|required');
   			if ($this->form_validation->run() == TRUE) {				
   				$name = $this->input->post('name');
   				$baud_rate = $this->input->post('baud_rate');
   				$cmd = $this->input->post('cmd');
   				$reply = $this->input->post('reply');
   				if ($id) {
   					$result = $this->mp_xjdh->Update_spdevs($id, $name, $baud_rate, $cmd, $reply);
   					if($result){
   						$data['successMsg'] = '修改成功<a href="/portal/spdev_manages">返回列表</a>';
   					}
   				} else {
   					$result = $this->mp_xjdh->Save_spdevs($name, $baud_rate, $cmd, $reply);
   					if ($result){
   						$data['successMsg'] = '新增成功<a href="/portal/spdev_manages">返回列表</a>';
   					}
   				}
   			}
   		}
   		if($id){
   			$dbObj = $this->load->database('default', TRUE);
   			$data['spedv'] = $this->mp_xjdh->Get_spdev_protocol($id);
   		}
   		$content = $this->load->view('portal/edit_spedv', $data, TRUE);
   		$this->mp_master->Show_Portal($content, $scriptExtra, '协议管理', $data);
   	}

   	function delete_manage(){  		
   		$manageId = $this->input->post('manageId');  	
   		$result = $this->mp_xjdh->DeleteManage($manageId);		
   		echo json_encode($result ? 'true' : 'false');
   		return;
   	}
   	function change_status ()
   	{
   		$status = $this->input->post('status');
   		$device_id = $this->input->post('device_id');
   		echo $this->mp_xjdh->Change_Status($device_id, $status);
   		return;
   	}
   	function change_password ()
   	{
   		
   		$data = array();
        $data['actTab'] = 'users';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
   		
   		$data['txtPasswdold'] = $txtPasswdold = $this->input->post('txtPasswdold');
        $data['txtPasswdnew'] = $txtPasswdnew = $this->input->post('txtPasswdnew');
        $data['txtPasswdagain'] = $txtPasswdagain = $this->input->post('txtPasswdagain');
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
            if ($this->userObj->password == md5($txtPasswdold)){
        	    if($txtPasswdnew == $txtPasswdagain){
        		    if(User::ChangePasswd($this->userObj->id, $txtPasswdnew)){
        		    	$data['msg']="修改密码成功!";
        		    	//$jsonRet['ret'] = 0;
        		    }
        	    }else{
        		    $data['msg'] = "两次密码输入不相同!";
        	    }	
            }else{ $data['msg'] = "旧密码不正确!";}
        }else{
        	$data['msg'] = $data['msg'] = "请填写新旧密码";
        }
   		$content = $this->load->view('portal/change_password', $data, TRUE);
   		$this->mp_master->Show_Portal($content, $scriptExtra, '', $data);
   	}
   	
   	function power_network_assessment()
   	{
   		$data = array();
   		$data['actTab'] = 'settings';
   		$data['bcList'] = array();
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '系统配置';
   		array_push($data['bcList'], $bcObj);
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '电源网络安全评估';
   		$bcObj->url = '/portal/power_network_assessment';
   		$bcObj->isLast = true;
   		array_push($data['bcList'], $bcObj);		

   		$data['type'] = $type = $this->input->get('type');
   		$data['property'] = $property = $this->input->get('property');
   		$data['element'] = $element = $this->input->get('element');
   		$data['name'] = $name = $this->input->get('name');
   		$data['offset'] = $offset = intval($this->input->get('per_page'));
		
   		$data['networkList'] = $networkList = $this->mp_xjdh->Get_NetWork_List($type, $property, $element, $name, $offset,DEFAULT_PAGE_SIZE);
   		$data['count'] = $count = $this->mp_xjdh->Get_NetWorkCount($type, $property, $element, $name);
   		$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/power_network_assessment"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
   		
   		$scriptExtra = '<link rel="stylesheet" href="/public/js/jstree/themes/default/style.min.css"/>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/tiny_mce/tinymce.min.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/edit-device.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/highcharts.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/modules/exporting.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/jstree/jstree.min.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
   		$scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/power_network_assessment.js"></script>';
   	
   		$content = $this->load->view("portal/power_network_assessment", $data, TRUE);
   		$this->mp_master->Show_Portal($content, $scriptExtra, '电源网络安全评估', $data);
   	}
   	function delete_network(){
   		$id = $this->input->post('id');
   		echo $this->mp_xjdh->DeleteNetwork($id);
   		return;
   	}
   	function edit_network ($id=0){
   		$data = array();
    	$data['pageTitle'] = '插入/修改数据信息';
    	$data['actTab'] = 'settings';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '电源网络安全评估';
        $bcObj->url = '/portal/power_network_assessment';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $data['pageTitle'];
        $bcObj->url = '#';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
   		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
   			$this->load->library('form_validation');
   			$this->form_validation->set_rules('type', 'type', 'trim|required');
   			$this->form_validation->set_rules('property', 'property', 'trim|required');
   			$this->form_validation->set_rules('element', 'element', 'trim|required');
   			if ($this->form_validation->run() == TRUE) {
   				$type = $this->input->post('type');
   				$property = $this->input->post('property');
   				$element = $this->input->post('element');
   				$name = $this->input->post('name');
   				$meaning = $this->input->post('meaning');
   				$requirements = $this->input->post('requirements');
   				$reference = $this->input->post('reference');
   				$remarks = $this->input->post('remarks');
   				$config = $this->input->post('config');
   				if ($id) {
   					$result = $this->mp_xjdh->Update_network($id, $type, $property, $element, $name, $meaning, $requirements, $reference, $remarks, $config);
   					if($result){
   						$data['successMsg'] = '修改成功<a href="/portal/power_network_assessment">返回列表</a>';
   					}
   				} else {
   					$result = $this->mp_xjdh->Save_network($type, $property, $element, $name, $meaning, $requirements, $reference, $remarks, $config);
   					if ($result){
   						$data['successMsg'] = '新增成功<a href="/portal/power_network_assessment">返回列表</a>&nbsp&nbsp&nbsp&nbsp<a href="/portal/edit_network">继续添加</a>';
   					}
   				}
   			}
   		}
   		if($id){
   			$dbObj = $this->load->database('default', TRUE);
   			$data['network'] = $network = $this->mp_xjdh->Get_network_protocol($id);
   		}
   		$content = $this->load->view('portal/edit_network', $data, TRUE);
   		$this->mp_master->Show_Portal($content, $scriptExtra, '电源网络安全评估', $data);
   	}
   	function get_substation_tree()
   	{
   		header('Content-Type: application/json');
   		$id = $this->input->get('id');
   		$nodeArray = array();
   		if($id == "#")
   		{
   			if( $_SESSION['XJTELEDH_USERROLE'] == 'city_admin'||$_SESSION['XJTELEDH_USERROLE'] == 'noc'){
   				foreach (Defines::$gCity as $cityKey => $cityVal)
   				{
   					$city_code = $this->userObj->city_code;
   					if ($city_code == $cityKey ){
   						$node = array();
   						$node["id"] = "#".$cityKey;
   						$node["text"] = $cityVal;
   						$node["children"] = $this->mp_xjdh->Get_SubstationCount($cityKey) > 0;
   						$nodeArray[] = $node;
   					}
   				}
   			}else{
   				foreach (Defines::$gCity as $cityKey => $cityVal)
   				{
   					$node = array();
   					$node["id"] = "#".$cityKey;
   					$node["text"] = $cityVal;
   					$node["children"] = $this->mp_xjdh->Get_SubstationCount($cityKey) > 0;
   					$nodeArray[] = $node;
   				}
   			}
   		}else if(strlen($id) == 4 && substr($id, 0, 1) === '#' && substr($id, 1, 1) != '#')
   		{
   			$substationList = $this->mp_xjdh->Get_Substations(substr($id,1));
   			foreach ($substationList as $substationObj){
   				$node = array();
   				$node["id"] = '##'.$substationObj->id;
   				$node["text"] = $substationObj->name;
   				//$node["children"] = $this->mp_xjdh->Get_RoomCount(false, false, $substationObj->id) > 0;
   				$nodeArray[] = $node;
   			}
   		}
   		echo json_encode($nodeArray);
   	}
   	function Get_Substation_Type($substation_id){
   		$dbObj = $this->load->database('default', TRUE);
   		$dbObj->where('id', $substation_id);
   		$dbObj->select('substation.type');
   		$row=$dbObj->get('substation')->row();
   		$row= json_decode(json_encode($row),true);
        $type = $row[type];
   		return $type;
   	}
   	function substation_network_assessment($substation_id = 0)
   	{
   		$data = array();
   		$data['actTab'] = 'settings';
   		$data['bcList'] = array();
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '系统配置';
   		$bcObj->url = '#';
   		array_push($data['bcList'], $bcObj);
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '局站电源安全评估';
   		$bcObj->isLast = true;
   		array_push($data['bcList'], $bcObj);

   		$data['substation_id'] = $substation_id;
   		$data['type'] = $type = $this->Get_Substation_Type($substation_id);
   		$data['substationObj'] = $substationObj = $this->mp_xjdh->Get_Substation($substation_id);

   		$array = array();
   		$networkObj = $this->mp_xjdh->Network_Id($substation_id);
   	        foreach($networkObj as $key=>$network){
   	    	     foreach($network as $k=>$v){
   	    		if($k =="network_id")
   	    		array_push($array,$v);
   	    	}
   	    }
   	    $arr = array();
        $n = count($array)-1;
        for($i=0;$i<=$n;$i++){
        	$networkList = $this->mp_xjdh->Get_NetWork($type,false,false,false,$substation_id,$array[$i]);
        	array_push($arr,$networkList);
        }
        $network = $this->mp_xjdh->Get_NetWork_Not_Where($type,$substation_id,$array);
        $data['networkList'] =  array_merge($arr,$network);

   		$data['count'] = $count = count($data['networkList']);
   		$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/substation_network_assessment"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
   		 
   		$scriptExtra = '<link rel="stylesheet" href="/public/js/jstree/themes/default/style.min.css"/>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/tiny_mce/tinymce.min.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/edit-device.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/highcharts.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/modules/exporting.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/jstree/jstree.min.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
   		$scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/power_network_assessment.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/substation_network_assessment.js"></script>';

   		$content = $this->load->view("portal/substation_network_assessment", $data, TRUE);
   		$this->mp_master->Show_Portal($content, $scriptExtra, '局站电源安全评估', $data);
   	}

   	
   	function substationSetting ($substation_id)
   	{
   		$data = array();
   		$data['actTab'] = 'settings';
   		$data['bcList'] = array();
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '系统配置';
   		$bcObj->url = '#';
   		array_push($data['bcList'], $bcObj);
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '局站电源安全评估';
   		$bcObj->url = '/portal/substation_network_assessment';
   		array_push($data['bcList'], $bcObj);
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '添加局站安全评估规则';
   		$bcObj->isLast = true;
   		array_push($data['bcList'], $bcObj);
   		
   		$data['substation_id'] = $substation_id;
   		$data['netSubList'] = $this->mp_xjdh->Get_NetworkSubstationConfig($substation_id);
   		$data['devList'] = $devList = $this->mp_xjdh->Get_NetworkSubstationSetting($substation_id);

   		$content = $this->load->view('portal/substation_setting', $data, TRUE);
   		$scriptExtra = '<script type="text/javascript" src="/public/js/insertsome.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/substation_setting.js"></script>';
   		$this->mp_master->Show_Portal($content, $scriptExtra, '机房性能动态配置', $data);
   	}
   	
   	function perforSetting ($substation_id)
   	{
   		$data = array();
   		$data['actTab'] = 'settings';
   		$data['bcList'] = array();
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '系统配置';
   		$bcObj->url = '#';
   		array_push($data['bcList'], $bcObj);
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '局站性能管理';
   		$bcObj->url = '/portal/substation_performance_manage';
   		array_push($data['bcList'], $bcObj);
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '添加局站性能管理评估规则';
   		$bcObj->isLast = true;
   		array_push($data['bcList'], $bcObj);

   		$data['substation_id'] = $substation_id;
   		$data['perforSubList'] = $this->mp_xjdh->Get_PerforSubstationConfig($substation_id);
   		$data['devList'] = $this->mp_xjdh->Get_PerforSubstationSetting($substation_id);
   		
   		$content = $this->load->view('portal/perfor_setting', $data, TRUE);
   		$scriptExtra = '<script type="text/javascript" src="/public/js/insertsome.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/perfor_setting.js"></script>';
   		$this->mp_master->Show_Portal($content, $scriptExtra, '机房性能动态配置', $data);
   	}
   	
   	function saveNetWorkPi ()
   	{   		 		
   		$id = $this->input->post("id");
   		$substation_id = $this->input->post("substation_id");
   		$networkObj = $this->mp_xjdh->Get_Network_By_Id($id);
   		$configs = $config = json_decode($networkObj->config,true);
   		$substationnetwork = $this->mp_xjdh->Get_substation_network($id, $substation_id);
   		$pi_setting = $setting= json_decode($substationnetwork->pi_setting,true);
   		$count = count($config); $n=0;$num=0;
   		$key=array_keys($config);
   		for($i=0;$i<=$count;$i++){
   			if(in_array("label"."".$i,$key)){
   				$n++;
   			}
   			if(in_array("require"."".$i,$key)){
   				$num++;
   			}
   		}
   		$setting = array();
   		for($i=1;$i<=$n;$i++){
   			$key = $i-1;
   		    $name = "varArray[".$key."]";
   		    $setting[$config["var".$i]] = $this->input->post("$name");
   		}
   		$ret = $this->mp_xjdh->Save_Substation_NetWork($id, $substation_id, json_encode($setting), $pi_setting, $substationnetwork->network_id);
   		
   		$network = $this->mp_xjdh->Get_Network_By_Id($id);
   		$configs = json_decode($network->config,true);
   		$substationnetwork = $this->mp_xjdh->Get_substation_network($id, $substation_id);
   		$pi_setting = $setting= json_decode($substationnetwork->pi_setting,true);
   		foreach($pi_setting as $key => $val){
   			if(explode($key,$configs[value])){
   				$configs[value] = str_replace($key, $val, $configs[value]);
   			}
   		}
   		eval("\$value = $configs[value];");
   		$val = $value;
   		for($i=1;$i<=$num;$i++){
   			$val = $val.$config["require".$i];
   			eval("\$vals = $val;");
   			if($vals=="true"){
   				$state = $config["state".$i];
   			}
   			$val = $value;
   		}
   		$this->mp_xjdh->Save_NetWorkValue($id, $substation_id, $value, $state);
   		
   		header('Content-type: application/json');
   		echo json_encode($ret ? 'true' : 'false');			
   	}
   	function performance_manage()
   	{
   		$data = array();
   		$data['actTab'] = 'settings';
   		$data['bcList'] = array();
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '系统配置';
   		array_push($data['bcList'], $bcObj);
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '性能管理';
   		$bcObj->url = '/portal/performance_manage';
   		$bcObj->isLast = true;
   		array_push($data['bcList'], $bcObj);

   		$data['device_type'] = $device_type = trim($this->input->get('device_type'));
   		$data['quota'] = $quota = trim( $this->input->get('quota'));
   		$data['output_device'] = $output_device = trim($this->input->get('output_device'));
   		$data['acquisition_methods'] = $acquisition_methods = trim($this->input->get('acquisition_methods'));
   		$data['offset'] = $offset = intval($this->input->get('per_page'));

   		$data['perforList'] = $perforList = $this->mp_xjdh->Get_Performance($device_type,$quota,$output_device,$acquisition_methods, $offset, DEFAULT_PAGE_SIZE);
   		$data['count'] = $count = $this->mp_xjdh->Get_PerformanceCount($device_type,$quota,$output_device,$acquisition_methods);
   		$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/performance_manage"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
   		 
   		$scriptExtra = '<link rel="stylesheet" href="/public/js/jstree/themes/default/style.min.css"/>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/tiny_mce/tinymce.min.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/edit-device.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/highcharts.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/modules/exporting.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/jstree/jstree.min.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
   		$scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/performance_manage.js"></script>';
   		
   		$content = $this->load->view("portal/performance_manage", $data, TRUE);
   		$this->mp_master->Show_Portal($content, $scriptExtra, '性能管理', $data);
   	}

   	function edit_perfor ($id=0){
   		$data = array();
    	$data['pageTitle'] = '插入/修改数据信息';
    	$data['actTab'] = 'settings';
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();
        $bcObj->title = '系统配置';
        $bcObj->url = '#';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = '性能管理';
        $bcObj->url = '/portal/performance_manage';
        array_push($data['bcList'], $bcObj);
        $bcObj = new Breadcrumb();
        $bcObj->title = $data['pageTitle'];
        $bcObj->url = '#';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);
        
   		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
   			$this->load->library('form_validation');
   			$this->form_validation->set_rules('device_type', 'device_type', 'trim|required');
   			$this->form_validation->set_rules('quota', 'quota', 'trim|required');
   			$this->form_validation->set_rules('output_device', 'output_device', 'trim|required');
   			$this->form_validation->set_rules('acquisition_methods', 'acquisition_methods', 'trim|required');
   			if ($this->form_validation->run() == TRUE) {
   				$major = $this->input->post('major');
   				$device_type = $this->input->post('device_type');
   				$quota = $this->input->post('quota');
   				$cycle = $this->input->post('cycle');
   				$night = $this->input->post('night');
   				$day = $this->input->post('day');
   				$output_device = $this->input->post('output_device');
   				$acquisition_methods = $this->input->post('acquisition_methods');
   				$type = $this->input->post('type');
   				$responsible = $this->input->post('responsible');
   				$set_basis = $this->input->post('set_basis');
   				$output_mode = $this->input->post('output_mode');
   				$remarks = $this->input->post('remarks');
   				$config = $this->input->post('config');

   				if ($id) {
   					$result = $this->mp_xjdh->Update_perfor($id, $major, $device_type, $quota, $cycle, $night, $day, $output_device, $acquisition_methods, $type, $responsible, $set_basis, $output_mode, $remarks, $config);
   					if($result){
   						$data['successMsg'] = '修改成功<a href="/portal/performance_manage">返回列表</a>';
   					}
   				} else {
   					$result = $this->mp_xjdh->Save_perfor($major, $device_type, $quota, $cycle, $night, $day, $output_device, $acquisition_methods, $type, $responsible, $set_basis, $output_mode, $remarks, $config);
   					if ($result){
   						$data['successMsg'] = '新增成功<a href="/portal/performance_manage">返回列表</a>&nbsp&nbsp&nbsp&nbsp<a href="/portal/edit_perfor">继续添加</a>';
   					}
   				}
   			}
   		}
   		if($id){
   			$dbObj = $this->load->database('default', TRUE);
   			$data['perfor'] = $perfor = $this->mp_xjdh->Get_perfor_protocol($id);
   		}
   		$content = $this->load->view('portal/edit_perfor', $data, TRUE);
   		$this->mp_master->Show_Portal($content, $scriptExtra, '性能管理', $data);
   	}
   	function delete_perfor(){
   		$id = $this->input->post('id');
   		echo $this->mp_xjdh->DeletePerfor($id);
   		return;
   	}
   	function substation_performance_manage($substation_id = 0)
   	{
   		$data = array();
   		$data['actTab'] = 'settings';
   		$data['bcList'] = array();
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '系统配置';
   		array_push($data['bcList'], $bcObj);
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '局站性能管理';
   		$bcObj->isLast = true;
   		array_push($data['bcList'], $bcObj);
   		$data['substation_id'] = $substation_id;
   		$data['substationObj'] = $substationObj = $this->mp_xjdh->Get_Substation($substation_id);	
   		$array = array();
   		$perforObj = $this->mp_xjdh->Perfor_Id($substation_id);
   		foreach($perforObj as $key=>$perfor){
   			foreach($perfor as $k=>$v){
   				if($k =="perfor_id")
   					array_push($array,$v);
   			}
   		}
   		$arr = array();
   		$n = count($array)-1;
   		for($i=0;$i<=$n;$i++){
   			$perforList = $this->mp_xjdh->Get_PerFor($substation_id,$array[$i]);
   			array_push($arr,$perforList);
   		}
   		$perfor = $this->mp_xjdh->Get_Perfor_Not_Where($substation_id,$array);
   		$data['perforList'] =  array_merge($arr,$perfor);
   		$data['count'] = $count = $this->mp_xjdh->Get_PerformanceCount($device_type,$quota,$output_device,$acquisition_methods);
   		$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/substation_performance_manage"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);

   		$scriptExtra = '<link rel="stylesheet" href="/public/js/jstree/themes/default/style.min.css"/>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/tiny_mce/tinymce.min.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/jquery.validate.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/validate-extend.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/edit-device.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/highcharts.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/highcharts/modules/exporting.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/jstree/jstree.min.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/moment.min.js"></script>';
   		$scriptExtra .= '<link rel="stylesheet" href="/public/css/daterangepicker-bs2.css"/>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/js/daterangepicker.js"></script>';
   		$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/substation_performance_manage.js"></script>';
   		 
   		$content = $this->load->view("portal/substation_performance_manage", $data, TRUE);
   		$this->mp_master->Show_Portal($content, $scriptExtra, '局站性能管理', $data);
   	}
   	
   	function savePerforPi ()
   	{
   		$id = $this->input->post("id");
   		$substation_id = $this->input->post("substation_id");
   		$perforObj = $this->mp_xjdh->Get_Perfor_By_Id($id);
   		$configs = $config = json_decode($perforObj->config,true);
   		$substationperfor = $this->mp_xjdh->Get_substation_perfor($id, $substation_id);
   		$pi_setting = $setting= json_decode($substationperfor->pi_setting,true);
   		$count = count($config); $n=0;
   		$key=array_keys($config);
   		for($i=0;$i<=$count;$i++){
   			if(in_array("label"."".$i,$key)){
   				$n++;
   			}
   		}
   		$setting = array();
   		for($i=1;$i<=$n;$i++){
   			$key=$i-1;
   		    $name = "varArray[".$key."]";
   		    $setting[$config["var".$i]] = $this->input->post("$name");
   		}
   		$ret = $this->mp_xjdh->Save_Substation_PerFor($id, $substation_id, json_encode($setting), $pi_setting, $substationperfor->perfor_id);
   		
   		$perfor = $this->mp_xjdh->Get_Perfor_By_Id($id);
   		$configs = json_decode($perfor->config,true);
   		$substationperfor = $this->mp_xjdh->Get_substation_perfor($id, $substation_id);
   		$pi_setting = $setting= json_decode($substationperfor->pi_setting,true);
   		foreach($pi_setting as $key => $val){
   			if(explode($key,$configs[value])){
   				$configs[value] = str_replace($key, $val, $configs[value]);
   			}
   		}
   		eval("\$value = $configs[value];");
   		$this->mp_xjdh->Save_PerForValue($id, $substation_id, $value);
   		header('Content-type: application/json');
   		echo json_encode($ret ? 'true' : 'false');	
   		
   		
   		
   	}
   	public function get_network_settings()
   	{
   		$id = $this->input->post("id");
   		
   		$substation_id = $this->input->post("substation_id");
   		$networkObj = $this->mp_xjdh->Get_NetworkList($id);
   		$substationnetwork = $this->mp_xjdh->Get_substation_network($id, $substation_id);
   		//var_dump($networkObj).die;
   		$haveconfig = $networkObj->config;
   		
   		$formulaconfig = $text = $configs = json_decode($networkObj->config,true);
   		$formulasetting = $pi_setting = json_decode($substationnetwork->pi_setting,true);
   		$value = json_decode($substationnetwork->value,true);
   		$array = array();$txt = array();
   		foreach($configs as $key => $val) {
   			foreach($pi_setting as $k => $v){
   				if($val==$k){
   					$configs[$key] = $pi_setting[$k];
   					array_push($array,$v);
   				}
   			}
   		}
   		foreach($text as $key => $val){
   			if(substr($key,0,5)=="label"){
   				array_push($txt,$val);
   			}
   		}
   		foreach($formulaconfig as $key => $val){
   			if(explode($val,$formulaconfig[value])){
   				$a = $formulaconfig[label.substr($key, -1)];
   				$formulaconfig[value] = str_replace($val, $a, $formulaconfig[value]);
   			}
   		}
	
   		
   		echo json_encode(array("pi_setting" => json_decode($substationnetwork->pi_setting),"config" => json_decode($networkObj->config),'txt'=>$txt,'array'=>$array,
   				'formulaconfig'=>$formulaconfig[value],'value'=>$value,"haveconfig"=>$haveconfig));
	
   	}
   	public function get_perfor_settings()
   	{
   		$id = $this->input->post("id");
   		$substation_id = $this->input->post("substation_id");
   		$perforObj = $this->mp_xjdh->Get_PerforList($id);
   		$haveconfig = $perforObj->config;
   		$substationperfor = $this->mp_xjdh->Get_substation_perfor($id, $substation_id);
   		$formulaconfig = $text = $configs = json_decode($perforObj->config,true);
   		$formulasetting = $pi_setting = json_decode($substationperfor->pi_setting,true);
   		$value = json_decode($substationperfor->value,true);
   		$array = array();$txt = array();
   		foreach($configs as $key => $val) {
   			foreach($pi_setting as $k => $v){
   				if($val==$k){
   					$configs[$key] = $pi_setting[$k];
   					array_push($array,$v);
   				}
   			}
   		}
   		foreach($text as $key => $val){
   			if(substr($key,0,5)=="label"){
   				array_push($txt,$val);
   			}
   		}
   		foreach($formulaconfig as $key => $val){
   			if(explode($val,$formulaconfig[value])){
   				$a = $formulaconfig[label.substr($key, -1)];
   				$formulaconfig[value] = str_replace($val, $a, $formulaconfig[value]);
   			}
   		}
   		echo json_encode(array("pi_setting" => json_decode($substationperfor->pi_setting),"config" => json_decode($perforObj->config),'txt'=>$txt,'array'=>$array,
   				'formulaconfig'=>$formulaconfig[value],'value'=>$value,"haveconfig"=>$haveconfig));
   	}
   	function checkip ()
   	{
   		$ip = $this->input->post('txtIP');
   		$device_no = $this->input->post('txtDevNo');
   		$userObj = User::GetSmdDeviceByIp($ip);
   		if (count($userObj)) {
   			if ($device_no != false && $userObj->device_no == $device_no)
   				echo "true";
   			else
   				echo 'false';
   		} else
   			echo "true";
   	}
   	function saveNetworkConfig ()
   	{
   		$substation_id = $this->input->post('substation_id');
   		$nk_name = $nk_script = $this->input->post('nk_script');
   		$is_subid = $this->mp_xjdh->Get_NetworkSubstationConf($substation_id);
   		$is_subid = $is_subid->substation_id;
   		$data['devList'] = $devList = $this->mp_xjdh->Get_NetworkSubstationSetting($substation_id);
   		foreach($devList as $key=>$val){
   		   if(strpos($nk_script,$val->name)!== false){
   		   	  $nk_name = str_replace($val->name,$val->value,$nk_name);
   		   }
   		}
   		eval("\$value = $nk_name;");
   		$ret = $this->mp_xjdh->Save_NetworKSubstationConfig($substation_id, $nk_script, $value, $is_subid);
   		header('Content-type: application/json');
   		echo json_encode($ret ? 'true' : 'false');
   	}
   	
   	function savePerforConfig ()
   	{
   		$substation_id = $this->input->post('substation_id');
   		$nk_name = $nk_script = $this->input->post('nk_script');
   		$is_subid = $this->mp_xjdh->Get_PerforSubstationConf($substation_id);
   		$is_subid = $is_subid->substation_id;
   		$data['devList'] = $devList = $this->mp_xjdh->Get_PerforSubstationSetting($substation_id);
   		foreach($devList as $key=>$val){
   			if(strpos($nk_script,$val->device_type)!== false){
   				$nk_name = str_replace($val->device_type,$val->value,$nk_name);
   			}
   		}
   		eval("\$value = $nk_name;");
   		$ret = $this->mp_xjdh->Save_PerforSubstationConfig($substation_id, $nk_script, $value, $is_subid);
   		header('Content-type: application/json');
   		echo json_encode($ret ? 'true' : 'false');
   	}
   	
   	function deleteNetworkConfig ()
   	{
   		$substation_id = $this->input->post('substation_id');
   		$this->mp_xjdh->Delete_NetworkConfig($substation_id);
//    		$this->load->helper("smdthrift");
//    		$apiObj = new SMDThrift();
//    		$devObj = $this->mp_xjdh->Get_Device($data_id);
//    		if (0 == $apiObj->RefreshVDevice($devObj->smd_device_no)) {
//    			$ret = 1;
//    		} else {
//    			$ret = 0;
//    		}
//   		header('Content-type: application/json');
   		echo json_encode('true');
   	}
   	function deletePerforConfig ()
   	{
   		$substation_id = $this->input->post('substation_id');
   		$this->mp_xjdh->Delete_PerforConfig($substation_id);
   		echo json_encode('true');
   	}
   	
   	function door_report()
   	{
   		$data = array();
   		$data['userObj'] = $this->userObj;
   		$data['actTab'] = 'charts';
   		$data['bcList'] = array();
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '统计报表';
   		$bcObj->url = '#';
   		array_push($data['bcList'], $bcObj);
   		$bcObj = new Breadcrumb();
   		$bcObj->title = '门禁报表';
   		$bcObj->isLast = true;
   		array_push($data['bcList'], $bcObj);
   		
   		$data['offset'] = $offset = intval($this->input->get('per_page'));
   		$data['startDatetime'] = $startDatetime = $this->input->get('datestart');
   		$data['endDatetime'] = $endDatetime = $this->input->get('dateend');
   		$data['cityCode'] = $cityCode = $this->input->get('selCity');
   		$data['countyCode'] = $countyCode = $this->input->get('selCounty');
   		$data['substationId'] = $substationId = $this->input->get('selSubstation');
   		$data['substationList'] = $this->mp_xjdh->Get_Substations();
   		$data['roomId'] = $roomId = $this->input->get('selRoom');
   		$data['roomList'] = $this->mp_xjdh->Get_Rooms();
   		$data['keyWord'] = $keyWord = $this->input->get('keyWord');

   		if ($startDatetime == NULL || $endDatetime == NULL) {
   			$startDatetime = array();$endDatetime = array();
   			//上个月
   			$lastMonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d") - 1, date("Y")));
   			$data['startDatetime'] = $lastMonth;
   			//本月
   			$data['endDatetime'] = date('Y-m-d');
   		}
   		
   		$export = $this->input->get('export');
   		if($export == "exporttoexcel")
   		{
   			require 'resources/php-excel.class.php';	
   			$record_offset = 0;
   			$PAGE_SIZE = 2000;
   			$xls = new Excel_XML('UTF-8', false, '门禁报表');
   			$xls->addRow(array("分公司","区域","局站","门禁","用户名","手机号","卡号","操作","描述","操作时间"));
   			while(true)
   			{
       			$recordList = $this->mp_xjdh->Get_Door_Report_List($cityCode, $countyCode, $substationId, $roomId, $keyWord, $startDatetime, $endDatetime, $PAGE_SIZE, $record_offset);
       			foreach($recordList as $recordObj)
       			{
       				$xls->addRow(array(
       						Defines::$gCity[$recordObj->city_code], Defines::$gCounty[$recordObj->city_code][$recordObj->county_code], 
       				        $recordObj->substation_name, $recordObj->name, $recordObj->full_name, 
       						$recordObj->mobile, $recordObj->card_no, $recordObj->action, $recordObj->desc, $recordObj->added_datetime
       				));
       			}
       			$record_offset += $PAGE_SIZE;
       			if(count($recordList) < $PAGE_SIZE)
       			{
       			    break;
       			}
   			}
   			header('Content-Type: application/vnd.ms-excel');
   			header('Content-Disposition: attachment;filename="门禁报表.xls"');
   			header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
   			header('Expires:0');
   			header('Pragma:public');
   			header('Cache-Control: max-age=1');
   			$xls->generateXML('门禁报表');
   			return;
   		}
   		
   		$data['count'] = $count = $this->mp_xjdh->Get_Door_Report_Count($cityCode, $countyCode, $substationId, $roomId, $keyWord, $startDatetime, $endDatetime);
   		$data['recordList'] = $recordList = $this->mp_xjdh->Get_Door_Report_List($cityCode, $countyCode, $substationId, $roomId, $keyWord, $startDatetime, $endDatetime, DEFAULT_PAGE_SIZE, $offset);
   		$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("portal/door_report"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
   		$scriptExtra .= '<script type="text/javascript" src="/public/portal/js/door_report.js"></script>';
   		$content = $this->load->view("portal/door_report", $data, TRUE);
   		$this->mp_master->Show_Portal($content, $scriptExtra, '局站性能管理', $data);
   	}
   	
   	
   	
   	
 }

?>
