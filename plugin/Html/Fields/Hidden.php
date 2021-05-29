<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Html\Fields;

use Psource\SiteReviews\Html\Fields\Text;

class Hidden extends Text
{
	/**
	 * @return string
	 */
	public function render( array $defaults = [] )
	{
		if( isset( $this->args['label'] )) {
			unset( $this->args['label'] );
		}
		if( isset( $this->args['desc'] )) {
			unset( $this->args['desc'] );
		}
		if( isset( $this->args['id'] )) {
			unset( $this->args['id'] );
		}
		return parent::render( wp_parse_args( $defaults, [
			'class' => '',
		]));
	}
}
