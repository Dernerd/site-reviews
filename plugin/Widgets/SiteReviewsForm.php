<?php

/**
 * Site Reviews Form widget
 *
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2016, Paul Ryley
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Widgets;

use Psource\SiteReviews\Traits\SiteReviewsForm as Common;
use Psource\SiteReviews\Widget;

class SiteReviewsForm extends Widget
{
	use Common;

	/**
	 * Display the widget form
	 *
	 * @param array $instance
	 *
	 * @return void
	 */
	public function form( $instance )
	{
		$args = $this->normalize( $instance, [
			'description' => sprintf( __( 'Deine Email-Adresse wird nicht veröffentlicht. Erforderliche Felder sind mit %s*%s gekennzeichnet', 'site-reviews' ), '<span>', '</span>' ),
		]);

		$this->create_field([
			'type'  => 'text',
			'name'  => 'title',
			'label' => __( 'Titel', 'site-reviews' ),
			'value' => $args['title'],
		]);

		$this->create_field([
			'type'  => 'textarea',
			'name'  => 'description',
			'class' => 'widefat',
			'label' => __( 'Beschreibung', 'site-reviews' ),
			'value' => $args['description'],
		]);

		$this->create_field([
			'type'  => 'select',
			'name'  => 'category',
			'label' => __( 'Ordne automatisch eine Kategorie zu', 'site-reviews' ),
			'value' => $args['category'],
			'options' => ['' => __( 'Ordne keine Kategorie zu', 'site-reviews' ) ] + glsr_resolve( 'Database' )->getTerms(),
			'class' => 'widefat',
		]);

		$this->create_field([
			'type'    => 'text',
			'name'    => 'assign_to',
			'label'   => __( 'Weise einer benutzerdefinierten Seite/Post-ID Bewertungen zu', 'site-reviews' ),
			'value'   => $args['assign_to'],
			'default' => '',
			'description' => sprintf( __( 'Du kannst auch %s eingeben, um den aktuellen Beitrag zuzuweisen.', 'site-reviews' ), '<code>post_id</code>' ),
		]);

		$this->create_field([
			'type'  => 'text',
			'name'  => 'class',
			'label' => __( 'Gib hier benutzerdefinierte CSS-Klassen ein', 'site-reviews' ),
			'value' => $args['class'],
		]);

		$this->create_field([
			'type'  => 'checkbox',
			'name'  => 'hide',
			'value' => $args['hide'],
			'options' => [
				'email' => __( 'Blende das E-Mail-Feld aus', 'site-reviews' ),
				'name'  => __( 'Blende das Namensfeld aus', 'site-reviews' ),
				'terms' => __( 'Blende das Begriffsfeld aus', 'site-reviews' ),
				'title' => __( 'Blende das Titelfeld aus', 'site-reviews' ),
			],
		]);
	}

	/**
	 * Display the widget Html
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @return void
	 */
	public function widget( $args, $instance )
	{
		$instance = $this->normalize( $instance );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		if( $instance['assign_to'] == 'post_id' ) {
			$instance['assign_to'] = intval( get_the_ID() );
		}

		echo $args['before_widget'];
		if( !empty( $title )) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		if( !$this->renderRequireLogin() ) {
			echo $this->renderForm( $instance );
		}
		echo $args['after_widget'];
	}
}
