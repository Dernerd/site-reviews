<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2016, Paul Ryley
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Html\Fields;

use Psource\SiteReviews\Html\Fields\Radio;

class Yesno extends Radio
{
	/**
	 * @return string
	 */
	public function render( array $defaults = [] )
	{
		$this->args['options'] = [
			'no'  => __( 'No', 'site-reviews' ),
			'yes' => __( 'Yes', 'site-reviews' ),
		];
		return parent::render( wp_parse_args( $defaults, [
			'default' => 'no',
		]));
	}
}
