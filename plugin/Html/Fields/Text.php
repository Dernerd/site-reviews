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

class Text extends Base
{
	protected $element = 'input';

	/**
	 * @return string
	 */
	public function render( array $defaults = [] )
	{
		$defaults = wp_parse_args( $defaults, [
			'class' => 'regular-text',
			'type'  => 'text',
		]);

		return sprintf( '<input %s/>%s',
			$this->implodeAttributes( $defaults ),
			$this->generateDescription()
		);
	}
}
