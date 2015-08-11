<?php include TT_ADMIN_TPL_PATH.'header.php'; ?>
<div class="info top-info"></div>
<div class="ajax-message<?php if ( isset( $message ) ) { echo ' show'; } ?>">
	<?php if ( isset( $message ) ) { echo $message; } ?>
</div>
	<div id="content">
		<div id="options_tabs">
			<ul class="options_tabs">
				<li><a href="#option_settings"><?php echo SETTINGS_TEXT; ?></a><span></span></li>
				<li><a href="#option_links"><?php echo LINKS_TEXT; ?></a><span></span></li>
				<li><a href="#option_sale_report"><?php echo SALE_REPORT_TEXT; ?></a><span></span></li>
				<li><a href="#option_members"><?php echo MEMBERS_TEXT; ?></a><span></span></li>
				<li><a href="#option_orders"><?php echo MANAGE_ORDER_TEXT; ?></a><span></span></li>
			</ul>