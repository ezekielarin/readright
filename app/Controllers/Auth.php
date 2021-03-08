<?php namespace App\Controllers;
use Firebase\JWT\JWT;

use App\Models\Auth_model;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;


class Auth extends ResourceController
{
	public function __construct()
	{
		$this->auth = new Auth_model();
		//$this->auth = new Auth_model();
	}

	public function privateKey()
	{
		$privateKey = '834r9h34eroiefWJOidfaoijefoaod';
		return $privateKey;
	}

	public function register()
	{

		// $firstname 	= $this->request->getPost('first_name');
		// $lastname 	= $this->request->getPost('last_name');
		// $email 		= $this->request->getPost('email');
		// $password 	= $this->request->getPost('password');

		$firstname 	= 'ezekiel';
		$lastname 	= 'arin';
		$email 		= 'ezekielarin@gmail.com';
		$password 	= 'password';

		$password_hash = password_hash($password, PASSWORD_BCRYPT);

		$data = json_decode(file_get_contents("php://input"));

		$dataRegister = [
		'first_name' => $firstname,
		'last_name' => $lastname,
		'email' => $email,
		'password' => $password_hash
		];

		$register = $this->auth->register($dataRegister);

		if($register == true){
			$output = [
			'status' => 200,
			'ag' => $firstname,
			'lag' => $lastname,
			'message' => 'successfully register'
			];
			return $this->respond($output, 200);
		} else {
			$output = [
			'status' => 400,
			'message' => 'Failed register'
			];
			return $this->respond($output, 400);
		}
	}

	public function login()
	{
		// $email 		= $this->request->getPost('email');
		// $password 	= $this->request->getPost('password');

		 $email 	= 'ezekielarin@gmail.com';
		 $password 	= 'password';

		$cek_login = $this->auth->cek_login($email);

		
		if(password_verify($password, $cek_login['password']))
		{
			$key = 'weiwo3489yh9Yh98h9h9g87g7g8g8yh';
			$issuer_claim = "http://localhost/readright"; // this can be the servername. Example: https://domain.com
			$audience_claim = "http://localhost/readright";
			$issuedat_claim = time(); // issued at
			$notbefore_claim = $issuedat_claim + 10; //not before in seconds
			$expire_claim = $issuedat_claim + 3600; // expire time in seconds
			
            $token = array(
				"iss" => $issuer_claim,
				"aud" => $audience_claim,
				"iat" => $issuedat_claim,
				"nbf" => $notbefore_claim,
				"exp" => $expire_claim,
				"data" => array(
					"id" => $cek_login['id'],
					"firstname" => $cek_login['first_name'],
					"lastname" => $cek_login['last_name'],
					"email" => $cek_login['email']
					)
				);
          //  print_r($token);

			//$jwt = new Firebase\JWT\JWT;
			//$jwt::$leeway = 60;

			/*$client = new Google_Client(['client_id' => $CLIENT_ID]);
			$payload = $client->verifyIdToken($id_token);*/	

			$token = JWT::encode($token, $key);

			$output = [
			'status' => 200,
			'message' => 'successfully login',
			"token" => $token,
			"email" => $email,
			"expireAt" => $expire_claim
			];
			//print_r($output);
			return $this->respond($output, 200);
		} else {
			$output = [
			'status' => 401,
			'message' => 'Login failed',
			"password" => $password
			];
			return $this->respond($output, 401);
		}

	}

	public function logoutUser()
	{
		

	}

	public function get_all()
	{
		$users = $this->auth->get_all();
		if ($users) {
			
			return $this->respond($users, 200);
		} else {
			$output = [
			'status' => 401,
			'message' => 'Login failed',
			"password" => $password
			];
			return $this->respond($output, 401);
		}
	}

}
