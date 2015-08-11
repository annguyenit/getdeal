<?php
	/* Note: This thumbnail creation script requires the GD PHP Extension.  
		If GD is not installed correctly PHP does not render this page correctly
		and SWFUpload will get "stuck" never calling uploadSuccess or uploadError
	 */

	// Get the session Id passed from SWFUpload. We have to do this to work-around the Flash Player Cookie Bug
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}

	session_start();
	ini_set("html_errors", "0");

	// Check the upload
	if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
		echo "ERROR:invalid upload";
		exit(0);
	}
#####################################################################################	
######################### ADDED BY STIOFAN WWW.HEBTECH.CO.UK ########################
#####################################################################################
	
	//###### Get file extension
	$path_info = pathinfo($_FILES["Filedata"]['name']);
	$file_extension = $path_info["extension"];
	
    
	
	if($file_extension=='jpg' || $file_extension=='JPG' || $file_extension=='jpeg' || $file_extension=='JPEG')
	$img = imagecreatefromjpeg($_FILES["Filedata"]["tmp_name"]);
	else if($file_extension=='png' || $file_extension=='PNG')
	$img = imagecreatefrompng($_FILES["Filedata"]["tmp_name"]);
	else if($file_extension=='gif' || $file_extension=='GIF')
	$img = imagecreatefromgif($_FILES["Filedata"]["tmp_name"]);
	else if($file_extension=='bmp' || $file_extension=='BMP')
	$img = imagecreatefromwbmp($_FILES["Filedata"]["tmp_name"]);
#####################################################################################	
######################### END ADDED BY STIOFAN WWW.HEBTECH.CO.UK ####################
#####################################################################################	
	// Get the image and create a thumbnail
	// $img = imagecreatefromjpeg($_FILES["Filedata"]["tmp_name"]); ##### removed to be replaced with above to get the type of image
	if (!$img) {
		echo "ERROR:could not create image handle ". $_FILES["Filedata"]["tmp_name"];
		exit(0);
	}

	$width = imageSX($img);
	$height = imageSY($img);

	if (!$width || !$height) {
		echo "ERROR:Invalid width or height";
		exit(0);
	}

	if (!isset($_SESSION["file_info"])) {
		$_SESSION["file_info"] = array();
	}

	// Use a output buffering to load the image into a variable
	 									
	ob_start();
	
	imagejpeg($img); 
	$imagevariable = ob_get_contents();
	ob_end_clean();

	$file_id = md5($_FILES["Filedata"]["tmp_name"] + rand()*100000);
	
	//$_SESSION["file_info"][$file_id] = $imagevariable;
	$_SESSION["file_info"][$file_id] = $file_id;
	if(!imagejpeg($img,get_image_phy_destination_path().$file_id.'.jpg'))
	{
		echo "error in image upload";
		exit;
	}
	echo "FILEID:" . $file_id;	// Return the file id to the script

function get_image_phy_destination_path()
{	
	 $rootdir = dirname(__FILE__);
	 $blog_id = '';
	$content_dir = substr($rootdir,0,strpos($rootdir,'themes'));
	if(isset($_REQUEST['bid']) && $_REQUEST['bid'] != '')
		$blog_id = $_REQUEST['bid'];
	global $upload_folder_path;
	if($blog_id)
	{
		 $upload_folder_path = "blogs.dir/$blog_id/files/";
	}else
	{
		 $upload_folder_path = "uploads/";
	}
	
	$rootdir = dirname(__FILE__);
	$content_dir = substr($rootdir,0,strpos($rootdir,'themes'));
	$destination_path = $content_dir . $upload_folder_path . "tmp/";
	 
	if (!file_exists($destination_path)){
      $imagepatharr = explode('/',$upload_folder_path . "tmp");
	   $year_path = $content_dir;
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {
			$year_path .= $imagepatharr[$i]."/";
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	}
	 return $destination_path;
}	
?>