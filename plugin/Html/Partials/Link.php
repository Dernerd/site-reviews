<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Html\Partials;

use Psource\SiteReviews\Html\Partials\Base;

class Link extends Base
{
	/**
	 * Generate a link
	 *
	 * @return string|null
	 */
	public function render()
	{
		$args = shortcode_atts( ['post_id' => ''], $this->args );
		$post = get_post( $args['post_id'] );
		return isset( $post->ID ) && $post->ID == $args['post_id'] && $post->post_status == 'publish'
			? sprintf( '<a href="%s">%s</a>', (string) get_the_permalink( $post->ID ), get_the_title( $post->ID ))
			: '';
	}
}
