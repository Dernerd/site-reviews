<?php
/**
 * Plugin Name: Webseiten-Bewertungen
 * Plugin URI:  https://wordpress.org/plugins/site-reviews
 * Description: Erhalten und Anzeigen von Webseiten-Bewertungen
 * Version:     2.2.3
 * Author:      DerN3rd
 * Author URI:  https//n3rds.work
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: site-reviews
 * Domain Path: languages
 */

require 'vendor/psource-plugin-update/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://n3rds.work/wp-update-server/?action=get_metadata&slug=site-reviews', 
	__FILE__, 
	'site-reviews' 
);
defined( 'WPINC' ) || die;

require_once __DIR__ . '/activate.php';

if( !glsr_version_check() )return;

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/compatibility.php';
require_once __DIR__ . '/helpers.php';

use Psource\SiteReviews\App;
use Psource\SiteReviews\Providers\MainProvider;

$app = App::load();

$app->register( new MainProvider );

register_activation_hook( __FILE__, array( $app, 'activate' ));
register_deactivation_hook( __FILE__, array( $app, 'deactivate' ));

$app->init();
