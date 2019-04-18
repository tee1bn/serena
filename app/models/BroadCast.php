<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class BroadCast extends Eloquent 
{
	
	protected $fillable = ['broadcast_message', 'admin_id','status'];
	
	protected $table = 'broadcast';


public function admin()
{
		return $this->belongsTo('Admin', 'admin_id')	;
}



public function live()
{
	return BroadCast::where('status', 1)->latest()->get();
}


public function latest_broadcast()
{
	return BroadCast::live()->first();
}



public function status()
{
	if ($this->status == 1) {
		return '<span class="btn-xs btn btn-success">Live</span>';
	}else{
		return '<span class="btn-xs btn btn-danger">Not Live</span>';

	}
}


}


















?>