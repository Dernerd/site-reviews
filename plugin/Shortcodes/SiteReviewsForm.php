<?php

/**
 * Site Reviews Form shortcode
 *
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2016, Paul Ryley
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Shortcodes;

use Psource\SiteReviews\Shortcode;
use Psource\SiteReviews\Traits\SiteReviewsForm as Common;

class SiteReviewsForm extends Shortcode
{
	use Common;

	/**
	 * @var bool|string
	 */
	public $id = false;

	/**
	 * @return null|string
	 */
	public function printShortcode( $atts = [] )
	{
		$args = $this->normalize( $atts );
		if( $args['assign_to'] == 'post_id' ) {
			$args['assign_to'] = intval( get_the_ID() );
		}
		ob_start();
		echo '<div class="shortcode-reviews-form">';
		if( !empty( $args['title'] )) {
			printf( '<h3 class="glsr-shortcode-title">%s</h3>', $args['title'] );
		}
		if( !$this->renderRequireLogin() ) {
			echo $this->renderForm( $args );
		}
		echo '</div>';
		return ob_get_clean();
	}
}
