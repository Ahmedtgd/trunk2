<?php
namespace App\Classes;

/**
* 
*/
use File;
use Log;
use Image;
class ImageSave
{
	
	
	public function makedir($path)
	{
		# code...
		try {
		File::makeDirectory(public_path($full_path), 0775, true);
             
		} catch (\Exception $e) {
			
		}
	}

	public function generate_path($type)
	{
		# code...
		$ret="images/";
		switch ($type) {
			case 'siso':
				# code...
				$ret.="siso";
				break;
			
			default:
				# code...
				break;
		}

		return $ret;
	}

	public function generate_name()
	{
		# code...
		$r1 = str_random(10);
		$r2 = str_random(5);
		$r3 = str_random(2);
		$pname = $r1 . $r2 . $r3;
		return $pname;
	}

	public function save($r)
	{
		# code...
		$img = $r->file('image');
        $imgext = $img->getClientOriginalExtension();
        $image_name=$this->generate_name().".".$imgext;
        $path = $this->generate_path($r->type)."/".$r->product_id;
        if(!file_exists(public_path($path)))
        {
			File::makeDirectory(public_path($path), 0775, true);
        }
		$fullpath = $path."/".$image_name;
		Image::make($img)->resize('400', '300')->save($fullpath);
		return $image_name;

	}



}