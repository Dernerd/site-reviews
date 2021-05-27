<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2016, Paul Ryley
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Html\Fields;

use Psource\SiteReviews\Html\Fields\Select;

class Roles extends Select
{
	/**
	 * @return string
	 */
	public function render( array $defaults = [] )
	{
		return parent::render( wp_parse_args( $defaults, [
			'options' => wp_roles()->get_names(),
		]));
	}
}
