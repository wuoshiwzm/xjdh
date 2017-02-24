<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

const DEFAULT_PAGE_SIZE = 5;

class Wap extends CI_Controller
{

    var $user = null;

    public function __construct ()
    {
        parent::__construct();
        // Initiate the request handlerw which deals with $_GET, $_POST, etc
        $request = new League\OAuth2\Server\Util\Request();
        require "application/config/database.php";
        // Initiate a new database connection
        $conn_str = 'mysql://' . $db['default']['username'] . ":" . $db['default']['password'] . '@' . $db['default']['hostname'] . '/' .
                 $db['default']['database'];
        $db = new League\OAuth2\Server\Storage\PDO\Db($conn_str);
        
        $this->server = new League\OAuth2\Server\Resource(new League\OAuth2\Server\Storage\PDO\Session($db));
        try {
            $this->server->isValid();
            $this->user = User::GetUserById($this->server->getOwnerId());
            User::Set_UserAppOnline($this->user->id);
        } catch (League\OAuth2\Server\Exception\InvalidAccessTokenException $e) {
            redirect('welcome/error_404');
        }
        $this->load->model('mp_xjdh');
    }

    private function _show_smd_device($deviceNo)
    {
        $deviceList = $this->mp_xjdh->Get_Device_By_SMD_no($deviceNo);
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
        return $this->load->view ("portal/DevicePage/smd_device", array("diList"=>$diList,"aiList"=>$aiList, "spList"=>$spList), TRUE);
    }
    
