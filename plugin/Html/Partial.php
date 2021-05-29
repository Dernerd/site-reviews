<?php

/**
 * @package   Psource\SiteReviews
 * @copyright Copyright (c) 2021, DerN3rd
 * @license   GPLv3
 * @since     1.0.0
 * -------------------------------------------------------------------------------------------------
 */

namespace Psource\SiteReviews\Html;

use Psource\SiteReviews\App;
use ReflectionException;

class Partial
{
	/**
	 * @var App
	 */
	protected $app;

	/**
	 * @var array
	 */
	protected $args;

	public function __construct( App $app )
	{
		$this->app  = $app;
		$this->args = [];
	}

	/**
	 * @return $this
	 */
	public function normalize( $name, array $args = [] )
	{
		$this->args = wp_parse_args( $args, [
			'partial' => $name,
		]);
		return $this;
	}

	/**
	 * @return string
	 */
	public function render()
	{
		$className = sprintf( 'Psource\SiteReviews\Html\Partials\%s',
			$this->app->make( 'Helper' )->buildClassName( $this->args['partial'] )
		);
		$instance = $this->app->make( $className );
		$instance->args = $this->args;
		$rendered = $instance->render();
		return apply_filters( 'site-reviews/rendered/partial', $rendered, $this->args['partial'] );
	}
}
