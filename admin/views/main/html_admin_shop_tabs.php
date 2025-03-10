<?php
//Leaven empty tag to let automation add the path disclosure line
?>
<?php /** @var wc4bp_admin $this */ ?>
<p>
    <label>
        <input name='wc4bp_options[tab_activity_disabled]' type='checkbox' value='1' <?php checked( $tab_activity_disabled, 1 ); ?> />
        <b><?php _e( 'Turn off Shop.', 'wc4bp' ); ?></b>
		<?php _e( 'Disable the BuddyPress Shop Tab and WooCommerce My Account will work normally.', 'wc4bp' ); ?>
    </label>
</p>
<p>
    <label>
        <input name='wc4bp_options[tab_my_account_disabled]' type='checkbox' value='1' <?php checked( $tab_my_account_disabled, 1 ); ?> />
        <b><?php _e( 'Turn off \'WooCommerce My Account\' redirection.', 'wc4bp' ); ?></b>&nbsp; <?php _e( 'This option is useful when you have problems with 3rd WooCommerce plugins. It disables only the My Account redirection, not the sub tabs URL.', 'wc4bp' ); ?>
    </label>
</p>
<p>
    <label>
        <b><?php _e( 'Change the  Shop label. ', 'wc4bp' ); ?></b>&nbsp; <?php _e( 'This option is useful when you want to change the Label of the Shop.', 'wc4bp' ); ?>
        <br/>
        <input name='wc4bp_options[tab_my_account_shop_label]' type='text' value='<?php echo  $tab_my_account_shop_label; ?>'  />

    </label>
</p>

<p>
    <label>
        <b><?php _e( 'Change the  Shop Url. ', 'wc4bp' ); ?></b>&nbsp; <?php _e( 'This option is useful when you want to change the Url of the Shop.', 'wc4bp' ); ?>
        <br/>
        <input name='wc4bp_options[tab_my_account_shop_url]' type='text' value='<?php echo  $tab_my_account_shop_url; ?>'  />

    </label>
</p>
