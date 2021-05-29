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
use Psource\SiteReviews\Commands\RegisterShortcodes as Command;
use ReflectionException;

class RegisterShortcodes
{
	/**
	 * @return void
	 */
	public function handle( Command $command )
	{
		foreach( $command->shortcodes as $key ) {
			try {

				$shortcodeClass = glsr_resolve( 'Helper' )->buildClassName( $key, 'Psource\SiteReviews\Shortcodes' );

				add_shortcode( $key, [ glsr_resolve( $shortcodeClass ), 'printShortcode'] );
			}
			catch( Exception $e ) {
				glsr_resolve( 'Log\Logger' )->error( sprintf( 'Error registering shortcode. Message: %s "(%s:%s)"',
					$e->getMessage(),
					$e->getFile(),
					$e->getLine()
				));
			}
		}
	}
}
