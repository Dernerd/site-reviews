<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews;

use Psource\SiteReviews\App;
use Psource\SiteReviews\Html;
use Psource\SiteReviews\Translator;
use ReflectionClass;
use ReflectionMethod;

class Settings
{
	/**
	 * @var App
	 */
	protected $app;

	/**
	 * @var Html
	 */
	protected $html;

	/**
	 * @var array
	 */
	protected $settings;

	public function __construct( App $app, Html $html )
	{
		$this->app      = $app;
		$this->html     = $html;
		$this->settings = [];
	}

	/**
	 * Add a setting default
	 *
	 * @param string $formId
	 *
	 * @return void
	 */
	public function addSetting( $formId, array $args )
	{
		$args = $this->normalizePaths( $formId, $args );

		if( isset( $args['name'] )) {
			$this->settings[ $args['name']] = $this->getDefault( $args );
		}

		$this->html->addfield( $formId, $args );
	}

	/**
	 * Get the default field value
	 *
	 * @return string
	 */
	public function getDefault( array $args )
	{
		isset( $args['default'] ) ?: $args['default'] = '';
		isset( $args['placeholder'] ) ?: $args['placeholder'] = '';

		if( $args['default'] === ':placeholder' ) {
			$args['default'] = $args['placeholder'];
		}

		if( strpos( $args['type'], 'yesno' ) !== false && empty( $args['default'] )) {
			$args['default'] = 'no';
		}

		return $args['default'];
	}

	/**
	 * Get the default settings
	 *
	 * @return array
	 */
	public function getSettings()
	{
		$this->register();

		return $this->settings;
	}

	/**
	 * @param string $path
	 * @param string $prefix
	 *
	 * @return string
	 */
	public function normalizePath( $path, $prefix )
	{
		return substr( $path, 0, strlen( $prefix )) != $prefix
			? sprintf( '%s.%s', $prefix, $path )
			: $path;
	}

	/**
	 * @param string $formId
	 *
	 * @return array
	 */
	public function normalizePaths( $formId, array $args )
	{
		$prefix = strtolower( str_replace( '/', '.', $formId ));

		if( isset( $args['name'] ) && is_string( $args['name'] )) {
			$args['name'] = $this->normalizePath( $args['name'], $prefix );
		}

		if( isset( $args['depends'] ) && is_array( $args['depends'] )) {
			$depends = [];
			foreach( $args['depends'] as $path => $value ) {
				$depends[ $this->normalizePath( $path, $prefix ) ] = $value;
			}
			$args['depends'] = $depends;
		}

		return $args;
	}

	/**
	 * Register the settings for each form
	 *
	 * @return void
	 *
	 * @action admin_init
	 */
	public function register()
	{
		if( !empty( $this->settings ))return;

		$methods = (new ReflectionClass( __CLASS__ ))->getMethods( ReflectionMethod::IS_PROTECTED );

		foreach( $methods as $method ) {
			if( substr( $method->name, 0, 3 ) === 'set' ) {
				$this->{$method->name}();
			}
		}
	}

