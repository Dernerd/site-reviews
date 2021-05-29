<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Providers;

use Psource\SiteReviews\App;

interface ProviderInterface
{
	/**
	 * @return void
	 */
	public function register( App $app );
}
