<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

defined( 'WPINC' ) || die;

/**
 * PSR-4 autoloader
 */
spl_autoload_register( function( $class )
{
	$namespaces = [
		'Psource\\SiteReviews\\'        => __DIR__ . '/plugin/',
		'Psource\\SiteReviews\\Tests\\' => __DIR__ . '/tests/',
		'Psource\\SchemaOrg\\'          => __DIR__ . '/vendor/psource/schema-org/src/',
		'Sepia\\PoParser\\'                => __DIR__ . '/vendor/qcubed/i18n/src/Sepia/',
		'Sinergi\\BrowserDetector\\'       => __DIR__ . '/vendor/sinergi/browser-detector/src/',
		'Vectorface\\Whip\\'               => __DIR__ . '/vendor/vectorface/whip/src/',
	];

	foreach( $namespaces as $prefix => $base_dir ) {
		$len = strlen( $prefix );
		if( strncmp( $prefix, $class, $len ) !== 0 )continue;
		$file = $base_dir . str_replace( '\\', '/', substr( $class, $len )) . '.php';
		if( !file_exists( $file ))continue;
		require $file;
		break;
	}
});

require_once( ABSPATH . WPINC . '/class-phpass.php' );
