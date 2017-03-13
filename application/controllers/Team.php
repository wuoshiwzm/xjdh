<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 2017/2/27
 * Time: 9:52
 */
require_once "CommonController.php";

class Team extends CommonController
{
    private $userObj;

    public function index()
    {
        $data = array();
//        $data['userObj'] = $this->userObj;
//        $data['gCity'] = Defines::$gCity;
//        $data['gCounty'] = $gCounty = Defines::$gCounty;
//        $data['actTab'] = 'users';
        $data['bcList'] = array();

//        $bcObj = new Breadcrumb();
//        $bcObj->title = ' ';
//        array_push($data['bcList'], $bcObj);

        $bcObj = new Breadcrumb();
        $bcObj->title = '施工队管理';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);

        //搜索

        /*$data['cityCode'] = $cityCode = $this->input->get('selCity');
        $data['countyCode'] = $countyCode = $this->input->get('selCounty');
        $data['offset'] = $offset = intval($this->input->get('per_page'));
        $data['userRole'] = $userRole = $this->input->get('userRole');
        $data['gender'] = $gender = $this->input->get('gender');
        $data['fullName'] = $fullName = trim($this->input->get('fullName'));
        $data['mobile'] = $mobile = trim($this->input->get('mobile'));
        $data['email'] = $email = $this->input->get('email');
        $data['accessId'] = $accessId = trim($this->input->get('accessId'));*/


        //获取施工队内容
//        $data['count'] = $count = User::Get_UserCount($cityCode, $countyCode, $fullName,
//            $gender, $email, $userRole, $mobile, $accessId, false, $this->userObj->city_code, false);

//        $data['userList'] = User::getTeam();

        //上传施工队信息
//        $import = $this->input->post('import');
//        if ($import == 'importtodb') {
//            $config['upload_path'] = './public/portal/Station_image/';
//            $config['allowed_types'] = 'xls|xlsx';
//            $config['file_name'] = 'user';
//            $config['max_size'] = 500000;
//            $this->load->library('upload', $config);
//            if ($this->upload->do_upload('teamfile')) {
//
//                $up = $this->upload->data();
//                $file_name = $up["file_name"];
//                require_once("phpexcel/PHPExcel.php");
//                $objPHPExcel = PHPExcel_IOFactory::load('./public/portal/Station_image/' . $file_name);
//                $sheet = $objPHPExcel->getSheet(0);
//                $maxRow = $sheet->getHighestRow();
//                if ($sheet->getCell('A' . '1')->getValue() == "负责人" && $sheet
//                        ->getCell('B' . '1')->getValue() == "成员"
//                ) {
//                    $errMsg = '';
//                    for ($i = 2; $i <= $maxRow; $i++) {
//                        $leader = $sheet->getCell('A' . $i)->getValue();
//                        $members = $sheet->getCell('B' . $i)->getValue();
//
//                    if (User::Get_mobile_User($mobile)) {
//                        $errMsg .= $data['errMsg'] = '手机号重复' . ',';
//                    }
//                        //写入数据
//                        if ($errMsg == '') {
//                            $dbObj = $this->load->database('default', TRUE);
//                            $dbObj->set('leader', $leader);
//                            $dbObj->set('members', $members);
//                            $dbObj->inser('team');
//                            $id = $dbObj->insert_id();
//                        } else {
//                            $data['errMsg'] = $errMsg . "请修改后重新导入";
//                        }
//                    }
//                    if ($id != 0) {
//                        unlink('./public/portal/Station_image/' . $file_name);
//                        $count = $maxRow - 1;
//                        $data['msg'] = "共导入" . $count . "条信息，请点击刷新页面查看。";
//                    }
//
//                } else {
//                    $data['errMsg'] = "请上传正确的文件，包括(负责人名，团队成员)。";
//                }
//            } else {
//                $data['errMsg'] = "请选择上传的文件，包括(负责人名,团队成员)。";
//            }
//        }

        $dbObj = $this->load->database('default', TRUE);

        $data['teams'] = $dbObj->get('check_team')->result();


        //调取视图
        //$data['pagination'] = $this->mp_paging->Show(Util::Build_Page_Base("member/team"), $count, DEFAULT_PAGE_SIZE, 3, TRUE);
        $content = $this->load->view('check/team', $data, TRUE);
        $scriptExtra = '<script type="text/javascript" src="/public/js/bootbox.js"></script>';
        $scriptExtra .= '<script type="text/javascript" src="/public/portal/js/team.js"></script>';
        $this->mp_master->Show_Portal($content, $scriptExtra, '人员管理', $data);
    }


}