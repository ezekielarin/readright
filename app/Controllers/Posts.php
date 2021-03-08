<?php 

namespace App\Controllers;

// JWT
use Firebase\JWT\JWT;

// class Auht
use App\Controllers\Auth;

// class Auht
use Controllers\API\responseTrait;

// class Auht
use App\Models\Post_model;

//  restful api codeigniter 4
use CodeIgniter\RESTful\ResourceController;

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



class Posts extends ResourceController
{
	public function __construct()
	{
        // class Auth dengan $this->protect
		$this->protect = new Auth();
		$this->pst = new Post_model();
	}


    public function list()
    {
    	//echo "hello";
    	
    	$id = $this->request->getVar('id');
		
			if(!empty($id)){

				$dat = $this->pst->get_posts($id);
			}else{
				$dat = $this->pst->get_posts();
			}
	
		//$data['output'] = $dat;
		return $this->respond($dat->getResultArray());
		

    }



	public function index()
	{


		$secret_key = $this->protect->privateKey();
		$token = null;
		$authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
		$arr = explode(" ", $authHeader);
		$token = $arr[1];

		$id = $this->request->getVar('id');

			if(!empty($id)){
				$dat = $this->pst->get_posts($id);
			}else{
				$dat = $this->pst->get_posts();
			}

	
		$data = $dat->getResultArray();
		// print_r($data);
		// print_r($token);
		// print_r($secret_key);
		 print_r($authHeader);
		
		if($token){
			//print_r($token);
			try {

				$decoded = JWT::decode($token, $secret_key, array('HS256'));
				// Access is granted. Add code of the operation here
				if($decoded){
                    // response true
					$output = [
					'message' => 'Access granted',
					'data'=>$data
					];
					return $this->respond($output, 200);
				}
				
			} catch (\Exception $e){

				$output = [
				'message' => 'Access denied',
				"error" => $e->getMessage()
				];

				return $this->respond($output, 401);
			}
		}
	}
	
}
