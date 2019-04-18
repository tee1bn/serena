<?php

/**
* This is where all miscellaneous operational functions is done
*/
class MIS 
{
	

	public static function get_filter_here()
	{
		$filter_name = self::get_filter_name();
		
		if (! isset($_SESSION['filters'][$filter_name])) {
			return false;
		}

		$filter  = $_SESSION['filters'][$filter_name];

		return $filter;
	}	


	public static function set_filter_name($redirect)
	{
		
		$explode  =	explode("/", $redirect);
		$filter_name = "{$explode[0]}_{$explode[1]}";

		return $filter_name;
	}	


	public static function get_filter_name()
	{
		$explode  =	explode("/", $_GET['url']);
		$filter_name = "{$explode[0]}_{$explode[1]}";

		return $filter_name;
	}	



	public static function use_filter($filter_name, $action, $filters=null)
	{	
		$domain = Config::domain();

		$modal = <<<EOL
		 		<a href="javascript:void;"  data-toggle="modal" data-target="#customise_report" class="btn btn-primary" >
								  <i class="fa fa-cog"></i> Customise Report
								</a>


  					<div id="customise_report" class="modal fade " style="display: ;" role="dialog">
						<div class="modal-dialog">

						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Customise Report</h4>
						      </div>
						      <div class="modal-body">
						      	<form method="post" id="customise_report"
						      	 action="$domain/home/set_filters">  
						      		<input type="hidden" name="redirect" value="$action">
						      		<div class="form-group">
						      			<label>From</label>
						      			<input type="date" value="<?=$from;?>" name="from" class="form-control"> 
						      			<label>To</label>
						      			<input type="date" name="to" value="<?=$to;?>" class="form-control"> 
						      		</div>


						      		<div class="form-group">
						      			<label>Per Page</label>
						      			<input type="number" value="<?=$per_page;?>" name="per_page" class="form-control"> 
						      			
						      		</div>


								      <div class="modal-footer">
								        <button type="submit" class="btn btn-danger" >Submit</button>
								        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								      </div>
						      	</form>
							  </div>
						  	</div>
						</div>
					</div>

EOL;

	return $modal ;
	}

	
	public static function verify_google_captcha()
	{
		 	$settings = SiteSettings::site_settings();		 	
			$post_data =  [
							'secret'=> $settings['google_re_captcha_secret_key'],
							'response'=> $_POST['g-recaptcha-response'],
						];
    			$response = self::make_post("https://www.google.com/recaptcha/api/siteverify", $post_data);


			$csrf =  (json_decode($response, true));
					
			if(($csrf['success'] != 1) || ($csrf['hostname'] != $_SERVER['HTTP_HOST'])){
			    Session::putFlash('warning', "Please solve the captcha");
			    Redirect::back();
			}

	}


	public static function make_post($url, $post_data)
	{


		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "$url");
		curl_setopt($ch, CURLOPT_POST, 1);
	
		// In real life you should use something like:
		curl_setopt($ch, CURLOPT_POSTFIELDS, 
		         http_build_query($post_data));

		// Receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);

		curl_close ($ch);

		return $server_output;


 
	}


}