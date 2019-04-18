<?php
/*ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
*/
use Illuminate\Database\Eloquent\Model as Eloquent;
use Carbon\Carbon;



class User extends Eloquent 
{
	
	protected $fillable = [ 
				'mlm_id',
				'referred_by',
				'introduced_by',
				'placement_cut_off',
				'type_of_registration',
				'rejoin_id', //former id
				'rejoin_email',
				'placed',		//determines whether the user has been placed
				'firstname',
				'lastname',
				'username',	
				'account_plan',	
	 			'locked_to_receive',	
				'rank',
				'rank_history',
                'email',
				'email_verification',
				'phone',
				'age',
				'country',
				'worthy_cause_for_donation',
				'phone_verification',
				'bank_name',
				'bank_account_name',
				'bank_account_number',
				'profile_pix',
				'resized_profile_pix',
				'password',
				'lastseen_at',
				'lastlogin_ip',
	 			'blocked_on',

	 ];
	
	protected $table = 'users';
  	protected $dates = [
        'created_at',
        'updated_at',
        'lastseen_at'

    ];
    protected $hidden = ['password'];

    public static $max_level = 4;


    public function accessible_ebooks()
    {

    	return Ebooks::accessible($this->subscription->id)->get();
    }


    //end of the calendar month degrade
    public static function degrade_all_members()
    {
    	$update = self::latest()->update(['account_plan'=> null]);
    	if ($update) {
    		return true;
    	}
    }



    public function getPayoutAttribute($month=null)
    {
    	return  LevelIncomeReport::payout_for_month($this->id, $month);
    }



    public function getPayoutEligibityAttribute($month=null)
    {

    	if ($this->is_qualified_for_commission($month)) {

    		return "<span class='badge badge-success'><i class='fa fa-2x fa-check-circle'></i></span>";
    	}
    		return "<span class='badge badge-danger'><i class='fa fa-2x fa-times'></i></span>";
    }




    public function is_qualified_for_commission($month)
    {

		$settings= SiteSettings::site_settings();
		$payment_day = $this->subscription_payment_date($month, true);

	
		$qualified_day = $settings['active_day_of_the_month'];
		if ($payment_day != null) {

			if ($payment_day <= $qualified_day) {
				return true;
			}

		}
    	
		return false;
    }



    public function subscription_payment_date($month=null , $day_format = false)
    {
    	 $subscription =  $this->subscription_for($month);
    	if ($subscription !=  null) {
    		switch ($day_format) {
    			case true:

    				return date("d" , strtotime(($subscription->paid_at)));

    				break;
    			
    			default:
    				return $subscription->paid_at;
    				break;
    		}
		}


		return false;

    }

    public function subscription_for(int $month = null)
    {
    	if ($month == null) {
    		$month =  date('m');
    	}



    	 $subscription = SubscriptionOrder::where('paid_at', '!=', null)
    					 ->where('user_id', $this->id)
    					 ->whereMonth('created_at', $month)
    					 ->latest()
    					 ->first();  //will be reviewed later

    	return $subscription;

    }


    public function getSubAttribute()
    {

    	if ($this->subscription != null) {
    		return $this->subscription->package_type;
    	}

    	return 'Nil';
    }


    public function subscription()
    {
    	return $this->belongsTo('SubscriptionPlan', 'account_plan');
    }

    public function subscriptions()
    {
    	return $this->hasMany('SubscriptionOrder',  'user_id');
    }


    public function scopeBlockedUsers($query)
    {

    	return $query->where('blocked_on','!=',null);

    }





public static function generate_phone_code_for($user_id)
{

 	$remaining_code_length =   6 -	strlen($user_id) ;
 	$min = pow(10, ($remaining_code_length-1));
 	$max = pow(10, ($remaining_code_length)) - 1;
 	
 	$remaining_code = random_int($min, $max);

 	return  $phone_code = $user_id.$remaining_code;


}






    public function getqualifyStatusAttribute()
    {

             $status = (($this->is_qualified_for_commission(null)) )
              ? "<span type='span' class='badge badge-success'>Active</span>":
               "<span type='span' class='badge badge-danger'>Not Active</span>";

               return $status;
    }


    public function getactiveStatusAttribute()
    {

             $status = (($this->blocked_on == null) )
              ? "<span type='span' class='label label-xs label-success'>Active</span>":
               "<span type='span' class='label label-xs label-danger'>Blocked</span>";

               return $status;
    }


  
    public function getDropSelfLinkAttribute()
    {
    	return  "<a target='_blank' href='{$this->AdminViewUrl}'>{$this->full_name}</a>";
    }


