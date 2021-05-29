<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Commands;

class RegisterPointers
{
	public $pointers;

	public function __construct( $input )
	{
		$this->pointers = $input;
	}
}
