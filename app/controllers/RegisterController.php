<?php
@session_start();
/**



*/
class RegisterController extends controller
{

	public function __construct(){


		}



	public function confirm_email($email, $email_verification_token)
	{

 $user = User::where('email', $email)
			->where('email_verification', $email_verification_token)
			->first();

	if ($user != null) {

	$update = $user->update(['email_verification'=> 1]);

		if ($update) {

			Session::putFlash('Info', 'Email verified successfully');

		}else{

			Session::putFlash('Info', 'Email verification unsuccesfully');

		}

	}




		if($this->auth()){
			
					$this->redirect()->to($this->domain.'/account-dashboard')->go();

		}else{


		$this->redirect()->to($this->domain.'/login')->go();

		}

	}



public function 	confirm_phone()
{


if (Input::exists() ) {

	$this->validator()->check(Input::all() , array(

			'phone_code' =>[

				'required'=> true,
				'exist'=> 'User|phone_verification',
					],
	
				));

}
 if($this->validator->passed()){




	if ($this->auth()->phone_verification == Input::get('phone_code')) {

	$update = $this->auth()->update(['phone_verification'=> 1]);

		if ($update) {

			Session::putFlash('Info', 'Phone verified successfully');

		}else{

			Session::putFlash('Info', 'Phone verification unsuccesful.');

		}





		if($this->auth()){
			
					$this->redirect()->to($this->domain.'/account-dashboard')->go();

		}else{


		$this->redirect()->to($this->domain.'/login')->go();

		}

	}else{

					Session::putFlash('Info', 'Phone verification unsuccesful.');

	}

}
					$this->redirect()->to($this->domain.'/account-dashboard')->go();



	}



public function verify_phone()
{
		$message = "Dear ".$this->auth()->firstname.", your code is ".$this->auth()->phone_verification." from $this->name";
		$phone   =  $this->auth()->phone ;





	return (new	SMS)->send_sms($phone, $message);


}

public function verify_email()
{

	ob_start();

$user =  User::where('email', $email)->first();
$name =  $user->firstname;

$subject 	= 'Email Verification';
$body 		= $this->buildView('emails/email-verification', [
																'name' => $name,
																'email' => $email,
																'email_verification_token' => $email_verification_token,
																]);


$to 		= $email;

$email_verification_token = $this->auth()->email_verification ;
$email = $this->auth()->email ;




$link = 'Thank you for signing up at '.$this->name.', \n please click this link to continue '.$this->domain.'/register/confirm_email/'.$email.'/'.$email_verification_token.'';

$status =  mail($email, $subject, $link);




	$response =   (! $status) ? 'false' : 'true';

// ob_end_clean();

echo $response;

}




public function generate_phone_code_for($user_id)
{

 	$remaining_code_length =   6 -	strlen($user_id) ;
 	$min = pow(10, ($remaining_code_length-1));
 	$max = pow(10, ($remaining_code_length)) - 1;
 	
 	$remaining_code = random_int($min, $max);

 	return  $phone_code = $user_id.$remaining_code;


}



	
	public function index()
	{
		
	if($this->auth()){

		// $this->redirect()->to($this->domain.'/account-dashboard')->go();

	}

	$this->view('guest/register', []);


	}

public function where_to_place_new_user_introduced_by($introducer_user_id)
{


$MLM_SETTINGS = MlmMatrixSettings::first();
$mlm_width 		= $MLM_SETTINGS->width ;
$referrer_user 	= User::find($introducer_user_id);
$preferred_leg 	= max(($referrer_user->preferred_leg_to_build - 1), 0 );
 
// during registratio
$i = 1;

do {
/*
echo "<br>iteration $i<br>";
echo "user $referrer_user->id<br>";*/
$value = $referrer_user->id ;
//check if referral still has room in direct line else consider next downline to put new user in referral weaker leg

/*echo*/ $referral_width =  count($referrer_direct_line = $referrer_user->referred_members_downlines(1)[1]);

if (($referral_width < $mlm_width) && ($i == 1)) {//if actual referral still has space
/*echo*/ "<br>iteration $i notfull";
break;
}






$referrer_user = User::find($referrer_direct_line[$preferred_leg]['id']);
$i++;
} while ($referrer_user != null);


/*
// echo $referrer_user.'<br>' ;
echo "user will be under $value <br><br>";

echo $referrer_user->id;
print_r($referrer_direct_line[$preferred_leg]);
*/



return $value ;





}


