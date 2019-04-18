<?php
@session_start();

/**



*/
class home extends controller
{



	public function __construct(){

	}


	public function message()
	{

echo "<pre>";
print_r($_SESSION);
print_r($_POST);



if (Input::exists('contact') ) {
	$this->validator()->check(Input::all() , array(

		
			'name' =>[

				'required'=> true,
				'min'=> 3,
				'max'=> 32,
					],
	'email' =>[

				'required'=> true,
				'email'=> true,
				'max'=> 52,
					],

	'message' =>[

				'required'=> true,
				'min'=> 5,
					],




		));

 if($this->validator->passed()){



echo "string";


$to = "booking@carat24hotelsng.com";
// $to = "tee02bn@gmail.com";
$from = "$name, $email ";
$message = "$from  ".$_POST['message'];


// Always set content-type when sending HTML email
/*$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
*/
// More headers
$headers .= 'From: <'.$_POST["email"].'>' . "\r\n";
// $headers .= 'Cc: myboss@example.com' . "\r\n";

mail($to,'New Message',$message,$headers);




 	Session::putFlash('Info', '<div id="sendmessage" style="display: block;">Your message has been sent. Thank you!</div>');




 }else{

print_r($this->validator->errors());
 	Session::putFlash('Info', '<div id="errormessage" style="display: block;">Could not send message. Please try again </div> ');


 }

		
		


	}


	$this->redirect()->to($this->domain.'/contact-at-carat-24-hotels-and-suites-ijesha-lagos-nigeria')->go();
	
	}



	public function index()
	{ 
	$this->view('carat24hotels/index' , ['header' => 'kll']);



	}



}























?>