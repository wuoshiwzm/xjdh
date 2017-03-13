<?php
session_start();

class User
{

    static $userRole = array();

    function GetUserListByName ($nameList)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where_in('username', $nameList);
        return $dbObj->get('user')->result();
    }
    function Get_UserList ($cityCode = false, $countyCode = false, $fullName = false, $gender = false, $email = false, $userRole = false, $mobile = false, $access_id = false, $offset = 0, $size = 0, $substationId = false,$selCity = false,$selCounty = false, $username=false)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        // $dbObj->where_in('user_role', array('city_admin','member'));
        if ($cityCode)
        	$dbObj->where('city_code', $cityCode);
        if ($countyCode)
        	$dbObj->where('county_code', $countyCode);
        if ($gender)
            $dbObj->where('user.gender', $gender);
        if ($username)
        	$dbObj->like('user.username', $username);
        if ($fullName)
            $dbObj->like('user.full_name', $fullName);
        if ($mobile)
            $dbObj->like('user.mobile', $mobile);
        if ($access_id)
            $dbObj->like('user.accessid', $access_id);
        if ($email)
            $dbObj->like('user.email', $email);
        if ($dateStart)
            $dbObj->where('user.added_datetime >=', $dateStart . ' 00:00:00');
        if ($dateEnd)
            $dbObj->where('user.added_datetime <=', $dateEnd . ' 23:59:59');  
        if ($userRole)
        	$dbObj->where('user.user_role ', $userRole);
        if($substationId)
            $dbObj->where('substation_id',$substationId);
        if($selCity)
        	$dbObj->where('city_code',$selCity);
        if($selCounty)
        	$dbObj->where('county_code',$selCounty);
        if($accessId)
        	$dbObj->like('accessid',$accessId);
        if($_SESSION['XJTELEDH_USERROLE'] == "city_admin"){
          return $dbObj->where_not_in('user.user_role',array('noc','admin'))->get('user', $size, $offset)->result();
        }
        if($_SESSION['XJTELEDH_USERROLE'] == "operator"){
        	return $dbObj->where_not_in('user.user_role',array('operator','noc','city_admin','admin'))->get('user', $size, $offset)->result();
        }
          return $dbObj->get('user', $size, $offset)->result();
    }
    function Get_username_User ($username = false)
    {
    	$ci = &get_instance();
    	$dbObj = $ci->load->database('default', TRUE);
    	return $dbObj->get_where("user", array("username" => $username))->row();
    }
    
    function Get_email_User ($email = false)
    {
    	$ci = &get_instance();
    	$dbObj = $ci->load->database('default', TRUE);
    	return $dbObj->get_where("user", array("email" => $email))->row();
    }
    
    function Get_mobile_User ($mobile = false)
    {
    	$ci = &get_instance();
    	$dbObj = $ci->load->database('default', TRUE);
    	return $dbObj->get_where("user", array("mobile" => $mobile))->row();
    }
    
    function Get_accessId_User ($accessId = false)
    {
    	$ci = &get_instance();
    	$dbObj = $ci->load->database('default', TRUE);
    	return $dbObj->get_where("user", array("accessid" => $accessId))->row();
    }
    
    function Get_PartUserList ($userName = false, $fullName = false, $idNumber = false, $offset = 0, $size = 0, $selCity = false)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        
        if ($userName)
        	$dbObj->like('userName', $userName);
        if ($fullName)
            $dbObj->like('full_name', $fullName);
        if($selCity)
        	$dbObj->where('city_code',$selCity);
         
        if (! $size)
            return $dbObj->get('user')->result();
        else
            return $dbObj->get('user', $size, $offset)->result();
    }

    function Get_NewUsers_Count ($fullName, $mobile, $ID, $dateStart, $dateEnd, $mode = 0)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('auth_status <>', '审核通过');
        $dbObj->where('user_role', 'member');
        if ($fullName)
            $dbObj->like('full_name', $fullName);
        if ($mobile)
            $dbObj->like('mobile', $mobile);
        if ($ID)
            $dbObj->like('ID_number', $ID);
        if ($dateStart)
            $dbObj->where('added_datetime >=', $dateStart . ' 00:00:00');
        if ($dateEnd)
            $dbObj->where('added_datetime <=', $dateEnd . ' 23:59:59');
        if ($mode == 0) {
            // show complete only
            $dbObj->where("(info_filled=1 and cert_filled=1 and user_img <> '') ", '', FALSE);
        } else 
            if ($mode == 1) {
                // show incomplete only
                $dbObj->where("(info_filled=0 or cert_filled=0 or user_img = '') ", '', FALSE);
            } else {
                // show all
            }
        return $dbObj->count_all_results('user');
    }

    function Get_NewUsers_List ($fullName, $mobile, $ID, $dateStart, $dateEnd, $mode = 0, $offset = 0, $size = 10)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('auth_status <>', '审核通过');
        $dbObj->where('user_role', 'member');
        if ($fullName)
            $dbObj->like('full_name', $fullName);
        if ($mobile)
            $dbObj->like('mobile', $mobile);
        if ($ID)
            $dbObj->like('ID_number', $ID);
        if ($dateStart)
            $dbObj->where('added_datetime >=', $dateStart . ' 00:00:00');
        if ($dateEnd)
            $dbObj->where('added_datetime <=', $dateEnd . ' 23:59:59');
        if ($mode == 0) {
            // show complete only
            $dbObj->where("(info_filled=1 and cert_filled=1 and user_img <> '') ", '', FALSE);
        } else 
            if ($mode == 1) {
                // show incomplete only
                $dbObj->where("(info_filled=0 or cert_filled=0 or user_img = '') ", '', FALSE);
            } else {
                // show all
            }
        $dbObj->order_by('id', 'desc');
        return $dbObj->get('user', $size, $offset)->result();
    }

    function Get_UserCount ($cityCode = false, $countyCode = false, $fullName = false, $gender = false, $email = false, $userRole = false, $mobile = false, $access_id = false, $substation_id= false,$selCity = false,$selCounty = false, $username = false)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        // $dbObj->where_in('user_role', array('city_admin','member'));
        if ($cityCode)
        	$dbObj->where('city_code', $cityCode);
        if ($countyCode)
        	$dbObj->where('county_code', $countyCode);
        if ($gender)
            $dbObj->where('user.gender', $gender);
        if ($username)
        	$dbObj->like('user.username', $username);
        if ($fullName)
            $dbObj->like('user.full_name', $fullName);
        if ($mobile)
            $dbObj->like('user.mobile', $mobile);
        if($access_id)
            $dbObj->like('user.accessid', $access_id);
        if ($email)
            $dbObj->like('user.email', $email);
        if ($dateStart)
            $dbObj->where('user.added_datetime >=', $dateStart . ' 00:00:00');
        if ($dateEnd)
            $dbObj->where('user.added_datetime <=', $dateEnd . ' 23:59:59');
        if ($userRole)
        	$dbObj->where('user.user_role ', $userRole);
        if($substation_id)
            $dbObj->where('substation_id', $substation_id);
        if($selCity)
        	$dbObj->where('city_code',$selCity);
        if($selCounty)
        	$dbObj->where('county_code',$selCounty);
        if($accessId)
        	$dbObj->like('accessid',$accessId);
        if($_SESSION['XJTELEDH_USERROLE']  == "city_admin"){
        	return $dbObj->where_not_in('user.user_role',array('noc','admin'))->count_all_results('user');
        }
        if($_SESSION['XJTELEDH_USERROLE']  == "operator"){
        	return $dbObj->where_not_in('user.user_role',array('operator','noc','city_admin','admin'))->count_all_results('user');
        }
        
        $dbObj->select("count(distinct(user.id)) as count");
        $row = $dbObj->get('user')->row();
        return $row->count;
     
    }
   function Get_UserLoginCount($txtName,$userRole,$userAgent,$selCity,$selCounty,$selSubstation,$datestart,$dateend,$cityCode){
       $ci = &get_instance();
       $dbObj = $ci->load->database('default', TRUE);
       $dbObj->join('user as u', 'l.user_id=u.id', 'left');
       if ($txtName != '')  $dbObj->like('u.full_name', $txtName);
       if ($userRole != '')  $dbObj->where('u.user_role', $userRole);
       if($userAgent!= ''){
           if($userAgent == 'pc'){
            $dbObj->where('l.agent', 'pc');
           }else{
            $dbObj->where('l.agent <>', 'pc');
           }
       }
       if($selSubstation != '')
           $dbObj->where('u.substation_id',$selSubstation);
       else if($selCounty != '')
           $dbObj->where('u.county_code',$selCounty);
       else if($selCity != '') 
           $dbObj->where('u.city_code',$selCity);
       if($datestart != '' || $dateend != ''){
           if($datestart > 0 && $dateend > 0){
               $dbObj->where('l.time >=',$datestart.' 00:00:00');
               $dbObj->where('l.time <=',$dateend. ' 23:59:59');
           }else if($dateend == ''){
               $dbObj->where('l.time >=',$datestart.' 00:00:00');
           }else{
                $dbObj->where('l.time <=',$dateend. ' 23:59:59');
            } 
        }
        if($cityCode)
        	$dbObj->where('city_code',$cityCode);
       return $dbObj->count_all_results('user_loginlog AS  l');
       
   }
   function Get_UserLoginList($txtName,$userRole,$userAgent,$selCity,$selCounty,$selSubstation,$datestart,$dateend, $offset = 0, $size = 0,$cityCode){
       $ci = &get_instance();
       $dbObj = $ci->load->database('default', TRUE);
       $dbObj->join('user as u', 'l.user_id=u.id', 'left');
       if ($txtName != '')  $dbObj->like('u.full_name', $txtName);
       if ($userRole != '')  $dbObj->where('u.user_role', $userRole);
       if($userAgent!= ''){
           if($userAgent == 'pc'){
            $dbObj->where('l.agent', 'pc');
           }else{
            $dbObj->where('l.agent <>', 'pc');
           }
       }
       if($selSubstation != '')
           $dbObj->where('u.substation_id',$selSubstation);
       else if($selCounty != '')
           $dbObj->where('u.county_code',$selCounty);
       else if($selCity != '') 
           $dbObj->where('u.city_code',$selCity);
       if($datestart != '' || $dateend != ''){
           if($datestart > 0 && $dateend > 0){
               $dbObj->where('l.time >=',$datestart.' 00:00:00');
               $dbObj->where('l.time <=',$dateend. ' 23:59:59');
           }else if($dateend == ''){
               $dbObj->where('l.time >=',$datestart.' 00:00:00');
           }else{
                $dbObj->where('l.time <=',$dateend. ' 23:59:59');
            }
          
        }
        if($cityCode)
        	$dbObj->where('city_code',$cityCode);

       $dbObj->order_by('l.id','DESC');
       $dbObj->select('l.id AS id,  l.username AS username ,u.full_name AS full_name,u.user_role AS user_role,l.agent AS agent ,l.ip AS ip,l.time AS time ');
       return $dbObj->get('user_loginlog AS  l',$size,$offset)->result();
    }

    function Get_PartUserCount ($userName = false, $fullName = false, $idNumber = false, $selCity = false)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);      
        
        if ($userName)
        	$dbObj->like('userName', $userName);
        if ($fullName)
            $dbObj->like('full_name', $fullName);
        if($selCity)
        	$dbObj->where('city_code',$selCity);
        
        
        return $dbObj->count_all_results('user');
    }

    function UpdateUserImage ($user_id, $user_img)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('id', $user_id);
        $dbObj->set('user_image', $user_img);
        return $dbObj->update('user');
    }

    function CreateUser ($username, $password, $userRole = 'member', $full_name, $gender = 'male', $mobile, $email, 
    									$info = '', $city_code, $county_code, $substation_id, $isActive , $accessId)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->set('username', $username);
        $dbObj->set('user_role', $userRole);
        if (! empty($password))
            $dbObj->set('password', md5($password));
        $dbObj->set('full_name', $full_name);
        $dbObj->set('gender', $gender);
        $dbObj->set('mobile', $mobile);
        $dbObj->set('email', $email);
        $dbObj->set('info', $info);
        $dbObj->set('accessid', $accessId);
        $dbObj->set('is_active', $isActive);
        $dbObj->set('city_code', $city_code);
        $dbObj->set('county_code', $county_code);
        $dbObj->set('substation_id', intval($substation_id));
        $dbObj->set('added_datetime', 'now()', false);
        $dbObj->insert('user');
        return $dbObj->insert_id();
    }
    function CreateUsers ($username = false, $password = false, $userRole = 'member', $full_name = false, $gender = 'male', $mobile = false, $email = false,
    		$info = '', $substation_id = false, $isActive = false, $accessId = false,$city = false,$county = false)
    {
    	$ci = &get_instance();
    	$dbObj = $ci->load->database('default', TRUE);
    	if($username)
    	$dbObj->set('username', $username);
    	if($userRole)
    	$dbObj->set('user_role', $userRole);
    	if (! empty($password))
    		$dbObj->set('password', md5($password));
    	if($full_name)
    	$dbObj->set('full_name', $full_name);
    	if($gender)
    	$dbObj->set('gender', $gender);
    	if($mobile)
    	$dbObj->set('mobile', $mobile);
    	if($email)
    	$dbObj->set('email', $email);
    	if($info)
    	$dbObj->set('info', $info);
    	if($accessId)
    	$dbObj->set('accessid', $accessId);
    	if($isActive)
    	$dbObj->set('is_active', $isActive);
    	if($city)
    	$dbObj->set('city_code', $city);
    	if($county)
    	$dbObj->set('county_code', $county);
    	if($substation_id)
    	$dbObj->set('substation_id', $substation_id);
    	$dbObj->set('added_datetime', 'now()', false);
    	$dbObj->insert('user');
    	return $dbObj->insert_id();
    }
    function CreatePartUser ($username, $department, $position, $password, $userRole, $full_name, $gender, $race, $ID_type, $ID_number, $birth, $mobile, $email, 
            $tele, $isActive)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->set('department', $department);
        $dbObj->set('position', $position);
        $dbObj->set('username', $username);
        $dbObj->set('user_role', $userRole);
        if (! empty($password))
            $dbObj->set('password', md5($password));
        $dbObj->set('full_name', $full_name);
        $dbObj->set('gender', $gender == "male" ? 0 : 1);
        $dbObj->set('race', $race);
        $dbObj->set('ID_type', $ID_type);
        $dbObj->set('ID_number', $ID_number);
        $dbObj->set('birth', $birth);
        $dbObj->set('mobile', $mobile);
        $dbObj->set('email', $email);
        $dbObj->set('tele', $tele);
        $dbObj->set('is_active', $isActive);
        $dbObj->set('info_filled', 0);
        $dbObj->set('added_datetime', 'now()', false);
        return $dbObj->insert('user');
    }

    function CreatEnroll ($username, $phone, $company, $memo, $article_id)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->set('name', $username);
        $dbObj->set('phone', $phone);
        $dbObj->set('company', $company);
        $dbObj->set('article_id', $article_id);
        $dbObj->set('memo', $memo);
        return $dbObj->insert('enroll');
    }

    function GetUserByName ($name)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbQuery = $dbObj->get_where('user', array('username' => $name));
        if ($dbQuery->num_rows() > 0) {
            return $dbQuery->row();
        }
        return null;
    }

    function GetUserByEmail ($email)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbQuery = $dbObj->get_where('user', array('email' => $email));
        if ($dbQuery->num_rows() > 0) {
            return $dbQuery->row();
        }
        return null;
    }
    
    
    function GetUserByAccessid ($accessid)
    {
        $ci = &get_instance();
    	$dbObj = $ci->load->database('default', TRUE);
    	$dbQuery = $dbObj->get_where('user', array('accessid' => $accessid));
    	if ($dbQuery->num_rows() > 0) {
    		return $dbQuery->row();
    	}
    	return null;
    }
    
    function GetSmdDeviceByIp ($ip)
    {
    	$ci = &get_instance();
    	$dbObj = $ci->load->database('default', TRUE);
    	$dbQuery = $dbObj->get_where('smd_device', array('ip' => $ip));
    	if ($dbQuery->num_rows() > 0) {
    		return $dbQuery->row();
    	}
    	return null;
    }
  
    function GetUserByPhone ($phone)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbQuery = $dbObj->get_where('user', array('mobile' => $phone));
        if ($dbQuery->num_rows() > 0) {
            return $dbQuery->row();
        }
        return null;
    }

    function UpdateUserBindingphone ($id, $phone)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('id', $id);
        $dbObj->set('mobile', $phone);
        $dbObj->update('user');
    }

    function UpdateUserinfo ($id, $password, $userRole = 'member', $full_name, $gender, $mobile, $email, $info, $city_code, $county_code, $substation_id, $isActive , $accessId)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('id', $id);
        $dbObj->set('user_role', $userRole);
        if ($password)
            $dbObj->set('password', md5($password));
        if ($full_name)
            $dbObj->set('full_name', $full_name);
        if ($gender)
            $dbObj->set('gender', $gender);
        if ($mobile)
            $dbObj->set('mobile', $mobile);
        //if ($accessId)
        	$dbObj->set('accessid', $accessId);
        //if ($email)
            $dbObj->set('email', $email);
        if ($info)
            $dbObj->set('info', $info);
        $dbObj->set('city_code', $city_code);
        $dbObj->set('county_code', $county_code);
        $dbObj->set('substation_id', intval($substation_id));
        $dbObj->set('is_active', $isActive);
        return $dbObj->update('user');
    }

    function UpdatePartUserinfo ($id, $department, $position, $password, $userRole, $full_name, $gender, $race, $ID_type, $ID_number, $birth, $mobile, $email, 
            $tele, $isActive, $accessid)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('id', $id);
        $dbObj->set('department', $department);
        $dbObj->set('position', $position);
        $dbObj->set('user_role', $userRole);
        if (! empty($password))
            $dbObj->set('password', md5($password));
        $dbObj->set('full_name', $full_name);
        $dbObj->set('gender', $gender == "male" ? 0 : 1);
        $dbObj->set('race', $race);
        $dbObj->set('ID_type', $ID_type);
        $dbObj->set('ID_number', $ID_number);
        $dbObj->set('birth', $birth);
        $dbObj->set('mobile', $mobile);
        $dbObj->set('email', $email);
        $dbObj->set('accessid', $accessId);
        $dbObj->set('tele', $tele);
        $dbObj->set('is_active', $isActive);
        return $dbObj->update('user');
    }

    function TestInfoByUserId ($userid)
    {
        $userObj = User::GetUserById($userid);
        User::TestInfoComplete($userObj);
    }

    function TestInfoComplete ($userObj)
    {
        $ci = &get_instance();
        if ($userObj->info_filled && $userObj->cert_filled && ! empty($userObj->user_img)) {
            $dbObj = $ci->load->database('default', TRUE);
            $userObj->auth_status = "审核通过";
            $dbObj->where('id', $userObj->id);
            $dbObj->update('user', $userObj);
        }
    }

    function UpdateUser ($userObj)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('id', $userObj->id);
        return $dbObj->update('user', $userObj);
    }

    function UpdateUserPasswd ($id, $password)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('id', $id);
        $dbObj->set('password', md5($password));
        $dbObj->update('user');
        return $dbObj->get_where('user', array('id' => $id))->row();
    }

    function UpdateLastSendCode ($id, $times)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('id', $id);
        $dbObj->set('last_sendcode', 'now()', FALSE);
        $dbObj->set('today_send_times', $times);
        $dbObj->update('user');
        return $dbObj->get_where('user', array('id' => $id))->row();
    }

    /**
     * regernate User's password
     *
     * @param string|object $user            
     * @param string $errMsg            
     * @return newPassword or null if error
     */
    function GeneratePassword ($user)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        if (is_string($user)) {
            $user = User::GetUser($user);
        }
        if ($user) {
            $ci->load->helper('string');
            $newPassword = random_string('alnum', 12);
            $dbObj->set('password', md5($newPassword));
            $dbObj->where('id', $user->id);
            $dbObj->update('user');
            return $newPassword;
        }
        return null;
    }

    /**
     * Change User's Password
     *
     * @param string|object $user            
     * @param
     *            old password $oldPassword
     * @param
     *            new password $newPassword
     * @param
     *            error message $errorMsg
     * @return bool
     */
    function ChangePassword ($user, $oldPassword, $newPassword, &$errorMsg)
    {
        $ci = &get_instance();
        $ci->load->database('default');
        if (is_string($user)) {
            $user = User::GetUser($user);
        }
        if (! strcasecmp($user->password, md5($oldPassword))) {
            $user->password = md5($newPassword);
            $ci->db->where('id', $user->id);
            $ci->db->update('user', $user);
            return true;
        }
        $errorMsg = "Incorrect old password!";
        return false;
    }

    function SetInterest ($user_id, $interestStr)
    {
        $ci = &get_instance();
        $ci->load->database('default');
        $ci->db->set('interest', $interestStr);
        $ci->db->where('user_id', $user_id);
        $ci->db->update('user');
    }

    function GetMemberUser ($name)
    {
        $_SESSION["membername"] = $name;
        return User::GetUser($name);
    }

    function SetPhone ($user_id, $newPhone)
    {
        $otherUser = User::GetUser($newPhone);
        if ($otherUser && $otherUser->id != $user_id) {
            return false;
        }
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->set('phone', $newPhone);
        $dbObj->where('id', $user_id);
        $dbObj->update('user');
    }

    function ConfirmMail ($code)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('code', $code);
        $confObj = $dbObj->get('email_change_request')->row();
        if ($confObj) {
            if ((time() - strtotime($confObj->request_date)) > (60 * 60 * 24)) {
                return "您的验证码已过期";
            } else {
                $otherUser = User::GetUser($confObj->email);
                if ($otherUser) {
                    $dbObj->where('id', $confObj->id);
                    $dbObj->delete('email_change_request');
                    return "邮箱验证失败！您的新邮箱已被其他用户注册并验证";
                }
                $dbObj->set('email', $confObj->email);
                $dbObj->where('id', $confObj->user_id);
                $dbObj->update('user');
                $dbObj->where('id', $confObj->id);
                $dbObj->delete('email_change_request');
                return "您的邮箱已被成功修改";
            }
        } else {
            return "您的验证码无效";
        }
    }

    function ChangeEmail ($user, $newEmail)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('user_id', $user->id);
        $dbObj->delete('email_change_request');
        
        $dbObj->set('user_id', $user->id);
        $dbObj->set('email', $newEmail);
        
        $ci->load->helper('string');
        $code = random_string('alnum', 10);
        
        $dbObj->set('code', $code);
        $dbObj->set('request_date', 'now()', FALSE);
        $dbObj->insert('email_change_request');
        return $code;
    }

    /**
     * Get User by Email,UserId,Username
     *
     * @param string(email,userid,username) $name            
     * @return Object or Null
     */
    function GetUser ($value)
    {
    	$ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        return $dbObj->get_where('user', array('username' => $value))->row();
//         if (preg_match('@^([_a-z0-9]+\.*)+\@([_a-z0-9]+\.)+[a-z0-9]{2,3}$@is', $value)) {
//             return $dbObj->get_where('user', array('email' => $value))->row();
// //         } else if (strlen($value) == 15 && preg_match('/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/is', $value)) {
// //             return $dbObj->get_where('user', array("ID_number" => $value))->row();
// //         } else if (strlen($value) == 18 && preg_match('/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/is', $value)) {
// //             return $dbObj->get_where('user', array("ID_number" => $value))->row();
//         } else if (preg_match('@^1[3|4|5|7|8][0-9]\d{8}$@is', $value)) {
//             // Else Phone
//             return $dbObj->get_where('user', array('mobile' => $value))->row();
//         } else {
//             return $dbObj->get_where('user', array('username' => $value))->row();
//         }
    }

    function Clear_Auth ($uid, $mUidArray)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('user_id', $uid);
        $dbObj->where_not_in('id', $mUidArray);
        $dbObj->delete('user_auth');
    }

    function GetUserById ($id)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('user.id', $id);
        return $dbObj->get('user')->row();
    }
    function GetUserByMobile ($mobile)
    {
        $ci = &get_instance();
    	$dbObj = $ci->load->database('default', TRUE);
    	$dbObj->where('user.mobile', $mobile);
    	return $dbObj->get('user')->row();
    }
    function GetAuthListAll ($uid)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbObj->where('user_id', $uid);
        return $dbObj->get('user_auth')->result();
    }

    /**
     * Get Current User
     *
     * @return object or null
     */
    function GetCurrentUser ($bForceLoad = false)
    {
        if (User::IsAuthenticated()) {
            $userid = $_SESSION["XJTELEDH_USERID"];
            $user = User::GetUserById($userid, $bForceLoad);
            if ($user)
                return $user;
            else {
                $ci->load->helper("cookie");
                unset($_SESSION['XJTELEDH_USERNAME']);
                unset($_SESSION['XJTELEDH_HASH']);
                unset($_SESSION["XJTELEDH_USERID"]);
                delete_cookie("XJTELEDH_HASH");
            }
        }
        $ci = &get_instance();
        $ci->load->library('session');
        $ci->session->set_userdata('returnUrl', $_SERVER['REQUEST_URI']);
        header("Location:" . site_url('login'));
        exit();
    }

    /**
     *
     * Add/Remove user from role
     *
     * @param
     *            $username
     * @param
     *            $role
     */
    function MarkUserRole ($username, $role)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('user_id', $username);
        $dbObj->where('role', $role);
        $dbQuery = $dbObj->get('user_roles');
        if ($dbQuery->num_rows() > 0) {
            $dbObj->where('id', $dbQuery->row()->id);
            $dbObj->delete('user_roles');
            return FALSE;
        }
        $dbObj->set('user_id', $username);
        $dbObj->set('role', $role);
        $dbObj->insert('user_roles');
        return TRUE;
    }

    function IsUserInRole ($username, $role)
    {
        if (empty($role)) {
            debug_print_backtrace();
            return;
        }
        if (empty($username)) {
            // test myself
            if (! User::IsAuthenticated()) {
                return FALSE;
            }
            $username = $_SESSION["XJTELEDH_USERNAME"];
        }
        if (isset(User::$userRole[$username . "_" . $role])) {
            return User::$userRole[$username . "_" . $role];
        }
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('role', $role);
        $dbObj->where('user_id', $username);
        $dbQuery = $dbObj->get('user_roles');
        
        User::$userRole[$username . "_" . $role] = ($dbQuery->num_rows() > 0);
        return User::$userRole[$username . "_" . $role];
    }

    /**
     * Is User logged in
     *
     * @return bool
     */
    function IsAuthenticated ()
    {
        
        if (isset($_SESSION["XJTELEDH_USERNAME"])) {
            // for performance reason
            return true;
        } else {
            $ci = &get_instance();
            // test if cookie exists
            $ci->load->helper("cookie");
            $username = get_cookie("XJTELEDH_USERNAME");
            if (! empty($username)) {
                $user = User::GetUser($username);
                if ($user) {
                    if (! strcmp(get_cookie("XJTELEDH_HASH"), md5($username . $user->password))) {
                        $_SESSION["XJTELEDH_USERNAME"] = $username;
                        $_SESSION["XJTELEDH_USERID"] = $user->id;
                        $_SESSION['XJTELEDH_USERROLE'] = $user->user_role;
                        $_SESSION["XJTELEDH_HASH"] = md5($username . $user->password);
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Validate User
     *
     * @param string $userName            
     * @param string $pwd            
     * @param
     *            string(Is pwd in md5 format) $isMd5
     * @return -1,user not exists; -2, user expire. -3, password incorrect, 1 passed
     */
    function ValidUser ($userName, $password, $isMd5 = false)
    {
        $user = User::GetUser($userName, true);
        
        if (! $user) {
            return - 1;
        }
        if (! $user->is_active) {
            return - 2;
        }
        if (! $isMd5) {
            $password = md5($password);
        }
        
        if($user->user_role == "door_user"){
        	return -4;
        }
        
        if (! strcasecmp($user->password, $password)) {
            return 1;
        } else {
            return - 3;
        }
    }

    /**
     * LogIn user, if success, user is kept logged in.
     *
     * @param username $username            
     * @param string $password            
     * @param string $isMd5            
     * @return bool
     */
    function LogInUser ($username, $password, $isMd5 = false, $isRememberMe = false)
    {
        if (1 == User::ValidUser($username, $password, $isMd5)) {
            $user = User::GetUser($username);
            return User::LogInUserObj($user, $isRememberMe);
        }
        return false;
    }

    function LogInUserObj ($user, $isRememberMe = false)
    {
        $username = $user->username;
        $password = $user->password;
        $hash = md5($username . $password);
        if ($isRememberMe) {
            $ci = &get_instance();
            $ci->load->helper('cookie');
            set_cookie("XJTELEDH_USERNAME", $username, 86400 * 7);
            set_cookie("XJTELEDH_HASH", $hash, 86400 * 7);
        }
        $_SESSION["XJTELEDH_USERID"] = $user->id;
        $_SESSION['XJTELEDH_USERNAME'] = $username;
        $_SESSION['XJTELEDH_USERROLE'] = $user->user_role;
        $_SESSION['XJTELEDH_HASH'] = $hash;
        if($_SESSION['XJTELEDH_USERROLE'] != 'door_user'){
        User::SaveUserLoginLog($user);
        }
        return true;
    }
    function SaveUserLoginLog($user){
        
        $ci = &get_instance();
        $agentObj = $ci->load->library('user_agent');
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->set('user_id', $user->id);
        $dbObj->set('username', $user->username);
        $dbObj->set('full_name',$user->full_name);
        $dbObj->set('time', date('Y-m-d H:i:s',time()));
         $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $ci->input->ip_address();
        $dbObj->set('ip',$ip);
        $agent = $ci->agent->is_mobile('iphone') ? 'iphone' : ($ci->agent->is_mobile('android') ? 'android' : 'pc');
        if($agent == 'pc' && $ci->agent->is_mobile()){
            $agent = 'moblie';  
          }
        $dbObj->set('agent',$agent);
        $dbObj->insert('user_loginlog');
        
    }

    function DeleteUser ($userid)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbObj->where('id', $userid);
        return $dbObj->delete('user');
    }

    function Save ($user)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbObj->where('id', $user->id);
        $dbObj->update('user', $user);
    }

    function LogInUserId ($userid, $isRememberMe = false, &$outScript = '')
    {
        $user = User::GetUser($userid);
        if (! $user) {
            return false;
        }
        User::LogInUserObj($user, $isRememberMe, $outScript);
        return true;
    }

    /**
     * Logout User
     */
    function LogOutUser ()
    {
        $ci = &get_instance();
        $ci->load->helper("cookie");
        unset($_SESSION['XJTELEDH_USERNAME']);
        unset($_SESSION['XJTELEDH_HASH']);
        unset($_SESSION["XJTELEDH_USERID"]);
        session_destroy();
        delete_cookie("XJTELEDH_HASH");
    }

    function Search_User ($word)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbObj->where('user_role', 'member');
        $dbObj->where('is_active', TRUE);
        $dbObj->like('username', $word);
        $dbObj->or_like('full_name', $word);
        $dbObj->or_like('phone', $word);
        $dbObj->or_like('email', $word);
        return $dbObj->get('user')->result();
    }

    function IsEmailAvailable ($email)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        // $dbObj->where('user_role','member');
        $dbObj->where('email', $email);
        return $dbObj->count_all_results('user') == 0;
    }

    function Get_ResetPassword ($user_id)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbQuery = $dbObj->get_where('reset_password', array('user_id' => $user_id));
        if ($dbQuery->num_rows() > 0) {
            return $dbQuery->row();
        }
        return null;
    }

    function Add_ResetPassword ($user_id, $rand)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbObj->set('user_id', $user_id);
        $dbObj->set('rand', $rand);
        $dbObj->set('datetime', 'now()', FALSE);
        return $dbObj->insert('reset_password');
    }

    function Update_ResetPassword ($user_id, $rand)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbObj->where('user_id', $user_id);
        $dbObj->set('rand', $rand);
        $dbObj->set('datetime', 'now()', FALSE);
        return $dbObj->update('reset_password');
    }

    function UpdateAuth ($uid, $pKey, $v)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        $dbObj->where('user_id', $uid);
        $dbObj->where('first_auth', $pKey);
        $dbObj->where('second_auth', $v);
        $mRow = $dbObj->get('user_auth')->row();
        if (count($mRow))
            return $mRow->id;
        $dbObj->set('user_id', $uid);
        $dbObj->set('first_auth', $pKey);
        $dbObj->set('second_auth', $v);
        $dbObj->insert('user_auth');
        return $dbObj->insert_id();
    }

    function GetParent ($pKey)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', TRUE);
        return $dbObj->get_where('user_auth', array('auth_name' => $pKey))->row();
    }

    function Delete_ResetPassword ($user_id)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbObj->where('user_id', $user_id);
        return $dbObj->delete('reset_password');
    }

    function Set_UserActiveStatus ($user_id, $status)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbObj->where('id', $user_id);
        $dbObj->set('is_active', $status == 'active');
        return $dbObj->update('user');
    }

    function Get_UserPrivilege ($user_id)
    {
    	$ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbObj->where('user_id', $user_id);
        return $dbObj->get('user_privilege')->row();
    }
    
    function Get_UserPrivileges ($user_id)
    {
    	$ci = &get_instance();
    	$dbObj = $ci->load->database('default', true);
    	$dbObj->where('user_id', $user_id);
    	return $dbObj->get('user_privilege')->row();
    }

    function Get_UserPrivilegeList ($offset = 0, $size = 0)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbObj->join('user_privilege', 'user.id=user_privilege.user_id');
        $dbObj->join('substation', 'substation.id=user.substation_id');
        $dbObj->select(
                'user_privilege.*,user.full_name,user.user_role,substation.city_code,substation.county_code,substation.name');
        if ($size)
            return $dbObj->get('user', $size, $offset)->result();
        else
            return $dbObj->get('user')->result();
    }

    function Update_UserPrivilege ($user_id, $area_privilege = false, $dev_privilege = false)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbObj->where('user_id', $user_id);
        if ($area_privilege != FALSE)
            $dbObj->set('area_privilege', $area_privilege);
        if ($dev_privilege != FALSE)
            $dbObj->set('dev_privilege', $dev_privilege);
        return $dbObj->update('user_privilege');
    }

    function Save_UserPrivilege ($user_id, $area_privilege, $dev_privilege)
    {
        $ci = &get_instance();
        $dbObj = $ci->load->database('default', true);
        $dbObj->set('user_id', $user_id);
        $dbObj->set('area_privilege', $area_privilege);
        $dbObj->set('dev_privilege', $dev_privilege);
        return $dbObj->insert('user_privilege');
    }

    function Set_UserAppOnline ($user_id)
    {
        User::Set_UserStatusToCache($user_id, 'app');
    }

    function Set_UserWebOnline ($user_id)
    {
        User::Set_UserStatusToCache($user_id, 'web');
    }

    function Set_UserStatusToCache ($user_id, $platform, $expire = 60)
    {
        $CI = & get_instance();
        $CI->load->driver('cache');
        $CI->cache->save('online_user-' . $user_id . '-' . $platform, date('Y-m-d H:i:s'), $expire);
    }

    function Is_UserOnline ($user_id)
    {
        $CI = & get_instance();
        $CI->load->driver('cache');
        $isOnline = FALSE;
        foreach (Defines::$gPlatform as $key => $val) {
            $isOnline |= $CI->cache->get('online_user-' . $user_id . '-' . $key) === TRUE;
        }
        return $isOnline;
    }

    function Get_AllOnlineUser ()
    {
        $CI = & get_instance();
        $dbObj = $CI->load->database('default', TRUE);
        if($_SESSION['XJTELEDH_USERROLE'] == "city_admin"){
        $tempList = $dbObj->where_not_in('user.user_role',array('noc','admin'))->get('user')->result();
        }
        if($_SESSION['XJTELEDH_USERROLE'] == "admin"){
        $tempList = $dbObj->get('user')->result();
        }
        $CI->load->driver('cache');

        $userList = array();
        foreach ($tempList as $userObj) {
            $isOnline = FALSE;
            foreach (Defines::$gPlatform as $key => $val) {
                $dCache = $CI->cache->get('online_user-' . $userObj->id . '-' . $key);
                if ($dCache !== FALSE) {
                    $isOnline = TRUE;
                    $userObj->$key = $dCache;
                } else {
                    $isOnline |= $dCache;
                    $userObj->$key = FALSE;
                }
            }
            if ($isOnline) {
                array_push($userList, $userObj);
            }
        }
        return $userList;
    }
    
    function IsUserHasFirst($userid, $permission)
    {
        $CI = & get_instance();
        $dbObj = $CI->load->database('default', TRUE);
        $dbObj->where('first_auth', $permission);
        $dbObj->where('user_id', $userid);
        return $dbObj->count_all_results('user_auth');
    }
    function IsUserHasPermission($userid, $permission)
    {
        $CI = & get_instance();
        $dbObj = $CI->load->database('default', TRUE);
        $dbObj->where('second_auth', $permission);
        $dbObj->where('user_id', $userid);
        return $dbObj->count_all_results('user_auth');
    }
    function ChangePasswd ($id, $password)
    {
    	$ci = &get_instance();
    	$dbObj = $ci->load->database('default', TRUE);
    	$dbObj->where('id', $id);
    	if ($password)
    		$dbObj->set('password', md5($password));
    	return $dbObj->update('user');
    }
  

    
    
    
    
    
    
}

?>
