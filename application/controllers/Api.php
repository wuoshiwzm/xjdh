<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

const DEFAULT_PAGE_SIZE = 10;

class Api extends CI_Controller
{

    var $authserver;

    var $server;

    var $response = array();

    var $user;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With");
        header("Access-Control-Request-Method: GET,POST,PUT,DELETE");
        header('Content-Type: application/json');
        header('Access-Control-Allow-Headers: Authorization');
        $postParams = json_decode(file_get_contents('php://input'));
        if (count($postParams)) {
            foreach ($postParams as $key => $val) {
                $_POST[$key] = $val;
            }
        }
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
            // $this->user = User::GetUserById(1);
            $this->server->isValid();
            $this->user = User::GetUserById($this->server->getOwnerId());
            User::Set_UserAppOnline($this->user->id);
        } catch (League\OAuth2\Server\Exception\InvalidAccessTokenException $e) {
            $jsonRet = array();
            $jsonRet['ret'] = 1;
            $jsonRet['data'] = $e->getMessage();
            echo json_encode($jsonRet);
            die();
        }
    }

    public function get_spdev_list()
    {
        $jsonRet = array();
        $jsonRet['ret'] = 0;
        $jsonRet['spdevList'] = $this->mp_xjdh->Get_Spdev_List();
        header('Content-Type: application/json');
        echo json_encode($jsonRet);
    }

    public function getuserinfo()
    {
        $jsonRet = array();
        if ($this->user != null) {
            unset($this->user->password);
            unset($this->user->is_active);
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode($this->user);
        } else {
            $jsonRet['ret'] = 2;
            $jsonRet['data'] = '';
        }
        echo json_encode($jsonRet);
        return;
    }

    public function getAlarmList()
    {
        $jsonRet = array();
        $cityCode = $this->input->get('citycode');
        $countyCode = $this->input->get('countycode');
        $substationId = $this->input->get('substationId');
        $roomId = trim($this->input->get('roomId'));
        $level = trim($this->input->get('level'));
        $devModel = trim($this->input->get('model'));
        $startdatetime = trim($this->input->get('startdatetime'));
        $enddatetime = $this->input->get('enddatetime');
        $signalName = $this->input->get('signalName');
        $offset = $this->input->get('offset');
        $pageSize = intval($this->input->get('count'));
        $lastId = intval($this->input->get('lastId'));
        if (!Util::Is_date($startdatetime)) {
            $startdatetime = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d") - 1, date("Y")));
        }
        if (!Util::Is_date($enddatetime)) {
            $enddatetime = date('Y-m-d');
        }

        $devModelArray = array();
        if (!empty($devModel)) {
            foreach (Constants::$devConfigList as $devConfig) {
                if ($devConfig[2] == $devModel) {
                    $devModelArray = $devConfig[0];
                }
            }
        }

        $userLevel = 3;
        $substationIdArray = array();
        if ($this->user->user_role == "admin") {
            $userLevel = 1;
        } else if ($this->user->user_role == "city_admin") {
            $userLevel = 2;
            $cityCode = $this->user->city_code;
        } else {
            $cityCode = $this->user->city_code;
            $userPrivilegeObj = User::Get_UserPrivilege($this->user->id);
            if (count($userPrivilegeObj)) {
                $substationIdArray = json_decode($userPrivilegeObj->area_privilege);
            }
        }


        $alarmCount = $this->mp_xjdh->Get_AlarmCount($cityCode, $countyCode, $substationId, $roomId, $devModelArray, $level,
            array('unresolved'), $startdatetime, $enddatetime, $word, $signalName,
            $userLevel, $substationIdArray);
        $alarmList = $this->mp_xjdh->Get_AlarmList($cityCode, $countyCode, $substationId, $roomId, $devModelArray, $level,
            array('unresolved'), $startdatetime, $enddatetime, $word, $signalName,
            $userLevel, $substationIdArray, $offset, $pageSize, $lastId);

        if (count($alarmList)) {
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(array('alarmCount' => $alarmCount, 'alarmList' => $alarmList));
        } else {
            $jsonRet['ret'] = 1;
            $jsonRet['data'] = "load finish";
        }
        echo json_encode($jsonRet);
        return;
    }

    public function getPreAlarmList()
    {
        $jsonRet = array();
        $privaligeObj = User::Get_UserPrivilege($this->user->id);
        $areaPrivilegeArr = json_decode($privaligeObj->area_privilege, TRUE);
        if ($this->user->user_role == 'admin') {
            $cityCode = trim($this->input->get('citycode'));
            $countyCode = trim($this->input->get('countycode'));
        } elseif ($this->user->user_role == 'noc' || $this->user->user_role == 'member' || $this->user->user_role == 'operator') {
            $cityCode = trim($this->input->get('citycode'));
            $countyCode = trim($this->input->get('countycode'));
            if (!$cityCode) {
                $cityList = array();
                $cities = $this->mp_xjdh->Get_CityList($areaPrivilegeArr);
                foreach ($cities as $cityObj) {
                    $cityList[$cityObj->city_code] = $cityObj->city;
                    $counties = $this->mp_xjdh->Get_CountyList($cityObj->city_code, $areaPrivilegeArr);
                    $countyList = array();
                    foreach ($counties as $countyObj) {
                        $countyList[$countyObj->county_code] = $countyObj->county;
                    }
                }
                $cityCode = array_keys($cityList);
                $countyCode = array_keys($countyList);
            }
        } elseif ($this->user->user_role == 'city_admin') {
            $cityCode = $areaPrivilegeArr[0];
            $countyCode = trim($this->input->get('countycode'));
        }
        $lastId = intval($this->input->get('lastId'));
        $pageSize = intval($this->input->get('count'));
        $substaitonId = trim($this->input->get('substationId'));
        $roomId = trim($this->input->get('roomId'));
        $level = trim($this->input->get('level'));
        $devModel = trim($this->input->get('model'));
        $startdatetime = trim($this->input->get('startdatetime'));
        if (!Util::Is_date($startdatetime)) {
            $startdatetime = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d") - 1, date("Y")));
        }
        $enddatetime = trim($this->input->get('enddatetime'));
        if (!Util::Is_date($enddatetime)) {
            $enddatetime = date('Y-m-d');
        }
        $offset = $this->input->get('offset');
        $alarmCount = $this->mp_xjdh->Get_takeAlarmCount($cityCode, $countyCode, $substaitonId, $roomId, $devModel, $level,
            $startdatetime, $enddatetime, "", array('unresolved'));
        $alarmList = $this->mp_xjdh->Get_takeAlarmList($cityCode, $countyCode, $substaitonId, $roomId, $devModel, $level,
            $startdatetime, $enddatetime, "", $offset, $pageSize, $lastId, array('unresolved'));
        if (count($alarmList)) {
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(array('alarmCount' => $alarmCount, 'alarmList' => $alarmList));
        } else {
            $jsonRet['ret'] = 1;
            $jsonRet['data'] = "load finish";
        }
        echo json_encode($jsonRet);
        return;
    }

    public function postPreAlarmList()
    {
        $jsonRet = array();
        $lastId = intval($this->input->post('lastId'));
        $result = $this->mp_xjdh->Take_PreAlert($lastId);
        if (count($result)) {
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = "load succeed";
        } else {
            $jsonRet['ret'] = 1;
            $jsonRet['data'] = "load finish";
        }
        echo json_encode($jsonRet);
        return;
    }

    function getSubstationList()
    {
        $name = $this->input->get('name');
        $offset = $this->input->get('offset');
        $jsonRet = array();
        $substationList = array();
        if (in_array($this->user->user_role, array("admin", "noc"))) {
            $substationList = $this->mp_xjdh->Search_Substation($name, '', array(), 10, $offset);
        } else {
            if ($this->user->user_role == "city_admin") {
                $substationList = $this->mp_xjdh->Search_Substation($name, $this->user->city_code, array(), 10, $offset);
            } else {
                $userPrivilegeObj = User::Get_UserPrivilege($this->user->id);
                if (count($userPrivilegeObj)) {
                    $substationIdArray = json_decode($userPrivilegeObj->area_privilege);
                    $substationList = $this->mp_xjdh->Search_Substation($name, $this->user->city_code, $substationIdArray, 10, $offset);
                } else {
                    $substationList = array();
                }
            }
        }
        $jsonSubstationList = array();
        foreach ($substationList as $obj) {
            $substationObj = new stdClass();
            $substationObj->code = $obj->id;
            $substationObj->name = Defines::$gCity[$obj->city_code] . "->" . Defines::$gCounty[$obj->city_code][$obj->county_code] . "->" . $obj->name;
            $substationObj->roomList = array();
            $roomList = $this->mp_xjdh->Get_Rooms(false, $obj->id);
            foreach ($roomList as $rObj) {
                $roomObj = new stdClass();
                $roomObj->id = $rObj->id;
                $roomObj->code = $rObj->code;
                $roomObj->name = $rObj->name;
                $roomObj->lng = $rObj->lng;
                $roomObj->lat = $rObj->lat;
                array_push($substationObj->roomList, $roomObj);
            }
            array_push($jsonSubstationList, $substationObj);
        }
        $jsonRet['ret'] = 0;
        $jsonRet['data'] = json_encode($jsonSubstationList);
        echo json_encode($jsonRet);
        return;
    }

    function getAreaData()
    {
        $jsonRet = array();
        $cities = array();
        $counties = array();
        $city = trim($this->input->get('cityName'));
        $substation = trim($this->input->get('stationName'));
        $substations = $this->input->get('stationNames');
        if ($city != 'all' && $substation != 'all') {
            foreach (Defines::$gCity as $key => $val) {
                if ($city == $val) {
                    $city_code = $key;
                }
            }
            $cityList = array();
            $countyList = $this->mp_xjdh->Get_CountyList($city_code);
            $cityObj = new stdClass();
            $cityObj->city_code = $city_code;
            $cityObj->name = $city;
            $cityObj->countyList = array();
            foreach ($countyList as $coObj) {
                $countyObj = new stdClass();
                $countyObj->code = $coObj->county_code;
                $countyObj->name = $coObj->county;
                $countyObj->substationList = array();
                $substationList = $this->mp_xjdh->Get_Substations(false, false, 'all', $substation);
            }
            foreach ($substationList as $obj) {
                $substationObj = new stdClass();
                $substationObj->code = $obj->id;
                $substationObj->name = $obj->name;
                $substationObj->roomList = array();
                $roomList = $this->mp_xjdh->Get_Rooms(false, $obj->id);
                foreach ($roomList as $rObj) {
                    $roomObj = new stdClass();
                    $roomObj->id = $rObj->id;
                    $roomObj->code = $rObj->code;
                    $roomObj->name = $rObj->name;
                    $roomObj->lng = $rObj->lng;
                    $roomObj->lat = $rObj->lat;
                    array_push($substationObj->roomList, $roomObj);
                }
                array_push($countyObj->substationList, $substationObj);
            }
            array_push($cityObj->countyList, $countyObj);

            array_push($cityList, $cityObj);
        } else {
            $privaligeObj = User::Get_UserPrivilege($this->user->id);
            $areaPrivilegeArr = json_decode($privaligeObj->area_privilege, TRUE);
            if ($this->user->user_role == 'admin') {
                $cities = Defines::$gCity;
                $counties = Defines::$gCounty;
            } elseif ($this->user->user_role == 'noc' || $this->user->user_role == 'member' || $this->user->user_role == 'operator') {
                $cityList = $this->mp_xjdh->Get_CityList($areaPrivilegeArr);
                foreach ($cityList as $cityObj) {
                    $cities[$cityObj->city_code] = $cityObj->city;
                    $countyList = $this->mp_xjdh->Get_CountyList($cityObj->city_code, $areaPrivilegeArr);
                    $counties[$cityObj->city_code] = array();
                    foreach ($countyList as $countyObj) {
                        $counties[$cityObj->city_code][$countyObj->county_code] = $countyObj->county;
                    }
                }
            } elseif ($this->user->user_role == 'city_admin') {
                $cities[$this->user->city_code] = Defines::$gCity[$this->user->city_code];
                $counties[$this->user->city_code] = Defines::$gCounty[$this->user->city_code];
            }
            $cityList = array();
            foreach ($cities as $key => $val) {
                $cityObj = new stdClass();
                $cityObj->city_code = $key;
                $cityObj->name = $val;
                $cityObj->countyList = array();
                foreach ($counties[$key] as $countyKey => $countyVal) {
                    $countyObj = new stdClass();
                    $countyObj->code = $countyKey;
                    $countyObj->name = $countyVal;
                    $countyObj->substationList = array();
                    $substationList = $this->mp_xjdh->Get_Substations(false, $countyKey, $substations);
                    foreach ($substationList as $obj) {
                        $substationObj = new stdClass();
                        $substationObj->code = $obj->id;
                        $substationObj->name = $obj->name;
                        $substationObj->roomList = array();
                        $roomList = $this->mp_xjdh->Get_Rooms(false, $obj->id);
                        foreach ($roomList as $rObj) {
                            $roomObj = new stdClass();
                            $roomObj->id = $rObj->id;
                            $roomObj->code = $rObj->code;
                            $roomObj->name = $rObj->name;
                            $roomObj->lng = $rObj->lng;
                            $roomObj->lat = $rObj->lat;
                            array_push($substationObj->roomList, $roomObj);
                        }
                        array_push($countyObj->substationList, $substationObj);
                    }
                    array_push($cityObj->countyList, $countyObj);
                }
                array_push($cityList, $cityObj);
            }
        }
        $jsonRet['ret'] = 0;
        $jsonRet['data'] = json_encode($cityList);
        echo json_encode($jsonRet);
        return;
    }

    function getDevModelData()
    {
        $jsonRet = array();
        $privaligeObj = User::Get_UserPrivilege($this->user->id);
        $devPrivilegeArr = json_decode($privaligeObj->dev_privilege, TRUE);
        $devModelList = array();

        foreach (Defines::$gDevModel as $key => $val) {
            if (($this->user->user_role == 'noc' || $this->user->user_role == 'member' || $this->user->user_role == 'operator') && !in_array($key, $devPrivilegeArr))
                continue;
            $devModelObj = new stdClass();
            $devModelObj->key = $key;
            $devModelObj->val = $val;
            array_push($devModelList, $devModelObj);
        }
        $jsonRet['ret'] = 0;
        $jsonRet['data'] = json_encode($devModelList);
        echo json_encode($jsonRet);
        return;
    }

    function getRoomDeviceList()
    {
        $jsonRet = array();
        $roomId = $this->input->get("roomcode");
        $model = $this->input->get("devtype");
        $devList = Device::getRoomDeviceList($roomId, $model, $this->user);
        $jsonRet['ret'] = 0;
        $jsonRet['data'] = json_encode($devList);
        echo json_encode($jsonRet);
        return;
    }

    function addfeedback()
    {
        $jsonRet = array();
        $content = $this->input->post('content');
        if ($this->mp_xjdh->Save_Feedback($content, $this->user->id)) {
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = '';
        } else {
            $jsonRet['ret'] = 2;
            $jsonRet['data'] = 'error';
        }
        echo json_encode($jsonRet);
        return;
    }

    function getAlarmChartsData()
    {
        $jsonRet = array();
        $privaligeObj = User::Get_UserPrivilege($this->user->id);
        $areaPrivilegeArr = json_decode($privaligeObj->area_privilege, TRUE);
        $cities = array();
        $counties = array();
        if ($this->user->user_role == 'admin') {
            $cities = Defines::$gCity;
            $counties = Defines::$gCounty;
        } elseif ($this->user->user_role == 'noc' || $this->user->user_role == 'member' || $this->user->user_role == 'operator') {
            $cityList = $this->mp_xjdh->Get_CityList($areaPrivilegeArr);
            foreach ($cityList as $cityObj) {
                $cities[$cityObj->city_code] = $cityObj->city;
                $countyList = $this->mp_xjdh->Get_CountyList($cityObj->city_code, $areaPrivilegeArr);
                $counties[$cityObj->city_code] = array();
                foreach ($countyList as $countyObj) {
                    $counties[$cityObj->city_code][$countyObj->county_code] = $countyObj->county;
                }
            }
        } elseif ($this->user->user_role == 'city_admin') {
            $cities[$areaPrivilegeArr[0]] = Defines::$gCity[$areaPrivilegeArr[0]];
            $counties[$areaPrivilegeArr[0]] = Defines::$gCounty[$areaPrivilegeArr[0]];
        }
        $startDatetime = date('Y-m-1');
        $endDatetime = date('Y-m-d');
        $alarmDataList = array();
        if ($this->user->user_role == 'admin' || $this->user->user_role == 'noc') {
            $title = "各本地网本月告警统计";
            foreach ($cities as $key => $val) {
                $alarmDataObj = new stdClass();
                $alarmDataObj->name = $val;
                $result = $this->mp_xjdh->Get_AlarmCountGroupByLevel($key, false, false, false, false, array(), $startDatetime, $endDatetime);
                $alarmDataObj->alarm_level_1 = 0;
                $alarmDataObj->alarm_level_2 = 0;
                $alarmDataObj->alarm_level_3 = 0;
                $alarmDataObj->alarm_level_4 = 0;
                foreach ($result as $rObj) {
                    $alarmDataObj->{'alarm_level_' . $rObj->level} = $rObj->count;
                }
                array_push($alarmDataList, $alarmDataObj);
            }
        } elseif ($this->user->user_role == 'city_admin' || $this->user->user_role == 'member') {
            $cityNames = array_values($cities);
            $title = $cititNames[0] . "分公司各分局本月告警统计";
            foreach ($cities as $cityKey => $cityVal) {
                foreach ($counties[$cityKey] as $key => $val) {
                    $alarmDataObj = new stdClass();
                    $alarmDataObj->name = $val;
                    $result = $this->mp_xjdh->Get_AlarmCountGroupByLevel($cityKey, $key, false, false, false, array(), $startDatetime, $endDatetime);
                    $alarmDataObj->alarm_level_1 = 0;
                    $alarmDataObj->alarm_level_2 = 0;
                    $alarmDataObj->alarm_level_3 = 0;
                    $alarmDataObj->alarm_level_4 = 0;
                    foreach ($result as $rObj) {
                        $alarmDataObj->{'alarm_level_' . $rObj->level} = $rObj->count;
                    }
                    array_push($alarmDataList, $alarmDataObj);
                }
            }
        }
        $jsonRet['ret'] = 0;
        $jsonRet['data'] = json_encode(array('title' => $title, 'alarmChartsDataList' => $alarmDataList));
        echo json_encode($jsonRet);
        return;
    }

    function modifyuserimage()
    {
        $jsonRet = array();
        $config['upload_path'] = './user_image/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '8096';
        $config['encrypt_name'] = true;
        $config['max_filename'] = 100;
        $oldImage = $this->user->user_img;
        $this->load->library('upload', $config);

        if (isset($_FILES['user_image'])) {
            $_FILES['user_image']['type'] = 'image/jpeg';
            $bRet = $this->upload->do_upload('user_image');
            if ($bRet) {
                $fileData = $this->upload->data();
                $ret = User::UpdateUserImage($this->user->id, $fileData['file_name']);
                if ($ret) {
                    if ($oldImage && file_exists($config['upload_path'] . $oldImage)) {
                        unlink($config['upload_path'] . $oldImage);
                    }
                    $jsonRet['ret'] = 0;
                    $jsonRet['data'] = $fileData['file_name'];
                    echo json_encode($jsonRet);
                    return;
                }
            }
        }
        $jsonRet['ret'] = 1;
        $jsonRet['data'] = '';
        echo json_encode($jsonRet);
        return;
    }

    function StationImage()
    {

        $file_path = "./public/portal/Station_image/";
        $filename = $_FILES['uploadImg']['name'];
        $gfilename = $filename;
        $filet = $_FILES['uploadImg']['tmp_name'];
        $filet[size] > "500000";
        for ($i = 0; $i < count($filename); $i++) {
            move_uploaded_file($filet[$i], $file_path . $filename[$i]);
        }
        $stationName = $this->input->post("stationName");
        $longitude = $this->input->post("longitude");
        $latitude = $this->input->post("latitude");
        $newGrouping = $this->input->post("newGroupingName");
        $this->mp_xjdh->Insert_lonLat($stationName, $longitude, $latitude, $filename, $newGrouping);
        if ($filename) {
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode($filename);
            echo json_encode($jsonRet);
            return;
        }
        $jsonRet['ret'] = 1;
        $jsonRet['data'] = '';
        echo json_encode($jsonRet);
        return;
    }

    function stationList()
    {
        $stationName = $this->input->get("stationName");
        if ($stationName != "all") {
            $stationList = $this->mp_xjdh->Get_station($stationName);
            $stationimg = $this->mp_xjdh->Get_stationimg();
            $jsonRet['ret'] = '0';
            $jsonRet['data'] = json_encode(array('stationList' => $stationList));
            echo json_encode($jsonRet);
            return;

        } else if ($stationName == 'all') {
            $stationList = $this->mp_xjdh->Get_station();
            $jsonRet['ret'] = '0';
            $jsonRet['data'] = json_encode(array('stationList' => $stationList));
            echo json_encode($jsonRet);
            return;
        }
    }

    function Group()
    {
        $substation_id = $this->input->get("substation_id");
        $Group = $this->mp_xjdh->Get_Group($substation_id);
        $jsonRet['ret'] = '0';
        $jsonRet['data'] = json_encode(array('stationList' => $Group));
        echo json_encode($jsonRet);
        return;
    }

    function newGrouping()
    {
        $GroupingName = $this->input->get("GroupingName");
        $substation_id = $this->input->get("substation_id");
        $stationimg = $this->mp_xjdh->Get_stationimg($substation_id, $GroupingName);
        $jsonRet['ret'] = '0';
        $jsonRet['data'] = json_encode(array('stationList' => $stationimg));
        echo json_encode($jsonRet);
        return;
    }

    function modifyuserinfo()
    {
        $jsonRet = array();
        $full_name = $this->input->post('full_name');
        $mobile = $this->input->post('mobile');
        $email = $this->input->post('email');
        $info = $this->input->post('info');
        $gender = $this->input->post('gender');
        $password = $this->input->post('password');
        $ret = User::UpdateUserinfo($this->user->id, $password, $this->user->user_role, $full_name, $gender, $mobile, $email, $info, $this->user->substation_id,
            $this->user->is_active);
        if ($ret) {
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = '';
        } else {
            $jsonRet['ret'] = 2;
            $jsonRet['data'] = '';
        }
        echo json_encode($jsonRet);
        return;
    }

    function getmessage()
    {
        $jsonRet = array();
        $mesgType = $this->input->get('msgtype');
        $mesgList = array();
        if ($mesgType == 1) {
            $feedbackList = $this->mp_xjdh->Get_FeedbackList($this->user->id);
            foreach ($feedbackList as $feedbackObj) {
                $mesgObj = new stdClass();
                $mesgObj->id = $feedbackObj->id;
                $mesgObj->content = '/wap/feedback?id=' . $feedbackObj->id;
                $mesgObj->title = $feedbackObj->content;
                $mesgObj->added_datetime = $feedbackObj->added_datetime;
                $mesgObj->is_web = true;
                $mesgObj->send_by = '意见反馈';
                array_push($mesgList, $mesgObj);
            }
        }
        $jsonRet['ret'] = 0;
        $jsonRet['data'] = json_encode($mesgList);
        echo json_encode($jsonRet);
        return;
    }

    function deleteStation()
    {
        $stationId = $this->input->get('station_id');
        $result = $this->mp_xjdh->Delete_substation($stationId);
        $result1 = $this->mp_xjdh->Delete_ImgApi($stationId);
        if ($result && $result1) {
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = '';
            echo json_encode($jsonRet);
            return;
        }

    }

    function get_door_status()
    {
        $data_id = $this->input->get('data_id');
        $jsonRet = array();
        $CI = &get_instance();
        $CI->load->driver('cache', array('adapter' => 'memcached'));
        $memData = $CI->cache->get($data_id);
        $v = unpack('C*', substr($memData, 4, 2));
        $jsonRet['data'] = strval($v[1]);
        $jsonRet['ret'] = 0;
        echo json_encode($jsonRet);
    }

    function changepasswd()
    {
        $jsonRet = array();
        $txtPasswdold = $this->input->get('txtPasswdold');
        $txtPasswdnew = $this->input->get('txtPasswdnew');
        $txtPasswdagain = $this->input->get('txtPasswdagain');
        if ($this->user->password == md5($txtPasswdold)) {
            if ($txtPasswdnew == $txtPasswdagain) {
                if (User::ChangePasswd($this->user->id, $txtPasswdnew)) {
                    $jsonRet['msg'] = "修改密码成功!";
                    $jsonRet['ret'] = 0;
                }
            } else {
                $jsonRet['msg'] = "两次密码输入不相同!";
                $jsonRet['ret'] = 1;
            }
        } else {
            $jsonRet['msg'] = "旧密码不正确!";
            $jsonRet['ret'] = 1;
        }
        echo json_encode($jsonRet);
        return;
    }

    function open_door()
    {
        $jsonRet = array();
        $jsonRet["ret"] = $ret;
        $data_id = $this->input->post('data_id');
        $message = $this->input->post('message');
        $action = $this->input->post('action');
        $CI = &get_instance();
        $CI->mp_xjdh->up_door_record($this->user->id, $message, $this->user->accessid, $action, $data_id);

        $this->load->helper("smdthrift");
        $apiObj = new SMDThrift();
        if ($action == "远程开门") {
            for ($j = 0; $j < 3; $j++) {
                $ret = $apiObj->DoorControl($data_id, 1/*OPENDOOR*/);
                if ($ret > 0) {
                    $i = 0;
                    while ($i++ < 5) {
                        usleep(200000);
                        $ret = $apiObj->DoorControl($data_id, 2/*OPENDOOR_STATUS*/);
                        if ($ret == 1) {
                            $jsonRet["ret"] = 0;
                            echo json_encode($jsonRet);
                            return;
                        }
                    }
                } else {
                    $jsonRet["ret"] = 1;
                    $jsonRet["msg"] = "设备未就绪，请重试";
                    break;
                }
            }
            if ($j == 3) {
                $jsonRet["ret"] = 1;
                $jsonRet["msg"] = "开门失败，请重试";
            }
        } else {
            $apiObj = new SMDThrift();
            $ret = $apiObj->DoorControl($data_id, 3/*OPENDOOR*/);
            if ($ret > 0) {
                $jsonRet["ret"] = $ret;
            } else {
                $jsonRet["ret"] = $ret;
                $jsonRet["msg"] = "设备未就绪，请重试";
            }
        }
        echo json_encode($jsonRet);
    }

    function AddDoorUser()
    {
        $postParams = json_decode(file_get_contents('php://input'), true);
//     	$postParams = '[{"name":"Bill","mobile":"","card_number":"1111111111","door_id":"4156602376","start_datetime":"2222-10-22","end_datetime":"2000-10-22"},
//    		         {"name":"jim","mobile":"13333333333","card_number":"2222222222","door_id":"4111111111","start_datetime":"2111-10-22","end_datetime":"2011-10-22"}]';
//    		$postParams = json_decode($postParams,true);
        $jsonRet = array();
        $Ret = array();
        $jsonRet["ret"] = $ret;
        foreach ($postParams as $key => $val) {
            $name = $val['name'];
            $mobile = $val['mobile'];
            $card_number = $val['card_number'];
            $door_id = $val['door_id'];
            $start_datetime = $val['start_datetime'];
            $end_datetime = $val['end_datetime'];
            $hex = dechex($card_number);//转成16进制
            $hex = substr($hex, 2, strlen($hex));//去掉前两位
            $decimal = hexdec($hex);//将16进制转成10进制

            $n = 10 - strlen($decimal);//将门禁卡号补成10位
            $zero = '';
            for ($i = 1; $i <= $n; $i++) {
                $zero .= "0";
            }
            $card_number = $zero . $decimal;

            if ($name) {
                if ($mobile) {
                    $mobileObj = $this->mp_xjdh->check_mobile($mobile);
                    if ($mobileObj->mobile == $mobile && $mobileObj->user_role != "door_user") {   //手机号和以前用户有冲突，如果以前用户是动环系统固有用户，则不更新记录
                        $jsonRet["ret"] = 3;
                        $jsonRet["msg"] = "该手机号已存在";
                    } else {
                        $this->mp_xjdh->add_door_user_on_user($name, $mobile, $card_number);//存进user表
                        $userObj = $this->mp_xjdh->get_user_id_by_name($name);
                        $user_id = $userObj->id;
                        $ret = $this->mp_xjdh->add_door_user($door_id, $start_datetime, $end_datetime, $user_id);
                        if ($ret > 0) {
                            $jsonRet["ret"] = 0;
                            $jsonRet["msg"] = "门禁授权成功";
                        } else {
                            $jsonRet["ret"] = 4;
                            $jsonRet["msg"] = "授权失败";
                        }
                    }
                } else {
                    $jsonRet["ret"] = 2;
                    $jsonRet["msg"] = "未填写手机号";
                }
            } else {
                $jsonRet["ret"] = 1;
                $jsonRet["msg"] = "未填写填写用户名";
            }
            array_push($Ret, $jsonRet);
        }
        echo json_encode($Ret);
    }


    /**
     * 提交审核内容
     * post方式传递参数：
     * $substationID 局站id;
     * $roomID 机房id;
     * $userID = 用户id;
     * $questionID = 某一个问题的id;
     * 图片 和之前一样
     */
    function CheckUpload()
    {

        //存储文件
        $file_path = "./public/portal/Check_image/";
        $fileName = $_FILES['uploadImg']['name'];
        $fileTempName = $_FILES['uploadImg']['tmp_name'];

        for ($i = 0; $i < count($fileName); $i++) {
            move_uploaded_file($fileTempName[$i], $file_path . $fileName[$i]);
        }

        //文件过大
        if ($fileTempName['size'] > "500000") {
            $jsonRet['ret'] = 1;
            $jsonRet['data'] = '';
            echo json_encode('文件过大');
            return;
        }

        $substationID = $this->input->post("substationID");
        $roomID = $this->input->post("roomID");
        $questionID = $this->input->post("questionID");
        $userID = $this->input->post("userID");

        //获取当前申请
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('room_id', $roomID);
        $res = $dbObj->get('check_apply')->row_array();

        //判断是否第一次上传，第一次上传新建一条check_apply数据
        if (empty($res)) {

            $dbObj->set('room_id', $roomID);
            $dbObj->set('substation_id',$substationID);
            $dbObj->set('user_id', $userID);
            $dbObj->set('content', json_encode([
                $questionID=>$fileName,
            ]));
            $dbObj->insert('check_apply');

            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode($fileName);
            echo json_encode($jsonRet);
            return;
        }

        //如果已经提交了审核，则不能提交
        if ($res['is_apply'] == 1) {

            $jsonRet['ret'] = 1;
            $jsonRet['data'] = '已经提交了审核，不能再次提交';
            echo json_encode($jsonRet);
            return;
        }

        //判断此问题的id是否已经有过回答
        //...

        //如果不是第一次上传，就找到对应的信息， 在content字段追加数据

        $applyContent = json_decode($res['content'],true);
        $applyContent[$questionID] = $fileName;
        $dbObj->where('room_id',$roomID);
        $dbObj->set('content', json_encode($applyContent));
        $dbObj->update('check_apply');
        //更新对应apply状态
        if($this->updateCheckAppply($roomID)){
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = '';
            echo json_encode($jsonRet);
            return;
        };



    }

    /**
     * 获取问题
     * $roomID 机房id;如果此机房有提交问题，则返回机房还没有提交的问题，如果此机房没有提交问题， 则返回所有可以提交的问题。
     */
    function checkQuestion($roomID = null)
    {

        $roomID = is_null( $this->input->get("roomID"))?null:$this->input->get("roomID");
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('room_id',$roomID);
        $apply = $dbObj->get('check_apply')->row_array();


        //审核表里没有对应机房的信息，说明没有提交申请，获取所有问题
        if(is_null($apply)){
            $res = $dbObj->get('check_question')->result();
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['questionList'=>$res]);
            echo json_encode($jsonRet);
            return;
        }else{
            //审核表里有对应机房信息，说明提交了申请，获取已经提交的问题列表
            $content = json_decode($apply['content']);
            $questionIDs = [];
            foreach ($content as $key=>$c){
                $questionIDs[] = $key;
            }
            $dbObj->where_not_in('id',$questionIDs);
            $res = $dbObj->get('check_question')->result_array();

            //所有问题已经都提交
            if(empty($res)){
                $jsonRet['ret'] = 1;
                $jsonRet['data'] = '该机房的问题已经全部提交';
                echo json_encode($jsonRet);
                return;
            }
            $jsonRet['ret'] =0;
            $jsonRet['data'] = json_encode(['questionList'=>$res]);
            echo json_encode($jsonRet);
            return;
        }
    }


    /**
     * @param null $type 接收get传参数 不传默认打印城市 1为局站 2为机房
     * @param null $id 接收get传参数  当要获取城市时不传， 获取局站时传城市id 获取机房时传局站id
     * 获取有效的可提交审核的城市
     */
    function GetCheckLocation($type = null, $id = null)
    {
        $type = is_null( $this->input->get("type"))?null:$this->input->get("type");
        $id = is_null( $this->input->get("id"))?null:$this->input->get("id");

        $dbObj = $this->load->database('default', TRUE);

        //生成已经有apply的机房和局站名称
        $roomList = [];
        $substationList = [];
        //机房表
        $dbObj->where('is_apply', 1);
        $dbObj->select('room_id');
        $res = $dbObj->get('check_apply')->result_array();
        foreach ($res as $room) {
            $roomList[] = $room['room_id'];
        }


        //局站表生成
        $dbObj->select('substation_id');
        $dbObj->where_not_in('id', $roomList);
        $dbObj->distinct('substation_id');
        $res = $dbObj->get('room')->result_array();
        foreach ($res as $sub) {
            $substationList[] = $sub['substation_id'];
        }

        //获取城市
        if (is_null($type)) {
            $dbObj->select('city_code,city');
            $dbObj->distinct('city');
            $res = $dbObj->get('substation')->result_array();

            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['checkCityList'=>$res]);
            echo json_encode($jsonRet);
            return;
        }

        //获取局站
        if ($type == 1 && $id) {
            $dbObj->select('id,name');
            $dbObj->where('city_code', $id);
            $dbObj->where_in('id', $substationList);
            $res = $dbObj->get('substation')->result_array();

            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['checkSubsList'=>$res]);
            echo json_encode($jsonRet);
            return;
        }

        //获取机房
        if ($type == 2 && $id) {
            $dbObj->select('id,name');
            $dbObj->where('substation_id', 1);
            $dbObj->where_not_in('id', $roomList);
            $res = $dbObj->get('room')->result_array();

            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['checkRoomList'=>$res]);
            echo json_encode($jsonRet);
            return;
        }

    }

    /**
     * 接收get参数 名为 roomID
     * 返回数据名 applyInfoList
     * 根据checkID 返回目前正在编辑中的没有审核的申请
     */
    function GetApplyInfo()
    {
        $roomID = $this->input->get("roomID");
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('room_id', $roomID);
        $res = $dbObj->get('check_apply')->row_array();
        if ($res['is_apply'] == 1) {
            $jsonRet['ret'] = 1;
            $jsonRet['data'] = '信息已经提交审核 无法更改！';
            echo json_encode($jsonRet);
            return;
        }
        $jsonRet['ret'] = 0;
        $jsonRet['data'] = json_encode(['applyInfoList',$res]);
        echo json_encode($jsonRet);
        return;
    }

    /**
     * @param $applyID 更新申请的状态，如果问题都已经提交，则更新此机房对应的check_apply表的is_apply字段为1
     */
    private function updateCheckAppply($roomID){
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('room_id',$roomID);
        $applyInfo = $dbObj->get('check_apply')->row_array();

        $content = json_decode($applyInfo['content']);
        $questionIDs = [];
        foreach ($content as $key=>$c){
            $questionIDs[] = $key;
        }

        $dbObj->where_not_in('id',$questionIDs);
        $questionAvailable = $dbObj->get('check_question')->row_array();

        if(empty($questionAvailable)){
            //更新is_apply状态
            $dbObj->where('room_id',$roomID);
            $dbObj->set('is_apply',1);
            $dbObj->update('check_apply');
        }

        return true;
    }

}

?>