	/**
	 * @return void
	 */
	protected function setGeneral()
	{
		$formId = 'settings/general';

		$this->html->createForm( $formId, [
			'action' => admin_url( 'options.php' ),
			'nonce'  => $this->app->id . '-settings',
			'submit' => __( 'Einstellungen speichern', 'site-reviews' ),
		]);

		$this->addSetting( $formId, [
			'type'    => 'yesno_inline',
			'name'    => 'require.approval',
			'label'   => __( 'Genehmigung erforderlich', 'site-reviews' ),
			'default' => 'yes',
			'desc'    => __( 'Setze den Status neuer Überprüfungseinreichungen auf ausstehend.', 'site-reviews' ),
		]);

		$this->addSetting( $formId, [
			'type'  => 'yesno_inline',
			'name'  => 'require.login',
			'label' => __( 'Anmeldung erforderlich', 'site-reviews' ),
			'desc'  => __( 'Erlaube nur Bewertungsbeiträge von registrierten Benutzern.', 'site-reviews' ),
		]);

		$this->addSetting( $formId, [
			'type'    => 'yesno_inline',
			'name'    => 'require.login_register',
			'label'   => __( 'Registrierungslink anzeigen', 'site-reviews' ),
			'depends' => [
				'require.login' => 'yes',
			],
			'desc' => sprintf( __( 'Zeige einen Link für einen neuen Benutzer an, um sich zu registrieren. Die Option %s Mitgliedschaft muss in den allgemeinen Einstellungen aktiviert sein, damit dies funktioniert.', 'site-reviews' ),
				sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php' ), __( 'Jeder kann sich registrieren', 'site-reviews' ))
			),
		]);

		$this->addSetting( $formId, [
			'type'    => 'radio',
			'name'    => 'notification',
			'label'   => __( 'Benachrichtigungen', 'site-reviews' ),
			'default' => 'none',
			'options' => [
				'none'    => __( 'Keine Bewertungsbenachrichtigungen senden', 'site-reviews' ),
				'default' => __( 'An Administrator senden', 'site-reviews' ) . sprintf( ' <code>%s</code>', (string) get_option( 'admin_email' )),
				'custom'  => __( 'An eine oder mehrere E-Mail-Adressen senden', 'site-reviews' ),
				'webhook' => sprintf( __( 'Senden an %s', 'site-reviews' ), '<a href="https://slack.com/">Slack</a>' ),
			],
		]);

		$this->addSetting( $formId, [
			'type'    => 'text',
			'name'    => 'notification_email',
			'label'   => __( 'Benachrichtigungs-E-Mails senden an', 'site-reviews' ),
			'depends' => [
				'notification' => 'custom',
			],
			'placeholder' => __( 'Trenne mehrere E-Mails mit einem Komma', 'site-reviews' ),
		]);

		$this->addSetting( $formId, [
			'type'    => 'url',
			'name'    => 'webhook_url',
			'label'   => __( 'Webhook URL', 'site-reviews' ),
			'depends' => [
				'notification' => 'webhook',
			],
			'desc' => sprintf( __( 'Um Benachrichtigungen an Slack zu senden, erstelle ein neues %s und füge die angegebene Webhook-URL in das Feld oben ein.', 'site-reviews' ),
				sprintf( '<a href="%s">%s</a>', esc_url( 'https://slack.com/apps/new/A0F7XDUAZ-incoming-webhooks' ), __( 'Eingehender WebHook', 'site-reviews' ))
			),
		]);

		$this->addSetting( $formId, [
			'type'    => 'code',
			'name'    => 'notification_message',
			'label'   => __( 'Benachrichtigungsvorlage', 'site-reviews' ),
			'rows'    => 10,
			'depends' => [
				'notification' => ['custom', 'default', 'webhook'],
			],
			'default' => $this->html->renderTemplate( 'email/templates/review-notification', [] ),
			'desc' => 'Um den Standardtext wiederherzustellen, speichere eine leere Vorlage.
				Wenn Du Benachrichtigungen an Slack sendest, wird diese Vorlage nur als Fallback verwendet, falls <a href="https://api.slack.com/docs/attachments">Nachrichtenanhänge</a> deaktiviert wurden.<br>
				Verfügbare Vorlagen-Tags:<br>
				<code>{review_rating}</code> - Die Bewertungsnummer (1-5)<br>
				<code>{review_title}</code> - Der Rezensionstitel<br>
				<code>{review_content}</code> - Der Inhalt der Rezension<br>
				<code>{review_author}</code> - Der Autor der Rezension<br>
				<code>{review_email}</code> - Die E-Mail des Rezensionsautors<br>
				<code>{review_ip}</code> - Die IP-Adresse des Rezensionsautors<br>
				<code>{review_link}</code> - Der Link zum Bearbeiten/Anzeigen einer Bewertung',
		]);
	}

