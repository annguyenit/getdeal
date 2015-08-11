**********************************************************
========MANAGE PAYMENT METHODS MODULE================
**********************************************************

This is the module which will give you the payemnt method module integrated from wp-admin.

This module will allow you paypal, authorize.net, google checkout, world pay, pre bank transfer and cash on delivery included.

You need to follow steps as mention below to know how to install this module ::-

1)Get the complete folder "paymethods".


2)You also need to add some code in admin/admin_menu.php file,
to show the hyperlink for "Payment options" from  sidebar.

-->Add the below php code in "templ_add_admin_menu()" function of the admin_menu.php file. This code will call the function "manage_paysettings()" which is mention in the next point.
---------------------------------------------
if(file_exists(TT_ADMIN_FOLDER_PATH . 'paymethods/admin_paymethods_list.php'))
{
	add_submenu_page('templatic_wp_admin_menu', __("Manage Payment options",'templatic'), __("Payment options",'templatic'), TEMPL_ACCESS_USER, 'paymentoptions', 'manage_paysettings');
}
---------------------------------------------

-->also need to add "manage_paysettings()" function in the same admin_menu.php file which is called while the link of "Payment options" is clicked.
----------------------------------------------
function manage_paysettings()
{
	include_once(TT_ADMIN_FOLDER_PATH . 'paymethods/admin_paymethods_list.php');
}
----------------------------------------------


3)Once you have integrated payment modules from wp-admin, not you need to use related functions how to use it. "paymethods_functons.php" is the file from where all usefull functions are included.
-----------------------------------------------
include_once (TT_ADMIN_FOLDER_PATH . 'paymethods/paymethods_functons.php');
-----------------------------------------------


4)Likewise if you want to add any new link in the "Shoping Cart" menu, you can add via (3)rd step.


++++++++++++++++++++++++Thank You+++++++++++++++++++++++++++++++++++++