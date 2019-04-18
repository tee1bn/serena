<?php
@session_start();

// use Illuminate\Database\Eloquent\Model as Eloquent;

class current_user extends controller
{
	

	public function __construct(){

				$this->setting = SiteSettings::site_settings();
	}
	
	
	public function must_have_verified_email()
	{

		if (($this->setting['email_verification'] == 1) && ($this->auth()->email_verification != 1)) {

			Redirect::to('verify/email');
		}

		return $this;

	}

	public function must_have_verified_phone()
	{

		if (($this->setting['phone_verification'] == 1) && ($this->auth()->phone_verification != 1)) {

			Redirect::to('verify/phone');
		}

		return $this;

	}
	
	

	public function must_have_no_letter_of_happiness_to_write()
	{


			$letter_of_happiness_to_write = $this->auth()->has_letter_of_happiness_to_write();
		if (($letter_of_happiness_to_write) && ($this->setting['is_letter_of_hapiness_compulsory'] == 1)) {

			Session::putFlash("warning", "You have $letter_of_happiness_to_write letters of happiness to write");
			Redirect::to('verify/write_letter_of_happiness');
		}

		return $this;

	}
	
	


	public function mustbe_loggedin(){

		if($this->auth()){

		return $this;

		}else{

		Redirect::to('login');
		}

	}







}


















?>