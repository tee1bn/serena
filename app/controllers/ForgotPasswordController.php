<?php


/**



*/
class ForgotPasswordController extends controller
{
	public $user_email;


	public function __construct(){
		ob_start();
	}
	
	public function index()
	{
		
	
		$this->view('guest/forgot-password');  
	}




public function confirm_password_reset($reset_token)
{

	 $password_reset =  PasswordResets::where('token', $reset_token)->first();
	 $five_mins_ago = time()  -  (20*60);

	 $time_token_was_created = strtotime($password_reset->updated_at);



	if (($password_reset ==null) || ( $five_mins_ago > $time_token_was_created)) {

	Session::putFlash('Info', "Password reset Link expired or invalid, pls try again!");
	$this->redirect()->to($this->domain.'/forgot-password')->go();

	}

	 $this->user_email  = $password_reset->email ;


	$this->reset_password();

}


protected function reset_password()
{

	$this->view('guest/reset-password-form' ,   ['user_email' => $this->user_email ] );

	Session::put('reset_email', $this->user_email);


}


public function change_password()
{

	echo $password_reset =  PasswordResets::where('email', Input::get('email'))->first();
	echo $five_mins_ago = time()  -  (20*60);

	echo "<br>",$time_token_was_created = strtotime($password_reset->updated_at);

if ( $five_mins_ago > $time_token_was_created) {
	Session::putFlash('Info', "Password reset Link expired or invalid, pls try again!");
	// $this->redirect()->to($this->domain.'/forgot-password')->go();

					$response = array('notification' => "Password reset Link expired or invalid, pls try again!", 'response' => false );

}


echo "scandir(directory)";
	if (Input::exists('reset_password_form')) {

		print_r(Input::all());


	$this->validator()->check(Input::all() , array(

			'new_password' =>[

				'required'=> true,
				'min'=>3
					],

			'confirm_new_password' =>[

				'required'=> true,
				'min'=>3,
				'matches'=>'new_password'
					],
));





 if($this->validator()->passed()){

 		User::where('email',Input::get('email'))->first()->update(['password'=>Input::get('new_password')]);
	Session::putFlash('Info', "Password reset sucessfully!");

	$this->redirect()->to($this->domain.'/login')->go();
	$response = array('notification' => "Password reset suscessful! Pls login", 'response' => true );


}else{
	Session::putFlash('Info', "Password do not match or too short!");

		$response = array('notification' => "Password do not match or too short!", 'response' => false );

}

	}
	$this->redirect()->to($this->domain.'/forgot-password')->go();


}







public function sendresetMail($password_reset)
{



		$reset_link = "$this->domain/forgot-password/confirm_password_reset/$password_reset->token";
		$mailer  	= new Mailer();
		$subject 	= $this->name." PASSWORD  RESET!";

		$body   	= $this->buildView('emails/password-reset', [
															'reset_link' 	=> $reset_link,
																]);

		$to 			= $password_reset->email;
		$recipient_name = '';

 	if($mailer->sendMail($to, $subject, $body, $reply='', $recipient_name)){
 		return true;
 	}else{

 		return false;
 	}

}

public function sendresetLink()
{


	if (Input::exists('forgot_password_send_reset_link')) {



	$this->validator()->check(Input::all() , array(

			'user' =>[

				'required'=> true,
				'exist'=> 'User|email',
					],
		));


 if($this->validator()->passed()){


		$email = Input::get('user');
		$token = md5(uniqid());

		$password_reset  = PasswordResets::where('email', $email)->first();

	if ($password_reset ==null) {
	

 $password_reset  =	PasswordResets::create([
								'email' => $email,
								'token' => $token
							   ]);
	}else{
		$password_reset->update(['token'=>$token]);
	}


$status = 	$this->sendresetMail($password_reset);
if ($status == true) {

	$response = array('notification' => "Reset Email has been sent to your mail.", 'response' => true );
	Session::putFlash('Info', "Reset Email has been sent to your mail.");

}else{

		$response = array('notification' => "Reset Email not sent. Pls try again.", 'response' => false );
	Session::putFlash('Info', "Reset Email could not be sent to your mail.");

}




	}else{

				$response = array('notification' => "Email does not exist.", 'response' => false );

	Session::putFlash('Info', "Email seem not to exist.");

	}

}



	$this->redirect()->to($this->domain.'/forgot-password')->go();


print_r($this->validator()->errors());
}




}























?>