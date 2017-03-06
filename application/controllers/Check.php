<?php

/**
 * Class CheckController
 * 审核模块页面控制器
 */
class Check extends CI_Controller
{

    private $userObj;

    public function __construct()
    {
        parent::__construct();
        if (!User::IsAuthenticated()) {
            redirect('/login');
        } else {
            $this->userObj = User::GetCurrentUser();
            User::Set_UserWebOnline($this->userObj->id);
        }
    }

    /**
     * 跳转控制
     */
    public function index()
    {
        $this->arrange();
    }

    /**
     * 用户界面 -- 工艺
     */
    private function Check()
    {
        $check_role = $this->userObj->check_role;
        $data['check_role'] = $check_role;

        $scriptExtra = '<script src="/public/layer/layer.js"></script>';
        $scriptExtra .= '<script src="/public/js/check/approve.js"></script>';

        $data = array();
        $data['userObj'] = $this->userObj;
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();

        //public function allowRole($type, $roleAllow = null, $roleApply = null)
        //check_role:1:一级审核 2:二级审核 3:查看，只能看，不能操作
        if (Author::allowRole(4, 1, $check_role)) {
            $bcObj->title = '审核工程 - 一级审核';
            $bcObj->url = site_url("check/check");
            $bcObj->isLast = true;
            array_push($data['bcList'], $bcObj);
            $data['applys'] = $this->getApplyInfo(1);

            $content = $this->load->view("check/first_check", $data, TRUE);
            $this->mp_master->Show_Portal($content, $scriptExtra, '一级审核', $data);
        }

        if (Author::allowRole(4, 2, $check_role)) {
            $bcObj->title = '审核工程 - 二级审核';
            $bcObj->url = site_url("check/check");
            $bcObj->isLast = true;
            array_push($data['bcList'], $bcObj);
            $data['applys'] = $this->getApplyInfo(2);

            $content = $this->load->view("check/first_check", $data, TRUE);
            $this->mp_master->Show_Portal($content, $scriptExtra, '二级审核', $data);
        }

        if (Author::allowRole(4, 3, $check_role)) {
            $bcObj->title = '审核工程 - 总揽';
            $bcObj->url = site_url("check/check");
            $bcObj->isLast = true;
            array_push($data['bcList'], $bcObj);
            $data['applys'] = $this->getApplyInfo(3);

            $content = $this->load->view("check/all_check", $data, TRUE);
            $this->mp_master->Show_Portal($content, $scriptExtra, '二级审核', $data);
        }

    }

    /**
     * @param $apply_id
     * 跳转到审核页面 -- 工艺
     */
    public function approveSub($subID)
    {
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['bcList'] = array();


        $bcObj = new Breadcrumb();
        $bcObj->title = '审核工程';
        $bcObj->url = site_url("check");
        $bcObj->isLast = false;
        array_push($data['bcList'], $bcObj);

        $bcObj = new Breadcrumb();
        $bcObj->title = '审核工程 - 工艺审核';
        $bcObj->url = site_url("check");
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);

        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('substation_id', $subID);
        $res = $dbObj->get('check_apply')->row();

        //无任何信息
        if (is_null($res)) {
            $data['cases'] = [];
        } else {
            //获取审核问题内容
            $contents = json_decode($res->content);
            $data['cases'] = [];

            foreach ($contents as $key => $content) {
                $dbObj = $this->load->database('default', TRUE);
                $dbObj->where('id', $key);
                $res = $dbObj->get('check_question')->row();
                $case['question'] = $res;
                $case['answer'] = $content;
                $data['cases'][] = $case;
            }
        }

