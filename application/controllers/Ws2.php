<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');


class Ws extends CI_Controller
{
	var $nusoap_server = null;
    public function __construct ()
    {
    	parent::__construct();
    	$this->nusoap_server = new soap_server ();
    	$this->nusoap_server->soap_defencoding = 'UTF-8';
    	$this->nusoap_server->decode_utf8 = false;
    	$this->nusoap_server->xml_encoding = 'UTF-8';
    	$this->nusoap_server->configureWSDL ('ws',"urn:ws"); // 打开 wsdl 支持
		
    	/*$this->nusoap_server->wsdl->addComplexType(
    			'Member',
    			'complexType',
    			'struct',
    			'all',
    			'',
    			array(
    					'id' => array('name' => 'id' , 'type' => 'xsd:integer'),
    					'username' => array('name' => 'username', 'type' => 'xsd:string')
    			)
    	);*/ 
    	//My Station   	
    	$this->nusoap_server->wsdl->addComplexType(
			"MyStationOutput","complexType","struct","all","",
    			array(
    				"lscId"=>array("name"=>"lscId","type"=>"xsd:int"),
    				"stationId"=>array("name"=>"stationId","type"=>"xsd:long"),
    				"name"=>array("name"=>"name","type"=>"xsd:string"),
    				"alaLevel"=>array("name"=>"alaLevel","type"=>"xsd:int"))    			
    	);
    	$this->nusoap_server->wsdl->addComplexType(
    		"MyStationOutputArray","complexType","array","","SOAP-ENC:Array",
    			array(),
    			array(array("ref"=>"SOAP-ENC:arrayType",'wsdl:arrayType'=>"tns:MyStationOutput[]")),
    			"tns:MyStationOutput");
    	$this->nusoap_server->wsdl->AddComplexType(
    		"MyStationRes","ComplexType","struct","all","",
    			array("resultState"=>array("name"=>"resultState","type"=>"xsd:int"),
    					"resultDesc"=>array("name"=>"resultDesc","type"=>"xsd:string"),
    					"total"=>array("name"=>"total","type"=>"xsd:int"),
    					"totalPages"=>array("name"=>"totalPages","type"=>"xsd:int"),
    					"pageSize"=>array("name"=>"pageSize","type"=>"xsd:int"),
    					"currentPage"=>array("name"=>"currentPage", "type"=>"xsd:int"),
    					"list"=>array("name"=>"list","type"=>"tns:MyStationOutputArray"))
    	);
    	$this->nusoap_server->register(
    			"MyStation",
    			array(
    					"oaId" => "xsd:string",
    					"searchKey" => "xsd:string",
    					"pageNo" => "xsd:int",
    					"pageSize" => "xsd:int"
    			),
    			array("return"=>"tns:MyStationRes"),
    			'urn:ws',                         // namespace
    			'urn:ws#MyStation'    			
    	);
    	//My Alarm
    	$this->nusoap_server->wsdl->addComplexType(
    			"MyAlarmOutput","complexType","struct","all","",
    			array(
    					"id"=>array("name"=>"id","type"=>"xsd:int"),
    					"startTime"=>array("name"=>"startTime","type"=>"xsd:string"),
    					"nodeName"=>array("name"=>"nodeName","type"=>"xsd:string"),
    					"alarmDesc"=>array("name"=>"alarmDesc","type"=>"xsd:string"),
    					"alaLevel"=>array("name"=>"alaLevel","type"=>"xsd:int"))
    	);
    	$this->nusoap_server->wsdl->addComplexType(
    			"MyAlarmOutputArray","complexType","array","","SOAP-ENC:Array",
    			array(),
    			array(array("ref"=>"SOAP-ENC:arrayType",'wsdl:arrayType'=>"tns:MyAlarmOutput[]")),
    			"tns:MyAlarmOutput");
    	$this->nusoap_server->wsdl->AddComplexType(
    			"MyAlarmRes","ComplexType","struct","all","",
    			array("resultState"=>array("name"=>"resultState","type"=>"xsd:int"),
    					"resultDesc"=>array("name"=>"resultDesc","type"=>"xsd:string"),
    					"total"=>array("name"=>"total","type"=>"xsd:int"),
    					"totalPages"=>array("name"=>"totalPages","type"=>"xsd:int"),
    					"pageSize"=>array("name"=>"pageSize","type"=>"xsd:int"),
    					"currentPage"=>array("name"=>"currentPage", "type"=>"xsd:int"),
    					"list"=>array("name"=>"list","type"=>"tns:MyAlarmOutputArray"))
    	);
    	$this->nusoap_server->register(
    			"MyAlarm",
    			array(
    					"oaId" => "xsd:string",
    					"pageNo" => "xsd:int",
    					"pageSize" => "xsd:int"
    			),
    			array("return"=>"tns:MyAlarmRes"),
    			'urn:ws',                         // namespace
    			'urn:ws#MyAlarm'
    	);
    	//设备查询 DeviceQuery
    	$this->nusoap_server->wsdl->addComplexType(
    			"DeviceQueryOutput","complexType","struct","all","",
    			array(
    					"lscId"=>array("name"=>"lscId","type"=>"xsd:int"),
    					"deviceId"=>array("name"=>"deviceId","type"=>"xsd:int"),
    					"deviceType"=>array("name"=>"deviceType","type"=>"xsd:int"),
    					"name"=>array("name"=>"name","type"=>"xsd:string"),
    					"alaLevel"=>array("name"=>"alaLevel","type"=>"xsd:int"))
    	);
    	$this->nusoap_server->wsdl->addComplexType(
    			"DeviceQueryOutputArray","complexType","array","","SOAP-ENC:Array",
    			array(),
    			array(array("ref"=>"SOAP-ENC:arrayType",'wsdl:arrayType'=>"tns:DeviceQueryOutput[]")),
    			"tns:DeviceQueryOutput");
    	
    	$this->nusoap_server->wsdl->AddComplexType(
    			"DeviceQueryRes","ComplexType","struct","all","",
    			array("resultState"=>array("name"=>"resultState","type"=>"xsd:int"),
    					"resultDesc"=>array("name"=>"resultDesc","type"=>"xsd:string"),
    					"total"=>array("name"=>"total","type"=>"xsd:int"),
    					"totalPages"=>array("name"=>"totalPages","type"=>"xsd:int"),
    					"pageSize"=>array("name"=>"pageSize","type"=>"xsd:int"),
    					"currentPage"=>array("name"=>"currentPage", "type"=>"xsd:int"),
    					"list"=>array("name"=>"list","type"=>"tns:DeviceQueryOutputArray"))
    	);
    	$this->nusoap_server->register(
    			"DeviceQuery",
    			array(
    					"oaId" => "xsd:string",
    					"lscId"=>"xsd:int",
    					"stationId"=>"xsd:int",
    					"pageNo" => "xsd:int",
    					"pageSize" => "xsd:int"
    			),
    			array("return"=>"tns:DeviceQueryRes"),
    			'urn:ws',                         // namespace
    			'urn:ws#DeviceQuery'
    	);
    	//告警查询 Alarm Query
    	$this->nusoap_server->wsdl->addComplexType(
    			"AlarmQueryOutput","complexType","struct","all","",
    			array(
    					"id"=>array("name"=>"id","type"=>"xsd:int"),
    					"startTime"=>array("name"=>"startTime","type"=>"xsd:string"),
    					"nodeName"=>array("name"=>"nodeName","type"=>"xsd:string"),
    					"alarmDesc"=>array("name"=>"alarmDesc","type"=>"xsd:string"),
    					"alaLevel"=>array("name"=>"alaLevel","type"=>"xsd:int"))
    	);
    	$this->nusoap_server->wsdl->addComplexType(
    			"AlarmQueryOutputArray","complexType","array","","SOAP-ENC:Array",
    			array(),
    			array(array("ref"=>"SOAP-ENC:arrayType",'wsdl:arrayType'=>"tns:AlarmQueryOutput[]")),
    			"tns:AlarmQueryOutput");
    	$this->nusoap_server->wsdl->AddComplexType(
    			"AlarmQueryRes","ComplexType","struct","all","",
    			array("resultState"=>array("name"=>"resultState","type"=>"xsd:int"),
    					"resultDesc"=>array("name"=>"resultDesc","type"=>"xsd:string"),
    					"total"=>array("name"=>"total","type"=>"xsd:int"),
    					"totalPages"=>array("name"=>"totalPages","type"=>"xsd:int"),
    					"pageSize"=>array("name"=>"pageSize","type"=>"xsd:int"),
    					"currentPage"=>array("name"=>"currentPage", "type"=>"xsd:int"),
    					"list"=>array("name"=>"list","type"=>"tns:AlarmQueryOutputArray"))
    	);
    	$this->nusoap_server->register(
    			"AlarmQuery",
    			array(
    					"oaId" => "xsd:string",
    					"lscId"=>"xsd:int",
    					"stationId"=>"xsd:int",
    					"almLevel"=>"xsd:int",
    					"pageNo" => "xsd:int",
    					"pageSize" => "xsd:int"
    			),
    			array("return"=>"tns:AlarmQueryRes"),
    			'urn:ws',                         // namespace
    			'urn:ws#AlarmQuery'
    	);
    	//历史告警 AlarmHistory
    	$this->nusoap_server->wsdl->addComplexType(
    			"AlarmHistoryOutput","complexType","struct","all","",
    			array(
    					"id"=>array("name"=>"id","type"=>"xsd:int"),
    					"startTime"=>array("name"=>"startTime","type"=>"xsd:string"),
    					"endTime"=>array("name"=>"endTime","type"=>"xsd:string"),
    					"nodeName"=>array("name"=>"nodeName","type"=>"xsd:string"),
    					"alarmDesc"=>array("name"=>"alarmDesc","type"=>"xsd:string"),
    					"alaLevel"=>array("name"=>"alaLevel","type"=>"xsd:int"))
    	);
    	$this->nusoap_server->wsdl->addComplexType(
    			"AlarmHistoryOutputArray","complexType","array","","SOAP-ENC:Array",
    			array(),
    			array(array("ref"=>"SOAP-ENC:arrayType",'wsdl:arrayType'=>"tns:AlarmHistoryOutput[]")),
    			"tns:AlarmHistoryOutput");
    	
    	$this->nusoap_server->wsdl->AddComplexType(
    			"AlarmHistoryRes","ComplexType","struct","all","",
    			array("resultState"=>array("name"=>"resultState","type"=>"xsd:int"),
    					"resultDesc"=>array("name"=>"resultDesc","type"=>"xsd:string"),
    					"total"=>array("name"=>"total","type"=>"xsd:int"),
    					"totalPages"=>array("name"=>"totalPages","type"=>"xsd:int"),
    					"pageSize"=>array("name"=>"pageSize","type"=>"xsd:int"),
    					"currentPage"=>array("name"=>"currentPage", "type"=>"xsd:int"),
    					"list"=>array("name"=>"list","type"=>"tns:AlarmHistoryOutputArray"))
    	);
    	$this->nusoap_server->register(
    			"AlarmHistory",
    			array(
    					"oaId" => "xsd:string",
    					"lscId"=>"xsd:int",
    					"stationId"=>"xsd:int",
    					"startTime"=>"xsd:string",
    					"endTime"=>"xsd:string",
    					"pageNo" => "xsd:int",
    					"pageSize" => "xsd:int"
    			),
    			array("return"=>"tns:AlarmHistoryRes"),
    			'urn:ws',                         // namespace
    			'urn:ws#AlarmHistory'
    	);
    	//局站搜索 StationQuery
    	$this->nusoap_server->register(
    			"StationQuery",
    			array(
    					"oaId" => "xsd:string",
    					"searchKey" => "xsd:string",
    					"pageNo" => "xsd:int",
    					"pageSize" => "xsd:int"
    			),
    			array("return"=>"tns:MyStationRes"),
    			'urn:ws',                         // namespace
    			'urn:ws#StationQuery'
    	);
    	//动环网元ping测试 Ping
    	$this->nusoap_server->wsdl->addComplexType(
    			"PingOutput","complexType","struct","all","",
    			array(
    					"ip"=>array("name"=>"ip","type"=>"xsd:string"),
    					"pingRst"=>array("name"=>"stationId","type"=>"xsd:string"))
    	);
    	$this->nusoap_server->wsdl->addComplexType(
    			"PingOutputArray","complexType","array","","SOAP-ENC:Array",
    			array(),
    			array(array("ref"=>"SOAP-ENC:arrayType",'wsdl:arrayType'=>"tns:PingOutput[]")),
    			"tns:PingOutput");
    	$this->nusoap_server->register(
    			"Ping",
    			array(
    					"oaId" => "xsd:string",
    					"lscId"=>"xsd:int",
    					"stationId"=>"xsd:int"
    			),
    			array("return"=>"tns:PingOutputArray"),
    			'urn:ws',                         // namespace
    			'urn:ws#Ping'
    	);
    }
    
    
    
