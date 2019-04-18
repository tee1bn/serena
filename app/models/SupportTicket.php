<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class SupportTicket extends Eloquent 
{
	
	protected $fillable = ['subject_of_ticket', 'user_id', 'status', 'closed_by'];
	
	protected $table = 'support_tickets';


public function messages()
{
		return $this->hasMany('TicketMessage', 'ticket_id')	;
}

public function user()
{
		return $this->belongsTo('User', 'user_id')	;
}


public function admin()
{
		return $this->belongsTo('Admin', 'closed_by')	;
}



}


















?>