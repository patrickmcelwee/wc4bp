<?php
//Leaven empty tag to let automation add the path disclosure line
?>
<?php /** @var wc4bp_admin $this */ ?>
<label>
	<p><?php _e( 'This option override the default tab to show when the user click in the Shop tab.', 'wc4bp' ); ?></p>
	<p>
		<select name='wc4bp_options[tab_shop_default]'>
			<?php
			if ( isset( $wc4bp_pages_options['selected_pages'] ) && is_array( $wc4bp_pages_options['selected_pages'] ) && count( $wc4bp_pages_options['selected_pages'] ) > 0 ) {
				foreach ( $wc4bp_pages_options['selected_pages'] as $key => $attached_page ) {
					echo '<option value="' . $key . '" ' . selected( $wc4bp_options['tab_shop_default'], $key, false ) . '>' . $attached_page['tab_name'] . '</option>';
				}
			} else {
				$wc4bp_options["tab_activity_disabled"] = 1;
				echo '<option value="default">' . __( 'You need at least one Page added to Member Profiles!', 'wc4bp' ) . '</option>';
			}
			?>
		</select>
	</p>
</label>
