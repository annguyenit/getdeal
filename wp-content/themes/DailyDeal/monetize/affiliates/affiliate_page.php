<?php
if($_REQUEST['type']=='reg'){

		include(TEMPLATEPATH . '/monetize/affiliates/affiliate_reg.php');

}else{

	/*if(CHILDTEMPLATEPATH && file_exists(CHILDTEMPLATEPATH . '/affiliate_login_page.php')){
		include(CHILDTEMPLATEPATH . '/affiliate_login_page.php');
	}else{*/
		include(TEMPLATEPATH . '/monetize/affiliates/affiliate_login.php');		
	/*}*/

}
?>