    public function index()
    {
    	function MyStation($oaId=0, $searchKey='', $pageNo=-1, $pageSize=-1) {
    		//$a = array("resultState"=>0,"resultDesc"=>"hello","total"=>100,"totalPages"=>10,"pageSize"=>10,"currentPage"=>"10");
    		//handreturn array("return"=>$a);
    		if($pageNo == -1 || $pageSize == -1)
    		{
    			
    		}
    		return array("resultState"=>1,"resultDesc"=>"","total"=>10,"totalPages"=>10,"pageSize"=>10,"currentPage"=>1,"list"=>array(array("lscId"=>"1","stationId"=>"2","name"=>"测试","alaLevel"=>3)));
    	}
    	function MyAlarm($oaId, $pageNo=-1, $pageSize=-1)
    	{
    		return array("resultState"=>1,"resultDesc"=>"","total"=>10,"totalPages"=>10,"pageSize"=>10,"currentPage"=>1,"list"=>array(array("id"=>"1","startTime"=>"2015-10-10 10:10:10","nodeName"=>"测试信号","alarmDesc"=>"测试信号描述","alaLevel"=>3)));
    	}
    	function DeviceQuery($oaId, $lscId, $stationId, $pageNo, $pageSize)
    	{
    		return array("resultState"=>1,"resultDesc"=>"","total"=>10,"totalPages"=>10,"pageSize"=>10,"currentPage"=>1,"list"=>array(array("lscId"=>"1","deviceId"=>"2","deviceType"=>2,"name"=>"测试设备名称","alaLevel"=>3))); 
    	}
    	function AlarmQuery($oaId, $lscId, $stationId, $almLevel, $pageNo, $pageSize)
    	{
    		return array("resultState"=>1,"resultDesc"=>"","total"=>10,"totalPages"=>10,"pageSize"=>10,"currentPage"=>1,"list"=>array(array("id"=>"1","startTime"=>"2015-10-10 10:10:10","nodeName"=>"测试信号","alarmDesc"=>"测试信号描述","alaLevel"=>3)));
    	}
    	
    	function AlarmHistory($oaId, $lscId, $stationId,$startTime, $endTime, $pageNo, $pageSize)
    	{
    		return array("resultState"=>1,"resultDesc"=>"","total"=>10,"totalPages"=>10,"pageSize"=>10,"currentPage"=>1,"list"=>array(array("id"=>"1","startTime"=>"2015-10-10 10:10:10","endTime"=>"2015-10-26 00:00:00","nodeName"=>"测试信号","alarmDesc"=>"测试信号描述","alaLevel"=>3)));
    	}
    	
    	function StationQuery($oaId, $searchKey, $pageNo, $pageSize)
    	{
    		return array("resultState"=>1,"resultDesc"=>"","total"=>10,"totalPages"=>10,"pageSize"=>10,"currentPage"=>1,"list"=>array(array("lscId"=>"1","stationId"=>"2","name"=>"测试","alaLevel"=>3)));
    	}
    	
    	function Ping($oaid, $lscid, $stationId)
    	{
    		return array(array("ip"=>"192.168.0.1","pingRst"=>"Delay:10ms,Drop:0%,PING:OK"),array("ip"=>"192.168.0.1","pingRst"=>"Delay:10ms,Drop:0%,PING:FAIL"));
    	}
    	$this->nusoap_server->service(file_get_contents("php://input"));
    }
}
