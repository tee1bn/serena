<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Ebooks extends Eloquent 
{
	
		protected $fillable = [
				'subscription_access',
				'title',
				'description',
				'cover_image',
				'file_path'
			];
	
	protected $table = 'ebooks';



	public function download()
	{

		$type = mime_content_type ( $this->file_path);
		$filename = end(explode('/', $this->file_path));

			header("Content-type: $type");
			header('Content-Disposition: attachment; filename="'.$filename.'"');

			readfile($this->file_path);
	}



	public function upload_coverpic($file)
	{
			$directory  = 'uploads/ebooks/cover_images';
				$handle = new Upload($file);

                //if it is image, generate thumbnail
                if (explode('/', $handle->file_src_mime)[0] == 'image') {

					$handle->Process($directory);
			 		$original_file  = $directory.'/'.$handle->file_dst_name;

					(new Upload($this->cover_image))->clean();
					$this->update(['cover_image' => $original_file]);


					return $this;
				}

	}

	public function upload_ebook($file)
	{


			$directory  = 'uploads/ebooks';
				$handle = new Upload($file);

                //if it is image, generate thumbnail

					$handle->Process($directory);
			 		$original_file  = $directory.'/'.$handle->file_dst_name;

					(new Upload($this->file_path))->clean();
					$this->update(['file_path' => $original_file]);


					return $this;
		}







	public static function accessible($subscription_id)
	{	
		$sub 	 = SubscriptionPlan::find($subscription_id);
		$sub_ids = SubscriptionPlan::where('hierarchy', '>=', $sub->hierarchy)
									->get()
									->pluck('id')
									->toArray();
		$sub_ids[] = 'free';

		$accessibles =  self::whereIn('subscription_access', $sub_ids);

		return $accessibles;
	}
	

	public function getAccessTypeAttribute()
	{

		if ($this->subscription_access != 'free') {

			$sub = SubscriptionPlan::find($this->subscription_access);
			return $sub->package_type;

		}else{

			return 'free';

		}

	}


	public static  function default_ebook_pix()
	{
		return 'https://wrappixel.com/demos/admin-templates/monster-admin/assets/images/big/img1.jpg';
	}

	

	public function getcoverpicAttribute()
    {
    	$value = $this->cover_image;
		if (! file_exists($value) &&  (!is_dir($value))) {
	        return (self::default_ebook_pix());
    	}

    	$pic_path = Config::domain()."/".$value;
	   	return $pic_path;

    }



}


















?>