        $data['info'] = $this->getInfo($subID);
        $scriptExtra = '';

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
//        $scriptExtra = '<script src="/public/layer/layer.js"></script>';
//        $scriptExtra .= '<script src="/public/js/check/approve.js"></script>';
        $content = $this->load->view("check/approveSub", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '审核', $data);
    }


    /**
     * @param $apply_id
     * 跳转到审核页面 -- 设备
     */
    public function approveDev($subID)
    {
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['bcList'] = array();

        $bcObj = new Breadcrumb();
        $bcObj->title = '审核工程';
        $bcObj->url = site_url("check");
        $bcObj->isLast = false;
        array_push($data['bcList'], $bcObj);

        $bcObj = new Breadcrumb();
        $bcObj->title = '审核工程 - 设备审核';
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);

        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('substation_id', $subID);
        $res = $dbObj->get('check_device')->result();

        $data['devs'] = [];
        //无任何信息
        if (is_null($res)) {
            $data['cases'] = [];
        } else {
            //data_id data_pics room_idx
            foreach ($res as $r) {
                //获取设备验收内容
                $contents = json_decode($r->content);
                foreach ($contents as $key => $content) {
                    array_push($data['cases'], [
                        'data_id' => $key,
                        'data_name' => $this->mp_xjdh->get_device_name($key),
                        'data_pics' => $content,
                        'room_id' => $r->room_id,
                        'room_name' => $this->mp_xjdh->Get_room_name($r->room_id)->name,
                    ]);
                }
            }

        }

        $data['info'] = $this->getInfo($subID);
        $scriptExtra = '';

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
//        $scriptExtra = '<script src="/public/layer/layer.js"></script>';
//        $scriptExtra .= '<script src="/public/js/check/approve.js"></script>';
        $content = $this->load->view("check/approveDev", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '审核', $data);


    }

    /**
     * @param $apply_id '
     * 审核通过某个提交的审核
     */
    public function approveCase($subID)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('substation_id', $subID);
        $apply = $dbObj->get('check_arrange')->row();

        //是否已经确认提交还是编辑中
        if (!$apply->is_apply) {
            die('该审核信息还在编辑中');
            return;
        }
        //判断是否已经完成审核
        if ($apply->check_tel) {
            die('该审核信息已经成功审核完成');
            return;
        }
        //一级审核未进行，则进行一级审核
        if (!$apply->check_jim) {
            $dbObj->where('substation_id', $subID);
            $dbObj->update('check_arrange', ['check_jim' => 1]);
            die('信息更新成功，请关闭窗口');
            return;
        }
        //二级审核
        $dbObj->where('substation_id', $subID);
        $dbObj->update('check_arrange', ['check_tel' => 1]);
        return;
    }

    /**
     * @param $apply_id '
     * 审核不通过某个提交的审核
     */
    public function unapproveCase($apply_id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $apply_id);
        $apply = $dbObj->get('check_apply')->row();

        //是否已经确认提交还是编辑中
        if (!$apply->is_apply) {
            die('该审核信息还在编辑中');
        }

        //所有审核归零
        $dbObj->where('id', $apply_id);
        $dbObj->update('check_apply', ['check_jim' => 0, 'check_tel' => 0, 'is_apply' => 0]);
        redirect('');
        return;
    }

    /**
     * @param $type 1:新建审核提交 2:打开已有审核
     */
    public function getQuestions($type = null)
    {
        //新建审核，返回新建表的问题信息
        if (is_null($type)) {
            $dbObj = $this->load->database('default', TRUE);
            $res = $dbObj->get('check_question')->result();
            return json_encode($res);
        }

        //已经提交过的审核， 返回

    }


    /**
     * @param $class 1:一级审核 2:二级审核
     * @return mixed
     * 工艺验收 - 获取审核的内容与城市用户关联的表
     */
    private function getApplyInfo($class)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->from('check_apply');
        $dbObj->join('user', 'check_apply.user_id = user.id');
        $dbObj->join('substation', 'check_apply.substation_id = substation.id');
        $dbObj->where('is_apply', 1);
        //一级审核
        if ($class == 1) {
            $dbObj->where('check_jim !=', 1);
        }
        //二级审核
        if ($class == 2) {
            $dbObj->where('check_tel !=', 1);
            $dbObj->where('check_jim', 1);
        }
        //所有审核信息
        if ($class == 3) {
            //$dbObj->where('check_tel !=', 1);
            $dbObj->where('check_jim', 1);
        }

        $dbObj->select(
            '
            user.username as username,
            user.full_name as name,
            check_apply.*,check_apply.id as check_id,
            substation.city as subs_city,
            substation.county as subs_county,
            substation.name as subs_name,
            '
        );
        return $dbObj->get()->result();
    }


    /**
     * @param $class 1:一级审核 2:二级审核
     * @return mixed
     * 设备验收 - 获取审核的内容与城市用户关联的表
     */
    private function getCheckInfo($class)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->from('check_device');
        $dbObj->join('user', 'check_apply.user_id = user.id');
        $dbObj->join('substation', 'check_apply.substation_id = substation.id');
        $dbObj->where('is_apply', 1);
        //一级审核
        if ($class == 1) {
            $dbObj->where('check_jim !=', 1);
        }
        //二级审核
        if ($class == 2) {
            $dbObj->where('check_tel !=', 1);
            $dbObj->where('check_jim', 1);
        }
        //所有审核信息
        if ($class == 3) {
            //$dbObj->where('check_tel !=', 1);
            $dbObj->where('check_jim', 1);
        }

        $dbObj->select(
            '
            user.username as username,
            user.full_name as name,
            check_device.*,check_device.id as check_id,
            substation.city as subs_city,
            substation.county as subs_county,
            substation.name as subs_name,
            '
        );
        return $dbObj->get()->result();
    }


    /**
     * @return mixed
     * 获取当前内容与城市用户关联的表
     */
    private function getInfo($subID)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->from('check_arrange');
        $dbObj->join('user', 'check_arrange.user_id = user.id');
        $dbObj->join('substation', 'check_arrange.substation_id = substation.id');
        $dbObj->where('check_arrange.substation_id', $subID);

        $dbObj->select(
            '
            user.username as username,
            user.full_name as name,
            check_arrange.*,check_arrange.id as check_id,
            substation.city as subs_city,
            substation.county as subs_county,
            substation.name as subs_name,
            substation.id as substation_id,
            '
        );
        return $dbObj->get()->row();
    }

    /*---------------------------------------------------*/
    /*                  督导安排模块                      */
    /*---------------------------------------------------*/
    /**
     * 安排督导检测的页面
     */
    public function arrange()
    {
        $check_role = $this->userObj->check_role;
        //未提交问题的局站：
        $scriptExtra = '<script src="/public/layer/layer.js"></script>';
        $scriptExtra .= '<script src="/public/js/check/approve.js"></script>';
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
        //$scriptExtra .= '<script src="/public/js/jquery.combo.select.js"></script>';
        $scriptExtra .= '<link rel="stylesheet" href="/public/css/combo.select.css"/>';
        //初始化
        $scriptExtra .= '<script src="/public/js/check/arrange.js"></script>';


        $data = array();
        $data['userObj'] = $this->userObj;
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();

        //权限判断与显示
        if (Author::allowRole(5, [3, 4], $check_role)) {
            //获取督导的数据
            $bcObj->title = '审核工程 - 安排督导';
            $bcObj->url = site_url("check/arrange");
            $bcObj->isLast = true;
            array_push($data['bcList'], $bcObj);

            $dbObj = $this->load->database('default', TRUE);

            //未提交
            $emptyCheck = [];
            //已经提交了内容的局站ID
            $testArr = [];
            $res = $dbObj->get('check_apply')->result();
//            $dbObj->get('check_apply')->result_array();
            foreach ($res as $k) {
                $testArr[] = $k->substation_id;
            }
            $res = $dbObj->get('check_device')->result();
            foreach ($res as $k) {
                $testArr[] = $k->substation_id;
            }

            $dbObj->where_not_in('substation_id', $testArr);
            $res = $dbObj->get('check_arrange')->result();

            foreach ($res as $k) {
                $emptyCheck[] = $k->substation_id;
            }

            //Ltest::test($testArr);
            //搜索
            //验收状态
            $checkStatus = $this->input->get('checkStatus');
            //吉姆督导验收时间
            $dateRangeApply = $this->input->get('dateRangeApply');
            //吉姆督查分配时间
            $dateRangeArrange = $this->input->get('dateRangeArrange');
            //吉姆督查审核时间
            $dateRangeJimApprove = $this->input->get('dateRangeJimApprove');
            //电信督查审核时间
            $dateRangeTelApprove = $this->input->get('dateRangeTelApprove');

//            Ltest::test($this->input->get());
            //Ltest::test($dateRangeApply);

            //获取现有的安排信息的数据

            //验收状态
            //1' >  已经分配
            //2' >  待验中
            //3' >  待验完成 - 提交
            //4' > 吉姆督查核查完成
            //5' > 电信督查核查完成

            if (!empty($checkStatus)) {
                switch ($checkStatus) {
                    case 1:
                        $dbObj->where('is_apply !=', 1);
                        $dbObj->where_in('substation_id', $emptyCheck);
                        break;
                    case 2:
                        $dbObj->where('is_apply !=', 1);
                        $dbObj->where_not_in('substation_id', $emptyCheck);
                        break;
                    case 3:
                        $dbObj->where('is_apply', 1);
                        $dbObj->where('check_jim !=', 1);
                        $dbObj->where('check_tel !=', 1);
                        break;
                    case 4:
                        $dbObj->where('check_jim', 1);
                        $dbObj->where('check_tel !=', 1);
                        break;
                    case 5:
                        $dbObj->where('check_tel', 1);
                        break;
                }
            }
            //吉姆督导验收时间
            if (!empty($dateRangeApply)) {
                $dateRangeArr = explode('至', $dateRangeApply);
                $dbObj->where('apply_time <=', $dateRangeArr[1]);
                $dbObj->where('apply_time >=', $dateRangeArr[0]);
            }
            //吉姆督查分配时间
            if (!empty($dateRangeArrange)) {
                $dateRangeArr = explode('至', $dateRangeArrange);
                $dbObj->where('arrange_time <=', $dateRangeArr[1]);
                $dbObj->where('arrange_time >=', $dateRangeArr[0]);
            }
            //吉姆督查审核时间
            if (!empty($dateRangeJimApprove)) {
                $dateRangeArr = explode('至', $dateRangeApply);
                $dbObj->where('check_jim_time <=', $dateRangeArr[1]);
                $dbObj->where('check_jim_time >=', $dateRangeArr[0]);
            }
            //电信督查审核时间
            if (!empty($dateRangeTelApprove)) {
                $dateRangeArr = explode('至', $dateRangeApply);
                $dbObj->where('check_tel_time <=', $dateRangeArr[1]);
                $dbObj->where('check_tel_time >=', $dateRangeArr[0]);
            }


            $dbObj->order_by('arrange_time', 'DESC');
            $data['arranges'] = $dbObj->get('check_arrange')->result();
            $data['subs'] = $dbObj->get('substation')->result();
            $dbObj->where('check_role', 1);
            $data['users'] = $dbObj->get('user')->result();
            $data['allUsers'] = $dbObj->get('user')->result();

            $data['checkRole'] = $check_role;

            //Ltest::test($data['checkRole'] );


            $content = $this->load->view("check/arrange", $data, TRUE);
            $this->mp_master->Show_Portal($content, $scriptExtra, '安排督导', $data);
        }

        //提交结果 - 安排督导验收任务
        $userID = $this->input->get('user');
        $subID = $this->input->get('sub');
        if (($userID != 0) && ($subID != 0)) {

            //过滤掉已经存在的安排 某局站已经安排过， 不能再安排了
            //$dbObj->where('user_id',$userID);
            $dbObj->where('substation_id', $subID);
            $res = $dbObj->get('check_arrange')->result();

            if (count($res) > 0) {
                //已经生成过此安排了，不能再生成
                redirect('check/arrange');
            }

            $substation = $this->mp_xjdh->Get_Substations(FALSE, FALSE, FALSE, FALSE, $subID);
            $subName = $substation[0]->name;

            $userInfo = User::GetUserById($userID);
            $userName = $userInfo->full_name;
            $time = date('Y-m-d H:i:s', time());

            //写入数据库
            $dbObj->set('user_id', $userID);
            $dbObj->set('user_name', $userName);
            $dbObj->set('substation_id', $subID);
            $dbObj->set('substation_name', $subName);
            $dbObj->set('arrange_time', $time);
            $dbObj->insert('check_arrange');

            redirect('check/arrange');
        }

        //提交结果 - 安排督导角色
        $roleUser = $this->input->get('roleUser');
        $role = $this->input->get('role');
        if (($roleUser != 0) && ($role != 0)) {
            $dbObj->where('id', $roleUser);
            $dbObj->set('check_role', $role);
            $dbObj->update('user');
            redirect('check/arrange');
        }


    }

    /**
     * @param $arrangeID
     * 编辑验收安排
     */
    public function editArrange($arrangeID)
    {
        $dbObj = $this->load->database('default', TRUE);

        //更新信息
        $userID = $this->input->get('user');
        $subID = $this->input->get('sub');

        if (($userID != 0) && ($subID != 0)) {
            $dbObj->where('id', $arrangeID);
            $dbObj->set('user_id', $userID);
            $dbObj->set('substation_id', $subID);
            $dbObj->set('arrange_time', date('Y-m-d H:i:s'));
            $dbObj->update('check_arrange');
        }

        //getArrange($arrangeID=NULL,$userID=NULL,$substationID=NULL,$status=NULL);
        $arrange = $this->mp_xjdh->getArrangeByID($arrangeID);
        $data['arrange'] = $arrange;
        $data['subs'] = $dbObj->get('substation')->result();
        $data['users'] = $dbObj->get('user')->result();


        $scriptExtra = '<script src="/public/layer/layer.js"></script>';
        $scriptExtra .= '<script src="/public/js/check/approve.js"></script>';
        $content = $this->load->view("check/edit_arrange", $data);
        $this->mp_master->Show_Pure($content, $scriptExtra, '编辑', $data);
    }

    /**
     *
     * 问题管理
     *
     */
    public function question()
    {
        $data = array();
        $data['userObj'] = $this->userObj;
        $data['bcList'] = array();
        $bcObj = new Breadcrumb();

        $bcObj->title = '审核工程';
        $bcObj->url = site_url("check");
        $bcObj->isLast = false;
        array_push($data['bcList'], $bcObj);

        $bcObj = new Breadcrumb();
        $bcObj->title = '审核工程 - 问题管理';
        $bcObj->url = site_url("check");
        $bcObj->isLast = true;
        array_push($data['bcList'], $bcObj);

        $dbObj = $dbObj = $this->load->database('default', TRUE);
        $data['question'] = $dbObj->get('check_question')->result();

        $scriptExtra = '';
        $scriptExtra .= '<script src="/public/js/check/approve.js"></script>';

        $content = $this->load->view("check/ques_manage", $data, TRUE);
        $this->mp_master->Show_Portal($content, $scriptExtra, '二级审核', $data);
    }

    public function updateQuestion()
    {

        $id = $this->input->post('id');
        $order = $this->input->post('order');
        $content = $this->input->post('content');
        $desc = $this->input->post('desc');

        $dbObj = $dbObj = $this->load->database('default', TRUE);

        if ($id != 'insert') {
            $dbObj->where('id', $id);
            $dbObj->set('order', $order);
            $dbObj->set('content', $content);
            $dbObj->set('desc', $desc);
            $dbObj->update('check_question');
        } else {
            $dbObj->set('order', $order);
            $dbObj->set('content', $content);
            $dbObj->set('desc', $desc);
            $dbObj->insert('check_question');
        }
        echo 'true';
    }

}