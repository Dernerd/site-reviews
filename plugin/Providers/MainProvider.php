<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2016, Paul Ryley
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Providers;

use Psource\SiteReviews\App;
use Psource\SiteReviews\Log\Logger;
use Psource\SiteReviews\Providers\ProviderInterface;

/**
 * Note: We're using the full "namespace\classname" because "::class" isn't supported in PHP 5.4
 */
class MainProvider implements ProviderInterface
{
	public function register( App $app )
	{
		$app->bind( 'Psource\SiteReviews\App', $app );

		$app->bind( 'Psource\SiteReviews\Log\Logger', function( $app ) {
			return Logger::file( trailingslashit( $app->path ) . 'debug.log', $app->prefix );
		});

		$app->singleton(
			'Psource\SiteReviews\Html',
			'Psource\SiteReviews\Html'
		);

		$app->singleton(
			'Psource\SiteReviews\Session',
			'Psource\SiteReviews\Session'
		);

		$app->singleton(
			'Psource\SiteReviews\Settings',
			'Psource\SiteReviews\Settings'
		);

		$app->singleton(
			'Psource\SiteReviews\Translator',
			'Psource\SiteReviews\Translator'
		);

		// controllers should go last
		$app->singleton(
			'Psource\SiteReviews\Controllers\AjaxController',
			'Psource\SiteReviews\Controllers\AjaxController'
		);

		$app->singleton(
			'Psource\SiteReviews\Controllers\MainController',
			'Psource\SiteReviews\Controllers\MainController'
		);

		$app->singleton(
			'Psource\SiteReviews\Controllers\ReviewController',
			'Psource\SiteReviews\Controllers\ReviewController'
		);
	}
}
