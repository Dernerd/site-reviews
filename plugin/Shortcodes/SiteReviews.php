<?php

/**
 * Site Reviews shortcode
 *
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Shortcodes;

use Psource\SiteReviews\Shortcode;
use Psource\SiteReviews\Traits\SiteReviews as Common;

class SiteReviews extends Shortcode
{
	use Common;

	/**
	 * @return string
	 */
	public function printShortcode( $atts = [] )
	{
		$args = $this->normalize( $atts, [
			'count' => 10,
			'display' => 'all',
			'offset' => '',
			'pagination' => false,
			'schema' => false,
		]);
		if( $args['assigned_to'] == 'post_id' ) {
			$args['assigned_to'] = intval( get_the_ID() );
		}
		ob_start();
		echo '<div class="shortcode-site-reviews">';
		if( !empty( $args['title'] )) {
			printf( '<h3 class="glsr-shortcode-title">%s</h3>', $args['title'] );
		}
		$this->renderReviews( $args );
		echo '</div>';
		return ob_get_clean();
	}
}