    public function getAdminViewUrlAttribute()
    {
    		$href =  Config::domain()."/admin/user_profile/".$this->id;
    		return $href ;
	  
    }




	public function testimonies()
	{
		return $this->hasMany('Testimonials','user_id');
	}




    public function no_of_rejoin()
    {
    	if ($this->rejoin_id != null) {

	    	return  count(explode("," ,rtrim($this->rejoin_id, ',')));	
    	}else{
    		return 0;
    	}
    }


   
    public function ripe_for_rejoin()
    {
    	$mustbe_on_highest_level = ($this->rank== self::$max_level);
    	$payments_received = Payouts::where('payer_id', $this->id)->where('status','Approved')->count();


    	$must_have_received_all_payments = ($payments_received == 30);

    	return  ($mustbe_on_highest_level && $must_have_received_all_payments);

    }


    public function rejoin()
    {

    	$email 		 = $this->email;
    	$referred_by = User::where_to_place_new_user_within_team_introduced_by($this->id) ;
    	$username 	 = User::generate_username_from_email($email);


		$replicate = $this->replicate();



    	$this->rejoin_email = $this->email; 
    	$this->email = null; 
    	$this->username = null; 

    	print_r($this->toArray());



		$replicate->email = $this->rejoin_email;
		$replicate->referred_by = $referred_by;
		$replicate->introduced_by = $this->id;
		$replicate->rank = null;
		$replicate->rejoin_id = ($this->rejoin_id == null)? $this->id : "{$this->rejoin_id},$this->id";

		$this->save();
		$replicate->save();



		// print_r($replicate->toArray());

		// $newTask->save();
		Session::putFlash('',"Congrats!! You completed the level". self::$max_level." and hence rejoined!");

    }



public function generate_username_from_email($email)
{
 	$username = explode('@', $email)[0];

	$i = 1;
 do{
 	$loop_username = ($i==1)? "$username" :"$username".($i-1);
 	$i++;
 	}while(User::where('username', $loop_username)->get()->isNotEmpty());


	return $loop_username;

 }




	public function which_leg($sponsor_id)
	{

   			 $sponsor = User::find($sponsor_id);
   			 $mlm_width = 2;


		$direct_lines =  ($sponsor->referred_members_downlines(1)[1]);

		for ($leg_index=0; $leg_index < $mlm_width; $leg_index++) { 
			if ($direct_lines[$leg_index] == '') {
				return $leg_index;
			}

		}
	}



	public function replace_any_cutoff_mlm_placement_position($sponsor_id, $substitute_id)
	{
		$placement_sponsor = User::find($sponsor_id);

		$former_downline_mlm_id =  (array_values($placement_sponsor->placement_cut_off))[0]; //mlm_id


		if ($former_downline_mlm_id != '') {




			print_r(array_values($placement_sponsor->placement_cut_off));


			$former_downline = User::where('mlm_id',$former_downline_mlm_id)->first();
			$former_downline_replica = $former_downline->replicate();

			$former_downline->mlm_id = null;
			$former_downline->save();

			$substitute = User::find($substitute_id);
			$substitute->mlm_id=  $former_downline_mlm_id ;

			$substitute->save();
	

			//update cutoff history
			$cutoff_history = $placement_sponsor->placement_cut_off;
	   	    $cutoff_index = array_search($former_downline_mlm_id, $cutoff_history);
			unset($cutoff_history[$cutoff_index]);

			$placement_sponsor->update(['placement_cut_off' => json_encode( $cutoff_history)]);

		}

	}




	public function getplacementcutoffAttribute($value='')
	{
		return json_decode($value, true)	;
	}


	public function prepare_placement_cutoff()
	{

		try{


		 	 $placement_sponsor = User::where('mlm_id' ,$this->referred_by)->where('mlm_id', '!=', null)->first() ;

		 	 if ($placement_sponsor == null) {
		 	 		// Redirect::to('login/logout');
		 	 	}

			$leg_index  =	$placement_sponsor->leg_of_user($this->mlm_id) ;



			 $cutoff_history 		= ($placement_sponsor->placement_cut_off);
			 $cutoff_history[$leg_index] 	= $this->mlm_id;


			 $placement_sponsor->update([
			 						'placement_cut_off' => json_encode($cutoff_history),
			 							]);

		}catch(Exception $e){
			echo "string";
		}

	}


	public function remove_from_mlm_tree()
	{
		$this->prepare_placement_cutoff();
			$this->update([
							'referred_by'	=> null,
							'introduced_by'	=> null,
							]);
	}

	public function block_user()
	{
	
			$this->update([
							'blocked_on'	=> date("Y-m-d H:i:s"),
							]);
	}


