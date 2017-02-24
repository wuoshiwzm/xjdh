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

    //审核画面
    public function index()
    {
        $this->Check();
    }

    private function Check()
    {
        $check_role = $this->userObj->check_role;

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
     * 跳转到审核页面
     */
    public function approve($apply_id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $apply_id);
        $res = $dbObj->get('check_apply')->row();
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

        $data['info'] = $this->getInfo($apply_id);
        $scriptExtra = '<script src="/public/layer/layer.js"></script>';
        $scriptExtra .= '<script src="/public/js/check/approve.js"></script>';
        $content = $this->load->view("check/approve", $data);
        $this->mp_master->Show_Pure($content, $scriptExtra, '审核', $data);
    }

    /**
     * @param $apply_id '
     * 审核通过某个提交的审核
     */
    public function approveCase($apply_id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->where('id', $apply_id);
        $apply = $dbObj->get('check_apply')->row();

        //是否已经确认提交还是编辑中
        if (!$apply->is_apply) {
            die('该审核信息还在编辑中');
        }
        //判断是否已经完成审核
        if ($apply->check_tel) {
            die('该审核信息已经成功审核完成');
        }
        //一级审核未进行，则进行一级审核
        if (!$apply->check_jim) {
            $dbObj->where('id', $apply_id);
            $dbObj->update('check_apply', ['check_jim' => 1]);
            die('信息更新成功，请关闭窗口');
        }
        //二级审核
        $dbObj->where('id', $apply_id);
        $dbObj->update('check_apply', ['check_tel' => 1]);
        die('信息更新成功，请关闭窗口');
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
        $dbObj->update('check_apply', ['check_jim' => 0, 'check_tel' => 0, 'is_apply' => 0,'content'=>'']);

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
     * 获取审核的内容与城市用户关联的表
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
     * @return mixed
     * 获取当前内容与城市用户关联的表
     */
    private function getInfo($apply_id)
    {
        $dbObj = $this->load->database('default', TRUE);
        $dbObj->from('check_apply');
        $dbObj->join('user', 'check_apply.user_id = user.id');
        $dbObj->join('substation', 'check_apply.substation_id = substation.id');
        $dbObj->where('is_apply', 1);
        $dbObj->where('check_apply.id', $apply_id);

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
        return $dbObj->get()->row();
    }


}