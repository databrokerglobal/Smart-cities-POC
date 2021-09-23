<?php
/**********************************************************************
 * 
 * 
 * 
 * 
 *********************************************************************/

namespace App\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use App\Models\ActivityLog;

class SiteHelper{

	/**
	 * 
	 * 
	 * 
	 * 
	 */
	public static function flash($message){
		session()->flash('message',$message);
	}

	/**
	 * 
	 * parse string and remove all special characters
	 * 
	 *  create clean string for URL
	 */

	public static function slugify($text) {
		
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);
	
		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	
		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);
	
		// trim
		$text = trim($text, '-');
	
		// remove duplicated - symbols
		$text = preg_replace('~-+~', '-', $text);
	
		// lowercase
		$text = strtolower($text);
	
		if (empty($text)) {
		  return 'n-a';
		}
	
		return $text;
	}
	/**
	 * 
	 *  Resize image
	 * 
	 * 
	 */
	public static function resizeImage($file, $width, $height, $fileName, $location){
		$imgObj = Image::make($file->getRealPath());
		$imgObj->resize($width, $height, function ($constraint) {
			$constraint->aspectRatio();
		})->save(public_path($location).'/'.$fileName);
	}
	/**
	 * 
	 * Resize image and upload
	 * 
	 * 
	 */
	public static function resizeAndUploadImage($file, $type, $fileName, $useCanvasFor = []){

		
		// Make a constant from String

		$folder = constant($type.'_IMAGE_UPLOAD_PATH');
		$imgObj = Image::make($file->getRealPath());

		// Resize Large Image
		
		$imgObj->resize(constant($type.'_LARGE_IMG_WIDTH'), constant($type.'_LARGE_IMG_HEIGHT'), function ($constraint) {
			$constraint->aspectRatio();
		})->save(public_path($folder.'/large').'/'.$fileName);

		// Fit in canvas if needed
		if(count($useCanvasFor) > 0 && in_array('LARGE',$useCanvasFor)){
			$canvas = Image::canvas(constant($type.'_LARGE_IMG_WIDTH'), constant($type.'_LARGE_IMG_HEIGHT'));
			$canvas->insert($imgObj, 'center');
			$canvas->save(public_path($folder.'/large').'/'.$fileName);
		}
				
		// Resize Medium Image
        $imgObj->resize(constant($type.'_MEDIUM_IMG_WIDTH'), constant($type.'_MEDIUM_IMG_HEIGHT'), function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path($folder.'/medium').'/'.$fileName);

		// Fit in canvas if needed
		if(count($useCanvasFor) > 0 && in_array('MEDIUM',$useCanvasFor)){
			$canvas = Image::canvas(constant($type.'_MEDIUM_IMG_WIDTH'), constant($type.'_MEDIUM_IMG_HEIGHT'));
			$canvas->insert($imgObj, 'center');
			$canvas->save(public_path($folder.'/medium').'/'.$fileName);
		}


		// Resize Tiny Image
        $imgObj->resize(constant($type.'_TINY_IMG_WIDTH'), constant($type.'_TINY_IMG_HEIGHT'), function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path($folder.'/tiny').'/'.$fileName);
		
		// Fit in canvas if needed
		if(count($useCanvasFor) > 0 && in_array('TINY',$useCanvasFor)) {
			$canvas = Image::canvas(constant($type.'_TINY_IMG_WIDTH'), constant($type.'_TINY_IMG_HEIGHT'));
			$canvas->insert($imgObj, 'center');
			$canvas->save(public_path($folder.'/tiny').'/'.$fileName);
		}

        
		// Resize Thumb Image
        $imgObj->resize(constant($type.'_THUMB_IMG_WIDTH'),constant($type.'_THUMB_IMG_HEIGHT'), function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path($folder.'/thumb').'/'.$fileName);
		
		// Fit in canvas if needed
		if(count($useCanvasFor) > 0 && in_array('THUMB',$useCanvasFor)){
			$canvas = Image::canvas(constant($type.'_THUMB_IMG_WIDTH'), constant($type.'_THUMB_IMG_HEIGHT'));
			$canvas->insert($imgObj, 'center');
			$canvas->save(public_path($folder.'/thumb').'/'.$fileName);
		}
		
		// Upload Actual Image
        $file->move(public_path($folder.'/'), $fileName);

	}
	/**
	 * 
	 * User log activity for frontend
	 * 
	 * 
	 */
	public static function logActivity($action_type, $action_detail, $anonymousUID = '') {

		if($anonymousUID == 'admin') {
			$action_by = 'admin';
		}else if($anonymousUID == '') {
			$action_by = Auth::user()->userIdx;
		} else {
			$action_by = $anonymousUID;
		}
		ActivityLog::create([
			'action_type'	=>	$action_type,
			'action_by'		=>	$action_by,
			'action_date'	=>  date('Y-m-d h:i:s'),
			'action_detail'	=>	$action_detail
		]);
	}
	
	/**
	 * 
	 * force http
	 * 
	 * 
	 */
	public static function forceHttp($url,$force=false) {
		return $url;	
	}
	
	/**
	 * 
	 * force https
	 * 
	 * 
	 */
	public static function forceHttps($url,$force=false) {
		return $url;		
	}


	/**
     *  Wyre payment 
     * 
     * 
     */

    public static function make_authenticated_request($endpoint, $method, $body) {
        $url = 'https://api.testwyre.com'; // todo use this endpoint for testwyre environment
      // $url = 'https://api.sendwyre.com';
     
       // todo please replace these with your own keys for the correct environment
       $api_key = "AK-3UE84YYT-TJ347NL7-9N9DMBT4-P2BTCY92";
       $secret_key = "SK-HXEBE2G3-YGHMA2BN-FXEVPXUZ-REWV4RA3";

       $timestamp = floor(microtime(true)*1000);
       $request_url = $url . $endpoint;

       if(strpos($request_url,"?"))
           $request_url .= '&timestamp=' . sprintf("%d", $timestamp);
       else
           $request_url .= '?timestamp=' . sprintf("%d", $timestamp);

       if(!empty($body))
           $body = json_encode($body, JSON_FORCE_OBJECT);
       else
           $body = '';


       $auth_sig_hash = hash_hmac('sha256', $request_url . $body, $secret_key);

       $headers = array(
           "Content-Type: application/json",
		   "cache-control: no-cache",
           "Authorization: ". $api_key
       );
       $curl = curl_init();

       if($method=="POST"){
         $options = array(
           CURLOPT_URL             => $request_url,
           CURLOPT_POST            =>  true,
           CURLOPT_POSTFIELDS      => $body,
           CURLOPT_RETURNTRANSFER  => true);
       }else {
         $options = array(
           CURLOPT_URL             => $request_url,
           CURLOPT_RETURNTRANSFER  => true);
       }
       curl_setopt_array($curl, $options);
       curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
       $result = curl_exec($curl);
       curl_close($curl);
      // var_dump($result);
       return json_decode($result, true);
   }

}