    /**
     * [higher_level_leaders for generational bonuses]
     * @return [type] [description]
     */
    public static function higher_level_leaders()
    {
 	$min_rank_to_earn_generational_bonus = json_decode(
						MlmSetting::where('rank_criteria', 'min_rank_to_earn_generational_bonus')->first()->settings, true) ;


    	return	User::where('rank', '>=', $min_rank_to_earn_generational_bonus)->where('blocked_on',null);
    }



    /**
     * [finalise_upline determines the upline to eventuwlly receive funds
     * after checking if original upline e]meets certain criteria else returns the demo 
     * user as the uline
     * @param  [type] $receiver_id   [the orignal upline]
     * @param  [type] $upgrade_level [the level the ugrade fee is for]
     * @return [type]                [description]
     */
    public function finalise_upline($receiver_id, $upgrade_level)
    {
    	return $receiver_id;
    	
    	$original_upline = User::find($receiver_id);
    	$default_upline =  User::where('account_plan', 'demo')->first();


    	$not_locked_to_receive_funds = ($original_upline->locked_to_receive == null);
    	 $not_blocked = ($original_upline->blocked_on == null);
    	$can_receive_level_fund = ($original_upline->rank >= $upgrade_level) ; //based on level
    	$upline_exists_in_mlm_tree  =  ($original_upline->referred_by != null);

    	$expected_no_of_receive = [1=>2,2=>4,3=>8, 4=>16];

    	$has_not_received_fund_in_excess = (Payouts::where('receiver_id', $original_upline->id)
    												->where('upgrade_level', $upgrade_level)
    												->where('status', 'Approved')
    												->count() < $expected_no_of_receive[$upgrade_level]);
   

    	if (
    		$not_blocked &&
    		$not_locked_to_receive_funds &&
    		// $can_receive_level_fund  &&
			$has_not_received_fund_in_excess &&
			$upline_exists_in_mlm_tree
    	) {
    		
    		return $original_upline->id;

    	}

    		return $default_upline->id;

    }

    

/**
 * 
 * @param   $team_leader_id [this determines the
 * placement sponsor of a new user introduced/enrolled by the
 * supplied $team_leader. 
 * the spill over is automatic and even within the downline]
 * the first downline not having complete mlm width is selected
 * @return [int]                 [description]
 */
public static function where_to_place_new_user_within_team_introduced_by($team_leader_id)
{

		$mlm_width 		= 10000000;
		$team_leader 	= User::find($team_leader_id);

		if ($team_leader->mlm_id == '') {
			$team_leader =  User::find(1);
		}



		  	$team_leader_downline_level = 1;
		  do{
		  		$downline_at_level =  $team_leader->referred_members_downlines($team_leader_downline_level)[$team_leader_downline_level];

		  		if ((count($downline_at_level) < $mlm_width) && ($team_leader_downline_level==1)) {
			  		return $team_leader->mlm_id;
			  	}


		  		$downline_at_level_obj   = collect($downline_at_level);
				$max =  ($downline_at_level_obj->max('no_of_direct_line'));
				$min =  ($downline_at_level_obj->min('no_of_direct_line'));
		

		  		foreach ($downline_at_level as $key => $downline) { 
					if ($downline['no_of_direct_line'] == $min) {  //select user with list downline
						$referrer_user = ($downline);
						break;
					}
				}
						// print_r($referrer_user);

				if ($referrer_user['no_of_direct_line'] < $mlm_width) {
					return $referrer_user['mlm_id'];
				}

				$team_leader_downline_level++;
		}while ($referrer_user != null);

}




	public function referral_link()
	{
		$link = Config::domain()."/ref/".$this->username;
		return $link;

	}


	public function matured_mavros_worth()
	{

	  	$matured_mavros  = $this->PhRequests('PH','user_id')->Completed()
	  				->whereDate('matures_at','<' , date("Y-m-d"))
	  				->sum('worth_after_maturity');

	  	return $matured_mavros;

	}




	public function attempted_withdrawals()
	{


	  	return GH::where('user_id', $this->id)->sum('amount');

	}



    /**
     * [available_balance fetches this user available balance]
     * @return [type] [description]
     */
    public function available_balance()
    {

    	$available_balance = LevelIncomeReport::available_balance($this->id);
	  	return $available_balance;
	 }




		/**
		 * [withdrawals fetches this users records of withdrawals]
		 * @return [eloquent query builder]
		 */
	   public function total_withdrawals()
	   {
	  		return LevelIncomeReport::total_withdrawals($this->id);
		}

	   public function withdrawals_history()
	   {
	  		return LevelIncomeReport::withdrawals_history($this->id);
		}


