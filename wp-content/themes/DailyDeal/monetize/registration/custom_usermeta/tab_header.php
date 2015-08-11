<?php include TT_ADMIN_TPL_PATH.'header.php'; ?>
<div class="info top-info"></div>
<div class="ajax-message<?php if ( isset( $message ) ) { echo ' show'; } ?>">
	<?php if ( isset( $message ) ) { echo $message; } ?>
</div>
	<div id="content">
		<div id="options_tabs">
			<ul class="options_tabs">
				<li><a href="#option_display_custom_usermeta">All custom user-info fields</a><span></span></li>
                <?php if($_REQUEST['cf'] != '') {
					echo '<li><a href="#option_add_custom_usermeta">Edit user-info field</a><span></span></li>';
					}  else { ?>
				<li><a href="#option_add_custom_usermeta">Add a new user-info field</a><span></span></li>		
                <?php } ?>				
			</ul> 