<?php


class CommonController extends CI_Controller{
    private $userObj = null;

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

    public function index()
    {

    }
};