    	/**
    	 * [sum_total_earnings calculates the total earnings of this user]
    	 * @return [int] [description]
    	 */
		  public function sum_total_earnings()
		  {
			  	return LevelIncomeReport::sum_total_earnings($this->id);
		  }


	  /**
	   * [earnings returns records of this users earnings]
	   * @return [query buider] [description]
	   */
	  public function earnings()
	  {
	  	return LevelIncomeReport::earnings($this->id);
	  }





  public function next_rank()
  {

	$next_rank  = intval($this->rank) +1  ;
	if ($next_rank > self::$max_level) {
		$next_rank = self::$max_level;
	}
		return $next_rank;
  }



	public function current_rank()
	{
		if ($this->rank == 0) {
			return 'N/A';
		}
			return $this->rank;

	}






/**
 * [total_placements total numbers of downlines in a user team]
 * @return int [description] placement structure
 */
public function total_placements()
{
	$all_downlines = $this->all_downlines();
	unset($all_downlines[0]);
	foreach ($all_downlines as $level => $downlines) {
		$total[$level] = count($downlines);
	}

	return array_sum($total);
}

/**
 * [total_enrolments total numbers of downlines in a user team]
 * @return int [description] enrolment structure
 */
public function total_enrolments()
{
	$all_downlines = $this->enroler_all_downlines();
	unset($all_downlines[0]);
	foreach ($all_downlines as $level => $downlines) {
		$total[$level] = count($downlines);
	}

	return array_sum($total);
}



/**
 * [users_with_no_placements fetches ids of users who have placments]
 * @return [type] [description]
 */
public static function users_with_enrolments()
{
	$referrals_ids =	User::where('introduced_by', '!=', null)
							->where('introduced_by', '!=', 0)->pluck('introduced_by')->toArray();

	$referrals_ids = array_unique($referrals_ids);

	return $referrals_ids ;
}
    


/**
 * [users_with_no_placements fetches ids of users who have placments]
 * @return [type] [description]
 */
public static function users_with_placements()
{
	$referrals_ids =	User::where('referred_by', '!=', null)
							->where('referred_by', '!=', 0)->pluck('referred_by')->toArray();

	$referrals_ids = array_unique($referrals_ids);

	return $referrals_ids ;
}
    

/**
 * [users_with_no_placements fetches ids of users who have placments]
 * @return [type] [description]
 */
public static function users_with_no_placements()
{
	$users_ids_with_no_placements =	User::whereNotIn('id' ,User::users_with_placements())->pluck('id')->toArray();
	$users_ids_with_no_placements = array_unique($users_ids_with_no_placements);
	return $users_ids_with_no_placements ;
}
    
/**
 * [users_with_no_placements fetches ids of users who have placments]
 * @return [type] [description]
 */
public static function users_with_no_enrolments()
{
	$users_ids_with_no_enrolments =	User::whereNotIn('id' ,User::users_with_enrolments())->pluck('id')->toArray();
	$users_ids_with_no_enrolments = array_unique($users_ids_with_no_enrolments);
	return $users_ids_with_no_enrolments ;
}
    



/**
 * [possible_placement fetches all possible placements for a user in a users team]
 * @param  [type] $enroler_id  [team lead]
 * @param  [type] $downline_id [new team memeber]
 * @return [array]              [ids of users where new memeber can ber placed]
 */
public function possible_placement($enroler_id, $downline_id=null)
{	
	$user =   User::find($enroler_id);
	$placement_tree =$user->all_downlines();
	$downlines_id =  User::where('referred_by', $enroler_id)->get(['id', 'referred_by']);

	$users_with_no_placements = User::users_with_no_placements();


/*
print_r($downlines_id->toArray());
print_r($placement_tree);
print_r($downline_level);*/
// print_r($users_with_no_placements);
	
	print_r(	$user->downline_level_of(11));

		foreach ($users_with_no_placements  as $user_id) {
			$downline_level = $user->downline_level_of($user_id);
			if ($downline_level['present'] == 1) {
				$possible_placement[$downline_level['level']][] = $user_id ;
			}

		}

		ksort($possible_placement);

	return $possible_placement;

}


/**
 * [is_placeable tells whether a user is placeable in the placement structure
 * ]
 * @return boolean 
 */
public function is_placeable()
{	
	$max_duration =	json_decode(MlmSetting::where('rank_criteria', 'placement_duration')->first()->settings, true);
	$one_day = 24 * 60 * 60; 
	$difference = (int)((time() - strtotime($this->created_at) )/ $one_day);
	
	return (bool) ($difference < $max_duration);


}


public function life_rank()
{
	$rank_history = json_decode($this->rank_history , true);
	return (max(array_values($rank_history)));
}

public function getrankhistoryAttribute($value)
    {
        return json_encode( json_decode($value ,true));
    }



