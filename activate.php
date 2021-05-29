<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

defined( 'WPINC' ) || die;

if( !function_exists( 'glsr_version_check' )) {
	function glsr_version_check( $returnArray = false ) {
		global $wp_version;
		$php = version_compare( PHP_VERSION, '5.4.0', '<' );
		$wordpress = version_compare( $wp_version, '4.0', '<' );
		return !$returnArray
			? !( $php || $wordpress )
			: array( 'php' => $php, 'wordpress' => $wordpress );
	}
}

if( !function_exists( 'glsr_deactivate_plugin' )) {
	function glsr_deactivate_plugin( $plugin )
	{
		$check = glsr_version_check( true );

		if( !$check['php'] && !$check['wordpress'] )return;

		$plugin_name = plugin_basename( dirname( __FILE__ ) . '/site-reviews.php' );

		if( $plugin == $plugin_name ) {
			$paged  = filter_input( INPUT_GET, 'paged' );
			$s      = filter_input( INPUT_GET, 's' );
			$status = filter_input( INPUT_GET, 'plugin_status' );

			wp_safe_redirect( self_admin_url( sprintf( 'plugins.php?plugin_status=%s&paged=%s&s=%s', $status, $paged, $s )));
			exit;
		}

		deactivate_plugins( $plugin_name );

		$title = __( 'Das Webseiten-Bewertung Plugin wurde deaktiviert.', 'site-reviews' );
		$msg_1 = '';
		$msg_2 = '';

		if( $check['php'] ) {
			$msg_1 = __( 'Entschuldigung, dieses Plugin benötigt PHP Version 5.4 oder höher, um richtig zu funktionieren.', 'site-reviews' );
			$msg_2 = __( 'Bitte wende Dich an Deinen Hosting-Anbieter oder Serveradministrator, um die Version von PHP auf Deinem Server zu aktualisieren (auf Deinem Server wird die PHP-Version %s ausgeführt), oder versuche, ein alternatives Plugin zu finden.', 'site-reviews' );
			$msg_2 = sprintf( $msg_2, PHP_VERSION );
		}

		// WordPress check overrides the PHP check
		if( $check['wordpress'] ) {
			$msg_1 = __( 'Entschuldigung, dieses Plugin benötigt WordPress Version 4.0.0 oder höher, um richtig zu funktionieren.', 'site-reviews' );
			$msg_2 = sprintf( '<a href="%s">%s</a>', admin_url( 'update-core.php' ), __( 'Update WordPress', 'site-reviews' ));
		}

		printf( '<div id="message" class="notice notice-error error is-dismissible"><p><strong>%s</strong></p><p>%s</p><p>%s</p></div>',
			$title,
			$msg_1,
			$msg_2
		);
	}
}

// PHP >= 5.4.0 and WordPress version >= 4.0.0 check
if( !glsr_version_check() ) {
	add_action( 'activated_plugin', 'glsr_deactivate_plugin' );
	add_action( 'admin_notices', 'glsr_deactivate_plugin' );
}
