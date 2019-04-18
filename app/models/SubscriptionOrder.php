<?php



use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;


class SubscriptionOrder extends Eloquent 
{
	
	protected $fillable = [
							'plan_id',
							 'user_id',
							 'payment_proof',
							 'price',
							 'paid_at',
							 'details',
							 'created_at'
							];
	
	protected $table = 'subscription_payment_orders';


	public function getpaystacktotalAttribute()
	{
		return $this->plandetails['price'] * 100;
	}

	

	public function mark_as_paid()
	{	
	
		if ($this->is_paid()) {
			Session::putFlash('info', 'Order Already Marked as completed');
			return false;
		}

		DB::beginTransaction();
		try {

			$this->update(['paid_at' => date("Y-m-d H:i:s")]);
			$this->give_value();

			DB::commit();
			Session::putFlash('success', 'Order marked as completed');
			return true;
		} catch (Exception $e) {
			DB::rollback();
			Session::putFlash('danger', 'Order could not mark as completed');
		}

		return false;
	}


	private function give_value()
	{
		$user = $this->user;
		$user->update(['account_plan' => $this->plan_id ]);



		$this->give_subscriber_upline_commission();
	}


	private function give_subscriber_upline_commission()
	{

		$settings= SiteSettings::site_settings();
		$month 	 = date("F");
		$user 	 = $this->user;
		$upline  = User::find($user->referred_by);
		$amount  = $settings['percent_referral_bonus'] * 0.01 * $this->price;
		$comment = "$month Commission";

		$month_index = date('m');



			// ensure  upliner is qualified for commission
			if (! $upline->is_qualified_for_commission($month_index)) {
				return false;
			}


		$credit  = LevelIncomeReport::credit_user($upline['id'], $amount, $comment , $user->id);
		return $credit;
	}

	public function is_paid()
	{

		return (bool) ($this->paid_at != null);
	}


	public function upload_payment_proof($file)
	{

		$directory 	= 'uploads/images/payment_proof';
		$handle  	= new Upload($file);

		if (explode('/', $handle->file_src_mime)[0] == 'image') {

			$handle->Process($directory);
	 		$original_file  = $directory.'/'.$handle->file_dst_name;

			(new Upload($this->payment_proof))->clean();
			$this->update(['payment_proof' => $original_file]);
		}

	}



	public function getplandetailsAttribute()
	{
		return json_decode($this->details, true);
	}


	public function payment_plan()
	{
		return $this->belongsTo('SubscriptionPlan', 'plan_id');

	}


	public static function user_has_pending_order($user_id, $plan_id)
	{
		return (bool) self::where('user_id', $user_id)
					->where('plan_id', $plan_id)
					->where('paid_at', '=' ,null)->count();
	}

	public static function create_order($plan_id , $user_id, $price, $start_of_next_month=null)
	{
		if ($start_of_next_month == null) {
			$start_of_next_month = date('Y-m-d H:i:s');
		}else{

		}


		$payment_plan = SubscriptionPlan::find($plan_id);
		$new_payment_order = self::create([
								 'plan_id'  	=> $plan_id,
								 'user_id' 		=> $user_id,
								 'price'   		=> $price,
								 'details'		=> json_encode($payment_plan),
								 'created_at'	=> $start_of_next_month
							]);

		return $new_payment_order;
	}


	public function getpaymentstatusAttribute()
	{
		if ($this->paid_at != null) {

			$label = '<span class="badge badge-success">Paid</span>';
		}else{
			$label = '<span class="badge badge-danger">Unpaid</span>';
		}

	return $label;
	}

	public function user()
	{
		return $this->belongsTo('User', 'user_id');

	}




}


















?>