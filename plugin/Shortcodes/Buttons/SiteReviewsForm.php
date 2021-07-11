<?php

/**
 * Site Reviews Form shortcode button
 *
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     2.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Shortcodes\Buttons;

use Psource\SiteReviews\Shortcodes\Buttons\Generator;

class SiteReviewsForm extends Generator
{
	/**
	 * @return array
	 */
	public function fields()
	{
		$terms = glsr_resolve( 'Database' )->getTerms();

		if( !empty( $terms )) {
			$category = [
				'type'    => 'listbox',
				'name'    => 'category',
				'label'   => esc_html__( 'Kategorie', 'site-reviews' ),
				'options' => $terms,
				'tooltip' => __( 'Weise Bewertungen, die mit diesem Shortcode eingereicht wurden, automatisch eine Kategorie zu.', 'site-reviews' ),
			];
		}

		return [
			[
				'type' => 'container',
				'html' => sprintf( '<p class="strong">%s</p>', esc_html__( 'Alle Einstellungen sind optional.', 'site-reviews' )),
			],[
				'type'    => 'textbox',
				'name'    => 'title',
				'label'   => esc_html__( 'Titel', 'site-reviews' ),
				'tooltip' => __( 'Gib eine benutzerdefinierte Shortcode-Überschrift ein.', 'site-reviews' ),
			],[
				'type'    => 'textbox',
				'name'    => 'description',
				'label'   => esc_html__( 'Beschreibung', 'site-reviews' ),
				'tooltip' => __( 'Gib eine benutzerdefinierte Shortcode-Beschreibung ein.', 'site-reviews' ),
				'minWidth' => 240,
				'minHeight' => 60,
				'multiline' => true,
			],
			( isset( $category ) ? $category : [] ),
			[
				'type'      => 'textbox',
				'name'      => 'assign_to',
				'label'     => esc_html__( 'Beitrags-ID', 'site-reviews' ),
				'tooltip'   => __( 'Weise eingereichte Bewertungen einer benutzerdefinierten Seiten-/Beitrags-ID zu. Du kannst auch "post_id" eingeben, um Bewertungen der ID der aktuellen Seite zuzuordnen.', 'site-reviews' ),
			],[
				'type'     => 'textbox',
				'name'     => 'class',
				'label'    => esc_html__( 'Klassen', 'site-reviews' ),
				'tooltip'  => __( 'Benutzerdefinierte CSS-Klassen zum Shortcode hinzufügen.', 'site-reviews' ),
			],[
				'type'    => 'container',
				'label'   => esc_html__( 'Ausblenden', 'site-reviews' ),
				'layout'  => 'grid',
				'columns' => 2,
				'spacing' => 5,
				'items'   => [
					[
						'type' => 'checkbox',
						'name' => 'hide_email',
						'text' => esc_html__( 'Email', 'site-reviews' ),
						'tooltip' => __( 'E-Mail-Feld ausblenden?', 'site-reviews' ),
					],[
						'type' => 'checkbox',
						'name' => 'hide_name',
						'text' => esc_html__( 'Name', 'site-reviews' ),
						'tooltip' => __( 'Namensfeld ausblenden?', 'site-reviews' ),
					],[
						'type' => 'checkbox',
						'name' => 'hide_terms',
						'text' => esc_html__( 'Bedingungen', 'site-reviews' ),
						'tooltip' => __( 'Bedingungssfeld ausblenden?', 'site-reviews' ),
					],[
						'type' => 'checkbox',
						'name' => 'hide_title',
						'text' => esc_html__( 'Titel', 'site-reviews' ),
						'tooltip' => __( 'Titelfeld ausblenden?', 'site-reviews' ),
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
