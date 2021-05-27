<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2016, Paul Ryley
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Html\Fields;

use Psource\SiteReviews\Html\Fields\Base;

class Radio extends Base
{
	protected $multi = true;
	protected $element = 'input';

	/**
	 * @return string
	 */
	public function render( array $defaults = [] )
	{
		$default = isset( $defaults['default'] )
			? $defaults['default']
			: null;
		$inline = $this->args['inline'] ? ' class="inline"' : '';
		return sprintf( '<ul%s>%s</ul>%s',
			$inline,
			$this->implodeOptions( 'multi_input', $default ),
			$this->generateDescription()
		);
	}
}