	public function getrankAttribute($value)
	    {
	    	if ($value ==0) {
	    		return "Nil";
	    	}
	    	return $value;
	    }






/*the placement structure begins*/

/**
 * [leg_of_user this returns the leg in which the suplied user is on this users team/donwline]
 * @param  string $user_id [the id of the user we want to check in this instance user]
 * @return [int]          [the actual leg not leg index ]
 */
public function leg_of_user($user_mlm_id='')
{
	/**
	 * [$i this is the leg we want to check if the supplied user is in
	 * usually, maximum leg will be equal the width of the matrix]
	 * @var integer
	 */
	$i =1;
	do  { 
	
		//if the supplied user is the direct downline of this instance user in this leg we are in 
			if ($this->user_at_leg($i)->mlm_id == $user_mlm_id) {
				$leg = $i ;
				break;
			}

			//if the supplied user is in downline of this instance user direct downline in this leg
			if($this->user_at_leg($i)->downline_level_of($user_mlm_id)['present']){
				$leg = $i ;
				break;
			}

			$i++;
	}while ($this->user_at_leg($i) != null);//ensure this instance user has started building the leg

	
	// print_r($user_at_leg);

	return ($leg);
}


/**
 * [downline_level_of retruns the downline level of a user in this instance user team]
 * @param  string $user_id [the id of the user we want to check in this instnace user]
 * @return [array]          [description] //placement structure
 */
public function downline_level_of($user_id='')
{

		foreach ($this->all_downlines() as $level => $downline_users) {

					foreach ($downline_users as $user) {

						if ($user_id == $user['id']) {
							$downline_level = $level;
							break(2);
						}
					}

		}


return ['present' =>boolval($downline_level) , 'level'=>$downline_level] ;
	}


/**
 * [all_downlines fetches all the ids of this users doenlines users infinitely
 * @return [array] [with keys as the downline level and values as all the users ids in the level]
 */
public function all_downlines()
{

    $depth_level = 1;
    $downlines_at[0] = ['mlm_id'=> $this->mlm_id , 'referred_by'=> $this->referred_by]; // self is on downline zero
    do {
    foreach ($this->referred_members_downlines($depth_level) as $level=> $downlines) {
        $downlines_at[$level] = $downlines;
    }
    $depth_level++;
    } while (count($this->referred_members_downlines($depth_level)[$depth_level]) != '');


    return ($downlines_at);

}




/**
 * [user_at_leg returns the first user at the leg supplied]
 * @param  [type] $leg 
 * @return [type]      [description]
 */
public function user_at_leg($leg)
{
	$leg--;
 $user_id_at_leg  = $this->referred_members_downlines(1)[1][$leg]['mlm_id'];
 $user_at_leg 	  =	self::where('mlm_id',$user_id_at_leg)->first();
 return $user_at_leg ;
}


/**
 * [number_of_all_downlines_at_leg tells how many users are in this user particular leg]
 * @param  int $leg [ the leg index we wish to check on i.e for leg 1, $leg=0]
 * @return [type]      [description]
 */
protected function number_of_all_downlines_at_leg($leg='')
{

 $user_at_leg 	  =	$this->user_at_leg($leg+1);


 if ($user_at_leg == null) {return 0; }

    $depth_level = 1;
    do {
    foreach ($user_at_leg->referred_members_downlines($depth_level) as $level=> $downlines) {
        $number_of_downlines_at_level[$level] = count($downlines);
    }
    $depth_level++;
    } while (count($user_at_leg->referred_members_downlines($depth_level)[$depth_level]) != '');

    $number_of_all_downlines  =  array_sum($number_of_downlines_at_level);
    return ($number_of_all_downlines + 1);
}



/**
 * [user_legs returns array with key as this user leg and value as number of downlines]
 * @return [array] [description]
 */
public function user_legs()
{
    $leg=0;
	do{
		    $users_leg[($leg+1)] = $this->number_of_all_downlines_at_leg($leg);
		    $leg++;
	}while ($users_leg[($leg)] != 0) ;


return ($users_leg);

}




public function enroller_all_uplines()
{
	$level = 1;
	do{
	$uplines = ( $this->enroler_referred_members_uplines($level));

	$level++;
	}while ( $this->enroler_referred_members_uplines($level)[$level] != '') ;
	return $uplines;
}


/**
 * [referred_members_uplines fetches all this uses uplines up to the level 
 * supplied :placement structure]
 * @param  int $level [description]
 * @return [type]        [description]
 */
public function referred_members_uplines($level ='')
{
		//first include self
		$this_user_uplines[0] = $this->toArray();
		$upline = $this->referred_by;

		for ($iteration= 1; $iteration <= $level ; $iteration++) { 

		$upline_here =    self::where('mlm_id' , $upline  )->where('mlm_id', '!=' ,null)->first();

		if ($upline_here != null) {
			
			$this_user_uplines[$iteration] = $upline_here->toArray();
		}else{
			break;
		}


			$upline = $this_user_uplines[$iteration]['referred_by'];

	}
	return  $this_user_uplines;

}








