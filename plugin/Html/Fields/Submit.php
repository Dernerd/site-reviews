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

class Submit extends Text
{
	/**
	 * @return string
	 */
	public function render( array $defaults = [] )
	{
		unset( $this->args['name'] );
		return parent::render( wp_parse_args( $defaults, [
			'class' => 'button button-primary',
			'type' => 'submit',
		])) . $this->recaptcha();
	}

	/**
	 * @return void|string
	 */
	protected function recaptcha()
	{
		$integration = glsr_get_option( 'reviews-form.recaptcha.integration' );
		if( $integration == 'custom' ) {
			return sprintf( '<div class="glsr-recaptcha-holder" data-sitekey="%s" data-badge="%s" data-size="invisible"></div>',
				sanitize_text_field( glsr_get_option( 'reviews-form.recaptcha.key' )),
				sanitize_text_field( glsr_get_option( 'reviews-form.recaptcha.position' ))
			);
		}
		if( $integration == 'invisible-recaptcha' ) {
			ob_start();
			do_action( 'google_invre_render_widget_action' );
			$html = ob_get_clean();
			return sprintf( '<div class="glsr-recaptcha-holder">%s</div>', $html );
		}
	}
}
