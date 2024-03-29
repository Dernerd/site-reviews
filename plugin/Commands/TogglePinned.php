<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Commands;

class TogglePinned
{
	public $id;
	public $pinned;

	public function __construct( $input )
	{
		$pinned = isset( $input['pinned'] )
			? wp_validate_boolean( $input['pinned'] )
			: null;

		$this->id     = $input['id'];
		$this->pinned = $pinned;
	}
}
