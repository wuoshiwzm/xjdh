<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

require "XML/Serializer.php";
class Ws extends CI_Controller {
	var $nusoap_server = null;
	var $serializer = null;
	public function __construct() {
		parent::__construct ();
		$this->nusoap_server = new soap_server ();
		$this->nusoap_server->soap_defencoding = 'UTF-8';
		$this->nusoap_server->decode_utf8 = false;
		$this->nusoap_server->xml_encoding = 'UTF-8';
		$this->nusoap_server->configureWSDL ( 'ws', "urn:ws" ); // 打开 wsdl 支持
		
		/*
		 * $this->nusoap_server->wsdl->addComplexType( 'Member', 'complexType', 'struct', 'all', '', array( 'id' => array('name' => 'id' , 'type' => 'xsd:integer'), 'username' => array('name' => 'username', 'type' => 'xsd:string') ) );
		 */
		// My Station
		$this->nusoap_server->register ( "MyStation", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#MyStation' );
		// searchMyStation
		$this->nusoap_server->register ( "searchMyStation", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#searchMyStation' );
		// queryStationByUserId
		$this->nusoap_server->register ( "queryStationByUserId", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#queryStationByUserId' );
		// My Alarm
		$this->nusoap_server->register ( "MyAlarm", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#MyAlarm' );
		// 告警查询searchMyAlarm
		$this->nusoap_server->register ( "searchMyAlarm", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#searchMyAlarm' );
		// 设备查询 DeviceQuery
		$this->nusoap_server->register ( "DeviceQuery", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#DeviceQuery' );
		
		// 局站设备列表查询,同上
		$this->nusoap_server->register ( "queryDeviceByStationId", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#queryDeviceByStationId' );
		// 历史告警 AlarmHistory
		$this->nusoap_server->register ( "AlarmHistory", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#AlarmHistory' );
		// 局站历史告警 searchStationAlarmHistory
		$this->nusoap_server->register ( "searchStationAlarmHistory", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#searchStationAlarmHistory' );
		// 局站搜索 StationQuery
		$this->nusoap_server->register ( "StationQuery", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#StationQuery' );
		// 局站搜索 searchStation, 和StationQuery是同一个接口
		$this->nusoap_server->register ( "searchStation", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#searchStation' );
		// 动环网元ping测试 Ping
		$this->nusoap_server->register ( "Ping", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#Ping' );
		$this->nusoap_server->register ( "pingIpAddress", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#pingIpAddress' );
		
		// 设备信号查询,querySignalByDeviceId
		$this->nusoap_server->register ( "querySignalByDeviceId", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#querySignalByDeviceId' );
		// 局站告警查询 queryAlarmByStationId
		$this->nusoap_server->register ( "queryAlarmByStationId", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#queryAlarmByStationId' );
		// 添加用户常用局站, addStationByUserId
		$this->nusoap_server->register ( "addStationByUserId", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#addStationByUserId' );
		// 删除用户常用局站, searchMyStationdeleteStationByUserId
		$this->nusoap_server->register ( "deleteStationByUserId", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#deleteStationByUserId' );
		// 局站PING测试, pingStationIpAddress
		$this->nusoap_server->register ( "pingStationIpAddress", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#pingStationIpAddress' );
		// 信号历史数据分析,getSignalValueAnalyse
		$this->nusoap_server->register ( "getSignalValueAnalyse", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#getSignalValueAnalyse' );
		
		// 获取某局站下告警
		$this->nusoap_server->register ( "AlarmQuery", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#AlarmQuery' );
		
		$this->nusoap_server->register ( "queryAlarmByStationId", array (
				"argu" => "xsd:string" 
		), array (
				"return" => "xsd:string" 
		), 'urn:ws', 		// namespace
		'urn:ws#queryAlarmByStationId' );
	}
	public function index() {
		// 获取常用局站
		function queryStationByUserId($argu) {
			$ci = &get_instance ();
			$ret = array ();
			
			$xmlObj = simplexml_load_string ( $argu );
			$oaId = strval ( $xmlObj->oaId );
			$pageNo = intval ( $xmlObj->pageNo );
			$pageSize = intval ( $xmlObj->pageSize );
			$userObj = User::GetUser ( $oaId );
			if (count ( $userObj ) == 0) {
				$ret = array (
						"resultState" => 0,
						"resultDesc" => "未找到用户",
						"total" => 0,
						"totalPages" => 0,
						"pageSize" => 0,
						"currentPage" => 1,
						"list" => array () 
				);
			} else {
				$ret = array (
						"resultState" => 1,
						"resultDesc" => "",
						"total" => 10,
						"totalPages" => 10,
						"pageSize" => 10,
						"currentPage" => 1 
				);
				$counties = $ci->mp_xjdh->Get_UserStation_List ( $userObj->id, '' );
				$ret ['totalPages'] = 1;
				$ret ['currentPage'] = 1;
				foreach ( $counties as $countyObj ) {
					$stationObj = array ();
					$stationObj ["lscId"] = $cityObj->city_code;
					$stationObj ["stationId"] = $countyObj->id;
					$stationObj ["name"] = $countyObj->name;
					$stationObj ["alaLevel"] = $ci->mp_xjdh->Get_Top_Alarm_By_Station ( $countyObj->id );
					array_push ( $ret, $stationObj );
				}
			}
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function searchMyStation($argu) {
			$ci = &get_instance ();
			$ret = array ();
			
			$xmlObj = simplexml_load_string ( $argu );
			$oaId = strval ( $xmlObj->oaId );
			$searchKey = strval ( $xmlObj->searchKey );
			$pageNo = intval ( $xmlObj->pageNo );
			$pageSize = intval ( $xmlObj->pageSize );
			
			log_message ( 'debug', "MyStation oaId:$oaId pageNo:$pageNo pageSize:$pageSize" );
			$userObj = User::GetUser ( $oaId );
			if (count ( $userObj ) == 0) {
				$ret = array (
						"resultState" => 0,
						"resultDesc" => "未找到用户",
						"total" => 0,
						"totalPages" => 0,
						"pageSize" => 0,
						"currentPage" => 1,
						"list" => array () 
				);
			} else {
				$ret = array (
						"resultState" => 1,
						"resultDesc" => "",
						"total" => 10,
						"totalPages" => 10,
						"pageSize" => 10,
						"currentPage" => 1 
				);
				
				$offset = 0;
				if ($pageNo == - 1 || $pageSize == - 1) {
				    $ret ['totalPages'] = 1;
				    $ret ['currentPage'] = 1;
				}else{
    				$offset = $pageSize * ($pageNo - 1);
    				if($offset < 0)
    				    $offset = 0;
				}
    			if(in_array($userObj->user_role, array("admin","noc"))){
    			    $count = $ci->mp_xjdh->Search_Substation_Count($keyword);
                    $substationList = $ci->mp_xjdh->Search_Substation($keyword,'',array(),$pageSize, $offset);
                }else{
                    if($userObj->user_role == "city_admin")
                    { 
                        $count = $ci->mp_xjdh->Search_Substation_Count($keyword,$userObj->city_code);
                        $substationList = $ci->mp_xjdh->Search_Substation($keyword,$userObj->city_code,array(),$pageSize, $offset);
                    }else{
                        $userPrivilegeObj = User::Get_UserPrivilege($userObj->id);
                        if(count($userPrivilegeObj))
                        {                    
                            $substationIdArray = json_decode($userPrivilegeObj->area_privilege);
                            $count = $ci->mp_xjdh->Search_Substation_Count($keyword,$userObj->city_code,$substationIdArray);
                            $substationList = $ci->mp_xjdh->Search_Substation($keyword,$userObj->city_code, $substationIdArray,$pageSize, $offset);
                        }else{
                            $count = 0;
                            $substationList = array();
                        }
                    }
                }
    			if($pageSize != -1)
    			{
    			    $ret ['totalPages'] = ( int ) ceil ( $count / $pageSize );
    			    if ($pageNo <= $ret ['totalPages']) {
    			        $ret ['currentPage'] = $pageNo;
    			    } else {
    			        $pageNo = $ret ['totalPages'];
    			        $ret ['currentPage'] = $pageNo;
    			    }
    			}	
    			$ret ['total'] = $count;
    			foreach ( $substationList as $substationObj ) {
    				$stationObj = array ();
    				$stationObj ["lscId"] = $substationObj->city_code;
    				$stationObj ["stationId"] = $substationObj->id;
    				$stationObj ["name"] = $substationObj->name;
    				$stationObj ["alaLevel"] = $ci->mp_xjdh->Get_Top_Alarm_By_Station ( $substationObj->id );
    				array_push ( $ret, $stationObj );
    			}
			}
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function searchStation($argu) {
			$ci = &get_instance ();
			$ret = array ();
			// $argu = iconv("GBK","UTF-8",$argu);
			$argu = str_replace ( "GBK", "UTF-8", $argu );
			log_message ( 'debug', "searchStation 中文" . $argu );
			$xmlObj = simplexml_load_string ( $argu );
			$oaId = strval ( $xmlObj->oaId );
			$searchKey = strval ( $xmlObj->searchKey );
			$pageNo = intval ( $xmlObj->pageNo );
			$pageSize = intval ( $xmlObj->pageSize );
			
			log_message ( 'debug', "searchStation oaId:$oaId searchKey:$searchKey pageNo:$pageNo pageSize:$pageSize" );
			$userObj = User::GetUser ( $oaId );
			if (count ( $userObj ) == 0) {
				$ret = array (
						"resultState" => 0,
						"resultDesc" => "未找到用户",
						"total" => 0,
						"totalPages" => 0,
						"pageSize" => 0,
						"currentPage" => 1,
						"list" => array () 
				);
			} else {
				$ret = array (
						"resultState" => 1,
						"resultDesc" => "",
						"total" => 10,
						"totalPages" => 10,
						"pageSize" => 10,
						"currentPage" => 1 
				);
				if (empty ( $searchKey )) {
					// 直接返回常用局站
					$counties = $ci->mp_xjdh->Get_UserStation_List ( $userObj->id, '' );
					$ret ['total'] = count ( $counties );
					$ret ['totalPages'] = 1;
					$ret ['currentPage'] = 1;
					foreach ( $counties as $countyObj ) {
						$stationObj = array ();
						$stationObj ["lscId"] = $cityObj->city_code;
						$stationObj ["stationId"] = $countyObj->id;
						$stationObj ["name"] = $countyObj->name;
						$stationObj ["alaLevel"] = $ci->mp_xjdh->Get_Top_Alarm_By_Station ( $countyObj->id );
						array_push ( $ret, $stationObj );
					}
				} else {
					$count = $ci->mp_xjdh->Get_CountyCount ( false, array (), $searchKey );
					
					$ret ['total'] = $count;
					log_message ( 'debug', 'scott count is ' . $count );
					if ($pageNo == - 1 || $pageSize == - 1) {
						$counties = $ci->mp_xjdh->Get_CountyList ( false, array (), $searchKey );
						$ret ['totalPages'] = 1;
						$ret ['currentPage'] = 1;
						foreach ( $counties as $countyObj ) {
							$stationObj = array ();
							$stationObj ["lscId"] = $cityObj->city_code;
							$stationObj ["stationId"] = $countyObj->id;
							$stationObj ["name"] = $countyObj->name;
							$stationObj ["alaLevel"] = $ci->mp_xjdh->Get_Top_Alarm_By_Station ( $countyObj->id );
							array_push ( $ret, $stationObj );
						}
					} else {
						$offset = 0;
						$ret ['totalPages'] = ( int ) ceil ( $count / $pageSize );
						if ($ret ['totalPages'] == 0)
							$ret ['totalPages'] = 1;
						if ($pageNo <= $ret ['totalPages']) {
							$ret ['currentPage'] = $pageNo;
						} else {
							$pageNo = $ret ['totalPages'];
							$ret ['currentPage'] = $pageNo;
						}
						$offset = $pageSize * ($pageNo - 1);
						$counties = $ci->mp_xjdh->Get_CountyList ( false, array (), $searchKey, $offset, $pageSize );
						foreach ( $counties as $countyObj ) {
							$stationObj = array ();
							$stationObj ["lscId"] = $cityObj->city_code;
							$stationObj ["stationId"] = $countyObj->id;
							$stationObj ["name"] = $countyObj->name;
							$stationObj ["alaLevel"] = $ci->mp_xjdh->Get_Top_Alarm_By_Station ( $countyObj->id );
							array_push ( $ret, $stationObj );
						}
					}
				}
			}
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function MyStation($argu) {
			$ret = array (
					"resultState" => 0,
					"resultDesc" => "本功能已经过时,请使用searchMyStation",
					"total" => 0,
					"totalPages" => 0,
					"pageSize" => 0,
					"currentPage" => - 1,
					"list" => array () 
			);
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function searchMyAlarm($argu) {
			$ci = &get_instance ();
			$ret = array ();
			log_message ( 'debug', "searchMyAlarm " . $argu );
			
			$xmlObj = simplexml_load_string ( $argu );
			$oaId = strval ( $xmlObj->oaId );
			$pageNo = intval ( $xmlObj->pageNo );
			$pageSize = intval ( $xmlObj->pageSize );
			
			$userObj = User::GetUser ( $oaId );
			if (count ( $userObj ) == 0) {
				$ret = array (
						"resultState" => 0,
						"resultDesc" => "未找到用户",
						"total" => 0,
						"totalPages" => 0,
						"pageSize" => 0,
						"currentPage" => 1,
						"list" => array () 
				);
			} else {
				$ret = array (
						"resultState" => 1,
						"resultDesc" => "",
						"total" => 0,
						"totalPages" => 1,
						"pageSize" => $pageSize,
						"currentPage" => 1 
				);
				
				$cityCode = "";
    			$userLevel = 3;
                $substationIdArray = array();
                if($userObj->user_role == "admin")
                {
                    $userLevel = 1;
                }else if($userObj->user_role == "city_admin")
                {
                    $userLevel = 2;
                    $cityCode = $userObj->city_code;
                }else{
                    $cityCode = $userObj->city_code;
                    $userPrivilegeObj = User::Get_UserPrivilege($userObj->id);
                    if(count($userPrivilegeObj))
                    {
                        $substationIdArray = json_decode($userPrivilegeObj->area_privilege);
                    }
                }
				$data['alarmCount'] = $this->mp_xjdh->Get_AlarmCount($cityCode, '', 0, 0, array(), 0, 
                															'unresolved', '', '', '', '', 
                                                                            $userLevel, $substationIdArray); 
				$offset = 0;
				$ret ['total'] = $count;
				$ret ['totalPages'] = ( int ) ceil ( $count / $pageSize );
				if ($ret ['totalPages'] == 0)
					$ret ['totalPages'] = 1;
				if ($pageNo <= $ret ['totalPages']) {
					$ret ['currentPage'] = $pageNo;
				} else {
					$pageNo = $ret ['totalPages'];
					$ret ['currentPage'] = $pageNo;
				}
				$offset = $pageSize * ($pageNo - 1);
				$alarmList = $this->mp_xjdh->Get_AlarmList($cityCode, '', 0, 0, array(), 0, 
                											array('unresolved'), '', '', '', '', 
				                                            $userLevel, $substationIdArray, $offset, $pageSize);
				foreach ( $alarmList as $alarmObj ) {
					array_push ( $ret, array (
							"id" => $alarmObj->id,
							"startTime" => $alarmObj->added_datetime,
							"nodeName" => $alarmObj->signal_name,
							"alarmDesc" => $alarmObj->subject,
							"alaLevel" => $alarmObj->level 
					) );
				}
			}
			
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function MyAlarm($argu) {
			$ret = array (
					"resultState" => 0,
					"resultDesc" => "本功能已经过时,请使用searchMyAlarm",
					"total" => 0,
					"totalPages" => 0,
					"pageSize" => 0,
					"currentPage" => - 1,
					"list" => array () 
			);
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function DeviceQuery($argu) {
			$ret = array (
					"resultState" => 0,
					"resultDesc" => "本功能已经过时,请使用queryDeviceByStationId",
					"total" => 0,
					"totalPages" => 0,
					"pageSize" => 0,
					"currentPage" => - 1,
					"list" => array () 
			);
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function queryDeviceByStationId($argu) {
			$ci = &get_instance ();
			$ret = array ();
			
			$xmlObj = simplexml_load_string ( $argu );
			$oaId = strval ( $xmlObj->oaId );
			$lscId = intval ( $xmlObj->lscId );
			$stationId = intval ( $xmlObj->stationId );
			$pageNo = intval ( $xmlObj->pageNo );
			$pageSize = intval ( $xmlObj->pageSize );
			$userObj = User::GetUser ( $oaId );
			
			log_message ( 'debug', "DeviceQuery oaId:$oaId lscId:$lscId stationId:$stationId pageNo:$pageNo pageSize:$pageSize" );
			if (count ( $userObj ) == 0) {
				$ret = array (
						"resultState" => 0,
						"resultDesc" => "未找到用户",
						"total" => 0,
						"totalPages" => 0,
						"pageSize" => 0,
						"currentPage" => 1,
						"list" => array () 
				);
			} else {
				$ret = array (
						"resultState" => 1,
						"resultDesc" => "",
						"total" => 10,
						"totalPages" => 10,
						"pageSize" => 10,
						"currentPage" => 1 
				);
				$count = $ci->mp_xjdh->Get_Device_Count ( $lscId, false, $stationId, false, false, array (),false, 'active', '' );
				$devList = $ci->mp_xjdh->Get_Device_List ( $lscId, false, $stationId, false, false, array (),false, 'active', '', $pageNo * 20, $pageSize );
				$ret ['total'] = $count;
				foreach ( $devList as $devObj ) {
					array_push ( $ret, array (
							"lscId" => $lscId,
							"deviceId" => $devObj->data_id,
							"deviceType" => $devObj->dev_type,
							"name" => $devObj->name,
							"alaLevel" => $ci->mp_xjdh->Get_Top_Alarm_By_DataId ( $devObj->data_id, $devObj->smd_device_no ) 
					) );
				}
			}
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function AlarmQuery($argu) {
			$ret = array (
					"resultState" => 0,
					"resultDesc" => "本功能已经过时,请使用queryAlarmByStationId",
					"total" => 0,
					"totalPages" => 0,
					"pageSize" => 0,
					"currentPage" => - 1,
					"list" => array () 
			);
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function queryAlarmByStationId($argu) {
			$ci = &get_instance ();
			$ret = array ();
			$xmlObj = simplexml_load_string ( $argu );
			$oaId = strval ( $xmlObj->oaId );
			$lscId = intval ( $xmlObj->lscId );
			$stationId = intval ( $xmlObj->stationId );
			$almLevel = intval ( $xmlObj->almLevel );
			$pageNo = intval ( $xmlObj->pageNo );
			$pageSize = intval ( $xmlObj->pageSize );
			log_message ( 'debug', "queryAlarmByStationId oaId:$oaId lscId:$lscId stationId:$stationId pageNo:$pageNo pageSize:$pageSize" );
			if ($pageNo == - 1 || $pageSize == - 1) {
				$pageNo = 1;
				$pageSize = 20;
			}
			
			$userObj = User::GetUser ( $oaId );
			if (count ( $userObj ) == 0) {
				$ret = array (
						"resultState" => 0,
						"resultDesc" => "未找到用户",
						"total" => 0,
						"totalPages" => 0,
						"pageSize" => 0,
						"currentPage" => 1,
						"list" => array () 
				);
			} else {
				$ret = array (
						"resultState" => 1,
						"resultDesc" => "",
						"total" => 0,
						"totalPages" => 1,
						"pageSize" => $pageSize,
						"currentPage" => 1 
				);
				
				$count = $ci->mp_xjdh->Get_WsAlarmCount ( $lscId, $stationId, "unresolved", $almLevel, false, false );
				$offset = 0;
				$ret ['total'] = $count;
				$ret ['totalPages'] = ( int ) ceil ( $count / $pageSize );
				if ($ret ['totalPages'] == 0)
					$ret ['totalPages'] = 1;
				if ($pageNo <= $ret ['totalPages']) {
					$ret ['currentPage'] = $pageNo;
				} else {
					$pageNo = $ret ['totalPages'];
					$ret ['currentPage'] = $pageNo;
				}
				$offset = $pageSize * ($pageNo - 1);
				$alarmList = $ci->mp_xjdh->Get_WsAlarmList ( $lscId, $stationId, "unresolved", $almLevel, false, false, $offset, $pageSize );
				foreach ( $alarmList as $alarmObj ) {
					array_push ( $ret, array (
							"id" => $alarmObj->id,
							"startTime" => $alarmObj->added_datetime,
							"nodeName" => $alarmObj->signal_name,
							"alarmDesc" => $alarmObj->subject,
							"alaLevel" => $alarmObj->level 
					) );
				}
			}
			
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function AlarmHistory($argu) {
			$ret = array (
					"resultState" => 0,
					"resultDesc" => "本功能已经过时,请使用searchStationAlarmHistory",
					"total" => 0,
					"totalPages" => 0,
					"pageSize" => 0,
					"currentPage" => - 1,
					"list" => array () 
			);
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function searchStationAlarmHistory($argu) {
			$ci = &get_instance ();
			$ret = array ();
			
			log_message ( 'debug', "searchStationAlarmHistory " . $argu );
			$xmlObj = simplexml_load_string ( $argu );
			$oaId = strval ( $xmlObj->oaId );
			$lscId = intval ( $xmlObj->lscId );
			$stationId = intval ( $xmlObj->stationId );
			$startTime = strval ( $xmlObj->startTime );
			$endTime = strval ( $xmlObj->endTime );
			$pageNo = intval ( $xmlObj->pageNo );
			$pageSize = intval ( $xmlObj->pageSize );
			log_message ( "debug", "searchStationAlarmHistory " . $startTime . " " . $endTime );
			if ($pageNo == - 1 || $pageSize == - 1) {
				$pageNo = 1;
				$pageSize = 20;
			}
			
			$userObj = User::GetUser ( $oaId );
			if (count ( $userObj ) == 0) {
				$ret = array (
						"resultState" => 0,
						"resultDesc" => "未找到用户",
						"total" => 0,
						"totalPages" => 0,
						"pageSize" => 0,
						"currentPage" => 1,
						"list" => array () 
				);
			} else {
				$ret = array (
						"resultState" => 1,
						"resultDesc" => "",
						"total" => 10,
						"totalPages" => 10,
						"pageSize" => 10,
						"currentPage" => 1 
				);
				$count = $ci->mp_xjdh->Get_WsAlarmCount ( $lscId, $stationId, "solved", 0, $startTime, $endTime );
				$offset = 0;
				$ret ['total'] = $count;
				$ret ['totalPages'] = ( int ) ceil ( $count / $pageSize );
				if ($ret ['totalPages'] == 0)
					$ret ['totalPages'] = 1;
				if ($pageNo <= $ret ['totalPages']) {
					$ret ['currentPage'] = $pageNo;
				} else {
					$pageNo = $ret ['totalPages'];
					$ret ['currentPage'] = $pageNo;
				}
				$offset = $pageSize * ($pageNo - 1);
				$alarmList = $ci->mp_xjdh->Get_wsAlarmList ( $lscId, $stationId, "solved", 0, $startTime, $endTime, $offset, $pageSize );
				foreach ( $alarmList as $alarmObj ) {
					array_push ( $ret, array (
							"id" => $alarmObj->id,
							"startTime" => $alarmObj->added_datetime,
							"endTime" => $alarmObj->restore_datetime,
							"nodeName" => $alarmObj->signal_name,
							"alarmDesc" => $alarmObj->subject,
							"alaLevel" => $alarmObj->level 
					) );
				}
			}
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function StationQuery($argu) {
			$ret = array (
					"resultState" => 0,
					"resultDesc" => "本功能已经过时,请使用searchStation",
					"total" => 0,
					"totalPages" => 0,
					"pageSize" => 0,
					"currentPage" => - 1,
					"list" => array () 
			);
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function Ping($argu) {
			$ret = array (
					"resultState" => 0,
					"resultDesc" => "本功能已经过时,请使用pingIpAddress",
					"total" => 0,
					"totalPages" => 0,
					"pageSize" => 0,
					"currentPage" => - 1,
					"list" => array () 
			);
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function pingStationIpAddress($argu) {
			$ci = &get_instance ();
			$ret = array ();
			$xmlObj = simplexml_load_string ( $argu );
			$lscId = intval ( $xmlObj->lscId );
			$stationId = intval ( $xmlObj->stationId );
			
			// function Get_SMD_Device_List ($cityCode = false, $countyCode = false, $substaitonId = false, $ip = '', $name = '', $active = 'all', $offset = 0, $size = 20)
			$smdDeviceList = $ci->mp_xjdh->Get_SMD_Device_List ( $lscId, $stationId );
			foreach ( $smdDeviceList as $smdDev ) {
				if ($smdDev->ip == "*")
					continue;
				$arr = array ();
				$cmd = 'ping -w 2 -c 1 ' . $smdDev->ip;
				log_message ( 'debug', 'ping ipaddress ' . $smdDev->ip );
				$line = exec ( $cmd, $arr );
				if (count ( $arr ) == 0) {
					// fail
					array_push ( $ret, array (
							"ip" => $smdDev->ip,
							"pingRst" => "unknown host " . $smdDev->ip 
					) );
				} else {
					// success
					array_push ( $ret, array (
							"ip" => $smdDev->ip,
							"pingRst" => $arr [1] 
					) );
				}
			}
			// die;
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function pingIpAddress($argu) {
			$ret = array ();
			$xmlObj = simplexml_load_string ( $argu );
			$ipAddress = strval ( $xmlObj->ipAddress );
			$ipArr = explode ( ",", $ipAddress );
			
			foreach ( $ipArr as $ip ) {
				if (empty ( $ip ))
					continue;
				$arr = array ();
				$cmd = 'ping -w 2 -c 1 ' . $ip;
				log_message ( 'debug', 'ping ipaddress ' . $ip );
				$line = exec ( $cmd, $arr );
				if (count ( $arr ) == 0) {
					// fail
					array_push ( $ret, array (
							"ip" => $ip,
							"pingRst" => "unknown host " . $ip 
					) );
				} else {
					// success
					array_push ( $ret, array (
							"ip" => $ip,
							"pingRst" => $arr [1] 
					) );
				}
			}
			// die;
			
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function get_alaLevel($dataId, $key) {
			$ci = &get_instance ();
			$ci->load->driver ( 'cache', array (
					'adapter' => 'memcached' 
			) );
			$keyStr = $dataId . "_alert_" . $key;
			$memData = $ci->cache->get ( $keyStr );
			if($memData != false)
			{
			$data = unpack ( "i", $memData );
			return $data[1];
			}
			return 0;
		}
		function querySignalByDeviceId($argu) {
			$ci = &get_instance ();
			$ret = array ();
			$xmlObj = simplexml_load_string ( $argu );
			
			// $jsonRet=array();
			
			$oaId = strval ( $xmlObj->oaId );
			$lscId = intval ( $xmlObj->lscId );
			$deviceId = $xmlObj->deviceId;
			$pageNo = $xmlObj->pageNo;
			$pageSize = $xmlObj->pageSize;
			log_message ( 'debug', "querySignalByDeviceId oaId:$oaId lscId:$lscId deviceId:$deviceId pageNo:$pageNo pageSize:$pageSize" );
			
			$devObj = $ci->mp_xjdh->Get_Device ( $deviceId );
			
			if (count ( $devObj ) == 0) {
				$ret = array (
						"resultState" => 0,
						"resultDesc" => "未找到指定设备",
						"total" => 0,
						"totalPages" => 0,
						"pageSize" => 0,
						"currentPage" => 1,
						"list" => array () 
				);
			} else {
				if (! $devObj->active) {
					$ret = array (
							"resultState" => 0,
							"resultDesc" => "指定设备被禁用",
							"total" => 0,
							"totalPages" => 0,
							"pageSize" => 0,
							"currentPage" => 1,
							"list" => array () 
					);
				} else {
					// 2015-11-13, 这个地方有两个问题，一是设备掉线，而是设备上级的采集设备掉线
					$ret = array (
							"resultState" => 1,
							"resultDesc" => "",
							"total" => 10,
							"totalPages" => 10,
							"pageSize" => 10,
							"currentPage" => 1 
					);
					$smd_offline = false;
					$dev_offline = get_alaLevel ( $valueSet [0]->data_id, "comm_fail" );
					if (! $dev_offline) {
						// 获取smd_device,判断smd_device状态
						$smd_offline = get_alaLevel ( $devObj->smd_device_no, "comm_fail" );
						if(! $smd_offline)
						{
							//判断smd_device是否已被禁用
							$smdDevObj = $ci->mp_xjdh->Get_SMD_Device_By_no($devObj->smd_device_no);
							$smd_offline = $smdDevObj->active == 0 ? 1 : 0;
						}
					}
					if ($dev_offline || $smd_offline) {
						array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => 1,
								"signalType" => 0,
								"name" => "通讯状态",
								"value" => ($smd_offline?"采集板":"")."异常",
								"alaLevel" => 1,
								"signalTime" => "" 
						) );
					} else {
						if ($devObj->dev_type == 0 || $devObj->dev_type == 1) {
							$valueSet = Realtime::Get_AiDiRtData ( $deviceId );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => 1,
									"isanalyse"=>1,
									"signalType" => $devObj->dev_type,
									"name" => "值",
									"value" => $valueSet [0]->value,
									"alaLevel" => get_alaLevel($devObj->data_id, "value"),
									"signalTime" => $valueSet [0]->save_datetime 
							) );
						} elseif ($devObj->model == 'imem_12') {
							$valueSet = Realtime::Get_Imem12RtData ( $deviceId );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 1,
									"isanalyse"=>1,
									"signalType" => $devObj->dev_type,
									"name" => "第一路累计能耗",
									"value" => $valueSet [0]->w1,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 2,
									"isanalyse"=>1,
									"signalType" => $devObj->dev_type,
									"name" => "第一路实时功率",
									"value" => $valueSet [0]->p1,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 3,
									"signalType" => $devObj->dev_type,
									"name" => "第二路累计能耗",
									"value" => $valueSet [0]->w2,
									"alaLevel" => 0,
									"isanalyse"=>1,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 4,
									"isanalyse"=>1,
									"signalType" => $devObj->dev_type,
									"name" => "第二路实时功率",
									"value" => $valueSet [0]->p2,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 5,
									"isanalyse"=>1,
									"signalType" => $devObj->dev_type,
									"name" => "第三路累计能耗",
									"value" => $valueSet [0]->w3,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 6,
									"isanalyse"=>1,
									"signalType" => $devObj->dev_type,
									"name" => "第三路实时功率",
									"value" => $valueSet [0]->p3,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 7,
									"isanalyse"=>1,
									"signalType" => $devObj->dev_type,
									"name" => "第四路累计能耗",
									"value" => $valueSet [0]->w4,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 8,
									"isanalyse"=>1,
									"signalType" => $devObj->dev_type,
									"name" => "第四路实时功率",
									"value" => $valueSet [0]->p4,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
						} elseif ($devObj->model == 'battery_24') {
							$valueSet = Realtime::Get_BatRtData ( $deviceId, 24 );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 1,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "整组电压",
									"value" => $valueSet [0]->group_v,
									"alaLevel" => get_alaLevel ( $valueSet [0]->data_id, "group_voltage" ),
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 2,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "整组电流",
									"value" => $valueSet [0]->group_i,
									"alaLevel" => get_alaLevel ( $valueSet [0]->data_id, "group_current" ),
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 3,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "温度",
									"value" => $valueSet [0]->temperature,
									"alaLevel" => get_alaLevel ( $valueSet [0]->data_id, "temperature" ),
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							for($i = 0; $i < 24; $i ++) {
								$key = "battery_" . $i . "_value";
								array_push ( $ret, array (
										"lscId" => $lscId,
										"signalId" => $devObj->data_id * 1000 + 4 + $i,
										"isanalyse"=>1,
										"signalType" => 0,
										"name" => "第" . ($i+1) . "节电池电压",
										"value" => $valueSet [0]->voltage [$i],
										"alaLevel" => get_alaLevel ( $valueSet [0]->data_id, $key ),
										"signalTime" => $valueSet [0]->update_datetime 
								) ); 
							}
						} elseif ($devObj->model == "battery_32") {
							$valueSet = Realtime::Get_BatRtData ( $deviceId, 32 );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 1,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "整组电压",
									"value" => $valueSet [0]->group_v,
									"alaLevel" => get_alaLevel ( $valueSet [0]->data_id, "group_voltage" ),
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 2,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "整组电流",
									"value" => $valueSet [0]->group_i,
									"alaLevel" => get_alaLevel ( $valueSet [0]->data_id, "group_current" ),
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 3,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "温度",
									"value" => $valueSet [0]->temperature,
									"alaLevel" => get_alaLevel ( $valueSet [0]->data_id, "temperature" ),
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							for($i = 0; $i < 32; $i ++) {
								$key = "battery_" . $i . "_value";
								array_push ( $ret, array (
										"lscId" => $lscId,
										"signalId" => $devObj->data_id * 1000 + 4 + $i,
										"isanalyse"=>1,
										"signalType" => 0,
										"name" => "第".($i+1)."节电池电压",
										"value" => $valueSet [0]->voltage [$i],
										"alaLevel" => get_alaLevel ( $valueSet [0]->data_id, $key ),
										"signalTime" => $valueSet [0]->update_datetime 
								) );
							}
						} elseif ($devObj->model == 'fresh_air') {
							$valueSet = Realtime::Get_FreshAirRtData ( $deviceId );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 1,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "当前温度1",
									"value" => $valueSet [0]->temperature1,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 2,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "当前温度2",
									"value" => $valueSet [0]->temperature2,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 3,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "当前温度3",
									"value" => $valueSet [0]->temperature3,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 4,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "当前温度4",
									"value" => $valueSet [0]->temperature4,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 5,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "当前温度5",
									"value" => $valueSet [0]->temperature5,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 6,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "当前湿度1",
									"value" => $valueSet [0]->humidity1,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 7,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "当前湿度2",
									"value" => $valueSet [0]->humidity2,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 8,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "当前湿度3",
									"value" => $valueSet [0]->humidity3,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 9,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "当前湿度4",
									"value" => $valueSet [0]->humidity4,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 10,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "当前湿度5",
									"value" => $valueSet [0]->humidity5,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 11,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "出风温度",
									"value" => $valueSet [0]->wind_temperature,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 12,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "出风湿度",
									"value" => $valueSet [0]->wind_humidity,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 13,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "室外温度",
									"value" => $valueSet [0]->outside_temperature,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 14,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "室外湿度",
									"value" => $valueSet [0]->outside_humidity,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 15,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "humidifier_current湿度",
									"value" => $valueSet [0]->humidifier_current,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 16,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "平均温度",
									"value" => $valueSet [0]->average_temperature,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 17,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "平均湿度",
									"value" => $valueSet [0]->average_humidity,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 18,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "reserve_60_42_1",
									"value" => $valueSet [0]->reserve_60_42_1,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 19,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "reserve_60_42_2",
									"value" => $valueSet [0]->reserve_60_42_2,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 20,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "最高温度",
									"value" => $valueSet [0]->highest_temperature,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 21,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "公共警告",
									"value" => $valueSet [0]->runstate_alert,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 22,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "内风机",
									"value" => $valueSet [0]->runstate_fan,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 23,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "runstate_r1",
									"value" => $valueSet [0]->runstate_r1,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 24,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "runstate_r2",
									"value" => $valueSet [0]->runstate_r2,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 25,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "runstate_r3",
									"value" => $valueSet [0]->runstate_r3,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 26,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "runstate_r4",
									"value" => $valueSet [0]->runstate_r4,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 27,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "湿帘加湿排水",
									"value" => $valueSet [0]->runstate_drain,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 28,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "湿帘加湿注水",
									"value" => $valueSet [0]->runstate_fill,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 29,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "湿帘加湿水泵",
									"value" => $valueSet [0]->runstate_pump,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 30,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "外部空调",
									"value" => $valueSet [0]->runstate_ac,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							/*
							 * for($i=0;$i<135;$i++) { array_push($ret, array ( "lscId" => $lscId, "signalId" => $devObj->data_id * 1000 + 31, "signalType" => 0, "name" => "外部空调", "value" => $valueSet[0]->runstate_ac, "alaLevel" => 0, "signalTime" => $valueSet[0]->update_datetime )); }
							 */
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 31,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "温度点设定",
									"value" => $valueSet [0]->setting_temperature,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 32,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "湿度设定点",
									"value" => $valueSet [0]->setting_humidity,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 33,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "高温告警点",
									"value" => $valueSet [0]->high_temperature_alert,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 34,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "低温告警点",
									"value" => $valueSet [0]->low_temperature_alert,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 35,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "高湿报警点",
									"value" => $valueSet [0]->high_humidity_alert,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
							array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + 36,
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "低湿报警点",
									"value" => $valueSet [0]->low_humidity_alert,
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime 
							) );
						} elseif ($devObj->model == "psma-ac") {
							$count = 1;
							$valueSet = Realtime::Get_SwitchingPowerSupplyRtData($deviceId);
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "A相输入电流",
							"value" => $valueSet [0]->ia.'A',
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "B相输入电流",
							"value" => $valueSet [0]->ib,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "C相输入电流",
							"value" => $valueSet [0]->ic,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "交流输入路数",
							"value" => $valueSet[0]->channelCount,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
								
							for($CCount = 0; $CCount < $valueSet [0]->channelCount; $CCount++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压AB/A",
								"value" => $valueSet [0]->channelList [$CCount]->a."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压BC/B",
								"value" => $valueSet [0]->channelList [$CCount]->b."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压CA/C",
								"value" => $valueSet [0]->channelList [$CCount]->c."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入频率",
								"value" => $valueSet [0]->channelList [$CCount]->f."Hz",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压AB/A告警",
								"value" => $valueSet [0]->channelList [$CCount]->alert_a == 0 ? "正常":"告警“",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压BC/B告警",
								"value" => $valueSet [0]->channelList [$CCount]->alert_b == 0 ? "正常":"告警",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压CA/C告警",
								"value" => $valueSet [0]->channelList [$CCount+1]->alert_c == 0 ? "正常":"告警",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入频率告警",
								"value" => $valueSet[0]->channelList[$CCount+1]->alert_f == 0 ? "正常":"告警",
								"alaLevel" => 0,
								"signalTime" => $valueSet[0]->update_datetime
								) );
							
								/*for($a = 0; $a < 8; $a ++) {
									array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + ($count++),
									"signalType" => 0,
									"name" => "交流通道".($CCount). ":".Defines::$gPsmaAc[$a],
									"value" => $valueSet[0]->channelList[$CCount]->p[$a],
									"alaLevel" => 0,
									"signalTime" => $valueSet[0]->update_datetime
									) );
								}*/
							}
								
							/*array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "空气锁个数",
							"value" => $valueSet[0]->airlock_count,
							"alaLevel" => 0,
							"signalTime" => $valueSet[0]->update_datetime
							) );
							for($i = 0; $i < $valueSet[0]->airlock_count; $i ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => "第" . ($i + 1) . "个空气锁状态",
								"value" => $valueSet[0]->airlock_status[$i],
								"alaLevel" => 0,
								"signalTime" => $valueSet[0]->update_datetime
								) );
							}*/
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "交流切换状态",
							"value" => $valueSet [0]->ac_switch?"自动":"手动",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "事故照明灯状态",
							"value" => $valueSet [0]->light_switch?"开":"关",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "当前工作路号",
							"value" => "第".$valueSet [0]->working_line."路",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							/*array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "A相输入电流告警量",
							"value" => $valueSet [0]->ia_alert,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "B相输入电流告警量",
							"value" => $valueSet [0]->ib_alert,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "C相输入电流告警量",
							"value" => $valueSet [0]->ic_alert,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );*/
						} elseif ($devObj->model == "psma-dc") {
							$count =1;
							$valueSet = Realtime::Get_SwitchingPowerSupplyRtData($deviceId);
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "直流输出电压",
							"value" => $valueSet [0]->v."V",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "总负载电流",
							"value" => $valueSet [0]->i."A",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "蓄电池组数",
							"value" => $valueSet [0]->m."组",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							for($i = 0; $i < $valueSet [0]->m; $i ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "电池组".($i+1)."电流",
								"value" => $valueSet[0]->dc_i[$i]."A",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "监测直流分路电流数",
							"value" => $valueSet [0]->n,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							for($j = 0; $j < $valueSet [0]->n; $j ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "分路" . ($j+1) . "",
								"value" => $valueSet [0]->channelList [$j],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "电池组1电压",
							"value" => $valueSet [0]->p[0]."V",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "电池组2电压",
							"value" => $valueSet [0]->p[1]."V",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "电池房温度",
							"value" => $valueSet [0]->p[2]."°C",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							/*array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "未知字段p_count",
							"value" => $valueSet [0]->p_count,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							if($valueSet [0]->m == 0 ||$valueSet [0]->m==1)
							{
							
							}
							elseif($valueSet [0]->m == 2)
							{	for($k = 0; $k < $valueSet [0]->p_count; $k ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => Defines::$gPsmaDcEx[$k],
								"value" => $valueSet [0]->p [$k],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
							}*/
							/*array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "直流电压告警",
							"value" => $valueSet [0]->alert_v,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "直流容断丝数量",
							"value" => $valueSet [0]->alert_m_number,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );*/
							/*for($m = 0; $m < $valueSet [0]->alert_m_number; $m ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => "第" . ($m+1) . "个直流容断丝",
								"value" => $valueSet [0]->alert_m [$m],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}*/
							/*for($n = 0; $n < 13; $n ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => Defines::$gPsmaDc[$n],
								"value" => $valueSet [0]->alert_p [$n],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}*/
						} elseif ($devObj->model == "psma-rc") {
							$count = 1;
							$valueSet = Realtime::Get_SwitchingPowerSupplyRtData($deviceId);
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "整流模块输出电压",
							"value" => $valueSet [0]->out_v."V",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "整流模块数量",
							"value" => $valueSet [0]->channelCount,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							for($CCount = 0; $CCount < $valueSet [0]->channelCount; $CCount ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":输出电流",
								"value" => $valueSet [0]->channelList [$CCount]->out_i."A",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":模块温度",
								"value" => $valueSet [0]->channelList [$CCount]->p_temperature."°C",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":模块限流点（百分数）",
								"value" => $valueSet [0]->channelList [$CCount]->p_limiting,
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":模块输出电压",
								"value" => $valueSet [0]->channelList [$CCount]->p_out_v."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":输出电压保护点",
								"value" => $valueSet [0]->channelList [$CCount]->p_out_v_limiting,
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":开机/关机状态",
								"value" => $valueSet [0]->channelList [$CCount]->shutdown == 0 ? "开启":"关闭",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":限流/不限流状态",
								"value" => $valueSet [0]->channelList [$CCount]->i_limit ? "限流":"不限流",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":浮充/均充/测试状态",
								"value" => $valueSet [0]->channelList [$CCount]->charge == 0 ? '浮充' : ($valueSet [0]->channelList [$CCount]->charge == 1 ? '均充' :'测试'),
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":模块的控制状态",
								"value" => $valueSet [0]->channelList [$CCount]->auto_manual == 0 ? '自动' : '手动',
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "告警量",
								"value" => $valueSet [0]->channelList [$CCount]->fault,
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								for($i = 0; $i < 3; $i ++) {
									array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + ($count++),
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => Defines::$gPsmaRc[$i],
									"value" => $valueSet [0]->channelList [$CCount]->p [$i]?"告警":"正常",
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime
									) );
								}
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => Defines::$gPsmaRc[3],
								"value" => $valueSet [0]->channelList [$CCount]->p [3] == 226 ?"中断":"正常",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
						}elseif ($devObj->model == "m810g-ac"){
							$valueSet = Realtime::Get_SwitchingPowerSupplyRtData($deviceId);
							$count = 1;
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "A相输入电流",
							"value" => $valueSet [0]->ia."A",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "B相输入电流",
							"value" => $valueSet [0]->ib."A",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "C相输入电流",
							"value" => $valueSet [0]->ic."A",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "交流输入路数",
							"value" => $valueSet[0]->channelCount,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							 
							$CCount = 0;
							for(; $CCount < $valueSet [0]->channelCount; $CCount ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压AB/A",
								"value" => $valueSet [0]->channelList [$CCount]->a."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压BC/B",
								"value" => $valueSet [0]->channelList [$CCount]->b."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压CA/C",
								"value" => $valueSet [0]->channelList [$CCount]->c."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入频率",
								"value" => $valueSet [0]->channelList [$CCount]->f."Hz",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压AB/A告警",
								"value" => $valueSet [0]->channelList [$CCount]->alert_a?"告警":"正常",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压BC/B告警",
								"value" => $valueSet [0]->channelList [$CCount]->alert_b?"告警":"正常",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压CA/C告警",
								"value" => $valueSet [0]->channelList [$CCount]->alert_c?"告警":"正常",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入频率告警",
								"value" => $valueSet[0]->channelList[$CCount]->alert_f?"告警":"正常",
								"alaLevel" => 0,
								"signalTime" => $valueSet[0]->update_datetime
								) );
							
								for($a = 0; $a < 7; $a ++) {
									array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + ($count++),
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "交流通道".($CCount+1).":".Defines::$gM810gAc[$a],
									"value" => $valueSet[0]->channelList[$CCount]->p[$a]?"告警":"正常",
									"alaLevel" => 0,
									"signalTime" => $valueSet[0]->update_datetime
									) );
								}
							}
							 
							/*array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "空气锁个数",
							"value" => $valueSet[0]->airlock_count,
							"alaLevel" => 0,
							"signalTime" => $valueSet[0]->update_datetime
							) );
							for($i = 0; $i < $valueSet[0]->airlock_count; $i ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => "第" . ($i + 1) . "个空气锁状态",
								"value" => $valueSet[0]->airlock_status[$i],
								"alaLevel" => 0,
								"signalTime" => $valueSet[0]->update_datetime
								) );
							}*/
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "交流切换状态",
							"value" => $valueSet [0]->ac_switch?"自动":"手动",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "事故照明灯状态",
							"value" => $valueSet [0]->light_switch?"开":"关",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "当前工作路号",
							"value" => "第".$valueSet [0]->working_line."路",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							/*array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "A相输入电流告警量",
							"value" => $valueSet [0]->ia_alert,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "B相输入电流告警量",
							"value" => $valueSet [0]->ib_alert,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "C相输入电流告警量",
							"value" => $valueSet [0]->ic_alert,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );*/
						}elseif($devObj->model == "m810g-dc"){
							$count = 1;
							$valueSet = Realtime::Get_SwitchingPowerSupplyRtData($deviceId);
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "直流输出电压",
							"value" => $valueSet [0]->v."V",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "总负载电流",
							"value" => $valueSet [0]->i."A",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "蓄电池组数",
							"value" => $valueSet [0]->m,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							for($i = 0; $i < $valueSet [0]->m; $i ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "电池组".($i+1)."电流",
								"value" => $valueSet[0]->dc_i[$i]."A",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "监测直流分路电流数",
							"value" => $valueSet [0]->n,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							for($j = 0; $j < $valueSet [0]->n; $j ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "分路" . ($j+1) . "",
								"value" => $valueSet [0]->channelList [$j],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
							/*array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "未知字段p_count",
							"value" => $valueSet [0]->p_count,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							
							for($k = 0; $k < $valueSet [0]->p_count; $k ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => Defines::$gM810gDc[$k],
								"value" => $valueSet [0]->p [$k],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}*/
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "直流电压告警",
							"value" => $valueSet [0]->alert_v?"告警":"正常",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							/*array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "直流告警容断丝数量",
							"value" => $valueSet [0]->alert_m_number,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							for($m = 0; $m < $valueSet [0]->alert_m_number; $m ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => "第" . ($m+1) . "个直流告警容断丝",
								"value" => $valueSet [0]->alert_m [$m],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
							for($n = 0; $n < 17; $n ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => Defines::$gM810gDcEx[$n],
								"value" => $valueSet [0]->alert_p [$n],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}*/
						}elseif($devObj->model == "m810g-rc"){
							$valueSet = Realtime::Get_SwitchingPowerSupplyRtData($deviceId);
							$count = 1;
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "输出电压",
							"value" => $valueSet [0]->out_v."V",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "通道数",
							"value" => $valueSet [0]->channelCount,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							for($CCount = 0; $CCount < $valueSet [0]->channelCount; $CCount ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":输出电流",
								"value" => $valueSet [0]->channelList [$CCount]->out_i."A",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":模块温度",
								"value" => $valueSet [0]->channelList [$CCount]->p_temperature."°C",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":模块限流点（百分数）",
								"value" => $valueSet [0]->channelList [$CCount]->p_limiting,
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":模块输出电压",
								"value" => $valueSet [0]->channelList [$CCount]->p_out_v."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":交流AB线电压",
								"value" => $valueSet [0]->channelList [$CCount]->p_ab_v."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":交流BC线相电压",
								"value" => $valueSet [0]->channelList [$CCount]->p_bc_v."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":交流CA线相电压",
								"value" => $valueSet [0]->channelList [$CCount]->p_ca_v."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":模块位置号",
								"value" => $valueSet [0]->channelList [$CCount]->p_no,
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":开机/关机状态",
								"value" => $valueSet [0]->channelList [$CCount]->shutdown == 0 ? "开启":"关闭",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":限流/不限流状态",
								"value" => $valueSet [0]->channelList [$CCount]->i_limit ? "限流":"不限流",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":浮充/均充/测试状态",
								"value" => $valueSet [0]->channelList [$CCount]->charge == 0 ? '浮充' : ($valueSet [0]->channelList [$CCount]->charge == 1 ? '均充' :'测试'),
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								/*for($i = 0; $i < 5; $i ++) {
									array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + ($count++),
									"signalType" => 0,
									"name" => "整流模块".($CCount+1).":".Defines::$gM810gRc[$i],
									"value" => $valueSet [0]->channelList [$CCount]->status_p [$i],
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime
									) );
								}
								 
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => "告警量",
								"value" => $valueSet [0]->channelList [$CCount]->charge,
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								for($i = 0; $i < 4; $i ++) {
									array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + ($count++) ,
									"signalType" => 0,
									"name" => Defines::$gPsmaRc[$i],
									"value" => $valueSet [0]->channelList [$CCount]->p [$i],
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime
									) );
								}*/
							}
						}elseif ($devObj->model == "smu06c-ac"){
							$valueSet = Realtime::Get_SwitchingPowerSupplyRtData($deviceId);
							$count = 1;
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "A相输入电流",
							"value" => $valueSet [0]->ia."A",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "B相输入电流",
							"value" => $valueSet [0]->ib."A",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "C相输入电流",
							"value" => $valueSet [0]->ic."A",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "交流输入路数",
							"value" => $valueSet[0]->channelCount,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							 
							$CCount = 0;
							for(; $CCount < $valueSet [0]->channelCount; $CCount ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压AB/A",
								"value" => $valueSet [0]->channelList [$CCount]->a."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压BC/B",
								"value" => $valueSet [0]->channelList [$CCount]->b."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压CA/C",
								"value" => $valueSet [0]->channelList [$CCount]->c."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入频率",
								"value" => $valueSet [0]->channelList [$CCount]->f."Hz",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压AB/A告警",
								"value" => $valueSet [0]->channelList [$CCount]->alert_a?"告警":"正常",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压BC/B告警",
								"value" => $valueSet [0]->channelList [$CCount]->alert_b?"告警":"正常",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入线/相电压CA/C告警",
								"value" => $valueSet [0]->channelList [$CCount]->alert_c?"告警":"正常",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "交流通道".($CCount+1).":输入频率告警",
								"value" => $valueSet[0]->channelList[$CCount]->alert_f?"告警":"正常",
								"alaLevel" => 0,
								"signalTime" => $valueSet[0]->update_datetime
								) );
							
								for($a = 0; $a < 7; $a ++) {
									array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + ($count++),
									"isanalyse"=>1,
									"signalType" => 0,
									"name" => "交流通道".($CCount+1).":".Defines::$gM810gAc[$a],
									"value" => $valueSet[0]->channelList[$CCount]->p[$a]?"告警":"正常",
									"alaLevel" => 0,
									"signalTime" => $valueSet[0]->update_datetime
									) );
								}
							}
							 
							/*array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "空气锁个数",
							"value" => $valueSet[0]->airlock_count,
							"alaLevel" => 0,
							"signalTime" => $valueSet[0]->update_datetime
							) );
							for($i = 0; $i < $valueSet[0]->airlock_count; $i ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => "第" . ($i + 1) . "个空气锁状态",
								"value" => $valueSet[0]->airlock_status[$i],
								"alaLevel" => 0,
								"signalTime" => $valueSet[0]->update_datetime
								) );
							}*/
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "交流切换状态",
							"value" => $valueSet [0]->ac_switch?"自动":"手动",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "事故照明灯状态",
							"value" => $valueSet [0]->light_switch?"开":"关",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "当前工作路号",
							"value" => "第".$valueSet [0]->working_line."路",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							/*array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "A相输入电流告警量",
							"value" => $valueSet [0]->ia_alert,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "B相输入电流告警量",
							"value" => $valueSet [0]->ib_alert,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "C相输入电流告警量",
							"value" => $valueSet [0]->ic_alert,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );*/
						}elseif($devObj->model == "smu06c-dc"){
							$count = 1;
							$valueSet = Realtime::Get_SwitchingPowerSupplyRtData($deviceId);
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "直流输出电压",
							"value" => $valueSet [0]->v."V",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "总负载电流",
							"value" => $valueSet [0]->i."A",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "蓄电池组数",
							"value" => $valueSet [0]->m,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							for($i = 0; $i < $valueSet [0]->m; $i ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "电池组".($i+1)."电流",
								"value" => $valueSet[0]->dc_i[$i]."A",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "监测直流分路电流数",
							"value" => $valueSet [0]->n,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							for($j = 0; $j < $valueSet [0]->n; $j ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "分路" . ($j+1) . "",
								"value" => $valueSet [0]->channelList [$j],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
							/*array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "未知字段p_count",
							"value" => $valueSet [0]->p_count,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							
							for($k = 0; $k < $valueSet [0]->p_count; $k ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => Defines::$gM810gDc[$k],
								"value" => $valueSet [0]->p [$k],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}*/
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "直流电压告警",
							"value" => $valueSet [0]->alert_v?"告警":"正常",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							/*array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"signalType" => 0,
							"name" => "直流告警容断丝数量",
							"value" => $valueSet [0]->alert_m_number,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							for($m = 0; $m < $valueSet [0]->alert_m_number; $m ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => "第" . ($m+1) . "个直流告警容断丝",
								"value" => $valueSet [0]->alert_m [$m],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
							for($n = 0; $n < 17; $n ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => Defines::$gM810gDcEx[$n],
								"value" => $valueSet [0]->alert_p [$n],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}*/
						}elseif($devObj->model == "smu06c-rc"){
							$valueSet = Realtime::Get_SwitchingPowerSupplyRtData($deviceId);
							$count = 1;
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "输出电压",
							"value" => $valueSet [0]->out_v."V",
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + ($count++),
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "通道数",
							"value" => $valueSet [0]->channelCount,
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
							) );
							for($CCount = 0; $CCount < $valueSet [0]->channelCount; $CCount ++) {
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":输出电流",
								"value" => $valueSet [0]->channelList [$CCount]->out_i."A",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":模块温度",
								"value" => $valueSet [0]->channelList [$CCount]->p_temperature."°C",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":模块限流点（百分数）",
								"value" => $valueSet [0]->channelList [$CCount]->p_limiting,
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":模块输出电压",
								"value" => $valueSet [0]->channelList [$CCount]->p_out_v."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":交流AB线电压",
								"value" => $valueSet [0]->channelList [$CCount]->p_ab_v."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":交流BC线相电压",
								"value" => $valueSet [0]->channelList [$CCount]->p_bc_v."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":交流CA线相电压",
								"value" => $valueSet [0]->channelList [$CCount]->p_ca_v."V",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":模块位置号",
								"value" => $valueSet [0]->channelList [$CCount]->p_no,
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":开机/关机状态",
								"value" => $valueSet [0]->channelList [$CCount]->shutdown == 0 ? "开启":"关闭",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":限流/不限流状态",
								"value" => $valueSet [0]->channelList [$CCount]->i_limit ? "限流":"不限流",
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "整流模块".($CCount+1).":浮充/均充/测试状态",
								"value" => $valueSet [0]->channelList [$CCount]->charge == 0 ? '浮充' : ($valueSet [0]->channelList [$CCount]->charge == 1 ? '均充' :'测试'),
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								/*for($i = 0; $i < 5; $i ++) {
									array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + ($count++),
									"signalType" => 0,
									"name" => "整流模块".($CCount+1).":".Defines::$gM810gRc[$i],
									"value" => $valueSet [0]->channelList [$CCount]->status_p [$i],
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime
									) );
								}
								 
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + ($count++),
								"signalType" => 0,
								"name" => "告警量",
								"value" => $valueSet [0]->channelList [$CCount]->charge,
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
								for($i = 0; $i < 4; $i ++) {
									array_push ( $ret, array (
									"lscId" => $lscId,
									"signalId" => $devObj->data_id * 1000 + ($count++) ,
									"signalType" => 0,
									"name" => Defines::$gPsmaRc[$i],
									"value" => $valueSet [0]->channelList [$CCount]->p [$i],
									"alaLevel" => 0,
									"signalTime" => $valueSet [0]->update_datetime
									) );
								}*/
							}
						}elseif ($devObj->model == 'liebert-ups') {
							$count = 1;
							$valueSet = Realtime::Get_LiebertUpsRtData ( $deviceId );
// 							foreach ( $valueSet [0]->aList as $index => $a ) {
// 								array_push ( $ret, array (
// 										"lscId" => $lscId,
// 										"signalId" => $devObj->data_id * 1000 + ($count++),
// 										"signalType" => 0,
// 										"name" => Defines::$gLiebertUpsRemoteMesureParams [$index],
// 										"value" => $a->val,
// 										"alaLevel" => $valueSet [0]->alert,
// 										"signalTime" => $valueSet [0]->update_datetime 
// 								) );
// 							}
                            for($index=0;$index<30;$index++)
                            {
                            	array_push ( $ret, array (
                            	"lscId" => $lscId,
                            	"signalId" => $devObj->data_id * 1000 + ($count++),
                            	"isanalyse"=>1,
                            	"signalType" => 0,
                            	"name" => Defines::$gLiebertUpsRemoteMesureParams [$index],
                            	"value" => $valueSet [0]->aList[$index]->val,
                            	"alaLevel" => $valueSet [0]->alert,
                            	"signalTime" => $valueSet [0]->update_datetime
                            	) );
                            }
							/* foreach ( $valueSet [0]->d1List as $indexx => $d1 ) {
								if(0==strcmp(Defines::$gLiebertUpsRemoteSignalParams[$indexx],Defines::$gLiebertUpsRemoteSignalParams[0]))
								{
									continue;
								}
								else
								{
									array_push ( $ret, array (
										"lscId" => $lscId,
										"signalId" => $devObj->data_id * 1000 + $indexx + 32,
										"signalType" => 0,
										"name" => Defines::$gLiebertUpsRemoteSignalParams [$indexx],
										"value" => $d1->val,
										"alaLevel" => $valueSet [0]->alert,
										"signalTime" => $valueSet [0]->update_datetime 
							    	) );
								
							} */
/* 
                            $UpsCount = 1;   //UPS遥信量列表计数变量
							for($indexx=0;$indexx<=80;$indexx++)
							{
								if(!strcmp(Defines::$gLiebertUpsRemoteSignalParams[$indexx],Defines::$gLiebertUpsRemoteSignalParams[0]))
								{
									continue;
								}
								else
								{
									if($valueSet[0]->d1List[$indexx]->val == 0)
									{
										if($UpsCount<5)
							    		{
								    		array_push ( $ret, array (
									    	"lscId" => $lscId,
								    		"signalId" => $devObj->data_id * 1000 + ($count++),
									    	"signalType" => 0,
									    	"name" => Defines::$gLiebertUpsRemoteSignalParams [$indexx],
									    	"value" => "关闭",
									    	"alaLevel" => $valueSet [0]->alert,
								    		"signalTime" => $valueSet [0]->update_datetime
								    		) );
								    	}elseif ($UpsCount==5){
								    		array_push ( $ret, array (
								    		"lscId" => $lscId,
								    		"signalId" => $devObj->data_id * 1000 + ($count++),
								    		"signalType" => 0,
								    		"name" => Defines::$gLiebertUpsRemoteSignalParams [$indexx],
								    		"value" => "断开",
								    		"alaLevel" => $valueSet [0]->alert,
								    		"signalTime" => $valueSet [0]->update_datetime
								    		) );
								    	}elseif ( ($UpsCount > 5 && $UpsCount < 62) || ($UpsCount==67) || ($UpsCount==68) ){
								    		array_push ( $ret, array (
								    		"lscId" => $lscId,
								    		"signalId" => $devObj->data_id * 1000 + ($count++),
								    		"signalType" => 0,
								    		"name" => Defines::$gLiebertUpsRemoteSignalParams [$indexx],
								    		"value" => "否",
								    		"alaLevel" => $valueSet [0]->alert,
								    		"signalTime" => $valueSet [0]->update_datetime
								    		) );
								    	}elseif( $UpsCount>= 62 && $UpsCount < 67 ){
								    		array_push ( $ret, array (
								    		"lscId" => $lscId,
								    		"signalId" => $devObj->data_id * 1000 + ($count++),
								    		"signalType" => 0,
								    		"name" => Defines::$gLiebertUpsRemoteSignalParams [$indexx],
								    		"value" => "正常",
								    		"alaLevel" => $valueSet [0]->alert,
								    		"signalTime" => $valueSet [0]->update_datetime
								    		) );
								    	}
									}else{
										array_push ( $ret, array (
						    			"lscId" => $lscId,
					    				"signalId" => $devObj->data_id * 1000 + ($count++),
						    			"signalType" => 0,
						    			"name" => Defines::$gLiebertUpsRemoteSignalParams [$indexx],
							    		"value" => $valueSet [0]->d1List[$indexx]->val,
							    		"alaLevel" => $valueSet [0]->alert,
							    		"signalTime" => $valueSet [0]->update_datetime
							    		) );
									}
									$UpsCount++;
								}
							} */
						}
						elseif($devObj->model == 'liebert-pex')
						{
							$valueSet = Realtime::Get_LiebertPexRtData($deviceId);
							var_dump($valueSet);
						}
						elseif($devObj->model == 'aeg-ms10m'){
							$valueSet = Realtime::Get_AegMS10MRtData($deviceId);
							for($i=0;$i<35;$i++)
							{
								array_push ( $ret, array (
							    "lscId" => $lscId,
						    	"signalId" => $devObj->data_id * 1000 + $i+1,
						    	"isanalyse"=>1,
						    	"signalType" => 0,
						    	"name" => "基本测量参数地址区".($i+1)."",
						    	"value" => $valueSet [0]->reg1[$i],
						    	"alaLevel" => 0,
						    	"signalTime" => $valueSet [0]->update_datetime
						    	) );
							}
							
							for($j=0;$j<15;$j++)
							{
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + $j+36,
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "电度参量地址区".($j+1)."",
								"value" => $valueSet [0]->reg2[$j],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
							for($k=0;$k<6;$k++)
							{
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + $k+51,
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "DI 数据地址区".($k+1)."",
								"value" => $valueSet [0]->di[$k],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
							
							for($l=0;$l<6;$l++)
							{
								array_push ( $ret, array (
								"lscId" => $lscId,
								"signalId" => $devObj->data_id * 1000 + $l+57,
								"isanalyse"=>1,
								"signalType" => 0,
								"name" => "DO 数据地址区".($l+1)."",
								"value" => $valueSet [0]->d_o[$l],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
						}elseif($devObj->model =='aeg-ms10se'){
							$valueSet = Realtime::Get_AegMS10SERtData($deviceId);
							for($i=0;$i<64;$i++)
							{
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + $i+1,
							"isanalyse"=>1,
									"signalType" => 0,
									"name" => "基本测量参数数据区".($i+1)."",
											"value" => $valueSet [0]->reg1[$i],
													"alaLevel" => 0,
													"signalTime" => $valueSet [0]->update_datetime
															) );
							}
								
							for($j=0;$j<26;$j++)
							{
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + $j+65,
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "单位时间内最大值统计区".($j+1)."",
							"value" => $valueSet [0]->reg2[$j],
							"alaLevel" => 0,
							"signalTime" => $valueSet [0]->update_datetime
									) );
							}
							for($k=0;$k<26;$k++)
							{
							array_push ( $ret, array (
							"lscId" => $lscId,
							"signalId" => $devObj->data_id * 1000 + $k+91,
							"isanalyse"=>1,
							"signalType" => 0,
							"name" => "单位时间内平均值统计区".($k+1)."",
							"value" => $valueSet [0]->reg3[$k],
								"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
								) );
							}
				
							for($l=0;$l<197;$l++)
							{
								array_push ( $ret, array (
										"lscId" => $lscId,
										"signalId" => $devObj->data_id * 1000 + $l+117,
										"isanalyse"=>1,
										"signalType" => 0,
										"name" => "谐波分析数据区".($l+1)."",
										"value" => $valueSet [0]->reg4[$l],
										"alaLevel" => 0,
								"signalTime" => $valueSet [0]->update_datetime
									) );
							}
						}
					}
				}
			}
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function addStationByUserId($argu) {
			$ci = &get_instance ();
			
			$ret = array ();
			$xmlObj = simplexml_load_string ( $argu );
			$oaId = strval ( $xmlObj->oaId );
			$lscId = intval ( $xmlObj->lscId );
			$stationId = $xmlObj->stationId;
			
			$userObj = User::GetUser ( $oaId );
			if (count ( $userObj ) == 0) {
				$ret = array (
						"resultState" => 0,
						"resultDesc" => "未找到用户" 
				);
			} else {
				if ($ci->mp_xjdh->Has_UserStation ( $userObj->id, $stationId )) {
					$ret = array (
							"resultState" => 0,
							"resultDesc" => "此常用局站已添加" 
					);
				} else {
					$ci->mp_xjdh->Add_UserStation ( $userObj->id, $stationId );
					$ret = array (
							"resultState" => 1,
							"resultDesc" => "常用局站添加成功" 
					);
				}
			}
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function deleteStationByUserId($argu) {
			$ci = &get_instance ();
			
			$ret = array ();
			$xmlObj = simplexml_load_string ( $argu );
			$oaId = strval ( $xmlObj->oaId );
			$lscId = intval ( $xmlObj->lscId );
			$stationId = $xmlObj->stationId;
			
			$userObj = User::GetUser ( $oaId );
			if (count ( $userObj ) == 0) {
				$ret = array (
						"resultState" => 0,
						"resultDesc" => "未找到用户" 
				);
			} else {
				$hasUS = $ci->mp_xjdh->Has_UserStation ( $userObj->id, $stationId );
				if (! $hasUS) {
					$ret = array (
							"resultState" => 0,
							"resultDesc" => "此常用局站不存在" 
					);
				} else {
					$ci->mp_xjdh->Del_UserStation ( $userObj->id, $stationId );
					$ret = array (
							"resultState" => 1,
							"resultDesc" => "常用局站删除成功" 
					);
				}
			}
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		function getSignalValueAnalyse($argu) {
			$ci = &get_instance ();
			
			$ret = array ();
			$xmlObj = simplexml_load_string ( $argu );
			$oaId = strval ( $xmlObj->oaId );
			$lscId = intval ( $xmlObj->lscId );
			$signalId = $xmlObj->signalId;
			
			$userObj = User::GetUser ( $oaId );
			if (count ( $userObj ) == 0) {
				$ret = array (
						"resultState" => 0,
						"resultDesc" => "未找到用户" 
				);
			} else {
				$data_id = $signalId / 1000;
				$data_id = intval ( $data_id );
				$index = intval ( $signalId % 1000 );
				$devObj = $ci->mp_xjdh->Get_Device ( $data_id );
				if (count ( $devObj ) == 0) {
					$ret = array (
							"resultState" => 0,
							"resultDesc" => "未找到指定设备",
							"total" => 0,
							"totalPages" => 0,
							"pageSize" => 0,
							"currentPage" => 1,
							'maxValue' => 0,
							"minValue" => 0,
							array () 
					);
				} else {
					$ret = array (
							"resultState" => 1,
							"resultDesc" => "",
							"total" => 10,
							"totalPages" => 10,
							"pageSize" => 10,
							"currentPage" => 1,
							'maxValue' => 0,
							"minValue" => 0 
					);
					// 获取最近7天的数据
					$dayArray = array ();
					
					$today = new DateTime ();
					array_push ( $dayArray, date_format ( $today, "Y-m-d" ) );
					for($i = 0; $i < 6; $i ++) {
						$today->sub ( new DateInterval ( "P1D" ) );
						array_push ( $dayArray, date_format ( $today, "Y-m-d" ) );
					}
					$dayArray = array_reverse ( $dayArray );
					$maxValue = - 99999;
					$minValue = 99999;
					if ($devObj->dev_type == 0 || $devObj->dev_type == 1) {
						
						$variable = "";
						$unit = "";
						if ($devObj->dev_type == 0) {
							$variable = "di" . $devObj->port;
						} else if ($devObj->dev_type == 1) {
							$variable = "ai" . $devObj->port;
							if ($devObj->model == "temperature") {
								$unit = "℃";
							} else if ($devObj->model == "humid") {
								$unit = "%";
							}
						}
						
						foreach ( $dayArray as $day ) {
							$devHistory = $ci->mp_xjdh->Get_AiDi_Signal_History_By_Date ( $data_id, $day );
							array_push ( $ret, array (
									"signalTime" => $devHistory->save_datetime,
									"value" => $devHistory->$variable,
									"unit" => $unit,
									"isanalyse"=>1
							) );
							if ($devHistory->$variable > $maxValue)
								$maxValue = $devHistory->$variable;
							if ($devHistory->$variable < $minValue)
								$minValue = $devHistory->$variable;
						}
						$ret ["maxValue"] = $maxValue;
						$ret ["minValue"] = $minValue;
					} elseif ($devObj->model == 'imem_12') {
						//$ret ["resultState"] = 0;
						//$ret ["resultDesc"] = "分析数据暂未提供";
						foreach ( $dayArray as $day ) {
							$value = 0;
							$unit = "";
							$devHistory = $ci->mp_xjdh->Get_Imem12_History_By_Date ( $data_id, $day );
							switch ($signalId) {
								case 1 :
									// group voltage
									$value = $devHistory->voltage;
									$unit = "V";
									break;
								case 2 :
									// current
									$value = $devhistory->current;
									$unit = "A";
									break;
								case 3 :
									$value = $devHistory->temperature;
									$unit = "℃";
									break;
								default :
									// for single battery voltage
									$v = unpack ( 'f*', substr ( $devHistory->battery_voltage, 4, 24 * 4 ) );
									$value = number_format ( $v [$signalId - 4], 3 );
							}
							array_push ( $ret, array (
							"signalTime" => $devHistory->update_datetime,
							"value" => $value,
							"unit" => $unit
							) );
							if ($value > $maxValue)
								$maxValue = $value;
							if ($value < $minValue)
								$minValue = $value;
						}
						$ret ["maxValue"] = $maxValue;
						$ret ["minValue"] = $minValue;
					} elseif ($devObj->model == 'battery_24') {
						foreach ( $dayArray as $day ) {
							$value = 0;
							$unit = "";
							$devHistory = $ci->mp_xjdh->Get_Bma24_History_By_Date ( $data_id, $day );
							switch ($signalId) {
								case 1 :
									// group voltage
									$value = $devHistory->voltage;
									$unit = "V";
									break;
								case 2 :
									// current
									$value = $devhistory->current;
									$unit = "A";
									break;
								case 3 :
									$value = $devHistory->temperature;
									$unit = "℃";
									break;
								default :
									// for single battery voltage
									$v = unpack ( 'f*', substr ( $devHistory->battery_voltage, 4, 24 * 4 ) );
									$value = number_format ( $v [$signalId - 4], 3 );
							}
							array_push ( $ret, array (
									"signalTime" => $devHistory->update_datetime,
									"value" => $value,
									"unit" => $unit 
							) );
							if ($value > $maxValue)
								$maxValue = $value;
							if ($value < $minValue)
								$minValue = $value;
						}
						$ret ["maxValue"] = $maxValue;
						$ret ["minValue"] = $minValue;
					} else if ($devObj->model == "battery_32") {
						foreach ( $dayArray as $day ) {
							$value = 0;
							$unit = "";
							$devHistory = $ci->mp_xjdh->Get_Bma32_History_By_Date ( $data_id, $day );
							switch ($signalId) {
								case 1 :
									// group voltage
									$value = $devHistory->voltage;
									$unit = "V";
									break;
								case 2 :
									// current
									$value = $devhistory->current;
									$unit = "A";
									break;
								case 3 :
									$value = $devHistory->temperature;
									$unit = "℃";
									break;
								default :
									// for single battery voltage
									$v = unpack ( 'f*', substr ( $devHistory->battery_voltage, 4, 32 * 4 ) );
									$value = number_format ( $v [$signalId - 4], 3 );
							}
							array_push ( $ret, array (
									"signalTime" => $devHistory->update_datetime,
									"value" => $value,
									"unit" => $unit 
							) );
							if ($value > $maxValue)
								$maxValue = $value;
							if ($value < $minValue)
								$minValue = $value;
						}
						$ret ["maxValue"] = $maxValue;
						$ret ["minValue"] = $minValue;
					} elseif ($devObj->model == "psma-dc" ) {
						//$ret ["resultState"] = 0;
						//$ret ["resultDesc"] = "分析数据暂未提供";
						
						foreach ( $dayArray as $day ) {
							$value = 0;
							$unit = "";
							$devHistory = $ci->mp_xjdh->Get_PsmaDc_History_By_Date ( $data_id, $day );
							switch ($signalId) {
								case 1 :
									// group voltage
									$value = $devHistory->voltage;
									$unit = "V";
									break;
								case 2 :
									// current
									$value = $devhistory->current;
									$unit = "A";
									break;
								case 3 :
									$value = $devHistory->temperature;
									$unit = "℃";
									break;
								default :
									// for single battery voltage
									$v = unpack ( 'f*', substr ( $devHistory->battery_voltage, 4, 32 * 4 ) );
									$value = number_format ( $v [$signalId - 4], 3 );
							}
							array_push ( $ret, array (
							"signalTime" => $devHistory->update_datetime,
							"value" => $value,
							"unit" => $unit
							) );
							if ($value > $maxValue)
								$maxValue = $value;
							if ($value < $minValue)
								$minValue = $value;
						}
						$ret ["maxValue"] = $maxValue;
						$ret ["minValue"] = $minValue;
					}elseif ($devObj->model == "m810g-dc"){
						foreach ( $dayArray as $day ) {
							$value = 0;
							$unit = "";
							$devHistory = $ci->mp_xjdh->Get_M810gDc_History_By_Date ( $data_id, $day );
							switch ($signalId) {
								case 1 :
									// group voltage
									$value = $devHistory->voltage;
									$unit = "V";
									break;
								case 2 :
									// current
									$value = $devhistory->current;
									$unit = "A";
									break;
								case 3 :
									$value = $devHistory->temperature;
									$unit = "℃";
									break;
								default :
									// for single battery voltage
									$v = unpack ( 'f*', substr ( $devHistory->battery_voltage, 4, 32 * 4 ) );
									$value = number_format ( $v [$signalId - 4], 3 );
							}
							array_push ( $ret, array (
							"signalTime" => $devHistory->update_datetime,
							"value" => $value,
							"unit" => $unit
							) );
							if ($value > $maxValue)
								$maxValue = $value;
							if ($value < $minValue)
								$minValue = $value;
						}
						$ret ["maxValue"] = $maxValue;
						$ret ["minValue"] = $minValue;
					}elseif ($devObj->model == "smu06c-dc"){
						foreach ( $dayArray as $day ) {
							$value = 0;
							$unit = "";
							$devHistory = $ci->mp_xjdh->Get_M810gDc_History_By_Date ( $data_id, $day );
							switch ($signalId) {
								case 1 :
									// group voltage
									$value = $devHistory->voltage;
									$unit = "V";
									break;
								case 2 :
									// current
									$value = $devhistory->current;
									$unit = "A";
									break;
								case 3 :
									$value = $devHistory->temperature;
									$unit = "℃";
									break;
								default :
									// for single battery voltage
									$v = unpack ( 'f*', substr ( $devHistory->battery_voltage, 4, 32 * 4 ) );
									$value = number_format ( $v [$signalId - 4], 3 );
							}
							array_push ( $ret, array (
							"signalTime" => $devHistory->update_datetime,
							"value" => $value,
							"unit" => $unit
							) );
							if ($value > $maxValue)
								$maxValue = $value;
							if ($value < $minValue)
								$minValue = $value;
						}
						$ret ["maxValue"] = $maxValue;
						$ret ["minValue"] = $minValue;
					}elseif ($devObj->model == "psma-rc"){
						foreach ( $dayArray as $day ) {
							$value = 0;
							$unit = "";
							$devHistory = $ci->mp_xjdh->Get_PsmaRc_History_By_Date ( $data_id, $day );
							switch ($signalId) {
								case 1 :
									// group voltage
									$value = $devHistory->voltage;
									$unit = "V";
									break;
								case 2 :
									// current
									$value = $devhistory->current;
									$unit = "A";
									break;
								case 3 :
									$value = $devHistory->temperature;
									$unit = "℃";
									break;
								default :
									// for single battery voltage
									$v = unpack ( 'f*', substr ( $devHistory->battery_voltage, 4, 32 * 4 ) );
									$value = number_format ( $v [$signalId - 4], 3 );
							}
							array_push ( $ret, array (
							"signalTime" => $devHistory->update_datetime,
							"value" => $value,
							"unit" => $unit
							) );
							if ($value > $maxValue)
								$maxValue = $value;
							if ($value < $minValue)
								$minValue = $value;
						}
						$ret ["maxValue"] = $maxValue;
						$ret ["minValue"] = $minValue;
					}elseif ($devObj->model == "m810g-rc") {
						//$ret ["resultState"] = 0;
						//$ret ["resultDesc"] = "分析数据暂未提供";
						foreach ( $dayArray as $day ) {
							$value = 0;
							$unit = "";
							$devHistory = $ci->mp_xjdh->Get_M810gRc_History_By_Date ( $data_id, $day );
							switch ($signalId) {
								case 1 :
									// group voltage
									$value = $devHistory->voltage;
									$unit = "V";
									break;
								case 2 :
									// current
									$value = $devhistory->current;
									$unit = "A";
									break;
								case 3 :
									$value = $devHistory->temperature;
									$unit = "℃";
									break;
								default :
									// for single battery voltage
									$v = unpack ( 'f*', substr ( $devHistory->battery_voltage, 4, 32 * 4 ) );
									$value = number_format ( $v [$signalId - 4], 3 );
							}
							array_push ( $ret, array (
							"signalTime" => $devHistory->update_datetime,
							"value" => $value,
							"unit" => $unit
							) );
							if ($value > $maxValue)
								$maxValue = $value;
							if ($value < $minValue)
								$minValue = $value;
						}
						$ret ["maxValue"] = $maxValue;
						$ret ["minValue"] = $minValue;
					}elseif ($devObj->model == "smu06c-rc") {
						//$ret ["resultState"] = 0;
						//$ret ["resultDesc"] = "分析数据暂未提供";
						foreach ( $dayArray as $day ) {
							$value = 0;
							$unit = "";
							$devHistory = $ci->mp_xjdh->Get_M810gRc_History_By_Date ( $data_id, $day );
							switch ($signalId) {
								case 1 :
									// group voltage
									$value = $devHistory->voltage;
									$unit = "V";
									break;
								case 2 :
									// current
									$value = $devhistory->current;
									$unit = "A";
									break;
								case 3 :
									$value = $devHistory->temperature;
									$unit = "℃";
									break;
								default :
									// for single battery voltage
									$v = unpack ( 'f*', substr ( $devHistory->battery_voltage, 4, 32 * 4 ) );
									$value = number_format ( $v [$signalId - 4], 3 );
							}
							array_push ( $ret, array (
							"signalTime" => $devHistory->update_datetime,
							"value" => $value,
							"unit" => $unit
							) );
							if ($value > $maxValue)
								$maxValue = $value;
							if ($value < $minValue)
								$minValue = $value;
						}
						$ret ["maxValue"] = $maxValue;
						$ret ["minValue"] = $minValue;
					} else {
						$ret ["resultState"] = 0;
						$ret ["resultDesc"] = "分析数据暂未提供";
					}
				}
			}
			$serializer = new XML_Serializer ( array (
					"encoding" => "UTF-8",
					"rootName" => "root",
					"defaultTagName" => "list" 
			) );
			$result = $serializer->serialize ( $ret );
			$str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$str .= $serializer->getSerializedData ();
			return $str;
		}
		$this->nusoap_server->service ( file_get_contents ( "php://input" ) );
	}
}
