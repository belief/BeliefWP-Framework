<div class="wrap">
	<div class="wphootsuitedashboard">
		<div class="icon32" id="hootsuite-logo"><br></div>
		<h2><?php _e( 'Settings', WPHOOTSUITEDASHBOARD_DOMAIN ); ?></h2>
		<?php
		if (!current_user_can('administrator')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		} else {
			settings_errors();
			?>
			<form id="wphootsuitedashboard_plugin_settings" action="options.php" method="post">
				<?php settings_fields('wphootsuitedashboard_settings'); ?>
				<?php do_settings_sections('wphootsuitedashboard-plugin-settings-section'); ?>
				<?php submit_button(); ?>
			</form>
		<?php
		}
		?>
	</div>
</div>
