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
     * 获取有效的可提交审核的局站或设备
     * @param null $type 接收get传参数 1工艺 2为设备
     * @param null $locationType 接收get传参数 1为局站 2为机房
     * @param null $id 接收get传参数  获取局站时传用户的ID 获取机房时传局站id
     */
    function GetLocation($type = NULL, $id = NULL, $locationType = NULL)
    {
        $type = is_null($this->input->get("type")) ? null : $this->input->get("type");
        $locationType = is_null($this->input->get("locationType")) ? null : $this->input->get("locationType");
        $id = is_null($this->input->get("id")) ? null : $this->input->get("id");


        $dbObj = $this->load->database('default', TRUE);
        //获取局站列表
        if ($locationType == 1) {
            //工艺验收
            if ($type == 1) {
                $dbObj->where('user_id', $id);
                $dbObj->where('status_check', 0);
                $dbObj->select('substation_id,substation_name');
                $res = $dbObj->get('check_arrange')->result();
            } //设备验收
            elseif ($type == 2) {
                $dbObj->where('user_id', $id);
                $dbObj->where('status_device', 0);
                $dbObj->select('substation_id,substation_name');
                $res = $dbObj->get('check_arrange')->result();
            }

            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['checkSubList' => $res]);
            echo json_encode($jsonRet);
            return;
        } //获取机房列表 -- 只对应设备验收
        elseif ($locationType == 2) {
            $roomList = [];
            $subID = $id;
            //获取已提交 的机房列表
            $roomList = [];
            $dbObj->where('substation_id', $subID);
            $dbObj->where('is_apply', 1);
            $rooms = $dbObj->get('check_device')->result_array();

            foreach ($rooms as $room) {
                $roomList[] = $room['room_id'];
            }

            $dbObj->where('substation_id', $subID);

            if (!empty($roomList)) {
                $dbObj->where_not_in('id', $roomList);
            }

            $dbObj->select('id,name');
            $res = $dbObj->get('room')->result();

            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['checkRoomList' => $res]);
            echo json_encode($jsonRet);
            return;
        } //获取设备列表
        elseif ($locationType == 3) {
            //已经提交的设备列表
            $deviceList = [];
            $roomID = $id;
            $dbObj->where('room_id', $roomID);
            $content = $dbObj->get('check_device')->row()->content;
            $contentArr = json_decode($content);
            foreach ($contentArr as $k => $v) {
                $deviceList[] = $k;
            }

            //获取对应机房的content字段，遍历已经提交过的设备ID
            $dbObj->where('room_id', $roomID);
            $dbObj->where_not_in('data_id', $deviceList);
            $dbObj->select('data_id,name');
            $res = $dbObj->get('device')->result();

            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['checkDevList' => $res]);
            echo json_encode($jsonRet);
            return;
        }


    }


    /**
     * 提交审核内容
     * post方式传递参数：
     * $typeID 上传问题的类型 1：提交局站工艺验收 2：提交机房设备验收
     * $substationID 局站id;
     * $roomID 机房id;
     * $userID = 用户id;
     * $questionID = 某一个问题的id 或   设备的id
     * 图片 和之前一样
     */
    function CheckUpload()
    {

//        $jsonRet['ret'] = 1;
//        $jsonRet['data'] = '成功链接';
//        echo json_encode($jsonRet);
//        return;

        //存储文件
        $file_path = "./public/portal/Check_image/";
        $fileName = $_FILES['uploadImg']['name'];
        $fileTempName = $_FILES['uploadImg']['tmp_name'];
        //图片上传
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
        $roomID = is_null($this->input->post("roomID")) ? NULL : $this->input->post("roomID");
        $questionID = $this->input->post("questionID");
        $userID = $this->input->post("userID");
        $typeID = $this->input->post("typeID");

        $this->checkWrite($typeID, $substationID, $roomID, $questionID, $userID, $fileName);
    }

    /**
     * 获取问题/设备
     * $type 1 工艺验收 2 设备验收
     * $topicID $type为1时指局站id $type为2时指机房id 机房id;
     */
    function getQuestion($type, $topicID = null)
    {
        $type = is_null($this->input->get("type")) ? null : $this->input->get("type");
        $topicID = is_null($this->input->get("topicID")) ? null : $this->input->get("topicID");

        $dbObj = $this->load->database('default', TRUE);
        $tableName = '';
        $search = '';
        if ($type == 1) {
            //工艺 - 通过局站ID 获取对应的验收问题
            $tableName = 'check_apply';
            $search = 'substation_id';
            $sourceTable = 'check_question';
        } elseif ($type == 2) {
            //设备 - 通过机房ID 获取对应的验收设备
            $tableName = 'check_device';
            $search = 'room_id';
            $sourceTable = 'device';
        }

        $dbObj->where($search, $topicID);
        $apply = $dbObj->get($tableName)->row_array();

        //审核表里没有对应机房的信息，说明没有提交申请，获取所有问题
        if (empty($apply)) {
            if ($type == 1) {
                //工艺
                $res = $dbObj->get('check_question')->result();

                $jsonRet['ret'] = 0;
                $jsonRet['data'] = json_encode(['questionSubList' => $res]);
                echo json_encode($jsonRet);
                return;
            } elseif ($type == 2) {

                //设备
                $dbObj->where('room_id', $topicID);
                $dbObj->select('data_id,name');
                $res = $dbObj->get('device')->result();

                $jsonRet['ret'] = 0;
                $jsonRet['data'] = json_encode(['questionDevList' => $res]);
                echo json_encode($jsonRet);
                return;
            }
        } else {
            //审核表里有对应机房信息，说明提交了申请，获取已经提交的问题列表
            $content = json_decode($apply['content']);
            $questionIDs = [];
            foreach ($content as $key => $c) {
                $questionIDs[] = $key;
            }
            if ($type == 1) {
                $dbObj->where_not_in('id', $questionIDs);
                $res = $dbObj->get('check_question')->result();

                $jsonRet['ret'] = 0;
                $jsonRet['data'] = json_encode(['questionSubList' => $res]);
                echo json_encode($jsonRet);
                return;
            } elseif ($type == 2) {

                $dbObj->where('room_id', $topicID);
                $dbObj->where_not_in('data_id', $questionIDs);
                $dbObj->select('data_id,name');
                $res = $dbObj->get('device')->result();

                $jsonRet['ret'] = 0;
                $jsonRet['data'] = json_encode(['questionDevList' => $res]);
                echo json_encode($jsonRet);
                return;
            }

            //所有问题已经都提交
            if (empty($res)) {
                $jsonRet['ret'] = 1;
                $jsonRet['data'] = '';
                echo json_encode($jsonRet);
                return;
            }
        }
    }

    /**
     * 获取已经提交的或已经验收的局站/机房
     * @param $checkType 1：工艺验收 2：设备验收
     * @param $applyType 1：已经提交 2：已经验收
     * @param $userID 用户ID
     * @param $subID 局站ID
     * @param $roomID 机房ID
     * 获取城市对应的局站列表(包括已经审核和未审核)  或者 机房列表(包括已经审核和未审核)  或者设备列表(包括已经审核和未审核)
     */
    function GetAppliedLocation($checkType, $applyType, $userID, $subID, $roomID)
    {
        $jsonRet['ret'] = 1;
        $jsonRet['data'] = '成功链接';
        echo json_encode($jsonRet);
        return;

        $checkType = is_null($this->input->get("checkType")) ? null : $this->input->get("checkType");
        $applyType = is_null($this->input->get("applyType")) ? null : $this->input->get("applyType");
        $userID = is_null($this->input->get("userID")) ? null : $this->input->get("userID");
        $subID = is_null($this->input->get("subID")) ? null : $this->input->get("subID");
        $roomID = is_null($this->input->get("roomID")) ? null : $this->input->get("roomID");

        $dbObj = $this->load->database('default', TRUE);

        $arrangeSubs = $this->getArrangeSubs($userID); //已被安排验收的局站列表
        $roomsDeviceArr = $this->getSubsRoomsDone(1, $userID);//设备验收 完成审核的机房列表

        //获取已经审核/未审核的局站
        //工艺 - 已经提交但未审核的局站：
        $unDoApplySubs = $this->getSubsPending(1, $userID);
        //工艺验收 完成审核的局站列表
        $subsApplyArr = $this->getSubsRoomsDone(2, $userID);
        //设备验收 - 获取未审核的局站列表
        $unDoDeviceSubs = $this->getSubsPending(2, $userID);

        //$checkType = 1 工艺验收 获取局站
        if ($checkType == 1) {
            //获取已经提交但未审核的局站
            if ($applyType == 1) {
                $res = $unDoApplySubs;
            } //获取已经提交已经审核通过
            elseif ($applyType == 2) {
                $dbObj->where_in('substation_id', $subsApplyArr);
                $dbObj->where('user_id', $userID);
                $dbObj->select('substation_id,substation_name');
                $res = $dbObj->get('check_apply')->result();
            }
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['locationList' => $res]);
            echo json_encode($jsonRet);
            return;
        }

        //$checkType = 2 设备验收
        //* @param $applyType 1：已经提交但未验收 2：已经验收
        if ($checkType == 2) {

            //获取局站
            if (!is_null($userID)) {
                //获取已经审核
                if ($applyType == 1) {
                    $res = $this->getDeviceSubApproved($userID);
                } //获取未审核
                elseif ($applyType == 2) {
                    $res = $this->getSubsPending(2, $userID);
                }
            } //获取机房
            elseif (!is_null($subID)) {
                //获取已经审核
                if ($applyType == 1) {
                    $res = $this->getSubsRoomsDone($subID, $userID);
                } //获取未审核
                elseif ($applyType == 2) {
                    $res = $this->getRoomsPending($subID, $userID);
                }
            }
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['locasList' => $res]);
            echo json_encode($jsonRet);
            return;
        }
    }


    /**
     * @param $type 1 工艺验收 2 设备验收
     * @param $locID
     * 根据checkID 返回目前已经编辑提交的申请的内容图片
     */
    function GetApplyInfo($type, $locID)
    {
        $jsonRet['ret'] = 1;
        $jsonRet['data'] = '成功链接';
        echo json_encode($jsonRet);
        return;

        $dbObj = $this->load->database('default', TRUE);
        $type = is_null($this->input->get("type")) ? null : $this->input->get("type");
        $locID = is_null($this->input->get("locID")) ? null : $this->input->get("locID");

        if ($type == 1) {
            $dbObj->select('id,content,desc');
            $ques = $dbObj->get('check_question')->result_array();
        } elseif ($type == 2) {
            $dbObj->where('room_id', $locID);
            $dbObj->select('data_id,name');
            $ques = $dbObj->get('device')->result_array();
        }

        foreach ($ques as &$q) {

            if ($type == 1) {
                $dbObj->where('substation_id', $locID);
                $dbObj->select('content');
                $answer = $dbObj->get('check_apply')->row_array();
                $answerArr = json_decode($answer['content'], true);

                foreach ($answerArr as $k => $a) {
                    if ($k == $q['id']) {
                        $q['answer'] = $a;
                    }
                }
            }

            if ($type == 2) {
                $dbObj->where('room_id', $locID);
                $dbObj->select('content');
                $answer = $dbObj->get('check_device')->row_array();
                $answerArr = json_decode($answer['content'], true);

                foreach ($answerArr as $k => $a) {
                    if ($k == $q['id']) {
                        $q['answer'] = $a;
                    }
                }
            }

        }

        $jsonRet['ret'] = 0;
        $jsonRet['data'] = json_encode(['applyInfoList' => $ques]);
        echo json_encode($jsonRet);
        return;
    }


    /**
     * 则更新此机房对应的check_apply表的is_apply字段为1
     */
    private function updateCheckAppply($typeID , $id)
    {
        //施工工艺验收
        if ($typeID == 1) {
            $tableName = 'check_apply';
            $search = 'substation_id';

        }
        //设备验收
        if ($typeID == 2) {
            $tableName = 'check_device';
            $search = 'room_id';

        }
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where($search, $id);
        $applyInfo = $dbObj->get($tableName)->row_array();
        $content = json_decode($applyInfo['content']);

        //判断是否已经完成提交
        //已经提交的id
        $questionIDs = [];
        foreach ($content as $key => $c) {
            $questionIDs[] = $key;
        }
        //工艺施工
        if ($typeID == 1) {
            $dbObj->where_not_in('id', $questionIDs);
            $questionAvailable = $dbObj->get('check_question')->result_array();
            //更新arrange表
            if (empty($questionAvailable)) {
                $dbObj->where('substation_id', $id);
                $dbObj->set('status_check', 1);
                $dbObj->update('check_arrange');
            }
        }

        //设备验收
        elseif ($typeID == 2) {
            $dbObj->where('room_id', $id);
            $dbObj->where_not_in('id', $questionIDs);
            $questionAvailable = $dbObj->get('device')->row_array();

            //更新arrange表
            if (empty($questionAvailable)) {
                $dbObj->where('id',$id);
                $dbObj->select('substation_id');
                $room = $dbObj->get('room')->row();

                $dbObj->where('id',$room->substation_id);
                $dbObj->select('id');
                $sub = $dbObj->get('substation')->row();


                $this->updateStatusDevice($sub->id);
            }
        }

        //更新is_apply 字段为1
        if (empty($questionAvailable)) {
            //更新is_apply状态
            $dbObj->where($search, $id);
            $dbObj->set('is_apply', 1);
            $dbObj->update($tableName);
        }
        return true;
    }


    /**
     * @param $subID局站ID
     * 更新局站对应的status_device属性
     */
    private function updateStatusDevice($subID)
    {
        $dbObj = $this->load->database('default', TRUE);
        $rarr = [];

        $dbObj->where('substation_id', $subID);
        $dbObj->select('id');
        $rids = $dbObj->get('room')->result();

        foreach ($rids as $rid) {
            $rarr[] = $rid->id;
        }

        $dbObj->where_not_in('room_id', $rarr);
        $res1 = $dbObj->get('check_device')->result_array();

        $dbObj->where_in('room_id', $rarr);
        $dbObj->where('isapply !=', 1);
        $res2 = $dbObj->get('check_device')->result_array();

        //没有机房还没提交
        if (empty($res1) && empty($res2)) {
            //更新status_device
            $dbObj->where('substation_id', $subID);
            $dbObj->set('status_device', 1);
            $dbObj->update('check_arrange');
        }
    }


    /**
     *  写入数据到content
     * @param $tableName
     * @param $data
     */
    private function checkWrite($typeID, $substationID, $roomID, $questionID, $userID, $fileName)
    {
        //工艺验收
        if ($typeID == 1) {
            $tableName = 'check_apply';
        }

        //设备验收
        if ($typeID == 2) {
            $tableName = 'check_device';
        }

        $dbObj = $this->load->database('default', TRUE);

        if ($typeID == 1) {
            $dbObj->where('substation_id', $substationID);
        }
        if ($typeID == 2) {
            $dbObj->where('room_id', $roomID);
        }
        $res = $dbObj->get($tableName)->row_array();


        //判断是否第一次上传，第一次上传新建一条check_apply数据
        if (empty($res)) {
            if ($typeID == 2) {
                $dbObj->set('room_id', $roomID);
            }
            $dbObj->set('substation_id', $substationID);
            $dbObj->set('user_id', $userID);
            $dbObj->set('content', json_encode([
                $questionID => $fileName,
            ]));
            $dbObj->insert($tableName);

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

        //如果不是第一次上传，就找到对应的信息， 在content字段追加数据
        $applyContent = json_decode($res['content'], true);
        $applyContent[$questionID] = $fileName;
        //工艺施工
        if ($typeID == 1) {
            $dbObj->where('substation_id', $substationID);
            $dbObj->set('content', json_encode($applyContent));
            $dbObj->update('check_apply');

            //设备施工
        } elseif ($typeID == 2) {
            $dbObj->where('room_id', $roomID);
            $dbObj->set('content', json_encode($applyContent));
            $dbObj->update('check_apply');
        }



        //更新对应apply状态
        if ($typeID == 1) {
            $writable = $this->updateCheckAppply($typeID, $substationID);
        }
        if ($typeID == 2) {
            $writable = $this->updateCheckAppply($typeID, $roomID);
        }

        if ($writable) {
            $jsonRet['ret'] = 0;
            $jsonRet['data'] = '';
            echo json_encode($jsonRet);
            return;
        };
    }


    /**
     * @param $userID
     * 获取安排的局站ID
     */
    private function getArrangeSubs($userID)
    {
        $subs = [];
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('user_id', $userID);
        $dbObj->select('substation_id');
        $subRes = $dbObj->get('check_arrange')->result_array();
        foreach ($subRes as $sub) {
            array_push($subs, $sub['substation_id']);
        }
        return $subs;
    }


    /**
     * @param $type 1:工艺验收，获取check_apply表 2：设备验收，获取check_device表
     * 获取已经完成审核的机房列表
     */
    private function getSubsRoomsDone($type, $userID)
    {
        $type = ($type == 1) ? 'check_apply' : 'check_device';
        $arr = [];
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('is_apply', 1);
        $dbObj->where('check_tel', 1);
        $dbObj->where('user_id', $userID);
        if ($type == 1) {
            $dbObj->select('substation_id');
        } elseif ($type == 2) {
            $dbObj->select('room_id');
        }
        $res = $dbObj->get($type)->result_array();
        foreach ($res as $re) {
            array_push($arr, $re['room_id']);
        }
        return $arr;
    }


    /**
     * @param $userID
     * @param $type 1:工艺 2：设备
     * 工艺 - 获取已经提交但是没有审核的局站
     */
    private function getSubsPending($type, $userID)
    {
        //安排的局站表
        $subsArrange = $this->getArrangeSubs($userID);
        //已经完成的局站/机房表
        $subsRoomsDone = $this->getSubsRoomsDone($userID);

        $dbObj = $this->load->database('default', TRUE);

        if ($type == 1) {
            $dbObj->where_in('substation_id', $subsArrange);
            $dbObj->where_not_in('substation_id', $subsRoomsDone);
            $dbObj->select('substation_id,substation_name');
            $res = $dbObj->get('check_apply')->result();
        } elseif ($type == 2) {
            $dbObj->where_not_in('room_id', $subsRoomsDone);
            $dbObj->distinct('substation_id');
            $dbObj->select('substation_id,substation_name');
            $res = $dbObj->get('check_device')->result();
        }
        return $res;
    }


    /**
     * @param $userID
     * 设备下已经审核通过的局站
     */
    private function getDeviceSubApproved($userID)
    {
        //安排的局站表
        $subsArrange = $this->getArrangeSubs($userID);
        //已经完成的局站/机房表
        $roomsDone = $this->getSubsRoomsDone($userID);
        $subs = [];

        $dbObj = $this->load->database('default', TRUE);

        $dbObj->where_in('room_id', $roomsDone);
        $dbObj->distinct('substation_id');
        $dbObj->select('substation_id,substation_name');
        $res = $dbObj->get('check_device')->result();
        return $res;
    }

    /**
     * @param $subID
     * 获取局站内的已经提交的审核中的机房
     */
    private function getRoomsPending($subID, $userID)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('substation_id', $subID);
        $dbObj->where('user_id', $userID);
        $dbObj->where('is_apply', 1);
        $dbObj->where('check_tel !=', 1);
        $dbObj->select('room_id,room_name');
        $res = $dbObj->get('check_device')->result();
        return $res;
    }

    /**
     * @param $subID
     * 获取局站内的审核完成的机房
     */
    private function getRoomsDone($subID, $userID)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('substation_id', $subID);
        $dbObj->where('user_id', $userID);
        $dbObj->where('is_apply', 1);
        $dbObj->where('check_tel', 1);
        $dbObj->select('room_id,room_name');
        $res = $dbObj->get('check_device')->result();
        return $res;
    }

    //------------------------------修改系统------------------------------//


    /**
     * @param $userID
     * @param $type 1:工艺- 2：设备
     * @param $locationType 1:局站- 2：机房
     * $userID
     * 获取用户已经提交的局站
     */
    public function getEditSubs($userID, $type, $locationType)
    {
        $dbObj = $this->loadd->database('default', TRUE);
        $userID = is_null($this->input->get("userID")) ? null : $this->input->get("userID");
        $type = is_null($this->input->get("type")) ? null : $this->input->get("type");
        $locationType = is_null($this->input->get("locationType")) ? null : $this->input->get("locationType");

        //工艺 - 获取局站
        if (($type == 1) && ($locationType == 1)) {
            $dbObj->from('check_apply');
            $dbObj->join('substation', 'check_apply.substation_id = substation.id');
            $dbObj->where('user_id', $userID);

            $dbObj->select(
                '
            substation.id as substation_id,
            substation.name as substation_name,
            '
            );
            $res = $dbObj->get()->result();

            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['subsList' => $res]);
            echo json_encode($jsonRet);
            return;
        }

        //设备 - 获取局站
        if (($type == 2) && ($locationType == 1)) {
            $dbObj->from('check_device');
            $dbObj->join('substation', 'check_device.substation_id = substation.id');
            $dbObj->where('user_id', $userID);

            $dbObj->select(
                '
            substation.id as substation_id,
            substation.name as substation_name,
            '
            );
            $res = $dbObj->get()->result();

            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['subsDevList' => $res]);
            echo json_encode($jsonRet);
            return;
        }

        //设备 - 获取机房
        //设备 - 获取局站
        if (($type == 2) && ($locationType == 1)) {
            $dbObj->from('check_device');
            $dbObj->join('room', 'check_device.room_id = room.id');
            $dbObj->where('user_id', $userID);

            $dbObj->select(
                '
            room.id as room_id,
            room.name as room_name,
            '
            );
            $res = $dbObj->get()->result();

            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['roomsList' => $res]);
            echo json_encode($jsonRet);
            return;
        }

    }

    /**
     * @param $type 1:工艺 2：设备
     * @param $id 工艺对应局站id 设备对应机房id
     * 获取用户已经提交的问题 对应局站(工艺)或机房(设备)
     */
    public function getEditQuestions($type, $id)
    {
        $dbObj = $this->loadd->database('default', TRUE);
        $type = is_null($this->input->get("type")) ? null : $this->input->get("type");
        $id = is_null($this->input->get("id")) ? null : $this->input->get("id");

        //工艺
        if ($type == 1) {
            $dbObj->where('substation_id', $id);
            $dbObj->select('content');
            $res = $dbObj->get('check_apply')->row();

            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['subContentList' => $res]);
            echo json_encode($jsonRet);
            return;
        }

        //设备
        if ($type == 2) {
            $dbObj->where('room_id', $id);
            $dbObj->select('content');
            $res = $dbObj->get('check_apply')->row();

            $jsonRet['ret'] = 0;
            $jsonRet['data'] = json_encode(['subContentList' => $res]);
            echo json_encode($jsonRet);
            return;

        }
    }

    /**
     * @param $type 1:工艺 2:设备
     * @param $id 工艺对应局站 设备对应机房
     * @param $questionID
     * 更新提交内容
     */
    public function editQuestion($type, $id, $questionID)
    {

        $questionID = $this->input->post("questionID");
        $id = $this->input->post("id");
        $type = $this->input->post("type");


        $dbObj = $this->load->database('default', TRUE);
        //存储文件
        $file_path = "./public/portal/Check_image/";
        $fileName = $_FILES['uploadImg']['name'];
        $fileTempName = $_FILES['uploadImg']['tmp_name'];
        //图片上传
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

        if ($type == 1) {
            $subID = $this->input->post("id");
            $table = 'check_apply';
            $search = 'substations_id';
        } elseif ($type == 2) {
            $roomID = $this->input->post("id");
            $table = 'check_device';
            $search = 'room_id';
        }


        $dbObj->where($search, $id);
        $res = $dbObj->get($table)->row_array();
        $applyContent = json_decode($res['content'], true);
        $applyContent[$questionID] = $fileName;

        $dbObj->where($search, $id);
        $dbObj->set('content', json_encode($applyContent));
        $dbObj->update($table);

        $jsonRet['ret'] = 0;
        $jsonRet['data'] = '更新完成';
        echo json_encode($jsonRet);
        return;
    }


}

?>
