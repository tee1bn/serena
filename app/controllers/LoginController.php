<?php
@session_start();
/**



*/
class LoginController extends controller
{

	public function __construct(){
	      // print_r($_SESSION);
	}


	public function resendotp()
	{

	echo $user = User::where('email', Session::get('ab_email'))->first();
		$password = Session::get('ab_p');
		$this->doLoginOTP($user , $password);
	}

	public function submitOTP()
	{	
		

		if (Token::evaluateOTPattempt() > 2) {

					$this->redirect()->to($this->domain.'/login')->go();
		}

		if (Input::exists("otp_form")) {

			/*echo' <pre>';
			print_r(Input::all());
			print_r($_SESSION);*/

			if(Token::requestOTP() == Input::get('password') ) {

				Token::fufillOTP();


		/*echo*/		$result =	$this->authenticate_with(Session::get('ab_email') , Session::get('ab_p'));

					if ($result) {

		Session::putFlash('Info',"Welcome ".$result->firstname);
		$this->redirect()->to($this->domain.'/account-dashboard')->go();
/*
	$response = array('notification' => "Welcome ".$this->auth()->firstname, 'response' => true, 'view'=>$this->buildView('user/speedboosted', ['channel'=>'dashboard']) );
								echo json_encode($response);
*/


				}
			}else{


		Session::putFlash('Info',"Error, please try again ");
		$this->redirect()->to($this->domain.'/login/otp')->go();

			}

		}


	}

	public function otp()
	{

		if(Token::OTPattempt() >= 3){
		$this->redirect()->to($this->domain.'/login')->go();
		}

				/*$response = array('notification' => "Enter OTP sent to your mail.", 'response' => true );
								echo json_encode($response);
*/
		Session::putFlash('Info',"Enter OTP sent to your mail ");

		// $this->view('guest/speedboosted', ['channel'=>'login-otp']);

		$this->view('guest/otp');

	}

	public function adminLogindfghjkioiuy3hj8()
	{
		
	/*if($this->auth() ){
		$this->redirect()->to($this->domain.'/admin-dashboard')->go();
	}*/
	$this->view('admin/login', []);

	}



	// authenticateing admnistrators
	public function authenticateAdmin()
	{

	if(Input::exists('admin_login')){


		$trial = Admin::where('email', Input::get('user'))->first();

		if ($trial == null) {

			$trial = Admin::where('username', Input::get('user'))->first();
		}


		$email = $trial->email;





	$admin = Admin::where('email', $email)->first();
	$password = Input::get('password') ;
 	$hash = $admin->password;
			if(password_verify($password, $hash)){



			Session::put('administrator', $admin->id);

			echo $this->admin();

			Session::putFlash('Info',"Welcome Admin $admin->firstname");
			$this->redirect()->to($this->domain.'/admin-dashboard')->go();

}else{
			Session::putFlash('Info','Could not authenticate, Try again');
			$this->validator()->addError('credentials' , "<i class='fa fa-exclamation-triangle'></i> Invalid Credentials.");

			$this->redirect()->to($this->domain.'/'.Config::admin_url())->go();
}




}




	}


	
	public function index()
	{
	
	if($this->auth()){
		$this->redirect()->to($this->domain."/account-dashboard/index/{$this->auth()->username}")->go();
	}
	$this->view('guest/login', []);
		// $this->view('guest/speedboosted', ['channel'=>'login']);

	}



	//authenticating users
	public function authenticate()
	{
// echo "<pre>";

		if(Input::exists("csrf_login")){

			// print_r(Input::all());
		$trial = User::where('email', Input::get('user'))->first();

		if ($trial == null) {


			$trial = User::where('username', Input::get('user'))->first();
		}

		$email = $trial->email;


		 $result = $this->authenticate_with($email , Input::get('password') );

		if ($result) {

// echo "wole ";

		Session::putFlash('Info',"Welcome ".$result->firstname);
		$this->redirect()->to($this->domain."/account-dashboard/index/{$this->auth()->username}")->go();

		$response = array('notification' => "Welcome ".$result->firstname , 'response' => true );

				}else{

			Session::putFlash('Info','Could not authenticate, Try again');
			$this->validator()->addError('credentials' , "<i class='fa fa-exclamation-triangle'></i> Invalid Credentials.");


				// $response = array('notification' => "Invalid credentials.", 'response' => false );


				}


			}

		Session::putFlash('Info','Could not authenticate, See Inputs.');
		$this->redirect()->to($this->domain.'/login')->go();

/*
					$response = array('notification' => "Could not authenticate, Try again",  'response' => false );

				echo json_encode($response);*/
	}





	public function logout($user=''){

		session_destroy();
		Session::putFlash('Info',"Hope to see you again.");



		if($user == 'admin'){

					$this->redirect()->to($this->domain.'/login/adminLogin')->go();
	
		}



		$this->redirect()->to($this->domain.'/login')->go();

	}


public function tester()
{


		if(Input::exists()){

			print_r(Input::all());

			}
}




}























?>