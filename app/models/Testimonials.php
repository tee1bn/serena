<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Testimonials extends Eloquent 
{
	
	protected $fillable = ['attester', 'user_id',	'content', 'approval_status'];
	
	protected $table = 'testimonials';


public function approved()
{
	return self::where('approval_status', 1);
}


public function user()
{
	return $this->belongsTo('User', 'user_id');
}


public function status()
{
	if ($this->approval_status) {
		$status = "<label class='label label-success'>Approved</label>";
	}else{
		
		$status = "<label class='label label-danger'>Not Approved</label>";
	}

	return $status;
}

}


















?>