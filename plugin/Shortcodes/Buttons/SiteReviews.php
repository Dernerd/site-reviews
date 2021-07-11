<?php

/**
 * Site Reviews shortcode button
 *
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     2.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Shortcodes\Buttons;

use Psource\SiteReviews\Shortcodes\Buttons\Generator;

class SiteReviews extends Generator
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
				'type'    => 'listbox',
				'name'    => 'display',
				'label'   => esc_html__( 'Anzeige', 'site-reviews' ),
				'options' => $types,
				'tooltip' => __( 'Welche Bewertungen möchtest Du anzeigen?', 'site-reviews' ),
			];
		}

		if( !empty( $terms )) {
			$category = [
				'type'    => 'listbox',
				'name'    => 'category',
				'label'   => esc_html__( 'Kategorie', 'site-reviews' ),
				'options' => $terms,
				'tooltip' => __( 'Beschränke Bewertungen auf diese Kategorie.', 'site-reviews' ),
			];
		}

		return [
			[
				'type' => 'container',
				'html' => sprintf( '<p class="strong">%s</p>', esc_html__( 'Alle Einstellungen sind optional.', 'site-reviews' )),
				'minWidth' => 320,
			],[
				'type'     => 'textbox',
				'name'     => 'title',
				'label'    => esc_html__( 'Titel', 'site-reviews' ),
				'tooltip'  => __( 'Gib eine benutzerdefinierte Shortcode-Überschrift ein.', 'site-reviews' ),
			],[
				'type'      => 'textbox',
				'name'      => 'count',
				'maxLength' => 5,
				'size'      => 3,
				'text'      => '10',
				'label'     => esc_html__( 'Zähler', 'site-reviews' ),
				'tooltip'   => __( 'Wie viele Bewertungen möchtest Du anzeigen (Standard: 10)?', 'site-reviews' ),
			],[
				'type'    => 'listbox',
				'name'    => 'rating',
				'label'   => esc_html__( 'Bewertung', 'site-reviews' ),
				'options' => [
					'5' => esc_html__( '5 Sterne', 'site-reviews' ),
					'4' => esc_html__( '4 Sterne', 'site-reviews' ),
					'3' => esc_html__( '3 Sterne', 'site-reviews' ),
					'2' => esc_html__( '2 Sterne', 'site-reviews' ),
					'1' => esc_html__( '1 Stern', 'site-reviews' ),
				],
				'tooltip' => __( 'Was ist die Mindestbewertung (Standard: 1 Stern)?', 'site-reviews' ),
			],[
				'type'    => 'listbox',
				'name'    => 'pagination',
				'label'   => esc_html__( 'Pagination', 'site-reviews' ),
				'options' => [
					'true'  => esc_html__( 'Aktivieren', 'site-reviews' ),
					'ajax' => esc_html__( 'Aktivieren (mit Ajax)', 'site-reviews' ),
					'false' => esc_html__( 'Deaktivieren', 'site-reviews' ),
				],
				'tooltip' => __( 'Bei Verwendung der Paginierung kann dieser Shortcode nur einmal auf einer Seite verwendet werden. (Standard: Deaktivieren)', 'site-reviews' ),
			],
			( isset( $display ) ? $display : [] ),
			( isset( $category ) ? $category : [] ),
			[
				'type'      => 'textbox',
				'name'      => 'assigned_to',
				'label'     => esc_html__( 'Post ID', 'site-reviews' ),
				'tooltip'   => __( 'Beschränke die Überprüfungen auf diejenigen, die dieser Beitrags-ID zugewiesen sind (trenne mehrere IDs durch ein Komma). Du kannst auch "post_id" eingeben, um die ID der aktuellen Seite zu verwenden.', 'site-reviews' ),
			],[
				'type' => 'listbox',
				'name' => 'schema',
				'label' => esc_html__( 'Schema', 'site-reviews' ),
				'options' => [
					'true' => esc_html__( 'Aktiviere Rich Snippets', 'site-reviews' ),
					'false' => esc_html__( 'Deaktiviere Rich Snippets', 'site-reviews' ),
				],
				'tooltip' => __( 'Rich Snippets sind standardmäßig deaktiviert.', 'site-reviews' ),
			],[
				'type'     => 'textbox',
				'name'     => 'class',
				'label'    => esc_html__( 'Klassen', 'site-reviews' ),
				'tooltip'  => __( 'Füge dem Shortcode benutzerdefinierte CSS-Klassen hinzu.', 'site-reviews' ),
			],[
				'type'    => 'container',
				'label'   => esc_html__( 'Ausblenden', 'site-reviews' ),
				'layout'  => 'grid',
				'columns' => 2,
				'spacing' => 5,
				'items'   => [
					[
						'type' => 'checkbox',
						'name' => 'hide_author',
						'text' => esc_html__( 'Autor', 'site-reviews' ),
						'tooltip' => __( 'Den Bewertungs-Autor ausblenden?', 'site-reviews' ),
					],[
						'type' => 'checkbox',
						'name' => 'hide_date',
						'text' => esc_html__( 'Datum', 'site-reviews' ),
						'tooltip' => __( 'Bewertungsdatum ausblenden?', 'site-reviews' ),
					],[
						'type' => 'checkbox',
						'name' => 'hide_excerpt',
						'text' => esc_html__( 'Auszug', 'site-reviews' ),
						'tooltip' => __( 'Bewertungsauszug ausblenden?', 'site-reviews' ),
					],[
						'type' => 'checkbox',
						'name' => 'hide_rating',
						'text' => esc_html__( 'Bewertung', 'site-reviews' ),
						'tooltip' => __( 'Bewertungswertung ausblenden?', 'site-reviews' ),
					],[
						'type' => 'checkbox',
						'name' => 'hide_response',
						'text' => esc_html__( 'Antwort', 'site-reviews' ),
						'tooltip' => __( 'Antwort der Bewertung ausblenden?', 'site-reviews' ),
					],[
						'type' => 'checkbox',
						'name' => 'hide_title',
						'text' => esc_html__( 'Titel', 'site-reviews' ),
						'tooltip' => __( 'Bewertungstitel ausblenden?', 'site-reviews' ),
					],
				],
			],[
				'type'   => 'textbox',
				'name'   => 'id',
				'hidden' => true,
			],
		];
	}
}
