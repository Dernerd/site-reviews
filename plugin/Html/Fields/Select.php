<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Html\Fields;

use Psource\SiteReviews\Html\Fields\Base;

class Select extends Base
{
	protected $element = 'select';

	/**
	 * @return string
	 */
	public function render( array $defaults = [] )
	{
		$defaults = wp_parse_args( $defaults, [
			'type' => 'select',
		]);
		return sprintf( '<select %s>%s</select>%s',
			$this->implodeAttributes( $defaults ),
			$this->implodeOptions( 'select_option' ),
			$this->generateDescription()
		);
	}
}