	/**
	 * @return void
	 */
	protected function setReviews()
	{
		$formId = 'settings/reviews';

		$this->html->createForm( $formId, [
			'action' => admin_url( 'options.php' ),
			'nonce'  => $this->app->id . '-settings',
			'submit' => __( 'Einstellungen speichern', 'site-reviews' ),
		]);

		$this->addSetting( $formId, [
			'type'  => 'select',
			'name'  => 'date.format',
			'label' => __( 'Datumsformat', 'site-reviews' ),
			'options' => [
				'default' => __( 'Verwende das Standard-Datumsformat', 'site-reviews' ),
				'relative' => __( 'Verwende ein relatives Datumsformat', 'site-reviews' ),
				'custom' => __( 'Verwende ein benutzerdefiniertes Datumsformat', 'site-reviews' ),
			],
			'desc'  => sprintf( __( 'Das Standard-Datumsformat ist das in %s festgelegte.', 'site-reviews' ),
				sprintf( '<a href="%s">%s<a>', get_admin_url( null, 'options-general.php' ), __( 'Einstellungen', 'site-reviews' ))
			),
		]);

		$this->addSetting( $formId, [
			'type'    => 'text',
			'name'    => 'date.custom',
			'label'   => __( 'Benutzerdefiniertes Datumsformat', 'site-reviews' ),
			'default' => get_option( 'date_format' ),
			'desc'    => sprintf( __( 'Gib ein benutzerdefiniertes Datumsformat ein (%s).', 'site-reviews' ),
				sprintf( '<a href="https://codex.wordpress.org/Formatting_Date_and_Time">%s</a>', __( 'Dokumentation zur Datums- und Uhrzeitformatierung', 'site-reviews' ))
			),
			'depends' => [
				'date.format' => 'custom',
			],
		]);

		$this->addSetting( $formId, [
			'type'  => 'yesno_inline',
			'name'  => 'assigned_links.enabled',
			'label' => __( 'Zugewiesene Links aktivieren', 'site-reviews' ),
			'desc'  => __( 'Zeige einen Link zum zugewiesenen Beitrag einer Bewertung an.', 'site-reviews' ),
		]);

		$this->addSetting( $formId, [
			'type'  => 'yesno_inline',
			'name'  => 'avatars.enabled',
			'label' => __( 'Avatare aktivieren', 'site-reviews' ),
			'desc'  => sprintf( __( 'Rezensent-Avatare anzeigen. Diese werden aus der E-Mail-Adresse des Rezensenten mit %s generiert.', 'site-reviews' ),
				sprintf( '<a href="https://gravatar.com">%s</a>', __( 'Gravatar', 'site-reviews' ))
			),
		]);

		$this->addSetting( $formId, [
			'type'  => 'yesno_inline',
			'name'  => 'excerpt.enabled',
			'label' => __( 'Auszüge aktivieren', 'site-reviews' ),
			'desc'  => __( 'Einen Auszug statt der vollständigen Rezension anzeigen.', 'site-reviews' ),
		]);

		$this->addSetting( $formId, [
			'type'    => 'number',
			'name'    => 'excerpt.length',
			'label'   => __( 'Auszug Länge', 'site-reviews' ),
			'default' => '55',
			'desc'    => __( 'Stelle die Wortlänge des Auszugs ein.', 'site-reviews' ),
			'depends' => [
				'excerpt.enabled' => 'yes',
			],
		]);

		$this->html->addfield( $formId, [
			'type'  => 'heading',
			'value' => __( 'Rich Snippets (schema.org)', 'site-reviews' ),
			'desc'  => __( 'Bewertungs-Snippets erscheinen in den Ergebnissen der Google-Suche und enthalten die Sternebewertung und andere zusammenfassende Informationen aus Deinen Bewertungen.', 'site-reviews' ),
		]);

		$this->addSetting( $formId, [
			'type'  => 'select',
			'name'  => 'schema.type.default',
			'label' => __( 'Standardschematyp', 'site-reviews' ),
			'default' => 'LocalBusiness',
			'options' => [
				'LocalBusiness' => __( 'Lokales Geschäft', 'site-reviews' ),
				'Product' => __( 'Produkt', 'site-reviews' ),
				'custom' => __( 'Benutzerdefiniert', 'site-reviews' ),
			],
			'desc' => sprintf( __( 'Dies ist der Standardschematyp für das überprüfte Element. Du kannst diese Option pro Beitrag/Seite überschreiben, indem Du mit %s einen %s-Metadatenwert hinzufügst.', 'site-reviews' ),
				'<code>schema_type</code>',
				sprintf( '<a href="https://codex.wordpress.org/Using_Custom_Fields#Usage">%s</a>', __( 'Benutzerdefinierte Felder', 'site-reviews' ))
			),
		]);

		$this->addSetting( $formId, [
			'type'  => 'text',
			'name'  => 'schema.type.custom',
			'label' => __( 'Benutzerdefinierter Schematyp', 'site-reviews' ),
			'depends' => [
				'schema.type.default' => 'custom',
			],
			'desc' => sprintf(
				__( 'Google supports review ratings for the following schema content types: Regionale Unternehmen, Movies, Books, Music, and Products. %s', 'site-reviews' ),
				sprintf( '<a href="https://schema.org/docs/schemas.html">%s</a>', __( 'Weitere Informationen zu Schematypen findest Du hier.', 'site-reviews' ))
			),
		]);

		$this->addSetting( $formId, [
			'type'  => 'select',
			'name'  => 'schema.name.default',
			'label' => __( 'Standardname', 'site-reviews' ),
			'default' => 'post',
			'options' => [
				'post' => __( 'Verwende den zugewiesenen oder aktuellen Seitentitel', 'site-reviews' ),
				'custom' => __( 'Gib einen benutzerdefinierten Titel ein', 'site-reviews' ),
			],
			'desc' => sprintf( __( 'Dies ist der Standardname des überprüften Elements. Du kannst diese Option pro Beitrag/Seite überschreiben, indem Du mit %s einen %s-Metadatenwert hinzufügst.', 'site-reviews' ),
				'<code>schema_name</code>',
				sprintf( '<a href="https://codex.wordpress.org/Using_Custom_Fields#Usage">%s</a>', __( 'Benutzerdefinierte Felder', 'site-reviews' ))
			),
		]);

		$this->addSetting( $formId, [
			'type'  => 'text',
			'name'  => 'schema.name.custom',
			'label' => __( 'Benutzerdefinierter Name', 'site-reviews' ),
			'depends' => [
				'schema.name.default' => 'custom',
			],
		]);

		$this->addSetting( $formId, [
			'type'  => 'select',
			'name'  => 'schema.description.default',
			'label' => __( 'Standardbeschreibung', 'site-reviews' ),
			'default' => 'post',
			'options' => [
				'post' => __( 'Verwende den zugewiesenen oder aktuellen Seitenauszug', 'site-reviews' ),
				'custom' => __( 'Gib eine benutzerdefinierte Beschreibung ein', 'site-reviews' ),
			],
			'desc' => sprintf( __( 'Dies ist die Standardbeschreibung für den Artikel, der überprüft wird. Du kannst diese Option pro Beitrag/Seite überschreiben, indem Du mit %s einen %s-Metadatenwert hinzufügst.', 'site-reviews' ),
				'<code>schema_description</code>',
				sprintf( '<a href="https://codex.wordpress.org/Using_Custom_Fields#Usage">%s</a>', __( 'Benutzerdefinierte Felder', 'site-reviews' ))
			),
		]);

		$this->addSetting( $formId, [
			'type'  => 'text',
			'name'  => 'schema.description.custom',
			'label' => __( 'Benutzerdefinierte Beschreibung', 'site-reviews' ),
			'depends' => [
				'schema.description.default' => 'custom',
			],
		]);

		$this->addSetting( $formId, [
			'type'  => 'select',
			'name'  => 'schema.url.default',
			'label' => __( 'Standard-URL', 'site-reviews' ),
			'default' => 'post',
			'options' => [
				'post' => __( 'Verwende die zugewiesene oder aktuelle Seiten-URL', 'site-reviews' ),
				'custom' => __( 'Gib eine benutzerdefinierte URL ein', 'site-reviews' ),
			],
			'desc' => sprintf( __( 'Dies ist die Standard-URL für den überprüften Artikel. Du kannst diese Option pro Beitrag/Seite überschreiben, indem Du mit %s einen %s-Metadatenwert hinzufügst.', 'site-reviews' ),
				'<code>schema_url</code>',
				sprintf( '<a href="https://codex.wordpress.org/Using_Custom_Fields#Usage">%s</a>', __( 'Benutzerdefinierte Felder', 'site-reviews' ))
			),
		]);

		$this->addSetting( $formId, [
			'type'  => 'text',
			'name'  => 'schema.url.custom',
			'label' => __( 'Eigene URL', 'site-reviews' ),
			'depends' => [
				'schema.url.default' => 'custom',
			],
		]);

		$this->addSetting( $formId, [
			'type'  => 'select',
			'name'  => 'schema.image.default',
			'label' => __( 'Standardbild', 'site-reviews' ),
			'default' => 'post',
			'options' => [
				'post' => __( 'Verwende das vorgestellte Bild der zugewiesenen oder aktuellen Seite', 'site-reviews' ),
				'custom' => __( 'Gib eine benutzerdefinierte Bild-URL ein', 'site-reviews' ),
			],
			'desc' => sprintf( __( 'Dies ist das Standardbild für den überprüften Artikel. Du kannst diese Option pro Beitrag/Seite überschreiben, indem Du mit %s einen %s-Metadatenwert hinzufügst.', 'site-reviews' ),
				'<code>schema_image</code>',
				sprintf( '<a href="https://codex.wordpress.org/Using_Custom_Fields#Usage">%s</a>', __( 'Benutzerdefinierte Felder', 'site-reviews' ))
			),
		]);

		$this->addSetting( $formId, [
			'type'  => 'text',
			'name'  => 'schema.image.custom',
			'label' => __( 'Benutzerdefinierte Bild-URL', 'site-reviews' ),
			'depends' => [
				'schema.image.default' => 'custom',
			],
		]);
	}

