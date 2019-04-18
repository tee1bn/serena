<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class SiteSettings extends Eloquent 
{
	
	protected $fillable = ['criteria',	'settings'];
	
	protected $table = 'site_settings';



	public static function site_settings()
	{
		$settings = json_decode(self::where('criteria', 'site_settings')->first()->settings, true);
		return $settings;

	}





	public static function company_account_details()
	{
		$settings = json_decode(self::where('criteria', 'admin_bank_details')->first()->settings, true);
		return $settings;

	}



	public static function paystack_keys()
	{
		$settings = json_decode(self::where('criteria', 'paystack_keys')->first()->settings, true);
		return $settings;

	}



	public static function sms_api_keys()
	{
		$settings = json_decode(self::where('criteria', 'sms_api_keys')->first()->settings, true);
		return $settings;

	}






	public function getsettingsAttribute($value)
    {
        return json_encode( json_decode($value ,true));
    }








}
?>
