<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Handlers;

use Exception;
use Psource\SiteReviews\Commands\RegisterWidgets as Command;

class RegisterWidgets
{
	/**
	 * @return void
	 */
	public function handle( Command $command )
	{
		global $wp_widget_factory;

		foreach( $command->widgets as $key => $values ) {

			$widgetClass = glsr_resolve( 'Helper' )->buildClassName( $key, 'Psource\SiteReviews\Widgets' );

			try {
				// bypass register_widget() in order to pass our custom values to the widget
				$widget = new $widgetClass( sprintf( '%s_%s', glsr_app()->id, $key ), $values['title'], $values );
				$wp_widget_factory->widgets[ $widgetClass ] = $widget;
			}
			catch( Exception $e ) {
				glsr_resolve( 'Log\Logger' )->error( sprintf( 'Error registering widget. Message: %s "(%s:%s)"',
					$e->getMessage(),
					$e->getFile(),
					$e->getLine()
				));
			}
		}
	}
}