	public static function referred_members_downlines_paginated($user_id, $level_of_referral=1, $requested_per_page=1, $requested_page=1)
	{
		$recruiters = [$user_id];
		for ($iteration=1; $iteration <= $level_of_referral ; $iteration++) { 

			//ensure the pagination is on the last result set
			if ($iteration == $level_of_referral) {
				$page= $requested_page; $per_page = $requested_per_page;
			}else{
				$page=1; $per_page = 'all';
			}

			$downlines = User::referred_members_downlines_optimised($recruiters, $page, $per_page);
			$recruiters =  $downlines['list'];
		}
		$downlines['list'] = self::whereIn('mlm_id' , $downlines['list'])->get();
		return $downlines ;
	}




	public static function referred_members_downlines_optimised( array $recruiters=[], $page=1, $per_page = 'all')
	{
    	$skip = ($page - 1)* $per_page;


    	$sql_query = self::whereIn('referred_by' , $recruiters);
		$downlines['total'] = $sql_query->count();

				if ($per_page == 'all') {
					$downlines['list'] = $sql_query->get()->pluck(['mlm_id'])->toArray();
					$page = 1;
				}else{
					$downlines['list'] = $sql_query->offset($skip)->take($per_page)->get()->pluck(['mlm_id'])->toArray();

				}

		$downlines['page'] = $page;
		return $downlines;

	}




	public static function enroler_referred_members_downlines_paginated($user_id, $level_of_referral=1, $requested_per_page=1, $requested_page=1)
	{
		$recruiters = [$user_id];
		for ($iteration=1; $iteration <= $level_of_referral ; $iteration++) { 

			//ensure the pagination is on the last result set
			if ($iteration == $level_of_referral) {
				$page= $requested_page; $per_page = $requested_per_page;
			}else{
				$page=1; $per_page = 'all';
			}

			$downlines = User::enroler_referred_members_downlines_optimised($recruiters, $page, $per_page);
			$recruiters =  $downlines['list'];
		}
		$downlines['list'] = self::whereIn('mlm_id' , $downlines['list'])->get();
		return $downlines ;
	}



	public static function enroler_referred_members_downlines_optimised( array $recruiters=[], $page=1, $per_page = 'all')
	{
    	$skip = ($page - 1)* $per_page;


    	$sql_query = self::whereIn('introduced_by' , $recruiters);
		$downlines['total'] = $sql_query->count();

				if ($per_page == 'all') {
					$downlines['list'] = $sql_query->get()->pluck(['mlm_id'])->toArray();
					$page = 1;
				}else{
					$downlines['list'] = $sql_query->offset($skip)->take($per_page)->get()->pluck(['mlm_id'])->toArray();

				}

		
		$downlines['page'] = $page;
		return $downlines;

	}




/*
*@param takes the depth of doenlnes to calaclate
*returns array of this downlines
*/
public function referred_members_downlines($level )
{

$recruiters = [$this->mlm_id];
	for ($iteration= 1; $iteration <= $level ; $iteration++) { 
			$this_user_downlines[$iteration] = self::whereIn('referred_by' , $recruiters)
													->where('mlm_id', '!=', null)->get(['mlm_id'])->toArray();
			$recruiters = $this_user_downlines[$iteration];
	}


foreach ($this_user_downlines as $downline => $members) {
	foreach ($members as $key => $member) {
		$member_full =  $this::where('mlm_id' ,$member['mlm_id'])->first();
		$this_user_downlines[$downline][$key]['referred_by'] = $member_full->referred_by;
		$this_user_downlines[$downline][$key]['id'] =$member_full->id;
		$this_user_downlines[$downline][$key]['no_of_direct_line'] = User::where('referred_by' , $member['mlm_id'])->count();
	}

	}

	return $this_user_downlines;

}

/*the placement structure ends*/