    public function loadrealtime ()
    {
        
        $data = array();
        $accessToken = $this->server->getAccessToken();
        $model = $this->input->get('model');
        if ($model == "enviroment" || $model == 'ad' || $model == 'di') {
            $roomId = $this->input->get('room_code');
            $data['devList'] = $this->mp_xjdh->Get_Room_Devices($roomId, array('temperature','humid','smoke','water'));
            $data['pageContent'] = $this->load->view('wap/page-addi', $data, TRUE);
        } elseif ($model == 'powermeterapp' || $model == 'powermeter') {
        	$data_id = $this->input->get('data_id');
        	$data['dataObj'] = $dataObj = $this->mp_xjdh->Get_Device($data_id);
			if($data['dataObj']->model == 'power_302a')
			{
				$data['pageContent'] = $this->load->view('wap/page-power_302a',$data, TRUE);
			}elseif($data['dataObj']->model == 'imem_12'){
				$data['pageContent'] = $this->load->view('wap/page-imem12',  $data, TRUE);
			}
        } else if($model == "smd_device")
        {
            $data_id = $this->input->get('data_id');
            $data['pageContent'] = $this->_show_smd_device($data_id);
        }elseif ($model == 'bat' || $model == 'battery') {
            $data_id = $this->input->get('data_id');
            $data['batObj'] = $this->mp_xjdh->Get_Device($data_id);
            
            $extraPara = $this->mp_xjdh->Device_extra_para($data_id);
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
            
            $data['pageContent'] = $this->load->view('wap/page-bat', $data, TRUE);
        } elseif ($model == 'pdu') {
        	$data_id = $this->input->get('data_id');
        	$data['dataObj'] = $this->mp_xjdh->Get_Device($data_id);
        	if(in_array($data['dataObj']->model, array('aeg-ms10se','aeg-ms10m')))
        	{
        		$data['pageContent'] = $this->load->view('portal/DevicePage/page-aeg', $data, TRUE);
        	}elseif($data['dataObj']->model == 'vpdu'){
        		$data['pageContent'] = $this->load->view('wap/page-vpdu', $data, TRUE);
        	}
        } elseif ($model == 'fresh-air') {
            $data_id = $this->input->get('data_id');
            $data['freshAirObj'] = $freshAirObj = $this->mp_xjdh->Get_Device($data_id);
            $pageContent = '<div class="rt-data" data_type="fresh-air" id="fresh-air-' . $freshAirObj->data_id . '" data_id="' . $freshAirObj->data_id . '"><h3>' .
                     $freshAirObj->name . '</h3>';
            $pageContent .= $this->load->view('portal/DevicePage/freshair', $data, TRUE);
            $pageContent .= "</div>";
            $data['pageContent'] = $pageContent;
        } elseif ($model == 'psm-a' || $model == 'sps') {
            $data_id = $this->input->get('data_id');
            $data['isShowSettingField'] = false;
            $spsObj = $this->mp_xjdh->Get_Device($data_id);
            $content = "<div class='row-fluid'><div class='rt-data' data_type='" . $spsObj->model . "' data_id='" . $spsObj->data_id . "' id='sps-a-" .
                     $spsObj->data_id . "'><h3>" . $spsObj->name . "</h3>";
            if (stripos($spsObj->model, "psma") !== false) {
                $data['psmAObj'] = $spsObj;
                $content .= $this->load->view('portal/DevicePage/psm-a', $data, TRUE);
            } else if(stripos($spsObj->model, "m810g") !== false) {
                $data['m810gObj'] = $spsObj;
                $content .= $this->load->view('portal/DevicePage/m810g', $data, TRUE);
            } else {
                $data['smu06cObj'] = $spsObj;
                $content .= $this->load->view('portal/DevicePage/smu06c', $data, TRUE);
            }
            $content .= "</div></div>";
            $data['pageContent'] = $content;
        } elseif ($model == 'liebert-ups') {
            $data_id = $this->input->get('data_id');
            $data['isMobile'] = true;
            $data['liebertUpsObj'] = $this->mp_xjdh->Get_Device($data_id);
            $data['pageContent'] = $this->load->view('portal/DevicePage/liebert-ups', $data, TRUE);
        } elseif ($model == 'motor_battery') {
            $data['isMobile'] = true;
            $roomId = $this->input->get('room_code');
            $data['motorBatList'] = $this->mp_xjdh->Get_Room_Devices($roomId,  'motor_battery');
            $data['pageContent'] = $this->load->view('portal/DevicePage/page-motor-battery', $data, TRUE);
        } else if($model == "access4000x")
        {
        	$data['isMobile'] = true;
            $data_id = $this->input->get('data_id');
            $data['access4000xObj'] = $this->mp_xjdh->Get_Device($data_id);
            $data['pageContent'] = $this->load->view('portal/DevicePage/page-access4000x', $data, TRUE);
        }else if($model == "amf25")
        {
        	$data['isMobile'] = true;
            $data_id = $this->input->get('data_id');
            $data['amf25Obj'] = $this->mp_xjdh->Get_Device($data_id);
            $data['pageContent'] = $this->load->view('portal/DevicePage/page-amf25', $data, TRUE);
        }else if($model == "camera")
        {
            $data['isMobile'] = true;
            $data_id = $this->input->get('data_id');
            $dataObj = $this->mp_xjdh->Get_Device($data_id);
            $data['pageContent'] = $this->load->view ("wap/page-camera", array("dataObj"=>$dataObj), TRUE );
        }
        $data['scriptExtra'] = '<script type="text/javascript">var accessToken ="' . $accessToken . '",model = "' . $model . '";' . '</script>';
        if ($model == 'ad' || $model == 'di') {
            //$data['pageContent'] = $this->load->view('wap/page-addi', $data, TRUE);
            $data['scriptExtra'] .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-addiapp.js"></script>';
        } else if($model == "powermeter")
        {
            $data['scriptExtra'] .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-powermeterapp.js?v=1"></script>';
        }else if($model == "battery")
        {
            $data['scriptExtra'] .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-bat.js"></script>';
        }else if($model == "battery_32")
        {
            $data_id = $this->input->get('data_id');
            $data['batObj'] = $this->mp_xjdh->Get_Device($data_id);
            $data['pageContent'] = $this->load->view('wap/page-bat32', $data, TRUE);
            $data['scriptExtra'] .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-bat32.js"></script>';
        }else {
            $data['scriptExtra'] .= '<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-' . $model . '.js?v=1"></script>';
        }
        $this->load->view('wap/master', $data);
    }

    public function onlineuser ()
    {
        $data = array();
        $data['isWap'] = true;
        $data['userList'] = User::Get_AllOnlineUser();
        $data['pageContent'] = $this->load->view('portal/online_user', $data, TRUE);
        $this->load->view('wap/master', $data);
    }

    public function feedback ()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['feedbackObj'] = $this->mp_xjdh->Get_Feedback($id);
        $data['scriptExtra'] = '';
        $data['pageContent'] = $this->load->view('wap/feedback', $data, TRUE);
        $this->load->view('wap/master', $data);
    }
	function datamodel()
	{
		$data = array();
        $data['scriptExtra'] = '';
        $data['pageContent'] = $this->load->view('wap/data_model', $data, TRUE);
        $this->load->view('wap/master', $data);
	}
}
