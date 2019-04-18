<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class CmsPages extends Eloquent 
{
	
		protected $fillable = [
								'page_unique_name',
								'page_name',
								'page_content',
								'default_page_content'
								];
	
	protected $table = 'cms_table';





}


















?>