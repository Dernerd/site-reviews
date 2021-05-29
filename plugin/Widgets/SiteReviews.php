<?php

/**
 * Site Reviews widget
 *
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Widgets;

use Psource\SiteReviews\Traits\SiteReviews as Common;
use Psource\SiteReviews\Widget;

class SiteReviews extends Widget
{
	use Common;

	/**
	 * Display the widget form
	 *
	 * @param array $instance
	 * @return void
	 */
	public function form( $instance )
	{
		$args = $this->normalize( $instance );
		$types = glsr_resolve( 'Database' )->getReviewTypes();
		$terms = glsr_resolve( 'Database' )->getTerms();

		$this->create_field([
			'type'  => 'text',
			'name'  => 'title',
			'label' => __( 'Titel', 'site-reviews' ),
			'value' => $args['title'],
		]);

		$this->create_field([
			'type'    => 'number',
			'name'    => 'count',
			'label'   => __( 'Wie viele Bewertungen möchtest Du anzeigen? ', 'site-reviews' ),
			'value'   => $args['count'],
			'default' => 5,
			'max'     => 100,
		]);

		$this->create_field([
			'type'  => 'select',
			'name'  => 'rating',
			'label' => __( 'Was ist die Mindestbewertung, die angezeigt werden soll? ', 'site-reviews' ),
			'value' => $args['rating'],
			'options' => [
				'5' => sprintf( _n( '%s Stern', '%s Sterne', 5, 'site-reviews' ), 5 ),
				'4' => sprintf( _n( '%s Stern', '%s Sterne', 4, 'site-reviews' ), 4 ),
				'3' => sprintf( _n( '%s Stern', '%s Sterne', 3, 'site-reviews' ), 3 ),
				'2' => sprintf( _n( '%s Stern', '%s Sterne', 2, 'site-reviews' ), 2 ),
				'1' => sprintf( _n( '%s Stern', '%s Sterne', 1, 'site-reviews' ), 1 ),
			],
		]);

		if( count( $types ) > 1 ) {
			$this->create_field([
				'type'  => 'select',
				'name'  => 'display',
				'label' => __( 'Welche Bewertungen möchtest Du anzeigen? ', 'site-reviews' ),
				'class' => 'widefat',
				'value' => $args['display'],
				'options' => ['' => __( 'Alle Bewertungen', 'site-reviews' ) ] + $types,
			]);
		}

		if( !empty( $terms )) {
			$this->create_field([
				'type'  => 'select',
				'name'  => 'category',
				'label' => __( 'Beschränke Bewertungen auf diese Kategorie', 'site-reviews' ),
				'class' => 'widefat',
				'value' => $args['category'],
				'options' => ['' => __( 'Alle Kategorien', 'site-reviews' ) ] + glsr_resolve( 'Database' )->getTerms(),
			]);
		}

		$this->create_field([
			'type'    => 'text',
			'name'    => 'assigned_to',
			'label'   => __( 'Beschränke die Bewertungen auf diejenigen, die dieser Seiten-/Beitrags-ID zugewiesen sind', 'site-reviews' ),
			'value'   => $args['assigned_to'],
			'default' => '',
			'placeholder' => __( "Trenne mehrere IDs durch ein Komma", 'site-reviews' ),
			'description' => sprintf( __( 'Du kannst auch %s eingeben, um die zugewiesenen Bewertungen auf die aktuelle Seite zu beschränken.', 'site-reviews' ), '<code>post_id</code>' ),
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
				'author' => __( 'Review-Autor ausblenden?', 'site-reviews' ),
				'date' => __( 'Bewertungssdatum ausblenden?', 'site-reviews' ),
				'excerpt' => __( 'Bewertungsauszug ausblenden?', 'site-reviews' ),
				'rating' => __( 'Bewertungswertung ausblenden?', 'site-reviews' ),
				'response' => __( 'Bewertungsantwort ausblenden?', 'site-reviews' ),
				'title' => __( 'Bewertungstitel ausblenden?', 'site-reviews' ),
			],
		]);
	}

	/**
	 * Update the widget form
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance )
	{
		if( $new_instance['count'] < 0 ) {
			$new_instance['count'] = 0;
		}
		if( $new_instance['count'] > 100 ) {
			$new_instance['count'] = 100;
		}
		if( !is_numeric( $new_instance['count'] )) {
			$new_instance['count'] = 5;
		}
		return parent::update( $new_instance, $old_instance );
	}

	/**
	 * Display the widget Html
	 *
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget( $args, $instance )
	{
		$instance = $this->normalize( $instance );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		if( $instance['assigned_to'] == 'post_id' ) {
			$instance['assigned_to'] = intval( get_the_ID() );
		}

		echo $args['before_widget'];
		if( !empty( $title )) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		$this->renderReviews( $instance );
		echo $args['after_widget'];
	}
}
