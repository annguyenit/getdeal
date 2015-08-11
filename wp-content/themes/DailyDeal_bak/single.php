<?php
if($post->post_type=='seller')
{
	require_once (TEMPLATEPATH.'/single-seller.php');
}else
{
	require_once (TEMPLATEPATH.'/single_blog.php');
}
?>