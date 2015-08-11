<?php
$wp_user_roles_array = get_option('wp_user_roles');
if(strstr($_SERVER['REQUEST_URI'],'/themes.php'))
{
$wp_user_roles_array['affiliate'] = array(
							"name"	=> "Affiliate",
							"capabilities" => array
												(
													"upload_files" => 1,
													"edit_posts" => 1,
													"edit_published_posts" => 1,
													"publish_posts" => 1,
													"read" => 1,
													"level_2" => 1,
													"level_1" => 1,
													"level_0" => 1,
													"delete_posts" => 1,
													"delete_published_posts" => 1,
												)

							);
							
update_option('wp_user_roles', $wp_user_roles_array);
}

function affiliates()
{
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/monetize/affiliates/admin_affiliates_frm.php');
	}else
	{
		include_once(TEMPLATEPATH . '/monetize/affiliates/admin_affiliates.php');
	}
}

function affiliates_settings()
{
	include_once(TEMPLATEPATH . '/monetize/affiliates/affiliates_settings.php');
}

function affiliate_report()
{
	include_once(TEMPLATEPATH . '/monetize/monetize/admin_affiliates_report.php');
}

?>