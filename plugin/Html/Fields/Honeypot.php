<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Html\Fields;

use Psource\SiteReviews\Html\Fields\Hidden;

class Honeypot extends Hidden
{
	/**
	 * @return string
	 */
	public function render( array $defaults = [] )
	{
		$this->args['type'] = 'text';
		$this->args['name'] = 'gotcha';
		$this->args['prefix'] = false;
		$this->args['attributes']['style'] = 'display:none!important';
		$this->args['attributes']['tabindex'] = '-1';
		$this->args['attributes']['autocomplete'] = 'off';

		return parent::render( wp_parse_args( $defaults, [
			'class' => 'glsr-input',
		]));
	}
}
