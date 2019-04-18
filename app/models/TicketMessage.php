<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class TicketMessage extends Eloquent 
{
	
	protected $fillable = ['ticket_id', 'message', 'admin_id', 'user_id', 'status'];
	
	protected $table = 'customers_support';




public function supportTicket()
{
		return $this->belongsTo('supportTicket', 'ticket_id')	;
}




}


















?>