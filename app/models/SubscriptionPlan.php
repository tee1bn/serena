<?php


use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;


class SubscriptionPlan extends Eloquent 
{
	
	protected $fillable = [
							'package_type',
							 'price' ,
							 'hierarchy' ,
							 'given_emails' ,
							 'given_sms' ,
							'features',
							'availability',
							'created_at'
						];
	
	protected $table = 'subscription_plans';



	public static function buyable_with($cost)
	{
		$all_prices =  self::available()->get()->pluck('price')->toArray();
		$all_prices[] = $cost;
		rsort($all_prices);
		$price = $all_prices[1];

		return self::where('price', $price)->where('availability', on)->first();


	}



	public static function create_subscription_request($subscription_id, $user_id)
	{	


			$month = date('m');


		DB::beginTransaction();

		try {


			$has_existing_request = SubscriptionOrder::where('user_id', $user_id)
												->whereMonth('created_at', $month )
												->where('plan_id', $subscription_id)
												->get();

			$user  			= User::find($user_id);
			$previous_sub 	= self::find($user->account_plan);
			$new_sub 		= self::find($subscription_id);
			$cost 			= ($new_sub->price - (int)$previous_sub->price);


					//ensure this is not downgrade
				if ($new_sub->hierarchy  < $previous_sub->hierarchy  ) {
					Session::putFlash('danger', 
						"You cannot downgrade your subscription to {$new_sub->package_type}.");
					throw new Exception("Error Processing Request", 1);
				}

					//ensure no request is existing for the month
					//ie one subscription per calendar month
				if ($has_existing_request != null) {
						$month = date('F');
						Session::putFlash('danger', 
							"You already have a request on {$new_sub->package_type}");
						throw new Exception("Error Processing Request", 1);
				}


			//if user has enough balance, put on subscription
			if (false) {


			}else{
				//create subscription request
				if (SubscriptionOrder::user_has_pending_order($user_id, $new_sub->id)) {
					Session::putFlash('danger', 
						"You have pending order for {$new_sub->package_type}.");
					throw new Exception("Error Processing Request", 1);
				}

				SubscriptionOrder::create_order($subscription_id, $user_id, $cost);
			}

			DB::commit();
				Session::putFlash('success', 
					"Order for {$new_sub->package_type} created successfully.");
			return true;
		} catch (Exception $e) {
			// DB::rollback();
		}

		return false;
	}

	public function is_available()
	{
		return (bool) ($this->availability =='on');
	}



	public function available()
	{
		return self::where('availability', 'on');
	}

	public function getfeatureslistAttribute()
	{
		return explode(',', $this->features);
	}


}


















?>