	/**
	 * @return void
	 */
	protected function setReviewsForm()
	{
		$formId = 'settings/reviews-form';

		$this->html->createForm( $formId, [
			'action' => admin_url( 'options.php' ),
			'nonce'  => $this->app->id . '-settings',
			'submit' => __( 'Einstellungen speichern', 'site-reviews' ),
		]);

		$this->addSetting( $formId, [
			'type'    => 'checkbox',
			'name'    => 'required',
			'label'   => __( 'Benötigte Felder', 'site-reviews' ),
			'default' => ['title','content','name','email'],
			'options' => [
				'title' => __( 'Titel', 'site-reviews' ),
				'content' => __( 'Rezension', 'site-reviews' ),
				'name' => __( 'Name', 'site-reviews' ),
				'email' => __( 'Email', 'site-reviews' ),
			],
		]);

		$this->addSetting( $formId, [
			'type' => 'yesno_inline',
			'name' => 'akismet',
			'label' => __( 'Akismet-Integration aktivieren', 'site-reviews' ),
			'default' => 'no',
			'desc' => sprintf( __( 'die %s-Integration bietet Spam-Filter für Deine Bewertungen. Damit diese Einstellung wirksam wird, musst Du zuerst das Akismet-Plugin installieren und aktivieren und einen WordPress.com-API-Schlüssel einrichten.', 'site-reviews' ),
				sprintf( '<a href="https://akismet.com" target="_blank">%s</a>', __( 'Akismet plugin', 'site-reviews' ))
			),
		]);

		$this->addSetting( $formId, [
			'type'  => 'select',
			'name'  => 'recaptcha.integration',
			'label' => __( 'Unsichtbares reCAPTCHA', 'site-reviews' ),
			'options' => [
				'' => __( 'Verwende reCAPTCHA nicht', 'site-reviews' ),
				'custom' => __( 'Verwende reCAPTCHA', 'site-reviews' ),
				'invisible-recaptcha' => _x( 'Plugin eines Drittanbieters verwenden: Unsichtbares reCaptcha', 'plugin name', 'site-reviews' ),
			],
			'desc'  => sprintf( __( 'Invisible reCAPTCHA ist ein kostenloser Anti-Spam-Dienst von Google. Um es zu verwenden, benötigst Du %s für ein API-Schlüsselpaar für Deine Webseite. Falls Du bereits ein hier aufgeführtes reCAPTCHA-Plugin verwendest, wähle es bitte aus; ansonsten "reCAPTCHA verwenden" wählen.', 'site-reviews' ),
				sprintf( '<a href="https://www.google.com/recaptcha/admin" target="_blank">%s</a>', __( 'sign up', 'site-reviews' ))
			),
		]);

		$this->addSetting( $formId, [
			'type'  => 'text',
			'name'  => 'recaptcha.key',
			'label' => __( 'Webseiten-Schlüssel', 'site-reviews' ),
			'depends' => [
				'recaptcha.integration' => 'custom',
			],
		]);

		$this->addSetting( $formId, [
			'type'  => 'text',
			'name'  => 'recaptcha.secret',
			'label' => __( 'Webseiten-Secret', 'site-reviews' ),
			'depends' => [
				'recaptcha.integration' => 'custom',
			],
		]);

		$this->addSetting( $formId, [
			'type'  => 'select',
			'name'  => 'recaptcha.position',
			'label' => __( 'Badge Position', 'site-reviews' ),
			'options' => [
				'bottomleft' => 'Unten links',
				'bottomright' => 'Unten rechts',
				'inline' => 'Inline',
			],
			'depends' => [
				'recaptcha.integration' => 'custom',
			],
		]);

		$this->addSetting( $formId, [
			'type' => 'textarea',
			'name' => 'blacklist.entries',
			'label' => __( 'Rezension Blacklist', 'site-reviews' ),
			'desc' => __( 'Wenn eine Bewertung eines dieser Wörter in Titel, Inhalt, Name, E-Mail-Adresse oder IP-Adresse enthält, wird sie abgelehnt. Ein Wort oder eine IP-Adresse pro Zeile. Es wird innerhalb von Wörtern übereinstimmen, also wird "press" mit "WordPress" übereinstimmen..', 'site-reviews' ),
			'class' => 'large-text code',
			'rows' => 10,
		]);

		$this->addSetting( $formId, [
			'type' => 'select',
			'name' => 'blacklist.action',
			'label' => __( 'Blacklist-Aktion', 'site-reviews' ),
			'options' => [
				'unapprove' => __( 'Genehmigung erforderlich', 'site-reviews' ),
				'reject' => __( 'Einreichung ablehnen', 'site-reviews' ),
			],
			'desc' => __( 'Wähle die Aktion aus, die ausgeführt werden soll, wenn eine Bewertung auf die schwarze Liste gesetzt wird.', 'site-reviews' ),
		]);
	}

	/**
	 * @return void
	 */
	protected function setStrings()
	{
		$formId = 'settings/strings';

		$this->html->createForm( $formId, [
			'action' => admin_url( 'options.php' ),
			'class'  => 'glsr-strings-form',
			'nonce'  => $this->app->id . '-settings',
			'submit' => __( 'Einstellungen speichern', 'site-reviews' ),
		]);

		// This exists for when there are no custom translations
		$this->addSetting( $formId, [
			'type' => 'hidden',
			'name' => '',
		]);

		$this->html->addCustomField( $formId, function() {
			$translations = $this->app->make( 'Translator' )->renderAll();
			$class = empty( $translations )
				? 'glsr-hidden'
				: '';
			return $this->html->renderTemplate( 'strings/translations', [
				'class' => $class,
				'translations' => $translations,
			]);
		});
	}
}
