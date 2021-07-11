<?php

/**
 * Site Reviews Summary shortcode button
 *
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     2.3.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Shortcodes\Buttons;

use Psource\SiteReviews\Shortcodes\Buttons\Generator;

class SiteReviewsSummary extends Generator
{
	/**
	 * @return array
	 */
	public function fields()
	{
		$types = glsr_resolve( 'Database' )->getReviewTypes();
		$terms = glsr_resolve( 'Database' )->getTerms();

		if( count( $types ) > 1 ) {
			$display = [
				'type' => 'listbox',
				'name' => 'display',
				'label' => esc_html__( 'Anzeige', 'site-reviews' ),
				'options' => $types,
				'tooltip' => __( 'Welche Bewertungen möchtest Du anzeigen?', 'site-reviews' ),
			];
		}
		if( !empty( $terms )) {
			$category = [
				'type' => 'listbox',
				'name' => 'category',
				'label' => esc_html__( 'Kategorie', 'site-reviews' ),
				'options' => $terms,
				'tooltip' => __( 'Bewertungen auf diese Kategorie beschränken.', 'site-reviews' ),
			];
		}
		return [
			[
				'type' => 'container',
				'html' => sprintf( '<p class="strong">%s</p>', esc_html__( 'Alle Einstellungen sind optional.', 'site-reviews' )),
				'minWidth' => 320,
			],[
				'type' => 'textbox',
				'name' => 'title',
				'label' => esc_html__( 'Titel', 'site-reviews' ),
				'tooltip' => __( 'Gib eine benutzerdefinierte Shortcode-Überschrift ein.', 'site-reviews' ),
			],[
				'type' => 'textbox',
				'name' => 'labels',
				'label' => esc_html__( 'Labels', 'site-reviews' ),
				'tooltip' => __( 'Gib benutzerdefinierte Labels für die Bewertungsstufen von 1 bis 5 Sternen (von hoch bis niedrig) ein und trenne sie durch ein Komma. Die Standardbezeichnungen sind: "Ausgezeichnet, Sehr gut, Durchschnittlich, Schlecht, Schrecklich".', 'site-reviews' ),
			],[
				'type' => 'listbox',
				'name' => 'rating',
				'label' => esc_html__( 'Bewertung', 'site-reviews' ),
				'options' => [
					'5' => esc_html( sprintf( _n( '%s Stern', '%s Sterne', 5, 'site-reviews' ), 5 )),
					'4' => esc_html( sprintf( _n( '%s Stern', '%s Sterne', 4, 'site-reviews' ), 4 )),
					'3' => esc_html( sprintf( _n( '%s Stern', '%s Sterne', 3, 'site-reviews' ), 3 )),
					'2' => esc_html( sprintf( _n( '%s Stern', '%s Sterne', 2, 'site-reviews' ), 2 )),
					'1' => esc_html( sprintf( _n( '%s Stern', '%s Sterne', 1, 'site-reviews' ), 1 )),
				],
				'tooltip' => __( 'Was ist die Mindestbewertung? (Standard: 1 Stern)', 'site-reviews' ),
			],
			( isset( $display ) ? $display : [] ),
			( isset( $category ) ? $category : [] ),
			[
				'type' => 'textbox',
				'name' => 'assigned_to',
				'label' => esc_html__( 'Beitrags-ID', 'site-reviews' ),
				'tooltip' => __( "Beschränke die Bewertungen auf diejenigen, die dieser Beitrags-ID zugewiesen sind (trenne mehrere IDs durch ein Komma). Du kannst auch 'post_id' eingeben, um die ID der aktuellen Seite zu verwenden.", 'site-reviews' ),
			],[
				'type' => 'listbox',
				'name' => 'schema',
				'label' => esc_html__( 'Schema', 'site-reviews' ),
				'options' => [
					'true' => esc_html__( 'Rich Snippets aktivieren', 'site-reviews' ),
					'false' => esc_html__( 'Rich Snippets deaktivieren', 'site-reviews' ),
				],
				'tooltip' => __( 'Rich Snippets sind standardmäßig deaktiviert.', 'site-reviews' ),
			],[
				'type' => 'textbox',
				'name' => 'class',
				'label' => esc_html__( 'Klassen', 'site-reviews' ),
				'tooltip' => __( 'Benutzerdefinierte CSS-Klassen zum Shortcode hinzufügen.', 'site-reviews' ),
			],[
				'type' => 'container',
				'label' => esc_html__( 'Ausblenden', 'site-reviews' ),
				'layout' => 'grid',
				'columns' => 2,
				'spacing' => 5,
				'items' => [
					[
						'type' => 'checkbox',
						'name' => 'hide_bars',
						'text' => esc_html__( 'Bars', 'site-reviews' ),
						'tooltip' => esc_attr__( 'Prozentbalken ausblenden?', 'site-reviews' ),
					],[
						'type' => 'checkbox',
						'name' => 'hide_rating',
						'text' => esc_html__( 'Bewertung', 'site-reviews' ),
						'tooltip' => esc_attr__( 'Bewertung ausblenden?', 'site-reviews' ),
					],[
						'type' => 'checkbox',
						'name' => 'hide_stars',
						'text' => esc_html__( 'Sterne', 'site-reviews' ),
						'tooltip' => esc_attr__( 'Die Sterne verstecken?', 'site-reviews' ),
					],[
						'type' => 'checkbox',
						'name' => 'hide_summary',
						'text' => esc_html__( 'Zusammenfassung', 'site-reviews' ),
						'tooltip' => esc_attr__( 'Zusammenfassungstext ausblenden?', 'site-reviews' ),
					],
				],
			],
		];
	}
}