    /*the enroller strucure begins*/

/**
 * [leg_of_user this returns the leg in which the suplied user is on this users team/donwline]
 * @param  string $user_id [the id of the user we want to check in this instance user]
 * @return [int]          [description]
 */
public function enroler_leg_of_user($user_id='')
{
	/**
	 * [$i this is the leg we want to check if the supplied user is in
	 * usually, maximum leg will be equal the width of the matrix]
	 * @var integer
	 */
	$i =1;
	do  { 
	
		//if the supplied user is the direct downline of this instance user in this leg we are in 
			if ($this->enroler_user_at_leg($i)->id == $user_id) {
				$leg = $i ;
				break;
			}

			//if the supplied user is in downline of this instance user direct downline in this leg
			if($this->enroler_user_at_leg($i)->enroler_downline_level_of($user_id)['present']){
				$leg = $i ;
				break;
			}

			$i++;
	}while ($this->enroler_user_at_leg($i) != null);//ensure this instance user has started building the leg

	
	// print_r($user_at_leg);

	return ($leg);
}



/**
 * [downline_level_of retruns the downline level of a user in this instance user team]
 * @param  string $user_id [the id of the user we want to check in this instnace user]
 * @return [array]          [description]
 */
public function enroler_downline_level_of($user_id='')
{

		foreach ($this->enroler_all_downlines() as $level => $downline_users) {

					foreach ($downline_users as $user) {

						if ($user_id == $user['id']) {
							$downline_level = $level;
							break(2);
						}
					}

		}


return ['present' =>boolval($downline_level) , 'level'=>$downline_level] ;
	}


/**
 * [enroler_legs returns all the user ids in all the available legs for this user]
 * @return [type] [array with key representing the leg index and value an array of userids]
 */
public function placement_legs()
{
			$legs = ($this->referred_members_downlines(1)[1]);
			
			// print_r($legs);
			// $plucked_legs_ids =  $legs->pluck('id');


			foreach ($legs as $key => $user_array) {
				$user_obj = User::find($user_array['id']);
				$downlines = ($user_obj->all_downlines());
				 unset($downlines[0]);
				// echo "downlines<br>"; print_r($downlines);

				 foreach ($downlines as $level => $downline) {
				 $downline = collect($downline);
/*
				 echo "leg $key and level $level <br>";
				 	 print_r($downline->pluck('id'));*/
				 	 $user_ids = ($downline->pluck('id'));

				 	 foreach ($user_ids as  $id) {
				 	 	$result[$key][] = $id;
				 	 }



				 }

			}

			//include the front line user_id in the legs
			foreach ($legs as $key => $value) {
				$result[$key][] = $legs[$key]['id'];
			}
			ksort($result);


			return ($result);

}


/**
 * [enroler_legs returns all the user ids in all the available legs for this user]
 * @return [type] [array with key representing the leg index and value an array of userids]
 */
public function enroler_legs()
{
			$legs = ($this->enroler_referred_members_downlines(1)[1]);
			
			// print_r($legs);
			// $plucked_legs_ids =  $legs->pluck('id');


			foreach ($legs as $key => $user_array) {
				$user_obj = User::find($user_array['id']);
				$downlines = ($user_obj->enroler_all_downlines());
				 unset($downlines[0]);
				// echo "downlines<br>"; print_r($downlines);

				 foreach ($downlines as $level => $downline) {
				 $downline = collect($downline);
/*
				 echo "leg $key and level $level <br>";
				 	 print_r($downline->pluck('id'));*/
				 	 $user_ids = ($downline->pluck('id'));

				 	 foreach ($user_ids as  $id) {
				 	 	$result[$key][] = $id;
				 	 }



				 }

			}

			//include the front line user_id in the legs
			foreach ($legs as $key => $value) {
				$result[$key][] = $legs[$key]['id'];
			}
			ksort($result);


			return ($result);

}


/**
 * [all_downlines fetches all the ids of this users doenlines users infinitely
 * @return [array] [with keys as the downline level and values as all the users ids in the level]
 */
public function enroler_all_downlines()
{

    $depth_level = 1;
    $downlines_at[0] = ['id'=> $this->id , 'introduced_by'=> $this->introduced_by]; // self is on downline zero
    do {
    foreach ($this->enroler_referred_members_downlines($depth_level) as $level=> $downlines) {
        $downlines_at[$level] = $downlines;
    }
    $depth_level++;
    } while (count($this->enroler_referred_members_downlines($depth_level)[$depth_level]) != '');


    return ($downlines_at);

}


/**
 * [user_at_leg returns the first user at the leg supplied]
 * @param  [type] $leg 
 * @return [type]      [description]
 */
public function enroler_user_at_leg($leg)
{
	$leg--;
 $user_id_at_leg  = $this->enroler_referred_members_downlines(1)[1][$leg]['id'];
 $user_at_leg 	  =	self::find($user_id_at_leg);
 return $user_at_leg ;
}



/**
 * [number_of_all_downlines_at_leg tells how many users are in this user particular leg]
 * @param  int $leg [ the leg index we wish to check on i.e for leg 1, $leg=0]
 * @return [type]      [description]
 */
public function enroler_number_of_all_downlines_at_leg($leg='')
{

 $user_at_leg 	  =	$this->enroler_user_at_leg($leg+1);


 if ($user_at_leg == null) {return 0; }

    $depth_level = 1;
    do {
    foreach ($user_at_leg->enroler_referred_members_downlines($depth_level) as $level=> $downlines) {
        $number_of_downlines_at_level[$level] = count($downlines);
    }
    $depth_level++;
    } while (count($user_at_leg->enroler_referred_members_downlines($depth_level)[$depth_level]) != '');

    $number_of_all_downlines  =  array_sum($number_of_downlines_at_level);
    return ($number_of_all_downlines + 1);
}


/**
 * [user_legs returns array with key as this user leg and value as number of downlines]
 * @return [array] [description]
 */
public function enroler_user_legs()
{
    $leg=0;
	do{
		    $users_leg[($leg+1)] = $this->enroler_number_of_all_downlines_at_leg($leg);
		    $leg++;
	}while ($users_leg[($leg)] != 0) ;


return ($users_leg);

}











/**
 * [referred_members_uplines fetches all this uses uplines up to the level supplied]
 * @param  int $level [description]
 * @return [type]        [description]
 */
public function enroler_referred_members_uplines($level ='')
{
		//first include self
		$this_user_uplines[0] = $this->toArray();
$upline = $this->introduced_by;

	for ($iteration= 1; $iteration <= $level ; $iteration++) { 



		$upline_here =    self::where('mlm_id' , $upline  )->where('mlm_id', '!=' ,null)->first();

		if ($upline_here != null) {
			
			$this_user_uplines[$iteration] = $upline_here->toArray();
		}else{
			break;
		}


			$upline = $this_user_uplines[$iteration]['introduced_by'];

	}
	return  $this_user_uplines;

}




/*
*@param takes the depth of doenlnes to calaclate
*returns array of this downlines
*/
public function enroler_referred_members_downlines($level)
{



$recruiters = [$this->mlm_id];
	for ($iteration= 1; $iteration <= $level ; $iteration++) { 
			$this_user_downlines[$iteration] = self::whereIn('introduced_by' , $recruiters)->where('mlm_id', '!=', null)
				->get(['mlm_id','rank','rank_history'])->toArray();
			$recruiters = $this_user_downlines[$iteration];
	}


foreach ($this_user_downlines as $downline => $members) {
	foreach ($members as $key => $member) {
		$member_full =  $this::where('mlm_id' ,$member['mlm_id'])->first();
		$this_user_downlines[$downline][$key]['introduced_by'] = $member_full->introduced_by;
		$this_user_downlines[$downline][$key]['id'] =$member_full->id;
		$this_user_downlines[$downline][$key]['no_of_direct_line'] = User::where('introduced_by' , $member['mlm_id'])->count();
	}

	}

	return $this_user_downlines;




}



