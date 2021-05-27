<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2017, Paul Ryley
 * @license   GPLv3
 * @since     2.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Commands;

class RegisterTaxonomy
{
	public $args;

	public function __construct( $input )
	{
		$this->args = $input;
	}
}
