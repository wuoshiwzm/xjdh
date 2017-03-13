<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Oauth2 extends CI_Controller
{

    var $authserver;

    public function __construct ()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With");
        header("Access-Control-Request-Method: GET,POST,PUT,DELETE");
        header('Content-Type: application/json');
        header('Access-Control-Allow-Headers: Authorization');
        parent::__construct();
        $postParams = json_decode(file_get_contents('php://input'));
        if (count($postParams)) {
            foreach ($postParams as $key => $val) {
                $_POST[$key] = $val;
            }
        }
        // Initiate the request handler which deals with $_GET, $_POST, etc
        $request = new League\OAuth2\Server\Util\Request();
        
        require "application/config/database.php";
        // Initiate a new database connection
        $conn_str = 'mysql://' . $db['default']['username'] . ":" . $db['default']['password'] . '@' . $db['default']['hostname'] . '/' .
                 $db['default']['database'];
        $db = new League\OAuth2\Server\Storage\PDO\Db($conn_str);
        $this->authserver = new League\OAuth2\Server\Authorization(new League\OAuth2\Server\Storage\PDO\Client($db), 
                new League\OAuth2\Server\Storage\PDO\Session($db), new League\OAuth2\Server\Storage\PDO\Scope($db));
        // Enable the authorization code grant type
        $this->authserver->addGrantType(new League\OAuth2\Server\Grant\AuthCode($this->authserver));
        $this->authserver->addGrantType(new League\OAuth2\Server\Grant\RefreshToken($this->authserver));
    }

    public function token ()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With");
        header("Access-Control-Request-Method: GET,POST");
        header('Content-Type: application/json');
        try {
            
            // Tell the auth server to issue an access token
            $response = $this->authserver->issueAccessToken();
        } catch (League\OAuth2\Server\Exception\ClientException $e) {
            
            // Throw an exception because there was a problem with the client's request
            $response = array('error' => $this->authserver->getExceptionType($e->getCode()),'error_description' => $e->getMessage());
            // var_dump($this->authserver->getExceptionHttpHeaders($this->authserver->getExceptionType($e->getCode())));
            // Set the correct header
            $headers = $this->authserver->getExceptionHttpHeaders($this->authserver->getExceptionType($e->getCode()));
            foreach ($headers as $headStr) {
                header($headStr);
            }
        } catch (Exception $e) {
            
            // Throw an error when a non-library specific exception has been thrown
            $response = array('error' => 'undefined_error','error_description' => $e->getMessage());
        }
        echo json_encode($response);
    }
    /**
     * Use for application to login directly
     */
    public function authenticate ()

    {
//        $jsonRet = array();
//        $jsonRet['ret'] = 1;
//        $jsonRet['error'] = json_encode($this->input->post());
//        $jsonRet['response'] = '';
//        echo json_encode($jsonRet);
//        return;

        // Do validation of App and user's login
        $this->load->library("form_validation");
        $this->form_validation->set_rules('client_id', 'client_id', 'required');
        $this->form_validation->set_rules('client_secret', 'client_secret', 'required');
        $this->form_validation->set_rules('redirect_uri', 'redirect_uri', 'required');
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        
        $_POST['response_type'] = "code";
        $_POST['grant_type'] = 'authorization_code';
        $_POST['scope'] = "";
        if($this->input->post('mobile')){
        	$mobile = $this->input->post('mobile');
        	$username = $mobile;
            $key = substr($this->input->post('mobile'), 7);
            $password = $key.date('Y-m-d H:i:s',time());            
            $user = User::GetUserByMobile($mobile);
            	if(!$user){
            		//$userId = User::CreateUser($username, $password, $userRole = 'admin', $full_name = '管理员', $gender = 'male', $mobile, $email = '',
            		//		$info = '', $substation_id = 0, $isActive = 1 , $accessId = '');
            	}else{
            		$userId = User::UpdateUserPasswd($user->id,$password);
            	}
            if($userId){
            	$user = User::GetUserById($userId->id);
            	$jsonRet = array();
            	$jsonRet['ret'] = 0;
            	$jsonRet['mobile'] = $mobile;
            	$jsonRet['response'] = $password;
            	echo json_encode($jsonRet);
            	return;
            }
            $jsonRet = array();
            $jsonRet['ret'] = 1;
            $jsonRet['error'] = "incorrect user login info";
            $jsonRet['response'] = '';
            echo json_encode($jsonRet);
            return;
        }
        if ($this->form_validation->run()) {
            try {
                // Tell the auth server to check the required parameters are in the
                // query string
//var_dump($_POST);die;
               $params = $this->authserver->getGrantType('authorization_code')
                   ->checkAuthoriseParams($_POST);
            } catch (Oauth2\Exception\ClientException $e) {
                // Throw an error here which says what the problem is with the
                // auth params
                $jsonRet = array();
                $jsonRet['ret'] = 1;
                $jsonRet['error'] = "incorrect app login info";
                $jsonRet['response'] = '';
                echo json_encode($jsonRet);
                return;
            } catch (Exception $e) { 
                // Throw an error here which has caught a non-library specific error
                $jsonRet = array();
                $jsonRet['ret'] = 6;
                $jsonRet['error'] = "Server internal error";
                $jsonRet['response'] = '';
                echo json_encode($jsonRet);
                return;
            }
            // Validate User Info
            if (1 != User::ValidUser($this->input->post('user_id'), $this->input->post('password'), true)) {
                $jsonRet = array();
                $jsonRet['ret'] = 2;
                $jsonRet['error'] = "incorrect user login info";
                $jsonRet['response'] = '';
                echo json_encode($jsonRet);
                return;
            }
            // validation pass, now issue the access token



            $user = User::GetUser($this->input->post('user_id'));

//            $jsonRet = array();
//            $jsonRet['ret'] = 1;
//            $jsonRet['error'] = json_encode($user);
//            $jsonRet['response'] = '';
//            echo json_encode($jsonRet);
//            return;

            $userid = $user->id;
            $_POST['scopes'] = array();
            $_POST['code'] = $this->authserver->getGrantType('authorization_code')
                ->newAuthoriseRequest('user', $userid, $_POST);
            $accessToken = $this->authserver->issueAccessToken($_POST);
            $response['ret'] = 0;
            $response['error'] = '';
            $response['response'] = json_encode($accessToken);
            echo json_encode($response);
            return;
        } else {
            $jsonRet = array();
            $jsonRet['ret'] = 3;
            $jsonRet['error'] = validation_errors();
            $jsonRet['response'] = '';
            echo json_encode($jsonRet);
        }
    }
}