    /*the enroller strucure ends*/








	public function supportTickets()
	{
		return $this->hasMany('SupportTicket' , 'user_id');
	}


	public function getfullnameAttribute()
	{

		return "{$this->lastname} {$this->firstname}";
	}










































    /**
     * is_blocked() tells whether a user is blocked or not
     * @return boolean true when blocked and false ff otherwise
     */
	public function is_blocked()
	{
	return	boolval($this->blocked_on);
	}




	public function getresizedprofilepixAttribute($value)
    {
    	$value= $this->resized_profile_pix;
    	if (! file_exists($value) &&  (!is_dir($value))) {
	        return (Config::default_profile_pix());
    	}
    	return $value;
    }

	public function getprofilepicAttribute()
    {
    	$value = $this->profile_pix;
	if (! file_exists($value) &&  (!is_dir($value))) {
	        return (Config::default_profile_pix());
    	}

	   	return $value;

    }



	/**
	 * [getFirstNameAttribute eloquent accessor for firstname column]
	 * @param  [type] $value [description]
	 * @return [string]        [description]
	 */
	public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

/**
	 * [getFirstNameAttribute eloquent accessor for firstname column]
	 * @param  [type] $value [description]
	 * @return [string]        [description]
	 */
	public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }


	/**
	 * eloquent mutators for password hashing
	 * hashes user password on insert or update
	 *@return 
	 */
	 public function setPasswordAttribute($value)
	    {
	        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
	    }




}

















?>