<?php
//Leaven empty tag to let automation add the path disclosure line
?>
<div class="wrap">
	<?php include_once WC4BP_ABSPATH_ADMIN_VIEWS_PATH . 'html_admin_header.php'; ?>
	<br>

	<div>
		<form method="post" action="options.php">
			<?php wp_nonce_field( 'update-options' ); ?>
			<?php settings_fields( 'wc4bp_options_notifications' ); ?>
			<?php do_settings_sections( 'wc4bp_options_notifications' ); ?>
		</form>
	</div>
</div>