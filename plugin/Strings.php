<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews;

class Strings
{
	/**
	 * @param string|null $key
	 * @param string      $fallback
	 *
	 * @return array|string
	 */
	public function post_type_labels( $key = null, $fallback = ''  )
	{
		return $this->result( $key, $fallback, [
			'add_new_item'          => __( 'Neue Bewertung hinzufügen', 'site-reviews' ),
			'all_items'             => __( 'Alle Bewertungen', 'site-reviews' ),
			'archives'              => __( 'Bewertungsarchiv', 'site-reviews' ),
			'edit_item'             => __( 'Bewertung bearbeiten', 'site-reviews' ),
			'insert_into_item'      => __( 'In Rezension einfügen', 'site-reviews' ),
			'new_item'              => __( 'Neue Bewertung', 'site-reviews' ),
			'not_found'             => __( 'Keine Bewertungen gefunden', 'site-reviews' ),
			'not_found_in_trash'    => __( 'Keine Bewertungen gefunden in Papierkorb', 'site-reviews' ),
			'search_items'          => __( 'Bewertungen suchen', 'site-reviews' ),
			'uploaded_to_this_item' => __( 'Zu dieser Bewertung hochgeladen', 'site-reviews' ),
			'view_item'             => __( 'Bewertung ansehen', 'site-reviews' ),
		]);
	}

	/**
	 * @param string|null $key
	 * @param string      $fallback
	 *
	 * @return array|string
	 */
	public function post_updated_messages( $key = null, $fallback = ''  )
	{
		return $this->result( $key, $fallback, [
			'approved'      => __( 'Die Bewertung wurde genehmigt und veröffentlicht.', 'site-reviews' ),
			'draft_updated' => __( 'Bewertungsentwurf aktualisiert.', 'site-reviews' ),
			'preview'       => __( 'Bewertungsvorschau', 'site-reviews' ),
			'published'     => __( 'Bewertung genehmigt und veröffentlicht.', 'site-reviews' ),
			'restored'      => __( 'Bewertung in Revision von %s wiederhergestellt.', 'site-reviews' ),
			'reverted'      => __( 'Die Bewertung wurde auf den ursprünglichen Einreichungsstatus zurückgesetzt.', 'site-reviews' ),
			'saved'         => __( 'Bewertung gespeichert.', 'site-reviews' ),
			'scheduled'     => __( 'Bewertung geplant für: %s.', 'site-reviews' ),
			'submitted'     => __( 'Bewertung eingereicht.', 'site-reviews' ),
			'unapproved'    => __( 'Die Bewertung wurde nicht genehmigt und steht nun aus.', 'site-reviews' ),
			'updated'       => __( 'Bewertung aktualisiert.', 'site-reviews' ),
			'view'          => __( 'Bewertung ansehen', 'site-reviews' ),
		]);
	}

	/**
	 * @param string|null $key
	 * @param string      $fallback
	 *
	 * @return array|string
	 *
	 * @since 2.0.0
	 */
	public function review_types( $key = null, $fallback = ''  )
	{
		return $this->result( $key, $fallback, apply_filters( 'site-reviews/addon/types', [
			'local' => __( 'Lokal', 'site-reviews' ),
		]));
	}

	/**
	 * @param string|null $key
	 * @param string      $fallback
	 *
	 * @return array|string
	 */
	public function validation( $key = null, $fallback = '' )
	{
		return $this->result( $key, $fallback, [
			'accepted'        => _x( 'Das :attribute muss akzeptiert werden.', ':attribute ist ein Platzhalter und sollte nicht übersetzt werden.', 'site-reviews' ),
			'between.numeric' => _x( 'Das :attribute muss zwischen: min und: max liegen.', ':attribute, :min und :max sind Platzhalter und sollten nicht übersetzt werden.', 'site-reviews' ),
			'between.string'  => _x( 'Das :attribute muss zwischen :min und :max Zeichen liegen.', ':attribute, :min, und :max sind Platzhalter und sollten nicht übersetzt werden.', 'site-reviews' ),
			'email'           => _x( 'Das :attribute muss eine gültige E-Mail-Adresse sein.', ':attribute ist ein Platzhalter und sollte nicht übersetzt werden.', 'site-reviews' ),
			'max.numeric'     => _x( 'Das :attribute darf nicht größer sein als :max.', ':attribute und :max sind Platzhalter und sollten nicht übersetzt werden.', 'site-reviews' ),
			'max.string'      => _x( 'Das :attribute darf nicht größer als :max Zeichen sein.', ':attribute und :max sind Platzhalter und sollten nicht übersetzt werden.', 'site-reviews' ),
			'min.numeric'     => _x( 'Das :attribute muss mindestens :min sein.', ':attribute und :min sind Platzhalter und sollten nicht übersetzt werden.', 'site-reviews' ),
			'min.string'      => _x( 'Das :attribute muss mindestens :min Zeichen enthalten.', ':attribute und :min sind Platzhalter und sollten nicht übersetzt werden.', 'site-reviews' ),
			'regex'           => _x( 'Das :attribute Format ist ungültig.', ':attribute ist ein Platzhalter und sollte nicht übersetzt werden.', 'site-reviews' ),
			'required'        => _x( 'Das :attribute Feld ist erforderlich.', ':attribute ist ein Platzhalter und sollte nicht übersetzt werden.', 'site-reviews' ),
		]);
	}

	/**
	 * @param string|null $key
	 * @param string      $fallback
	 *
	 * @return array|string
	 *
	 * @since 2.0.0
	 */
	protected function result( $key, $fallback, array $values )
	{
		if( is_string( $key )) {
			return isset( $values[ $key ] )
				? $values[ $key ]
				: $fallback;
		}

		return $values;
	}
}
