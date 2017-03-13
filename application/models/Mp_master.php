<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class MP_Master extends CI_Model
{

    function __construct ()
    {
        parent::__construct();
    }

    function Show ($mainPlaceHolder, $headerPlaceHolder, $pageTitle, $data)
    {
        $data['siteName'] = $this->config->item('site_name');
        $data['headerPlaceHolder'] = '<link href="/public/account/style/user.css" rel="stylesheet" type="text/css" />
                <script src="/public/admin/js/jquery-1.8.2.min.js" type="text/javascript"></script><script src="/public/account/js/account.js" type="text/javascript"></script>' .
                 $headerPlaceHolder;
        $data['pageTitle'] = $pageTitle;
        $data['actTab'] = 'account';
        
        $data['accountPlaceHolder'] = $mainPlaceHolder;
        $data['mainPlaceHolder'] = $this->load->view('account/master', $data, TRUE);
        $this->load->view('portal/master', $data);
    }

    function Show_Portal ($mainPlaceHolder, $headerPlaceHolder, $pageTitle, $data)
    {
    	$data['userObj'] = User::GetCurrentUser();
        $data['siteName'] = $this->config->item('site_name');
        $data['pageTitle'] = $pageTitle;
        $data['mainPlaceHolder'] = $mainPlaceHolder;
        $data['headerPlaceHolder'] = $headerPlaceHolder;
        $this->load->view('portal/master', $data);
    }
}
?>