<?php
if($post->post_type==CUSTOM_POST_TYPE1)
{
	require_once (TEMPLATEPATH."/single-".CUSTOM_POST_TYPE1.".php");
}else
{
	require_once (TEMPLATEPATH.'/single_blog.php');
}
?>