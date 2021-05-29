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

class Textarea extends Base
{
	protected $element = 'textarea';

	/**
	 * @return string
	 */
	public function render( array $defaults = [] )
	{
		$defaults = wp_parse_args( $defaults, [
			'class' => 'large-text',
			'rows'  => 3,
			'type'  => 'textarea',
		]);

		return sprintf( '<textarea %s>%s</textarea>%s',
			$this->implodeAttributes( $defaults ),
			$this->args['value'],
			$this->generateDescription()
		);
	}
}