	public function register()
	{


if (Input::exists('user_registration') ) {

	$this->validator()->check(Input::all() , array(

			'username' =>[

				'required'=> true,
				'unique'=> 'User',
					],

			'firstname' =>[

				'required'=> true,
				'min'=> 2,
				'max'=> 20,
					],
	'lastname' =>[

				'required'=> true,
				'min'=> 2,
				'max'=> 20,
					],

		'referral' => [
						'required'=> true,
						'exist'=> 'User|username',
						'not match'=> 'username',
					],
		
		'email' => [

						'required'=> true,
						'email'=> true,
						'unique'=> 'User',
					],
		
	/*	'phone' => [

						'required'=> true,
						'min'=> 6,
						'max'=> 20,
						'unique'=> 'User',
					],*/
		
		'password' => [

								'required'=> true,
								'min'=> 3,
								'max'=> 32,
						],

	'confirm_password' =>[

								'required'=> true,
								'matches'=> 'password',
						],


	'agreement' =>[

								'required'=> true,
						],




		));

 if($this->validator->passed()){



if (!isset($_GET['ref'])) {	
echo $referral = "?ref=".$_GET['ref']."";
}


//create username
 	// $username = explode('@', Input::get('email'))[0];


 	$email_verification_token =  md5(uniqid()) ;



//check if referral bonus is turned on by admin
   if ($this->system_settings->referral_bonus_allocation ===1) {
   }


   $referred_by = User::where('username', Input::get('referral'))->first()->id;



   //phone inputs processing

    $phoneTel = Input::get('phone');
        //the Intl dialing code
        $dialCode = preg_replace('#[^0-9.]#', '', Input::get('dialCode'));
        //Mobile number plus Intl dialing code
        $phonefull = Input::get('phonefull');
        //Check if it has 0 in front (eg: 080********)
        $firt = substr($phoneTel,0,1);
        if($firt == "0") {
         $phne = preg_replace("/^".$firt."/", "", $phoneTel);
        }else{
          $phne = $phoneTel;
        }

        $phne2 = preg_replace("/^".$dialCode."/", "", $phne);
        $phone = preg_replace('#[^0-9.]#', '', $dialCode.$phne2);

     


echo $placed_under = $this->where_to_place_new_user_introduced_by($referred_by);
   //phone inputs processing ends
// exit();
	$country  =strtolower( Location::location()['geoplugin_countryName'] );


 // echo  Input::get('username');

echo 	$user  =  User::create([
 				'username' 	=> Input::get('username') ,
 				'firstname' 	=> Input::get('firstname') ,
 				'lastname' 		=> Input::get('lastname') ,
 				'introduced_by' => $referred_by,
 				'referred_by' 	=>  $placed_under,
 				'email' 		=> Input::get('email') ,
 				'country' 		=> $country ,
 				'phone' 		=> $phone ,
 				'email_verification' => $email_verification_token,
 				'password' 		=> Input::get('password') ,
  				]);




 echo	$updated_user =  $user->update(['phone_verification' => $this->generate_phone_code_for($user->id) ]);



 	if($user){

 /*	if($this->authenticate_with($user->email, $reg_password)){


 	}*/

	// $this->give_refferal_credibity_score($user);


 		$reg_password = Input::get('password') ;
 		$this->sendWelcomeEmail($user->id, $reg_password);

 	}
 		Session::putFlash('Info', "Registration Successful! Please login.");
 		$this->redirect()->to($this->domain.'/login')->go();
 }else{

 	Session::putFlash('Info', "Please try again ".Input::get('firstname'));

// print_r($this->validator->errors());


$country  =strtolower( Location::location()['geoplugin_countryName'] );






       













 }

		
		
				// $this->view('user/register', []);


	}


 	
	$this->redirect()->to($this->domain.'/register'.$referral)->go();


}




public function give_refferal_credibity_score($user)
{	
	CommisionsDueFromReferrals::create([
											'downline_user_id' 	 		=> $user->id,
											'transaction_amount' 		=> 200,
											'activity_id' 				=> 2,
											'referral_matrix_attribute' => 'referral_bonus_at_registration',
											'status' => 0,
										]);
}


public function sendWelcomeEmail($user_id , $password)
{


 $new_user= User::find($user_id);


		$mailer  = new Mailer();
		$subject = $this->name." SUCCESSFUL REGISTRATION!!";

		$body    = $this->buildView('emails/registration-welcome-mail', [
															'firstname' => $new_user->firstname,
															'user_id' 	=> $new_user->username,
															'password' 	=> $password,
																]);

		$to = $new_user->email;
		$recipient_name = $new_user->firstname;

 	if($mailer->sendMail($to, $subject, $body, $reply='', $recipient_name)){
 		return true;
 	}



 }

}




















?>