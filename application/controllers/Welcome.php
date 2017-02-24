<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Welcome extends CI_Controller
{
    
    function crontab_delete_dooruser()
    {
        //获得当前月1号，和下月1号
        $dateStart = date('Y-m-d', mktime(0, 0, 0, date("m"), 1, date("Y")));
        $dateEnd = date('Y-m-d', mktime(0, 0, 0, date("m")+1, 1, date("Y")));
        $dateStart = '';
        $dateEnd = '';
        $dbObj = $this->load->database('default', true);
        $dbObj->where('delete_check_count >', 0);
        $duList = $dbObj->get('door_user')->result();
        foreach($duList as $duObj)
        {
            $dbObj->where('data_id', $duObj->data_id);
            $dbObj->where('user_id', $duObj->user_id);
            $dbObj->where('action', '正常打卡');
            $dbObj->where('added_datetime >=', $dateStart);
            $dbObj->where('added_datetime <', $dateEnd);
            $count = $dbObj->count_all_results("door_record");
            if($count < $duObj->delete_check_count)
            {
                //自动删除
                $dbObj->set('data_id', $duObj->data_id);
                $dbObj->set('user_id', $duObj->user_id);
                $dbObj->set('card_no', '');
                $dbObj->set('action', '自动删除');
                $dbObj->set('desc', '月打卡记录'.$count."次，没达到设置".$duObj->delete_check_count."次");
                $dbObj->set('added_datetime', 'now()', false);
                $dbObj->insert('door_record');
                $dbObj->where('id', $duObj->id);
                $dbObj->delete('door_user');   
            }
        }
    }
    
    function process_name()
    {
        $dbObj = $this->load->database('default', true);
        $dbObj->like('name','空调');//普通空调，专用空调,新风设备
        $retList = $dbObj->get("device")->result();
        echo $dbObj->last_query();
        
        foreach($retList as $ret)
        {
            //$parts1 = mbsplit('（', $name);
            $parts1 = explode("（", $ret->name);
            if(count($parts1) != 2)
            {
                echo $ret->name;
                echo "error1 <br/>";
                continue;
            }
            $parts2 = explode("）", $parts1[1]);
            if(count($parts2) != 2)
            {
                echo $ret->name;
                echo "error2 <br/>";            
                continue;
            }
            $parts3 = explode("_", $parts2[0]);
            if(count($parts3) != 2)
            {
                echo $ret->name;
                echo "error3 <br/>";            
                continue;
            }
            //echo mb_substr($parts3[1], mb_strlen($parts3[1])-2, 2);
            if(mb_substr($parts3[1], mb_strlen($parts3[1])-2, 2) == "空调" )
            {
                echo $ret->name;
                echo "<br/>";
                continue;
            }
                
            //var_dump($parts1);
            //var_dump($parts2);
            //var_dump($parts3);
            
            $newName = $parts1[0]."（".$parts3[1]."_".$parts3[0]."）";
            //echo $newName;
            $dbObj->where('id', $ret->id);
            $dbObj->set('name', $newName);
            $dbObj->update('device');
            //echo "<br/>";
            //break;
        }
    }
    function calculate_ec_hourly()
    {
        $this->load->library("mongo_db");
        $time = time();//strtotime("2016-7-19 23:00:01");
        $date = date("Y-m-d", $time);
        $curHour = intval(date("H", $time));
        if($curHour == 0)
        {
            $date = date("Y-m-d",strtotime("-1 day",strtotime($date)));
            $curHour = 23;
        }else{
            $curHour = $curHour-1;
        }
        $timeStart = str_pad($curHour,2,"0",STR_PAD_LEFT).":00:00";
        $timeEnd = str_pad($curHour,2,"0",STR_PAD_LEFT).":59:59";
        echo "Now processing last hour's power data";
        echo $date." ".$timeStart ."-".$date." ".$timeEnd;
        //do group by and get first record and last record
        //[{$match:{"Date" : { $eq:"2016-07-19"}, "Time":{ $gte:"23:00:00",$lte:"23:59:59"}}},{$group:{_id:"$data_id",lq:{$first:"$epa"},mq:{$last:"$epa"}}}]
        $operation = array();
        array_push($operation, array('$match' => array("Date"=>array('$eq'=>$date),
        "Time"=>array('$gte'=>$timeStart, '$lte'=>$timeEnd))));
        array_push($operation, array('$group' => array('_id'=>'$data_id',
        'lepa'=>array('$first'=>'$epa'),'hepa'=>array('$last'=>'$epa'),
        'lepb'=>array('$first'=>'$epb'),'hepb'=>array('$last'=>'$epb'),
        'lepc'=>array('$first'=>'$epc'),'hepc'=>array('$last'=>'$epc'),
        'lept'=>array('$first'=>'$ept'),'hept'=>array('$last'=>'$ept'))));
    
        //$operation[] = array('$skip' => $skip);
        //$operation[] = array('$limit'=>10);
        $docs = $this->mongo_db->aggregate("power302a",$operation);
        if(count($docs) == 0)
        {
            echo "empty";
            return;
        }
        foreach($docs as $doc)
        {
            echo "Processing data_id:".$doc->_id."<br/>";
            $count = $this->mongo_db->where("data_id",$doc->_id)->where("Date", $date)->where("Time", $curHour)->count('power302a_hourly_ec');
            if($count == 0)
            {
                $insert = array();
                $insert['data_id'] = $doc->_id;
                $insert['epa'] =  $doc->hepa - $doc->lepa;
                $insert['epb'] = $doc->hepb - $doc->lepb;
                $insert['epc'] = $doc->hepc - $doc->lepc;
                $insert['ept'] = $doc->hept - $doc->lept;
                $insert['Date'] = $date;
                $insert['Time'] = $curHour;
                $this->mongo_db->insert('power302a_hourly_ec', $insert);
            }else{
                $this->mongo_db->set('epa', $doc->hepa - $doc->lepa)->set('epb', $doc->hepb - $doc->lepb)
                ->set('epc', $doc->hepc - $doc->lepc)->set('ept', $doc->hept - $doc->lept)
                ->where("data_id",$doc->_id)->where("Date", $date)->where("Time", $curHour)->update('power302a_hourly_ec');
            }
        }
    
    }
    
	public function get_mystation()
	{
		
		$date = getdate();
		//$client = new nusoap_client("http://xjdh.jimglobal.com/ws");
		$client = new nusoap_client("http://www.xjdh.com/ws");
		//$argu = array("oaId"=>"13325559716","lscId"=>"903","stationId"=>"9030","pageNo"=>1,"pageSize"=>10);
		//$argu = array("ipAddress"=>"www.baidu.com");
		var_dump($client);
		die;
		$argu = array("oaId"=>"13325559716","lscId"=>992,"stationId"=>9920);

		$serializer = new XML_Serializer(array("encoding"=> "UTF-8","rootName"=> "root","defaultTagName"=>"list"));

		$result = $serializer->serialize($argu);
		
		$str = $serializer->getSerializedData();

		//$result = $client->call("AlarmQuery",array("argu"=>$str));
		$result = $client->call("querySignalByDeviceId",array("argu"=>$str));
		
		//$result = $client->call("pingStationIpAddress",array("argu"=>$str));
		//$result = $client->call("pingIpAddress",array("argu"=>$str));
		//$result = $client->call("AlarmQuery",array());
		//$result = $client->call("AlarmHistory",array());
		//$result = $client->call("StationQuery",array());
		//$result = $client->call("getSignalValueAnalyse",array());
		//$result = $client->call("searchStation", array());
		//$result = $client->call("searchStationAlarmHistory", array());
		var_dump($client->response);
		//var_dump($result);
	}
	
    public function index ()
    {
        $this->login();
    }

    public function qrcode()
    {
        $this->load->library('ciqrcode');
        $updateObj = $this->mp_xjdh->Get_LatestUpdateInfo();
        $params['data'] = $updateObj->download_url;
        $params['size'] = 200;
        $this->ciqrcode->generate($params);
    }
    public function login ()
    {
        if (User::IsAuthenticated()) {
            redirect('/');
        }
        $data = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txtUsername', '用户名', 'trim|required');
            $this->form_validation->set_rules('txtPasswd', "密码", 'required');
            if ($this->form_validation->run()) {
            	$username = $this->input->post('txtUsername');
                $password = $this->input->post('txtPasswd');
                $val = User::ValidUser($username, $password, false);
                if ($val == 1 ) {
                    $isRemember = $this->input->post("cbIsRemember");
                    if ($isRemember != "true") {
                        $isRemember = false;
                    } else {
                        $isRemember = true;
                    }
                    if (User::LogInUser($username, $password, false, $isRemember)) {
                            if($_SESSION['XJTELEDH_USERROLE'] != 'door_user'){
                                redirect("/portal");
                            } else {
                                session_destroy();
                                $data['msg'] = "门禁用户无法登录网站!";
                                }
                     } else {
                        $data['msg'] = "登录失败，请重试!";
                    }
                } else {
                    $data['msg'] = "您的用户名密码不匹配!";
                }
            } else {
                $data['msg'] = "请填写用户名和密码";
            }
        }
        $this->load->view('login', $data);
    }

    function checkupdate ()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With");
        header("Access-Control-Request-Method: POST");
        header('Content-Type: application/json');
        $updateObj = $this->mp_xjdh->Get_LatestUpdateInfo();
        echo json_encode($updateObj);
        return;
    }

    public function error_404 ()
    {
        $data = array();
        $data['pageContent'] = $this->load->view('wap/page404', $data, TRUE);
        $this->load->view('wap/master', $data);
    }
}

